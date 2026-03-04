<x-app-layout title="Ticket Created" css='css/style-78.css'>
    <div class="flex-1">
        <header class="sticky top-0 z-20 border-b border-slate-200/70 bg-white/70 backdrop-blur-xl">
          <div class="flex flex-wrap items-center justify-between gap-4 px-6 py-4">
            <div>
              <div class="mb-2 flex items-center gap-3 lg:hidden">
                <img src="logo.png" alt="BiT Logo" class="h-10 w-auto" />
                <span class="text-sm font-semibold">Mela Support: BiT Edition</span>
              </div>
              <p class="text-xs uppercase tracking-[0.25em] text-slate-400">Campus Maintenance</p>
              <h1 class="text-2xl font-semibold">Ticket Created Successfully</h1>
            </div>
            <div class="flex items-center gap-3">
              <a class="rounded-2xl border border-slate-200 bg-white px-5 py-2 text-sm font-semibold text-slate-700 shadow-sm transition-all duration-300 hover:-translate-y-0.5 hover:shadow-md" href="{{ route('tickets.show', $ticket->id) }}">View Ticket</a>
            </div>
          </div>
        </header>

        <main class="px-6 py-10">
          <div class="mx-auto w-full max-w-6xl space-y-8">
            <section class="grid gap-6 lg:grid-cols-[1.1fr_0.9fr]">
              <div class="rounded-[2rem] border border-slate-200/70 bg-white/70 p-8 shadow-sm">
                <div class="flex items-start justify-between gap-4">
                  <div>
                    <p class="text-xs uppercase tracking-[0.25em] text-slate-400">Success</p>
                    <h2 class="mt-3 text-2xl font-semibold">Ticket {{ $ticket->tracking_id }} created</h2>
                    <p class="mt-2 text-sm text-slate-600">Your issue in <strong>{{ $ticket->building }}</strong> has been logged. Dispatch to the {{ $ticket->category->name }} team is underway.</p>
                  </div>
                </div>
                
                <div class="mt-6 grid gap-4 sm:grid-cols-3">
                  <div class="rounded-2xl border border-slate-200/70 bg-white/80 p-4">
                    <p class="text-xs uppercase tracking-[0.25em] text-slate-400">Technician</p>
                    <!-- 🚨 NOTICE: Changed from assignedAgent to assignedTechnician! -->
                    <p class="mt-2 text-sm font-semibold">{{ $ticket->assignedTechnician ? $ticket->assignedTechnician->name : 'Pending Assignment' }}</p>
                    <p class="text-xs text-slate-500">Campus Staff</p>
                  </div>
                  <div class="rounded-2xl border border-slate-200/70 bg-white/80 p-4">
                    <p class="text-xs uppercase tracking-[0.25em] text-slate-400">ETA</p>
                    <p class="mt-2 text-sm font-semibold">{{ $ticket->eta_timestamp ? $ticket->eta_timestamp->diffForHumans() : 'Calculating...' }}</p>
                    <p class="text-xs text-slate-500">Service Target</p>
                  </div>
                  <div class="rounded-2xl border border-slate-200/70 bg-white/80 p-4">
                    <p class="text-xs uppercase tracking-[0.25em] text-slate-400">Status</p>
                    <p class="mt-2 text-sm font-semibold capitalize">{{ str_replace('_', ' ', $ticket->status) }}</p>
                    <p class="text-xs text-slate-500">System tracking active</p>
                  </div>
                </div>
              </div>

              <div class="rounded-[2rem] border border-slate-200/70 bg-white/70 p-6 shadow-sm">
                <p class="text-xs uppercase tracking-[0.25em] text-slate-400">Dispatch Timeline</p>
                <h3 class="mt-3 text-xl font-semibold">What happens next?</h3>
                <div class="mt-6 space-y-4">
                  <div class="flex items-start gap-3 rounded-2xl border border-slate-200/70 bg-white/80 p-4">
                    <div class="mt-1 h-2.5 w-2.5 rounded-full bg-[var(--color-action)]"></div>
                    <div>
                      <p class="text-sm font-semibold">Technician Dispatched</p>
                      <p class="text-xs text-slate-500">Staff will arrive at {{ $ticket->building }} ({{ $ticket->floor }}).</p>
                    </div>
                  </div>
                  <div class="flex items-start gap-3 rounded-2xl border border-slate-200/70 bg-white/80 p-4">
                    <div class="mt-1 h-2.5 w-2.5 rounded-full bg-slate-300"></div>
                    <div>
                      <p class="text-sm font-semibold">Resolution Proof</p>
                      <p class="text-xs text-slate-500">The technician will upload a photo when the issue is fixed.</p>
                    </div>
                  </div>
                  <div class="flex items-start gap-3 rounded-2xl border border-slate-200/70 bg-white/80 p-4">
                    <div class="mt-1 h-2.5 w-2.5 rounded-full bg-slate-300"></div>
                    <div>
                      <p class="text-sm font-semibold">Your Confirmation</p>
                      <p class="text-xs text-slate-500">You must approve the work before the ticket is closed.</p>
                    </div>
                  </div>
                </div>
              </div>
            </section>

            <!-- Quick View Review (Read Only for now, to keep it simple!) -->
            <section class="rounded-[2rem] border border-slate-200/70 bg-white/70 p-8 shadow-sm">
              <div class="flex items-center justify-between gap-4 mb-6">
                <div>
                  <p class="text-xs uppercase tracking-[0.25em] text-slate-400">Review</p>
                  <h3 class="mt-2 text-xl font-semibold">Submitted Ticket Details</h3>
                </div>
              </div>
              
              <div class="grid gap-6 lg:grid-cols-2">
                <div class="space-y-4">
                  <div>
                    <label class="text-xs text-slate-500">Category</label>
                    <p class="font-medium">{{ $ticket->category->name }}</p>
                  </div>
                  <div>
                    <label class="text-xs text-slate-500">Subject</label>
                    <p class="font-medium">{{ $ticket->subject }}</p>
                  </div>
                  <div>
                    <label class="text-xs text-slate-500">Description</label>
                    <p class="text-sm mt-1">{{ $ticket->description }}</p>
                  </div>
                </div>
                
                <div class="space-y-4">
                  <div>
                    <label class="text-xs text-slate-500">Building / Block</label>
                    <p class="font-medium">{{ $ticket->building }}</p>
                  </div>
                  <div>
                    <label class="text-xs text-slate-500">Floor</label>
                    <p class="font-medium">{{ $ticket->floor }}</p>
                  </div>
                  <div>
                    <label class="text-xs text-slate-500">Exact Location</label>
                    <p class="font-medium">{{ $ticket->specific_location }}</p>
                  </div>
                </div>
              </div>
            </section>
          </div>
        </main>
    </div>
</x-app-layout>