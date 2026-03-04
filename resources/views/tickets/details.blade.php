{{-- 
<x-app-layout title="Ticket {{ $ticket->tracking_id }}" css='css/style-78.css'>
    <div class="flex-1">
        <header class="sticky top-0 z-20 border-b border-slate-200/70 bg-white/70 backdrop-blur-xl">
          <div class="flex flex-wrap items-center justify-between gap-4 px-6 py-4">
            <div>
              <div class="mb-2 flex items-center gap-3 lg:hidden">
                <img src="{{ asset('logo.png') }}" alt="BiT Logo" class="h-10 w-auto" />
                <span class="text-sm font-semibold">Mela Support: BiT Edition</span>
              </div>             
              <p class="text-xs uppercase tracking-[0.25em] text-slate-400">Case {{ $ticket->tracking_id }}</p>
              
              <!-- 🔄 DYNAMIC TITLE -->
              <h1 class="text-2xl font-semibold">{{ $ticket->category->name }} • {{ $ticket->building }}</h1>
            </div>
            
            <!-- 🔒 ONLY TECHNICIANS/ADMINS CAN SEE THE RESOLVE BUTTON (Placeholder for later) -->
            @if(auth()->user()->role !== 'user' && $ticket->status !== 'closed' && $ticket->status !== 'resolved')
                <button class="rounded-2xl bg-[var(--color-action)] px-5 py-2 text-sm font-semibold text-white shadow-sm transition-all duration-300 hover:-translate-y-0.5 hover:shadow-md">
                    Resolve Case
                </button>
            @endif
          
            <button class="mobile-menu-btn lg:hidden rounded-2xl border border-slate-200/70 bg-white px-3 py-2 text-sm font-medium text-slate-700 shadow-sm transition-all duration-300 hover:-translate-y-0.5 hover:shadow-md">
              <i data-lucide="menu" class="h-4 w-4"></i>
            </button>
          </div>
        </header>

        <!-- SUCCESS NOTIFICATION -->
        @if (session('success'))
        <div class="px-6 pt-6">
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

        <main class="px-6 py-10">

          <!-- 🚨 TECHNICIAN ACTION PANEL (ONLY STAFF CAN SEE THIS) 🚨 -->
          @if(auth()->user()->role == 'technician')
          <section class="mb-8 rounded-[2rem] border-2 border-[var(--color-primary)] bg-indigo-50/50 p-6 shadow-sm">
            <div class="flex items-center justify-between">
              <div>
                <p class="text-xs uppercase tracking-[0.25em] text-[var(--color-primary)] font-bold">Technician Controls</p>
                <h2 class="text-xl font-semibold mt-1">Update Case Status</h2>
              </div>
            </div>
            
            <form action="{{ route('tickets.updateStatus', $ticket->id) }}" method="POST" enctype="multipart/form-data" class="mt-6 grid gap-6 md:grid-cols-3 items-end">
                @csrf
                @method('PATCH')

                <div>
                    <label class="text-sm font-medium">Change Status</label>
                    <select id="status-select" name="status" class="mt-2 w-full rounded-2xl border border-slate-200/70 bg-white px-4 py-3 text-sm focus:border-[var(--color-primary)] outline-none">
                        <option value="assigned" {{ $ticket->status === 'assigned' ? 'selected' : '' }}>Assigned to Me</option>
                        <option value="in_progress" {{ $ticket->status === 'in_progress' ? 'selected' : '' }}>On Site / Working</option>
                        <option value="resolved" {{ $ticket->status === 'resolved' ? 'selected' : '' }}>Resolved (Upload Proof)</option>
                    </select>
                </div>

                <!-- 📸 HIDDEN FILE UPLOAD (Only shows when Resolved is selected) -->
                <div id="evidence-upload-box" class="hidden">
                    <label class="text-sm font-medium text-[var(--color-primary)]">Resolution Photo <span class="text-red-500">*</span></label>
                    <input type="file" name="resolution_evidence" accept="image/*" class="mt-2 w-full text-sm text-slate-500 file:mr-4 file:py-2.5 file:px-4 file:rounded-xl file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100" />
                </div>

                <div class="flex gap-3 h-full items-end">
                    <button type="submit" class="w-full rounded-2xl bg-[var(--color-primary)] px-8 py-3 text-sm font-semibold text-white shadow-sm transition-all duration-300 hover:-translate-y-0.5 hover:shadow-md">
                        Save Update
                    </button>
                </div>
            </form>

            <script>
                document.getElementById('status-select').addEventListener('change', function() {
                    const box = document.getElementById('evidence-upload-box');
                    if(this.value === 'resolved') {
                        box.classList.remove('hidden');
                    } else {
                        box.classList.add('hidden');
                    }
                });
            </script>
          </section>
          @endif
          <!-- 🚨 END TECHNICIAN ACTION PANEL 🚨 -->

          <!-- ⚖️ STUDENT/USER VERIFICATION PANEL ⚖️ -->
          @if(auth()->user()->role === 'user' && $ticket->status === 'resolved')
          <section class="mb-8 rounded-[2rem] border-2 border-emerald-500 bg-emerald-50/30 p-6 shadow-sm">
            <div class="flex flex-col md:flex-row items-start md:items-center justify-between gap-6">
                <div>
                    <div class="flex items-center gap-2">
                        <i data-lucide="check-circle" class="h-5 w-5 text-emerald-600"></i>
                        <p class="text-xs uppercase tracking-[0.25em] text-emerald-600 font-bold">Action Required</p>
                    </div>
                    <!-- 🚨 Updated from assignedAgent to assignedTechnician -->
                    <h2 class="text-xl font-semibold mt-2 text-slate-800">Technician {{ $ticket->assignedTechnician ? $ticket->assignedTechnician->name : 'System administrator' }} marked this as Fixed!</h2>
                    <p class="text-sm text-slate-600 mt-1">Please review the work. Is your issue completely resolved?</p>
                    
                    @if($ticket->resolution_evidence_path)
                        <a href="{{ asset('storage/' . $ticket->resolution_evidence_path) }}" target="_blank" class="inline-flex items-center gap-2 mt-4 text-sm font-semibold text-indigo-600 hover:text-indigo-800 transition">
                            <i data-lucide="image" class="h-4 w-4"></i> View Technician's Photo Evidence
                        </a>
                    @endif
                </div>

                <form action="{{ route('tickets.verify', $ticket->id) }}" method="POST" class="flex flex-wrap gap-3 w-full md:w-auto">
                    @csrf
                    @method('PATCH')
                    <!-- ✅ Confirm Button -->
                    <button type="submit" name="action" value="confirm" class="flex-1 md:flex-none rounded-2xl bg-emerald-600 px-6 py-3 text-sm font-semibold text-white shadow-sm transition-all duration-300 hover:bg-emerald-700 hover:-translate-y-0.5 hover:shadow-md">
                        Yes, Close Ticket
                    </button>
                    <!-- ❌ Reject Button -->
                    <button type="submit" name="action" value="reject" class="flex-1 md:flex-none rounded-2xl border-2 border-red-200 bg-white px-6 py-3 text-sm font-semibold text-red-600 shadow-sm transition-all duration-300 hover:bg-red-50 hover:border-red-300 hover:-translate-y-0.5">
                        No, Still Broken
                    </button>
                </form>
            </div>
          </section>
          @endif

          <section class="grid gap-8 lg:grid-cols-[0.8fr_1.2fr]">
              
            <!-- LEFT COLUMN: STATUS & METADATA -->
            <div class="space-y-8">
                <!-- TIMELINE -->
                <div class="rounded-[2rem] border border-slate-200/70 bg-white/70 p-6 shadow-sm">
                  <p class="text-xs uppercase tracking-[0.25em] text-slate-400">Status Timeline</p>
                  <h2 class="mt-4 text-xl font-semibold">Progress</h2>
                  
                  <div class="mt-6 space-y-5">
                    <!-- 1. NEW -->
                    <div class="flex items-start gap-4">
                      <div class="mt-1 h-3 w-3 rounded-full bg-[var(--color-primary)]"></div>
                      <div>
                        <p class="text-sm font-semibold">Reported</p>
                        <p class="text-xs text-slate-500">Filed by {{ $ticket->user->name }} • {{ $ticket->created_at->format('H:i') }}</p>
                      </div>
                    </div>

                    <!-- 2. ASSIGNED -->
                    <div class="flex items-start gap-4">
                      <div class="mt-1 h-3 w-3 rounded-full {{ in_array($ticket->status, ['assigned', 'in_progress', 'resolved', 'closed']) ? 'bg-[var(--color-primary)]' : 'bg-slate-300' }}"></div>
                      <div>
                        <p class="text-sm font-semibold">Assigned to Technician</p>
                        <p class="text-xs text-slate-500">
                            <!-- 🚨 Updated from assignedAgent to assignedTechnician -->
                            {{ $ticket->assignedTechnician ? $ticket->assignedTechnician->name : 'Awaiting Assignment' }}
                        </p>
                      </div>
                    </div>

                    <!-- 3. IN PROGRESS -->
                    <div class="flex items-start gap-4">
                      <div class="mt-1 h-3 w-3 rounded-full {{ in_array($ticket->status, ['in_progress', 'resolved', 'closed']) ? 'bg-[var(--color-primary)]' : 'bg-slate-300' }}"></div>
                      <div>
                        <p class="text-sm font-semibold">Technician Dispatched</p>
                        <p class="text-xs text-slate-500">
                            {{ $ticket->status === 'open' ? 'Pending' : 'Staff is on site or on the way' }}
                        </p>
                      </div>
                    </div>

                    <!-- 4. RESOLVED / CLOSED -->
                    <div class="flex items-start gap-4">
                      <div class="mt-1 h-3 w-3 rounded-full {{ in_array($ticket->status, ['resolved', 'closed']) ? 'bg-[var(--color-primary)]' : 'bg-slate-300' }}"></div>
                      <div>
                        @if($ticket->status === 'resolved')
                            <p class="text-sm font-semibold text-amber-600">Awaiting Your Confirmation</p>
                            <p class="text-xs text-slate-500">Tech marked it fixed. Please verify.</p>
                        @elseif($ticket->status === 'closed')
                            <p class="text-sm font-semibold text-emerald-600">Officially Closed</p>
                            <p class="text-xs text-slate-500">Resolution confirmed.</p>
                        @else
                            <p class="text-sm font-semibold text-slate-500">Resolution</p>
                            <p class="text-xs text-slate-500">Pending completion</p>
                        @endif
                      </div>
                    </div>
                  </div>
                </div>

                <!-- METADATA (BiT CAMPUS EDITION) -->
                <div class="rounded-2xl border border-slate-200/70 bg-white/80 p-6 shadow-sm">
                  <p class="text-xs uppercase tracking-[0.25em] text-slate-400">Campus Location</p>
                  <div class="mt-4 space-y-3 text-sm">
                    <p class="flex justify-between border-b border-slate-100 pb-2"><span class="font-medium text-slate-500">Building / Block:</span> <span class="font-semibold text-right">{{ $ticket->building }}</span></p>
                    <p class="flex justify-between border-b border-slate-100 pb-2"><span class="font-medium text-slate-500">Floor:</span> <span class="font-semibold text-right">{{ $ticket->floor }}</span></p>
                    <p class="flex flex-col border-b border-slate-100 pb-2"><span class="font-medium text-slate-500 mb-1">Exact Details:</span> <span class="font-semibold">{{ $ticket->specific_location }}</span></p>
                    <p class="flex justify-between mt-2"><span class="font-medium text-slate-500">SLA Target:</span> <span class="font-semibold text-[var(--color-primary)]">{{ $ticket->eta_timestamp ? $ticket->eta_timestamp->format('M d, H:i') : 'N/A' }}</span></p>
                  </div>
                </div>
                
                <!-- IF STUDENT UPLOADED A PHOTO OF THE BROKEN THING -->
                @if($ticket->evidence_path)
                <div class="rounded-2xl border border-slate-200/70 bg-white/80 p-6 shadow-sm">
                  <p class="text-xs uppercase tracking-[0.25em] text-slate-400">Initial Evidence</p>
                  <a href="{{ asset('storage/' . $ticket->evidence_path) }}" target="_blank" class="mt-3 block overflow-hidden rounded-xl border border-slate-200 hover:opacity-90 transition">
                      <img src="{{ asset('storage/' . $ticket->evidence_path) }}" alt="Problem Evidence" class="w-full h-auto object-cover max-h-48" />
                  </a>
                </div>
                @endif
            </div>
            
                        <!-- RIGHT COLUMN: CONVERSATION -->
            <div class="rounded-[2rem] border border-slate-200/70 bg-white/70 p-6 shadow-sm flex flex-col h-[600px]">
              <div class="flex items-center justify-between border-b border-slate-100 pb-4 shrink-0">
                <div>
                  <p class="text-xs uppercase tracking-[0.25em] text-slate-400">Conversation</p>
                  <h2 class="text-xl font-semibold">Campus Member ↔ Technician</h2>
                </div>
                <span class="rounded-full bg-[var(--color-primary)]/10 px-3 py-1 text-xs font-semibold text-[var(--color-primary)] capitalize">
                    {{ str_replace('_', ' ', $ticket->status) }}
                </span>
              </div>
              
              <!-- 💬 DYNAMIC CHAT BOX 💬 -->
              <div class="mt-6 space-y-4 flex-1 overflow-y-auto pr-2 pb-4 flex flex-col-reverse">
                <!-- We use flex-col-reverse so it sticks to the bottom naturally! -->
                
                <div class="space-y-4">
                    <!-- Initial Ticket Description (The First Message) -->
                    <div class="flex items-start gap-3">
                      <div class="h-9 w-9 rounded-2xl bg-indigo-100 text-indigo-700 flex items-center justify-center font-bold text-xs shrink-0">
                          {{ substr($ticket->user->name, 0, 2) }}
                      </div>
                      <div class="rounded-2xl border border-slate-200/70 bg-white/80 p-4">
                        <p class="text-sm font-semibold">{{ $ticket->user->name }} <span class="text-xs font-normal text-slate-500 ml-2">(Reporter)</span></p>
                        <p class="text-sm text-slate-600 mt-1">{{ $ticket->description }}</p>
                        <p class="text-xs text-slate-400 mt-2">{{ $ticket->created_at->format('M d, H:i') }}</p>
                      </div>
                    </div>

                    <div class="text-center my-4">
                        <span class="text-[10px] uppercase tracking-widest font-semibold text-slate-400 bg-slate-100 px-4 py-1.5 rounded-full">System: Case Logged</span>
                    </div>

                    <!-- 🔄 THE MESSAGE LOOP -->
                    @foreach($ticket->messages->sortBy('created_at') as $msg)
                        @if($msg->user_id === auth()->id())
                            <!-- MY MESSAGE (Aligned Right, Blue) -->
                            <div class="flex items-start gap-3 justify-end">
                                <div class="rounded-2xl bg-[var(--color-primary)] p-4 text-white max-w-[85%] shadow-sm">
                                    <p class="text-sm">{{ $msg->message }}</p>
                                    <p class="text-[10px] text-indigo-200 mt-2 text-right">{{ $msg->created_at->format('H:i') }}</p>
                                </div>
                            </div>
                        @else
                            <!-- THEIR MESSAGE (Aligned Left, White) -->
                            <div class="flex items-start gap-3">
                                <div class="h-9 w-9 rounded-2xl bg-slate-200 text-slate-700 flex items-center justify-center font-bold text-xs shrink-0">
                                    {{ substr($msg->user->name, 0, 2) }}
                                </div>
                                <div class="rounded-2xl border border-slate-200/70 bg-white p-4 max-w-[85%] shadow-sm">
                                    <p class="text-sm font-semibold text-slate-800">{{ $msg->user->name }}</p>
                                    <p class="text-sm text-slate-600 mt-1">{{ $msg->message }}</p>
                                    <p class="text-[10px] text-slate-400 mt-2">{{ $msg->created_at->format('H:i') }}</p>
                                </div>
                            </div>
                        @endif
                    @endforeach
                </div>
              </div>
              
              <!-- Message Input Form -->
              <!-- Only allow chatting if the ticket is NOT officially closed -->
              @if($ticket->status !== 'closed')
                  <form action="{{ route('tickets.messages.store', $ticket->id) }}" method="POST" class="mt-4 rounded-2xl border border-slate-200/70 bg-slate-50/50 p-4 shrink-0">
                    @csrf
                    <p class="text-xs uppercase tracking-[0.25em] text-slate-400">Send Message</p>
                    <div class="mt-3 flex gap-3">
                      <input type="text" name="message" required autocomplete="off" placeholder="Type a message..." class="flex-1 rounded-2xl border border-slate-200/70 bg-white px-4 py-3 text-sm focus:outline-none focus:border-[var(--color-primary)] outline-none" />
                      <button type="submit" class="rounded-2xl bg-[var(--color-action)] px-6 py-3 text-sm font-semibold text-white transition-all duration-300 hover:-translate-y-0.5 hover:shadow-md">Send</button>
                    </div>
                  </form>
              @else
                  <div class="mt-4 text-center p-4 rounded-2xl border border-slate-200/70 bg-slate-50 text-slate-500 text-sm">
                      This ticket is officially closed. Chat is disabled.
                  </div>
              @endif
            </div>          
          </section>
        </main>
    </div>
</x-app-layout> --}}

