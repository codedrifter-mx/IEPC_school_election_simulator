<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class EventController extends Controller
{
    public function index()
    {
        $events = Event::all();
        return response()->json($events);
    }

    public function create()
    {
        return view('event.create');
    }

    public function store(Request $request)
    {
        // Make an array of rules for validation with these keys
        $rules = [
            'user_id' => 'required|integer',
            'name' => 'required|string',
            'schedule' => 'required|string',
            'director' => 'required|string',
            'in_charge' => 'required|string',
            'population' => 'required|integer',
            'groups' => 'required|integer',
            'added_at' => 'required|date',
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

        // Make a validator with the rules and msgs
        $validator = Validator::make($request->all(), $rules, $msgs);

        // If the validator fails, return the errors
        if ($validator->fails()) {
            return response()->json($validator->errors()->all(), 400);
        }

        // If the validator passes, create the event
        $event = Event::create($request->all());

        // Return the event
        return response()->json($event, 201);
    }

    public function show($id)
    {
        // Find the event with the id
        $event = Event::find($id);

        // If the event is not found, return a 404
        if (!$event) {
            return response()->json(['message' => 'Event not found'], 404);
        }

        // Return the event
        return response()->json($event, 200);
    }

    public function edit($id)
    {
        // Find the event with the id
        $event = Event::find($id);

        // If the event is not found, return a 404
        if (!$event) {
            return response()->json(['message' => 'Event not found'], 404);
        }

        // Return the event
        return view('event.edit', compact('event'));
    }

    public function update(Request $request, $id)
    {
        // Make an array of rules for validation with these keys
        $rules = [
            'user_id' => 'required|integer',
            'name' => 'required|string',
            'schedule' => 'required|string',
            'director' => 'required|string',
            'in_charge' => 'required|string',
            'population' => 'required|integer',
            'groups' => 'required|integer',
            'added_at' => 'required|date',
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

        // Make a validator with the rules and msgs
        $validator = Validator::make($request->all(), $rules, $msgs);

        // If the validator fails, return the errors
        if ($validator->fails()) {
            return response()->json($validator->errors()->all(), 400);
        }

        // If the validator passes, update the event
        $event = Event::find($id)->update($request->all());

        // Return the event
        return response()->json($event, 200);
    }

    public function destroy($id)
    {
        // Find the event
        $event = Event::find($id);

        // If the event is not found, return a 404
        if (!$event) {
            return response()->json(['message' => 'Event not found'], 404);
        }

        // Delete the event
        $event->delete();

        // Return a 204
        return response()->json(null, 204);
    }
}
