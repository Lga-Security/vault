@extends('layouts.app')

@section('title', 'Vaults')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3 mb-0">Vaults</h1>
    <a href="{{ route('vaults.create') }}" class="btn btn-primary">
        <i class="bi bi-plus-lg me-1"></i>New Vault
    </a>
</div>

@if ($vaults->isEmpty())
    <div class="card shadow-sm">
        <div class="card-body text-center text-muted py-5">
            <i class="bi bi-safe fs-1 d-block mb-3 opacity-25"></i>
            <p class="mb-3">You have no vaults yet.</p>
            <a href="{{ route('vaults.create') }}" class="btn btn-primary">Create your first vault</a>
        </div>
    </div>
@else
    <div class="row g-3">
        @foreach ($vaults as $vault)
            <div class="col-md-6 col-lg-4">
                <div class="card h-100 shadow-sm">
                    <div class="card-body">
                        <div class="d-flex align-items-start gap-2 mb-2">
                            @if ($vault->color)
                                <span class="badge-color mt-1" style="background: {{ $vault->color }};"></span>
                            @endif
                            @if ($vault->icon)
                                <span class="fs-4">{{ $vault->icon }}</span>
                            @endif
                            <div class="flex-grow-1">
                                <h2 class="h5 card-title mb-1">
                                    <a href="{{ route('vaults.show', $vault) }}" class="text-decoration-none text-dark">
                                        {{ $vault->name }}
                                    </a>
                                </h2>
                                @if ($vault->description)
                                    <p class="card-text small text-muted mb-2">{{ Str::limit($vault->description, 120) }}</p>
                                @endif
                                <p class="small text-secondary mb-0">
                                    <i class="bi bi-key me-1"></i>{{ $vault->password_entries_count }} {{ Str::plural('entry', $vault->password_entries_count) }}
                                </p>
                            </div>
                        </div>
                        <div class="d-flex gap-2 flex-wrap mt-3">
                            <a href="{{ route('vaults.show', $vault) }}" class="btn btn-sm btn-primary">
                                <i class="bi bi-folder2-open me-1"></i>Open
                            </a>
                            <a href="{{ route('vaults.edit', $vault) }}" class="btn btn-sm btn-outline-secondary">
                                <i class="bi bi-pencil me-1"></i>Edit
                            </a>
                            <form action="{{ route('vaults.destroy', $vault) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete this vault and all its entries?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger">
                                    <i class="bi bi-trash me-1"></i>Delete
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@endif
@endsection
