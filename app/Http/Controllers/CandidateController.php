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


        // Get all candidates where event_key, and remove 'nulo' candidate
        $candidates = Candidate::where('event_id', $event->event_id)->where('name', '!=', 'Nulo')->get();


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

        // if there is more than 10 candidates in the event, return error message about max candidates
        if (Candidate::where('event_id', $event->event_id)->count() >= 11) {
            return response()->json(['message' => 'El número máximo de candidatos es 10'], 203);
        }

        // if the validator passes, create the candidate
        $candidate = Candidate::create($request->all());

        // if request has photo file, save it
        if ($request->hasFile('photo')) {
            // transform $request->file('photo') into .jpg file with vertical 4:3 ratio and lowest file size
            $image = Image::make($request->file('photo'))->fit(300, 400)->encode('jpg', 75);

            // save the image in 'public/candidates', $candidate->candidate_key . '.jpg'
            Storage::disk('s3')->put('candidates/' . $candidate->candidate_key . '.jpg', $image);
        }

        // if request has video file, save it
        if ($request->hasFile('video')) {
            // save the video in 'public/candidates', $candidate->candidate_key . '.mp4'
            Storage::disk('s3')->put('candidates/' . $candidate->candidate_key . '.mp4', $request->file('video'));
        }

        // create a 'nulo' candidate, if its not already created on this event_key
        if (Candidate::where('event_id', $event->event_id)->where('name', 'nulo')->count() == 0) {
            $nulo = new Candidate();
            $nulo->candidate_key = Str::random(8);
            $nulo->event_id = $event->event_id;
            $nulo->teamname = 'nulo';
            $nulo->name = 'nulo';
            $nulo->paternal_surname = 'nulo';
            $nulo->maternal_surname = 'nulo';
            $nulo->save();
        }


        // if there is odd number of candidates, send a json warning
        $candidates = Candidate::where('event_id', $event->event_id)->get();

        if ((count($candidates) - 1) == 1) {
            return response()->json([
                'message' => 'El número de candidatos es 1, por favor agrega otro candidato',
                'candidate' => $candidate,
            ], 203);
        }

        // if event end_at is empty, return a successful message but with a warning about validation
        if ($event->end_at == null) {
            return response()->json([
                'message' => 'Candidato creado con éxito, para la siguiente fase, espere a que el IEPC valide su evento y fecha fin',
                'candidate' => $candidate,
            ], 201);
        } else {
            return response()->json([
                'message' => 'Candidato creado con éxito, puedes avanzar a las fases de votacion',
                'candidate' => $candidate,
            ], 200);
        }
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
            Storage::disk('s3')->put('candidates/' . $candidate->candidate_key . '.jpg', $image);
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
            Storage::disk('s3')->delete('candidates/' . $candidate_key . '.jpg');
        } catch (\Exception $e) {
            \Log::info($e);
        }

        // if there is odd number of candidates, send a json warning
        $event = Event::where('event_id', $candidate->event_id)->first();
        $candidates = Candidate::where('event_id', $event->event_id)->get();

        if (count($candidates) % 2 != 0) {
            return response()->json([
                'message' => 'El número de candidatos es impar, por favor agrega otro candidato',
                'candidate' => $candidate,
            ], 201);
        }

        return response()->json(['message' => 'Evento borrado']);
    }
}
