<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Verifikasi Pendaftaran Tenant SBDigital</title>
</head>
<body style="font-family: Arial, sans-serif; background-color: #f8fafc; padding: 20px;">
    <div style="max-w: 600px; margin: 0 auto; background-color: #ffffff; padding: 30px; border-radius: 8px; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);">
        <h2 style="color: #1e293b; text-align: center;">Halo, {{ $adminName }}!</h2>
        <p style="color: #475569; font-size: 16px; line-height: 1.5;">
            Terima kasih telah mendaftar di SBDigital untuk perumahan <strong>{{ $namaPerumahan }}</strong>. 
            Satu langkah lagi untuk mulai mengelola lingkungan Anda dengan lebih baik!
        </p>
        <div style="text-align: center; margin: 30px 0;">
            <a href="{{ $verificationUrl }}" style="background-color: #4f46e5; color: #ffffff; padding: 12px 24px; text-decoration: none; border-radius: 6px; font-weight: bold; display: inline-block;">
                Verifikasi Email Sekarang
            </a>
        </div>
        <p style="color: #64748b; font-size: 14px; line-height: 1.5;">
            Jika tombol di atas tidak berfungsi, Anda juga bisa menyalin dan menempel tautan berikut di browser Anda: <br>
            <a href="{{ $verificationUrl }}" style="color: #4f46e5; word-break: break-all;">{{ $verificationUrl }}</a>
        </p>
        <hr style="border: none; border-top: 1px solid #e2e8f0; margin: 30px 0;">
        <p style="color: #94a3b8; font-size: 12px; text-align: center;">
            &copy; {{ date('Y') }} SBDigital. All rights reserved.
        </p>
    </div>
</body>
</html>
