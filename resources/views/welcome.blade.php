<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="ltr">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>NEXUS.ERP - Smart Business Management</title>
        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />
        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="antialiased min-h-screen flex flex-col relative z-0 bg-slate-50 dark:bg-slate-950" id="app-body">
        
        <!-- Theme Initialization -->
        <script>
            if (localStorage.theme === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
                document.documentElement.classList.add('dark')
            } else {
                document.documentElement.classList.remove('dark')
            }
        </script>
        
        <!-- Thematic Intro Animation Overlay -->
        <div id="intro-overlay" class="fixed inset-0 z-50 bg-slate-950 flex flex-col items-center justify-center">
            <div id="intro-logo" class="flex items-center gap-3">
                <div class="w-16 h-16 rounded-2xl bg-gradient-to-tr from-brand-primary to-brand-accent flex items-center justify-center shadow-[0_0_40px_rgba(59,130,246,0.6)]">
                    <svg class="w-10 h-10 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                    </svg>
                </div>
                <h1 class="text-5xl font-extrabold tracking-tight text-white">NEXUS<span class="text-brand-primary">.ERP</span></h1>
            </div>
            <div class="mt-8 w-64 h-1 bg-slate-800 rounded-full overflow-hidden">
                <div class="h-full bg-brand-primary w-0" id="intro-progress"></div>
            </div>
        </div>

        <div id="main-content" class="flex-1 flex flex-col opacity-0 transition-opacity duration-1000 bg-slate-50 dark:bg-slate-950 text-slate-900 dark:text-white">
            <!-- Navbar -->
            <nav class="flex items-center justify-between px-8 py-6 z-10 glass-card m-4 rounded-2xl border-none bg-white/30 dark:bg-slate-900/30">
                <div class="flex items-center gap-2">
                    <div class="w-8 h-8 rounded-lg bg-gradient-to-tr from-brand-primary to-brand-accent flex items-center justify-center shadow-lg shadow-brand-primary/40">
                        <svg class="w-5 h-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                        </svg>
                    </div>
                    <span class="text-2xl font-extrabold tracking-tight text-slate-900 dark:text-white">NEXUS<span class="text-brand-primary">.ERP</span></span>
                </div>
                <div>
                    @if (Route::has('login'))
                        <div class="flex gap-4">
                            @auth
                                <a href="{{ url('/dashboard') }}" class="text-slate-600 dark:text-slate-300 hover:text-slate-900 dark:hover:text-white transition font-medium">{{ __('messages.dashboard') }}</a>
                            @else
                                <a href="{{ route('login') }}" class="text-slate-600 dark:text-slate-300 hover:text-slate-900 dark:hover:text-white transition font-medium flex items-center">Log in</a>
                                @if (Route::has('register'))
                                    <a href="{{ route('register') }}" class="btn-premium px-6 py-2 text-sm">Get Started</a>
                                @endif
                            @endauth
                        </div>
                    @endif
                </div>
            </nav>

            <!-- Hero Section -->
            <main class="flex-grow flex items-center justify-center relative overflow-hidden">
                <!-- Background Glow -->
                <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[600px] h-[600px] bg-brand-primary/20 rounded-full blur-[120px] -z-10 animate-fade-in-up"></div>
                
                <div class="max-w-4xl mx-auto text-center px-6 z-10">
                    <h1 class="text-5xl md:text-7xl font-bold mb-6 leading-tight animate-fade-in-up stagger-1 text-slate-900 dark:text-white">
                        Manage your business <br/>
                        <span class="text-transparent bg-clip-text bg-gradient-to-r from-brand-primary to-brand-secondary">intelligently with NEXUS</span>
                    </h1>
                    <p class="text-xl text-slate-600 dark:text-text-muted mb-10 max-w-2xl mx-auto animate-fade-in-up stagger-2">
                        An integrated system designed specifically to facilitate the management of Human Resources, Sales, Inventory, and CRM all in one place with a modern, sharp interface.
                    </p>
                    <div class="flex flex-col sm:flex-row justify-center gap-4 animate-fade-in-up stagger-3">
                        @auth
                            <a href="{{ url('/dashboard') }}" class="btn-premium px-8 py-4 text-lg">Go to Dashboard &rarr;</a>
                        @else
                            @if (Route::has('register'))
                                <a href="{{ route('register') }}" class="btn-premium px-8 py-4 text-lg">Start for free</a>
                            @endif
                            <a href="{{ route('login') }}" class="glass-card px-8 py-4 text-lg hover:bg-slate-100 dark:hover:bg-slate-800 transition text-slate-900 dark:text-white">Log in</a>
                        @endauth
                    </div>
                </div>
            </main>

            <!-- Footer -->
            <footer class="w-full text-center p-6 text-slate-500 dark:text-text-muted text-sm border-t border-slate-200 dark:border-slate-800/50">
                &copy; {{ date('Y') }} All rights reserved to NEXUS.ERP System.
            </footer>
        </div>

        <script>
            document.addEventListener('DOMContentLoaded', () => {
                const overlay = document.getElementById('intro-overlay');
                const logo = document.getElementById('intro-logo');
                const progress = document.getElementById('intro-progress');
                const mainApp = document.getElementById('main-content');
                const body = document.getElementById('app-body');

                // Welcome page specific logic: don't play intro again if navigating back from dashboard,
                // but play it if landing here first time.
                if (!sessionStorage.getItem('introPlayed')) {
                    // Lock scrolling
                    body.classList.add('overflow-hidden');
                    
                    overlay.classList.add('intro-overlay-active');
                    logo.classList.add('intro-logo-active');
                    
                    progress.style.transition = 'width 2s cubic-bezier(0.8, 0, 0.2, 1)';
                    progress.style.width = '100%';

                    setTimeout(() => {
                        mainApp.classList.remove('opacity-0');
                        body.classList.remove('overflow-hidden');
                        overlay.remove();
                        sessionStorage.setItem('introPlayed', 'true');
                    }, 2400);
                } else {
                    overlay.style.display = 'none';
                    mainApp.classList.remove('opacity-0');
                }
            });
        </script>
    </body>
</html>
