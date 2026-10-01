<?php

namespace App\Http\Controllers\auth;

use App\Enums\SettingKey;
use App\Http\Controllers\Controller;
use App\Mail\ForgotPasswordOtpMail;
use App\Models\Otp;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\View;
use Illuminate\Validation\Rule;

class AuthController extends Controller
{

    protected $adminEmail;

    public function __construct()
    {
        $this->adminEmail = setting(SettingKey::SiteEmail, 'site_email');
        View::share('adminEmail', $this->adminEmail);
    }

    public function adminLoginView()
    {
        return view('admin.auth.login');
    }

    public function adminLoginPost(Request $request)
    {
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required|min:8',
        ], [
            'email.required'    => 'Email is required.',
            'email.email'       => 'Please enter a valid email address.',
            'password.required' => 'Password is required.',
            'password.min'      => 'Password must be at least 8 characters.',
        ]);

        if (Auth::attempt([
            'email'    => $request->email,
            'password' => $request->password,
            'role'     => 'admin',
            'status'   => 'active',
        ], $request->boolean('remember_me'))) {
            $request->session()->regenerate();

            return redirect()->intended(route('admin.settings.site-settings'));
        }

        return back()->withErrors(['error' => 'The provided credentials are incorrect.'])->withInput();
    }

    public function adminForgotPasswordView()
    {
        return view('admin.auth.forgot-password');
    }

    public function adminForgotPasswordPost(Request $request)
    {
        $validated = $request->validate([
            'email' => ['required', 'email', Rule::exists('users', 'email')->where(function ($query) {
                    $query->where('role', 'admin');
                }),
            ]
        ]);

        $admin = User::where('email', $validated['email'])->where('role', 'admin')->first();
        $otp = str_pad((string) random_int(0, 999999), 6, '0', STR_PAD_LEFT);

        Otp::where('identifier', $validated['email'])->delete(); 

        Otp::create([
            'identifier' => $validated['email'],
            'otp'        => Hash::make($otp),
            'expires_at' => now()->addMinutes(5),
        ]);

        Mail::to($validated['email'])->send(new ForgotPasswordOtpMail(1, ['Multivendor', $admin->name ?? '', $otp, 5]));

        session(['admin_reset_email' => $validated['email']]);

        return redirect()->route('admin.verify-otp.view')->with('success', 'We sent a 6-digit code to your email.');
    }

    public function adminVerifyOtpView() {
        $email = session('admin_reset_email');
        return view('admin.auth.verify-otp', compact('email'));
    }

    public function adminVerifyOtpPost(Request $request)
    {
        $request->validate([
            'otp' => ['required', 'digits:6'],
        ], [
            'otp.required' => 'Please enter the OTP.',
            'otp.digits'   => 'The OTP must be 6 digits.',
        ]);

        $email = session('admin_reset_email');

        if (!$email) {
            return redirect()->route('admin.forgot-password.view')->withErrors(['error' => 'Your password reset session has expired.']);
        }

        $otpRecord = Otp::where('identifier', $email)->latest()->first();

        // dd($otpRecord->expires_at);

        if($otpRecord->expires_at < now()){
            return back()->withErrors(['otp' => 'The OTP has expired.'])->withInput();
        }
        if (!$otpRecord || !Hash::check((string) $request->input('otp'), $otpRecord->otp)) {
            return back()->withErrors(['otp' => 'The OTP is invalid.'])->withInput();
        }

        // $otpRecord->delete();
        session(['admin_reset_otp_verified' => true]);

        return redirect()->route('admin.reset-password.view');
    }


    public function adminResetPasswordView() {
        return view('admin.auth.reset-password');
    }
}
