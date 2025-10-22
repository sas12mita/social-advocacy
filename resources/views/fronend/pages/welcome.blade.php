@extends('fronend.layout.app')

@push('title', 'Social Advocacy')
@section('content')
<!-- Hero Section -->
<section class="bg-light text-center py-5">
    <div class="container">
        <h1 class="display-4" data-i18n="गृहपृष्ठ">Welcome to Social Advocacy</h1>
        <p class="lead mb-4" data-i18n="हमारा उद्देश्य">
            Our mission is to create positive social change in communities.
        </p>
        <a href="#" class="btn btn-primary btn-lg" data-i18n="सामेल">Join Us</a>
    </div>
</section>

<!-- Campaigns Section -->
<section class="py-5">
    <div class="container">
        <h2 class="mb-4 text-center" data-i18n="अभियान">Our Campaigns</h2>
        <div class="row g-4">
            @forelse($campaigns as $campaign)
            <div class="col-md-4">
                <div class="card h-100 shadow-sm">
                    <img src="{{ asset('uploads/campaigns/' . $campaign->image) }}"
                        class="card-img-top"
                        alt="{{ $campaign->title }}"
                        style="height: 250px; object-fit: cover;">
                    <div class="card-body">
                        <h5 class="card-title" data-i18n="{{ $campaign->nep_title }}">
                            {{ $campaign->title }}
                        </h5>
                        <p class="card-text" data-i18n="{{ $campaign->nep_description }}">
                            {{ Str::limit($campaign->description, 100) }}
                        </p>
                        <a href="{{ route('campaign.show', $campaign->id) }}"
                            class="btn btn-outline-primary"
                            data-i18n="थप जान्नुहोस्">
                            Learn More
                        </a>
                    </div>
                </div>
            </div>
            @empty
            <p class="text-center" data-i18n="कुनै अभियान उपलब्ध छैन">
                No campaigns available right now.
            </p>
            @endforelse
        </div>
    </div>
</section>


<!-- Events Section -->
<section class="bg-light py-5">
    <div class="container">
        <h2 class="mb-4 text-center" data-i18n="कार्यक्रमहरू">Upcoming Events</h2>
        <div class="row g-4">
            @forelse($events as $event)
            <div class="col-md-6">
                <div class="card h-100 shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title" data-i18n="{{ $event->nep_title }}">
                            {{ $event->title }}
                        </h5>
                        <p class="card-text" data-i18n="{{ $event->nep_description }}">
                            {{ Str::limit($event->description, 120) }}
                        </p>
                        <p class="text-muted mb-2">
                            <strong data-i18n="मिति">Deadline:</strong>
                            {{ \Carbon\Carbon::parse($event->deadline)->format('d M Y') }}
                        </p>
                        <a href="{{ route('event.show', $event->id) }}"
                            class="btn btn-primary"
                            data-i18n="दर्ता गर्नुहोस्">
                            Register
                        </a>
                    </div>
                </div>
            </div>
            @empty
            <p class="text-center" data-i18n="कुनै कार्यक्रम उपलब्ध छैन">
                No upcoming events available right now.
            </p>
            @endforelse
        </div>
    </div>
</section>


<!-- Blog Section -->
<section class="py-5">
    <div class="container">
        <h2 class="mb-4 text-center" data-i18n="ब्लग">Latest Blog</h2>
        <div class="row g-4">
            <div class="col-md-4">
                <div class="card h-100">
                    <img src="assets/images/blog1.jpg" class="card-img-top" alt="Blog 1">
                    <div class="card-body">
                        <h5 class="card-title">5 Ways to Make a Difference</h5>
                        <p class="card-text">Learn how small actions can create a big social impact.</p>
                        <a href="#" class="btn btn-outline-primary">Read More</a>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card h-100">
                    <img src="assets/images/blog2.jpg" class="card-img-top" alt="Blog 2">
                    <div class="card-body">
                        <h5 class="card-title">Volunteer Stories</h5>
                        <p class="card-text">Inspiring stories from our dedicated volunteers.</p>
                        <a href="#" class="btn btn-outline-primary">Read More</a>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card h-100">
                    <img src="assets/images/blog3.jpg" class="card-img-top" alt="Blog 3">
                    <div class="card-body">
                        <h5 class="card-title">Health & Wellness Tips</h5>
                        <p class="card-text">Simple tips to maintain good health in your community.</p>
                        <a href="#" class="btn btn-outline-primary">Read More</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Call to Action -->
<section class="bg-primary text-white text-center py-5">
    <div class="container">
        <h2 class="mb-3" data-i18n="स्वयंसेवक">Become a Volunteer</h2>
        <p class="mb-4">Join our community and help us make a difference today!</p>
        <a href="#" class="btn btn-light btn-lg" data-i18n="सामेल">Join Us</a>
    </div>
</section>


@endsection