<x-app-layout title="Ticket {{ $ticket->tracking_id }}" css='css/style-78.css'>
    <div class="flex-1">
        <header class="sticky top-0 z-20 border-b border-slate-200/70 bg-white/70 backdrop-blur-xl">
          <div class="flex flex-wrap items-center justify-between gap-4 px-6 py-4">
            <div>
              <div class="mb-2 flex items-center gap-3 lg:hidden">
                <img src="{{ asset('logo.png') }}" alt="BiT Logo" class="h-10 w-auto" />
                <span class="text-sm font-semibold">Mela Support: BiT Edition</span>
              </div>             
              <p class="text-xs uppercase tracking-[0.25em] text-slate-400">Case {{ $ticket->tracking_id }}</p>
              
              <!-- 🔄 DYNAMIC TITLE -->
              <h1 class="text-2xl font-semibold">{{ $ticket->category->name }} • {{ $ticket->building }}</h1>
            </div>
            
            <!-- 🔒 ONLY TECHNICIANS CAN SEE THE RESOLVE BUTTON -->
            @if(auth()->user()->role === 'technician' && $ticket->status !== 'closed' && $ticket->status !== 'resolved')
                <button class="rounded-2xl bg-[var(--color-action)] px-5 py-2 text-sm font-semibold text-white shadow-sm transition-all duration-300 hover:-translate-y-0.5 hover:shadow-md">
                    Resolve Case
                </button>
            @endif
          
            <button class="mobile-menu-btn lg:hidden rounded-2xl border border-slate-200/70 bg-white px-3 py-2 text-sm font-medium text-slate-700 shadow-sm transition-all duration-300 hover:-translate-y-0.5 hover:shadow-md">
              <i data-lucide="menu" class="h-4 w-4"></i>
            </button>
          </div>
        </header>

        <!-- SUCCESS NOTIFICATION -->
        @if (session('success'))
        <div class="px-6 pt-6">
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

        <main class="px-6 py-10">

          <!-- 🚨 TECHNICIAN ACTION PANEL (STRICTLY FOR TECHNICIANS ONLY) 🚨 -->
          <!-- We also hide this if the ticket is 'closed' because once verified by the user, the technician shouldn't change it -->
          @if(auth()->user()->role === 'technician' && $ticket->status !== 'closed')
          <section class="mb-8 rounded-[2rem] border-2 border-[var(--color-primary)] bg-indigo-50/50 p-6 shadow-sm">
            <div class="flex items-center justify-between">
              <div>
                <p class="text-xs uppercase tracking-[0.25em] text-[var(--color-primary)] font-bold">Technician Controls</p>
                <h2 class="text-xl font-semibold mt-1">Update Case Status</h2>
              </div>
            </div>
            
            <form action="{{ route('tickets.updateStatus', $ticket->id) }}" method="POST" enctype="multipart/form-data" class="mt-6 grid gap-6 md:grid-cols-3 items-end">
                @csrf
                @method('PATCH')

                <div>
                    <label class="text-sm font-medium">Change Status</label>
                    <select id="status-select" name="status" class="mt-2 w-full rounded-2xl border border-slate-200/70 bg-white px-4 py-3 text-sm focus:border-[var(--color-primary)] outline-none">
                        <option value="assigned" {{ $ticket->status === 'assigned' ? 'selected' : '' }}>Assigned to Me</option>
                        <option value="in_progress" {{ $ticket->status === 'in_progress' ? 'selected' : '' }}>On Site / Working</option>
                        <option value="resolved" {{ $ticket->status === 'resolved' ? 'selected' : '' }}>Resolved (Upload Proof)</option>
                    </select>
                </div>

                <!-- 📸 HIDDEN FILE UPLOAD (Only shows when Resolved is selected) -->
                <div id="evidence-upload-box" class="{{ $ticket->status === 'resolved' ? '' : 'hidden' }}">
                    <label class="text-sm font-medium text-[var(--color-primary)]">Resolution Photo <span class="text-red-500">*</span></label>
                    <input type="file" name="resolution_evidence" accept="image/*" class="mt-2 w-full text-sm text-slate-500 file:mr-4 file:py-2.5 file:px-4 file:rounded-xl file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100" />
                </div>

                <div class="flex gap-3 h-full items-end">
                    <button type="submit" class="w-full rounded-2xl bg-[var(--color-primary)] px-8 py-3 text-sm font-semibold text-white shadow-sm transition-all duration-300 hover:-translate-y-0.5 hover:shadow-md">
                        Save Update
                    </button>
                </div>
            </form>

            <script>
                document.getElementById('status-select').addEventListener('change', function() {
                    const box = document.getElementById('evidence-upload-box');
                    if(this.value === 'resolved') {
                        box.classList.remove('hidden');
                    } else {
                        box.classList.add('hidden');
                    }
                });
            </script>
          </section>
          @endif
          <!-- 🚨 END TECHNICIAN ACTION PANEL 🚨 -->

          <!-- ⚖️ STUDENT/USER VERIFICATION PANEL ⚖️ -->
          @if(auth()->user()->role === 'user' && $ticket->status === 'resolved')
          <section class="mb-8 rounded-[2rem] border-2 border-emerald-500 bg-emerald-50/30 p-6 shadow-sm">
            <div class="flex flex-col md:flex-row items-start md:items-center justify-between gap-6">
                <div>
                    <div class="flex items-center gap-2">
                        <i data-lucide="check-circle" class="h-5 w-5 text-emerald-600"></i>
                        <p class="text-xs uppercase tracking-[0.25em] text-emerald-600 font-bold">Action Required</p>
                    </div>
                    <h2 class="text-xl font-semibold mt-2 text-slate-800">Technician {{ $ticket->assignedTechnician ? $ticket->assignedTechnician->name : 'Staff' }} marked this as Fixed!</h2>
                    <p class="text-sm text-slate-600 mt-1">Please review the "After" photo below. Is your issue completely resolved?</p>
                </div>

                <form action="{{ route('tickets.verify', $ticket->id) }}" method="POST" class="flex flex-wrap gap-3 w-full md:w-auto">
                    @csrf
                    @method('PATCH')
                    <!-- ✅ Confirm Button -->
                    <button type="submit" name="action" value="confirm" class="flex-1 md:flex-none rounded-2xl bg-emerald-600 px-6 py-3 text-sm font-semibold text-white shadow-sm transition-all duration-300 hover:bg-emerald-700 hover:-translate-y-0.5 hover:shadow-md">
                        Yes, Close Ticket
                    </button>
                    <!-- ❌ Reject Button -->
                    <button type="submit" name="action" value="reject" class="flex-1 md:flex-none rounded-2xl border-2 border-red-200 bg-white px-6 py-3 text-sm font-semibold text-red-600 shadow-sm transition-all duration-300 hover:bg-red-50 hover:border-red-300 hover:-translate-y-0.5">
                        No, Still Broken
                    </button>
                </form>
            </div>
          </section>
          @endif

          <section class="grid gap-8 lg:grid-cols-[0.8fr_1.2fr]">
              
            <!-- LEFT COLUMN: STATUS & METADATA -->
            <div class="space-y-8">
                <!-- TIMELINE -->
                <div class="rounded-[2rem] border border-slate-200/70 bg-white/70 p-6 shadow-sm">
                  <p class="text-xs uppercase tracking-[0.25em] text-slate-400">Status Timeline</p>
                  <h2 class="mt-4 text-xl font-semibold">Progress</h2>
                  
                  <div class="mt-6 space-y-5">
                    <!-- 1. NEW -->
                    <div class="flex items-start gap-4">
                      <div class="mt-1 h-3 w-3 rounded-full bg-[var(--color-primary)]"></div>
                      <div>
                        <p class="text-sm font-semibold">Reported</p>
                        <p class="text-xs text-slate-500">Filed by {{ $ticket->user->name }} • {{ $ticket->created_at->format('H:i') }}</p>
                      </div>
                    </div>

                    <!-- 2. ASSIGNED -->
                    <div class="flex items-start gap-4">
                      <div class="mt-1 h-3 w-3 rounded-full {{ in_array($ticket->status, ['assigned', 'in_progress', 'resolved', 'closed']) ? 'bg-[var(--color-primary)]' : 'bg-slate-300' }}"></div>
                      <div>
                        <p class="text-sm font-semibold">Assigned to Technician</p>
                        <p class="text-xs text-slate-500">
                            {{ $ticket->assignedTechnician ? $ticket->assignedTechnician->name : 'Awaiting Assignment' }}
                        </p>
                      </div>
                    </div>

                    <!-- 3. IN PROGRESS -->
                    <div class="flex items-start gap-4">
                      <div class="mt-1 h-3 w-3 rounded-full {{ in_array($ticket->status, ['in_progress', 'resolved', 'closed']) ? 'bg-[var(--color-primary)]' : 'bg-slate-300' }}"></div>
                      <div>
                        <p class="text-sm font-semibold">Technician Dispatched</p>
                        <p class="text-xs text-slate-500">
                            {{ $ticket->status === 'open' ? 'Pending' : 'Staff is on site or on the way' }}
                        </p>
                      </div>
                    </div>

                    <!-- 4. RESOLVED / CLOSED -->
                    <div class="flex items-start gap-4">
                      <div class="mt-1 h-3 w-3 rounded-full {{ in_array($ticket->status, ['resolved', 'closed']) ? 'bg-[var(--color-primary)]' : 'bg-slate-300' }}"></div>
                      <div>
                        @if($ticket->status === 'resolved')
                            <p class="text-sm font-semibold text-amber-600">Awaiting User Confirmation</p>
                            <p class="text-xs text-slate-500">Tech marked it fixed. Please verify.</p>
                        @elseif($ticket->status === 'closed')
                            <p class="text-sm font-semibold text-emerald-600">Officially Closed</p>
                            <p class="text-xs text-slate-500">Resolution confirmed.</p>
                        @else
                            <p class="text-sm font-semibold text-slate-500">Resolution</p>
                            <p class="text-xs text-slate-500">Pending completion</p>
                        @endif
                      </div>
                    </div>
                  </div>
                </div>

                <!-- METADATA (BiT CAMPUS EDITION) -->
                <div class="rounded-2xl border border-slate-200/70 bg-white/80 p-6 shadow-sm">
                  <p class="text-xs uppercase tracking-[0.25em] text-slate-400">Campus Location</p>
                  <div class="mt-4 space-y-3 text-sm">
                    <p class="flex justify-between border-b border-slate-100 pb-2"><span class="font-medium text-slate-500">Building / Block:</span> <span class="font-semibold text-right">{{ $ticket->building }}</span></p>
                    <p class="flex justify-between border-b border-slate-100 pb-2"><span class="font-medium text-slate-500">Floor:</span> <span class="font-semibold text-right">{{ $ticket->floor }}</span></p>
                    <p class="flex flex-col border-b border-slate-100 pb-2"><span class="font-medium text-slate-500 mb-1">Exact Details:</span> <span class="font-semibold">{{ $ticket->specific_location }}</span></p>
                    <p class="flex justify-between mt-2"><span class="font-medium text-slate-500">SLA Target:</span> <span class="font-semibold text-[var(--color-primary)]">{{ $ticket->eta_timestamp ? $ticket->eta_timestamp->format('M d, H:i') : 'N/A' }}</span></p>
                  </div>
                </div>
                
                <!-- 📸 BEFORE & AFTER EVIDENCE GALLERY 📸 -->
                @if($ticket->evidence_path || $ticket->resolution_evidence_path)
                <div class="grid gap-4 {{ ($ticket->evidence_path && $ticket->resolution_evidence_path) ? 'xl:grid-cols-2' : 'grid-cols-1' }}">
                    
                    <!-- BEFORE (User Upload) -->
                    @if($ticket->evidence_path)
                    <div class="rounded-2xl border border-slate-200/70 bg-white/80 p-5 shadow-sm flex flex-col">
                        <p class="text-[10px] font-bold uppercase tracking-[0.25em] text-slate-400 mb-3 flex items-center gap-2">
                            <i data-lucide="image" class="h-3 w-3"></i> Before (Issue)
                        </p>
                        <a href="{{ asset('storage/' . $ticket->evidence_path) }}" target="_blank" class="block overflow-hidden rounded-xl border border-slate-200 hover:opacity-90 transition flex-1">
                            <img src="{{ asset('storage/' . $ticket->evidence_path) }}" alt="Problem Evidence" class="w-full h-full object-cover min-h-[150px] max-h-48" />
                        </a>
                    </div>
                    @endif

                    <!-- AFTER (Technician Upload) -->
                    @if($ticket->resolution_evidence_path)
                    <div class="rounded-2xl border border-emerald-200/70 bg-emerald-50/50 p-5 shadow-sm flex flex-col">
                        <p class="text-[10px] font-bold uppercase tracking-[0.25em] text-emerald-600 mb-3 flex items-center gap-2">
                            <i data-lucide="check-square" class="h-3 w-3"></i> After (Resolved)
                        </p>
                        <a href="{{ asset('storage/' . $ticket->resolution_evidence_path) }}" target="_blank" class="block overflow-hidden rounded-xl border border-emerald-200 hover:opacity-90 transition flex-1">
                            <img src="{{ asset('storage/' . $ticket->resolution_evidence_path) }}" alt="Resolution Evidence" class="w-full h-full object-cover min-h-[150px] max-h-48" />
                        </a>
                    </div>
                    @endif

                </div>
                @endif
            </div>
            
            <!-- RIGHT COLUMN: CONVERSATION -->
            <!-- RIGHT COLUMN: CONVERSATION -->
            <div class="rounded-[2rem] border border-slate-200/70 bg-white/70 p-6 shadow-sm flex flex-col h-[650px]">
              <div class="flex items-center justify-between border-b border-slate-100 pb-4 shrink-0">
                <div>
                  <p class="text-xs uppercase tracking-[0.25em] text-slate-400">Conversation</p>
                  <h2 class="text-xl font-semibold">Campus Member ↔ Technician</h2>
                </div>
                <span class="rounded-full bg-[var(--color-primary)]/10 px-3 py-1 text-xs font-semibold text-[var(--color-primary)] capitalize">
                    {{ str_replace('_', ' ', $ticket->status) }}
                </span>
              </div>
              
              <!-- 💬 DYNAMIC CHAT BOX 💬 -->
              <div class="mt-6 space-y-4 flex-1 overflow-y-auto pr-2 pb-4 flex flex-col-reverse">
                <div class="space-y-4">

                    <!-- 1️⃣ DYNAMIC INITIAL TICKET DESCRIPTION -->
                    @if($ticket->user_id === auth()->id())
                        <!-- MY MESSAGE (Reporter viewing their own ticket) -->
                        <div class="flex items-start gap-3 justify-end">
                            <div class="rounded-2xl bg-[var(--color-primary)] p-4 text-white max-w-[85%] shadow-sm">
                                <p class="text-[10px] uppercase tracking-widest text-indigo-200 mb-1 font-bold">Original Report</p>
                                <p class="text-sm">{{ $ticket->description }}</p>
                                <p class="text-[10px] text-indigo-200 mt-2 text-right">{{ $ticket->created_at->format('M d, H:i') }}</p>
                            </div>
                        </div>
                    @else
                        <!-- THEIR MESSAGE (Technician viewing student's ticket) -->
                        <div class="flex items-start gap-3">
                            <div class="h-9 w-9 rounded-2xl bg-indigo-100 text-indigo-700 flex items-center justify-center font-bold text-xs shrink-0">
                                {{ substr($ticket->user->name, 0, 2) }}
                            </div>
                            <div class="rounded-2xl border border-slate-200/70 bg-white p-4 max-w-[85%] shadow-sm">
                                <p class="text-sm font-semibold text-slate-800">{{ $ticket->user->name }} <span class="text-[10px] uppercase tracking-widest text-slate-400 ml-2">Original Report</span></p>
                                <p class="text-sm text-slate-600 mt-1">{{ $ticket->description }}</p>
                                <p class="text-[10px] text-slate-400 mt-2">{{ $ticket->created_at->format('M d, H:i') }}</p>
                            </div>
                        </div>
                    @endif

                    <div class="text-center my-4">
                        <span class="text-[10px] uppercase tracking-widest font-semibold text-slate-400 bg-slate-100 px-4 py-1.5 rounded-full">System: Case Logged</span>
                    </div>

                    <!-- 2️⃣ THE MESSAGE LOOP -->
                    @foreach($ticket->messages->sortBy('created_at') as $msg)
                        
                        <!-- 🛡️ SECURITY: HIDE INTERNAL NOTES FROM STUDENTS -->
                        @if($msg->is_internal && auth()->user()->role === 'user')
                            @continue
                        @endif

                        @if($msg->user_id === auth()->id())
                            <!-- MY MESSAGE -->
                            <div class="flex items-start gap-3 justify-end">
                                @if($msg->is_internal)
                                    <!-- 🔒 INTERNAL NOTE STYLE (Yellow) -->
                                    <div class="rounded-2xl bg-amber-100 p-4 text-amber-900 border border-amber-200 max-w-[85%] shadow-sm">
                                        <p class="text-[10px] uppercase tracking-widest text-amber-600 mb-1 font-bold flex items-center justify-end gap-1">
                                            <i data-lucide="lock" class="h-3 w-3"></i> Internal Note
                                        </p>
                                        <p class="text-sm">{{ $msg->message }}</p>
                                        <p class="text-[10px] text-amber-600/70 mt-2 text-right">{{ $msg->created_at->format('H:i') }}</p>
                                    </div>
                                @else
                                    <!-- NORMAL MESSAGE (Blue) -->
                                    <div class="rounded-2xl bg-[var(--color-primary)] p-4 text-white max-w-[85%] shadow-sm">
                                        <p class="text-sm">{{ $msg->message }}</p>
                                        <p class="text-[10px] text-indigo-200 mt-2 text-right">{{ $msg->created_at->format('H:i') }}</p>
                                    </div>
                                @endif
                            </div>
                        @else
                            <!-- THEIR MESSAGE -->
                            <div class="flex items-start gap-3">
                                <div class="h-9 w-9 rounded-2xl {{ $msg->is_internal ? 'bg-amber-100 text-amber-700' : 'bg-slate-200 text-slate-700' }} flex items-center justify-center font-bold text-xs shrink-0">
                                    {{ substr($msg->user->name, 0, 2) }}
                                </div>
                                @if($msg->is_internal)
                                    <!-- 🔒 THEIR INTERNAL NOTE (Yellow) -->
                                    <div class="rounded-2xl border border-amber-200 bg-amber-50 p-4 max-w-[85%] shadow-sm">
                                        <p class="text-[10px] uppercase tracking-widest text-amber-600 mb-1 font-bold flex items-center gap-1">
                                            <i data-lucide="lock" class="h-3 w-3"></i> Internal Note • {{ $msg->user->name }}
                                        </p>
                                        <p class="text-sm text-amber-900">{{ $msg->message }}</p>
                                        <p class="text-[10px] text-amber-600/70 mt-2">{{ $msg->created_at->format('H:i') }}</p>
                                    </div>
                                @else
                                    <!-- THEIR NORMAL MESSAGE (White) -->
                                    <div class="rounded-2xl border border-slate-200/70 bg-white p-4 max-w-[85%] shadow-sm">
                                        <p class="text-sm font-semibold text-slate-800">{{ $msg->user->name }}</p>
                                        <p class="text-sm text-slate-600 mt-1">{{ $msg->message }}</p>
                                        <p class="text-[10px] text-slate-400 mt-2">{{ $msg->created_at->format('H:i') }}</p>
                                    </div>
                                @endif
                            </div>
                        @endif
                    @endforeach
                </div>
              </div>
              
              <!-- 3️⃣ MESSAGE INPUT FORM -->
              @if($ticket->status !== 'closed')
                  <form action="{{ route('tickets.messages.store', $ticket->id) }}" method="POST" class="mt-4 rounded-2xl border border-slate-200/70 bg-slate-50/50 p-4 shrink-0">
                    @csrf
                    
                    <div class="flex items-center justify-between mb-3">
                        <p class="text-xs uppercase tracking-[0.25em] text-slate-400">Send Message</p>
                        
                        <!-- 🔒 TOGGLE: ONLY SHOW TO TECHNICIANS -->
                        @if(auth()->user()->role === 'technician' || auth()->user()->role === 'admin')
                        <label class="flex items-center gap-2 cursor-pointer">
                            <input type="checkbox" name="is_internal" value="1" class="peer sr-only">
                            <span class="text-xs font-medium text-slate-500 peer-checked:text-amber-600 transition-colors">Internal Note</span>
                            <div class="relative h-5 w-9 rounded-full bg-slate-200 transition-colors peer-checked:bg-amber-500">
                                <div class="absolute left-0.5 top-0.5 h-4 w-4 rounded-full bg-white transition-transform peer-checked:translate-x-4"></div>
                            </div>
                        </label>
                        @endif
                    </div>

                    <div class="flex gap-3">
                      <input type="text" name="message" required autocomplete="off" placeholder="Type a message..." class="flex-1 rounded-2xl border border-slate-200/70 bg-white px-4 py-3 text-sm focus:outline-none focus:border-[var(--color-primary)] outline-none" />
                      <button type="submit" class="rounded-2xl bg-[var(--color-action)] px-6 py-3 text-sm font-semibold text-white transition-all duration-300 hover:-translate-y-0.5 hover:shadow-md">Send</button>
                    </div>
                  </form>
              @else
                  <div class="mt-4 text-center p-4 rounded-2xl border border-slate-200/70 bg-slate-50 text-slate-500 text-sm">
                      <i data-lucide="lock" class="h-4 w-4 inline-block mb-1 text-slate-400"></i><br>
                      This ticket is officially closed. Chat is disabled.
                  </div>
              @endif
            </div>                  
          </section>
        </main>
    </div>
</x-app-layout>