<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Vote;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Str;
use setasign\Fpdi\Fpdi;

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
            'start_at' => 'required|date'
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
        ];

        $request->validate($rules, $msgs);

        $request->request->add(['event_key' => Str::random(8)]);

        // add end_at to request with start_at
        $request->request->add(['end_at' => $request->start_at]);

        // log $request
        \Log::info($request->all());


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

        // Add a numeric status column, if the event is between start_at and end_at, is 1, if the event is before start_at, is 0, if the event is after end_at, is 2
        $event->status = $event->start_at->isBefore(now()) ? ($event->end_at->isAfter(now()) ? 1 : 2) : 0;

        return response()->json($event);
    }

    public function update(Request $request)
    {
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

    public function getFichaTecnica(Request $request)
    {
        $event_key = $request->event_key;

        // get $event inner joined with users table
        $event = DB::table('events')
            ->join('users', 'events.user_id', '=', 'users.user_id')
            ->select('events.*', 'users.name as user_name')
            ->where('events.event_key', $event_key)
            ->first();

        if (!$event) {
            return response()->json(['message' => 'Event not found'], 404);
        }



        // get votes inner join with candidates
        $votes = DB::table('votes')
            ->join('candidates', 'votes.candidate_id', '=', 'candidates.candidate_id')
            // select votes.* and candidates.name + candidates.paternal_surname + candidates.maternal_surname as candidate_name
            ->select('votes.*', 'candidates.*')
            ->where('votes.event_id', $event->event_id)
            ->get();
        if (!$votes) {
            return response()->json(['message' => 'Votes not found'], 404);
        }

        // get users name limit 1
        $nombre_escuela = $event->user_name;

        // get event start_at on format 'd/m/Y' using strtotime
        $fecha_inicio = date('d/m/Y', strtotime($event->start_at));

        // get event start_at on time format 'H:i'
        $hora_inicio = date('H:i', strtotime($event->start_at));

        // get event end_at on format 'd/m/Y'
        $fecha_fin = date('d/m/Y', strtotime($event->end_at));

        // get event end_at on time format 'H:i'
        $hora_fin = date('H:i', strtotime($event->end_at));

        // get event population
        $poblacion = $event->population;

        // get all votes count
        $votos = $votes->count();

        // get all votes count inner join candidates where candidate name is 'Nulo'
        $nulos = $votes->where('name', 'Nulo')->count();

        // get candidate winner with most votes
        $ganador = $votes->where('name', '!=', 'Nulo')->sortByDesc('votes')->first();

//        // get a groupbby candidate name and count the votes order by desc
//        $votos_por_candidato = $votes->groupBy('candidate_name')->countBy()->sortDesc();
//
//        // get candidate name with most votes
//        $candidato_ganador = $votos_por_candidato->keys()->first();

        // get a groupbby candidate name and count the votes
        $votos_por_candidato = $votes->groupBy('name')->map(function ($item, $key) {
            return $item->count();
        });


        // get responsible name
        $encargado = $event->responsible;



        $fpdi = new Fpdi;

        // get pdf template on public/pdf/default/1_ficha_tecnica.pdf
        $pageCount = $fpdi->setSourceFile(public_path('pdf/default/1_ficha_tecnica.pdf'));

        for ($i=1; $i<=$pageCount; $i++) {
            $template   = $fpdi->importPage($i);
            $size       = $fpdi->getTemplateSize($template);
            $fpdi->AddPage($size['orientation'], array($size['width'], $size['height']));
            $fpdi->useTemplate($template);

//            $fpdi->SetFont("Century Gothic", "", 15);
            $fpdi->SetFont("helvetica", "", 13);

            $left = 63;
            $top = 61;
            $text = $nombre_escuela;
            $fpdi->Text($left,$top,$text);

            $left = 61.5;
            $top = 83;
            $text = $fecha_inicio;
            $fpdi->Text($left,$top,$text);

            $left = 93;
            $top = 83;
            $text = $hora_inicio;
            $fpdi->Text($left,$top,$text);

            $left = 112;
            $top = 83;
            $text = $fecha_fin;
            $fpdi->Text($left,$top,$text);

            $left = 140;
            $top = 83;
            $text = $hora_fin;
            $fpdi->Text($left,$top,$text);

            $left = 63;
            $top = 100;
            $text = $poblacion;
            $fpdi->Text($left,$top,$text);

            $left = 63;
            $top = 120;
            $text = $votos;
            $fpdi->Text($left,$top,$text);

            $left = 63;
            $top = 140;
            $text = $nulos;
            $fpdi->Text($left,$top,$text);

            $left = 63;
            $top = 180;
            $text = $votos_por_candidato;
            $fpdi->Text($left,$top,$text);


//            $left = 63;
//            $top = 210;
//            $text = $ganador->teamname;
//            $fpdi->Text($left,$top,$text);
//
//            $left = 63;
//            $top = 230;
//            $text = $ganador->name . ' ' . $ganador->paternal_surname . ' ' . $ganador->maternal_surname;
//            $fpdi->Text($left,$top,$text);


        }

        $file = $fpdi->Output('S',$event->event_key  . '.pdf');

        Storage::disk('public')->put('/pdf/ficha/' . $event->event_key  . '.pdf', $file);

        // Storage::disk() but with S3
        Storage::disk('s3')->put('/pdf/ficha/' . $event->event_key  . '.pdf', $file);

        // get s3 url
        $url = Storage::disk('s3')->url('/pdf/ficha/' . $event->event_key  . '.pdf');

        //log if the file exists on s3
        \Log::info('File exists: ' . Storage::disk('s3')->exists('/pdf/ficha/' . $event->event_key  . '.pdf'));





        // return json success
        return response()->json(['message' => $event->event_key]);
    }
}
