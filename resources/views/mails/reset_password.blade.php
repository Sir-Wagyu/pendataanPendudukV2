{{-- resources/views/emails/send-password.blade.php --}}
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Password Baru SIDUKTANG</title>
    <style>
        body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; background: #f8f9fa; }
        .container { max-width: 600px; margin: 20px auto; background: white; border-radius: 8px; overflow: hidden; box-shadow: 0 4px 6px rgba(0,0,0,0.1); }
        .header { background: #3a6ea5; color: white; padding: 30px; text-align: center; }
        .content { padding: 40px 30px; }
        .password-box { background: #f8f9fa; border: 2px dashed #3a6ea5; padding: 20px; text-align: center; margin: 20px 0; border-radius: 8px; }
        .password { font-size: 24px; font-weight: bold; color: #3a6ea5; font-family: monospace; letter-spacing: 2px; }
        .warning { background: #fff3cd; border-left: 4px solid #ffc107; padding: 15px; margin: 20px 0; }
        .footer { text-align: center; padding: 20px; color: #666; font-size: 12px; background: #f8f9fa; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>🏠 SIDUKTANG</h1>
            <p>Sistem Data Kependudukan Pendatang</p>
        </div>
        
        <div class="content">
            <h2>Password Baru Anda</h2>
            <p>Halo! Kami telah membuat password baru untuk akun Anda sesuai permintaan.</p>
            
            <div class="password-box">
                <p style="margin: 0; color: #666; font-size: 14px;">Password Baru Anda:</p>
                <div class="password">{{ $password }}</div>
            </div>
            
            <div class="warning">
                <h4 style="margin-top: 0; color: #856404;">⚠️ Penting untuk Keamanan:</h4>
                <ul style="margin: 10px 0; padding-left: 20px; color: #856404;">
                    <li>Silakan login dengan password di atas</li>
                    <li>Sistem akan meminta Anda mengganti password ini</li>
                    <li>Pilih lokasi Anda untuk menyelesaikan setup</li>
                    <li>Jangan bagikan password ini kepada siapa pun</li>
                </ul>
            </div>
            
            <div style="text-align: center; margin: 30px 0;">
                <a href="{{ route('login') }}" 
                   style="background: #4F46E5; color: white; padding: 12px 30px; text-decoration: none; border-radius: 6px; display: inline-block; font-weight: bold;">
                    Login Sekarang
                </a>
            </div>
            
            <p style="color: #666; font-size: 14px;">
                Jika Anda tidak meminta reset password, silakan abaikan email ini atau hubungi administrator.
            </p>
        </div>
        
        <div class="footer">
            <p>&copy; {{ date('Y') }} SIDUKTANG. All rights reserved.</p>
            <p>Email ini dikirim secara otomatis, mohon tidak membalas.</p>
        </div>
    </div>
</body>
</html>