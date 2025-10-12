@extends('backend.layout.main')
@push('title', 'Events Management')
@section('content')

<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="fw-bold">Our Events</h4>
        <a href="{{ route('events.create') }}" class="btn btn-primary">Add New Event</a>
    </div>

    <div class="card">
        <div class="card-header">
            <h5 class="mb-0">All Events</h5>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered align-middle">
                    <thead>
                        <tr>
                            <th width="5%">SN</th>
                            <th>Title</th>
                            <th>Image</th>
                            <th>Price</th>
                            <th>Deadline</th>
                            <th>Status</th>
                            <th>Created At</th>
                            <th width="15%">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($events as $event)
                        <tr>
                            <td>{{ ($events->currentPage() - 1) * $events->perPage() + $loop->iteration }}</td>
                            <td>
                                <div class="fw-semibold">{{ $event->title }}</div>
                                @if($event->nep_title)
                                    <div class="text-muted small">{{ $event->nep_title }}</div>
                                @endif
                            </td>
                            <td>
                                @if($event->image && file_exists(public_path('storage/' . $event->image)))
                                    <img src="{{ asset('storage/' . $event->image) }}" width="60" height="60" style="object-fit: cover;" class="rounded">
                                @else
                                    <span class="text-muted">No image</span>
                                @endif
                            </td>
                            <td>{{ $event->price }}</td>
                            <td>{{ \Carbon\Carbon::parse($event->deadline)->format('Y-m-d') }}</td>
                            <td>
                                <span class="badge bg-{{ $event->publish_status ? 'success' : 'warning' }}">
                                    {{ $event->publish_status ? 'Published' : 'Unpublished' }}
                                </span>
                            </td>
                            <td>{{ $event->created_at->format('Y-m-d') }}</td>
                            <td>
                                <div class="dropdown position-relative">
                                    <button class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                                        <i class="bx bx-dots-vertical-rounded"></i>
                                    </button>
                                    <div class="dropdown-menu">
                                        <a class="dropdown-item" href="{{ route('events.edit', $event->id) }}">
                                            <i class="bx bx-edit-alt me-1"></i> Edit
                                        </a>

                                        <form action="{{ route('events.destroy', $event->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="dropdown-item text-danger">
                                                <i class="bx bx-trash me-1"></i> Delete
                                            </button>
                                        </form>

                                        <form action="{{ route('events.statusupdate', $event->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            <button type="submit" class="dropdown-item text-{{ $event->publish_status ? 'danger' : 'success' }}">
                                                <i class="bx bx-sync me-1"></i>
                                                {{ $event->publish_status ? 'Unpublish' : 'Publish' }}
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="d-flex justify-content-end mt-4">
                {{ $events->links() }}
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Delete confirmation
    const deleteForms = document.querySelectorAll('form[action*="/events/"]');
    deleteForms.forEach(form => {
        form.addEventListener('submit', function(e) {
            if (!confirm('Are you sure you want to delete this event?')) {
                e.preventDefault();
            }
        });
    });
});
</script>

@endsection
