<!DOCTYPE html>
<html lang="en" data-theme="light">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Login</title>
    <!-- Tailwind CSS -->
    <link href="{{ mix('css/style.css') }}" rel="stylesheet">

    <style>
        .fade-in {
            animation: fadeIn ease 2s;
        }

        @keyframes fadeIn {
            0% {opacity:0;}
            100% {opacity:1;}
        }
    </style>
</head>

<body class="flex items-center justify-center min-h-screen bg-gradient-to-r from-blue-500 to-teal-500">
    <div
        class="w-full max-w-md p-8 space-y-6 bg-white bg-opacity-90 rounded-lg shadow-lg transition-transform transform hover:scale-105 hover:shadow-2xl fade-in">
        <h2 class="text-4xl font-extrabold text-center text-gray-900 bounce">Login</h2>
        <p class="text-center text-gray-600">Welcome back! Please login to your account.</p>

        @if ($errors->any())
            <div class="p-4 mb-4 text-sm text-red-700 bg-red-100 rounded-lg">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('member.login.submit') }}">
            @csrf

            <div class="form-control">
                <label for="email" class="label">
                    <span class="label-text text-gray-700">Email</span>
                </label>
                <input id="email" type="email" name="email"
                    class="input input-bordered w-full transition duration-200 ease-in-out transform hover:scale-105 focus:ring-2 focus:ring-blue-500"
                    value="{{ old('email') }}" required autofocus>
                @error('email')
                    <div class="mt-1 text-sm text-red-600">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-control">
                <label for="password" class="label">
                    <span class="label-text text-gray-700">Password</span>
                </label>
                <input id="password" type="password" name="password"
                    class="input input-bordered w-full transition duration-200 ease-in-out transform hover:scale-105 focus:ring-2 focus:ring-blue-500"
                    required autocomplete="current-password">
                @error('password')
                    <div class="mt-1 text-sm text-red-600">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-control mt-6">
                <button type="submit"
                    class="btn btn-primary w-full bg-gradient-to-r from-blue-500 to-teal-500 text-white transition duration-200 ease-in-out transform hover:scale-105 hover:bg-gradient-to-r hover:from-teal-500 hover:to-blue-500">Login</button>
            </div>

            <div class="text-center mt-4">
                <a href="{{ route('signUp') }}" class="text-sm text-gray-600 hover:text-gray-900">Daftar Sekarang!</a>
            </div>
        </form>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const formControls = document.querySelectorAll('.form-control input');
            formControls.forEach(input => {
                input.addEventListener('focus', function () {
                    this.classList.add('shadow-lg', 'transform', 'scale-105');
                });
                input.addEventListener('blur', function () {
                    this.classList.remove('shadow-lg', 'transform', 'scale-105');
                });
            });
        });
    </script>
</body>

</html>
