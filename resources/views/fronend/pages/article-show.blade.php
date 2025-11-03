@extends('frontend.layout.app')

@push('title', $article->heading)
@section('content')

<section class="bg-light py-5">
    <div class="container">
        <div class="row justify-content-center">

            <!-- LEFT COLUMN -->
            <div class="col-lg-8 mb-4">
                <div class="card shadow-sm border-0 overflow-hidden">

                    {{-- IMAGES LAYOUT --}}
                    @php
                        $images = json_decode($article->image, true) ?? [];
                        $count = count($images);
                    @endphp

                    @if($count == 1)
                        <img src="{{ asset('storage/' . $images[0]) }}"
                             class="w-100"
                             style="height:500px; object-fit:cover;" />

                    @elseif($count == 2)
                        <div class="row g-2" style="height:500px;">
                            @foreach($images as $img)
                                <div class="col-6">
                                    <img src="{{ asset('storage/' . $img) }}" class="w-100 h-100"
                                         style="object-fit:cover;" />
                                </div>
                            @endforeach
                        </div>

                    @elseif($count == 3)
                        <div class="row g-2" style="height:500px;">
                            <div class="col-6">
                                <img src="{{ asset('storage/' . $images[0]) }}"
                                     class="w-100 h-100"
                                     style="object-fit:cover;" />
                            </div>
                            <div class="col-6 d-flex flex-column gap-2">
                                <img src="{{ asset('storage/' . $images[1]) }}" class="w-100 flex-grow-1"
                                     style="object-fit:cover;" />
                                <img src="{{ asset('storage/' . $images[2]) }}" class="w-100 flex-grow-1"
                                     style="object-fit:cover;" />
                            </div>
                        </div>
                    @endif

                    <div class="card-body p-4">

                        <h2 class="fw-bold mb-3 text-primary" data-i18n="{{ $article->nep_heading }}">
                            {{ $article->heading }}
                        </h2>

                        <p class="text-muted">
                            <strong>Category:</strong> {{ $article->category->name }}
                        </p>

                        <p class="text-muted mb-3">
                            <small><i class="bi bi-eye"></i> {{ $article->view ?? 0 }} views</small>
                        </p>

                        <div>
                            <h5 class="fw-semibold mb-2" data-i18n="विवरण">Article Content:</h5>
                            <p class="text-secondary" data-i18n="{{ $article->nep_body }}">
                                {!! $article->body !!}
                            </p>
                        </div>

                    </div>
                </div>
            </div>

            <!-- RIGHT COLUMN -->
            <div class="col-lg-4">
                <div class="card shadow-sm border-0 p-4 h-80">
                    <h4 class="fw-bold mb-3 text-center">Related Articles</h4>

                    @forelse ($relatedArticles as $item)
                        <div class="mb-3">
                            <a href="{{ route('articles.show', $item->slug) }}" class="text-decoration-none">
                                <strong>{{ $item->heading }}</strong>
                            </a>
                        </div>
                    @empty
                        <p class="text-muted text-center">No related articles</p>
                    @endforelse
                </div>
            </div>

        </div>

        <div class="text-center mt-4">
            <a href="{{ route('index') }}" class="text-decoration-none text-secondary">
                <i class="bi bi-arrow-left-circle me-1"></i>
                Back to Articles
            </a>
        </div>
    </div>
</section>

@endsection
