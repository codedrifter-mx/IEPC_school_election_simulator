<?php

namespace App\Http\Controllers;

use App\Models\Elector;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Str;

class ElectorController extends Controller
{
    public function index()
    {
        $electors = Elector::all();
        return response()->json($electors);
    }

    public function store(Request $request)
    {
        // make an array of rules for validation with these keys
        $rules = [
            'name' => 'required|string',
            'paternal_surname' => 'required|string',
            'maternal_surname' => 'required|string',
            'code' => 'required|string'
        ];

        // make an array of msgs for each rule, but in spanish
        $msgs = [
            'name.required' => 'El nombre es requerido',
            'name.string' => 'El nombre debe ser una cadena de texto',
            'paternal_surname.required' => 'El apellido paterno es requerido',
            'paternal_surname.string' => 'El apellido paterno debe ser una cadena de texto',
            'maternal_surname.required' => 'El apellido materno es requerido',
            'maternal_surname.string' => 'El apellido materno debe ser una cadena de texto',
            'code.required' => 'El código es requerido',
            'code.string' => 'El código debe ser una cadena de texto'
        ];

        // make a validator with the rules and msgs
        $request->validate($rules, $msgs);

        $request->request->add(['elector_key' => Str::random(8)]);

        // if the validator passes, create the user, inside a try catch, in case of error, return json error
        try {
            $elector = Elector::create($request->all());
            return response()->json($elector);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }

    public function show($id)
    {
        $elector = Elector::find($id);
        return response()->json($elector);
    }

    public function update(Request $request, $id)
    {
        // make an array of rules for validation with these keys
        $rules = [
            'event_key' => 'required',
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
            'event_key.required' => 'Event ID is required',
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
