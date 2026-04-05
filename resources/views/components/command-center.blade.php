<section class="rounded-3xl border border-slate-200/70 bg-white/80 p-8 shadow-sm">
  <!-- SUCCESS MESSAGE DISPLAYER (Keep your existing JS logic exactly as is) -->
  @if (session('success'))
      <!-- Your exact success toast HTML here -->
        <div class="px-6 pb-6">
          <div class="mx-auto w-full max-w-2xl md:ml-auto md:mr-0 md:max-w-md">
            <div id="success-toast" class="flex items-start gap-3 rounded-[1.5rem] border border-emerald-300/50 bg-emerald-50/40 p-4 text-emerald-950 shadow-lg backdrop-blur-md transition-all duration-500 ease-out opacity-0 -translate-y-3" role="status" aria-live="polite">
              <div class="mt-0.5 rounded-full bg-emerald-500/10 p-2">
                <i data-lucide="check-circle" class="h-5 w-5 text-emerald-600"></i>
              </div>
              <div class="flex-1">
                <p class="text-sm font-semibold uppercase tracking-[0.18em] text-emerald-700">Success</p>
                <p class="mt-1 text-sm text-emerald-900">{{ session('success') }}</p>
              </div>
              <button type="button" data-toast-close class="rounded-full p-1 text-emerald-700/80 transition hover:bg-emerald-500/10 hover:text-emerald-900" aria-label="Dismiss notification">
                <i data-lucide="x" class="h-4 w-4"></i>
              </button>
            </div>
          </div>
        </div>
        <script>
          document.addEventListener('DOMContentLoaded', () => {
            const toast = document.getElementById('success-toast');
            if (!toast) return;
            const closeBtn = toast.querySelector('[data-toast-close]');
            const showToast = () => { requestAnimationFrame(() => { toast.classList.remove('opacity-0', '-translate-y-3'); toast.classList.add('opacity-100', 'translate-y-0'); }); };
            const hideToast = () => { toast.classList.add('opacity-0', '-translate-y-3'); toast.classList.remove('opacity-100', 'translate-y-0'); setTimeout(() => toast.remove(), 500); };
            showToast(); const timer = setTimeout(hideToast, 7000);
            if (closeBtn) closeBtn.addEventListener('click', () => { clearTimeout(timer); hideToast(); });
          });
        </script>
  @endif

    <div class="flex flex-wrap items-center justify-between gap-4">
      <div>
        <p class="text-xs uppercase tracking-[0.25em] text-slate-400">Campus Admin View</p>
        <h2 class="mt-2 text-2xl font-semibold">Command Center: Technician Control</h2>
      </div>
    </div>

    <div class="mt-6 grid gap-6 lg:grid-cols-[minmax(0,1fr)_minmax(0,1fr)]">
      
      <!-- 👷 LEFT COLUMN: REGISTER TECHNICIAN -->
      <div class="rounded-3xl border border-slate-200/70 bg-white/90 p-6">
        <div class="flex items-center gap-3">
          <div class="flex h-10 w-10 items-center justify-center rounded-2xl bg-[var(--color-primary)]/10 text-[var(--color-primary)]">
            <i data-lucide="user-plus" class="h-5 w-5"></i>
          </div>
          <div>
            <p class="text-xs uppercase tracking-[0.25em] text-slate-400">Add New Staff</p>
            <h3 class="text-lg font-semibold">Register Campus Technician</h3>
          </div>
        </div>

        <form method="POST" action="{{ route('admin.agents.store') }}" class="mt-6 space-y-4">
          @csrf 
          
          <!-- Name & Email -->
          <div class="grid gap-4 sm:grid-cols-2">
              <div>
                <label class="text-sm font-medium">Full Name</label>
                <input name="name" value="{{ old('name') }}" class="mt-2 w-full rounded-2xl border border-slate-200/70 bg-white px-4 py-3 text-sm focus:border-[var(--color-primary)] outline-none" placeholder="Abebe Kebede" required />
                @error('name') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
              </div>
              <div>
                <label class="text-sm font-medium">Official Email</label>
                <input type="email" name="email" value="{{ old('email') }}" class="mt-2 w-full rounded-2xl border border-slate-200/70 bg-white px-4 py-3 text-sm focus:border-[var(--color-primary)] outline-none" placeholder="abebe@bit.edu.et" required />
                @error('email') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
              </div>
          </div>

          <!-- Phone & Specialty -->
          <div class="grid gap-4 sm:grid-cols-2">
            <div>
              <label class="text-sm font-medium">Phone Number</label>
              <input name="phone" value="{{ old('phone') }}" class="mt-2 w-full rounded-2xl border border-slate-200/70 bg-white px-4 py-3 text-sm focus:border-[var(--color-primary)] outline-none" placeholder="+251..." required />
              @error('phone') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
            </div>
            <div>
              <label class="text-sm font-medium">Specialty (Field)</label>
              <select name="specialty" class="mt-2 w-full rounded-2xl border border-slate-200/70 bg-white px-4 py-3 text-sm focus:border-[var(--color-primary)] outline-none" required>
                  <option value="" disabled selected>Select Skill...</option>
                  <!-- We match these to our DatabaseSeeder Categories! -->
                  <option value="Plumbing & Water">Plumbing & Water</option>
                  <option value="Electrical & Power">Electrical & Power</option>
                  <option value="IT & Network">IT & Network</option>
                  <option value="Carpentry & Furniture">Carpentry & Furniture</option>
              </select>
              @error('specialty') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
            </div>
          </div>

          <!-- 🚨 THE MULTI-BUILDING SELECTOR 🚨 -->
          <div>
              <label class="text-sm font-medium flex justify-between">
                  <span>Assigned Buildings</span>
                  <span class="text-xs text-slate-400 font-normal">Hold CTRL to select multiple</span>
              </label>
              <select name="assigned_buildings[]" multiple class="mt-2 w-full rounded-2xl border border-slate-200/70 bg-white px-4 py-3 text-sm focus:border-[var(--color-primary)] outline-none h-32" required>
                    <optgroup label="Men's Dormitories">
                      <option value="Thomas Edison Dorm">Thomas Edison</option>
                      <option value="James Watt Dorm">James Watt</option>
                      <option value="Albert Einstein Dorm">Albert Einstein</option>
                      <option value="Guna Dorm">Guna</option>
                      <option value="Abdisa Aga Dorm">Abdisa Aga</option>
                      <option value="Aklilu Lema Dorm">Aklilu Lema</option>
                      <option value="Gafat Dorm">Gafat</option>
                  </optgroup>
                    <optgroup label="Women's Dormitories">
                        <option value="Empress Taytu Dorm">Empress Taytu</option>
                        <option value="Empress Zewditu Dorm">Empress Zewditu</option>
                        <option value="Abebech Gobena Dorm">Abebech Gobena</option>
                    </optgroup>
                    <optgroup label="Classrooms & Halls">
                        <option value="Ghion Classroom">Ghion</option>
                        <option value="Poli A Classroom">Poli A</option>
                        <option value="Poli B Classroom">Poli B</option>
                        <option value="Poli C Classroom">Poli C</option>
                        <option value="Poli D Classroom">Poli D</option>
                        <option value="Washera Hall">Washera Hall</option>
                        <option value="Emperor Tewodros 1">Emperor Tewodros 1</option>
                        <option value="Emperor Tewodros 2">Emperor Tewodros 2</option>
                    </optgroup>
                                            <optgroup label="Laboratories">
                        <option value="Computing Lab">Computing Lab</option>
                        <option value="Engineering Lab">Engineering Lab</option>
                        <option value="Nutrition Lab">Nutrition Lab</option>
                    </optgroup>

                    <optgroup label="Staff & Admin">
                        <option value="Kitaw Ejigu Building">Kitaw Ejigu</option>
                        <option value="Kehas Building">Kehas</option>
                        <option value="Registrar Office">Registrar</option>
                        <option value="Tana Building">Tana</option>
                    </optgroup>

                    <optgroup label="Campus Services">
                        <option value="Mother Cafe">Mother Cafe</option>
                        <option value="Sister Cafe">Sister Cafe</option>
                        <option value="Jan Mosqov Library">Jan Mosqov Library</option>
                        <option value="Campus Clinic">Clinic</option>
                        <option value="Teachers Lounge">Teacher's Lounge</option>
                        <option value="Students Lounge">Student's Lounge</option>
                        <option value="Campus Shop">Campus Shop</option>
                        <option value="Gamezone">Gamezone</option>
                    </optgroup>
              </select>
              @error('assigned_buildings') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
          </div>

          <!-- Passwords -->
          <div class="grid gap-4 sm:grid-cols-2">
            <div>
              <label class="text-sm font-medium">Temporary Password</label>
              <input type="password" name="password" class="mt-2 w-full rounded-2xl border border-slate-200/70 bg-white px-4 py-3 text-sm focus:border-[var(--color-primary)] outline-none" required />
              @error('password') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
            </div>
            <div>
              <label class="text-sm font-medium">Confirm Password</label>
              <input type="password" name="password_confirmation" class="mt-2 w-full rounded-2xl border border-slate-200/70 bg-white px-4 py-3 text-sm focus:border-[var(--color-primary)] outline-none" required />
            </div>
          </div>

          <button type="submit" class="mt-4 inline-flex w-full items-center justify-center gap-2 rounded-2xl bg-[var(--color-primary)] px-6 py-3 text-sm font-semibold text-white shadow-sm transition-all duration-300 hover:-translate-y-0.5 hover:shadow-md">
            <i data-lucide="shield-check" class="h-4 w-4"></i>
            Generate Technician Account
          </button>
        </form>
      </div>

      <!-- 📋 RIGHT COLUMN: ACTIVE DIRECTORY -->
      <div class="rounded-3xl border border-slate-200/70 bg-white/90 p-6 flex flex-col">
        <div class="flex items-center justify-between border-b border-slate-100 pb-4">
          <div>
            <p class="text-xs uppercase tracking-[0.25em] text-slate-400">Staff Directory</p>
            <h3 class="text-lg font-semibold">Active Technicians</h3>
          </div>
        </div>
        
        <div class="mt-6 flex-1 overflow-y-auto">
            <!-- DYNAMIC LIST OF TECHNICIANS -->
            @php
                // Fetch all users who are technicians (Architect shortcut just for the component)
                $technicians = \App\Models\User::where('role', 'technician')->get();
            @endphp
            
            @forelse($technicians as $tech)
                <div class="mb-4 rounded-2xl border border-slate-200/70 bg-slate-50/50 p-4 shadow-sm">
                    <div class="flex justify-between items-start">
                        <div>
                            <h4 class="font-semibold text-slate-800">{{ $tech->name }}</h4>
                            <p class="text-xs font-medium text-indigo-600 mt-0.5">{{ $tech->specialty }}</p>
                        </div>
                        <span class="rounded-full bg-emerald-100 px-2.5 py-0.5 text-[10px] font-bold text-emerald-700 uppercase tracking-wider">Active</span>
                    </div>
                    
                    <div class="mt-3 text-xs text-slate-600">
                        <p><i data-lucide="phone" class="inline h-3 w-3 mr-1"></i> {{ $tech->phone }}</p>
                        <p class="mt-1 leading-relaxed"><i data-lucide="building" class="inline h-3 w-3 mr-1"></i> 
                            <!-- Show the buildings as a comma separated list -->
                            {{ str_replace('"', '', trim($tech->assigned_buildings, '[]')) }}
                        </p>
                    </div>
                </div>
            @empty
                <div class="text-center py-10 text-slate-500">
                    <i data-lucide="users" class="mx-auto h-8 w-8 mb-2 opacity-50"></i>
                    <p>No technicians registered yet.</p>
                </div>
            @endforelse
        </div>
      </div>
      
    </div>
</section>