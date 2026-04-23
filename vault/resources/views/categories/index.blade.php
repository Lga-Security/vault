@extends('layouts.app')

@section('title', 'Categories')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h1 class="h3 mb-1">Categories</h1>
        <p class="text-muted mb-0 small">Organise your password entries with categories.</p>
    </div>
    <button class="btn btn-primary" type="button" data-bs-toggle="collapse" data-bs-target="#createCategoryForm">
        <i class="bi bi-plus-lg me-1"></i>New Category
    </button>
</div>

{{-- Create form --}}
<div class="collapse mb-4 {{ $errors->any() ? 'show' : '' }}" id="createCategoryForm">
    <div class="card shadow-sm">
        <div class="card-header bg-white">
            <h2 class="h6 mb-0"><i class="bi bi-plus-circle me-1"></i>Create New Category</h2>
        </div>
        <form method="POST" action="{{ route('categories.store') }}">
            @csrf
            <div class="card-body">
                <div class="row g-3">
                    <div class="col-md-6">
                        <label for="name" class="form-label small fw-semibold">
                            Name <span class="text-danger">*</span>
                        </label>
                        <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror"
                               value="{{ old('name') }}" required maxlength="255" autofocus
                               placeholder="e.g. Work, Social Media…">
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-6">
                        <label for="icon" class="form-label small fw-semibold">Icon <span class="text-muted">(emoji)</span></label>
                        <input type="text" name="icon" id="icon" class="form-control @error('icon') is-invalid @enderror"
                               value="{{ old('icon') }}" maxlength="50" placeholder="e.g. 🔑 🏢 💳">
                        @error('icon')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>
            <div class="card-footer bg-white d-flex gap-2 justify-content-end">
                <button type="button" class="btn btn-outline-secondary"
                        data-bs-toggle="collapse" data-bs-target="#createCategoryForm">Cancel</button>
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-plus-lg me-1"></i>Create Category
                </button>
            </div>
        </form>
    </div>
</div>

<div class="row g-4">
    {{-- Custom Categories --}}
    <div class="col-lg-8">
        <div class="card shadow-sm">
            <div class="card-header bg-white">
                <h2 class="h6 mb-0"><i class="bi bi-person-circle me-1"></i>Your Categories</h2>
            </div>

            @if ($customCategories->isEmpty())
                <div class="card-body text-center text-muted py-5">
                    <i class="bi bi-tags fs-1 d-block mb-2 opacity-25"></i>
                    <p class="mb-0">You haven't created any custom categories yet.</p>
                </div>
            @else
                <ul class="list-group list-group-flush">
                    @foreach ($customCategories as $category)
                        <li class="list-group-item" id="category-row-{{ $category->id }}">
                            {{-- Display row --}}
                            <div class="d-flex align-items-center gap-3" id="display-{{ $category->id }}">
                                @if ($category->icon)
                                    <span class="fs-5">{{ $category->icon }}</span>
                                @else
                                    <span class="text-muted"><i class="bi bi-tag"></i></span>
                                @endif
                                <span class="fw-semibold flex-grow-1">{{ $category->name }}</span>
                                <button type="button" class="btn btn-sm btn-outline-secondary"
                                        onclick="showEditForm({{ $category->id }})">
                                    <i class="bi bi-pencil"></i>
                                </button>
                                <form action="{{ route('categories.destroy', $category) }}" method="POST"
                                      class="d-inline"
                                      onsubmit="return confirm('Delete this category? Entries using it will become uncategorised.');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </div>

                            {{-- Inline edit form (hidden) --}}
                            <div class="d-none mt-3" id="edit-form-{{ $category->id }}">
                                <form method="POST" action="{{ route('categories.update', $category) }}">
                                    @csrf
                                    @method('PUT')
                                    <div class="row g-2 align-items-end">
                                        <div class="col-md-5">
                                            <label class="form-label small fw-semibold">Name</label>
                                            <input type="text" name="name" class="form-control form-control-sm"
                                                   value="{{ $category->name }}" required maxlength="255">
                                        </div>
                                        <div class="col-md-4">
                                            <label class="form-label small fw-semibold">Icon</label>
                                            <input type="text" name="icon" class="form-control form-control-sm"
                                                   value="{{ $category->icon }}" maxlength="50" placeholder="emoji">
                                        </div>
                                        <div class="col-md-3 d-flex gap-1">
                                            <button type="submit" class="btn btn-sm btn-primary flex-fill">
                                                <i class="bi bi-check-lg"></i> Save
                                            </button>
                                            <button type="button" class="btn btn-sm btn-outline-secondary"
                                                    onclick="hideEditForm({{ $category->id }})">
                                                <i class="bi bi-x"></i>
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </li>
                    @endforeach
                </ul>
            @endif
        </div>
    </div>

    {{-- Default Categories (read-only) --}}
    <div class="col-lg-4">
        <div class="card shadow-sm">
            <div class="card-header bg-white">
                <h2 class="h6 mb-0">
                    <i class="bi bi-shield-check me-1 text-success"></i>Default Categories
                </h2>
            </div>
            <div class="card-body">
                <p class="small text-muted mb-3">
                    These categories are provided by the system and cannot be edited or deleted.
                </p>
                <div class="d-flex flex-wrap gap-2">
                    @foreach ($defaultCategories as $category)
                        <span class="badge bg-light text-dark border px-3 py-2 fs-6">
                            @if ($category->icon)
                                {{ $category->icon }}
                            @else
                                <i class="bi bi-tag me-1"></i>
                            @endif
                            {{ $category->name }}
                        </span>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
function showEditForm(id) {
    document.getElementById('display-' + id).classList.add('d-none');
    document.getElementById('edit-form-' + id).classList.remove('d-none');
}

function hideEditForm(id) {
    document.getElementById('edit-form-' + id).classList.add('d-none');
    document.getElementById('display-' + id).classList.remove('d-none');
}
</script>
@endpush
