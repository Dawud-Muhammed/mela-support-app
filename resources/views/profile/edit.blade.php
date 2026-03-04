<x-app-layout title="My Profile" css="css/style-78.css">
    <div class="flex-1">
        <!-- Header -->
        <header class="sticky top-0 z-20 border-b border-slate-200/70 bg-white/70 backdrop-blur-xl">
          <div class="flex flex-wrap items-center justify-between gap-4 px-6 py-4">
            <div>
              <p class="text-xs uppercase tracking-[0.25em] text-slate-400">Account Settings</p>
              <h1 class="text-2xl font-semibold">My Profile</h1>
            </div>
            
            <button class="mobile-menu-btn lg:hidden rounded-2xl border border-slate-200/70 bg-white px-3 py-2 text-sm font-medium text-slate-700 shadow-sm transition-all duration-300 hover:-translate-y-0.5 hover:shadow-md">
              <i data-lucide="menu" class="h-4 w-4"></i>
            </button>
          </div>
        </header>

        <!-- SUCCESS NOTIFICATION -->
        @if (session('success'))
        <div class="px-6 pt-6">
          <div class="mx-auto w-full max-w-3xl">
            <div id="success-toast" class="flex items-start gap-3 rounded-[1.5rem] border border-emerald-300/50 bg-emerald-50/40 p-4 text-emerald-950 shadow-sm backdrop-blur-md">
              <div class="mt-0.5 rounded-full bg-emerald-500/10 p-2">
                <i data-lucide="check-circle" class="h-5 w-5 text-emerald-600"></i>
              </div>
              <div class="flex-1">
                <p class="text-sm font-semibold uppercase tracking-[0.18em] text-emerald-700">Success</p>
                <p class="mt-1 text-sm text-emerald-900">{{ session('success') }}</p>
              </div>
            </div>
          </div>
        </div>
        @endif

        <main class="px-6 py-10">
          <div class="mx-auto w-full max-w-3xl space-y-8">

            <!-- SECTION 1: INSTITUTIONAL DATA (LOCKED) -->
            <section class="rounded-[2rem] border border-slate-200/70 bg-white/70 p-6 shadow-sm">
                <div class="border-b border-slate-100 pb-4 mb-6">
                    <h2 class="text-xl font-semibold">Institutional Data</h2>
                    <p class="text-sm text-slate-500 mt-1">This information is tied to your official University ID and cannot be changed here.</p>
                </div>

                <div class="grid gap-6 md:grid-cols-2">
                    <div>
                        <label class="text-sm font-medium text-slate-500">Full Name</label>
                        <input type="text" disabled value="{{ $user->name }}" class="mt-2 w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-500 cursor-not-allowed" />
                    </div>
                    <div>
                        <label class="text-sm font-medium text-slate-500">University Email</label>
                        <input type="text" disabled value="{{ $user->email }}" class="mt-2 w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-500 cursor-not-allowed" />
                    </div>
                    <div>
                        <label class="text-sm font-medium text-slate-500">System Role / Affiliation</label>
                        <input type="text" disabled value="{{ ucfirst($user->role) }}" class="mt-2 w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-500 cursor-not-allowed capitalize" />
                    </div>
                </div>
            </section>

            <!-- SECTION 2: CONTACT PREFERENCES (EDITABLE) -->
            <section class="rounded-[2rem] border border-[var(--color-primary)] bg-indigo-50/30 p-6 shadow-sm">
                <div class="border-b border-indigo-100 pb-4 mb-6">
                    <h2 class="text-xl font-semibold text-slate-800">Contact Preferences</h2>
                    <p class="text-sm text-slate-600 mt-1">Update how the system communicates with you.</p>
                </div>

                <form action="{{ route('profile.update') }}" method="POST" class="space-y-6">
                    @csrf
                    @method('PATCH')

                    <div>
                        <label class="text-sm font-medium">Phone Number</label>
                        <input type="text" name="phone" value="{{ old('phone', $user->phone) }}" placeholder="+251 9..." class="mt-2 w-full rounded-2xl border border-slate-200/70 bg-white px-4 py-3 text-sm focus:border-[var(--color-primary)] outline-none" />
                        @error('phone') <span class="text-xs text-red-500 mt-1">{{ $message }}</span> @enderror
                    </div>

                    <!-- 🤖 ONLY SHOW TELEGRAM ID IF THEY ARE A TECHNICIAN -->
                    @if($user->role === 'technician')
                    <div>
                        <label class="text-sm font-medium">Telegram Chat ID <span class="text-xs text-[var(--color-primary)] font-normal ml-2">(Used for instant dispatch notifications)</span></label>
                        <input type="text" name="telegram_chat_id" value="{{ old('telegram_chat_id', $user->telegram_chat_id) }}" placeholder="e.g., 123456789" class="mt-2 w-full rounded-2xl border border-slate-200/70 bg-white px-4 py-3 text-sm focus:border-[var(--color-primary)] outline-none" />
                        <p class="text-xs text-slate-500 mt-2">To find your ID, message <b>@userinfobot</b> on Telegram.</p>
                        @error('telegram_chat_id') <span class="text-xs text-red-500 mt-1">{{ $message }}</span> @enderror
                    </div>
                    @endif

                    <button type="submit" class="rounded-2xl bg-[var(--color-primary)] px-6 py-3 text-sm font-semibold text-white shadow-sm transition-all duration-300 hover:-translate-y-0.5 hover:shadow-md">
                        Save Contact Info
                    </button>
                </form>
            </section>

            <!-- SECTION 3: SECURITY / PASSWORD -->
            <section class="rounded-[2rem] border border-slate-200/70 bg-white/70 p-6 shadow-sm">
                <div class="border-b border-slate-100 pb-4 mb-6">
                    <h2 class="text-xl font-semibold">Security</h2>
                    <p class="text-sm text-slate-500 mt-1">Ensure your account is using a long, random password to stay secure.</p>
                </div>

                <form action="{{ route('profile.password') }}" method="POST" class="space-y-6">
                    @csrf
                    @method('PATCH')

                    <div>
                        <label class="text-sm font-medium">Current Password</label>
                        <input type="password" name="current_password" required class="mt-2 w-full rounded-2xl border border-slate-200/70 bg-white px-4 py-3 text-sm focus:border-[var(--color-primary)] outline-none" />
                        @error('current_password') <span class="text-xs text-red-500 mt-1">{{ $message }}</span> @enderror
                    </div>

                    <div class="grid gap-6 md:grid-cols-2">
                        <div>
                            <label class="text-sm font-medium">New Password</label>
                            <input type="password" name="password" required class="mt-2 w-full rounded-2xl border border-slate-200/70 bg-white px-4 py-3 text-sm focus:border-[var(--color-primary)] outline-none" />
                            @error('password') <span class="text-xs text-red-500 mt-1">{{ $message }}</span> @enderror
                        </div>
                        <div>
                            <label class="text-sm font-medium">Confirm New Password</label>
                            <input type="password" name="password_confirmation" required class="mt-2 w-full rounded-2xl border border-slate-200/70 bg-white px-4 py-3 text-sm focus:border-[var(--color-primary)] outline-none" />
                        </div>
                    </div>

                    <button type="submit" class="rounded-2xl bg-slate-800 px-6 py-3 text-sm font-semibold text-white shadow-sm transition-all duration-300 hover:-translate-y-0.5 hover:bg-slate-700 hover:shadow-md">
                        Update Password
                    </button>
                </form>
            </section>

          </div>
        </main>
    </div>
</x-app-layout>