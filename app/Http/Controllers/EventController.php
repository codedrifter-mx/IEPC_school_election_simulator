<?php

namespace App\Http\Controllers;

use App\Models\Candidate;
use App\Models\Elector;
use App\Models\Event;
use App\Models\Vote;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Intervention\Image\Facades\Image;
use NumberFormatter;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Redirect;
use Response;
use Str;
use setasign\Fpdi\Fpdi;
use STS\ZipStream\ZipStreamFacade as ZipStream;
use ZipArchive;

class EventController extends Controller
{
    public function index(Request $request)
    {
        $user_id = $request->user_id;

        $events = Event::where('user_id', $user_id)->get();

        // Add a numeric status column, if the event is between start_at and end_at, is 1, if the event is before start_at, is 0, if the event is after end_at, is 2
        $events->map(function ($event) {
            $now = now('America/Mexico_City');

            $now = $now->toDateTimeString();
            $event->start_at = $event->start_at->toDateTimeString();
            $event->end_at = $event->end_at->toDateTimeString();

            if ($now < $event->end_at && $now > $event->start_at) {
                $event->status = 1;
            } elseif ($now < $event->start_at) {
                $event->status = 0;
            } else {
                $event->status = 2;
            }

            return $event;
        });


        // if request has ongoing = true, filter events other than status 2
        if ($request->ongoing == 'true') {
            $events = $events->filter(function ($event) {
                return $event->status != 2;
            });
// remove parent json "1" and "0" keys
            $events = $events->values();
        }




        return response()->json($events, 200);
    }

    public function indexCount(Request $request)
    {
        $events = Event::where('approved', 0)->get();

        $count = $events->count();

        return response()->json($count, 200);
    }

    public function store(Request $request)
    {
        // rules for event
        $rules = [
            'name' => 'required|string',
            'cycle' => 'required|string',
            'population' => 'required|integer',
            'groups' => 'required|integer',
            'schedule' => 'required|string',
            'director' => 'required|string',
            'responsible' => 'required|string',
            'responsible_phone' => 'required|string',
            'start_at' => 'required|date',
            'end_at' => 'required|date'
        ];

        // messages, but in spanish
        $msgs = [
            'name.required' => 'El nombre del evento es requerido',
            'name.string' => 'El nombre del evento debe ser una cadena de texto',
            'cycle.required' => 'El ciclo escolar es requerido',
            'cycle.string' => 'El ciclo escolar debe ser una cadena de texto',
            'population.required' => 'La población es requerida',
            'population.integer' => 'La población debe ser un número entero',
            'groups.required' => 'El número de grupos es requerido',
            'groups.integer' => 'El número de grupos debe ser un número entero',
            'schedule.required' => 'El horario es requerido',
            'schedule.string' => 'El horario debe ser una cadena de texto',
            'director.required' => 'El nombre del director es requerido',
            'director.string' => 'El nombre del director debe ser una cadena de texto',
            'responsible.required' => 'El nombre del responsable es requerido',
            'responsible.string' => 'El nombre del responsable debe ser una cadena de texto',
            'responsible_phone.required' => 'El teléfono del responsable es requerido',
            'responsible_phone.string' => 'El teléfono del responsable debe ser una cadena de texto',
            'start_at.required' => 'La fecha de inicio es requerida',
            'start_at.date' => 'La fecha de inicio debe ser una fecha',
            'end_at.required' => 'La fecha de fin es requerida',
            'end_at.date' => 'La fecha de fin debe ser una fecha'
        ];

        $request->validate($rules, $msgs);

        $request->request->add(['event_key' => Str::random(8)]);

        // if request has photo file, save it
        if ($request->hasFile('photo')) {
            // transform $request->file('photo') into .jpg file with vertical 4:3 ratio and lowest file size
            $image = Image::make($request->file('photo'))->fit(300, 400)->encode('jpg', 75);

            // save the image in 'public/candidates', $candidate->candidate_key . '.jpg'
            Storage::disk('s3')->put('events/' . $request->event_key . '.jpg', $image);
        } else {
            return response()->json(['errors' => ['photo' => ['El logotipo es requerido']]], 422);
        }

        $event = Event::create($request->all());


        return response()->json($event, 200);
    }

