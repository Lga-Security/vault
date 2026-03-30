@extends('welcome')

@section('content')
<div class="container py-4" style="max-width: 560px;">
    <h1 class="h3 mb-4">New vault</h1>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('vaults.store') }}" class="card shadow-sm border-0">
        @csrf
        <div class="card-body">
            <div class="mb-3">
                <label for="name" class="form-label">Name <span class="text-danger">*</span></label>
                <input type="text" name="name" id="name" class="form-control" value="{{ old('name') }}" required maxlength="255" autofocus>
            </div>
            <div class="mb-3">
                <label for="description" class="form-label">Description</label>
                <textarea name="description" id="description" class="form-control" rows="3">{{ old('description') }}</textarea>
            </div>
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="icon" class="form-label">Icon</label>
                    <input type="text" name="icon" id="icon" class="form-control" value="{{ old('icon') }}" maxlength="50" placeholder="e.g. emoji or short text">
                </div>
                <div class="col-md-6 mb-3">
                    <label for="color" class="form-label">Color</label>
                    <input type="text" name="color" id="color" class="form-control" value="{{ old('color') }}" maxlength="7" placeholder="#3366cc">
                </div>
            </div>
        </div>
        <div class="card-footer bg-white border-0 d-flex gap-2 justify-content-end">
            <a href="{{ route('vaults.index') }}" class="btn btn-outline-secondary">Cancel</a>
            <button type="submit" class="btn btn-primary">Create vault</button>
        </div>
    </form>
</div>
@endsection
