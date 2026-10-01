@extends('admin.layout.auth', ['title' => 'Verify Code'])

@section('content')
    <div class="login-card card">

        <div class="card-header-text">
            <h2>Enter the code</h2>
            <p>We sent a 6-digit code to <strong>{{ $email ?? 'the given email address' }}</strong>. It expires in 10 minutes.</p>
        </div>

        <form id="otpForm" action="{{ route('admin.verify-otp.post') }}" method="POST" novalidate>
            @csrf
            <input type="hidden" name="otp" id="otp" />

            <div class="form-group">
                <label class="form-label" for="otp-0">Verification code</label>
                <div class="otp-grid" id="otpGrid">
                    <input type="text" id="otp-0" class="otp-input" inputmode="numeric" pattern="[0-9]*"
                        maxlength="1" autocomplete="one-time-code" aria-label="Digit 1" autofocus />
                    <input type="text" id="otp-1" class="otp-input" inputmode="numeric" pattern="[0-9]*"
                        maxlength="1" autocomplete="off" aria-label="Digit 2" />
                    <input type="text" id="otp-2" class="otp-input" inputmode="numeric" pattern="[0-9]*"
                        maxlength="1" autocomplete="off" aria-label="Digit 3" />
                    <input type="text" id="otp-3" class="otp-input" inputmode="numeric" pattern="[0-9]*"
                        maxlength="1" autocomplete="off" aria-label="Digit 4" />
                    <input type="text" id="otp-4" class="otp-input" inputmode="numeric" pattern="[0-9]*"
                        maxlength="1" autocomplete="off" aria-label="Digit 5" />
                    <input type="text" id="otp-5" class="otp-input" inputmode="numeric" pattern="[0-9]*"
                        maxlength="1" autocomplete="off" aria-label="Digit 6" />
                </div>
            </div>

            <button type="submit" class="btn-login" id="submitBtn" disabled>
                <span id="btnText">Verify code</span>
                <i class="bi bi-arrow-right" id="btnIcon"></i>
                <span id="btnSpinner" style="display:none; align-items:center; gap:6px;">
                    <i class="bi bi-arrow-repeat"
                        style="animation: spin 0.8s linear infinite; display:inline-block;"></i>
                    Verifying…
                </span>
            </button>
        </form>

        <form id="resendForm" action="verify-otp.html" method="GET" class="resend-row">
            Didn't get it?
            <button type="submit" class="resend-btn" id="resendBtn" disabled>Resend code</button>
            <span id="timer"></span>
        </form>

        <div class="form-footer">
            Remembered it? <a href="{{ route('admin.login.view') }}">Sign in</a><br />
            Need access? <a href="mailto:{{ $adminEmail }}">Contact your administrator</a>.
        </div>

    </div>
@endsection

@push('js')
    <script>
        (function () {
            const inputs = Array.from(document.querySelectorAll('.otp-input'));
            const hidden = document.getElementById('otp');
            const submit = document.getElementById('submitBtn');

            function sync() {
                const code = inputs.map(i => i.value).join('');
                hidden.value = code;
                submit.disabled = code.length !== 6;
                inputs.forEach(i => i.classList.toggle('filled', i.value !== ''));
            }

            inputs.forEach((input, idx) => {
                input.addEventListener('input', () => {
                    input.value = input.value.replace(/\D/g, '').slice(-1);
                    input.classList.remove('error');
                    if (input.value && idx < inputs.length - 1) inputs[idx + 1].focus();
                    sync();
                });

                input.addEventListener('keydown', (e) => {
                    if (e.key === 'Backspace' && !input.value && idx > 0) {
                        inputs[idx - 1].value = '';
                        inputs[idx - 1].focus();
                        sync();
                    } else if (e.key === 'ArrowLeft' && idx > 0) {
                        inputs[idx - 1].focus();
                    } else if (e.key === 'ArrowRight' && idx < inputs.length - 1) {
                        inputs[idx + 1].focus();
                    }
                });

                input.addEventListener('focus', () => input.select());

                input.addEventListener('paste', (e) => {
                    e.preventDefault();
                    const digits = (e.clipboardData.getData('text') || '').replace(/\D/g, '').slice(0, 6);
                    digits.split('').forEach((d, i) => { inputs[i].value = d; });
                    inputs[Math.min(digits.length, 5)].focus();
                    sync();
                });
            });

            document.getElementById('otpForm').addEventListener('submit', function () {
                submit.disabled = true;
                document.getElementById('btnText').style.display = 'none';
                document.getElementById('btnIcon').style.display = 'none';
                document.getElementById('btnSpinner').style.display = 'inline-flex';
            });

            // Resend countdown
            const resendBtn = document.getElementById('resendBtn');
            const timerEl = document.getElementById('timer');
            let seconds = 60;
            timerEl.textContent = 'in ' + seconds + 's';
            const tick = setInterval(() => {
                seconds--;
                if (seconds <= 0) {
                    clearInterval(tick);
                    resendBtn.disabled = false;
                    timerEl.textContent = '';
                } else {
                    timerEl.textContent = 'in ' + seconds + 's';
                }
            }, 1000);
        })();
    </script>
@endpush