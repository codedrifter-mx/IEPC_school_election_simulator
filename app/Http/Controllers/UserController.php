<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function index()
    {
        $users = User::all();
        return response()->json($users);
    }

    public function store(Request $request)
    {
        // make an array of rules for validation with these keys
        $rules = [
            'name' => 'required|string',
            'email' => 'required|string',
            'email_verified_at' => 'required|date',
            'password' => 'required|string',
            'level' => 'required|integer',
            'remember_token' => 'required|string',
            'created_at' => 'required|date',
            'updated_at' => 'required|date',
        ];
        // make an array of msgs for each rule
        $msgs = [
            'name.required' => 'Name is required',
            'name.string' => 'Name must be a string',
            'email.required' => 'Email is required',
            'email.string' => 'Email must be a string',
            'email_verified_at.required' => 'Email Verified At is required',
            'email_verified_at.date' => 'Email Verified At must be a date',
            'password.required' => 'Password is required',
            'password.string' => 'Password must be a string',
            'level.required' => 'Level is required',
            'level.integer' => 'Level must be an integer',
            'remember_token.required' => 'Remember Token is required',
            'remember_token.string' => 'Remember Token must be a string',
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
        $user = User::create($request->all());
        // return the user
        return response()->json($user, 201);
    }

    public function show($id)
    {
        $user = User::find($id);
        return response()->json($user);
    }

}
