<?php

namespace App\Livewire\Central\Settings;

use Livewire\Component;
use App\Models\Setting;
use Livewire\Attributes\Layout;

#[Layout('layouts.superadmin')]
class Index extends Component
{
    public $activeTab = 'logikraf';

    // Logikraf Settings
    public $logikraf_api_key;
    public $logikraf_webhook_secret;

    // Mail Settings
    public $mail_mailer;
    public $mail_host;
    public $mail_port;
    public $mail_username;
    public $mail_password;
    public $mail_encryption;
    public $mail_from_address;
    public $mail_from_name;

    public function mount()
    {
        abort_unless(auth()->user()->hasRole('Super Admin'), 403, 'Akses ditolak.');

        // Load Logikraf
        $this->logikraf_api_key = Setting::get('logikraf_api_key');
        $this->logikraf_webhook_secret = Setting::get('logikraf_webhook_secret');

        // Load Mail
        $this->mail_mailer = Setting::get('mail_mailer', 'smtp');
        $this->mail_host = Setting::get('mail_host', '127.0.0.1');
        $this->mail_port = Setting::get('mail_port', '2525');
        $this->mail_username = Setting::get('mail_username');
        $this->mail_password = Setting::get('mail_password');
        $this->mail_encryption = Setting::get('mail_encryption', 'tls');
        $this->mail_from_address = Setting::get('mail_from_address', 'hello@example.com');
        $this->mail_from_name = Setting::get('mail_from_name', 'SBDigital');
    }

    public function saveLogikraf()
    {
        Setting::set('logikraf_api_key', $this->logikraf_api_key);
        Setting::set('logikraf_webhook_secret', $this->logikraf_webhook_secret);

        $this->dispatch('notify', [
            'message' => 'Pengaturan Logikraf berhasil disimpan!',
            'icon' => 'success'
        ]);
    }

    public function saveMail()
    {
        Setting::set('mail_mailer', $this->mail_mailer);
        Setting::set('mail_host', $this->mail_host);
        Setting::set('mail_port', $this->mail_port);
        Setting::set('mail_username', $this->mail_username);
        Setting::set('mail_password', $this->mail_password);
        Setting::set('mail_encryption', $this->mail_encryption);
        Setting::set('mail_from_address', $this->mail_from_address);
        Setting::set('mail_from_name', $this->mail_from_name);

        $this->dispatch('notify', [
            'message' => 'Pengaturan Email SMTP berhasil disimpan!',
            'icon' => 'success'
        ]);
    }

    public function render()
    {
        $webhookUrl = url('/webhook/logikraf');
        return view('livewire.central.settings.index', compact('webhookUrl'));
    }
}
