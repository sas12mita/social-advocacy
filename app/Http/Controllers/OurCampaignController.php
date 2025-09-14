<?php

namespace App\Http\Controllers;

use App\Models\OurCampaign;
use Illuminate\Http\Request;

class OurCampaignController extends Controller
{

    public function index()
    {
        //
    }

    public function create()
    {
        return view('backend.cms.our-campaign.create');
    }

    /**
     * Store a newly created resource in storage.
     */

    public function store(Request $request)
    {
        $request->validate([
            'title'            => 'nullable|string|max:255',
            'nep_title'        => 'nullable|string|max:255',
            'nep_description'  => 'nullable|string',
            'description'      => 'nullable|string',
            'image'            => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $path = null;

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            // Save in storage/app/public/campions
            $path = $image->store('campions', 'public');
        }

        OurCampaign::create([
            'title'           => $request->title,
            'nep_title'       => $request->nep_title,
            'nep_description' => $request->nep_description,
            'image'           => $path, // stored relative path
        ]);

        return redirect()->back()
            ->with('success', 'Campaign created successfully!');
    }


    /**
     * Display the specified resource.
     */
    public function show(OurCampaign $OurCampaign)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(OurCampaign $OurCampaign)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, OurCampaign $OurCampaign)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(OurCampaign $OurCampaign)
    {
        //
    }
}