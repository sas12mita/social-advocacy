{{-- resources/views/backend/cms/articles/create.blade.php --}}
@extends('backend.layout.main')
@push('title', 'Create Article')
@section('content')
<link href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.13/cropper.min.css" rel="stylesheet" />
<link href="https://cdn.jsdelivr.net/npm/summernote@0.8.20/dist/summernote-lite.min.css" rel="stylesheet">

<!-- Modal for cropping -->
<div class="modal fade" id="cropperModal" tabindex="-1" aria-labelledby="cropperModalLabel"
    aria-hidden="true" data-bs-backdrop="static">
    <div class="modal-dialog modal modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Crop Image</h5>
            </div>
            <div class="modal-body ">
                <div class="w-100 text-center">
                    <img id="cropImage" class="img-fluid w-100" />
                </div>
            </div>
            <div class="modal-footer">
                <button id="cropBtn" type="button" class="btn btn-success">Crop & Next</button>
                <button id="skipBtn" type="button" class="btn btn-secondary">Skip</button>
            </div>
        </div>
    </div>
</div>

<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="fw-bold">Create New Article</h4>
        <a href="{{ route('articles.index') }}" class="btn btn-secondary">Back to Articles</a>
    </div>

    <div class="card">
        <div class="card-body">
            <form method="POST" action="{{ route('articles.store') }}" enctype="multipart/form-data" id="articleForm">
                @csrf

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label class="form-label">Heading (English) *</label>
                        <input type="text" name="heading" class="form-control" value="{{ old('heading') }}" required>
                        @error('heading')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Heading (Nepali)</label>
                        <input type="text" name="nep_heading" class="form-control" value="{{ old('nep_heading') }}">
                        @error('nep_heading')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label class="form-label">Category *</label>
                        <select name="category_id" class="form-select" required>
                            <option value="">Select Category</option>
                            @foreach ($categories as $category)
                            <option value="{{ $category->id }}"
                                {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                            @endforeach
                        </select>
                        @error('category_id')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label class="form-label">Images</label>
                        <input type="file" name="image[]" class="form-control" multiple accept="image/*"
                            id="imageUpload">
                        <small class="text-muted">Allowed formats: JPEG, PNG, JPG, GIF. Max size: 2MB each</small>
                        <div id="fileSizeError" class="text-danger d-none"></div>
                    <!-- Cropped preview thumbnails -->
                        <div id="croppedPreviewContainer" class="d-flex flex-wrap gap-3 mb-3 mt-3"></div>
                        @error('image.*')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label class="form-label">Content (English) *</label>
                        <textarea name="body" class="form-control" id="summernote" rows="10">{{ old('body') }}</textarea>
                        @error('body')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Content (Nepali)</label>
                        <textarea name="nep_body" class="form-control" id="summernote_nep" rows="10">{{ old('nep_body') }}</textarea>
                        @error('nep_body')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <button type="submit" class="btn btn-primary">Save Article</button>
            </form>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<!-- Load jQuery first -->
{{-- <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<!-- Then load Summernote -->
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.20/dist/summernote-lite.min.js"></script>
<!-- Then load CropperJS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.13/cropper.min.js"></script> --}}

<script>
    // Initialize Summernote
    // $(document).ready(function() {
    //     $('#summernote').summernote({
    //         placeholder: 'Write your content here...',
    //         height: 300,
    //         toolbar: [
    //             ['style', ['style']],
    //             ['font', ['bold', 'italic', 'underline', 'clear']],
    //             ['color', ['color']],
    //             ['para', ['ul', 'ol', 'paragraph']],
    //             ['table', ['table']],
    //             ['insert', ['link', 'picture', 'video']],
    //             ['view', ['fullscreen', 'codeview', 'help']]
    //         ]
    //     });
    // });
    let selectedFiles = [];
    let croppedFiles = [];
    let currentIndex = 0;
    let cropper;
    const cropImage = document.getElementById('cropImage');
    const modalElement = document.getElementById('cropperModal');
    const modal = new bootstrap.Modal(modalElement);
    const previewList = document.getElementById('croppedPreviewContainer');
    const MAX_FILE_SIZE = 2 * 1024 * 1024; // 2MB

    document.getElementById('imageUpload').addEventListener('change', function(e) {
        const files = Array.from(e.target.files);
        const validFiles = [];
        const invalidFiles = [];

        // Validate files
        files.forEach(file => {
            if (file.size > MAX_FILE_SIZE) {
                invalidFiles.push(file.name);
            } else {
                validFiles.push(file);
            }
        });

        if (invalidFiles.length > 0) {
            alert(`The following files exceed 2MB limit and won't be uploaded:\n${invalidFiles.join('\n')}`);
        }

        if (validFiles.length > 0) {
            // ✅ Merge new files instead of replacing
            selectedFiles = [...selectedFiles, ...validFiles];
            currentIndex = selectedFiles.length - validFiles.length;
            loadImageForCropping(currentIndex);
        }
    });

    function loadImageForCropping(index) {
        const file = selectedFiles[index];
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
    }

    document.getElementById('cropBtn').addEventListener('click', function() {
        if (!cropper) return;

        cropper.getCroppedCanvas().toBlob((blob) => {
            const originalName = selectedFiles[currentIndex].name;
            const croppedFile = new File([blob], originalName, {
                type: 'image/jpeg'
            });
            croppedFiles.push(croppedFile);
            createPreviewThumbnail(blob);

            currentIndex++;
            if (currentIndex < selectedFiles.length) {
                loadImageForCropping(currentIndex);
            } else {
                updateFileInput();
                modal.hide();
            }
        }, 'image/jpeg');
    });

    document.getElementById('skipBtn').addEventListener('click', function() {
        croppedFiles.push(selectedFiles[currentIndex]);
        createPreviewThumbnail(selectedFiles[currentIndex]);

        currentIndex++;
        if (currentIndex < selectedFiles.length) {
            loadImageForCropping(currentIndex);
        } else {
            updateFileInput();
            modal.hide();
        }
    });

    function createPreviewThumbnail(fileOrBlob) {
        const wrapper = document.createElement('div');
        wrapper.className = 'position-relative d-inline-block me-2 mb-2';
        wrapper.style.width = '150px';

        const previewImg = document.createElement('img');
        previewImg.src = URL.createObjectURL(fileOrBlob);
        previewImg.className = 'img-thumbnail w-100 h-auto';

        const deleteBtn = document.createElement('button');
        deleteBtn.type = 'button';
        deleteBtn.className = 'btn btn-sm btn-danger position-absolute top-0 end-0 translate-middle p-0 rounded-circle';
        deleteBtn.innerHTML = '&times;';
        deleteBtn.style.width = '1.5rem';
        deleteBtn.style.height = '1.5rem';

        wrapper.appendChild(previewImg);
        wrapper.appendChild(deleteBtn);
        previewList.appendChild(wrapper);

        deleteBtn.addEventListener('click', () => {
            const index = Array.from(previewList.children).indexOf(wrapper);
            croppedFiles.splice(index, 1);
            selectedFiles.splice(index, 1);
            wrapper.remove();
            updateFileInput();
        });
    }

    function updateFileInput() {
        const dataTransfer = new DataTransfer();
        croppedFiles.forEach(file => dataTransfer.items.add(file));
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