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
            'grade' => 'required|string',
            'group' => 'required|string',
            'code' => 'required|string'
        ];

        // make an array of msgs for each rule, but in spanish
        $msgs = [
            'name.required' => 'El nombre es requerido',
            'name.string' => 'El nombre debe ser una cadena de texto',
            'paternal_surname.required' => 'El primer apellido es requerido',
            'paternal_surname.string' => 'El primer apellido debe ser una cadena de texto',
            'grade.required' => 'El grado es requerido',
            'grade.string' => 'El grado debe ser una cadena de texto',
            'group.required' => 'El grupo es requerido',
            'group.string' => 'El grupo debe ser una cadena de texto',
            'code.required' => 'El código es requerido',
            'code.string' => 'El código debe ser una cadena de texto'
        ];

        // make a validator with the rules and msgs
        $request->validate($rules, $msgs);

        // if maternal_surname is empty, then add a space
        if ($request->maternal_surname == null) {
            $request->request->add(['maternal_surname' => " "]);
        }

        $request->request->add(['elector_key' => Str::random(8)]);
        // combine name, paternal_surname and maternal_surname and delete paternal_surname and maternal_surname afterwards

        // search if the code exists in the database
        $event = Elector::where('code', $request->code)->first();

        // if the code exists, then return an error\
        if ($event) {
            return response()->json([
                'message' => 'El código ya existe, elige otro'
            ], 400);
        }



        $elector = Elector::create($request->all());


        // success json
        return response()->json([
            'success' => true,
            'message' => 'Elector registrado correctamente'
        ]);
    }


    public function view($key = null)
    {
        $event = Event::where('user_id', Auth::user()->user_id)->get();

        // return the view with the event
        return view('auth.electors.register')->with('events', $event);
    }
}
