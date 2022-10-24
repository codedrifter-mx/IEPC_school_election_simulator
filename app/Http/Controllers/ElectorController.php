<?php

namespace App\Http\Controllers;

use App\Models\Elector;
use App\Models\Event;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Str;

class ElectorController extends Controller
{
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

    public function view($key = null)
    {
        $event = Event::where('user_id', Auth::user()->user_id)->get();

        // return the view with the event
        return view('auth.electors.register')->with('events', $event);
    }
}