    public function show(Request $request)
    {
        $event_key = $request->event_key;

        $event = Event::firstWhere('event_key', $event_key);

        if (!$event) {
            return response()->json(['message' => 'Evento no encontrado'], 404);
        }

        // now variable with America/Mexico_City timezone
        $now = now('America/Mexico_City');

        // do IF(events.start_at <= CONVERT_TZ(NOW(),"SYSTEM","America/Mexico_City") AND events.end_at >= CONVERT_TZ(NOW(),"SYSTEM","America/Mexico_City"), 1, IF(events.start_at > CONVERT_TZ(NOW(),"SYSTEM","America/Mexico_City"), 0, IF(events.end_at < CONVERT_TZ(NOW(),"SYSTEM","America/Mexico_City"), 2, 3))) as status but in php and converting to strtotime
        if (strtotime($now) > strtotime($event->start_at) and strtotime($now) < strtotime($event->end_at)) {
            $event->status = 1;
        } elseif (strtotime($now) < strtotime($event->start_at)) {
            $event->status = 0;
        } elseif (strtotime($now) > strtotime($event->end_at)) {
            $event->status = 2;
        } else {
            $event->status = 3;
        }

        if ($event->approved == 0) {
            $event->status = 3;
        }

        // if tha candidates with this event_key are odd or less than 2, status is 4
        $candidates = Candidate::where('event_id', $event->event_id)->get();

        if ((count($candidates) - 1) < 2) {
            $event->status = 4;
        }

        // get total electors count with event_key, if null, is 0
        $event->total_electors = Elector::where('event_key', $event->event_key)->count();

        // get event total votes with table vote
        $event->total_votes = Vote::where('event_id', $event->event_id)->count();


        // if event end_at is empty, send a 400 with a message
        if ($event->status == 3) {
            return response()->json([
                'data' => $event,
                'message' => 'El evento aun no ha sido validado por el IEPC'
            ], 201);
        } else {
            return response()->json([
                'data' => $event,
                'message' => 'Evento validado'
            ], 200);
        }
    }

    public function showToValidate(Request $request)
    {
        // get all event with approved = 0
        $events = Event::where('approved', 0)->get();


        return response()->json([
            'data' => $events,
            'message' => 'Evento validado'
        ], 200);

    }

    public function update(Request $request)
    {
        // if request has approved, validate it
        if ($request->has('approved')) {
            //
            $event_key = $request->event_key;

            $event = Event::firstWhere('event_key', $event_key);

            if (!$event) {
                return response()->json(['message' => 'Evento no encontrado'], 404);
            }

            // just update end_at and approved
            $event->update([
                'start_at' => $request->start_at,
                'end_at' => $request->end_at,
                'approved' => $request->approved
            ]);

            return response()->json([
                'data' => $event,
                'message' => 'Evento validado'
            ], 200);
        }


        $rules = [
            'name' => 'required|string',
            'schedule' => 'required|string',
            'director' => 'required|string',
            'responsible' => 'required|string',
            'population' => 'required|integer',
            'groups' => 'required|integer',
            'start_at' => 'required|date'
        ];

        $msgs = [
            'name.required' => 'El nombre es requerido',
            'name.string' => 'El nombre debe ser un string',
            'schedule.required' => 'El horario es requerido',
            'schedule.string' => 'El horario debe ser un string',
            'director.required' => 'El director es requerido',
            'director.string' => 'El director debe ser un string',
            'responsible.required' => 'El encargado es requerido',
            'responsible.string' => 'El encargado debe ser un string',
            'population.required' => 'La población es requerida',
            'population.integer' => 'La población debe ser un entero',
            'groups.required' => 'El número de grupos es requerido',
            'groups.integer' => 'El número de grupos debe ser un entero',
            'start_at.required' => 'La fecha de inicio es requerida',
            'start_at.date' => 'La fecha de inicio debe ser una fecha'
        ];

        $request->validate($rules, $msgs);

        $event_key = $request->event_key;

        $event = Event::firstWhere('event_key', $event_key);

        if (!$event) {
            return response()->json(['message' => 'Evento no encontrado'], 404);
        }

        $event->update($request->all());

        return response()->json($event);
    }

    public function destroy(Request $request)
    {
        $event_key = $request->event_key;
        $event = Event::firstWhere('event_key', $event_key);

        if (!$event) {
            return response()->json(['message' => 'Evento no encontrado'], 500);
        }

        $event->delete();

        return response()->json(['message' => 'Evento borrado']);
    }

