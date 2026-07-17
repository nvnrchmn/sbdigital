<?php

namespace App\Providers;

use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // FIX (b): daftarkan eksplisit supaya email verifikasi benar-benar terkirim
        // saat event Registered dipicu (tidak bisa mengandalkan auto-discovery karena
        // listener ini ada di namespace framework, bukan di app/Listeners).
        Event::listen(Registered::class, SendEmailVerificationNotification::class);

        try {
            if (\Illuminate\Support\Facades\Schema::hasTable('settings')) {
                $mailMailer = \App\Models\Setting::get('mail_mailer');
                if ($mailMailer) {
                    config([
                        'mail.default' => $mailMailer,
                        'mail.mailers.smtp.host' => \App\Models\Setting::get('mail_host', config('mail.mailers.smtp.host')),
                        'mail.mailers.smtp.port' => \App\Models\Setting::get('mail_port', config('mail.mailers.smtp.port')),
                        'mail.mailers.smtp.username' => \App\Models\Setting::get('mail_username', config('mail.mailers.smtp.username')),
                        'mail.mailers.smtp.password' => \App\Models\Setting::get('mail_password', config('mail.mailers.smtp.password')),
                        'mail.mailers.smtp.encryption' => \App\Models\Setting::get('mail_encryption', config('mail.mailers.smtp.encryption')),
                        'mail.from.address' => \App\Models\Setting::get('mail_from_address', config('mail.from.address')),
                        'mail.from.name' => \App\Models\Setting::get('mail_from_name', config('mail.from.name')),
                    ]);
                }
            }
        } catch (\Exception $e) {
            // Log setting error
        }
    }
}
