@extends('layouts.app')

@section('title', $vault->name)

@section('content')
<div class="d-flex flex-wrap justify-content-between align-items-start gap-3 mb-4">
    <div>
        <div class="d-flex align-items-center gap-2 mb-1">
            @if ($vault->color)
                <span class="badge-color" style="background: {{ $vault->color }};"></span>
            @endif
            @if ($vault->icon)
                <span class="fs-3">{{ $vault->icon }}</span>
            @endif
            <h1 class="h3 mb-0">{{ $vault->name }}</h1>
        </div>
        @if ($vault->description)
            <p class="text-muted mb-0">{{ $vault->description }}</p>
        @endif
    </div>
    <div class="d-flex gap-2 flex-wrap">
        <a href="{{ route('vaults.edit', $vault) }}" class="btn btn-outline-secondary btn-sm">
            <i class="bi bi-pencil me-1"></i>Edit Vault
        </a>
        <form action="{{ route('vaults.destroy', $vault) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete this vault and all its entries?');">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-outline-danger btn-sm">
                <i class="bi bi-trash me-1"></i>Delete
            </button>
        </form>
    </div>
</div>

{{-- Add Password Entry --}}
<div class="card shadow-sm mb-4">
    <div class="card-header bg-white d-flex justify-content-between align-items-center">
        <h2 class="h6 mb-0"><i class="bi bi-key me-1"></i>Password Entries</h2>
        <button class="btn btn-sm btn-primary" type="button" data-bs-toggle="collapse" data-bs-target="#addEntryForm">
            <i class="bi bi-plus-lg me-1"></i>Add Entry
        </button>
    </div>

    <div class="collapse" id="addEntryForm">
        <div class="card-body border-bottom bg-light">
            <form method="POST" action="{{ route('vaults.entries.store', $vault) }}">
                @csrf
                <div class="row g-3">
                    <div class="col-md-6">
                        <label for="site_name" class="form-label small fw-semibold">Site / Service Name <span class="text-danger">*</span></label>
                        <input type="text" name="site_name" id="site_name" class="form-control" required value="{{ old('site_name') }}" placeholder="e.g. GitHub">
                    </div>
                    <div class="col-md-6">
                        <label for="category_id" class="form-label small fw-semibold">Category</label>
                        <select name="category_id" id="category_id" class="form-select">
                            <option value="">— None —</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label for="username" class="form-label small fw-semibold">Username / Email <span class="text-danger">*</span></label>
                        <input type="text" name="username" id="username" class="form-control" required value="{{ old('username') }}" placeholder="user@example.com">
                    </div>
                    <div class="col-md-6">
                        <label for="password" class="form-label small fw-semibold">Password <span class="text-danger">*</span></label>
                        <input type="text" name="password" id="password" class="form-control font-monospace" required value="{{ old('password') }}">
                    </div>
                    <div class="col-12">
                        <label for="notes" class="form-label small fw-semibold">Notes</label>
                        <textarea name="notes" id="notes" class="form-control" rows="2" placeholder="Optional notes...">{{ old('notes') }}</textarea>
                    </div>
                </div>
                <div class="mt-3 d-flex gap-2 justify-content-end">
                    <button type="button" class="btn btn-sm btn-outline-secondary" data-bs-toggle="collapse" data-bs-target="#addEntryForm">Cancel</button>
                    <button type="submit" class="btn btn-sm btn-primary"><i class="bi bi-plus-lg me-1"></i>Save Entry</button>
                </div>
            </form>
        </div>
    </div>

    <div class="card-body p-0">
        @if ($entries->isEmpty())
            <div class="text-center text-muted py-5">
                <i class="bi bi-key fs-1 d-block mb-2 opacity-25"></i>
                <p class="mb-0">No password entries in this vault yet.</p>
            </div>
        @else
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>Site</th>
                            <th>Username</th>
                            <th>Password</th>
                            <th>Category</th>
                            <th class="text-end">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($entries as $entry)
                            <tr>
                                <td class="fw-semibold">{{ $entry->site_name }}</td>
                                <td><code>{{ $entry->username }}</code></td>
                                <td>
                                    <span class="password-hidden" id="pw-{{ $entry->id }}">••••••••</span>
                                    <span class="d-none" id="pw-val-{{ $entry->id }}">{{ $entry->password }}</span>
                                    <button class="btn btn-sm btn-link p-0 ms-1" onclick="togglePassword({{ $entry->id }})" title="Show/Hide">
                                        <i class="bi bi-eye" id="pw-icon-{{ $entry->id }}"></i>
                                    </button>
                                    <button class="btn btn-sm btn-link p-0 ms-1" onclick="copyPassword({{ $entry->id }})" title="Copy">
                                        <i class="bi bi-clipboard"></i>
                                    </button>
                                </td>
                                <td>
                                    @if ($entry->category)
                                        <span class="badge bg-secondary bg-opacity-10 text-secondary">{{ $entry->category->name }}</span>
                                    @else
                                        <span class="text-muted">—</span>
                                    @endif
                                </td>
                                <td class="text-end">
                                    <a href="{{ route('vaults.entries.edit', [$vault, $entry]) }}" class="btn btn-sm btn-outline-secondary" title="Edit">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <form action="{{ route('vaults.entries.destroy', [$vault, $entry]) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete this entry?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger" title="Delete">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
</div>

<a href="{{ route('vaults.index') }}" class="text-decoration-none">
    <i class="bi bi-arrow-left me-1"></i>Back to Vaults
</a>
@endsection

@push('scripts')
<script>
function togglePassword(id) {
    const display = document.getElementById('pw-' + id);
    const value = document.getElementById('pw-val-' + id);
    const icon = document.getElementById('pw-icon-' + id);
    if (display.textContent === '••••••••') {
        display.textContent = value.textContent;
        icon.className = 'bi bi-eye-slash';
    } else {
        display.textContent = '••••••••';
        icon.className = 'bi bi-eye';
    }
}
function copyPassword(id) {
    const value = document.getElementById('pw-val-' + id).textContent;
    navigator.clipboard.writeText(value);
}
</script>
@endpush
