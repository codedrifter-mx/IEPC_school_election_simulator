<?php

namespace App\Http\Controllers;

use App\Models\Candidate;
use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Intervention\Image\Facades\Image;
use Str;

class CandidateController extends Controller
{
    public function index(Request $request)
    {
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
        ];

        // make an array of msgs for each rule, but in spanish
        $msgs = [
            'event_key.required' => 'La clave del evento es requerida',
            'teamname.required' => 'El nombre del equipo es requerido',
            'teamname.string' => 'El nombre del equipo debe ser un string',
            'name.required' => 'El nombre es requerido',
            'name.string' => 'El nombre debe ser un string',
        ];

        // Make a validator with the rules and msgs
        $request->validate($rules, $msgs);

        // Find event id with event_key
        $event = Event::where('event_key', $request->event_key)->first();

        // add event_id to request
        $request->request->add(['event_id' => $event->event_id]);
        $request->request->add(['paternal_surname' => "temp"]);
        $request->request->add(['maternal_surname' => "temp"]);

        $request->request->add(['candidate_key' => Str::random(8)]);

        // if the validator passes, create the candidate
        $candidate = Candidate::create($request->all());

        // if request has photo file, save it
        if ($request->hasFile('photo')) {
            // transform $request->file('photo') into .jpg file with vertical 4:3 ratio and lowest file size
            $image = Image::make($request->file('photo'))->fit(300, 400)->encode('jpg', 75);

            // save the image in 'public/candidates', $candidate->candidate_key . '.jpg'
            Storage::disk('public')->put('candidates/' . $candidate->candidate_key . '.jpg', $image);
        }




        // return the candidate
        return response()->json($candidate, 200);
    }

    public function show(Request $request)
    {
        $candidate_key = $request->candidate_key;

        $candidate = Candidate::firstWhere('candidate_key', $candidate_key);

        if (!$candidate) {
            return response()->json(['message' => 'Candidato no encontrado'], 404);
        }

        return response()->json($candidate, 200);
    }

    public function update(Request $request)
    {
        $candidate_key = $request->candidate_key;

        $rules = [
            'teamname' => 'required|string',
            'name' => 'required|string'
        ];

        $msgs = [
            'teamname.required' => 'El nombre del equipo es requerido',
            'teamname.string' => 'El nombre del equipo debe ser un string',
            'name.required' => 'El nombre es requerido',
            'name.string' => 'El nombre debe ser un string'        ];

        $request->validate($rules, $msgs);

        $candidate = Candidate::firstWhere('candidate_key', $candidate_key);

        if (!$candidate) {
            return response()->json(['message' => 'Candidato no encontrado'], 404);
        }

        $candidate->update($request->all());

        // if request has photo file, save it
        if ($request->hasFile('photo')) {
            // transform as vertical 4:3 ratio and lowest file size
            $image = Image::make($request->file('photo'))->fit(400, 400)->encode('jpg', 75);

            // save the image
            Storage::disk('public')->put('candidates/' . $candidate->candidate_key . '.jpg', $image);
        }

        return response()->json($candidate, 200);
    }

    public function destroy(Request $request)
    {
        $candidate_key = $request->candidate_key;
        $candidate = Candidate::firstWhere('candidate_key', $candidate_key);

        if (!$candidate) {
            return response()->json(['message' => 'Candidato no encontrado'], 404);
        }

        $candidate->delete();

        // delete 'candidates/' . $candidate_key . '.jpg' from storage inside try catch
        try {
            Storage::disk('public')->delete('candidates/' . $candidate_key . '.jpg');
        } catch (\Exception $e) {
            \Log::info($e);
        }

        return response()->json(['message' => 'Evento borrado']);
    }
}
