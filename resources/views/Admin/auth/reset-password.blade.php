@extends('admin.layout.auth', ['title' => 'Set New Password'])

@push('css')
    <style>
        .form-control-custom[data-strength="1"] { border-color: #dca226; }
        .form-control-custom[data-strength="2"] { border-color: #f1f50b; }
        .form-control-custom[data-strength="3"] { border-color: #84cc16; }
        .form-control-custom[data-strength="4"] { border-color: #16a34a; }
    </style>
@endpush

@section('content')
    <div class="login-card card">

        <div class="card-header-text">
            <h2>Set a new password</h2>
            <p>Your code is <strong>verified</strong>. Choose a strong password you haven't used before.</p>
        </div>

        <form id="resetForm" action="{{ route('admin.reset-password.post') }}" method="POST" novalidate>
            @csrf

            <div class="form-group">
                <label class="form-label" for="password">New password</label>
                <div class="input-group-custom">
                    <i class="bi bi-lock input-icon"></i>
                    <input type="password" id="password" name="password" class="form-control-custom has-toggle"
                        placeholder="•••••••••••••••" autocomplete="new-password" autofocus required data-pw-toggle />
                    <button type="button" class="toggle-pw" data-pw-toggle-btn aria-label="Toggle password visibility">
                        <i class="bi bi-eye"></i>
                    </button>
                </div>
            </div>

            <div class="form-group">
                <label class="form-label" for="password_confirmation">Confirm password</label>
                <div class="input-group-custom">
                    <i class="bi bi-lock-fill input-icon"></i>
                    <input type="password" id="password_confirmation" name="password_confirmation"
                        class="form-control-custom has-toggle" placeholder="•••••••••••••••"
                        autocomplete="new-password" required data-pw-toggle />
                    <button type="button" class="toggle-pw" data-pw-toggle-btn aria-label="Toggle password visibility">
                        <i class="bi bi-eye"></i>
                    </button>
                </div>
            </div>

            <button type="submit" class="btn-login" id="submitBtn">
                <span>Update password</span>
                <i class="bi bi-arrow-right"></i>
            </button>
        </form>

        <div class="form-footer">
            Remembered it? <a href="{{ route('admin.login.view') }}">Sign in</a><br />
            Need access? <a href="mailto:{{ $adminEmail }}">Contact your administrator</a>.
        </div>

    </div>
@endsection

@push('js')
    <script>
        $('#password').on('input', function () {
            const v = this.value;
            let s = (v.length >= 8) + (/[a-z]/.test(v) && /[A-Z]/.test(v)) + /\d/.test(v) + /\W|_/.test(v);
            if (v.length < 8) s = Math.min(s, 1);
            $(this).attr('data-strength', v ? s : null);
        });
    </script>
@endpush