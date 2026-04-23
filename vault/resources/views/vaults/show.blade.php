@extends('layouts.app')

@section('title', $vault->name)

@section('content')
<div class="d-flex flex-wrap justify-content-between align-items-start gap-3 mb-4">
    <div>
        <nav aria-label="breadcrumb" class="mb-1">
            <ol class="breadcrumb mb-0 small">
                <li class="breadcrumb-item"><a href="{{ route('vaults.index') }}">Vaults</a></li>
                <li class="breadcrumb-item active">{{ $vault->name }}</li>
            </ol>
        </nav>
        <div class="d-flex align-items-center gap-2 mt-1">
            @if ($vault->color)
                <span class="badge-color" style="background: {{ $vault->color }};"></span>
            @endif
            @if ($vault->icon)
                <span class="fs-3">{{ $vault->icon }}</span>
            @endif
            <h1 class="h3 mb-0">{{ $vault->name }}</h1>
        </div>
        @if ($vault->description)
            <p class="text-muted mb-0 mt-1">{{ $vault->description }}</p>
        @endif
    </div>
    <div class="d-flex gap-2 flex-wrap">
        <a href="{{ route('vaults.entries.create', $vault) }}" class="btn btn-primary btn-sm">
            <i class="bi bi-plus-lg me-1"></i>Add Entry
        </a>
        <a href="{{ route('vaults.edit', $vault) }}" class="btn btn-outline-secondary btn-sm">
            <i class="bi bi-pencil me-1"></i>Edit Vault
        </a>
        <form action="{{ route('vaults.destroy', $vault) }}" method="POST" class="d-inline"
              onsubmit="return confirm('Delete this vault and ALL its entries? This cannot be undone.');">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-outline-danger btn-sm">
                <i class="bi bi-trash me-1"></i>Delete
            </button>
        </form>
    </div>
</div>

{{-- Filter bar --}}
@if ($entries->isNotEmpty())
<div class="card shadow-sm mb-3">
    <div class="card-body py-2 px-3">
        <div class="d-flex align-items-center gap-3 flex-wrap">
            <span class="text-muted small fw-semibold">Filter:</span>
            <button class="btn btn-sm btn-outline-secondary active" id="filter-all" onclick="filterEntries('all')">All</button>
            @foreach ($categories as $category)
                @if ($entries->where('category_id', $category->id)->isNotEmpty())
                    <button class="btn btn-sm btn-outline-secondary" id="filter-{{ $category->id }}"
                            onclick="filterEntries({{ $category->id }})">
                        {{ $category->name }}
                    </button>
                @endif
            @endforeach
        </div>
    </div>
</div>
@endif

{{-- Entries list --}}
<div class="card shadow-sm">
    <div class="card-header bg-white d-flex justify-content-between align-items-center">
        <h2 class="h6 mb-0">
            <i class="bi bi-key me-1"></i>Password Entries
            <span class="badge bg-secondary bg-opacity-10 text-secondary ms-1">{{ $entries->count() }}</span>
        </h2>
        <a href="{{ route('vaults.entries.create', $vault) }}" class="btn btn-sm btn-primary">
            <i class="bi bi-plus-lg me-1"></i>Add Entry
        </a>
    </div>

    <div class="card-body p-0">
        @if ($entries->isEmpty())
            <div class="text-center text-muted py-5">
                <i class="bi bi-key fs-1 d-block mb-2 opacity-25"></i>
                <p class="mb-3">No password entries in this vault yet.</p>
                <a href="{{ route('vaults.entries.create', $vault) }}" class="btn btn-primary btn-sm">
                    <i class="bi bi-plus-lg me-1"></i>Add your first entry
                </a>
            </div>
        @else
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0" id="entries-table">
                    <thead class="table-light">
                        <tr>
                            <th>Site / Service</th>
                            <th>URL</th>
                            <th>Category</th>
                            <th class="text-end">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($entries as $entry)
                            <tr data-category="{{ $entry->category_id ?? 'none' }}">
                                <td>
                                    <a href="{{ route('vaults.entries.show', [$vault, $entry]) }}"
                                       class="fw-semibold text-decoration-none text-dark">
                                        @if ($entry->icon ?? false)
                                            <span class="me-1">{{ $entry->icon }}</span>
                                        @endif
                                        {{ $entry->site_name }}
                                    </a>
                                </td>
                                <td>
                                    @if ($entry->url)
                                        <a href="{{ $entry->url }}" target="_blank" rel="noopener noreferrer"
                                           class="small text-truncate d-inline-block text-muted"
                                           style="max-width: 200px;" title="{{ $entry->url }}">
                                            <i class="bi bi-link-45deg me-1"></i>{{ parse_url($entry->url, PHP_URL_HOST) }}
                                        </a>
                                    @else
                                        <span class="text-muted">—</span>
                                    @endif
                                </td>
                                <td>
                                    @if ($entry->category)
                                        <span class="badge bg-secondary bg-opacity-10 text-secondary">
                                            {{ $entry->category->name }}
                                        </span>
                                    @else
                                        <span class="text-muted small">—</span>
                                    @endif
                                </td>
                                <td class="text-end">
                                    <a href="{{ route('vaults.entries.show', [$vault, $entry]) }}"
                                       class="btn btn-sm btn-outline-primary" title="View credentials">
                                        <i class="bi bi-eye"></i>
                                    </a>
                                    <a href="{{ route('vaults.entries.edit', [$vault, $entry]) }}"
                                       class="btn btn-sm btn-outline-secondary" title="Edit">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <form action="{{ route('vaults.entries.destroy', [$vault, $entry]) }}"
                                          method="POST" class="d-inline"
                                          onsubmit="return confirm('Delete this password entry?');">
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
@endsection

@push('scripts')
<script>
function filterEntries(categoryId) {
    const rows = document.querySelectorAll('#entries-table tbody tr');
    rows.forEach(row => {
        if (categoryId === 'all') {
            row.style.display = '';
        } else {
            row.style.display = (row.dataset.category == categoryId) ? '' : 'none';
        }
    });

    document.querySelectorAll('[id^="filter-"]').forEach(btn => btn.classList.remove('active'));
    document.getElementById('filter-' + categoryId)?.classList.add('active');
}
</script>
@endpush
