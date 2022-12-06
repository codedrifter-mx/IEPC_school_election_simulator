<?php

namespace App\Http\Controllers;

use App\Models\Candidate;
use App\Models\Event;
use App\Models\Vote;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Redirect;
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
            $now = now();
            if ($now->between($event->start_at, $event->end_at)) {
                $event->status = 1;
            } elseif ($now->lt($event->start_at)) {
                $event->status = 0;
            } else {
                $event->status = 2;
            }
            return $event;
        });

        return response()->json($events, 200);
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

        if ((count($candidates) - 1) % 2 != 0 || (count($candidates) - 1) < 2) {
            $event->status = 4;
        }

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

        $data = [
            'name' => $event->name,
            'schedule' => $event->schedule,
            'cycle' => $event->cycle,
            'population' => $event->population,
            'total_votes' => $candidates->sum('votes'),
            // json $candidates->pluck('name') as key and $candidates->pluck('votes') as value
            'candidates' => $candidates->pluck('votes', 'name'),
            'no_votes' => $event->population - $candidates->sum('votes')
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

        $data = [
            'name' => $event->name,
            'schedule' => $event->schedule,
            'cycle' => $event->cycle,
            'population' => $event->population,
            'groups' => $event->groups,
            'total_votes' => $candidates->sum('votes'),
            // json $candidates->pluck('name') as key and $candidates->pluck('votes') as value
            'candidates' => $candidates->pluck('votes', 'name'),
            'no_votes' => $event->population - $candidates->sum('votes'),
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
        $candidates = Candidate::select('candidates.name', DB::raw('count(votes.vote_id) as votes'))
            ->join('votes', 'candidates.candidate_id', '=', 'votes.candidate_id', 'left')
            ->where('candidates.event_id', $event->event_id)
            ->groupBy('candidates.name')
            ->orderBy('votes', 'desc')
            ->get();

        $data = [
            'name' => $event->name,
            'schedule' => $event->schedule,
            'cycle' => $event->cycle,
            'population' => $event->population,
            'total_votes' => $candidates->sum('votes'),
            // json $candidates->pluck('name') as key and $candidates->pluck('votes') as value
            'candidates' => $candidates->pluck('votes', 'name'),
            'no_votes' => $event->population - $candidates->sum('votes')
        ];


        $fpdi = new Fpdi;

        // get pdf template on public/pdf/default/1_ficha_tecnica.pdf
        $pageCount = $fpdi->setSourceFile(public_path('pdf/default/1_ficha_tecnica.pdf'));

        for ($i = 1; $i <= $pageCount; $i++) {
            $template = $fpdi->importPage($i);
            $size = $fpdi->getTemplateSize($template);
            $fpdi->AddPage($size['orientation'], array($size['width'], $size['height']));
            $fpdi->useTemplate($template);

//            $fpdi->SetFont("Century Gothic", "", 15);
            $fpdi->SetFont("helvetica", "", 13);

            $left = 63;
            $top = 61;
            $text = $data['name'];
            $fpdi->Text($left, $top, $text);

            $left = 61.5;
            $top = 83;
            $text = $data['schedule'];
            $fpdi->Text($left, $top, $text);

            $left = 61.5;
            $top = 95;
            $text = $data['cycle'];
            $fpdi->Text($left, $top, $text);

            $left = 61.5;
            $top = 107;
            $text = $data['population'];
            $fpdi->Text($left, $top, $text);

            $left = 61.5;
            $top = 119;
            $text = $data['total_votes'];
            $fpdi->Text($left, $top, $text);

            $left = 61.5;
            $top = 131;
            $text = $data['no_votes'];
            $fpdi->Text($left, $top, $text);

            $left = 61.5;
            $top = 143;
            $text = $data['candidates'];
            $fpdi->Text($left, $top, $text);

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

        $data = [
            'name' => $event->name,
            'candidates' => $candidates->pluck('votes', 'teamname'),
            'end_at' => $event->end_at,
            'director' => $event->director,
        ];

        $data['candidates'] = $data['candidates']->sortDesc();

        $top_candidate = $data['candidates']->first();
        $top_candidates = $data['candidates']->filter(function ($value, $key) use ($top_candidate) {
            return $value == $top_candidate;
        });

        $top_candidates_array = [];
        foreach ($top_candidates as $key => $value) {
            $fpdi = new Fpdi;
            $pageCount = $fpdi->setSourceFile(public_path('pdf/default/3_constancia.pdf'));
            for ($i = 1; $i <= $pageCount; $i++) {
                $template = $fpdi->importPage($i);
                $size = $fpdi->getTemplateSize($template);
                $fpdi->AddPage($size['orientation'], array($size['width'], $size['height']));
                $fpdi->useTemplate($template);
                $fpdi->SetFont("helvetica", "", 13);

                $left = 63;
                $top = 61;
                $text = $data['name'];
                $fpdi->Text($left, $top, $text);

                $left = 61.5;
                $top = 83;
                $text = $key;
                $fpdi->Text($left, $top, $text);

                //$data['end_at']
                $left = 61.5;
                $top = 95;
                $text = $data['end_at'];
                $fpdi->Text($left, $top, $text);

                //director
                $left = 61.5;
                $top = 107;
                $text = $data['director'];
                $fpdi->Text($left, $top, $text);
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

            Storage::disk('s3')->put('/pdf/majority/' . $event->event_key . '/'. $event->event_key .'.zip', $zip);
            $url = Storage::disk('s3')->url('/pdf/majority/' . $event->event_key . '/'. $event->event_key .'.zip');

            return response()->json(['url' => $url]);
        }
    }
}
