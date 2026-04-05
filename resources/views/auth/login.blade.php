 <x-app-layout title="Login" css='css/style-78.css'>
<div class="flex-1">
    <header class="sticky top-0 z-20 border-b border-slate-200/70 bg-white/70 backdrop-blur-xl">
        <div class="flex flex-wrap items-center justify-between gap-4 px-6 py-4">
            <div>
                <div class="mb-2 flex items-center gap-3 lg:hidden">
                    <img src="{{ asset('mela-logo.svg') }}"alt="BiT Logo" class="h-10 w-auto">
                    <span class="text-sm font-semibold">Mela Support</span>
                </div>
                <p class="text-xs uppercase tracking-[0.25em] text-slate-400">Access</p>
                <h1 class="text-2xl font-semibold">Secure Sign-in</h1>
            </div>

            <button class="mobile-menu-btn lg:hidden rounded-2xl border border-slate-200/70 bg-white px-3 py-2 text-sm font-medium text-slate-700 shadow-sm transition-all duration-300 hover:-translate-y-0.5 hover:shadow-md">
                <i data-lucide="menu" class="h-4 w-4"></i>
            </button>
        </div>
    </header>

    <main class="flex items-center justify-center px-6 py-16">
        <div class="w-full max-w-md rounded-[2rem] border border-slate-200/70 bg-white/70 p-8 shadow-sm">
            <h2 class="text-xl font-semibold">Welcome back</h2>
            <p class="text-sm text-slate-500">Sign in to manage your cases.</p>
            
            @if (session('status'))
                <div class="mt-4 text-sm font-medium text-green-600">
                    {{ session('status') }}
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}">
                @csrf
                
                <div class="mt-6 space-y-4">
                    <div>
                        <label for="email" class="text-sm font-medium">Email Address</label>
                        <input id="email" type="email" name="email" 
                               class="mt-2 w-full rounded-2xl border @error('email') border-red-500 @else border-slate-200/70 @enderror bg-white px-4 py-3 text-sm" 
                               value="{{ old('email') }}" required autofocus autocomplete="username" />
                        @error('email')
                            <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="password" class="text-sm font-medium">Password</label>
                        <input id="password" type="password" name="password" 
                               class="mt-2 w-full rounded-2xl border @error('password') border-red-500 @else border-slate-200/70 @enderror bg-white px-4 py-3 text-sm" 
                               required autocomplete="current-password" />
                        @error('password')
                            <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="mt-4 flex items-center justify-between text-sm">
                    <label class="flex items-center gap-2 cursor-pointer">
                        <input id="remember_me" type="checkbox" name="remember" class="h-4 w-4 rounded border-slate-300 text-[var(--color-primary)]" />
                        <span class="text-slate-600">Remember me</span>
                    </label>
                    
                    @if (Route::has('password.request'))
                        <a class="text-[var(--color-primary)] hover:underline" href="{{ route('password.request') }}">
                            Forgot Password?
                        </a>
                    @endif
                </div>

                <button type="submit" class="mt-6 w-full rounded-2xl bg-[var(--color-action)] px-5 py-3 text-sm font-semibold text-white shadow-sm transition-all duration-300 hover:-translate-y-0.5 hover:shadow-md">
                    Sign in
                </button>
            </form>

            <p class="mt-4 text-xs text-slate-500 text-center">Need help? Contact the ICT helpdesk.</p>
        </div>
    </main>
</div>
</x-app-layout>