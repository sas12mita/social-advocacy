@extends('backend.layout.main')
@push('title', 'Event Registrations')
@section('content')

<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="fw-bold">
            Event Registrations — 
            <span class="text-primary">{{ $event->title ?? 'Unknown Event' }}</span>
        </h4>
        <a href="{{ route('events.index') }}" class="btn btn-secondary">← Back to Events</a>
    </div>

    <div class="card">
        <div class="card-header">
            <h5 class="mb-0">Registered Participants</h5>
        </div>

        <div class="card-body">
            @if($registrations->isEmpty())
                <p class="text-muted mb-0">No one has registered for this event yet.</p>
            @else
                <div class="table-responsive">
                    <table class="table table-bordered align-middle">
                        <thead class="table-light">
                            <tr>
                                <th width="5%">SN</th>
                                <th>Full Name</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th>Address</th>
                                <th>Registered At</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($registrations as $r)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $r->name }}</td>
                                    <td>{{ $r->email }}</td>
                                    <td>{{ $r->phone }}</td>
                                    <td>{{ $r->address }}</td>
                                    <td>{{ \Carbon\Carbon::parse($r->created_at)->format('Y-m-d H:i') }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </div>
</div>

@endsection
