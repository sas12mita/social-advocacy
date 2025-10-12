{{-- resources/views/backend/cms/our-event/edit.blade.php --}}
@extends('backend.layout.main')
@push('title', 'Edit Event')
@section('content')
<link href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.13/cropper.min.css" rel="stylesheet" />

<!-- Modal for cropping -->
<div class="modal fade" id="cropperModal" tabindex="-1" aria-labelledby="cropperModalLabel"
    aria-hidden="true" data-bs-backdrop="static">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Crop Image</h5>
            </div>
            <div class="modal-body text-center">
                <img id="cropImage" class="img-fluid w-100" />
            </div>
            <div class="modal-footer">
                <button id="cropBtn" type="button" class="btn btn-success">Crop & Save</button>
                <button id="skipBtn" type="button" class="btn btn-secondary">Skip</button>
            </div>
        </div>
    </div>
</div>

<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="fw-bold">Edit Event</h4>
        <a href="{{ route('events.index') }}" class="btn btn-secondary">Back</a>
    </div>

    <div class="card">
        <div class="card-body">
            <form method="POST" action="{{ route('events.update', $OurEvent->id) }}" enctype="multipart/form-data" id="eventForm">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label class="form-label">Title (English)</label>
                    <input type="text" name="title" class="form-control" 
                        value="{{ old('title', $OurEvent->title) }}">
                    @error('title') <div class="text-danger">{{ $message }}</div> @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Title (Nepali)</label>
                    <input type="text" name="nep_title" class="form-control" 
                        value="{{ old('nep_title', $OurEvent->nep_title) }}">
                    @error('nep_title') <div class="text-danger">{{ $message }}</div> @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Description (English)</label>
                    <textarea name="description" class="form-control" rows="5">{{ old('description', $OurEvent->description) }}</textarea>
                    @error('description') <div class="text-danger">{{ $message }}</div> @enderror
                </div>
                <div class="mb-3">
                    <label class="form-label">Description (Nepali)</label>
                    <textarea name="nep_description" class="form-control" rows="5">{{ old('nep_description', $OurEvent->nep_description) }}</textarea>
                    @error('nep_description') <div class="text-danger">{{ $message }}</div> @enderror
                </div>

                <div class="mb-3">
                    <label for="deadline" class="form-label">Deadline</label>
                    <input type="date" name="deadline" id="deadline"
                        class="form-control" value="{{ old('deadline', $OurEvent->deadline) }}" required>
                    @error('deadline')
                    <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Price</label>
                    <input type="text" name="price" class="form-control" 
                        value="{{ old('price', $OurEvent->price) }}">
                    @error('price') <div class="text-danger">{{ $message }}</div> @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Image *</label>
                    <input type="file" name="image" class="form-control" accept="image/*" id="imageUpload">
                    <small class="text-muted">Allowed formats: JPEG, PNG, JPG, GIF. Max size: 2MB</small>
                    <div id="fileSizeError" class="text-danger d-none"></div>

                    <!-- Current Image -->
                    @if ($OurEvent->image)
                        <div class="mt-3">
                            <p class="fw-bold">Current Image:</p>
                            <img src="{{ asset('storage/'.$OurEvent->image) }}" class="img-thumbnail w-25 h-auto" alt="Event Image">
                        </div>
                    @endif

                    <!-- Cropped preview -->
                    <div id="croppedPreviewContainer" class="mt-3"></div>
                    @error('image') <div class="text-danger">{{ $message }}</div> @enderror
                </div>

                <button type="submit" class="btn btn-primary">Update Event</button>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.13/cropper.min.js"></script>
<script>
    let selectedFile = null;
    let croppedFile = null;
    let cropper;
    const cropImage = document.getElementById('cropImage');
    const modalElement = document.getElementById('cropperModal');
    const modal = new bootstrap.Modal(modalElement);
    const previewContainer = document.getElementById('croppedPreviewContainer');
    const MAX_FILE_SIZE = 2 * 1024 * 1024; // 2MB

    document.getElementById('imageUpload').addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (!file) return;

        if (file.size > MAX_FILE_SIZE) {
            alert("File size exceeds 2MB limit!");
            this.value = "";
            return;
        }

        selectedFile = file;
        const reader = new FileReader();
        reader.onload = function(e) {
            cropImage.src = e.target.result;
            cropImage.onload = () => {
                if (cropper) cropper.destroy();
                cropper = new Cropper(cropImage, {
                    aspectRatio: 4 / 3,
                    viewMode: 1,
                    autoCropArea: 1,
                    responsive: true,
                });
                modal.show();
            };
        };
        reader.readAsDataURL(file);
    });

    document.getElementById('cropBtn').addEventListener('click', function() {
        if (!cropper) return;
        cropper.getCroppedCanvas().toBlob((blob) => {
            croppedFile = new File([blob], selectedFile.name, { type: 'image/jpeg' });
            showPreview(croppedFile);
            updateFileInput(croppedFile);
            modal.hide();
        }, 'image/jpeg');
    });

    document.getElementById('skipBtn').addEventListener('click', function() {
        croppedFile = selectedFile;
        showPreview(croppedFile);
        updateFileInput(croppedFile);
        modal.hide();
    });

    function showPreview(file) {
        previewContainer.innerHTML = "";
        const img = document.createElement('img');
        img.src = URL.createObjectURL(file);
        img.className = "img-thumbnail w-25 h-auto";
        previewContainer.appendChild(img);
    }

    function updateFileInput(file) {
        const dataTransfer = new DataTransfer();
        dataTransfer.items.add(file);
        document.getElementById('imageUpload').files = dataTransfer.files;
    }

    modalElement.addEventListener('hidden.bs.modal', function() {
        if (cropper) {
            cropper.destroy();
            cropper = null;
        }
    });
</script>
@endpush
