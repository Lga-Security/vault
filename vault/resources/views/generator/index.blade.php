@extends('layouts.app')

@section('title', 'Password Generator')

@section('content')
<div style="max-width: 640px;" class="mx-auto">

    <div class="mb-4">
        <h1 class="h3 mb-1">Password Generator</h1>
        <p class="text-muted mb-0">Generate a strong, random password using cryptographically secure randomness.</p>
    </div>

    {{-- Generated password display --}}
    <div class="card shadow-sm mb-4">
        <div class="card-body">
            <label class="form-label small fw-semibold text-muted text-uppercase">Generated Password</label>
            <div class="input-group mb-3">
                <input type="text" id="generated-password" class="form-control font-monospace fs-5"
                       placeholder="Click Generate…" readonly>
                <button class="btn btn-outline-secondary" type="button" id="copy-btn"
                        onclick="copyPassword()" title="Copy to clipboard">
                    <i class="bi bi-clipboard" id="copy-icon"></i>
                </button>
            </div>

            {{-- Strength meter --}}
            <div id="strength-section" class="d-none">
                <div class="d-flex align-items-center gap-3 mb-1">
                    <div class="d-flex gap-1 flex-grow-1">
                        <div class="strength-bar rounded" id="bar-1" style="height: 6px; flex: 1; background: #dee2e6;"></div>
                        <div class="strength-bar rounded" id="bar-2" style="height: 6px; flex: 1; background: #dee2e6;"></div>
                        <div class="strength-bar rounded" id="bar-3" style="height: 6px; flex: 1; background: #dee2e6;"></div>
                        <div class="strength-bar rounded" id="bar-4" style="height: 6px; flex: 1; background: #dee2e6;"></div>
                    </div>
                    <span id="strength-label" class="small fw-semibold" style="min-width: 50px;"></span>
                </div>
            </div>
        </div>
    </div>

    {{-- Options --}}
    <div class="card shadow-sm mb-4">
        <div class="card-header bg-white">
            <h2 class="h6 mb-0"><i class="bi bi-sliders me-1"></i>Options</h2>
        </div>
        <div class="card-body">

            <div class="mb-4">
                <label for="length-range" class="form-label small fw-semibold d-flex justify-content-between">
                    <span>Length</span>
                    <span class="text-primary fw-bold" id="length-display">16</span>
                </label>
                <input type="range" class="form-range" id="length-range"
                       min="8" max="64" value="16" step="1"
                       oninput="document.getElementById('length-display').textContent = this.value">
                <div class="d-flex justify-content-between text-muted" style="font-size: .7rem;">
                    <span>8</span><span>64</span>
                </div>
            </div>

            <div class="row g-3">
                <div class="col-6">
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" id="opt-upper" checked>
                        <label class="form-check-label small" for="opt-upper">Uppercase (A–Z)</label>
                    </div>
                </div>
                <div class="col-6">
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" id="opt-lower" checked>
                        <label class="form-check-label small" for="opt-lower">Lowercase (a–z)</label>
                    </div>
                </div>
                <div class="col-6">
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" id="opt-numbers" checked>
                        <label class="form-check-label small" for="opt-numbers">Numbers (0–9)</label>
                    </div>
                </div>
                <div class="col-6">
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" id="opt-symbols" checked>
                        <label class="form-check-label small" for="opt-symbols">Symbols (!@#…)</label>
                    </div>
                </div>
            </div>

        </div>
        <div class="card-footer bg-white">
            <button type="button" class="btn btn-primary w-100" id="generate-btn" onclick="generatePassword()">
                <i class="bi bi-arrow-repeat me-1"></i>Generate Password
            </button>
        </div>
    </div>

    <p class="text-muted small text-center">
        <i class="bi bi-shield-check me-1 text-success"></i>
        Passwords are generated server-side using <code>random_int()</code> and are never stored or logged.
    </p>

</div>
@endsection

@push('scripts')
<script>
const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

async function generatePassword() {
    const btn = document.getElementById('generate-btn');
    btn.disabled = true;
    btn.innerHTML = '<span class="spinner-border spinner-border-sm me-1"></span>Generating…';

    const payload = {
        length:  parseInt(document.getElementById('length-range').value),
        upper:   document.getElementById('opt-upper').checked,
        lower:   document.getElementById('opt-lower').checked,
        numbers: document.getElementById('opt-numbers').checked,
        symbols: document.getElementById('opt-symbols').checked,
    };

    try {
        const response = await fetch('{{ route('generator.generate') }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken,
                'Accept': 'application/json',
            },
            body: JSON.stringify(payload),
        });

        const data = await response.json();

        if (!response.ok) {
            showError(data.error || 'Something went wrong. Please try again.');
            return;
        }

        document.getElementById('generated-password').value = data.password;
        updateStrengthMeter(data.strength);

    } catch (err) {
        showError('Network error. Please try again.');
    } finally {
        btn.disabled = false;
        btn.innerHTML = '<i class="bi bi-arrow-repeat me-1"></i>Generate Password';
    }
}

function updateStrengthMeter(strength) {
    const section = document.getElementById('strength-section');
    section.classList.remove('d-none');

    const filled = parseInt(strength.filledBars);
    const color  = strength.color;
    const label  = strength.label;

    for (let i = 1; i <= 4; i++) {
        const bar = document.getElementById('bar-' + i);
        bar.style.background = i <= filled ? color : '#dee2e6';
    }

    const labelEl = document.getElementById('strength-label');
    labelEl.textContent = label;
    labelEl.style.color = color;
}

function copyPassword() {
    const input = document.getElementById('generated-password');
    if (!input.value) return;

    navigator.clipboard.writeText(input.value).then(() => {
        const icon = document.getElementById('copy-icon');
        icon.className = 'bi bi-check2-all';
        setTimeout(() => { icon.className = 'bi bi-clipboard'; }, 2000);
    });
}

function showError(message) {
    const input = document.getElementById('generated-password');
    input.value = '';
    input.placeholder = message;
    document.getElementById('strength-section').classList.add('d-none');
}

// Auto-generate on page load
generatePassword();
</script>
@endpush
