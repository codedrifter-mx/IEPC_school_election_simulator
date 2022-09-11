<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Str;

class EventController extends Controller
{
    public function index(Request $request)
    {
        // Get user_id from request
        $user_id = $request->user_id;

        // Get all events where user_id is the owner
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

        //\Log::info($events);

        // Return the event
        return response()->json($events, 200);
    }

    public function store(Request $request)
    {
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

        // Add event_key to request with a random 8 string with laravel random library
        $request->request->add(['event_key' => Str::random(8)]);

        // If the validator passes, create the event
        $event = Event::create($request->all());

        // Return only 200 status
        return response()->json($event, 200);
    }

    public function show(Request $request)
    {
        // Get id from request
        $event_key = $request->event_key;

        // log the id
        //\Log::info($event_key);

        // Find the event with the $event_key
        $event = Event::firstWhere('event_key', $event_key);

        // If the event is not found, return a 404
        if (!$event) {
            return response()->json(['message' => 'Event not found'], 404);
        }

        // Add a numeric status column, if the event is between start_at and end_at, is 1, if the event is before start_at, is 0, if the event is after end_at, is 2
        $event->status = $event->start_at->isBefore(now()) ? ($event->end_at->isAfter(now()) ? 1 : 2) : 0;

        // Return the event
        return response()->json($event, 200);
    }

    public function update(Request $request)
    {
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

        // Make an array of msgs for each rule
        $msgs = [
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

        // Get event_key from request
        $event_key = $request->event_key;

        // Log $event_key
        //\Log::info($event_key);

        // If the validator passes, update the event
        $event = Event::firstWhere('event_key', $event_key)->update($request->all());

        // Return the event
        return response()->json($event, 200);
    }

    public function destroy(Request $request)
    {
        // Get event_key from request
        $event_key = $request->event_key;

        // Log id and request
        //\Log::info($id);
        //\Log::info($request);

        // Find the event
        $event = Event::firstWhere('event_key', $event_key);

        // If the event is not found, return a 404
        if (!$event) {
            return response()->json(['message' => 'Event not found'], 500);
        }

        // Delete the event
        $event->delete();

        // Return json code 200
        return response()->json(['message' => 'Event deleted'], 200);
    }
}
