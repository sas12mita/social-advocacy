<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EventRegistrationController extends Controller
{
     public function register(Request $request) {
        $request->validate([
            'event_id' => 'required|exists:our_events,id',
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'phone' => 'required|string|max:20',
            'address' => 'required|string',
        ]);

        DB::table('event_registrations')->insert([
            'our_events_id' => $request->event_id,
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'address' => $request->address,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return redirect()->back()->with('success', 'Registration successful!');
     }
     public function eventregistered($eventId)
     {    
        $event = DB::table('our_events')->select('id', 'title')->where('id', $eventId)->first();

         $registrations = DB::table('event_registrations')
            ->where('our_events_id', $eventId)
            ->orderByDesc('id')
            ->get();

        return view('backend.cms.our-event.registrationevents', compact('event','registrations'));
     }
}
