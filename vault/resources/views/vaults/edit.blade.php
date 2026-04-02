@extends('layouts.app')

@section('title', 'Edit Vault')

@section('content')
<div style="max-width: 560px;" class="mx-auto">
    <h1 class="h3 mb-4">Edit Vault</h1>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0 small">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('vaults.update', $vault) }}" class="card shadow-sm">
        @csrf
        @method('PUT')
        <div class="card-body">
            <div class="mb-3">
                <label for="name" class="form-label small fw-semibold">Name <span class="text-danger">*</span></label>
                <input type="text" name="name" id="name" class="form-control" value="{{ old('name', $vault->name) }}" required maxlength="255" autofocus>
            </div>
            <div class="mb-3">
                <label for="description" class="form-label small fw-semibold">Description</label>
                <textarea name="description" id="description" class="form-control" rows="3">{{ old('description', $vault->description) }}</textarea>
            </div>
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="icon" class="form-label small fw-semibold">Icon</label>
                    <input type="text" name="icon" id="icon" class="form-control" value="{{ old('icon', $vault->icon) }}" maxlength="50" placeholder="e.g. emoji">
                </div>
                <div class="col-md-6 mb-3">
                    <label for="color" class="form-label small fw-semibold">Color</label>
                    <input type="color" name="color" id="color" class="form-control form-control-color w-100" value="{{ old('color', $vault->color ?? '#3366cc') }}">
                </div>
            </div>
        </div>
        <div class="card-footer bg-white d-flex gap-2 justify-content-end">
            <a href="{{ route('vaults.show', $vault) }}" class="btn btn-outline-secondary">Cancel</a>
            <button type="submit" class="btn btn-primary"><i class="bi bi-check-lg me-1"></i>Save Changes</button>
        </div>
    </form>
</div>
@endsection
