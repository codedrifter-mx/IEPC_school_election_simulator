<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index()
    {

    }

    public function index_events(Request $request)
    {
        // get all events
        $events = Event::all();

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

        return response()->json($events, 200);
    }


    // send email function with email and subject in the request, validated
    public function sendEmail(Request $request)
    {
        // set rules
        $rules = [
            'email' => 'required|email',
            'subject' => 'required',
        ];

        // msgs but in spanish
        $messages = [
            'email.required' => 'El campo email es requerido',
            'email.email' => 'El campo email debe ser un email valido',
            'subject.required' => 'El campo asunto es requerido',
        ];

        // validate
        $request->validate($rules, $messages);


        // send email
//        Mail::to($request->email)->send(new SendEmail($request->subject));

        // return response
        return response()->json(['message' => 'Email enviado correctamente'], 200);
    }
}
