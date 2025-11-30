<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="csrf-token" content="{{ csrf_token() }}" />

    <title>{{ config('app.name') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net" />
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <style>
        .eye {
            position: absolute;
            right: 12px;
            top: 70%;
            transform: translateY(-50%);
            cursor: pointer;
        }
        .focus\:ring-primary-500:focus {
            --tw-ring-color: #1469B5 !important;
        }

        .focus\:border-primary-500:focus {
            border: 1px solid #1469B5 !important;
        }

        input:-webkit-autofill {
            -webkit-box-shadow: 0 0 0 1000px transparent inset !important;
            -webkit-text-fill-color: white !important;
            background-color: transparent !important;
            color: white !important;
            transition: background-color 5000s ease-in-out 0s;
        }

        @media (max-width: 768px) {
            .login-page .overflow-hidden {
                display: none;
            }

            .login-page {
                display: grid !important;
                grid-template-columns: 1fr !important
            }
        }
    </style>

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

</head>

<body class="font-sans text-gray-900 antialiased">
    <div class="h-screen login-page grid grid-cols-2">
        <div class="relative overflow-hidden sm:w-full">
            <img src="{{ asset('assets/images/logo-background.png') }}" alt=""
                class="w-full h-full object-cover" />
        </div>
        <div class="relative login flex justify-center items-center"
            style="background-image: url('{{ asset('assets/images/Admin login.png') }}')">
            <div style="background-color:rgba(0, 0, 0, 0.12); backdrop-filter: blur(6px); border-radius: 16px; box-shadow: 0 4px 8px #00000094;width:78%">
                {{ $slot }}
            </div>

        </div>
    </div>
</body>
<script>
    function showHidePassword() {
        const password = document.getElementById("password");
        const toggle = document.getElementById("togglePassword");

        const isPassword = password.getAttribute("type") === "password";
        password.setAttribute("type", isPassword ? "text" : "password");

        // Toggle the image
        toggle.src = isPassword ?
            "{{ asset('assets/images/eye.svg') }}" :
            "{{ asset('assets/images/eye-disable.svg') }}";
    }

    const setLoginCredential = function() {
        var password = document.getElementById("password");
        var email = document.getElementById("email");
        email.value = 'root@example.com';
        password.value = 'password';
    }
</script>

</html>
