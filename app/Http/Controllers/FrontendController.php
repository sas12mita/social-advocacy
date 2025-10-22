<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\OurCampaign;
use App\Models\OurEvent;
use Illuminate\Http\Request;

class FrontendController extends Controller
{
    public function index()
    {
        // Fetch the latest 3 published articles
        $articles = Article::where('published_status', true)
            ->latest()
            ->limit(3)
            ->get();

        // Fetch the latest 3 published events
        $events = OurEvent::where('publish_status', true)
            ->latest()
            ->limit(3)
            ->get();

        // Fetch the latest 3 published campaigns
        $campaigns = OurCampaign::where('publish_status', true)
            ->latest()
            ->limit(3)
            ->get();

        // Pass data to the index Blade view
        return view('fronend.pages.welcome', compact('articles', 'events', 'campaigns'));
    }

    public function event() {}
    public function campaign() {}
    public function article() {}
}
