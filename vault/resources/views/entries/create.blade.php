@extends('layouts.app')

@section('title', 'Add Entry — ' . $vault->name)

@section('content')
<div style="max-width: 640px;" class="mx-auto">

    <nav aria-label="breadcrumb" class="mb-3">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('vaults.index') }}">Vaults</a></li>
            <li class="breadcrumb-item"><a href="{{ route('vaults.show', $vault) }}">{{ $vault->name }}</a></li>
            <li class="breadcrumb-item active">Add Entry</li>
        </ol>
    </nav>

    <h1 class="h3 mb-4">Add Password Entry</h1>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0 small">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('vaults.entries.store', $vault) }}" class="card shadow-sm">
        @csrf
        <div class="card-body">

            <div class="row g-3">
                <div class="col-md-6">
                    <label for="site_name" class="form-label small fw-semibold">
                        Site / Service Name <span class="text-danger">*</span>
                    </label>
                    <input type="text" name="site_name" id="site_name" class="form-control"
                           value="{{ old('site_name') }}" required maxlength="255" autofocus
                           placeholder="e.g. GitHub">
                </div>

                <div class="col-md-6">
                    <label for="url" class="form-label small fw-semibold">URL</label>
                    <input type="url" name="url" id="url" class="form-control"
                           value="{{ old('url') }}" maxlength="500" placeholder="https://example.com">
                </div>

                <div class="col-md-6">
                    <label for="username" class="form-label small fw-semibold">
                        Username / Email <span class="text-danger">*</span>
                    </label>
                    <input type="text" name="username" id="username" class="form-control"
                           value="{{ old('username') }}" required placeholder="you@example.com">
                </div>

                <div class="col-md-6">
                    <label for="password" class="form-label small fw-semibold">
                        Password <span class="text-danger">*</span>
                    </label>
                    <div class="input-group">
                        <input type="password" name="password" id="password" class="form-control font-monospace"
                               value="{{ old('password') }}" required placeholder="••••••••">
                        <button type="button" class="btn btn-outline-secondary" id="toggle-password" title="Show / Hide">
                            <i class="bi bi-eye" id="toggle-icon"></i>
                        </button>
                    </div>
                    <div class="mt-1">
                        <a href="{{ route('generator.index') }}" target="_blank" class="small text-muted">
                            <i class="bi bi-dice-3 me-1"></i>Need a strong password? Use the generator
                        </a>
                    </div>
                </div>

                <div class="col-12">
                    <label for="category_id" class="form-label small fw-semibold">Category</label>
                    <select name="category_id" id="category_id" class="form-select">
                        <option value="">— None —</option>
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}"
                                {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-12">
                    <label for="notes" class="form-label small fw-semibold">Notes</label>
                    <textarea name="notes" id="notes" class="form-control" rows="3"
                              placeholder="Optional notes...">{{ old('notes') }}</textarea>
                </div>
            </div>

        </div>
        <div class="card-footer bg-white d-flex gap-2 justify-content-end">
            <a href="{{ route('vaults.show', $vault) }}" class="btn btn-outline-secondary">Cancel</a>
            <button type="submit" class="btn btn-primary">
                <i class="bi bi-plus-lg me-1"></i>Save Entry
            </button>
        </div>
    </form>
</div>
@endsection

@push('scripts')
<script>
document.getElementById('toggle-password').addEventListener('click', function () {
    const input = document.getElementById('password');
    const icon  = document.getElementById('toggle-icon');
    if (input.type === 'password') {
        input.type = 'text';
        icon.className = 'bi bi-eye-slash';
    } else {
        input.type = 'password';
        icon.className = 'bi bi-eye';
    }
});
</script>
@endpush
