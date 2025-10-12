@extends('backend.layout.main')
@push('title', 'Create Event')
@section('content')
<link href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.13/cropper.min.css" rel="stylesheet" />
<link href="https://cdn.jsdelivr.net/npm/summernote@0.8.20/dist/summernote-lite.min.css" rel="stylesheet">

<!-- Cropper Modal -->
<div class="modal fade" id="cropperModal" tabindex="-1" aria-labelledby="cropperModalLabel" aria-hidden="true" data-bs-backdrop="static">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Crop Image</h5>
            </div>
            <div class="modal-body text-center">
                <img id="cropImage" class="img-fluid" />
            </div>
            <div class="modal-footer">
                <button id="cropBtn" type="button" class="btn btn-success">Crop & Use</button>
                <button id="cancelCropBtn" type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
            </div>
        </div>
    </div>
</div>

<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="fw-bold">Create New Event</h4>
        <a href="{{ route('events.index') }}" class="btn btn-secondary">Back to Events</a>
    </div>

    <div class="card">
        <div class="card-body">
            <form method="POST" action="{{ route('events.store') }}" enctype="multipart/form-data" id="eventForm">
                @csrf

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label class="form-label">Title (English) *</label>
                        <input type="text" name="title" class="form-control" value="{{ old('title') }}" required>
                        @error('title') <div class="text-danger">{{ $message }}</div> @enderror
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Title (Nepali)</label>
                        <input type="text" name="nep_title" class="form-control" value="{{ old('nep_title') }}">
                        @error('nep_title') <div class="text-danger">{{ $message }}</div> @enderror
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-4">
                        <label class="form-label">Deadline *</label>
                        <input type="date" name="deadline" class="form-control" value="{{ old('deadline') }}" required>
                        @error('deadline') <div class="text-danger">{{ $message }}</div> @enderror
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Price *</label>
                        <input type="text" name="price" class="form-control" value="{{ old('price') }}" required>
                        @error('price') <div class="text-danger">{{ $message }}</div> @enderror
                    </div>
                   
                </div>

                <div class="mb-3">
                    <label class="form-label">Event Image *</label>
                    <input type="file" name="image" class="form-control" id="imageUpload" accept="image/*" required>
                    <small class="text-muted">Allowed: JPG, JPEG, PNG. Max size: 2MB</small>
                    <div id="fileSizeError" class="text-danger d-none"></div>
                    <div id="croppedPreviewContainer" class="mt-3"></div>
                    @error('image') <div class="text-danger">{{ $message }}</div> @enderror
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label class="form-label">Description (English) *</label>
                        <textarea name="description" id="summernote" class="form-control" rows="6">{{ old('description') }}</textarea>
                        @error('description') <div class="text-danger">{{ $message }}</div> @enderror
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Description (Nepali)</label>
                        <textarea name="nep_description" id="summernote_nep" class="form-control" rows="6">{{ old('nep_description') }}</textarea>
                        @error('nep_description') <div class="text-danger">{{ $message }}</div> @enderror
                    </div>
                </div>

                <button type="submit" class="btn btn-primary">Save Event</button>
            </form>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.20/dist/summernote-lite.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.13/cropper.min.js"></script>

<script>
$(document).ready(function () {
    $('#summernote, #summernote_nep').summernote({
        height: 150
    });

    let cropper;
    const modal = new bootstrap.Modal(document.getElementById('cropperModal'));
    const cropImage = document.getElementById('cropImage');
    const imageUpload = document.getElementById('imageUpload');
    const croppedPreviewContainer = document.getElementById('croppedPreviewContainer');
    const fileSizeError = document.getElementById('fileSizeError');

    imageUpload.addEventListener('change', function (e) {
        const file = e.target.files[0];
        if (!file) return;

        if (file.size > 2 * 1024 * 1024) {
            fileSizeError.textContent = "Image size exceeds 2MB!";
            fileSizeError.classList.remove('d-none');
            e.target.value = "";
            return;
        } else {
            fileSizeError.classList.add('d-none');
        }

        const reader = new FileReader();
        reader.onload = function (event) {
            cropImage.src = event.target.result;
            modal.show();

            cropImage.onload = () => {
                if (cropper) cropper.destroy();
                cropper = new Cropper(cropImage, {
                    aspectRatio: 4 / 3,
                    viewMode: 1,
                    autoCropArea: 1,
                    responsive: true,
                });
            };
        };
        reader.readAsDataURL(file);
    });

    document.getElementById('cropBtn').addEventListener('click', function () {
        if (!cropper) return;

        cropper.getCroppedCanvas().toBlob((blob) => {
            const croppedFile = new File([blob], "cropped_image.jpg", { type: 'image/jpeg' });

            const dataTransfer = new DataTransfer();
            dataTransfer.items.add(croppedFile);
            imageUpload.files = dataTransfer.files;

            croppedPreviewContainer.innerHTML = '';
            const previewImg = document.createElement('img');
            previewImg.src = URL.createObjectURL(croppedFile);
            previewImg.className = 'img-thumbnail w-25';
            croppedPreviewContainer.appendChild(previewImg);

            modal.hide();
        }, 'image/jpeg');
    });
});
</script>
@endpush
