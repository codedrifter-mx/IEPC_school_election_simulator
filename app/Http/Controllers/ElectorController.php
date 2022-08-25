<?php

namespace App\Http\Controllers;

use App\Models\Elector;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ElectorController extends Controller
{
    public function index()
    {
        $electors = Elector::all();
        return response()->json($electors);
    }

    public function create()
    {
        return view('elector.create');
    }

    public function store(Request $request)
    {
        // make an array of rules for validation with these keys
        $rules = [
            'event_id' => 'required|integer',
            'name' => 'required|string',
            'paternal_surname' => 'required|string',
            'maternal_surname' => 'required|string',
            'email' => 'required|string',
            'code' => 'required|string',
            'created_at' => 'required|date',
            'updated_at' => 'required|date',
        ];

        // make an array of msgs for each rule
        $msgs = [
            'event_id.required' => 'Event ID is required',
            'event_id.integer' => 'Event ID must be an integer',
            'name.required' => 'Name is required',
            'name.string' => 'Name must be a string',
            'paternal_surname.required' => 'Paternal Surname is required',
            'paternal_surname.string' => 'Paternal Surname must be a string',
            'maternal_surname.required' => 'Maternal Surname is required',
            'maternal_surname.string' => 'Maternal Surname must be a string',
            'email.required' => 'Email is required',
            'email.string' => 'Email must be a string',
            'code.required' => 'Code is required',
            'code.string' => 'Code must be a string',
            'created_at.required' => 'Created At is required',
            'created_at.date' => 'Created At must be a date',
            'updated_at.required' => 'Updated At is required',
            'updated_at.date' => 'Updated At must be a date',
        ];

        // make a validator with the rules and msgs
        $validator = Validator::make($request->all(), $rules, $msgs);

        // if the validator fails, return the errors
        if ($validator->fails()) {
            return response()->json($validator->errors()->all());
        }

        // if the validator passes, create the user
        $elector = Elector::create($request->all());

        // return the user

    }

    public function show($id)
    {
        $elector = Elector::find($id);
        return response()->json($elector);
    }

    public function edit($id)
    {
        // find the user with the id
        $elector = Elector::find($id);

        // return the view with the user
        return view('elector.edit', compact('elector'));
    }

    public function update(Request $request, $id)
    {
        // make an array of rules for validation with these keys
        $rules = [
            'event_id' => 'required|integer',
            'name' => 'required|string',
            'paternal_surname' => 'required|string',
            'maternal_surname' => 'required|string',
            'email' => 'required|string',
            'code' => 'required|string',
            'created_at' => 'required|date',
            'updated_at' => 'required|date',
        ];

        // make an array of msgs for each rule
        $msgs = [
            'event_id.required' => 'Event ID is required',
            'event_id.integer' => 'Event ID must be an integer',
            'name.required' => 'Name is required',
            'name.string' => 'Name must be a string',
            'paternal_surname.required' => 'Paternal Surname is required',
            'paternal_surname.string' => 'Paternal Surname must be a string',
            'maternal_surname.required' => 'Maternal Surname is required',
            'maternal_surname.string' => 'Maternal Surname must be a string',
            'email.required' => 'Email is required',
            'email.string' => 'Email must be a string',
            'code.required' => 'Code is required',
            'code.string' => 'Code must be a string',
            'created_at.required' => 'Created At is required',
            'created_at.date' => 'Created At must be a date',
            'updated_at.required' => 'Updated At is required',
            'updated_at.date' => 'Updated At must be a date',
        ];

        // make a validator with the rules and msgs
        $validator = Validator::make($request->all(), $rules, $msgs);

        // if the validator fails, return the errors
        if ($validator->fails()) {
            return response()->json($validator->errors()->all());
        }

        // if the validator passes, update the user
        $elector = Elector::find($id);
        $elector->update($request->all());

        // return the user
        return response()->json($elector);
    }

    public function destroy($id)
    {
        $elector = Elector::find($id);
        $elector->delete();

        return response()->json(['success' => true]);
    }
}
