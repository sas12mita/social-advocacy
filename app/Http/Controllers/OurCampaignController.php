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
    public function edit($id)
    {
        $campaign = OurCampaign::findOrFail($id);
        return view('backend.cms.our-campaign.edit', compact('campaign'));
    }

    public function update(Request $request, $id)
    {
        $campaign = OurCampaign::findOrFail($id);

        $request->validate([
            'title' => 'required|string|max:255',
            'nep_title' => 'required|string|max:255',
            'description' => 'required',
            'nep_description' => 'required',
            'campaigns_date' => 'required|date',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $campaign->title = $request->title;
        $campaign->nep_title = $request->nep_title;
        $campaign->description = $request->description;
        $campaign->nep_description = $request->nep_description;
        $campaign->campaigns_date = $request->campaigns_date;

        if ($request->hasFile('image')) {
            // Delete image from storage if it exists
            if ($campaign->image && Storage::disk('public')->exists($campaign->image)) {
                Storage::disk('public')->delete($campaign->image);
            }
            $path = $request->file('image')->store('campaigns', 'public');
            $campaign->image = $path;
        }

        $campaign->save();

        return redirect()->route('campaigns.index')->with('success', 'Campaign updated successfully!');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(OurCampaign $OurCampaign)
    {
        // Delete image from storage if it exists
        if ($OurCampaign->image && Storage::disk('public')->exists($OurCampaign->image)) {
            Storage::disk('public')->delete($OurCampaign->image);
        }
        $OurCampaign->delete();
        return redirect()->back()->with('success', 'Successfully deleted');
    }
    public function statusupdate($id)
    {
        $article = OurCampaign::findOrFail($id);
        $article->publish_status = !$article->publish_status;
        $article->save();
        return redirect()->back()->with('success', 'Our Campaign status updated successfully.');
    }
}
