<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Selamat Datang - WarungWeb</title>

    <link rel="icon" type="image/png" href="{{ asset('images/warungweB.png') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Crimson+Pro:ital,wght@0,200..900;1,200..900&display=swap" rel="stylesheet">

    <style>
        /* Warna dan animasi mengikuti halaman login dan register */
        :root {
            --primary-color: #003366; 
            --primary-color-darker: #002244;
            --text-color: #222222;
            --text-color-muted: #444444;
            --border-color: #d3d3d3;
            --white: #ffffff;
        }

        @keyframes backgroundAnimate {
            0%   { background-position: 0% 50%; }
            50%  { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }

        body {
            font-family: "Crimson Pro", serif;
            font-weight: 400;
            font-style: normal;
            background: linear-gradient(-45deg, #003366, #005960, #43D4C4);
            background-size: 400% 400%;
            animation: backgroundAnimate 15s ease infinite;
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            margin: 0;
            color: var(--text-color);
        }

        /* wrapper utama kedua kolom (info + login/register). responsif di mobile */
        .page-wrapper {
            width: 100%;
            max-width: 960px;
            margin: 20px;
            padding: 24px;
            box-sizing: border-box;

            background-color: rgba(255, 255, 255, 0.88);
            backdrop-filter: blur(10px);
            border-radius: 16px;
            border: 1px solid rgba(255, 255, 255, 0.35);
            box-shadow: 0 12px 40px rgba(0, 0, 0, 0.18);

            display: flex;
            gap: 32px;
            align-items: stretch;
        }

        /* Mobile: tumpuk ke bawah */
        @media (max-width: 768px) {
            .page-wrapper {
                flex-direction: column;
                padding: 18px;
                gap: 20px;
            }

            .card-column {
                flex: 1;
            }

            .login-card {
                max-width: 100%;
            }
        }

        /* Kolom info */
        .info-column {
            flex: 1.1;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        /* Header info */
        .info-header {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 10px;
        }

        .info-header img {
            width: 52px;
            height: 52px;
            object-fit: contain;
        }

        .info-header h1 {
            font-size: 1.7rem;
            margin: 0;
            color: var(--primary-color-darker);
        }

        .info-subtitle {
            margin: 0 0 16px 0;
            font-size: 0.98rem;
            color: var(--text-color-muted);
        }

        .info-block {
            margin-bottom: 12px;
            font-size: 0.96rem;
            color: var(--text-color);
        }

        .info-block p {
            margin: 0.35rem 0;
        }

        .info-list-title {
            margin: 10px 0 4px;
            font-weight: 600;
            color: var(--primary-color-darker);
        }

        .info-list {
            margin: 0 0 0 1.2rem;
            padding: 0;
            font-size: 0.94rem;
            color: var(--text-color-muted);
        }

        .info-list li {
            margin-bottom: 4px;
        }

        .small-note {
            margin-top: 12px;
            font-size: 0.82rem;
            color: var(--text-color-muted);
        }

        /* Kolom card login/register */
        .card-column {
            flex: 0 0 360px;      
            display: flex;
            justify-content: center;
            align-items: center;
        }

        /* Card login/register */
        .login-card {
            width: 100%;
            max-width: 360px;
            padding: 26px 24px;
            border-radius: 14px;
            border: 1px solid var(--border-color);
            background-color: rgba(255, 255, 255, 0.96);
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.08);
            box-sizing: border-box;
            text-align: center;
        }

        .login-card img {
            max-width: 90px;
            height: auto;
            margin-bottom: 10px;
        }

        .login-card h2 {
            margin: 0;
            font-size: 1.4rem;
            color: var(--text-color);
        }

        .login-card p {
            margin: 6px 0 16px;
            font-size: 0.9rem;
            color: var(--text-color-muted);
        }

        .button-group {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 8px;
            margin-top: 8px;
        }

        @media (min-width: 768px) {
            .button-group {
                flex-direction: row;
                justify-content: center;
            }
        }

        /* Tombol utama dan outline */
        .btn-main,
        .btn-outline {
            padding: 0.5rem 1.2rem;
            border-radius: 999px;
            font-weight: 600;
            font-size: 0.85rem;
            cursor: pointer;
            text-decoration: none;
            display: inline-block;
            min-width: 120px;
            max-width: 180px;
            text-align: center;
            transition: all 0.22s ease;
        }

        .btn-main {
            background-color: var(--primary-color);
            color: var(--white);
            border: 1px solid var(--primary-color);
        }

        .btn-main:hover {
            background-color: var(--primary-color-darker);
        }

        .btn-outline {
            background-color: transparent;
            color: var(--primary-color);
            border: 1px solid var(--primary-color);
        }

        .btn-outline:hover {
            background-color: rgba(0, 51, 102, 0.07);
        }

        .card-footer-note {
            margin-top: 12px;
            font-size: 0.78rem;
            color: var(--text-color-muted);
        }
    </style>
</head>
<body>

<!-- Wrapper utama kedua kolom -->
<div class="page-wrapper">
    {{-- Kolom kiri: informasi --}}
    <div class="info-column">
        <div class="info-header">
            <img src="{{ asset('images/warungweB.png') }}" alt="Logo Warung Sembako">
            <h1>Selamat Datang di WarungWeb</h1>
        </div>
        <p class="info-subtitle">
            Sistem manajemen warung sembako yang membantu mencatat stok, penjualan, hutang piutang,
            hingga laporan sederhana. Semuanya di satu tempat.
        </p>

        <div class="info-block">
            <p>
                Jika Anda adalah <strong>kasir baru</strong> dan belum memiliki akun,
                silakan melakukan pendaftaran terlebih dahulu melalui tombol <strong>Register</strong>.
            </p>
            <p>
                Jika Anda sudah memiliki akun sebagai <strong>kasir</strong> atau <strong>admin</strong>,
                Anda dapat langsung masuk ke sistem menggunakan tombol <strong>Login</strong>.
            </p>
        </div>

        <div class="info-block">
            <p class="info-list-title">Kesimpulan:</p>
            <ul class="info-list">
                <li><strong>Kasir baru</strong> → klik <em>Register</em>, isi data akun Anda.</li>
                <li><strong>Kasir lama & Admin</strong> → klik <em>Login</em> dan masukkan email & password.</li>
            </ul>
        </div>

        <div class="small-note">
            Hak akses dan tampilan menu akan berbeda untuk kasir dan admin sesuai peran masing-masing.
        </div>
    </div>

    {{-- Kolom kanan: card login/register --}}
    <div class="card-column">
        <div class="login-card">
            <img src="{{ asset('images/warungweB.png') }}" alt="Logo Warung Sembako">

            <h2>Masuk ke WarungWeb</h2>
            <p>
                Pilih opsi sesuai kebutuhan Anda untuk mulai menggunakan web.
            </p>

            <div class="button-group">
                <a href="{{ route('login') }}" class="btn-main">
                    Login
                </a>
                <a href="{{ route('register') }}" class="btn-outline">
                    Register
                </a>
            </div>

            <div class="card-footer-note">
                &copy; {{ date('Y') }} WarungWeb — untuk tugas framework.
            </div>
        </div>
    </div>
</div>

</body>
</html>
