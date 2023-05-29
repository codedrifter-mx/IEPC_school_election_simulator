<?php

namespace App\Http\Controllers;

use App\Models\Elector;
use App\Models\Event;
use App\Models\Vote;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class VoteController extends Controller
{
    public function view($key)
    {
        return view('vote.Vote')->with('key', $key);
    }

    public function store(Request $request)
    {
        // Make a validation through each table: elector, candidate, event with these keys: elector_id, candidate_id, event_key
        // if the validation fails, return a json with the error messages
        $rules = [
            'code' => 'required',
            'candidate_id' => 'required|integer',
            'event_key' => 'required',
        ];

        // validation messages, but in spanish
        $msgs = [
            'code.required' => 'El código es requerido',
            'candidate_id.required' => 'El id del candidato es requerido',
            'candidate_id.integer' => 'El id del candidato debe ser un entero',
            'event_key.required' => 'La clave del evento es requerida',
        ];

        $request->validate($rules, $msgs);

        // Validate if the elector.code already exists
        $elector = Elector::where('code', $request->code)->first();

        // if elector is null, return a json with the error message that this code dont exists, but in spanish
        if ($elector == null) {
            return response()->json(['error' => 'El código de voto no esta registrado'], 404);
        }

        // if elector event_key is different to the request event_key, return a json with the error message that the elector has already voted, in spanish
        if ($elector->event_key != $request->event_key) {
            return response()->json(['error' => 'Este codigo de voto es para otro evento de votacion...'], 400);
        }


        $has_voted = Vote::where('elector_id', $elector->elector_id)->first();

        // If the elector.code exist, return a json with the error message that the elector has already voted, in spanish
        if ($has_voted) {
            return response()->json(['error' => 'Ya votaste en este evento'], 400);
        }



        // Get elector_id with elector.code, get candidate_id with the request, and get event_id with event_key, then create a new vote
        $event = Event::where('event_key', $request->event_key)->first();


        $now = now('America/Mexico_City');

        $now = $now->toDateTimeString();
        $event->start_at = $event->start_at->toDateTimeString();
        $event->end_at = $event->end_at->toDateTimeString();

        if ($now >= $event->end_at) {
            return response()->json(['error' => 'La votación termino'], 400);
        }

        $vote = Vote::create([
            'elector_id' => $elector->elector_id,
            'candidate_id' => $request->candidate_id,
            'event_id' => $event->event_id,
        ]);

        return response()->json($vote);
    }
}
