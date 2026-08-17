<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Login - KAIH App</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="min-h-screen bg-gradient-to-br from-indigo-600 via-purple-600 to-indigo-800">

<div class="min-h-screen flex items-center justify-center px-4 py-8">

    <div class="w-full max-w-md">

        {{-- Logo --}}
        <div class="text-center mb-8">

            <div class="inline-flex items-center justify-center
                        w-20 h-20
                        bg-white
                        rounded-2xl
                        shadow-xl
                        mb-5">

                <span class="text-4xl">🎓</span>

            </div>

            <h1 class="text-3xl font-bold text-white">
                KAIH App
            </h1>

            <p class="text-indigo-100 mt-2">
                Sistem Informasi Akademik
            </p>

        </div>


        {{-- Login Card --}}
        <div class="bg-white rounded-2xl shadow-2xl p-8">

            <div class="mb-7">

                <h2 class="text-2xl font-bold text-gray-800">
                    Selamat Datang 👋
                </h2>

                <p class="text-gray-500 mt-1">
                    Silakan masuk ke akun Anda
                </p>

            </div>


            {{-- Session Status --}}
            @if (session('status'))

                <div class="mb-5 p-4 rounded-lg bg-green-50 border border-green-200 text-green-700 text-sm">
                    {{ session('status') }}
                </div>

            @endif


            {{-- Error --}}
            @if ($errors->any())

                <div class="mb-5 p-4 rounded-lg bg-red-50 border border-red-200 text-red-700 text-sm">

                    <p class="font-semibold mb-1">
                        Login gagal
                    </p>

                    <ul class="list-disc ml-5">

                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach

                    </ul>

                </div>

            @endif


            {{-- Form Login --}}
            <form method="POST" action="{{ route('login') }}">

                @csrf

                {{-- Email --}}
                <div class="mb-5">

                    <label
                        for="email"
                        class="block text-sm font-semibold text-gray-700 mb-2">

                        Email

                    </label>

                    <input
                        id="email"
                        type="email"
                        name="email"
                        value="{{ old('email') }}"
                        required
                        autofocus
                        autocomplete="username"
                        placeholder="Masukkan email"
                        class="w-full px-4 py-3 border border-gray-300 rounded-xl
                               outline-none transition
                               focus:ring-2 focus:ring-indigo-500
                               focus:border-indigo-500"
                    >

                    @error('email')
                        <p class="mt-2 text-sm text-red-600">
                            {{ $message }}
                        </p>
                    @enderror

                </div>


                {{-- Password --}}
                <div class="mb-5">

                    <div class="flex justify-between items-center mb-2">

                        <label
                            for="password"
                            class="block text-sm font-semibold text-gray-700">

                            Password

                        </label>

                        @if (Route::has('password.request'))

                            <a
                                href="{{ route('password.request') }}"
                                class="text-sm font-semibold text-indigo-600 hover:text-indigo-800">

                                Lupa password?

                            </a>

                        @endif

                    </div>


                    <div class="relative">

                        <input
                            id="password"
                            type="password"
                            name="password"
                            required
                            autocomplete="current-password"
                            placeholder="Masukkan password"
                            class="w-full px-4 py-3 pr-12 border border-gray-300
                                   rounded-xl outline-none transition
                                   focus:ring-2 focus:ring-indigo-500
                                   focus:border-indigo-500"
                        >

                        <button
                            type="button"
                            id="togglePassword"
                            class="absolute right-3 top-1/2 -translate-y-1/2
                                   text-gray-500 hover:text-indigo-600">

                            👁️

                        </button>

                    </div>

                    @error('password')
                        <p class="mt-2 text-sm text-red-600">
                            {{ $message }}
                        </p>
                    @enderror

                </div>


                {{-- Remember --}}
                <div class="flex items-center mb-6">

                    <input
                        id="remember"
                        type="checkbox"
                        name="remember"
                        value="1"
                        class="w-4 h-4 text-indigo-600 border-gray-300
                               rounded focus:ring-indigo-500"
                    >

                    <label
                        for="remember"
                        class="ml-2 text-sm text-gray-600">

                        Ingat saya

                    </label>

                </div>


                {{-- Login Button --}}
                <button
                    type="submit"
                    class="w-full bg-indigo-600 hover:bg-indigo-700
                           active:bg-indigo-800 text-white font-semibold
                           py-3 rounded-xl transition duration-200
                           shadow-lg hover:shadow-xl">

                    Masuk ke Dashboard

                </button>

            </form>


            {{-- Footer --}}
            <div class="mt-7 pt-6 border-t border-gray-100 text-center">

                <p class="text-sm text-gray-500">
                    Sistem Informasi Akademik
                </p>

                <p class="text-xs text-gray-400 mt-1">
                    KAIH App © {{ date('Y') }}
                </p>

            </div>

        </div>

    </div>

</div>


<script>
document.addEventListener('DOMContentLoaded', function () {

    const passwordInput = document.getElementById('password');
    const togglePassword = document.getElementById('togglePassword');

    if (passwordInput && togglePassword) {

        togglePassword.addEventListener('click', function () {

            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                togglePassword.textContent = '🙈';
            } else {
                passwordInput.type = 'password';
                togglePassword.textContent = '👁️';
            }

        });

    }

});
</script>

</body>
</html>