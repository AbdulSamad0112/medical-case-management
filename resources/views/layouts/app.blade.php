<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full bg-slate-50">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Jajal Medical') }} — Case Management</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>body { font-family: 'Inter', sans-serif; }</style>
</head>
<body class="min-h-full flex flex-col text-slate-800 bg-slate-50 antialiased">
    <!-- Top Navigation Header -->
    <header class="bg-white border-b border-slate-200 sticky top-0 z-30">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <!-- Left: Brand & Navigation Links -->
                <div class="flex items-center space-x-8">
                    <a href="{{ route('dashboard') }}" class="flex items-center space-x-3 group">
                        <div class="w-9 h-9 rounded-xl bg-teal-600 text-white flex items-center justify-center font-bold text-lg shadow-sm group-hover:bg-teal-700 transition">
                            +
                        </div>
                        <div class="flex flex-col">
                            <span class="font-bold text-slate-900 leading-tight text-lg">Jajal Medical</span>
                            <span class="text-[10px] uppercase tracking-wider font-semibold text-teal-600">Case Management</span>
                        </div>
                    </a>

                    <nav class="hidden md:flex space-x-1">
                        <a href="{{ route('dashboard') }}"
                           class="px-3.5 py-2 rounded-lg text-sm font-medium transition {{ request()->routeIs('dashboard') ? 'bg-teal-50 text-teal-700' : 'text-slate-600 hover:text-slate-900 hover:bg-slate-100' }}">
                            Dashboard
                        </a>
                        <a href="{{ route('cases.index') }}"
                           class="px-3.5 py-2 rounded-lg text-sm font-medium transition {{ request()->routeIs('cases.*') ? 'bg-teal-50 text-teal-700' : 'text-slate-600 hover:text-slate-900 hover:bg-slate-100' }}">
                            Medical Cases
                        </a>
                    </nav>
                </div>

                <!-- Right: Action Buttons & User Menu -->
                <div class="flex items-center space-x-4">
                    @can('create', App\Models\MedicalCase::class)
                        <a href="{{ route('cases.create') }}"
                           class="hidden sm:inline-flex items-center px-3.5 py-2 border border-transparent text-sm font-medium rounded-lg shadow-sm text-white bg-teal-600 hover:bg-teal-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-teal-500 transition">
                            <svg class="-ml-1 mr-2 h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                            </svg>
                            New Case
                        </a>
                    @endcan

                    <!-- User Profile Details & Role Badge -->
                    <div class="flex items-center space-x-3 pl-3 border-l border-slate-200">
                        <div class="text-right hidden sm:block">
                            <div class="text-sm font-semibold text-slate-900 leading-tight">{{ auth()->user()->name }}</div>
                            <div class="text-xs text-slate-500">{{ auth()->user()->email }}</div>
                        </div>

                        <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-semibold {{ auth()->user()->isAdmin() ? 'bg-purple-100 text-purple-800 border border-purple-200' : 'bg-slate-100 text-slate-800 border border-slate-200' }}">
                            {{ auth()->user()->isAdmin() ? 'Admin' : 'Viewer' }}
                        </span>

                        <form method="POST" action="{{ route('logout') }}" class="inline">
                            @csrf
                            <button type="submit"
                                    title="Log Out"
                                    class="p-2 text-slate-400 hover:text-rose-600 rounded-lg hover:bg-slate-100 transition">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                                </svg>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Mobile sub-navigation bar -->
        <div class="md:hidden border-t border-slate-100 bg-slate-50/50 px-4 py-2 flex items-center justify-between">
            <div class="flex space-x-2">
                <a href="{{ route('dashboard') }}" class="text-xs font-medium px-2.5 py-1 rounded {{ request()->routeIs('dashboard') ? 'bg-teal-600 text-white' : 'text-slate-600' }}">
                    Dashboard
                </a>
                <a href="{{ route('cases.index') }}" class="text-xs font-medium px-2.5 py-1 rounded {{ request()->routeIs('cases.*') ? 'bg-teal-600 text-white' : 'text-slate-600' }}">
                    Cases
                </a>
            </div>
            @can('create', App\Models\MedicalCase::class)
                <a href="{{ route('cases.create') }}" class="text-xs font-medium text-teal-700 bg-teal-100 px-2.5 py-1 rounded">
                    + New Case
                </a>
            @endcan
        </div>
    </header>

    <!-- Main Content Area -->
    <main class="flex-1 max-w-7xl w-full mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Flash Notifications -->
        @if (session('success'))
            <div class="mb-6 p-4 rounded-xl bg-teal-50 border border-teal-200 text-teal-800 text-sm flex items-center shadow-sm">
                <svg class="w-5 h-5 mr-3 text-teal-600 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                </svg>
                <span>{{ session('success') }}</span>
            </div>
        @endif

        @if (session('error'))
            <div class="mb-6 p-4 rounded-xl bg-rose-50 border border-rose-200 text-rose-800 text-sm flex items-center shadow-sm">
                <svg class="w-5 h-5 mr-3 text-rose-600 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                </svg>
                <span>{{ session('error') }}</span>
            </div>
        @endif

        {{ $slot }}
    </main>

    <!-- Footer -->
    <footer class="bg-white border-t border-slate-200 mt-auto py-6">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex flex-col sm:flex-row items-center justify-between text-xs text-slate-500">
            <div>
                &copy; {{ date('Y') }} Jajal Medical Inc. All rights reserved. Medical Case Tracking System.
            </div>
            <div class="mt-2 sm:mt-0 flex items-center space-x-4">
                <span>Authenticated as: <strong class="text-slate-700">{{ auth()->user()->role->label() }}</strong></span>
                <span>•</span>
                <a href="{{ route('cases.index') }}" class="hover:underline">Case Registry</a>
            </div>
        </div>
    </footer>
</body>
</html>
