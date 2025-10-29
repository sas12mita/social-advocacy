<?php

namespace App\Http\Controllers;

use App\Models\OurEvent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class OurEventController extends Controller
{
    public function index()
    {
        $events = OurEvent::latest()->paginate(10); // get all OurEvents with pagination
        return view('backend.cms.our-event.index', compact('events'));
    }

    /**
     * Show the form for creating a new OurEvent.
     */
    public function create()
    {
        return view('backend.cms.our-event.create');
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
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $path = null;

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            // Save in storage/app/public/campions
            $path = $image->store('events', 'public');
        }

        OurEvent::create([
            'title'           => $request->title,
            'nep_title'       => $request->nep_title,
            'deadline'        => $request->deadline,
            'description'     => $request->description,
            'nep_description' => $request->nep_description,
            'price'           => $request->price,
            'image'           => $path, // stored relative path
        ]);

        return redirect()->back()->with('success', 'OurEvent created successfully.');
    }

    /**
     * Display the specified OurEvent.
     */
    public function show($id)
    {
        $event = OurEvent::findOrFail($id);
        return view('fronend.pages.events-show', compact('event'));
    }

    /**
     * Show the form for editing the specified OurEvent.
     */
    public function edit($id)
    {
        $OurEvent = OurEvent::findOrFail($id);
        return view('backend.cms.our-event.edit', compact('OurEvent'));
    }

    /**
     * Update the specified OurEvent in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'title'           => 'required|string|max:255',
            'nep_title'       => 'required|string|max:255',
            'deadline'        => 'required|date',
            'description'     => 'required|string',
            'nep_description' => 'required|string',
            'price'           => 'required|string|max:255',
            'image'           => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Find the event by ID
        $OurEvent = OurEvent::findOrFail($id);

        $data = $request->only([
            'title',
            'nep_title',
            'deadline',
            'description',
            'nep_description',
            'price',
        ]);

        // Handle new image upload
        if ($request->hasFile('image')) {
            // Delete old image if it exists
            if ($OurEvent->image && Storage::disk('public')->exists($OurEvent->image)) {
                Storage::disk('public')->delete($OurEvent->image);
            }

            // Store new image
            $data['image'] = $request->file('image')->store('events', 'public');
        }

        // Update the record
        $OurEvent->update($data);

        return redirect()->back()->with('success', 'Our Event updated successfully.');
    }


    /**
     * Remove the specified OurEvent from storage.
     */
    public function destroy($id)
    {
        $event = OurEvent::findOrFail($id);
        $event->delete();
        return redirect()->back()->with('success', 'OurEvent deleted successfully.');
    }
    public function statusupdate($id)
    {
        $event = OurEvent::findOrFail($id);
        $event->publish_status = !$event->publish_status;
        $event->save();
        return redirect()->back()->with('success', 'Our Events status updated successfully.');
    }
    public function register() {}
}
