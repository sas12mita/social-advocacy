@extends('backend.layout.main')
@push('title', 'Volunteer Applications')
@section('content')
<div class="card">
    <div class="card-header">
        <h5 class="mb-0">Volunteer Applications</h5>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th width="5%">SN</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Address</th>
                        <th>Motivation</th>
                        <th>Status</th>
                        <th>Created At</th>
                        <th width="15%">Actions</th>
                    </tr>
                </thead>
                <tbody>
                @foreach($volunteers as $volunteer)
                    <tr>
                        <td>{{ ($volunteers->currentPage() - 1) * $volunteers->perPage() + $loop->iteration }}</td>
                        <td>{{ $volunteer->name }}</td>
                        <td>{{ $volunteer->email }}</td>
                        <td>{{ $volunteer->phone ?? '—' }}</td>
                        <td>{{ Str::limit($volunteer->address, 30) }}</td>
                        <td>{{ Str::limit($volunteer->motivation, 50) }}</td>
                        <td>
                            <span class="badge bg-{{ $volunteer->approved ? 'success':'warning' }}">
                                {{ $volunteer->approved ? 'Approved':'Pending' }}
                            </span>
                        </td>
                        <td>{{ $volunteer->created_at->format('Y-m-d') }}</td>
                        <td>
                            <div class="dropdown position-relative">
                                <button class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                                    <i class="bx bx-dots-vertical-rounded"></i>
                                </button>
                                <div class="dropdown-menu">
                                    
                                    <!-- Approve / Unapprove -->
                                    <form action="{{ route('volunteer-applications.approved', $volunteer->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        <button class="dropdown-item text-{{ $volunteer->approved ? 'danger' : 'success' }}">
                                            <i class="bx bx-check me-1"></i>
                                            {{ $volunteer->approved ? 'Unapprove' : 'Approve' }}
                                        </button>
                                    </form>

                                    <!-- delete button trigger modal -->
                                    <button type="button" class="dropdown-item text-danger"
                                            data-bs-toggle="modal"
                                            data-bs-target="#deleteModal"
                                            data-id="{{ $volunteer->id }}">
                                        <i class="bx bx-trash me-1"></i> Delete
                                    </button>

                                </div>
                            </div>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>

        <div class="d-flex justify-content-end mt-4">
            {{ $volunteers->links() }}
        </div>
    </div>
</div>


<!-- Delete Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
        <form id="deleteForm" method="POST">
            @csrf
            @method('DELETE')
            <div class="modal-header">
                <h5 class="modal-title">Confirm Delete</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                Are you sure you want to delete this application?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="submit" class="btn btn-danger">Delete</button>
            </div>
        </form>
    </div>
  </div>
</div>
@endsection


@push('scripts')
<script>
var deleteModal = document.getElementById('deleteModal');
deleteModal.addEventListener('show.bs.modal', function(event){
    var button = event.relatedTarget;
    var id = button.getAttribute('data-id');
    var form = document.getElementById('deleteForm');
    form.action = '/admin/volunteer-applications/' + id;
});
</script>
@endpush
