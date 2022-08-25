<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class EventController extends Controller
{
    public function index()
    {
        $events = Event::all();

        // Return the event
        return response()->json($events, 200);
    }

    public function store(Request $request)
    {
        // Log all the request data
        \Log::info($request->all());

        // Make an array of rules for validation with these keys
        $rules = [
            'name' => 'required|string',
            'schedule' => 'required|string',
            'director' => 'required|string',
            'in_charge' => 'required|string',
            'population' => 'required|integer',
            'groups' => 'required|integer',
            'start_at' => 'required|date',
            'end_at' => 'required|date',
        ];

        // Make an array of msgs for each rule, in spanish
        $msgs = [
            'name.required' => 'El nombre es requerido',
            'name.string' => 'El nombre debe ser un string',
            'schedule.required' => 'El horario es requerido',
            'schedule.string' => 'El horario debe ser un string',
            'director.required' => 'El director es requerido',
            'director.string' => 'El director debe ser un string',
            'in_charge.required' => 'El encargado es requerido',
            'in_charge.string' => 'El encargado debe ser un string',
            'population.required' => 'La población es requerida',
            'population.integer' => 'La población debe ser un entero',
            'groups.required' => 'El número de grupos es requerido',
            'groups.integer' => 'El número de grupos debe ser un entero',
            'start_at.required' => 'La fecha de inicio es requerida',
            'start_at.date' => 'La fecha de inicio debe ser una fecha',
            'end_at.required' => 'La fecha de fin es requerida',
            'end_at.date' => 'La fecha de fin debe ser una fecha',
        ];

        // Make a validator with the rules and msgs
        $request->validate($rules, $msgs);

        // get current datetime and merge it to the request as added_at
        $request->merge(['added_at' => date('Y-m-d H:i:s')]);

        // If the validator passes, create the event
        $event = Event::create($request->all());

        // Return only 200 status
        return response()->json($event, 200);
    }

    public function show(Request $request)
    {
        // Get id from request
        $id = $request->id;

        // log the id
//        \Log::info($id);

        // Find the event with the id
        $event = Event::find($id);

        // If the event is not found, return a 404
        if (!$event) {
            return response()->json(['message' => 'Event not found'], 404);
        }

        // Return the event
        return response()->json($event, 200);
    }

    public function update(Request $request)
    {
        // Get event_id from request
        $id = $request->event_id;

        // Make an array of rules for validation with these keys
        $rules = [
            'user_id' => 'required|integer',
            'name' => 'required|string',
            'schedule' => 'required|string',
            'director' => 'required|string',
            'in_charge' => 'required|string',
            'population' => 'required|integer',
            'groups' => 'required|integer',
            'start_at' => 'required|date',
            'end_at' => 'required|date',
        ];

        // Make an array of msgs for each rule
        $msgs = [
            'user_id.required' => 'User ID is required',
            'user_id.integer' => 'User ID must be an integer',
            'name.required' => 'Name is required',
            'name.string' => 'Name must be a string',
            'schedule.required' => 'Schedule is required',
            'schedule.string' => 'Schedule must be a string',
            'director.required' => 'Director is required',
            'director.string' => 'Director must be a string',
            'in_charge.required' => 'In Charge is required',
            'in_charge.string' => 'In Charge must be a string',
            'population.required' => 'Population is required',
            'population.integer' => 'Population must be an integer',
            'groups.required' => 'Groups is required',
            'groups.integer' => 'Groups must be an integer',
            'added_at.required' => 'Added At is required',
            'added_at.date' => 'Added At must be a date',
            'start_at.required' => 'Start At is required',
            'start_at.date' => 'Start At must be a date',
            'end_at.required' => 'End At is required',
            'end_at.date' => 'End At must be a date',
        ];

        $request->validate($rules, $msgs);

        // log id
        \Log::info($id);

        // If the validator passes, update the event
        $event = Event::find($id)->update($request->all());

        // Return the event
        return response()->json($event, 200);
    }

    public function destroy(Request $request)
    {

        // Get event_id from request
        $id = $request->id;

        //log id
        \Log::info($id);
        \Log::info($request);

        // Find the event
        $event = Event::find($id);

        // If the event is not found, return a 404
        if (!$event) {
            return response()->json(['message' => 'Event not found'], 500);
        }

        // Delete the event
        $event->delete();

        $events = Event::all();

        return view('event.Event', ['events' => $events])->renderSections()['events'];
    }
}
