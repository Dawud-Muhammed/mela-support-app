@props(['title' => '','css'=>'css/style-78.css'])
<!doctype html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title }} | Mela Support BiT Edition</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Plus+Jakarta+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <script src="https://unpkg.com/lucide@latest"></script>
    <link rel="stylesheet" href="{{ asset('style-78.css') }}">
    <link rel="stylesheet" href="{{ asset($css) }}">
  </head>
  <body class="bg-[#f8fafc] text-slate-900">
    <div class="min-h-screen flex">
      <aside class="sidebar hidden lg:flex w-72 flex-col bg-indigo-900 text-white" data-sidebar>
        <div class="p-6 pb-4">
          <div class="flex flex-col items-start gap-4">
            <div class="flex w-full items-center gap-3 sidebar-logo-row">
              <div class="flex h-11 w-11 items-center justify-center rounded-2xl bg-white/10">
                <img src="{{ asset('mela-logo.svg') }}"alt="BiT Logo" class="h-10 w-auto">
              </div>
              <div class="sidebar-brand">
                <p class="text-xs uppercase tracking-[0.2em] text-indigo-200">BiT Campus</p>
                <p class="text-base font-semibold">Mela Support</p>
              </div>
            </div>
            <button type="button" aria-label="Toggle sidebar" data-sidebar-toggle class="sidebar-toggle inline-flex w-full items-center justify-center rounded-2xl border border-white/15 bg-white/10 px-3 py-2 text-sm font-semibold text-white transition hover:bg-indigo-800">
              <i data-lucide="chevron-right" class="sidebar-toggle-icon h-5 w-5"></i>
              <i data-lucide="chevron-right" class="sidebar-toggle-icon h-5 w-5"></i>
              <i data-lucide="chevron-right" class="sidebar-toggle-icon h-5 w-5"></i>
            </button>
          </div>
        </div>
        
        <div class="px-6 pb-4 lg:hidden">
          <button class="close-sidebar-btn inline-flex items-center gap-2 rounded-2xl border border-white/20 bg-white/10 px-3 py-2 text-sm font-medium text-white shadow-sm transition-all duration-300 hover:-translate-y-0.5 hover:bg-white/20">
            <i data-lucide="x" class="h-4 w-4"></i>
            Close
          </button>
        </div>

        <nav class="flex-1 px-4 pb-6 text-sm">
          <div class="space-y-1">
            <p class="sidebar-section-label px-4 text-[10px] uppercase tracking-[0.3em] text-indigo-200">Overview</p>
            <a class="sidebar-link flex items-center gap-3 rounded-2xl px-4 py-3 text-indigo-100 transition hover:bg-white/10 {{ request()->routeIs('landing')  ? 'bg-indigo-500 text-white shadow-md' : 'text-indigo-100 hover:bg-white/10' }}" href="{{ route('landing') }}">
              <i data-lucide="layout-dashboard" class="h-4 w-4"></i>
              <span class="sidebar-label">Landing</span>
            </a>

            @if (auth()->user()?->role == 'admin' OR auth()->user()?->role == 'technician' OR auth()->user()?->role == 'user')
            <!-- Using ?-> prevents the crash if user is logged out -->
            <a class="sidebar-link flex items-center gap-3 rounded-2xl px-4 py-3 text-indigo-100 transition hover:bg-white/10 {{ request()->routeIs('dashboard')  ? 'bg-indigo-500 text-white shadow-md' : 'text-indigo-100 hover:bg-white/10' }}" href="{{ route('dashboard') }}">
              <i data-lucide="bar-chart-3" class="h-4 w-4"></i>
              <span class="sidebar-label">Dashboard</span>
            </a>
            <a href="{{ route('profile.edit') }}" class="sidebar-link flex items-center gap-3 rounded-2xl px-4 py-3 text-indigo-100 transition hover:bg-white/10 {{ request()->routeIs('profile.edit')  ? 'bg-indigo-500 text-white shadow-md' : 'text-indigo-100 hover:bg-white/10' }}">
                <i data-lucide="user" class="h-5 w-5"></i>
                My Profile
            </a>
            @endif

            @if (auth()->user()?->role === 'admin')
            <a class="sidebar-link flex items-center gap-3 rounded-2xl px-4 py-3 text-indigo-100 transition hover:bg-white/10 {{ request()->routeIs('admin.analytics')  ? 'bg-indigo-500 text-white shadow-md' : 'text-indigo-100 hover:bg-white/10' }}" href="{{ route('admin.analytics') }}">
              <i data-lucide="shield" class="h-4 w-4"></i>
              <span class="sidebar-label">Admin Analytics</span>
            </a>
              <a  href="{{ route('admin.users') }}"class="sidebar-link flex items-center gap-3 rounded-2xl px-4 py-3 text-indigo-100 transition hover:bg-white/10 {{ request()->routeIs('admin.users')  ? 'bg-indigo-500 text-white shadow-md' : 'text-indigo-100 hover:bg-white/10' }}">
              <i data-lucide="users" class="h-4 w-4"></i>
              <span class="sidebar-label">Manage Users</span>
            </a>
            @endif
          </div>

          @guest
          <div class="mt-4 space-y-1">
            <p class="sidebar-section-label px-4 text-[10px] uppercase tracking-[0.3em] text-indigo-200">Access</p>
            <a class="sidebar-link flex items-center gap-3 rounded-2xl px-4 py-3 text-indigo-100 transition hover:bg-white/10 {{ request()->routeIs('register') ? 'bg-indigo-500 text-white shadow-md' : '' }}" href="{{ route('register') }}">
              <i data-lucide="user-plus" class="h-4 w-4"></i>
              <span class="sidebar-label">Register</span>
            </a>
            <a class="sidebar-link flex items-center gap-3 rounded-2xl px-4 py-3 text-indigo-100 transition hover:bg-white/10 {{ request()->routeIs('login') ? 'bg-indigo-500 text-white shadow-md' : '' }}" href="{{ route('login') }}">
              <i data-lucide="shield-check" class="h-4 w-4"></i>
              <span class="sidebar-label">Login</span>
            </a>
          </div>
          @endguest

          @auth
          <form method="POST" action="{{ route('logout') }}" class="mt-4 space-y-1">
              @csrf
              <button type="submit" class="flex w-full items-center gap-3 rounded-2xl px-4 py-3 text-red-400 hover:bg-red-500/10 transition">
                  <i data-lucide="log-out" class="h-4 w-4"></i>
                  <span class="sidebar-label">Logout ({{ Auth::user()->name }})</span>
              </button>
          </form>
          @endauth

          <!-- ONLY STUDENTS/STAFF CAN CREATE TICKETS -->
          @if(auth()->user()?->role === 'user')
          <div class="mt-4 space-y-2">
            <button class="sidebar-folder flex w-full items-center justify-between rounded-2xl px-4 py-3 text-left text-indigo-100 transition hover:bg-white/10" data-bs-toggle="collapse" data-bs-target="#ticket-management">
              <span class="flex items-center gap-3">
                <i data-lucide="folder" class="h-4 w-4"></i>
                <span class="sidebar-label">Maintenance Reports</span>
              </span>
              <i data-lucide="chevron-down" data-folder-chevron class="sidebar-chevron h-4 w-4 rotate-180"></i>
            </button>
            <div id="ticket-management" class="sidebar-items folder-content ml-9 space-y-1 overflow-hidden max-h-96 opacity-100">
              
              <a class="sidebar-link flex items-center gap-3 rounded-2xl px-3 py-2 text-indigo-100/90 transition hover:bg-white/10 {{ request()->routeIs('tickets.create') ? 'bg-indigo-500 text-white shadow-md' : '' }}" href="{{ route('tickets.create') }}">
                <i data-lucide="file-plus" class="h-4 w-4"></i>
                <span class="sidebar-label">Create Ticket</span>
              </a>

            </div>
          </div>
          @endif

        </nav>

        <!-- TECHNICIAN INFO BADGE -->
        @if(auth()->user()?->role === 'technician')
        <div class="mt-auto border-t border-white/10 px-4 py-4">
            <div class="rounded-2xl border border-white/10 bg-white/5 p-4 shadow-sm">
                <p class="sidebar-section-label text-[10px] uppercase tracking-[0.25em] text-indigo-200">Campus Tech</p>
                <p class="sidebar-label mt-2 text-sm font-medium">{{ auth()->user()->name }}</p>
                <p class="sidebar-label text-xs text-indigo-200/80">{{ auth()->user()->specialty }}</p>
            </div>
        </div>
        @endif
          <!-- User INFO BADGE -->
        @if(auth()->user()?->role === 'user')
        <div class="mt-auto border-t border-white/10 px-4 py-4">
            <div class="rounded-2xl border border-white/10 bg-white/5 p-4 shadow-sm">
                <p class="sidebar-section-label text-[10px] uppercase tracking-[0.25em] text-indigo-200">Campus User</p>
                <p class="sidebar-label mt-2 text-sm font-medium">{{ auth()->user()->name }}</p>
                <p class="sidebar-label text-xs text-indigo-200/80">{{ auth()->user()->campus_role }}</p>
            </div>
        </div>
        @endif
        <!-- Admin INFO BADGE -->
        @if(auth()->user()?->role === 'admin')
        <div class="mt-auto border-t border-white/10 px-4 py-4">
            <div class="rounded-2xl border border-white/10 bg-white/5 p-4 shadow-sm">
                <p class="sidebar-section-label text-[10px] uppercase tracking-[0.25em] text-indigo-200">Facility Manager</p>
                <p class="sidebar-label mt-2 text-sm font-medium">{{ auth()->user()->name }}</p>
                <p class="sidebar-label text-xs text-indigo-200/80">{{ auth()->user()->campus_role }}</p>
            </div>
        </div>
        @endif
      </aside>

      {{ $slot }}

    </div>
    <script src="{{ asset('js/app-ui.js') }}" defer></script>
  </body>
</html>