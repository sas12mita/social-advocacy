<?php

namespace App\Http\Controllers;

use App\Models\OurCampaign;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class OurCampaignController extends Controller
{

    public function index()
    {
        $our_campaigns = OurCampaign::paginate(10);
        return view('backend.cms.our-campaign.index', compact('our_campaigns'));
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
            'campaigns_date'    => 'nullable|date',
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
            'description'     => $request->description,
            'nep_description' => $request->nep_description,
            'campaigns_date' => $request->campaigns_date,
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
         $images = json_decode($OurCampaign->image, true) ?? [];

        // Delete images from public folder
        foreach ($images as $image) {
            if (Storage::disk('public')->exists($image)) {
                Storage::disk('public')->delete($image);
            }
        }
        $OurCampaign->delete();
        return redirect()->back()->with('success','Successfully deleted');
    }
     public function statusupdate($id)
    {
        $article = OurCampaign::findOrFail($id);
        $article->published_status = !$article->published_status;
        $article->save();
        return redirect()->back()->with('success', 'Article status updated successfully.');
    }
}
