@extends('welcome')

@section('content')
<div class="container py-4">
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="d-flex flex-wrap justify-content-between align-items-start gap-3 mb-4">
        <div>
            <div class="d-flex align-items-center gap-2 mb-2">
                @if ($vault->icon)
                    <span class="fs-3" aria-hidden="true">{{ $vault->icon }}</span>
                @endif
                <h1 class="h3 mb-0">{{ $vault->name }}</h1>
            </div>
            @if ($vault->description)
                <p class="text-muted mb-0">{{ $vault->description }}</p>
            @endif
            @if ($vault->color)
                <p class="small mt-2 mb-0">
                    <span class="badge border" style="background-color: {{ $vault->color }}; width: 1.25rem; height: 1.25rem; vertical-align: middle;"></span>
                    <span class="text-muted">{{ $vault->color }}</span>
                </p>
            @endif
        </div>
        <div class="d-flex gap-2 flex-wrap">
            <a href="{{ route('vaults.edit', $vault) }}" class="btn btn-outline-secondary">Edit</a>
            <form action="{{ route('vaults.destroy', $vault) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete this vault?');">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-outline-danger">Delete</button>
            </form>
        </div>
    </div>

    <div class="card shadow-sm border-0">
        <div class="card-body">
            <h2 class="h5 card-title">Password entries</h2>
            <p class="text-muted mb-0">Entry management can be added here later.</p>
        </div>
    </div>

    <p class="mt-4 mb-0">
        <a href="{{ route('vaults.index') }}" class="text-decoration-none">&larr; All vaults</a>
    </p>
</div>
@endsection
