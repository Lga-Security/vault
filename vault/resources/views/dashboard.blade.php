@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h1 class="h3 mb-1">Welcome back, {{ Auth::user()->name }}</h1>
        <p class="text-muted mb-0">Here's an overview of your password manager.</p>
    </div>
    <a href="{{ route('vaults.create') }}" class="btn btn-primary">
        <i class="bi bi-plus-lg me-1"></i>New Vault
    </a>
</div>

<div class="row g-3 mb-4">
    <div class="col-sm-6 col-lg-3">
        <div class="card shadow-sm h-100">
            <div class="card-body d-flex align-items-center gap-3">
                <div class="rounded-3 bg-primary bg-opacity-10 p-3">
                    <i class="bi bi-safe fs-4 text-primary"></i>
                </div>
                <div>
                    <div class="h4 mb-0">{{ $vaultCount }}</div>
                    <div class="text-muted small">Vaults</div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-lg-3">
        <div class="card shadow-sm h-100">
            <div class="card-body d-flex align-items-center gap-3">
                <div class="rounded-3 bg-success bg-opacity-10 p-3">
                    <i class="bi bi-key fs-4 text-success"></i>
                </div>
                <div>
                    <div class="h4 mb-0">{{ $entryCount }}</div>
                    <div class="text-muted small">Passwords</div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-lg-3">
        <div class="card shadow-sm h-100">
            <div class="card-body d-flex align-items-center gap-3">
                <div class="rounded-3 bg-warning bg-opacity-10 p-3">
                    <i class="bi bi-tags fs-4 text-warning"></i>
                </div>
                <div>
                    <div class="h4 mb-0">{{ $categoryCount }}</div>
                    <div class="text-muted small">Categories</div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-lg-3">
        <div class="card shadow-sm h-100">
            <div class="card-body d-flex align-items-center gap-3">
                <div class="rounded-3 bg-info bg-opacity-10 p-3">
                    <i class="bi bi-share fs-4 text-info"></i>
                </div>
                <div>
                    <div class="h4 mb-0">{{ $shareCount }}</div>
                    <div class="text-muted small">Shared</div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row g-4">
    <div class="col-lg-8">
        <div class="card shadow-sm">
            <div class="card-header bg-white d-flex justify-content-between align-items-center">
                <h2 class="h6 mb-0"><i class="bi bi-safe me-1"></i>Your Vaults</h2>
                <a href="{{ route('vaults.index') }}" class="btn btn-sm btn-outline-primary">View all</a>
            </div>
            <div class="card-body p-0">
                @if ($vaults->isEmpty())
                    <div class="text-center text-muted py-5">
                        <i class="bi bi-safe fs-1 d-block mb-2 opacity-25"></i>
                        <p class="mb-2">No vaults yet.</p>
                        <a href="{{ route('vaults.create') }}" class="btn btn-sm btn-primary">Create your first vault</a>
                    </div>
                @else
                    <div class="list-group list-group-flush">
                        @foreach ($vaults as $vault)
                            <a href="{{ route('vaults.show', $vault) }}" class="list-group-item list-group-item-action d-flex align-items-center gap-3 py-3">
                                @if ($vault->color)
                                    <span class="badge-color" style="background: {{ $vault->color }};"></span>
                                @else
                                    <span class="badge-color" style="background: #6c757d;"></span>
                                @endif
                                <div class="flex-grow-1">
                                    <div class="fw-semibold">
                                        @if ($vault->icon) {{ $vault->icon }} @endif
                                        {{ $vault->name }}
                                    </div>
                                    @if ($vault->description)
                                        <div class="small text-muted">{{ Str::limit($vault->description, 80) }}</div>
                                    @endif
                                </div>
                                <span class="badge bg-secondary bg-opacity-10 text-secondary">
                                    {{ $vault->password_entries_count }} {{ Str::plural('entry', $vault->password_entries_count) }}
                                </span>
                            </a>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="card shadow-sm">
            <div class="card-header bg-white">
                <h2 class="h6 mb-0"><i class="bi bi-clock-history me-1"></i>Recent Activity</h2>
            </div>
            <div class="card-body p-0">
                @if ($activities->isEmpty())
                    <div class="text-center text-muted py-4">
                        <i class="bi bi-clock fs-3 d-block mb-2 opacity-25"></i>
                        <p class="small mb-0">No activity yet.</p>
                    </div>
                @else
                    <div class="list-group list-group-flush">
                        @foreach ($activities as $activity)
                            <div class="list-group-item py-2">
                                <div class="small fw-semibold">{{ $activity->action }}</div>
                                @if ($activity->description)
                                    <div class="small text-muted">{{ $activity->description }}</div>
                                @endif
                                <div class="text-muted" style="font-size: .7rem;">{{ $activity->created_at->diffForHumans() }}</div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
