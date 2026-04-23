@extends('layouts.app')

@section('title', $entry->site_name)

@section('content')
<div style="max-width: 680px;" class="mx-auto">

    <nav aria-label="breadcrumb" class="mb-3">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('vaults.index') }}">Vaults</a></li>
            <li class="breadcrumb-item"><a href="{{ route('vaults.show', $vault) }}">{{ $vault->name }}</a></li>
            <li class="breadcrumb-item active">{{ $entry->site_name }}</li>
        </ol>
    </nav>

    <div class="d-flex justify-content-between align-items-start mb-4 flex-wrap gap-2">
        <h1 class="h3 mb-0">{{ $entry->site_name }}</h1>
        <div class="d-flex gap-2">
            <a href="{{ route('vaults.entries.edit', [$vault, $entry]) }}" class="btn btn-outline-secondary btn-sm">
                <i class="bi bi-pencil me-1"></i>Edit
            </a>
            <form action="{{ route('vaults.entries.destroy', [$vault, $entry]) }}" method="POST" class="d-inline"
                  onsubmit="return confirm('Delete this password entry?');">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-outline-danger btn-sm">
                    <i class="bi bi-trash me-1"></i>Delete
                </button>
            </form>
        </div>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">

            {{-- URL --}}
            @if ($entry->url)
                <div class="mb-4">
                    <div class="small text-muted fw-semibold text-uppercase mb-1">Website</div>
                    <a href="{{ $entry->url }}" target="_blank" rel="noopener noreferrer" class="text-break">
                        <i class="bi bi-link-45deg me-1"></i>{{ $entry->url }}
                    </a>
                </div>
            @endif

            {{-- Category --}}
            @if ($entry->category)
                <div class="mb-4">
                    <div class="small text-muted fw-semibold text-uppercase mb-1">Category</div>
                    <span class="badge bg-secondary bg-opacity-10 text-secondary fs-6">
                        <i class="bi bi-tag me-1"></i>{{ $entry->category->name }}
                    </span>
                </div>
            @endif

            {{-- Username --}}
            <div class="mb-4">
                <div class="small text-muted fw-semibold text-uppercase mb-1">Username / Email</div>
                <div class="d-flex align-items-center gap-2">
                    <code class="fs-6" id="username-val">{{ $decrypted['username'] }}</code>
                    <button type="button" class="btn btn-sm btn-outline-secondary"
                            onclick="copyToClipboard('username-val', this)" title="Copy username">
                        <i class="bi bi-clipboard"></i>
                    </button>
                </div>
            </div>

            {{-- Password --}}
            <div class="mb-4">
                <div class="small text-muted fw-semibold text-uppercase mb-1">Password</div>
                <div class="d-flex align-items-center gap-2 flex-wrap">
                    <code class="fs-6 font-monospace" id="password-display" style="letter-spacing: 2px;">••••••••</code>
                    <span class="d-none" id="password-val">{{ $decrypted['password'] }}</span>
                    <button type="button" class="btn btn-sm btn-outline-secondary"
                            id="toggle-btn" onclick="togglePassword()" title="Show / Hide">
                        <i class="bi bi-eye" id="toggle-icon"></i>
                    </button>
                    <button type="button" class="btn btn-sm btn-outline-secondary"
                            onclick="copyToClipboard('password-val', this)" title="Copy password">
                        <i class="bi bi-clipboard"></i>
                    </button>
                </div>
            </div>

            {{-- Notes --}}
            @if ($decrypted['notes'])
                <div class="mb-2">
                    <div class="small text-muted fw-semibold text-uppercase mb-1">Notes</div>
                    <div class="border rounded p-3 bg-light text-break" style="white-space: pre-wrap;">{{ $decrypted['notes'] }}</div>
                </div>
            @endif

        </div>
        <div class="card-footer bg-white d-flex justify-content-between align-items-center text-muted small">
            <span><i class="bi bi-clock me-1"></i>Added {{ $entry->created_at->diffForHumans() }}</span>
            @if ($entry->updated_at->ne($entry->created_at))
                <span><i class="bi bi-pencil me-1"></i>Edited {{ $entry->updated_at->diffForHumans() }}</span>
            @endif
        </div>
    </div>

    <div class="mt-3">
        <a href="{{ route('vaults.show', $vault) }}" class="text-decoration-none text-muted small">
            <i class="bi bi-arrow-left me-1"></i>Back to {{ $vault->name }}
        </a>
    </div>

</div>
@endsection

@push('scripts')
<script>
function togglePassword() {
    const display = document.getElementById('password-display');
    const value   = document.getElementById('password-val').textContent;
    const icon    = document.getElementById('toggle-icon');

    if (display.textContent === '••••••••') {
        display.textContent = value;
        display.style.letterSpacing = 'normal';
        icon.className = 'bi bi-eye-slash';
    } else {
        display.textContent = '••••••••';
        display.style.letterSpacing = '2px';
        icon.className = 'bi bi-eye';
    }
}

function copyToClipboard(elementId, btn) {
    const text = document.getElementById(elementId).textContent.trim();
    navigator.clipboard.writeText(text).then(() => {
        const icon = btn.querySelector('i');
        icon.className = 'bi bi-check2';
        setTimeout(() => { icon.className = 'bi bi-clipboard'; }, 2000);
    });
}
</script>
@endpush
