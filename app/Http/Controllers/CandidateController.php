<?php

namespace App\Http\Controllers;

use App\Models\Candidate;
use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Str;

class CandidateController extends Controller
{
    public function index(Request $request)
    {
        // Get user_id from request
        $event_key= $request->event_key;

        // Log the event_key
//        \Log::info($event_key);

        // Find event id with event_key
        $event = Event::where('event_key', $event_key)->first();


        // Get all candidates where event_key
        $candidates = Candidate::where('event_id', $event->event_id)->get();

//        \Log::info($candidates);

        // Return the event
        return response()->json($candidates, 200);
    }

    public function store(Request $request)
    {
        // make an array of rules for validation with these keys
        $rules = [
            'event_key' => 'required',
            'teamname' => 'required|string',
            'name' => 'required|string',
            'paternal_surname' => 'required|string',
            'maternal_surname' => 'required|string'
        ];

        // make an array of msgs for each rule, but in spanish
        $msgs = [
            'event_key.required' => 'La clave del evento es requerida',
            'teamname.required' => 'El nombre del equipo es requerido',
            'teamname.string' => 'El nombre del equipo debe ser un string',
            'name.required' => 'El nombre es requerido',
            'name.string' => 'El nombre debe ser un string',
            'paternal_surname.required' => 'El apellido paterno es requerido',
            'paternal_surname.string' => 'El apellido paterno debe ser un string',
            'maternal_surname.required' => 'El apellido materno es requerido',
            'maternal_surname.string' => 'El apellido materno debe ser un string'
        ];

        // Make a validator with the rules and msgs
        $request->validate($rules, $msgs);

        // Find event id with event_key
        $event = Event::where('event_key', $request->event_key)->first();

        // add event_id to request
        $request->request->add(['event_id' => $event->event_id]);

        $request->request->add(['candidate_key' => Str::random(8)]);

        // if the validator passes, create the candidate
        $candidate = Candidate::create($request->all());

        // return the candidate
        return response()->json($candidate, 200);
    }

    public function show(Request $request)
    {
        // Get id from request
        $id = $request->candidate_id;

        // log the id
//        \Log::info($id);


        // find the candidate with the id
        $candidate = Candidate::find($id);

        // If the event is not found, return a 404
        if (!$candidate) {
            return response()->json(['message' => 'Event not found'], 404);
        }

        // Return the event
        return response()->json($candidate, 200);
    }

    public function update(Request $request)
    {
        // Get event_key from request
        $candidate_id = $request->candidate_id;

        // make an array of rules for validation with these keys
        $rules = [
            'teamname' => 'required|string',
            'name' => 'required|string',
            'paternal_surname' => 'required|string',
            'maternal_surname' => 'required|string',
        ];

        // make an array of msgs for each rule
        $msgs = [
            'teamname.required' => 'Teamname is required',
            'teamname.string' => 'Teamname must be a string',
            'name.required' => 'Name is required',
            'name.string' => 'Name must be a string',
            'paternal_surname.required' => 'Paternal Surname is required',
            'paternal_surname.string' => 'Paternal Surname must be a string',
            'maternal_surname.required' => 'Maternal Surname is required',
            'maternal_surname.string' => 'Maternal Surname must be a string',
        ];

        // make a validator with the rules and msgs
        $request->validate($rules, $msgs);

        // if the validator passes, update the candidate
        $candidate = Candidate::find($candidate_id)->update($request->all());

        // return the candidate
        return response()->json($candidate, 200);
    }

    public function destroy(Request $request)
    {
        // Get id from request
        $id = $request->candidate_id;

        // find the candidate with the id
        $candidate = Candidate::find($id);

        // If the event is not found, return a 404
        if (!$candidate) {
            return response()->json(['message' => 'Event not found'], 404);
        }

        // Delete the candidate
        $candidate->delete();

        // Return the candidate
        return response()->json($candidate, 200);
    }
}
