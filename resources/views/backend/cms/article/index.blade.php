{{-- resources/views/backend/cms/articles/index.blade.php --}}
@extends('backend.layout.main')
@push('title', 'Articles Management')
@section('content')

<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="fw-bold">Articles</h4>
        <a href="{{ route('articles.create') }}" class="btn btn-primary">Add New Article</a>
    </div>
    
    {{-- <!-- Quick Edit Modal -->
    <div class="modal fade" id="editArticleModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <form id="quickEditForm" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="modal-header">
                        <h5 class="modal-title">Quick Edit Article</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">Heading (English)*</label>
                            <input type="text" name="heading" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Heading (Nepali)</label>
                            <input type="text" name="nep_heading" class="form-control">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Category*</label>
                            <select name="article_category_id" class="form-select" required>
                                @foreach($categories as $category)
                                <option value="{{ $category->id }}">
                                    {{ $category->name }}
                                </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Body (English)*</label>
                            <textarea name="body" class="form-control" rows="4"></textarea>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Body (Nepali)</label>
                            <textarea name="nep_body" class="form-control" rows="4"></textarea>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Status</label>
                            <select name="publish_status" class="form-select">
                                <option value="1">Published</option>
                                <option value="0">Draft</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div> --}}

    <div class="card">
        <div class="card-header">
            <h5 class="mb-0">All Articles</h5>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th width="5%">SN</th>
                            <th>Heading</th>
                            <th>Category</th>
                            <th>Images</th>
                            <th>Status</th>
                            <th>Views</th>
                            <th>Created At</th>
                            <th width="15%">Actions</th>
                        </tr>g
                    </thead>
                    <tbody>
                        @foreach($articles as $article)
                        <tr>
                            <td>{{ ($articles->currentPage() - 1) * $articles->perPage() + $loop->iteration }}</td>
                            <td>{{ $article->heading }}</td>
                            <td>{{ $article->category->name }}</td>
                            <td>
                                @php
                                $images = json_decode($article->image, true); // Decode the JSON string to array
                                @endphp

                                @if($images && count($images) > 0)
                                <div class="d-flex" style="gap: 5px;">
                                    @foreach(array_slice($images, 0, 3) as $image)
                                    <img src="{{ asset('storage/'.$image) }}" width="50" height="50" style="object-fit: cover;" class="rounded">
                                    @endforeach
                                    @if(count($images) > 3)
                                    <div class="bg-light d-flex align-items-center justify-content-center rounded" style="width:50px;height:50px;">
                                        +{{ count($images) - 3 }}
                                    </div>
                                    @endif
                                </div>
                                @else
                                <span class="text-muted">No images</span>
                                @endif

                            </td>
                            <td>
                                <span class="badge bg-{{ $article->publish_status ? 'success' : 'warning' }}">
                                    {{ $article->publish_status ? 'Published' : 'Unpublished' }}
                                </span>
                            </td>
                            <td>{{ $article->views }}</td>
                            <td>{{ $article->created_at->format('Y-m-d') }}</td>
                            <td>
                                <div class="dropdown position-relative">
                                    <button class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                                        <i class="bx bx-dots-vertical-rounded"></i>
                                    </button>
                                    <div class="dropdown-menu">
                                        <a class="dropdown-item" href="{{ route('articles.edit', $article->id) }}">
                                            <i class="bx bx-edit-alt me-1"></i> Edit
                                        </a>
                                        <form action="{{ route('articles.destroy', $article->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="dropdown-item text-danger">
                                                <i class="bx bx-trash me-1"></i> Delete
                                            </button>
                                        </form>
                                        <form action="{{ route('articles.statusupdate', $article->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            <button type="submit" class="dropdown-item text-{{ $article->publish_status ? 'danger' : 'success' }}">
                                                <i class="bx bx-sync me-1"></i>
                                                {{ $article->publish_status ? 'Unpublish' : 'Publish' }}
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
                {{ $articles->links() }}
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Delete confirmation
        const deleteForms = document.querySelectorAll('form[action*="/articles/"]');
        deleteForms.forEach(form => {
            form.addEventListener('submit', function(e) {
                if (!confirm('Are you sure you want to delete this article?')) {
                    e.preventDefault();
                }
            });
        });
    });
</script>
@endsection