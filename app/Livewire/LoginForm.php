<?php

namespace App\Livewire;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Livewire\Component;

class LoginForm extends Component
{
    public string $username = '';
    public string $password = '';
    public ?string $errorMessage = null;

    protected $rules = [
        'username' => 'required|string',
        'password' => 'required|string',
    ];

    public function login()
    {
        $this->errorMessage = null;

        // Rate Limiting: 5 attempts per 5 minutes per IP
        $ip = request()->ip();
        $rateLimitKey = 'login:' . $ip;

        if (RateLimiter::tooManyAttempts($rateLimitKey, 5)) {
            $seconds = RateLimiter::availableIn($rateLimitKey);
            $minutes = ceil($seconds / 60);
            $this->errorMessage = "Terlalu banyak percobaan login gagal. Demi keamanan, silakan tunggu {$minutes} menit sebelum mencoba lagi.";
            return;
        }

        $this->validate();

        if (Auth::guard('admin')->attempt(['username' => $this->username, 'password' => $this->password])) {
            RateLimiter::clear($rateLimitKey);
            session()->regenerate();
            return redirect()->intended(route('admin.dashboard'));
        }

        RateLimiter::hit($rateLimitKey, 300);
        $this->errorMessage = 'Username atau password salah.';
    }

    public function render()
    {
        return view('livewire.login-form');
    }
}
