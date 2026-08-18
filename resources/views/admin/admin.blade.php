<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Dashboard') - KAIH</title>

    <!-- Font -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet">

    <!-- Icons -->
    <link rel="stylesheet"
          href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        [x-cloak] {
            display: none !important;
        }

        body {
            font-family: 'Figtree', sans-serif;
        }

        .sidebar {
            width: 260px;
            transition: all .25s ease;
        }

        .main-content {
            margin-left: 260px;
            transition: all .25s ease;
        }

        .sidebar-link {
            transition: all .2s ease;
        }

        .sidebar-link:hover {
            transform: translateX(3px);
        }

        @media (max-width: 1024px) {
            .sidebar {
                transform: translateX(-100%);
            }

            .sidebar.open {
                transform: translateX(0);
            }

            .main-content {
                margin-left: 0;
            }
        }
    </style>

    @stack('styles')
</head>

<body class="bg-slate-50 text-slate-800 antialiased">

<div
    x-data="{ sidebarOpen: false }"
    class="min-h-screen"
>

    <!-- Mobile Overlay -->
    <div
        x-show="sidebarOpen"
        x-cloak
        @click="sidebarOpen = false"
        class="fixed inset-0 z-40 bg-slate-900/50 lg:hidden"
    ></div>


    <!-- ================= SIDEBAR ================= -->
    <aside
        class="sidebar fixed inset-y-0 left-0 z-50 flex flex-col bg-slate-950 text-white shadow-xl"
        :class="{ 'open': sidebarOpen }"
    >

        <!-- Logo -->
        <div class="flex h-20 items-center gap-3 border-b border-white/10 px-6">

            <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-blue-600 shadow-lg">
                <i class="fa-solid fa-school text-lg"></i>
            </div>

            <div>
                <h1 class="text-lg font-bold tracking-wide">
                    KAIH
                </h1>

                <p class="text-xs text-slate-400">
                    Sistem Sekolah
                </p>
            </div>

        </div>


        <!-- Navigation -->
        <nav class="flex-1 space-y-1 overflow-y-auto px-4 py-6">

            <p class="mb-3 px-3 text-xs font-semibold uppercase tracking-wider text-slate-500">
                Menu Utama
            </p>


            <!-- Dashboard -->
            <a
                href="{{ route('admin.dashboard') }}"
                class="sidebar-link flex items-center gap-3 rounded-xl px-4 py-3 text-sm font-medium
                {{ request()->routeIs('admin.dashboard')
                    ? 'bg-blue-600 text-white shadow-lg shadow-blue-600/20'
                    : 'text-slate-300 hover:bg-white/5 hover:text-white' }}"
            >
                <i class="fa-solid fa-chart-pie w-5"></i>
                <span>Dashboard</span>
            </a>


            <!-- Data Akademik -->
            <div class="pt-6 pb-2">

                <p class="px-3 text-xs font-semibold uppercase tracking-wider text-slate-500">
                    Data Akademik
                </p>

            </div>


            <!-- Siswa -->
            <a
                href="{{ route('siswa.index') }}"
                class="sidebar-link flex items-center gap-3 rounded-xl px-4 py-3 text-sm font-medium
                {{ request()->routeIs('siswa.*')
                    ? 'bg-blue-600 text-white shadow-lg shadow-blue-600/20'
                    : 'text-slate-300 hover:bg-white/5 hover:text-white' }}"
            >
                <i class="fa-solid fa-user-graduate w-5"></i>
                <span>Siswa</span>
            </a>


            <!-- Kelas -->
            <a
                href="{{ route('kelas.index') }}"
                class="sidebar-link flex items-center gap-3 rounded-xl px-4 py-3 text-sm font-medium
                {{ request()->routeIs('kelas.*')
                    ? 'bg-blue-600 text-white shadow-lg shadow-blue-600/20'
                    : 'text-slate-300 hover:bg-white/5 hover:text-white' }}"
            >
                <i class="fa-solid fa-school w-5"></i>
                <span>Kelas</span>
            </a>


            <!-- Jurusan -->
            <a
                href="{{ route('jurusan.index') }}"
                class="sidebar-link flex items-center gap-3 rounded-xl px-4 py-3 text-sm font-medium
                {{ request()->routeIs('jurusan.*')
                    ? 'bg-blue-600 text-white shadow-lg shadow-blue-600/20'
                    : 'text-slate-300 hover:bg-white/5 hover:text-white' }}"
            >
                <i class="fa-solid fa-book-open w-5"></i>
                <span>Jurusan</span>
            </a>


            <!-- Orang Tua -->
            <a
                href="{{ route('orangtua.index') }}"
                class="sidebar-link flex items-center gap-3 rounded-xl px-4 py-3 text-sm font-medium
                {{ request()->routeIs('orangtua.*')
                    ? 'bg-blue-600 text-white shadow-lg shadow-blue-600/20'
                    : 'text-slate-300 hover:bg-white/5 hover:text-white' }}"
            >
                <i class="fa-solid fa-users w-5"></i>
                <span>Orang Tua</span>
            </a>


            <!-- Monitoring -->
            <div class="pt-6 pb-2">

                <p class="px-3 text-xs font-semibold uppercase tracking-wider text-slate-500">
                    Monitoring
                </p>

            </div>


            <a
                href="#"
                class="sidebar-link flex items-center gap-3 rounded-xl px-4 py-3 text-sm font-medium text-slate-300 hover:bg-white/5 hover:text-white"
            >
                <i class="fa-solid fa-clipboard-check w-5"></i>
                <span>Angket Harian</span>
            </a>


            <a
                href="#"
                class="sidebar-link flex items-center gap-3 rounded-xl px-4 py-3 text-sm font-medium text-slate-300 hover:bg-white/5 hover:text-white"
            >
                <i class="fa-solid fa-chart-line w-5"></i>
                <span>Monitoring Siswa</span>
            </a>

        </nav>


        <!-- User -->
        <div class="border-t border-white/10 p-4">

            <div class="flex items-center gap-3 rounded-xl bg-white/5 p-3">

                <div class="flex h-10 w-10 items-center justify-center rounded-full bg-blue-600">
                    <i class="fa-solid fa-user"></i>
                </div>

                <div class="min-w-0 flex-1">

                    <p class="truncate text-sm font-semibold">
                        {{ auth()->user()->name ?? 'Admin' }}
                    </p>

                    <p class="text-xs text-slate-400">
                        Administrator
                    </p>

                </div>

            </div>

        </div>

    </aside>


    <!-- ================= MAIN ================= -->

    <div class="main-content min-h-screen">


        <!-- TOPBAR -->
        <header class="sticky top-0 z-30 border-b border-slate-200 bg-white/90 backdrop-blur">

            <div class="flex h-20 items-center justify-between px-4 sm:px-6 lg:px-8">


                <!-- Mobile Button -->
                <button
                    @click="sidebarOpen = !sidebarOpen"
                    class="rounded-xl p-2 text-slate-600 hover:bg-slate-100 lg:hidden"
                >
                    <i class="fa-solid fa-bars text-lg"></i>
                </button>


                <!-- Page Title -->
                <div class="hidden sm:block">

                    <p class="text-xs font-medium uppercase tracking-wider text-slate-400">
                        KAIH App
                    </p>

                    <h2 class="text-xl font-bold text-slate-900">
                        @yield('page-title', 'Dashboard')
                    </h2>

                </div>


                <!-- Right -->
                <div class="flex items-center gap-3">


                    <!-- Notification -->
                    <button
                        class="relative flex h-10 w-10 items-center justify-center rounded-xl text-slate-500 hover:bg-slate-100"
                    >
                        <i class="fa-regular fa-bell"></i>

                        <span class="absolute right-2 top-2 h-2 w-2 rounded-full bg-red-500"></span>
                    </button>


                    <!-- User -->
                    <div class="hidden items-center gap-3 border-l border-slate-200 pl-4 sm:flex">

                        <div class="text-right">

                            <p class="text-sm font-semibold text-slate-800">
                                {{ auth()->user()->name ?? 'Admin' }}
                            </p>

                            <p class="text-xs text-slate-400">
                                Administrator
                            </p>

                        </div>

                        <div class="flex h-10 w-10 items-center justify-center rounded-full bg-blue-100 text-blue-600">
                            <i class="fa-solid fa-user"></i>
                        </div>

                    </div>


                    <!-- Logout -->
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf

                        <button
                            type="submit"
                            title="Logout"
                            class="flex h-10 w-10 items-center justify-center rounded-xl text-slate-500 hover:bg-red-50 hover:text-red-600"
                        >
                            <i class="fa-solid fa-right-from-bracket"></i>
                        </button>

                    </form>

                </div>

            </div>

        </header>


        <!-- PAGE CONTENT -->
        <main class="p-4 sm:p-6 lg:p-8">

            @if(session('success'))

                <div class="mb-6 rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-700">
                    <i class="fa-solid fa-circle-check mr-2"></i>
                    {{ session('success') }}
                </div>

            @endif


            @if(session('error'))

                <div class="mb-6 rounded-xl border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700">
                    <i class="fa-solid fa-circle-exclamation mr-2"></i>
                    {{ session('error') }}
                </div>

            @endif


            @yield('content')

        </main>

    </div>

</div>

@stack('scripts')

</body>
</html>