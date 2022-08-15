<?php

namespace App\Http\Controllers;

use App\Models\Vote;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class VoteController extends Controller
{
    public function index()
    {
        $votes = Vote::all();
        return response()->json($votes);
    }

    public function create()
    {
        return view('vote.create');
    }

    public function store(Request $request)
    {
        // Make a validation through each table: voter, candidate, event with these keys: voter_id, candidate_id, event_id
        // if the validation fails, return a json with the error messages
        $rules = [
            'voter_id' => 'required|integer',
            'candidate_id' => 'required|integer',
            'event_id' => 'required|integer',
        ];

        $msgs = [
            'voter_id.required' => 'Voter ID is required',
            'voter_id.integer' => 'Voter ID must be an integer',
            'candidate_id.required' => 'Candidate ID is required',
            'candidate_id.integer' => 'Candidate ID must be an integer',
            'event_id.required' => 'Event ID is required',
            'event_id.integer' => 'Event ID must be an integer',
        ];

        $validator = Validator::make($request->all(), $rules, $msgs);

        if ($validator->fails()) {
            return response()->json($validator->errors());
        }

        $vote = Vote::create($request->all());

        return response()->json($vote);
    }

}
