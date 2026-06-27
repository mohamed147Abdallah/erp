<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="{{ app()->getLocale() == 'ar' ? 'rtl' : 'ltr' }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>{{ config('app.name', 'NEXUS ERP') }}</title>

        <!-- Scripts & Styles -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <!-- Theme Initialization (before render to avoid flash) -->
        <script>
            if (localStorage.theme === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
                document.documentElement.classList.add('dark');
            } else {
                document.documentElement.classList.remove('dark');
            }
        </script>

        <style>
            /* Thin top progress bar (NProgress style) */
            #page-progress {
                position: fixed;
                top: 0;
                left: 0;
                right: 0;
                height: 2px;
                z-index: 9999;
                pointer-events: none;
                background: #6366f1;
                transform: scaleX(0);
                transform-origin: left;
                opacity: 0;
                transition: transform 0.6s ease, opacity 0.3s ease;
            }
            #page-progress.active {
                opacity: 1;
                transform: scaleX(0.85);
            }
            #page-progress.done {
                transform: scaleX(1);
                opacity: 0;
                transition: transform 0.2s ease, opacity 0.4s ease 0.1s;
            }

            /* Main content fade-in on load */
            #main-content {
                animation: pageEnterMain 0.35s cubic-bezier(0.22, 1, 0.36, 1) both;
            }
            @keyframes pageEnterMain {
                from { opacity: 0; transform: translateY(6px); }
                to   { opacity: 1; transform: translateY(0); }
            }
        </style>
    </head>
    <body class="font-sans antialiased" id="app-body">

        <!-- Thin Top Progress Bar -->
        <div id="page-progress"></div>

        <!-- Intro Animation Overlay (only on first visit per session) -->
        <div id="intro-overlay" class="fixed inset-0 z-[100] bg-[#080b14] flex flex-col items-center justify-center" style="display:none!important">
            <div id="intro-logo" class="flex items-center gap-3">
                <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-indigo-500 to-violet-600 flex items-center justify-center shadow-2xl shadow-indigo-500/50">
                    <svg class="w-8 h-8 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M13 10V3L4 14h7v7l9-11h-7z" />
                    </svg>
                </div>
                <div>
                    <h1 class="text-4xl font-extrabold tracking-tight text-white">NEXUS<span class="text-indigo-400">.ERP</span></h1>
                    <p class="text-slate-500 text-sm mt-0.5">Enterprise Resource Planning</p>
                </div>
            </div>
            <div class="mt-10 w-56 h-0.5 bg-slate-800 rounded-full overflow-hidden">
                <div class="h-full bg-gradient-to-r from-indigo-500 to-violet-500 w-0" id="intro-progress" style="transition: width 2s cubic-bezier(0.76,0,0.24,1)"></div>
            </div>
        </div>

        <!-- ===== MOBILE SIDEBAR OVERLAY ===== -->
        <div id="sidebar-overlay"
             onclick="closeSidebar()"
             style="display:none; position:fixed; top:0; left:0; right:0; bottom:0; z-index:9998; background:rgba(0,0,0,0.55); backdrop-filter:blur(3px); -webkit-backdrop-filter:blur(3px);">
        </div>

        <!-- App Layout -->
        <div class="flex h-screen overflow-hidden" id="main-app">

            <!-- ===== SIDEBAR ===== -->
            <div id="app-sidebar"
                 style="position:fixed;
                        top:0; bottom:0;
                        {{ app()->getLocale() == 'ar' ? 'right:0;' : 'left:0;' }}
                        width:260px;
                        z-index:9999;
                        transform:{{ app()->getLocale() == 'ar' ? 'translateX(100%)' : 'translateX(-100%)' }};
                        transition:transform 0.3s cubic-bezier(0.4,0,0.2,1);">
                @include('layouts.sidebar')
            </div>

            <!-- Main Content Area -->
            <div class="flex-1 flex flex-col overflow-hidden w-full min-w-0">

                <!-- Header -->
                @include('layouts.header')

                <!-- Page Content -->
                <main class="flex-1 overflow-x-hidden overflow-y-auto p-5 md:p-7" id="main-content">
                    @isset($header)
                        <div class="mb-6">
                            {{ $header }}
                        </div>
                    @endisset
                    {{ $slot }}
                </main>

            </div>
        </div>

        <!-- Top Progress Bar Script -->
        <script>
            const progressBar = document.getElementById('page-progress');

            document.addEventListener('click', (e) => {
                const link = e.target.closest('a[href]');
                if (!link) return;
                const href = link.getAttribute('href');
                if (!href || href.startsWith('#') || href.startsWith('javascript') || href.startsWith('mailto') || link.target === '_blank') return;
                if (link.hasAttribute('download')) return;
                try {
                    const url = new URL(href, window.location.origin);
                    if (url.origin !== window.location.origin) return;
                } catch { return; }

                // Show thin progress bar
                progressBar.classList.remove('done');
                progressBar.classList.add('active');
            });

            // Finish the bar when page loads
            window.addEventListener('pageshow', () => {
                progressBar.classList.remove('active');
                progressBar.classList.add('done');
                setTimeout(() => progressBar.classList.remove('done'), 600);
            });
        </script>

        <!-- Sidebar Toggle Script -->
        <script>
            var _sidebarOpen = false;
            var _isRtl = {{ app()->getLocale() == 'ar' ? 'true' : 'false' }};

            // On desktop, reset sidebar to normal flow (no transform)
            function initSidebar() {
                var sidebar = document.getElementById('app-sidebar');
                if (!sidebar) return;
                if (window.innerWidth >= 768) {
                    // Desktop: remove fixed positioning, let it flow normally
                    sidebar.style.position = 'relative';
                    sidebar.style.top = '';
                    sidebar.style.bottom = '';
                    sidebar.style.left = '';
                    sidebar.style.right = '';
                    sidebar.style.transform = '';
                    sidebar.style.zIndex = '';
                } else {
                    // Mobile: keep fixed, hidden off-screen
                    sidebar.style.position = 'fixed';
                    sidebar.style.top = '0';
                    sidebar.style.bottom = '0';
                    if (_isRtl) {
                        sidebar.style.right = '0';
                        sidebar.style.left = '';
                    } else {
                        sidebar.style.left = '0';
                        sidebar.style.right = '';
                    }
                    sidebar.style.zIndex = '9999';
                    if (!_sidebarOpen) {
                        sidebar.style.transform = _isRtl ? 'translateX(100%)' : 'translateX(-100%)';
                    }
                }
            }

            function toggleSidebar() {
                _sidebarOpen ? closeSidebar() : openSidebar();
            }

            function openSidebar() {
                _sidebarOpen = true;
                var sidebar = document.getElementById('app-sidebar');
                var overlay = document.getElementById('sidebar-overlay');
                if (sidebar) sidebar.style.transform = 'translateX(0)';
                if (overlay) overlay.style.display = 'block';
                document.body.style.overflow = 'hidden';
            }

            function closeSidebar() {
                _sidebarOpen = false;
                var sidebar = document.getElementById('app-sidebar');
                var overlay = document.getElementById('sidebar-overlay');
                if (sidebar) sidebar.style.transform = _isRtl ? 'translateX(100%)' : 'translateX(-100%)';
                if (overlay) overlay.style.display = 'none';
                document.body.style.overflow = '';
            }

            // Close with ESC key
            document.addEventListener('keydown', function(e) {
                if (e.key === 'Escape' && _sidebarOpen) closeSidebar();
            });

            // Recalculate on resize
            window.addEventListener('resize', function() {
                initSidebar();
                if (window.innerWidth >= 768) {
                    _sidebarOpen = false;
                    var overlay = document.getElementById('sidebar-overlay');
                    if (overlay) overlay.style.display = 'none';
                    document.body.style.overflow = '';
                }
            });

            // Run on page load
            document.addEventListener('DOMContentLoaded', initSidebar);
        </script>

        <!-- Theme Toggle Script -->
        <script>
            const darkIcon  = document.getElementById('theme-toggle-dark-icon');
            const lightIcon = document.getElementById('theme-toggle-light-icon');

            if (localStorage.getItem('theme') === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
                lightIcon && lightIcon.classList.remove('hidden');
            } else {
                darkIcon && darkIcon.classList.remove('hidden');
            }

            const themeToggleBtn = document.getElementById('theme-toggle');
            themeToggleBtn && themeToggleBtn.addEventListener('click', () => {
                darkIcon.classList.toggle('hidden');
                lightIcon.classList.toggle('hidden');

                if (localStorage.getItem('theme') === 'dark') {
                    document.documentElement.classList.remove('dark');
                    localStorage.setItem('theme', 'light');
                } else {
                    document.documentElement.classList.add('dark');
                    localStorage.setItem('theme', 'dark');
                }
            });
        </script>

    </body>
</html>
