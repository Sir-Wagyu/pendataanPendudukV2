<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Password Baru - SIDUKTANG</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            line-height: 1.6;
            color: #333;
            background-color: #f4f7fa;
            margin: 0;
            padding: 0;
        }
        .email-container {
            max-width: 600px;
            margin: 20px auto;
            background: white;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 8px 32px rgba(0,0,0,0.1);
        }
        .header {
            background: linear-gradient(135deg, #3a6ea5 0%, #3a6ea5 100%);
            color: white;
            padding: 40px 30px;
            text-align: center;
            position: relative;
        }
        .header::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><defs><pattern id="grid" width="10" height="10" patternUnits="userSpaceOnUse"><path d="M 10 0 L 0 0 0 10" fill="none" stroke="rgba(255,255,255,0.1)" stroke-width="1"/></pattern></defs><rect width="100" height="100" fill="url(%23grid)"/></svg>');
            opacity: 0.3;
        }
        .header-content {
            position: relative;
            z-index: 1;
        }
        .logo {
            width: 60px;
            height: 60px;
            background: rgba(255,255,255,0.2);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 20px;
            font-size: 24px;
            font-weight: bold;
        }
        .header h1 {
            margin: 0;
            font-size: 28px;
            font-weight: 700;
            letter-spacing: 1px;
        }
        .header p {
            margin: 8px 0 0;
            font-size: 16px;
            opacity: 0.9;
        }
        .content {
            padding: 40px 30px;
        }
        .greeting {
            font-size: 18px;
            color: #3a6ea5;
            font-weight: 600;
            margin-bottom: 20px;
        }
        .message {
            font-size: 16px;
            margin-bottom: 30px;
            color: #555;
        }
        .password-section {
            background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
            border: 2px dashed #3a6ea5;
            padding: 30px;
            text-align: center;
            margin: 30px 0;
            border-radius: 12px;
            position: relative;
        }
        .password-section::before {
            content: '🔐';
            position: absolute;
            top: -15px;
            left: 50%;
            transform: translateX(-50%);
            background: white;
            padding: 5px 10px;
            border-radius: 20px;
            font-size: 20px;
        }
        .password-label {
            font-size: 14px;
            color: #666;
            margin-bottom: 10px;
            text-transform: uppercase;
            letter-spacing: 1px;
            font-weight: 600;
        }
        .password {
            font-size: 32px;
            font-weight: bold;
            color: #3a6ea5;
            font-family: 'Courier New', monospace;
            letter-spacing: 3px;
            background: white;
            padding: 15px 25px;
            border-radius: 8px;
            border: 2px solid #e2e8f0;
            display: inline-block;
            margin: 10px 0;
            box-shadow: 0 4px 6px rgba(0,0,0,0.05);
        }
        .warning-box {
            background: linear-gradient(135deg, #fef3c7 0%, #fde68a 100%);
            border-left: 4px solid #f59e0b;
            padding: 20px;
            margin: 30px 0;
            border-radius: 8px;
            position: relative;
        }
        .warning-box::before {
            content: '⚠️';
            position: absolute;
            top: -10px;
            left: 20px;
            background: #fbbf24;
            color: white;
            padding: 5px 8px;
            border-radius: 50%;
            font-size: 14px;
        }
        .warning-title {
            font-weight: 700;
            color: #92400e;
            margin-bottom: 10px;
            font-size: 16px;
        }
        .warning-list {
            margin: 15px 0;
            padding-left: 0;
            list-style: none;
        }
        .warning-list li {
            color: #92400e;
            margin: 8px 0;
            padding-left: 25px;
            position: relative;
        }
        .warning-list li::before {
            content: '✓';
            position: absolute;
            left: 0;
            color: #059669;
            font-weight: bold;
        }
        .login-button {
            display: inline-block;
            background: linear-gradient(135deg, #3a6ea5 0%, rgb(58, 121, 237) 100%);
            color: white;
            padding: 15px 35px;
            text-decoration: none;
            border-radius: 8px;
            font-weight: 600;
            font-size: 16px;
            margin: 20px 0;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(58, 121, 237, 0.3);
        }
        .login-button:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(58, 121, 237, 0.4);
            color: white;
            text-decoration: none;
        }
        .button-container {
            text-align: center;
            margin: 30px 0;
        }
        .footer {
            background: #f8fafc;
            padding: 30px;
            text-align: center;
            border-top: 1px solid #e2e8f0;
        }
        .footer-text {
            color: #64748b;
            font-size: 14px;
            margin: 5px 0;
        }
        .footer-brand {
            color: #3a6ea5;
            font-weight: 600;
            font-size: 16px;
        }
        .divider {
            height: 2px;
            background: linear-gradient(90deg, transparent 0%, #3a6ea5 50%, transparent 100%);
            margin: 30px 0;
            border-radius: 1px;
        }
        .security-notice {
            background: #f1f5f9;
            border: 1px solid #cbd5e1;
            padding: 20px;
            border-radius: 8px;
            margin: 20px 0;
        }
        .security-notice p {
            margin: 0;
            color: #475569;
            font-size: 14px;
        }
    </style>
</head>
<body>
    <div class="email-container">
        <!-- Header -->
        <div class="header">
            <div class="header-content">
                <div class="logo">🏠</div>
                <h1>SIDUKTANG</h1>
                <p>Sistem Data Kependudukan Pendatang</p>
            </div>
        </div>
        
        <!-- Content -->
        <div class="content">
            <div class="greeting">
                Selamat! Akun Anda Telah Diverifikasi ✅
            </div>
            
            <div class="message">
                Halo! Kami dengan senang hati memberitahukan bahwa akun Anda telah berhasil diverifikasi dan siap digunakan. 
                Berikut adalah password sementara untuk mengakses sistem SIDUKTANG.
            </div>
            
            <!-- Password Section -->
            <div class="password-section">
                <div class="password-label">Password Sementara Anda</div>
                <div class="password">{{ $password }}</div>
                <p style="margin: 15px 0 0; color: #666; font-size: 14px;">
                    Simpan password ini dengan aman
                </p>
            </div>
            
            <!-- Warning Box -->
            <div class="warning-box">
                <div class="warning-title">Langkah Selanjutnya untuk Keamanan Akun</div>
                <ul class="warning-list">
                    <li>Login menggunakan <strong>Username</strong> dan password di atas</li>
                    <li>Sistem akan meminta Anda <strong>mengganti password</strong> baru untuk keamanan</li>
                    <li>Pilih <strong>lokasi tempat tinggal</strong> Anda di peta</li>
                    <li>Jangan bagikan password ini kepada <strong>siapa pun</strong></li>
                </ul>
            </div>
            
            <div class="divider"></div>
            
            <!-- Login Button -->
            <div class="button-container">
                <a href="{{ route('login') }}" class="login-button">
                    🚀 Login Sekarang
                </a>
            </div>
            
            <!-- Security Notice -->
            <div class="security-notice">
                <p>
                    <strong>Catatan Keamanan:</strong> 
                    Jika Anda tidak mendaftar di sistem SIDUKTANG, silakan abaikan email ini atau 
                    hubungi administrator di <strong>admin@siduktang.com</strong>
                </p>
            </div>
        </div>
        
        <!-- Footer -->
        <div class="footer">
            <div class="footer-brand">SIDUKTANG</div>
            <div class="footer-text">Sistem Data Kependudukan Pendatang</div>
            <div class="footer-text">Tertib Administrasi • Kemudahan Pendataan • Legalitas Tinggal</div>
            <div class="footer-text" style="margin-top: 15px;">
                &copy; {{ date('Y') }} SIDUKTANG. Hak cipta dilindungi undang-undang.
            </div>
            <div class="footer-text" style="margin-top: 5px; font-size: 12px;">
                Email ini dikirim secara otomatis, mohon tidak membalas.
            </div>
        </div>
    </div>
</body>
</html>