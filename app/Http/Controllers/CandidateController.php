<?php

namespace App\Http\Controllers;

use App\Models\Candidate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CandidateController extends Controller
{
    public function index()
    {
        $candidates = Candidate::all();
        return response()->json($candidates);
    }

    public function create()
    {
        return view('candidate.create');
    }

    public function store(Request $request)
    {
        // make an array of rules for validation with these keys
        $rules = [
            'event_id' => 'required|integer',
            'teamname' => 'required|string',
            'name' => 'required|string',
            'paternal_surname' => 'required|string',
            'maternal_surname' => 'required|string',
            'created_at' => 'required|date',
            'updated_at' => 'required|date',
        ];

        // make an array of msgs for each rule
        $msgs = [
            'event_id.required' => 'Event ID is required',
            'event_id.integer' => 'Event ID must be an integer',
            'teamname.required' => 'Teamname is required',
            'teamname.string' => 'Teamname must be a string',
            'name.required' => 'Name is required',
            'name.string' => 'Name must be a string',
            'paternal_surname.required' => 'Paternal Surname is required',
            'paternal_surname.string' => 'Paternal Surname must be a string',
            'maternal_surname.required' => 'Maternal Surname is required',
            'maternal_surname.string' => 'Maternal Surname must be a string',
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

        // if the validator passes, create the candidate
        $candidate = Candidate::create($request->all());

        // return the candidate
        return response()->json($candidate, 201);
    }

    public function show($id)
    {
        // find the candidate with the id
        $candidate = Candidate::find($id);

        // return the candidate
        return response()->json($candidate, 200);
    }

    public function edit($id)
    {
        // find the candidate with the id
        $candidate = Candidate::find($id);

        // return the candidate
        return view('candidate.edit', compact('candidate'));
    }

    public function update(Request $request, $id)
    {
        // make an array of rules for validation with these keys
        $rules = [
            'event_id' => 'required|integer',
            'teamname' => 'required|string',
            'name' => 'required|string',
            'paternal_surname' => 'required|string',
            'maternal_surname' => 'required|string',
            'created_at' => 'required|date',
            'updated_at' => 'required|date',
        ];

        // make an array of msgs for each rule
        $msgs = [
            'event_id.required' => 'Event ID is required',
            'event_id.integer' => 'Event ID must be an integer',
            'teamname.required' => 'Teamname is required',
            'teamname.string' => 'Teamname must be a string',
            'name.required' => 'Name is required',
            'name.string' => 'Name must be a string',
            'paternal_surname.required' => 'Paternal Surname is required',
            'paternal_surname.string' => 'Paternal Surname must be a string',
            'maternal_surname.required' => 'Maternal Surname is required',
            'maternal_surname.string' => 'Maternal Surname must be a string',
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

        // if the validator passes, update the candidate
        $candidate = Candidate::find($id)->update($request->all());

        // return the candidate
        return response()->json($candidate, 200);
    }

    public function destroy($id)
    {
        // find the candidate with the id
        $candidate = Candidate::find($id);
        // if the candidate is not found, return a 404
        if (!$candidate) {
            return response()->json(['message' => 'Candidate not found'], 404);
        }
        // delete the candidate
        $candidate->delete();

        // return a 204
        return response()->json(null, 204);
    }
}
