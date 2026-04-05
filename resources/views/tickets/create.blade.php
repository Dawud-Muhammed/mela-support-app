<x-app-layout title="Create Ticket" >
    <div class="flex-1">
        <!-- Header -->
        <header class="sticky top-0 z-20 border-b border-slate-200/70 bg-white/70 backdrop-blur-xl">
          <div class="flex flex-wrap items-center justify-between gap-4 px-6 py-4">
            <div>
              <div class="mb-2 flex items-center gap-3 lg:hidden">
                <img src="{{ asset('mela-logo.svg') }}"alt="BiT Logo" class="h-10 w-auto">
                <span class="text-sm font-semibold">Mela Support</span>
              </div>
              <p class="text-xs uppercase tracking-[0.25em] text-slate-400">Case Intake</p>
              <h1 class="text-2xl font-semibold">Create Ticket</h1>
            </div>
            {{-- <div class="flex items-center gap-3">
              <button class="rounded-2xl bg-[var(--color-primary)] px-5 py-2 text-sm font-semibold text-white shadow-sm transition-all duration-300 hover:-translate-y-0.5 hover:shadow-md">Save Draft</button>
              <button class="mobile-menu-btn lg:hidden rounded-2xl border border-slate-200/70 bg-white px-3 py-2 text-sm font-medium text-slate-700 shadow-sm transition-all duration-300 hover:-translate-y-0.5 hover:shadow-md">
                <i data-lucide="menu" class="h-4 w-4"></i>
              </button>
            </div> --}}
          </div>
        </header>
        
        <main class="px-6 py-10">
          <div class="mx-auto w-full max-w-5xl">
            <section class="grid gap-8 lg:grid-cols-[minmax(0,2fr)_minmax(0,1fr)]">
              
              <form class="rounded-[2rem] border border-slate-200/70 bg-white/70 p-8 shadow-sm" action="{{ route('tickets.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                
                <!-- STEP 1: CASE DETAILS -->
                <div class="flex items-center justify-between">
                  <div>
                    <p class="text-xs uppercase tracking-[0.25em] text-slate-400">Step 1</p>
                    <h2 class="text-xl font-semibold">Case Details</h2>
                  </div>
                </div>

                <div class="mt-6 space-y-4">
                  <div>
                    <label class="text-sm font-medium">Category</label>
                    <select class="mt-2 w-full rounded-2xl border border-slate-200/70 bg-white px-4 py-3 text-sm focus:border-[var(--color-primary)] outline-none" name="category_id" required>
                      <option value="">Select an issue type...</option>
                      @foreach($categories as $category)
                          <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                      @endforeach
                    </select>
                    @error('category_id') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                  </div>

                  <div>
                    <label class="text-sm font-medium">Subject</label>
                    <input class="mt-2 w-full rounded-2xl border border-slate-200/70 bg-white px-4 py-3 text-sm focus:border-[var(--color-primary)] outline-none" value="{{ old('subject') }}" name="subject" placeholder="Brief summary of the issue" required/>
                    @error('subject') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                  </div>

                  <div>
                    <label class="text-sm font-medium">Detailed Description</label>
                    <textarea class="mt-2 w-full rounded-2xl border border-slate-200/70 bg-white px-4 py-3 text-sm focus:border-[var(--color-primary)] outline-none" rows="4" name="description" placeholder="Explain the problem in detail..." required>{{ old('description') }}</textarea>
                    @error('description') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                  </div>
                </div>

                <!-- STEP 2: LOCATION DETAILS (THE BiT MAP) -->
                <div class="mt-8 border-t border-slate-200/70 pt-6">
                  <div class="flex items-center justify-between mb-6">
                    <div>
                      <p class="text-xs uppercase tracking-[0.25em] text-slate-400">Step 2</p>
                      <h3 class="text-lg font-semibold">Location Details</h3>
                    </div>
                  </div>

                  <div class="grid gap-6 md:grid-cols-2">
                    <!-- Building Dropdown -->
                    <div>
                      <label class="text-sm font-medium text-slate-700">Building / Block <span class="text-red-500">*</span></label>
                      <select name="building" required class="mt-2 w-full rounded-2xl border border-slate-200/70 bg-white px-4 py-3 text-sm focus:border-[var(--color-primary)] outline-none">
                        <option value="" disabled selected>Select Building...</option>
                        
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
                      @error('building') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <!-- Floor Dropdown -->
                    <div>
                      <label class="text-sm font-medium text-slate-700">Floor <span class="text-red-500">*</span></label>
                      <select name="floor" required class="mt-2 w-full rounded-2xl border border-slate-200/70 bg-white px-4 py-3 text-sm focus:border-[var(--color-primary)] outline-none">
                        <option value="" disabled selected>Select Floor...</option>
                        <option value="Ground Floor">Ground Floor</option>
                        <option value="1st Floor">1st Floor</option>
                        <option value="2nd Floor">2nd Floor</option>
                        <option value="3rd Floor">3rd Floor</option>
                        <option value="4th Floor">4th Floor</option>
                      </select>
                      @error('floor') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <!-- Exact Location Details -->
                    <div class="md:col-span-2">
                      <label class="text-sm font-medium text-slate-700">Exact Location Details <span class="text-red-500">*</span></label>
                      <input type="text" name="specific_location" required class="mt-2 w-full rounded-2xl border border-slate-200/70 bg-white px-4 py-3 text-sm focus:border-[var(--color-primary)] outline-none placeholder:text-slate-400" placeholder="e.g. Dorm 104, right-side bathroom sink" value="{{ old('specific_location') }}" />
                      <p class="mt-1 text-xs text-slate-500">Please be as specific as possible so the technician can find the issue quickly.</p>
                      @error('specific_location') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                  </div>
                </div>

                <!-- STEP 3: EVIDENCE UPLOAD -->
                <div class="mt-8 border-t border-slate-200/70 pt-6">
                  <div class="flex items-center justify-between">
                    <div>
                      <p class="text-xs uppercase tracking-[0.25em] text-slate-400">Step 3</p>
                      <h3 class="text-lg font-semibold">Evidence Upload</h3>
                    </div>
                  </div>
                  <div class="mt-4">
                      <input type="file" name="evidence" accept=".jpg,.jpeg,.png,.pdf" class="block w-full text-sm text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-[var(--color-primary)] file:text-white hover:file:bg-indigo-700" required/>
                      @error('evidence') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                  </div>
                </div>

                <div class="mt-8 border-t border-slate-200/70 pt-6">
                  <div class="mt-4 flex flex-wrap gap-4">
                    <button type="submit" class="rounded-2xl bg-[var(--color-action)] px-8 py-3 text-sm font-semibold text-white shadow-sm transition-all duration-300 hover:-translate-y-0.5 hover:shadow-md">Submit Campus Ticket</button>
                  </div>
                </div>
              </form>

              <!-- SIDEBAR: REPORTER DETAILS -->
              <aside class="space-y-6">
                <div class="rounded-[2rem] border border-slate-200/70 bg-white/70 p-6 shadow-sm">
                  <p class="text-xs uppercase tracking-[0.25em] text-slate-400">Reporter Details</p>
                  <div class="mt-4 space-y-3 text-sm">
                    <p><span class="font-medium text-slate-500">Name:</span> {{ auth()->user()->name }}</p>
                    <p><span class="font-medium text-slate-500">Email:</span> {{ auth()->user()->email }}</p>
                    <p><span class="font-medium text-slate-500">Phone:</span> {{ auth()->user()->phone ?? 'Not provided' }}</p>
                    <p><span class="font-medium text-slate-500">Affiliation:</span> <span class="capitalize">{{ str_replace('_', ' ', auth()->user()->campus_role ?? 'Campus Member') }}</span></p>
                  </div>
                </div>
              </aside>
            </section>
          </div>
        </main>
    </div>
</x-app-layout>