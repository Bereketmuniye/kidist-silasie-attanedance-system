<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Attendance Management') · AMSPro</title>

    <!-- Tailwind CSS CDN — no build step required -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Plus Jakarta Sans', 'sans-serif'],
                    },
                    colors: {
                        brand: {
                            50:  '#eef2ff',
                            100: '#e0e7ff',
                            500: '#6366f1',
                            600: '#4f46e5',
                            700: '#4338ca',
                            900: '#312e81',
                        }
                    }
                }
            }
        }
    </script>

    <!-- Google Font -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800&display=swap" rel="stylesheet">

    @livewireStyles

    <style>
        [x-cloak] { display: none !important; }
        html, body { height: 100%; }
        /* Sidebar scrollbar */
        .sidebar-nav::-webkit-scrollbar { width: 4px; }
        .sidebar-nav::-webkit-scrollbar-track { background: transparent; }
        .sidebar-nav::-webkit-scrollbar-thumb { background: #374151; border-radius: 4px; }
        /* Page scrollbar */
        ::-webkit-scrollbar { width: 6px; }
        ::-webkit-scrollbar-track { background: transparent; }
        ::-webkit-scrollbar-thumb { background: #d1d5db; border-radius: 4px; }
        .sidebar-gradient {
            background: linear-gradient(180deg, #1e1b4b 0%, #1e1b4b 60%, #1a1a2e 100%);
        }
    </style>
</head>
<body class="font-sans bg-gray-50 text-gray-900 antialiased" x-data="{ sidebarOpen: false }">

<div class="flex h-screen overflow-hidden">

    @auth('teacher')
    <!-- ===== SIDEBAR ===== -->
    <!-- Mobile overlay -->
    <div x-show="sidebarOpen"
         x-cloak
         x-transition:enter="transition-opacity ease-linear duration-200"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition-opacity ease-linear duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         @click="sidebarOpen = false"
         class="fixed inset-0 z-40 bg-black/60 backdrop-blur-sm lg:hidden"></div>

    <!-- Sidebar panel -->
    <aside :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'"
           class="sidebar-gradient fixed inset-y-0 left-0 z-50 flex w-64 flex-col shadow-2xl transition-transform duration-300 ease-in-out lg:static lg:translate-x-0">

        <!-- Logo -->
        <div class="flex h-16 shrink-0 items-center gap-3 px-5 border-b border-white/10">
            <div class="flex h-9 w-9 items-center justify-center rounded-xl bg-gradient-to-br from-indigo-400 to-purple-500 shadow-lg shadow-indigo-900/50">
                <svg class="h-5 w-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                </svg>
            </div>
            <div>
                <span class="text-lg font-bold text-white">AMSPro</span>
                <p class="text-[10px] font-medium text-indigo-300 uppercase tracking-widest -mt-0.5">Attendance</p>
            </div>
            <button @click="sidebarOpen = false" class="ml-auto p-1.5 rounded-lg text-indigo-300 hover:text-white hover:bg-white/10 transition-colors lg:hidden">
                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
        </div>

        <!-- Teacher profile mini card -->
        <div class="mx-4 mt-5 mb-2 rounded-xl bg-white/5 border border-white/10 px-4 py-3 flex items-center gap-3">
            <div class="h-9 w-9 shrink-0 rounded-full bg-indigo-400/20 border border-indigo-300/30 flex items-center justify-center text-xs font-bold text-indigo-200">
                {{ substr(Auth::guard('teacher')->user()->first_name, 0, 1) }}{{ substr(Auth::guard('teacher')->user()->last_name, 0, 1) }}
            </div>
            <div class="min-w-0">
                <p class="truncate text-sm font-semibold text-white">{{ Auth::guard('teacher')->user()->full_name }}</p>
                <p class="text-[11px] text-indigo-300 font-medium">Teacher</p>
            </div>
        </div>

        <!-- Nav -->
        <nav class="sidebar-nav flex-1 overflow-y-auto px-3 py-4 space-y-1">
            <p class="px-3 text-[10px] font-bold uppercase tracking-widest text-indigo-400/70 mb-3">Main Menu</p>

            <a href="{{ route('teacher.dashboard') }}"
               class="group flex items-center gap-3 rounded-xl px-3 py-2.5 text-sm font-medium transition-all duration-150
                      {{ request()->routeIs('teacher.dashboard')
                         ? 'bg-white/15 text-white shadow-sm'
                         : 'text-indigo-200 hover:bg-white/8 hover:text-white' }}">
                <div class="flex h-8 w-8 shrink-0 items-center justify-center rounded-lg {{ request()->routeIs('teacher.dashboard') ? 'bg-indigo-500 shadow-lg shadow-indigo-500/40' : 'bg-white/5 group-hover:bg-white/10' }} transition-all">
                    <svg class="h-4 w-4 {{ request()->routeIs('teacher.dashboard') ? 'text-white' : 'text-indigo-300' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                    </svg>
                </div>
                Dashboard
                @if(request()->routeIs('teacher.dashboard'))
                    <span class="ml-auto h-1.5 w-1.5 rounded-full bg-indigo-400"></span>
                @endif
            </a>

            <a href="{{ route('teacher.students') }}"
               class="group flex items-center gap-3 rounded-xl px-3 py-2.5 text-sm font-medium transition-all duration-150
                      {{ request()->routeIs('teacher.students')
                         ? 'bg-white/15 text-white shadow-sm'
                         : 'text-indigo-200 hover:bg-white/8 hover:text-white' }}">
                <div class="flex h-8 w-8 shrink-0 items-center justify-center rounded-lg {{ request()->routeIs('teacher.students') ? 'bg-indigo-500 shadow-lg shadow-indigo-500/40' : 'bg-white/5 group-hover:bg-white/10' }} transition-all">
                    <svg class="h-4 w-4 {{ request()->routeIs('teacher.students') ? 'text-white' : 'text-indigo-300' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                    </svg>
                </div>
                Students
                @if(request()->routeIs('teacher.students'))
                    <span class="ml-auto h-1.5 w-1.5 rounded-full bg-indigo-400"></span>
                @endif
            </a>

            <a href="{{ route('teacher.reports') }}"
               class="group flex items-center gap-3 rounded-xl px-3 py-2.5 text-sm font-medium transition-all duration-150
                      {{ request()->routeIs('teacher.reports')
                         ? 'bg-white/15 text-white shadow-sm'
                         : 'text-indigo-200 hover:bg-white/8 hover:text-white' }}">
                <div class="flex h-8 w-8 shrink-0 items-center justify-center rounded-lg {{ request()->routeIs('teacher.reports') ? 'bg-indigo-500 shadow-lg shadow-indigo-500/40' : 'bg-white/5 group-hover:bg-white/10' }} transition-all">
                    <svg class="h-4 w-4 {{ request()->routeIs('teacher.reports') ? 'text-white' : 'text-indigo-300' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                </div>
                Reports
                @if(request()->routeIs('teacher.reports'))
                    <span class="ml-auto h-1.5 w-1.5 rounded-full bg-indigo-400"></span>
                @endif
            </a>
        </nav>

        <!-- Logout -->
        <div class="shrink-0 border-t border-white/10 p-4">
            <form method="POST" action="{{ route('teacher.logout') }}">
                @csrf
                <button type="submit"
                        class="group flex w-full items-center gap-3 rounded-xl px-3 py-2.5 text-sm font-medium text-indigo-300 hover:bg-red-500/10 hover:text-red-300 transition-all duration-150">
                    <div class="flex h-8 w-8 shrink-0 items-center justify-center rounded-lg bg-white/5 group-hover:bg-red-500/20 transition-all">
                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                        </svg>
                    </div>
                    Sign Out
                </button>
            </form>
        </div>
    </aside>
    @endauth

    <!-- ===== MAIN AREA ===== -->
    <div class="flex flex-1 flex-col min-w-0 overflow-hidden">

        @auth('teacher')
        <!-- Top Header -->
        <header class="flex h-16 shrink-0 items-center justify-between gap-4 border-b border-gray-200 bg-white px-4 sm:px-6 shadow-sm z-30">
            <!-- Hamburger for mobile -->
            <button @click="sidebarOpen = true"
                    class="inline-flex items-center justify-center rounded-lg p-2 text-gray-500 hover:bg-gray-100 hover:text-gray-700 transition-colors lg:hidden">
                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                </svg>
            </button>

            <!-- Page Title -->
            <div class="hidden lg:block">
                <h2 class="text-base font-semibold text-gray-800">@yield('title', 'Dashboard')</h2>
                <p class="text-xs text-gray-500">{{ now()->format('l, F j, Y') }}</p>
            </div>

            <!-- Right side -->
            <div class="ml-auto flex items-center gap-3">
                <!-- Notification bell -->
                <button class="relative rounded-full p-2 text-gray-400 hover:bg-gray-100 hover:text-gray-600 transition-colors">
                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
                    </svg>
                </button>

                <!-- Avatar -->
                <div class="flex items-center gap-2.5 rounded-full border border-gray-200 bg-gray-50 pl-1 pr-3 py-1">
                    <div class="h-8 w-8 rounded-full bg-indigo-600 flex items-center justify-center text-xs font-bold text-white shrink-0">
                        {{ substr(Auth::guard('teacher')->user()->first_name, 0, 1) }}{{ substr(Auth::guard('teacher')->user()->last_name, 0, 1) }}
                    </div>
                    <div class="hidden sm:block">
                        <p class="text-sm font-semibold text-gray-800 leading-tight">{{ Auth::guard('teacher')->user()->full_name }}</p>
                        <p class="text-[11px] text-gray-500">Teacher</p>
                    </div>
                </div>
            </div>
        </header>
        @endauth

        <!-- Scrollable page content -->
        <main class="flex-1 overflow-y-auto bg-gray-50/70">
            <div class="mx-auto max-w-7xl p-4 sm:p-6 lg:p-8">

                @if(session()->has('toaster'))
                    @php
                        $toaster = session('toaster');
                    @endphp
                    <script>
                        document.addEventListener('DOMContentLoaded', () => {
                            setTimeout(() => {
                                window.dispatchEvent(new CustomEvent('toaster:add', {
                                    detail: {
                                        type: '{{ $toaster['type'] }}',
                                        message: '{{ $toaster['message'] }}',
                                        description: @if(isset($toaster['description'])) '{{ $toaster['description'] }}' @else null @endif
                                    }
                                }));
                            }, 100);
                        });
                    </script>
                @endif

                @if(session()->has('message'))
                    <script>
                        document.addEventListener('DOMContentLoaded', () => {
                            setTimeout(() => {
                                window.dispatchEvent(new CustomEvent('toaster:success', {
                                    detail: {
                                        message: '{{ session('message') }}'
                                    }
                                }));
                            }, 100);
                        });
                    </script>
                @endif

                @yield('content')
            </div>
        </main>
    </div>
</div>

@livewireScripts

<!-- Global Toaster Component -->
<x-toaster />
</body>
</html>
