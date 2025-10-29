@extends('fronend.layout.app')

@push('title', 'Social Advocacy')
@section('content')
<!-- Hero Section -->
<section class="bg-light py-5">
    <div class="container">
        <div class="row justify-content-center">
            <!-- Left Column: Event Description (8 cols) -->
            <div class="col-lg-8 mb-4">
                <div class="card shadow-sm border-0 overflow-hidden">
                    <img src="{{ asset('storage/' . $event->image) }}"
                        alt="{{ $event->title }}"
                        class="w-100"
                        style="height: 400px; object-fit: cover;">

                    <div class="card-body p-4">
                        <h2 class="fw-bold mb-3 text-primary" data-i18n="{{ $event->nep_title }}">
                            {{ $event->title }}
                        </h2>

                        <p class="text-muted mb-3">
                            <i class="bi bi-calendar-event me-2"></i>
                            <strong data-i18n="अन्तिम मिति">Deadline:</strong>
                            {{ \Carbon\Carbon::parse($event->deadline)->format('F d, Y') }}
                        </p>

                        <p class="text-muted mb-4">
                            <i class="bi bi-cash-coin me-2"></i>
                            <strong data-i18n="शुल्क">Price:</strong>
                            {{ $event->price }}
                        </p>

                        <div>
                            <h5 class="fw-semibold mb-2" data-i18n="विवरण">Event Description:</h5>
                            <p class="text-secondary" data-i18n="{{ $event->nep_description }}">
                                {!! $event->description !!}
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Column: Registration Form (4 cols) -->
            <div class="col-lg-4">
                <div class="card shadow-sm border-0 p-4 h-80">
                    <h4 class="fw-bold mb-3 text-center" data-i18n="दर्ता गर्नुहोस्">Register Now</h4>

                    <form action="{{ route('events.register') }}" method="POST">
                        @csrf
                            <input type="hidden" name="event_id" value="{{ $event->id }}">

                        <div class="mb-3">
                            <label for="name" class="form-label" data-i18n="नाम">Name</label>
                            <input type="text" name="name" id="name" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label for="email" class="form-label" data-i18n="इमेल">Email</label>
                            <input type="email" name="email" id="email" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label for="phone" class="form-label" data-i18n="फोन नम्बर">Phone Number</label>
                            <input type="text" name="phone" id="phone" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label for="address" class="form-label" data-i18n="ठेगाना">Address</label>
                            <textarea name="address" id="address" class="form-control" rows="3" required></textarea>
                        </div>

                        <button type="submit" class="btn btn-primary btn-lg w-100 rounded-pill" data-i18n="दर्ता गर्नुहोस्">
                            Register Now
                        </button>
                    </form>

                    <small class="text-muted mt-3 d-block text-center" data-i18n="दर्ता शुल्क विवरण">
                        Please complete your registration before the deadline.
                    </small>
                </div>
            </div>
        </div>

        <!-- 🔙 Back to Events -->
        <div class="text-center mt-4">
            <a href="{{ route('index') }}" class="text-decoration-none text-secondary">
                <i class="bi bi-arrow-left-circle me-1"></i>
                <span data-i18n="कार्यक्रमहरूमा फर्कनुहोस्">Back to Events</span>
            </a>
        </div>
    </div>
</section>
@endsection