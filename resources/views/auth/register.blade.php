<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - Warung Sembako</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Crimson+Pro:ital,wght@0,200..900;1,200..900&display=swap" rel="stylesheet">

    <style>
        :root {
            --primary-color: #003366; 
            --primary-color-darker: #002244;
            --text-color: #333;
            --text-color-light: #666;
            --border-color: #ddd;
            --background-color: #f4f7f6; /* Tidak terpakai lagi oleh body */
            --white: #ffffff;
            --danger-color: #e3342f;
        }

        @@keyframes backgroundAnimate {
            0% {
                background-position: 0% 50%;
            }
            50% {
                background-position: 100% 50%;
            }
            100% {
                background-position: 0% 50%;
            }
        }
        body {         
            font-family: "Crimson Pro", serif;
            font-optical-sizing: auto;
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

        .login-container {
            
            background-color: rgba(255, 255, 255, 0.85); 
            backdrop-filter: blur(10px); 
            
            padding: 3rem;
            border-radius: 12px; /* Dibuat lebih bulat agar lebih modern */
            border: 1px solid rgba(255, 255, 255, 0.2); /* Border 'kaca' tipis */
            box-shadow: 0 8px 32px 0 rgba(0, 0, 0, 0.1); /* Shadow lebih halus */
            width: 100%;
            max-width: 420px;
            box-sizing: border-box;
        }

        .login-header {
            text-align: center;
            margin-bottom: 2rem;
        }

        .login-header img {
            max-width: 120px;
            height: auto;
            margin-bottom: 1rem;
        }

        .login-header h1 {
            font-size: 2rem;
            margin: 0;
            color: var(--text-color);
        }

        .login-header p {
            font-size: 1rem;
            color: var(--text-color-light);
            margin-top: 0.5rem;
        }

        .form-group {
            margin-bottom: 1.25rem;
        }

        .form-group label {
            display: block;
            margin-bottom: 0.5rem;
            font-weight: 600;
            font-size: 0.875rem;
            color: var(--text-color);
        }

        .form-group input[type="email"],
        .form-group input[type="password"],
        .form-group input[type="text"] { 
            width: 100%;
            padding: 0.75rem 1rem;
            border: 1px solid var(--border-color);
            border-radius: 4px;
            box-sizing: border-box;
            font-size: 1rem;
        }

        .form-group input:focus {
            outline: none;
            border-color: var(--primary-color);
            box-shadow: 0 0 0 2px rgba(0, 51, 102, 0.2);
        }

        /* Tombol diganti menjadi Biru Dongker */
        .login-button { 
            background-color: var(--primary-color);
            color: var(--white);
            border: none;
            width: 100%;
            padding: 0.875rem;
            font-size: 1rem;
            font-weight: 700;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s ease;
            margin-top: 1rem; /* Beri sedikit jarak dari field terakhir */
        }

        .login-button:hover {
            background-color: var(--primary-color-darker);
        }

        .register-link {
            text-align: center;
            margin-top: 1.5rem;
            border-top: 1px solid var(--border-color);
            padding-top: 1.5rem;
            font-size: 0.9rem;
            color: var(--text-color-light);
        }

        .register-link a {
            color: var(--primary-color);
            font-weight: 600;
            text-decoration: none;
        }

        .register-link a:hover {
            text-decoration: underline;
        }
        
        .invalid-feedback {
            color: var(--danger-color);
            font-size: 0.875rem;
            margin-top: 0.25rem;
        }

        input.is-invalid {
            border-color: var(--danger-color);
        }

    </style>
</head>
<body>

    <div class="login-container">
        <div class="login-header">
            <img src="{{ asset('images/warungweB.png') }}" alt="Logo Warung Sembako">
            
            <h1>Warung Sembako</h1>
            <p>Kelola Usaha Jadi Lebih Mudah 💼</p>
        </div>

        <form method="POST" action="{{ route('register') }}">
            @csrf

            <div class="form-group">
                <label for="name">Nama</label>
                <input id="name" type="text" name="name" value="{{ old('name') }}" required autofocus
                       class="@error('name') is-invalid @enderror">
                
                @error('name')
                    <div class="invalid-feedback" role="alert">
                        {{ $message }}
                    </div>
                @enderror
            </div>

            <div class="form-group">
                <label for="email">Email</label>
                <input id="email" type="email" name="email" value="{{ old('email') }}" required
                       class="@error('email') is-invalid @enderror">
                
                @error('email')
                    <div class="invalid-feedback" role="alert">
                        {{ $message }}
                    </div>
                @enderror
            </div>

            <div class="form-group">
                <label for="password">Password</label>
                <input id="password" type="password" name="password" required
                       class="@error('password') is-invalid @enderror">
                
                @error('password')
                    <div class="invalid-feedback" role="alert">
                        {{ $message }}
                    </div>
                @enderror
            </div>
            
            <div class="form-group">
                <label for="password-confirmation">Konfirmasi Password</label>
                <input id="password-confirmation" type="password" name="password_confirmation" required>
            </div>


            <button type="submit" class="login-button">
                Daftar
            </button>
        </form>

        <div class="register-link">
            <p>
                Sudah punya akun?
                <a href="{{ route('login') }}">Login Sekarang</a>
            </p>
        </div>
    </div>

</body>
</html>