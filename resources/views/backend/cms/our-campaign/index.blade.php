@extends('backend.layout.main')
@push('title', 'Campaigns Management')
@section('content')
<div class="card">
    <div class="card-header">
        <h5 class="mb-0">All Campaigns</h5>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th width="5%">SN</th>
                        <th>Title</th>
                        <th>Nepali Title</th>
                        <th>Description</th>
                        <th>Nepali Description</th>
                        <th>Image</th>
                        <th>Campaign Date</th>
                        <th>Status</th>
                        <th>Created At</th>
                        <th width="15%">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($our_campaigns as $campaign)
                    <tr>
                        <td>{{ ($our_campaigns->currentPage() - 1) * $our_campaigns->perPage() + $loop->iteration }}</td>
                        <td>{{ $campaign->title ?? '—' }}</td>
                        <td>{{ $campaign->nep_title ?? '—' }}</td>
                        <td>{{ Str::limit($campaign->description, 50) }}</td>
                        <td>{{ Str::limit($campaign->nep_description, 50) }}</td>
                        <td>
                            @if($campaign->image)
                                <img src="{{ asset('storage'.$campaign->image) }}" width="50" height="50" style="object-fit: cover;" class="rounded">
                            @else
                                <span class="text-muted">No image</span>
                            @endif
                        </td>
                        <td>{{ $campaign->campaigns_date }}</td>
                        <td>
                            <span class="badge bg-{{ $campaign->publish_status ? 'success' : 'warning' }}">
                                {{ $campaign->publish_status ? 'Published' : 'Unpublished' }}
                            </span>
                        </td>
                        <td>{{ $campaign->created_at->format('Y-m-d') }}</td>
                        <td>
                            <div class="dropdown position-relative">
                                <button class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                                    <i class="bx bx-dots-vertical-rounded"></i>
                                </button>
                                <div class="dropdown-menu">
                                    <a class="dropdown-item" href="{{ route('campaigns.edit', $campaign->id) }}">
                                        <i class="bx bx-edit-alt me-1"></i> Edit
                                    </a>
                                    <!-- Delete button triggers modal -->
                                    <button type="button" class="dropdown-item text-danger" 
                                            data-bs-toggle="modal" 
                                            data-bs-target="#deleteModal" 
                                            data-id="{{ $campaign->id }}">
                                        <i class="bx bx-trash me-1"></i> Delete
                                    </button>
                                    <form action="{{ route('campaigns.statusupdate', $campaign->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        <button type="submit" class="dropdown-item text-{{ $campaign->publish_status ? 'danger' : 'success' }}">
                                            <i class="bx bx-sync me-1"></i>
                                            {{ $campaign->publish_status ? 'Unpublish' : 'Publish' }}
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
            {{ $our_campaigns->links() }}
        </div>
    </div>
</div>

<!-- Bootstrap Delete Confirmation Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <form id="deleteForm" method="POST">
          @csrf
          @method('DELETE')
          <div class="modal-header">
              <h5 class="modal-title" id="deleteModalLabel">Confirm Delete</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
              Are you sure you want to delete this campaign?
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
    // Capture campaign ID and set form action dynamically
    var deleteModal = document.getElementById('deleteModal');
    deleteModal.addEventListener('show.bs.modal', function (event) {
        var button = event.relatedTarget; 
        var campaignId = button.getAttribute('data-id'); 
        var form = document.getElementById('deleteForm');
        form.action = '/campaigns/' + campaignId; // update delete route dynamically
    });
</script>
@endpush
