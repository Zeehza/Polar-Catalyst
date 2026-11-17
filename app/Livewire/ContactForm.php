<?php

namespace App\Livewire;

use App\Models\ContactSubmission;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\RateLimiter;
use Livewire\Component;

class ContactForm extends Component
{
    public string $name = '';
    public string $company = '';
    public string $email = '';
    public string $message = '';
    public string $website = ''; // Honeypot

    public ?string $successMessage = null;
    public ?string $errorMessage = null;

    protected $rules = [
        'name' => 'required|string|min:2|max:100',
        'company' => 'nullable|string|max:100',
        'email' => 'required|email|max:150',
        'message' => 'required|string|min:5|max:3000',
    ];

    protected $messages = [
        'name.required' => 'Nama lengkap wajib diisi.',
        'name.min' => 'Nama harus berisi minimal 2 karakter.',
        'name.max' => 'Nama maksimal 100 karakter.',
        'company.max' => 'Nama perusahaan maksimal 100 karakter.',
        'email.required' => 'Alamat email wajib diisi.',
        'email.email' => 'Format alamat email tidak valid.',
        'email.max' => 'Email maksimal 150 karakter.',
        'message.required' => 'Pesan wajib diisi.',
        'message.min' => 'Pesan harus berisi minimal 5 karakter.',
        'message.max' => 'Pesan maksimal 3000 karakter.',
    ];

    public function submit()
    {
        $this->errorMessage = null;
        $this->successMessage = null;

        // Rate limiting: max 5 per 10 minutes
        $ip = request()->ip();
        $rateLimitKey = 'contact:' . $ip;

        if (RateLimiter::tooManyAttempts($rateLimitKey, 5)) {
            $seconds = RateLimiter::availableIn($rateLimitKey);
            $minutes = ceil($seconds / 60);
            $this->errorMessage = "Terlalu banyak permintaan dari koneksi Anda. Silakan tunggu {$minutes} menit sebelum mencoba lagi.";
            return;
        }

        RateLimiter::hit($rateLimitKey, 600);

        // Honeypot spam check
        if (!empty($this->website)) {
            $this->successMessage = "Pesan Anda berhasil dikirim! Tim kami akan segera menghubungi Anda.";
            return;
        }

        $this->validate();

        try {
            $submission = ContactSubmission::create([
                'name' => trim($this->name),
                'company' => trim($this->company) ?: null,
                'email' => trim($this->email),
                'message' => trim($this->message),
            ]);

            // Discord Webhook
            $webhookUrl = config('services.discord.webhook_url') ?: env('DISCORD_WEBHOOK_URL');
            if ($webhookUrl) {
                try {
                    $discordPayload = [
                        'content' => 'Terdapat submission form kontak baru!',
                        'embeds' => [
                            [
                                'title' => 'Contact Form Submission',
                                'color' => 16711680,
                                'fields' => [
                                    ['name' => 'Nama', 'value' => substr($submission->name, 0, 100), 'inline' => true],
                                    ['name' => 'Perusahaan', 'value' => $submission->company ? substr($submission->company, 0, 100) : '-', 'inline' => true],
                                    ['name' => 'Email', 'value' => substr($submission->email, 0, 150), 'inline' => false],
                                    ['name' => 'Pesan', 'value' => substr($submission->message, 0, 1000), 'inline' => false],
                                ],
                                'timestamp' => now()->toIso8601String(),
                            ],
                        ],
                    ];

                    $res = Http::post($webhookUrl, $discordPayload);
                    if ($res->successful()) {
                        $submission->update(['discordSent' => true]);
                    }
                } catch (\Throwable $e) {
                    \Log::error('Discord webhook error: ' . $e->getMessage());
                }
            }

            // Resend Email (if key configured)
            $resendKey = env('RESEND_API_KEY');
            if ($resendKey) {
                try {
                    $safeName = e($submission->name);
                    $safeCompany = $submission->company ? e($submission->company) : '-';
                    $safeEmail = e($submission->email);
                    $safeMessage = nl2br(e($submission->message));

                    $res = Http::withToken($resendKey)->post('https://api.resend.com/emails', [
                        'from' => 'Acme <onboarding@resend.dev>',
                        'to' => ['admin@polarcatalyst.com'],
                        'subject' => "Pesan Kontak: {$safeName} ({$safeCompany})",
                        'html' => "<h2>Pesan Baru dari Form Kontak</h2>
                            <p><strong>Nama:</strong> {$safeName}</p>
                            <p><strong>Perusahaan:</strong> {$safeCompany}</p>
                            <p><strong>Email:</strong> {$safeEmail}</p>
                            <p><strong>Pesan:</strong><br/>{$safeMessage}</p>",
                    ]);

                    if ($res->successful()) {
                        $submission->update(['emailSent' => true]);
                    }
                } catch (\Throwable $e) {
                    \Log::error('Resend email error: ' . $e->getMessage());
                }
            }

            $this->reset(['name', 'company', 'email', 'message', 'website']);
            $this->successMessage = 'Pesan Anda berhasil dikirim! Tim kami akan segera menghubungi Anda.';
        } catch (\Throwable $e) {
            \Log::error('Contact form error: ' . $e->getMessage());
            $this->errorMessage = 'Terjadi kesalahan internal saat memproses pesan Anda. Silakan coba lagi nanti.';
        }
    }

    public function render()
    {
        return view('livewire.contact-form');
    }
}