    // stop function to modify end_at to now
    public function stop(Request $request)
    {
        $event_key = $request->event_key;
        $event = Event::firstWhere('event_key', $event_key);

        if (!$event) {
            return response()->json(['message' => 'Evento no encontrado'], 500);
        }

        $event->end_at = now('America/Mexico_City');
        $event->save();

        // return 200 json
        return response()->json(['message' => 'Evento detenido'], 200);
    }

    public function getDetails(Request $request)
    {
        $event_key = $request->event_key;

        $event = Event::firstWhere('event_key', $event_key);

        if (!$event) {
            return response()->json(['message' => 'Evento no encontrado'], 500);
        }

        // Query with * event, join with user
        $event = Event::select('events.*', 'users.name as user_name', 'users.email as user_email')
            ->join('users', 'events.user_id', '=', 'users.user_id')
            ->where('events.event_key', $event_key)
            ->first();

        // Query with candidates, join with votes, by event_key, count votes
        $candidates = Candidate::select('candidates.name', DB::raw('count(votes.vote_id) as votes'))
            ->join('votes', 'candidates.candidate_id', '=', 'votes.candidate_id', 'left')
            ->where('candidates.event_id', $event->event_id)
            ->groupBy('candidates.name')
            ->orderBy('votes', 'desc')
            ->get();

        $total_electors = Elector::where('event_key', $event->event_key)->count();

        // Query with electors, join with votes, by event_key and elector_id, count votes
        $electors = Elector::select('electors.name', DB::raw('count(votes.vote_id) as votes'))
            ->join('votes', 'electors.elector_id', '=', 'votes.elector_id', 'left')
            ->where('electors.event_key', $event->event_key)
            ->groupBy('electors.name')
            ->orderBy('votes', 'desc')
            ->get();

        $votes = Vote::where('event_id', $event->event_id)->count();


        $data = [
            'name' => $event->name,
            'schedule' => $event->schedule,
            'cycle' => $event->cycle,
            'population' => $event->population,
            'total_votes' => $votes,
            'total_electors' => $total_electors,
            'total_electors_votes' => $electors->sum('votes'),
            'candidates' => $candidates->pluck('votes', 'name'),
            'no_votes' => $event->population - $votes
        ];

        // return data
        return response()->json($data);
    }

    public function getResults(Request $request)
    {
        $event_key = $request->event_key;

        $event = Event::firstWhere('event_key', $event_key);

        if (!$event) {
            return response()->json(['message' => 'Evento no encontrado'], 500);
        }

        // Query with * event, join with user
        $event = Event::select('events.*', 'users.name as user_name', 'users.email as user_email')
            ->join('users', 'events.user_id', '=', 'users.user_id')
            ->where('events.event_key', $event_key)
            ->first();

        // Query with candidates, join with votes, by event_key, count votes
        $candidates = Candidate::select('candidates.name', DB::raw('count(votes.vote_id) as votes'))
            ->join('votes', 'candidates.candidate_id', '=', 'votes.candidate_id', 'left')
            ->where('candidates.event_id', $event->event_id)
            ->groupBy('candidates.name')
            ->orderBy('votes', 'desc')
            ->get();

        $votes = Vote::where('event_id', $event->event_id)->count();

        $data = [
            'name' => $event->name,
            'schedule' => $event->schedule,
            'cycle' => $event->cycle,
            'population' => $event->population,
            'groups' => $event->groups,
            'total_votes' => $votes,
            // json $candidates->pluck('name') as key and $candidates->pluck('votes') as value
            'candidates' => $candidates->pluck('votes', 'name'),
            'no_votes' => $event->population - $votes,
            'start_at' => $event->start_at,
            'end_at' => $event->end_at
        ];

        // return data
        return response()->json($data);
    }

