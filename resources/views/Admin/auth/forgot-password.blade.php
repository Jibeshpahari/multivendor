@extends('admin.layout.auth', ['title' => 'Forgot Password'])

@section('content')
    <div class="login-card card">

        <div class="card-header-text">
            <h2>Forgot your password?</h2>
            <p>Enter your admin email and we'll send you a 6-digit code to reset it.</p>
        </div>


        <form id="forgotForm" action="{{ route('admin.forgot-password.post') }}" method="post" novalidate>
            @csrf

            <div class="form-group">
                <label class="form-label" for="email">Email address</label>
                <div class="input-group-custom">
                    <i class="bi bi-envelope input-icon"></i>
                    <input type="email" id="email" name="email" value="" class="form-control-custom"
                        placeholder="user@example.com" autocomplete="email" autofocus required />
                </div>
                @error('email')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>

            <button type="submit" class="btn-login" id="submitBtn">
                <span id="btnText">Send code</span>
                <i class="bi bi-arrow-right" id="btnIcon"></i>
                <span id="btnSpinner" style="display:none; align-items:center; gap:6px;">
                    <i class="bi bi-arrow-repeat"
                        style="animation: spin 0.8s linear infinite; display:inline-block;"></i>
                    Sending…
                </span>
            </button>
        </form>

        <div class="form-footer">
            Remembered it? <a href="{{ route('admin.login.view') }}">Sign in</a><br />
            Need access? <a href="mailto:{{ $adminEmail }}">Contact your administrator</a>.
        </div>

    </div>
@endsection