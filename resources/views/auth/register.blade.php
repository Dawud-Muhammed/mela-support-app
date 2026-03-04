{{-- <x-app-layout title="Register" css='css/style-78.css'>
    <div class="flex-1">
      
  <header class="sticky top-0 z-20 border-b border-slate-200/70 bg-white/70 backdrop-blur-xl">
            <div class="flex flex-wrap items-center justify-between gap-4 px-6 py-4">
                <div>
                    <div class="mb-2 flex items-center gap-3 lg:hidden">
                        <img src="logo.png" alt="Mela Support Logo" class="h-10 w-auto" />
                        <span class="text-sm font-semibold">Mela Support</span>
                    </div>
                    <p class="text-xs uppercase tracking-[0.25em] text-slate-400">Account setup</p>
                    <h1 class="text-2xl font-semibold">Create your Mela Support profile</h1>
                </div>

                <div class="flex items-center gap-3">
                    <button class="rounded-2xl bg-[var(--color-primary)] px-5 py-2 text-sm font-semibold text-white shadow-sm transition-all duration-300 hover:-translate-y-0.5 hover:shadow-md">
                        Need help?
                    </button>

                    <button class="mobile-menu-btn lg:hidden rounded-2xl border border-slate-200/70 bg-white px-3 py-2 text-sm font-medium text-slate-700 shadow-sm transition-all duration-300 hover:-translate-y-0.5 hover:shadow-md">
                        <i data-lucide="menu" class="h-4 w-4"></i>
                    </button>
                </div>
            </div>
        </header>
      <main class="px-6 py-10">
        <section class="grid gap-8 lg:grid-cols-2">
          <div class="rounded-[2rem] border border-slate-200/70 bg-white/70 p-8 shadow-sm">
            <p class="text-xs uppercase tracking-[0.25em] text-slate-400">Welcome</p>
            <h2 class="mt-4 text-3xl font-semibold">Join 1M+ Ethiopians using evidence-based support.</h2>
            <p class="mt-4 text-slate-600">Create a secure account to open cases, track resolution timelines, and stay connected with your service provider.</p>
            <div class="mt-8 space-y-4">
              <div class="flex items-center gap-3 rounded-2xl border border-slate-200/70 bg-white/80 p-4">
                <i data-lucide="shield" class="h-5 w-5 text-[var(--color-primary)]"></i>
                <div>
                  <p class="text-sm font-medium">Verified Identity</p>
                  <p class="text-xs text-slate-500">Two-factor protected sessions</p>
                </div>
              </div>
              <div class="flex items-center gap-3 rounded-2xl border border-slate-200/70 bg-white/80 p-4">
                <i data-lucide="sparkles" class="h-5 w-5 text-[var(--color-action)]"></i>
                <div>
                  <p class="text-sm font-medium">Faster Resolutions</p>
                  <p class="text-xs text-slate-500">Priority routing for urgent issues</p>
                </div>
              </div>
              <div class="flex items-center gap-3 rounded-2xl border border-slate-200/70 bg-white/80 p-4">
                <i data-lucide="map" class="h-5 w-5 text-[var(--color-primary)]"></i>
                <div>
                  <p class="text-sm font-medium">Local Coverage</p>
                  <p class="text-xs text-slate-500">Service centers in every sub-city</p>
                </div>
              </div>
            </div>
          </div>

          <form class="rounded-[2rem] border border-slate-200/70 bg-white/70 p-8 shadow-sm" method="POST" action="{{ route('register') }}">@csrf
            <h3 class="text-xl font-semibold">Register</h3>
            <p class="text-sm text-slate-500">Tell us about your profile.</p>
            <div class="mt-6 space-y-4">
              <div>
                <label class="text-sm font-medium">Full Name</label>
                <input class="mt-2 w-full rounded-2xl border border-slate-200/70 bg-white px-4 py-3 text-sm" name="name" value="{{ old('name') }}" />
                @error('name')
                    <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                @enderror
              </div>
              <div>
                <label class="text-sm font-medium">Email Address</label>
                <input class="mt-2 w-full rounded-2xl border border-slate-200/70 bg-white px-4 py-3 text-sm" name="email" value="{{ old('email') }}" />
                @error('email')
                    <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                @enderror
              </div>
              <div>
                  <label for="password" class="text-sm font-medium">Password</label>
                  <input id="password" type="password" name="password" 
                          class="mt-2 w-full rounded-2xl border
                            @error('password') border-red-500 @else border-slate-200/70 @enderror bg-white px-4 py-3 text-sm" 
                          required autocomplete="current-password" />
                  @error('password')
                      <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                  @enderror
              </div>
              <div>
                  <label for="password_confirmation" class="text-sm font-medium">Confirm Password</label>
                  <input id="password_confirmation" type="password" name="password_confirmation" 
                          class="mt-2 w-full rounded-2xl border 
                          @error('password_confirmation') border-red-500 @else border-slate-200/70 @enderror bg-white px-4 py-3 text-sm" 
                          required autocomplete="current-password" />
                  @error('password_confirmation')
                      <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                  @enderror
              </div>
              
              <div>
              <label class="text-sm font-medium">Phone Number</label>
              <input class="mt-2 w-full rounded-2xl border @error('phone') border-red-500 @else border-slate-200/70 @enderror bg-white px-4 py-3 text-sm" 
                      name="phone" value="{{ old('phone') }}" />
              @error('phone')
                  <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
              @enderror
              </div>

              <div>
              <label class="text-sm font-medium">Kebele / Sub-city</label>
              <input class="mt-2 w-full rounded-2xl border @error('kebele') border-red-500 @else border-slate-200/70 @enderror bg-white px-4 py-3 text-sm" 
                      name="kebele" value="{{ old('kebele') }}" />
              @error('kebele')
                  <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
              @enderror
              </div>
            </div>
            <button class="mt-6 w-full rounded-2xl bg-[var(--color-action)] px-5 py-3 text-sm font-semibold text-white shadow-sm transition-all duration-300 hover:-translate-y-0.5 hover:shadow-md">Create Account</button>
            <p class="mt-4 text-xs text-slate-500">By continuing you agree to Mela Support terms and privacy policy.</p>
          
          </form>
        </section>
      </main>
    </div>

</x-app-layout> --}}
<x-app-layout title="Register" css='css/style-78.css'>
    <div class="flex-1">
      
        <header class="sticky top-0 z-20 border-b border-slate-200/70 bg-white/70 backdrop-blur-xl">
            <div class="flex flex-wrap items-center justify-between gap-4 px-6 py-4">
                <div>
                    <div class="mb-2 flex items-center gap-3 lg:hidden">
                        <!-- Remember to update this logo later! -->
                        <img src="logo.png" alt="BiT Support Logo" class="h-10 w-auto" />
                        <span class="text-sm font-semibold">Mela Support: BiT Edition</span>
                    </div>
                    <p class="text-xs uppercase tracking-[0.25em] text-slate-400">Account setup</p>
                    <h1 class="text-2xl font-semibold">Create your BiT Campus Profile</h1>
                </div>

                <div class="flex items-center gap-3">
                    <button class="rounded-2xl bg-[var(--color-primary)] px-5 py-2 text-sm font-semibold text-white shadow-sm transition-all duration-300 hover:-translate-y-0.5 hover:shadow-md">
                        Need help?
                    </button>

                    <button class="mobile-menu-btn lg:hidden rounded-2xl border border-slate-200/70 bg-white px-3 py-2 text-sm font-medium text-slate-700 shadow-sm transition-all duration-300 hover:-translate-y-0.5 hover:shadow-md">
                        <i data-lucide="menu" class="h-4 w-4"></i>
                    </button>
                </div>
            </div>
        </header>

      <main class="px-6 py-10">
        <section class="grid gap-8 lg:grid-cols-2">
          
          <!-- 🎓 THE NEW UNIVERSITY MARKETING TEXT 🎓 -->
          <div class="rounded-[2rem] border border-slate-200/70 bg-white/70 p-8 shadow-sm">
            <p class="text-xs uppercase tracking-[0.25em] text-slate-400">Welcome to BiT</p>
            <h2 class="mt-4 text-3xl font-semibold">Join the smart campus maintenance network.</h2>
            <p class="mt-4 text-slate-600">Create your secure account to report broken facilities in dorms, labs, or classrooms, and track resolution timelines directly from your phone.</p>
            
            <div class="mt-8 space-y-4">
              <div class="flex items-center gap-3 rounded-2xl border border-slate-200/70 bg-white/80 p-4">
                <i data-lucide="shield" class="h-5 w-5 text-[var(--color-primary)]"></i>
                <div>
                  <p class="text-sm font-medium">Verified Campus Identity</p>
                  <p class="text-xs text-slate-500">Secure access for BiT Students & Staff</p>
                </div>
              </div>
              <div class="flex items-center gap-3 rounded-2xl border border-slate-200/70 bg-white/80 p-4">
                <i data-lucide="zap" class="h-5 w-5 text-[var(--color-action)]"></i>
                <div>
                  <p class="text-sm font-medium">Faster Resolutions</p>
                  <p class="text-xs text-slate-500">Direct routing to the right campus technician</p>
                </div>
              </div>
              <div class="flex items-center gap-3 rounded-2xl border border-slate-200/70 bg-white/80 p-4">
                <i data-lucide="map" class="h-5 w-5 text-[var(--color-primary)]"></i>
                <div>
                  <p class="text-sm font-medium">Full Campus Coverage</p>
                  <p class="text-xs text-slate-500">Supporting all dormitories, labs, and blocks</p>
                </div>
              </div>
            </div>
          </div>

          <!-- 📝 THE UPDATED REGISTRATION FORM 📝 -->
          <form class="rounded-[2rem] border border-slate-200/70 bg-white/70 p-8 shadow-sm" method="POST" action="{{ route('register') }}">
            @csrf
            <h3 class="text-xl font-semibold">Register</h3>
            <p class="text-sm text-slate-500">Tell us about your campus profile.</p>
            
            <div class="mt-6 space-y-4">
              <div>
                <label class="text-sm font-medium">Full Name</label>
                <input class="mt-2 w-full rounded-2xl border border-slate-200/70 bg-white px-4 py-3 text-sm focus:border-[var(--color-primary)] outline-none" name="name" value="{{ old('name') }}" placeholder="e.g. Abebe Kebede" />
                @error('name') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
              </div>
              
              <div>
                <label class="text-sm font-medium">Email Address</label>
                <input type="email" class="mt-2 w-full rounded-2xl border border-slate-200/70 bg-white px-4 py-3 text-sm focus:border-[var(--color-primary)] outline-none" name="email" value="{{ old('email') }}" placeholder="student@bit.edu.et" />
                @error('email') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
              </div>

              <!-- 🆕 NEW DROPDOWN: CAMPUS ROLE 🆕 -->
              <div>
                <label class="text-sm font-medium">I am a...</label>
                <select name="campus_role" class="mt-2 w-full rounded-2xl border border-slate-200/70 bg-white px-4 py-3 text-sm focus:border-[var(--color-primary)] outline-none">
                    <option value="" disabled selected>Select your affiliation...</option>
                    <option value="student">Student</option>
                    <option value="teacher">Teacher / Professor</option>
                    <option value="admin_staff">Administrative Staff</option>
                    <option value="other">Other Campus Staff</option>
                </select>
                @error('campus_role') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
              </div>

              <div>
                  <label class="text-sm font-medium">Password</label>
                  <input type="password" name="password" 
                          class="mt-2 w-full rounded-2xl border @error('password') border-red-500 @else border-slate-200/70 @enderror bg-white px-4 py-3 text-sm focus:border-[var(--color-primary)] outline-none" 
                          required autocomplete="new-password" />
                  @error('password') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
              </div>
              
              <div>
                  <label class="text-sm font-medium">Confirm Password</label>
                  <input type="password" name="password_confirmation" 
                          class="mt-2 w-full rounded-2xl border @error('password_confirmation') border-red-500 @else border-slate-200/70 @enderror bg-white px-4 py-3 text-sm focus:border-[var(--color-primary)] outline-none" 
                          required autocomplete="new-password" />
              </div>
              
              <div>
                  <label class="text-sm font-medium">Phone Number</label>
                  <input type="text" class="mt-2 w-full rounded-2xl border @error('phone') border-red-500 @else border-slate-200/70 @enderror bg-white px-4 py-3 text-sm focus:border-[var(--color-primary)] outline-none" 
                          name="phone" value="{{ old('phone') }}" placeholder="+251 9..." />
                  @error('phone') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
              </div>

              <!-- KEBELE HAS BEEN COMPLETELY REMOVED! -->

            </div>
            <button type="submit" class="mt-6 w-full rounded-2xl bg-[var(--color-action)] px-5 py-3 text-sm font-semibold text-white shadow-sm transition-all duration-300 hover:-translate-y-0.5 hover:shadow-md">
                Create Campus Account
            </button>
            <p class="mt-4 text-xs text-slate-500 text-center">By continuing you agree to Bahir Dar University's IT terms and privacy policy.</p>
          
          </form>
        </section>
      </main>
    </div>
</x-app-layout>