    public function getResultsPdf(Request $request)
    {
        $event_key = $request->event_key;

        $event = Event::firstWhere('event_key', $event_key);

        if (!$event) {
            return response()->json(['message' => 'Evento no encontrado'], 500);
        }

        // Query with * event, join with user
        $event = Event::select('events.*', 'users.name as user_name', 'users.email as user_email')
            ->join('users', 'events.user_id', '=', 'users.user_id')
            ->where('events.event_key', $event_key)
            ->first();

        // Query with candidates, join with votes, by event_key, count votes
        $candidates = Candidate::select('candidates.name', 'candidates.candidate_key', DB::raw('count(votes.vote_id) as votes'))
            ->join('votes', 'candidates.candidate_id', '=', 'votes.candidate_id', 'left')
            ->where('candidates.event_id', $event->event_id)
            ->groupBy('candidates.name', 'candidates.candidate_key')
            ->orderBy('votes', 'desc')
            ->get();

        $votes = Vote::where('event_id', $event->event_id)->count();

        $data = [
            'name' => $event->name,
            'schedule' => $event->schedule,
            'cycle' => $event->cycle,
            'population' => $event->population,
            'director' => $event->director,
            'total_votes' => $votes,
            'candidates' => $candidates->pluck('votes', 'name'),
            'candidates_key' => $candidates->pluck('candidate_key', 'name'),
            'no_votes' => $event->population - $votes
        ];


        // count $data['candidates'] without nulo key
        $count = count($data['candidates']) - 1;

        // if there is no candidates, return error
        if ($count <= 0) {
            return response()->json(['message' => 'No hay candidatos'], 400);
        }

        $fpdi = new Fpdi;

        $pageCount = $fpdi->setSourceFile(public_path('pdf/default/2_cartel_resultados/' . $count . '.pdf'));

        for ($i = 1; $i <= $pageCount; $i++) {
            $template = $fpdi->importPage($i);
            $size = $fpdi->getTemplateSize($template);
            $fpdi->AddPage($size['orientation'], array($size['width'], $size['height']));
            $fpdi->useTemplate($template);

            $fpdi->AddFont('Century Gothic', '', 'Century_Gothic.php');
            $fpdi->SetFont("Century Gothic", "", 14);

            if (Storage::disk('s3')->exists('events/' . $request->event_key . '.jpg')) {
                $left = 11;
                $top = 20.3;
                $url = Storage::disk('s3')->url('events/' . $request->event_key . '.jpg');
                $fpdi->Image($url, $left, $top, 23.3, 23.3);
            }


            $text = $data['total_votes'];
            $left = 52;
            $left = $left - $fpdi->GetStringWidth($text) / 2;
            $top = 128;

            $fpdi->Text($left, $top, $text);


            $top = 146.3;
            foreach ($data['candidates'] as $key => $value) {
                if ($key == 'nulo') continue;

                $top += 15;

                $url = Storage::disk('s3')->url('default.png');


                try {
                    if (Storage::disk('s3')->exists('candidates/' . $data['candidates_key'][$key] . '.jpg')) {
                        $url = Storage::disk('s3')->url('candidates/' . $data['candidates_key'][$key] . '.jpg');
                        $top -= 6.5;
                        $left = 6.2;
                        $fpdi->Image($url, $left, $top, 9.5, 9.5);
                        $top += 6.5;
                    } else {
                        $url = Storage::disk('s3')->url('default.png');
                        $top -= 6.5;
                        $left = 6.5;
                        $fpdi->Image($url, $left, $top, 9.5, 9.5);
                        $top += 6.5;
                    }
                } catch (\Exception $e) {
                    $top += 7;
                }


                $left = 24;
                $text = $key;
                $fpdi->Text($left, $top, $text);

                $left = 117;
                $text = $value;
                $fpdi->Text($left, $top, $text);

                // now $value number transform to text number in spanish
                $left = 165;
                $text = $this->numberToText($value);
                $fpdi->Text($left, $top, $text);
            }

            $top += 15.5;
            $left = 117;
            $text = 0;
            $fpdi->Text($left, $top, $text);

            $left = 165;
            $text = $this->numberToText($text);
            $fpdi->Text($left, $top, $text);

            $left = 117;
            $top += 15.5;
            $text = $data['candidates']->sum() - $data['candidates']['nulo'];
            $fpdi->Text($left, $top, $text);

            $left = 117;
            $top += 15;
            // sum value of $data['candidates'] with key nulo
            $text = $data['candidates']['nulo'];
            $fpdi->Text($left, $top, $text);

            $left = 117;
            $top += 15;
            $text = $data['no_votes'];
            $fpdi->Text($left, $top, $text);

            $text = $data['director'];
            $left = 47;
            $left = $left - $fpdi->GetStringWidth($text) / 2;
            $top += 42.5;

            $fpdi->Text($left, $top, $text);

        }

        $file = $fpdi->Output('S', $event->event_key . '.pdf');
        Storage::disk('s3')->put('/pdf/ficha/' . $event->event_key . '.pdf', $file);
        $url = Storage::disk('s3')->url('/pdf/ficha/' . $event->event_key . '.pdf');

        return response()->json(['url' => $url]);
    }

