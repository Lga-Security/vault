@extends('layouts.app')

@section('title', 'Edit Entry')

@section('content')
<div style="max-width: 560px;" class="mx-auto">
    <h1 class="h3 mb-4">Edit Password Entry</h1>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0 small">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('vaults.entries.update', [$vault, $entry]) }}" class="card shadow-sm">
        @csrf
        @method('PUT')
        <div class="card-body">
            <div class="mb-3">
                <label for="site_name" class="form-label small fw-semibold">Site / Service Name <span class="text-danger">*</span></label>
                <input type="text" name="site_name" id="site_name" class="form-control" value="{{ old('site_name', $entry->site_name) }}" required>
            </div>
            <div class="mb-3">
                <label for="category_id" class="form-label small fw-semibold">Category</label>
                <select name="category_id" id="category_id" class="form-select">
                    <option value="">— None —</option>
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}" {{ old('category_id', $entry->category_id) == $category->id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="mb-3">
                <label for="username" class="form-label small fw-semibold">Username / Email <span class="text-danger">*</span></label>
                <input type="text" name="username" id="username" class="form-control" value="{{ old('username', $entry->username) }}" required>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label small fw-semibold">Password <span class="text-danger">*</span></label>
                <input type="text" name="password" id="password" class="form-control font-monospace" value="{{ old('password', $entry->password) }}" required>
            </div>
            <div class="mb-3">
                <label for="notes" class="form-label small fw-semibold">Notes</label>
                <textarea name="notes" id="notes" class="form-control" rows="3">{{ old('notes', $entry->notes) }}</textarea>
            </div>
        </div>
        <div class="card-footer bg-white d-flex gap-2 justify-content-end">
            <a href="{{ route('vaults.show', $vault) }}" class="btn btn-outline-secondary">Cancel</a>
            <button type="submit" class="btn btn-primary"><i class="bi bi-check-lg me-1"></i>Save Changes</button>
        </div>
    </form>
</div>
@endsection
