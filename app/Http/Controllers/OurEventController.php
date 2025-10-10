<?php

namespace App\Http\Controllers;

use App\Models\OurEvent;
use Illuminate\Http\Request;

class OurEventController extends Controller
{
   public function index()
    {
        $OurEvents = OurEvent::latest()->paginate(10); // get all OurEvents with pagination
        return view('OurEvents.index', compact('OurEvents'));
    }

    /**
     * Show the form for creating a new OurEvent.
     */
    public function create()
    {
        return ;
    }

    /**
     * Store a newly created OurEvent in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title'           => 'required|string|max:255',
            'nep_title'       => 'required|string|max:255',
            'deadline'        => 'required|date',
            'description'     => 'required|string',
            'nep_description' => 'required|string',
            'price'           => 'required|string|max:255',
        ]);

        OurEvent::create([
            'title'           => $request->title,
            'nep_title'       => $request->nep_title,
            'deadline'        => $request->deadline,
            'description'     => $request->description,
            'nep_description' => $request->nep_description,
            'price'           => $request->price,
            'publish_status'  => $request->has('publish_status'),
        ]);

        return redirect()->route('OurEvents.index')->with('success', 'OurEvent created successfully.');
    }

    /**
     * Display the specified OurEvent.
     */
    public function show(OurEvent $OurEvent)
    {
        return view('OurEvents.show', compact('OurEvent'));
    }

    /**
     * Show the form for editing the specified OurEvent.
     */
    public function edit(OurEvent $OurEvent)
    {
        return view('OurEvents.edit', compact('OurEvent'));
    }

    /**
     * Update the specified OurEvent in storage.
     */
    public function update(Request $request, OurEvent $OurEvent)
    {
        $request->validate([
            'title'           => 'required|string|max:255',
            'nep_title'       => 'required|string|max:255',
            'deadline'        => 'required|date',
            'description'     => 'required|string',
            'nep_description' => 'required|string',
            'price'           => 'required|string|max:255',
        ]);

        $OurEvent->update([
            'title'           => $request->title,
            'nep_title'       => $request->nep_title,
            'deadline'        => $request->deadline,
            'description'     => $request->description,
            'nep_description' => $request->nep_description,
            'price'           => $request->price,
            'publish_status'  => $request->has('publish_status'),
        ]);

        return redirect()->route('OurEvents.index')->with('success', 'OurEvent updated successfully.');
    }

    /**
     * Remove the specified OurEvent from storage.
     */
    public function destroy(OurEvent $OurEvent)
    {
        $OurEvent->delete();
        return redirect()->route('OurEvents.index')->with('success', 'OurEvent deleted successfully.');
    }
}