    public function getResultsXlsx(Request $request)
    {
        $event_key = $request->event_key;

        $event = Event::firstWhere('event_key', $event_key);

        if (!$event) {
            return response()->json(['message' => 'Evento no encontrado'], 500);
        }

        $event = Event::select('events.*', 'users.name as user_name', 'users.email as user_email')
            ->join('users', 'events.user_id', '=', 'users.user_id')
            ->where('events.event_key', $event_key)
            ->first();

        $candidates = Candidate::select('candidates.name', DB::raw('count(votes.vote_id) as votes'))
            ->join('votes', 'candidates.candidate_id', '=', 'votes.candidate_id', 'left')
            ->where('candidates.event_id', $event->event_id)
            ->groupBy('candidates.name')
            ->orderBy('votes', 'desc')
            ->get();

        $votes = Vote::where('event_id', $event->event_id)->count();


        $data = [
            'school_name' => $event->user_name,
            'direction' => $event->schedule,
            'event_name' => $event->name,
            'cycle' => $event->cycle,
            'total_alumni' => $event->population,
            'total_groups' => $event->groups,
            'schedule' => $event->schedule,
            'start_at' => $event->start_at,
            'end_at' => $event->end_at,
            'total_votes' => $votes,
            'candidates' => $candidates->pluck('votes', 'name'),
            'winner' => $candidates->first()->name,
            'no_votes' => $event->population - $votes
        ];


        // create a Xlsx file with data
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // set larger column widths
        $sheet->getColumnDimension('A')->setWidth(80);
        $sheet->getColumnDimension('B')->setWidth(30);

        $sheet->setCellValue('A1', 'Nombre de la escuela');
        $sheet->setCellValue('B1', $data['school_name']);
        $sheet->setCellValue('A2', 'Direccion');
        $sheet->setCellValue('B2', $data['direction']);
        $sheet->setCellValue('A3', 'Nombre del evento');
        $sheet->setCellValue('B3', $data['event_name']);
        $sheet->setCellValue('A4', 'Ciclo Escolar');
        $sheet->setCellValue('B4', $data['cycle']);
        $sheet->setCellValue('A5', 'Total de alumnos');
        $sheet->setCellValue('B5', $data['total_alumni']);
        $sheet->setCellValue('A6', 'Numero de grupos');
        $sheet->setCellValue('B6', $data['total_groups']);
        $sheet->setCellValue('A7', 'Turno');
        $sheet->setCellValue('B7', $data['schedule']);
        $sheet->setCellValue('A8', 'Inicio de votacion');
        $sheet->setCellValue('B8', $data['start_at']);
        $sheet->setCellValue('A9', 'Fin de votacion');
        $sheet->setCellValue('B9', $data['end_at']);

        $sheet->setCellValue('A10', 'Número de estudiantes inscritos en el “registro de votantes”');
        $sheet->setCellValue('B10', $data['total_alumni']);
        $sheet->setCellValue('A11', 'Número de personas que votaron');
        $sheet->setCellValue('B11', $data['total_votes']);
        $sheet->setCellValue('A12', 'Número de personas que no votaron');
        $sheet->setCellValue('B12', $data['no_votes']);

        $sheet->setCellValue('A13', 'Nombre de la planilla ganadora');
        $sheet->setCellValue('B13', $data['winner']);

        $sheet->setCellValue('A15', 'Desglose de votos por planilla');

        $i = 16;

        foreach ($data['candidates'] as $key => $value) {
            if ($key != 'nulo') {
                $sheet->setCellValue('A' . $i, $key);
                $sheet->setCellValue('B' . $i, $value);
                $i++;
            }
        }

        $writer = new Xlsx($spreadsheet);
        $writer->save('datos.xlsx');

        $file = public_path() . '/datos.xlsx';

        $headers = array(
            'Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
        );

        return response()->download($file, 'datos.xlsx', $headers);
    }
    public function getElectorsXlsx(Request $request)
    {
        $event_key = $request->event_key;

        $event = Event::firstWhere('event_key', $event_key);

        if (!$event) {
            return response()->json(['message' => 'Evento no encontrado'], 500);
        }

        $event = Event::select('events.*', 'users.name as user_name', 'users.email as user_email')
            ->join('users', 'events.user_id', '=', 'users.user_id')
            ->where('events.event_key', $event_key)
            ->first();

        $electors = Elector::select('electors.*')
            ->where('electors.event_key', $event_key)
            ->orderBy('electors.name', 'asc')
            ->get();



        // create a Xlsx file with data
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // set larger column widths
        $sheet->getColumnDimension('A')->setWidth(80);
        $sheet->getColumnDimension('B')->setWidth(30);

        $sheet->setCellValue('A1', 'Nombre completo');
        $sheet->setCellValue('B1', 'Codigo de voto');

        $i = 2;

        foreach ($electors as $elector) {
            $sheet->setCellValue('A' . $i, $elector->name . ' ' . $elector->paternal_surname . ' ' . $elector->maternal_surname);
            $sheet->setCellValue('B' . $i, $elector->code);
            $i++;
        }

        $writer = new Xlsx($spreadsheet);
        $writer->save('votantes.xlsx');

        $file = public_path() . '/votantes.xlsx';

        $headers = array(
            'Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
        );

        return response()->download($file, 'votantes.xlsx', $headers);
    }

