<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Pembayaran Langganan Berhasil</title>
</head>
<body style="font-family: Arial, sans-serif; line-height: 1.6; color: #333; max-width: 600px; margin: 0 auto; padding: 20px;">
    
    <div style="background-color: #f8fafc; padding: 20px; border-radius: 8px; text-align: center; margin-bottom: 30px;">
        <h1 style="color: #4f46e5; margin: 0;">SB Digital</h1>
    </div>

    <h2 style="color: #1e293b;">Terima kasih atas pembayaran Anda!</h2>
    
    <p>Halo,</p>
    <p>Pembayaran langganan untuk portal perumahan Anda telah kami terima dan paket langganan Anda kini telah aktif.</p>
    
    <div style="background-color: #f1f5f9; padding: 20px; border-radius: 8px; margin: 20px 0;">
        <h3 style="margin-top: 0; color: #334155;">Detail Tagihan:</h3>
        <table style="width: 100%; border-collapse: collapse;">
            <tr>
                <td style="padding: 8px 0; border-bottom: 1px solid #e2e8f0; color: #64748b;">Paket</td>
                <td style="padding: 8px 0; border-bottom: 1px solid #e2e8f0; font-weight: bold; text-align: right;">{{ $subscription->plan->name ?? '-' }}</td>
            </tr>
            <tr>
                <td style="padding: 8px 0; border-bottom: 1px solid #e2e8f0; color: #64748b;">Nominal</td>
                <td style="padding: 8px 0; border-bottom: 1px solid #e2e8f0; font-weight: bold; text-align: right;">Rp {{ number_format($subscription->amount, 0, ',', '.') }}</td>
            </tr>
            <tr>
                <td style="padding: 8px 0; border-bottom: 1px solid #e2e8f0; color: #64748b;">Status</td>
                <td style="padding: 8px 0; border-bottom: 1px solid #e2e8f0; font-weight: bold; text-align: right; color: #10b981;">LUNAS</td>
            </tr>
            <tr>
                <td style="padding: 8px 0; color: #64748b;">Tanggal Dibayar</td>
                <td style="padding: 8px 0; font-weight: bold; text-align: right;">{{ $subscription->paid_at ? $subscription->paid_at->format('d M Y H:i') : now()->format('d M Y H:i') }}</td>
            </tr>
        </table>
    </div>

    <p>Sekarang Anda dapat kembali ke Dashboard untuk menikmati seluruh fitur dari paket {{ $subscription->plan->name ?? '' }} Anda.</p>
    
    <div style="text-align: center; margin: 30px 0;">
        <a href="{{ config('app.url') }}" style="background-color: #4f46e5; color: #ffffff; padding: 12px 24px; text-decoration: none; border-radius: 6px; font-weight: bold; display: inline-block;">Kembali ke Dashboard</a>
    </div>

    <hr style="border: none; border-top: 1px solid #e2e8f0; margin: 30px 0;">
    
    <p style="font-size: 12px; color: #94a3b8; text-align: center;">
        Email ini dibuat secara otomatis, mohon tidak membalas email ini.<br>
        &copy; {{ date('Y') }} SB Digital. All rights reserved.
    </p>
</body>
</html>
