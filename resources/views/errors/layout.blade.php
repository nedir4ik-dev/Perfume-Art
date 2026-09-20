<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="images/favicon/logo.png" type="image/x-icon">
    <title>@yield('title', 'Ýalňyşlyk') | Perfume-Art</title>

    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/icons/bootstrap-icons.css') }}">

    <style>
        body {
            background-color: #0a0a0a;
            color: #ffffff;
            font-family: 'Inter', sans-serif;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
            overflow: hidden;
        }

        /* 🎯 Pop-up ýaly dury we modern kart gabygy */
        .error-card {
            background: rgba(31, 30, 30, 0.51);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.08);
            border-radius: 24px;
            max-width: 460px;
            width: 100%;
            padding: 40px 30px;
            box-shadow: 0 30px 60px rgba(0, 0, 0, 0.6);
            text-align: center;
        }

        /* ⚡ Uly neon reňkli error kody */
        .error-code {
            font-size: 5.5rem;
            font-weight: 800;
            line-height: 1;
            color: #0dcaf093;
            text-shadow: 0 0 40px rgba(13, 202, 240, 0.2);
            letter-spacing: -1px;
            margin-bottom: 20px;
        }

        .error-title {
            font-size: 1.3rem;
            font-weight: 700;
            color: #ffffff;
            margin-bottom: 12px;
            text-transform: uppercase;
        }

        .error-text {
            font-size: 0.9rem;
            color: rgba(255, 255, 255, 0.6);
            line-height: 1.6;
            margin-bottom: 30px;
        }

        /* Modern we ýumşak düwmeler */
        .error-btn {
            background: rgba(31, 30, 30, 0.51);
            color: rgba(255, 255, 255, 0.7);
            border: 1px solid rgba(255, 255, 255, 0.15);
            font-size: 0.95rem;
            transition: all 0.3s ease;
        }

        .error-btn:hover {
            background: rgba(31, 30, 30, 0.51);
            color: #ffffff;
            border-color: rgba(255, 255, 255, 0.2);
            box-shadow: 0 10px 20px rgba(13, 202, 240, 0.2);
        }

        .error-btn-outline {
            background: transparent;
            color: rgba(255, 255, 255, 0.7);
            border: 1px solid rgba(255, 255, 255, 0.15);
            font-size: 0.95rem;
            transition: all 0.3s ease;
        }

        .error-btn-outline:hover {
            background: rgba(255, 255, 255, 0.05);
            color: #ffffff;
            border-color: rgba(255, 255, 255, 0.2);
            box-shadow: 0 10px 20px rgba(13, 202, 240, 0.2);
        }
    </style>
</head>

<body>

    <div class="error-card">
        <div class="error-code">@yield('code', 'ERR')</div>

        <div class="error-title">@yield('heading', 'YALŇYŞLYK DÖREDI')</div>

        {{-- Message (Eger berilmese taýýar tekst çykýar) --}}
        <div class="error-text">
            @hasSection('message')
            @yield('message')
            @endif
        </div>

        {{-- Düwmeler toplumy --}}
        <div class="d-flex flex-column gap-2">
            <a href="{{ url('/') }}" class="btn error-btn rounded-pill px-4 py-2 fw-bold w-100">
                <i class="bi bi-house-door-fill me-2"></i> Go to Home Page
            </a>

            <button onclick="history.back()" class="btn error-btn-outline rounded-pill px-4 py-2 fw-semibold w-100">
                <i class="bi bi-arrow-left me-2"></i> Yza gaýtmak
            </button>
        </div>
    </div>

</body>

</html>