    public function getAct(Request $request)
    {
        $event_key = $request->event_key;

        $event = Event::firstWhere('event_key', $event_key);

        if (!$event) {
            return response()->json(['message' => 'Evento no encontrado'], 500);
        }

        // Query with * event, join with user
        $event = Event::select('events.*', 'users.name as user_name', 'users.*')
            ->join('users', 'events.user_id', '=', 'users.user_id')
            ->where('events.event_key', $event_key)
            ->first();

        // Query with candidates, join with votes, by event_key, count votes
        $candidates = Candidate::select('candidates.name', 'candidates.teamname', 'candidates.candidate_key', DB::raw('count(votes.vote_id) as votes'))
            ->join('votes', 'candidates.candidate_id', '=', 'votes.candidate_id', 'left')
            ->where('candidates.event_id', $event->event_id)
            ->groupBy('candidates.name', 'candidates.candidate_key')
            ->orderBy('votes', 'desc')
            ->get();

        // if there is no candidates, return error
        if ($candidates->count() == 0) {
            return response()->json(['message' => 'No hay candidatos'], 500);
        }
        $votes = Vote::where('event_id', $event->event_id)->count();


        $data = [
            'municipio' => $event->municipality,
            'escuela' => $event->name,
            'hora' => date('H:i:s', strtotime($event->end_at)),
            'dia' => date('d', strtotime($event->end_at)),
//            'mes' => date('F', strtotime($event->end_at)), in spanish
            'mes' => date('F', strtotime($event->end_at)),
            'anio' => date('Y', strtotime($event->end_at)),
            'domicilio' => $event->address,
            'start_at' => $event->start_at,
            'end_at' => $event->end_at,
            'population' => $event->population,
            'director' => $event->director,
            'locality' => $event->locality,
            'total_votes' => $votes,
            'candidates' => $candidates->pluck('votes', 'name'),
            'candidates_key' => $candidates->pluck('candidate_key', 'name'),
            'winner' => $candidates->first()->teamname,
            'no_votes' => $event->population - $votes
        ];

        //log data
//        \Log::info($data);

        // count $data['candidates'] without nulo key
        $count = count($data['candidates']) - 1;

        $fpdi = new Fpdi;

        $pageCount = $fpdi->setSourceFile(public_path('pdf/default/3_acta/' . $count . '.pdf'));

        for ($i = 1; $i <= $pageCount; $i++) {
            $template = $fpdi->importPage($i);
            $size = $fpdi->getTemplateSize($template);
            $fpdi->AddPage($size['orientation'], array($size['width'], $size['height']));
            $fpdi->useTemplate($template);
            $fpdi->AddFont('Century Gothic', '', 'Century_Gothic.php');
            $fpdi->SetFont("Century Gothic", "", 14);

            // if 'events/' . $request->event_key . '.jpg' exists, add image
            if (Storage::disk('s3')->exists('events/' . $request->event_key . '.jpg')) {
                $left = 10.5;
                $top = 20.5;
                $url = Storage::disk('s3')->url('events/' . $request->event_key . '.jpg');
                $fpdi->Image($url, $left, $top, 23.5, 23.5);
            }


            $left = 59;
            $top = 71;
            $text = $data['municipio'];
            $fpdi->Text($left, $top, $text);

            $left = 128;
            $top = 71;
            $text = $data['locality'];
            $fpdi->Text($left, $top, $text);

            $left = 40;
            $top = 76;
            $text = $data['escuela'];
            $fpdi->Text($left, $top, $text);

            $left = 165;
            $top = 76;
            $text = $data['hora'];
            $fpdi->Text($left, $top, $text);

            $left = 40;
            $top = 80.5;
            $text = $data['dia'];
            $fpdi->Text($left, $top, $text);

            $left = 80;
            $top = 80.5;
            // translate $data['mes'] to spanish
            $mes = $data['mes'];
            switch ($mes) {
                case 'January':
                    $mes = 'Enero';
                    break;
                case 'February':
                    $mes = 'Febrero';
                    break;
                case 'March':
                    $mes = 'Marzo';
                    break;
                case 'April':
                    $mes = 'Abril';
                    break;
                case 'May':
                    $mes = 'Mayo';
                    break;
                case 'June':
                    $mes = 'Junio';
                    break;
                case 'July':
                    $mes = 'Julio';
                    break;
                case 'August':
                    $mes = 'Agosto';
                    break;
                case 'September':
                    $mes = 'Septiembre';
                    break;
                case 'October':
                    $mes = 'Octubre';
                    break;
                case 'November':
                    $mes = 'Noviembre';
                    break;
                case 'December':
                    $mes = 'Diciembre';
                    break;
            }
            $text = $mes;
            $fpdi->Text($left, $top, $text);

            $left = 46;
            $top = 85.5;
            $text = $data['domicilio'];
            $fpdi->Text($left, $top, $text);



            $left = 124;
            $top = 80.5;
            $text = $data['anio'];
            $fpdi->Text($left, $top, $text);


            $left = 15;
            $top = 112.5;
            $text = utf8_decode('El Comité Estudiantil');
            $fpdi->Text($left, $top, $text);

            $left = 72;
            $top = 134;
            $text = $data['start_at']->format('H:i:s');
            $fpdi->Text($left, $top, $text);

            $left = 163;
            $top = 134;
            $text = $data['end_at']->format('H:i:s');
            $fpdi->Text($left, $top, $text);


            $top = 165;
            foreach ($data['candidates'] as $key => $value) {
                if ($key == 'nulo') continue;


                $left = 8;
                $top += 10.5;
                $text = $key;
                $fpdi->Text($left, $top, $text);

                try {
                    if (Storage::disk('s3')->url('candidates/' . $data['candidates_key'][$key] . '.jpg')) {
                        $url = Storage::disk('s3')->url('candidates/' . $data['candidates_key'][$key] . '.jpg');
                        $top -= 7;
                        $left = 64;
                        $fpdi->Image($url, $left, $top, 6.5, 6.6);
                        $top += 7;
                    }
                } catch (\Exception $e) {
                    $top += 6;
                }


                $left = 76;
                $text = $value;
                $fpdi->Text($left, $top, $text);

                $left = 143;
                $text = $this->numberToText($value);
                $fpdi->Text($left, $top, $text);
            }

            $top += 10.5;
            $left = 76;
            $text = '0';
            $fpdi->Text($left, $top, $text);

            $left = 143;
            $text = 'cero';
            $fpdi->Text($left, $top, $text);

            $left = 77;
            $top += 10;
            // sum value of $data['candidates'] without key nulo
            $text = $data['candidates']->sum() - $data['candidates']['nulo'];
            $fpdi->Text($left, $top, $text);

            $left = 77;
            $top += 11;
            // sum value of $data['candidates'] with key nulo
            $text = $data['candidates']['nulo'];
            $fpdi->Text($left, $top, $text);

            $left = 77;
            $top += 11;
            $text = $data['no_votes'];
            $fpdi->Text($left, $top, $text);

            $left = 49.5;
            $top += 17.8;
            $text = $data['winner'];
            $fpdi->Text($left, $top, $text);

            $left = 106;
            $top += 38;
            $text = $data['director'];
            $fpdi->Text($left - $fpdi->GetStringWidth($text) / 2 , $top, $text);

        }

        $file = $fpdi->Output('S', $event->event_key . '.pdf');
        Storage::disk('s3')->put('/pdf/ficha/' . $event->event_key . '.pdf', $file);
        $url = Storage::disk('s3')->url('/pdf/ficha/' . $event->event_key . '.pdf');

        return response()->json(['url' => $url]);
    }

