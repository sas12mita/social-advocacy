{{-- resources/views/backend/cms/articles/edit.blade.php --}}
@extends('backend.layout.main')
@push('title', 'Edit Article')
@section('content')
    
    <link href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.13/cropper.min.css" rel="stylesheet" />
    <!-- Modal for cropping -->

    <div class="modal fade" id="cropperModal" tabindex="-1"  aria-labelledby="cropperModalLabel"
        aria-hidden="true" data-bs-backdrop="static">
        <div class="modal-dialog modal modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Crop Image</h5>
                    {{-- <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"
                        id="closeModalBtn"></button> --}}
                </div>
                <div class="modal-body ">
                    <div class="w-100 text-center">
                        <img id="cropImage" class="img-fluid w-100" />
                    </div>

                </div>
                <div class="modal-footer">
                    <button id="cropBtn" type="button" class="btn btn-success">Crop & Next</button>
                </div>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h4 class="fw-bold">Edit Article</h4>
            <a href="{{ route('articles.index') }}" class="btn btn-secondary">Back to Articles</a>
        </div>

        <div class="card">
            <div class="card-body">
                <form method="POST" action="{{ route('articles.update', $article->id) }}" enctype="multipart/form-data"
                    id="articleForm">
                    @csrf
                    @method('PUT')

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label">Heading (English) *</label>
                            <input type="text" name="heading" class="form-control"
                                value="{{ old('heading', $article->heading) }}" required>
                            @error('heading')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Category *</label>
                            <select name="article_category_id" class="form-select" required>
                                <option value="">Select Category</option>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}"
                                        {{ old('article_category_id', $article->article_category_id) == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('article_category_id')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label">Heading (Nepali)</label>
                            <input type="text" name="nep_heading" class="form-control"
                                value="{{ old('nep_heading', $article->nep_heading) }}">
                            @error('nep_heading')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label">Images</label>
                            <input type="file" name="images[]" class="form-control" multiple accept="image/*"
                                id="imageUpload">
                            <small class="text-muted">Allowed formats: JPEG, PNG, JPG, GIF. Max size: 2MB each</small>
                            <div id="fileSizeError" class="text-danger d-none"></div>

                            <!-- Existing Images -->
                            <div class="row mt-3" id="existingImages">
                                @if ($article->images && count($article->images) > 0)
                                    @foreach ($article->images as $image)
                                        <div class="col-md-3 col-6 mb-3 existing-image" data-path="{{ $image }}">
                                            <div class="position-relative">
                                                <img src="{{ asset('storage/' . $image) }}" class="img-thumbnail"
                                                    style="height:120px;width:100%;object-fit:cover;">
                                                <button type="button"
                                                    class="btn btn-danger btn-sm position-absolute top-0 end-0 m-1"
                                                    onclick="removeExistingImage(this, '{{ $image }}')"
                                                    style="padding:0.15rem 0.3rem;">
                                                    ×
                                                </button>
                                            </div>
                                        </div>
                                    @endforeach
                                @endif
                            </div>

                            <!-- New Image Previews -->
                            <div id="croppedPreviewContainer" class="d-flex flex-wrap gap-3 mb-3"></div>

                            @error('images.*')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Content (English) *</label>
                            <textarea name="body" class="form-control" id="summernote" rows="10" required>{{ old('body', $article->body) }}</textarea>
                            @error('body')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="row mb-3">
                        <div class="col-md-12">
                            <label class="form-label">Content (Nepali)</label>
                            <textarea name="nep_body" class="form-control" id="summernote_nep" rows="10">{{ old('nep_body', $article->nep_body) }}</textarea>
                            @error('nep_body')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary">Update Article</button>
                </form>
            </div>
        </div>
    </div>

    <!-- Summernote and jQuery -->
    {{-- <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.20/dist/summernote-lite.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.20/dist/summernote-lite.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.13/cropper.min.js"></script> --}}
     <script>
        
        // $('#summernote').summernote({
        //     placeholder: 'Write your content here...',
        //     height: 200,
        //     toolbar: [
        //         ['style', ['style']],
        //         ['font', ['bold', 'underline', 'clear']],
        //         ['color', ['color']],
        //         ['para', ['ul', 'ol', 'paragraph']],
        //         ['table', ['table']],
        //         ['insert', ['link', 'picture', 'video']],
        //         ['view', ['fullscreen', 'codeview', 'help']]
        //     ]
        // });
        
        // $('#summernote_nep').summernote({
        //     placeholder: 'Write your Nepali content here...',
        //     height: 200,
        //     toolbar: [
        //         ['style', ['style']],
        //         ['font', ['bold', 'underline', 'clear']],
        //         ['color', ['color']],
        //         ['para', ['ul', 'ol', 'paragraph']],
        //         ['table', ['table']],
        //         ['insert', ['link', 'picture', 'video']],
        //         ['view', ['fullscreen', 'codeview', 'help']]
        //     ]
        // }); 
        let removedExistingImages = [];
        // let selectedFiles = [];
    
        

        // document.getElementById('imageUpload').addEventListener('change', function() {
        //     const errorElement = document.getElementById('fileSizeError');
        //     errorElement.classList.add('d-none');

        //     if (this.files) {
        //         const validFiles = Array.from(this.files).filter(file => file.size <= maxFileSize);

        //         if (validFiles.length !== this.files.length) {
        //             errorElement.textContent = 'Some files exceed the 2MB limit';
        //             errorElement.classList.remove('d-none');
        //         }

        //         validFiles.forEach(file => {
        //             if (!selectedFiles.some(f => f.name === file.name && f.size === file.size && f
        //                     .lastModified === file.lastModified)) {
        //                 selectedFiles.push(file);
        //             }
        //         });

        //         updateNewImagePreview();
        //         updateFileInput();
        //     }
        // });

        // function updateNewImagePreview() {
        //     const preview = document.getElementById('newImagePreview');
        //     preview.innerHTML = '';

        //     selectedFiles.forEach((file, index) => {
        //         const reader = new FileReader();
        //         reader.onload = function(e) {
        //             const col = document.createElement('div');
        //             col.className = 'col-md-3 col-6 mb-3';
        //             col.innerHTML = `
        //             <div class="position-relative">
        //                 <img src="${e.target.result}" class="img-thumbnail" style="height:120px;width:100%;object-fit:cover;">
        //                 <button type="button" class="btn btn-danger btn-sm position-absolute top-0 end-0 m-1" 
        //                         onclick="removeNewImage(${index})" style="padding:0.15rem 0.3rem;">
        //                     ×
        //                 </button>
        //             </div>
        //         `;
        //             preview.appendChild(col);
        //         };
        //         reader.readAsDataURL(file);
        //     });
        // }

        // function updateFileInput() {
        //     const dataTransfer = new DataTransfer();
        //     selectedFiles.forEach(file => dataTransfer.items.add(file));
        //     document.getElementById('imageUpload').files = dataTransfer.files;
        // }

        function removeNewImage(index) {
            selectedFiles.splice(index, 1);
            updateNewImagePreview();
            updateFileInput();
        }

        function removeExistingImage(button, imagePath) {
            
            removedExistingImages.push(imagePath);

            const input = document.createElement('input');
            input.type = 'hidden';
            input.name = 'removed_images[]';
            input.value = imagePath;
            document.getElementById('articleForm').appendChild(input);
            button.closest('.existing-image').remove();
        }
    </script>
    

@endsection


@push('scripts')
    <script>
        let selectedFiles = [];
        let croppedFiles = [];
        let currentIndex = 0;
        let cropper;
        const cropImage = document.getElementById('cropImage');
        const modalElement = document.getElementById('cropperModal');
        const modal = new bootstrap.Modal(modalElement);
        const previewList = document.getElementById('croppedPreviewContainer');

        // Image input
        document.getElementById('imageUpload').addEventListener('change', function(e) {
            selectedFiles = Array.from(e.target.files);
            croppedFiles = [];
            currentIndex = 0;
            previewList.innerHTML = '';

            if (selectedFiles.length > 0) {
                loadImageForCropping(currentIndex);
            }
        });

        function loadImageForCropping(index) {
            const file = selectedFiles[index];
            const reader = new FileReader();

            reader.onload = function(e) {
                cropImage.src = e.target.result;

                // Wait for image to load before showing modal
                cropImage.onload = () => {
                    if (cropper) cropper.destroy();

                    cropper = new Cropper(cropImage, {
                        aspectRatio: 4 / 3, // Allow any aspect ratio
                        viewMode: 2,
                        autoCropArea: 1,
                        responsive: true,
                        ready() {
                            cropper.reset();
                            cropper.crop();
                        }

                    });

                    modal.show();
                };
            };
            setTimeout(() => window.dispatchEvent(new Event('resize')), 300);
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

                // Optional: show preview
                const wrapper = document.createElement('div');
                wrapper.className = 'position-relative d-inline-block me-2 mb-2';

                const previewImg = document.createElement('img');
                previewImg.src = URL.createObjectURL(blob);
                previewImg.className = 'img-thumbnail';
                previewImg.style.maxWidth = '150px';

                // Delete button (Bootstrap 5 styling)
                const deleteBtn = document.createElement('button');
                deleteBtn.type = 'button';
                deleteBtn.className =
                    'btn btn-sm btn-danger position-absolute top-0 end-0 translate-middle p-0 rounded-circle';
                deleteBtn.innerHTML = '<span aria-hidden="true">&times;</span>';
                deleteBtn.style.width = '1.5rem';
                deleteBtn.style.height = '1.5rem';
                deleteBtn.style.fontSize = '1rem';
                deleteBtn.style.lineHeight = '1rem';

                // Append elements
                wrapper.appendChild(previewImg);
                wrapper.appendChild(deleteBtn);
                previewList.appendChild(wrapper);

                // Remove logic
                deleteBtn.addEventListener('click', () => {
                    const index = Array.from(previewList.children).indexOf(wrapper);
                    croppedFiles.splice(index, 1); // Remove from array
                    wrapper.remove();

                    // Clear file input if no images left
                    if (croppedFiles.length === 0) {
                        document.getElementById('imageUpload').value = '';
                        return;
                    }

                    // Update file input
                    const dataTransfer = new DataTransfer();
                    croppedFiles.forEach(file => dataTransfer.items.add(file));
                    document.getElementById('imageUpload').files = dataTransfer.files;
                });


                cropper.destroy();
                cropper = null;
                modal.hide();

                currentIndex++;
                if (currentIndex < selectedFiles.length) {
                    setTimeout(() => loadImageForCropping(currentIndex), 300);
                }
            }, 'image/jpeg');
        });
    </script>
@endpush