    public function getMajority(Request $request)
    {
        $event_key = $request->event_key;

        $event = Event::firstWhere('event_key', $event_key);

        if (!$event) {
            return response()->json(['message' => 'Evento no encontrado'], 500);
        }

        $event = Event::select('events.*', 'users.name as user_name', 'users.email as user_email')
            ->join('users', 'events.user_id', '=', 'users.user_id')
            ->where('events.event_key', $event_key)
            ->first();

        $candidates = Candidate::select('candidates.teamname', DB::raw('count(votes.vote_id) as votes'))
            ->join('votes', 'candidates.candidate_id', '=', 'votes.candidate_id', 'left')
            ->where('candidates.event_id', $event->event_id)
            ->groupBy('candidates.teamname')
            ->orderBy('votes', 'desc')
            ->get();

        // if there is no candidates, return error
        if ($candidates->count() == 0) {
            return response()->json(['message' => 'No hay candidatos'], 500);
        }

        $data = [
            'name' => $event->name,
            'candidates' => $candidates->pluck('votes', 'teamname'),
            'end_at' => $event->end_at,
            'director' => $event->director,
            'cycle' => $event->cycle,
        ];

        // exclude $data['candidates'] key 'nulo'
        $data['candidates']->forget('nulo');

        $data['candidates'] = $data['candidates']->sortDesc();


        $top_candidate = $data['candidates']->first();
        $top_candidates = $data['candidates']->filter(function ($value, $key) use ($top_candidate) {
            return $value == $top_candidate;
        });

        $top_candidates_array = [];
        foreach ($top_candidates as $key => $value) {
            $fpdi = new Fpdi;


            $pageCount = $fpdi->setSourceFile(public_path('pdf/default/4_constancia.pdf'));


            for ($i = 1; $i <= $pageCount; $i++) {
                $template = $fpdi->importPage($i);
                $size = $fpdi->getTemplateSize($template);
                $fpdi->AddPage($size['orientation'], array($size['width'], $size['height']));
                $fpdi->useTemplate($template);

                $fpdi->AddFont('Century Gothic', '', 'Century_Gothic.php');
                $fpdi->SetFont("Century Gothic", "", 26);

                // if 'events/' . $request->event_key . '.jpg' exists, add image
                if (Storage::disk('s3')->exists('events/' . $request->event_key . '.jpg')) {
                    $left = 11;
                    $top = 7;
                    $url = Storage::disk('s3')->url('events/' . $request->event_key . '.jpg');
                    $fpdi->Image($url, $left, $top, 30, 30);
                }


                $left = 135;
                $text = $key;
                $left = $left - $fpdi->GetStringWidth($text) / 2;
                $top = 146;
                $fpdi->Text($left, $top, $text);


                $fpdi->SetFont("Century Gothic", "", 20);

                $left = 165;
                $top = 75;
                $text = $data['cycle'];
                $fpdi->Text($left, $top, $text);

                $fpdi->SetFont("Century Gothic", "", 18);


                $left = 132;
                $top = 181;
                $text = $data['director'];
                $fpdi->Text($left - $fpdi->GetStringWidth($text) / 2 , $top, $text);
            }

            $file = $fpdi->Output('S', $event->event_key . '.pdf');
            Storage::disk('s3')->put('/pdf/majority/' . $event->event_key . '/' . $key . '.pdf', $file);
            $url = Storage::disk('s3')->url('/pdf/majority/' . $event->event_key . '/' . $key . '.pdf');

            $top_candidates_array[$key] = $url;
        }

        // if ($top_candidates->count() == 1) then just download the pdf, otherwise download a zip file with all pdf url with response()->download
        if ($top_candidates->count() == 1) {
            return response()->json(['url' => $top_candidates_array[$top_candidates->keys()->first()]]);
        } else {

            // zip each file from $top_candidates_array and return the zip file
            $zip = new ZipArchive;
            $zip_name = $event->event_key . '.zip';
            $zip->open($zip_name, ZipArchive::CREATE);
            foreach ($top_candidates_array as $key => $value) {
                $zip->addFromString($key . '.pdf', file_get_contents($value));
            }
            $zip->close();

            // make $zip compatible to upload to s3
            $zip = file_get_contents($zip_name);

            Storage::disk('s3')->put('/pdf/majority/' . $event->event_key . '/' . $event->event_key . '.zip', $zip);
            $url = Storage::disk('s3')->url('/pdf/majority/' . $event->event_key . '/' . $event->event_key . '.zip');

            return response()->json(['url' => $url]);
        }
    }

    private function numberToText(mixed $value)
    {
        $number = new NumberFormatter("es", NumberFormatter::SPELLOUT);
        return $number->format($value);
    }

}
