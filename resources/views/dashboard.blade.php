<x-app-layout title="Dashboard" css="css/style-78.css">
    <div class="flex-1">
        <!-- Header -->
        <header class="sticky top-0 z-20 border-b border-slate-200/70 bg-white/70 backdrop-blur-xl">
          <div class="flex flex-wrap items-center justify-between gap-4 px-6 py-4">
            <div>
              <div class="mb-2 flex items-center gap-3 lg:hidden">
                <img src="{{ asset('mela-logo.svg') }}"alt="BiT Logo" class="h-10 w-auto">
                <span class="text-sm font-semibold">Mela Support: BiT Edition</span>
              </div>
              <p class="text-xs uppercase tracking-[0.25em] text-slate-400">Overview</p>
              <h1 class="text-2xl font-semibold">
                  Welcome back, {{ auth()->user()->name }}
              </h1>
            </div>
            <div class="flex flex-wrap items-center gap-3">
              @if(auth()->user()->role === 'user')
                  <a href="{{ route('tickets.create') }}" class="rounded-2xl bg-[var(--color-action)] px-5 py-2 text-sm font-semibold text-white shadow-sm transition-all duration-300 hover:-translate-y-0.5 hover:shadow-md">New Report</a>
              @endif
              <button class="mobile-menu-btn lg:hidden rounded-2xl border border-slate-200/70 bg-white px-3 py-2 text-sm font-medium text-slate-700 shadow-sm transition-all duration-300 hover:-translate-y-0.5 hover:shadow-md">
                <i data-lucide="menu" class="h-4 w-4"></i>
              </button>
            </div>
          </div>
        </header>

        <main class="px-6 py-10">
          <div class="mx-auto w-full max-w-6xl space-y-8">
            
            <!-- 📊 6-STAGE PIPELINE METRICS (Perfectly spaced using grid-cols-6) -->
            <section class="grid gap-4 grid-cols-2 md:grid-cols-3 lg:grid-cols-6">
              
              <!-- TOTAL -->
              <div class="rounded-3xl border border-slate-200/70 bg-white/70 p-4 shadow-sm flex flex-col justify-between">
                <div>
                    <p class="text-[10px] font-bold uppercase tracking-[0.2em] text-slate-400">Total</p>
                    <h2 class="mt-1 text-2xl font-semibold">{{ $stats['total'] }}</h2>
                </div>
                <p class="mt-3 text-[10px] text-slate-500 leading-tight">
                    {{ auth()->user()->role === 'user' ? 'All cases you reported' : 'Your total workload' }}
                </p>
              </div>
              
              <!-- NEW / OPEN -->
              <div class="rounded-3xl border border-amber-200/70 bg-amber-50/50 p-4 shadow-sm flex flex-col justify-between">
                <div>
                    <p class="text-[10px] font-bold uppercase tracking-[0.2em] text-amber-600">New</p>
                    <h2 class="mt-1 text-2xl font-semibold text-amber-700">{{ $stats['open'] }}</h2>
                </div>
                <p class="mt-3 text-[10px] text-amber-600/80 leading-tight">Awaiting technician match</p>
              </div>
              
              <!-- ASSIGNED -->
              <div class="rounded-3xl border border-sky-200/70 bg-sky-50/50 p-4 shadow-sm flex flex-col justify-between">
                <div>
                    <p class="text-[10px] font-bold uppercase tracking-[0.2em] text-sky-600">Assigned</p>
                    <h2 class="mt-1 text-2xl font-semibold text-sky-700">{{ $stats['assigned'] }}</h2>
                </div>
                <p class="mt-3 text-[10px] text-sky-600/80 leading-tight">Technician notified & aware</p>
              </div>

              <!-- IN PROGRESS -->
              <div class="rounded-3xl border border-indigo-200/70 bg-indigo-50/50 p-4 shadow-sm flex flex-col justify-between">
                <div>
                    <p class="text-[10px] font-bold uppercase tracking-[0.2em] text-indigo-600">In Progress</p>
                    <h2 class="mt-1 text-2xl font-semibold text-indigo-700">{{ $stats['in_progress'] }}</h2>
                </div>
                <p class="mt-3 text-[10px] text-indigo-600/80 leading-tight">Staff is actively fixing it</p>
              </div>

              <!-- RESOLVED (Pending Verification) -->
              <div class="rounded-3xl border border-teal-200/70 bg-teal-50/50 p-4 shadow-sm flex flex-col justify-between">
                <div>
                    <p class="text-[10px] font-bold uppercase tracking-[0.2em] text-teal-600">Resolved</p>
                    <h2 class="mt-1 text-2xl font-semibold text-teal-700">{{ $stats['resolved'] }}</h2>
                </div>
                <p class="mt-3 text-[10px] text-teal-600/80 leading-tight">Fixed, waiting user approval</p>
              </div>

              <!-- CLOSED (Confirmed) -->
              <div class="rounded-3xl border border-emerald-200/70 bg-emerald-50/50 p-4 shadow-sm flex flex-col justify-between">
                <div>
                    <p class="text-[10px] font-bold uppercase tracking-[0.2em] text-emerald-600">Closed</p>
                    <h2 class="mt-1 text-2xl font-semibold text-emerald-700">{{ $stats['closed'] }}</h2>
                </div>
                <p class="mt-3 text-[10px] text-emerald-600/80 leading-tight">Verified and archived</p>
              </div>

            </section>

            <!-- DYNAMIC LAYOUT BASED ON ROLE -->
            <section class="grid gap-8 {{ auth()->user()->role === 'user' ? 'lg:grid-cols-1' : 'lg:grid-cols-[minmax(0,2fr)_minmax(0,1fr)]' }}">
              
              <!-- RECENT ACTIVITY LIST -->
              <div class="rounded-[2rem] border border-slate-200/70 bg-white/70 p-6 shadow-sm">
                <div class="flex items-center justify-between">
                  <div>
                    <p class="text-xs uppercase tracking-[0.25em] text-slate-400">Recent Activity</p>
                    <h3 class="text-xl font-semibold">Latest maintenance updates</h3>
                  </div>
                </div>
                
                <div class="mt-6 space-y-4">
                  @forelse($recentTickets as $ticket)
                      <div class="flex flex-wrap items-center justify-between gap-4 rounded-2xl border border-slate-200/70 bg-white/80 p-4 hover:shadow-md transition-shadow">
                        <div>
                          <a href="{{ route('tickets.show', $ticket->id) }}" class="text-sm font-semibold hover:text-indigo-600 transition">
                              {{ $ticket->tracking_id }} • {{ $ticket->category->name ?? 'Issue' }}
                          </a>
                          <p class="text-xs text-slate-500 mt-1">{{ $ticket->subject }} • {{ $ticket->building }} • Updated {{ $ticket->updated_at->diffForHumans() }}</p>
                        </div>
                        
                        <!-- Dynamic Status Badge Colors (Aligned with header boxes) -->
                        @php
                            $badgeColor = match($ticket->status) {
                                'closed' => 'bg-emerald-100 text-emerald-700',
                                'resolved' => 'bg-teal-100 text-teal-700',
                                'in_progress' => 'bg-indigo-100 text-indigo-700',
                                'assigned' => 'bg-sky-100 text-sky-700',
                                'open' => 'bg-amber-100 text-amber-700',
                                default => 'bg-slate-100 text-slate-700',
                            };
                        @endphp
                        <span class="rounded-full px-3 py-1 text-xs font-semibold {{ $badgeColor }} capitalize">
                            {{ str_replace('_', ' ', $ticket->status) }}
                        </span>
                      </div>
                  @empty
                      <div class="text-center py-8 text-slate-500 bg-slate-50/50 rounded-2xl">
                          <i data-lucide="inbox" class="mx-auto h-8 w-8 mb-2 opacity-40"></i>
                          <p class="text-sm">No recent activity found.</p>
                      </div>
                  @endforelse
                </div>
              </div>

              <!-- ONLY SHOW THESE DYNAMIC METRICS TO STAFF/ADMIN -->
              @if(auth()->user()->role !== 'user')
              <aside class="space-y-6">
                
                <!-- ⏱️ DYNAMIC SLA PULSE -->
                <div class="rounded-[2rem] border border-slate-200/70 bg-white/70 p-6 shadow-sm">
                  <p class="text-xs uppercase tracking-[0.25em] text-slate-400">SLA Pulse</p>
                  
                  @if($slaPercentage >= 90)
                      <h3 class="mt-3 text-xl font-semibold text-emerald-600">{{ $slaPercentage }}% on track</h3>
                  @elseif($slaPercentage >= 75)
                      <h3 class="mt-3 text-xl font-semibold text-amber-500">{{ $slaPercentage }}% on track</h3>
                  @else
                      <h3 class="mt-3 text-xl font-semibold text-red-500">{{ $slaPercentage }}% on track</h3>
                  @endif

                  <p class="mt-2 text-sm text-slate-500">
                      @if($nearingBreach > 0)
                          <span class="font-bold text-amber-600">{{ $nearingBreach }} cases</span> nearing breach in your scope.
                      @else
                          All active cases are well within their time limit.
                      @endif
                  </p>
                  <div class="mt-4 h-2 rounded-full bg-slate-100 overflow-hidden">
                    <div class="h-2 rounded-full {{ $slaPercentage >= 90 ? 'bg-emerald-500' : ($slaPercentage >= 75 ? 'bg-amber-500' : 'bg-red-500') }} transition-all duration-1000" style="width: {{ $slaPercentage }}%"></div>
                  </div>
                </div>
                
                <!-- 🚨 DYNAMIC PRIORITY MIX -->
                <div class="rounded-[2rem] border border-slate-200/70 bg-white/70 p-6 shadow-sm">
                  <p class="text-xs uppercase tracking-[0.25em] text-slate-400">Priority Mix</p>
                  <div class="mt-4 space-y-3 text-sm">
                    
                    @if($priorities['urgent'] > 0)
                    <div class="flex items-center justify-between pb-2 border-b border-slate-100">
                      <span class="font-medium">Urgent</span>
                      <span class="font-bold text-red-600 bg-red-100 px-2 py-0.5 rounded-md">{{ $priorities['urgent'] }}</span>
                    </div>
                    @endif

                    <div class="flex items-center justify-between pb-2 border-b border-slate-100">
                      <span class="text-slate-600">High</span>
                      <span class="font-semibold text-amber-600">{{ $priorities['high'] }}</span>
                    </div>
                    
                    <div class="flex items-center justify-between pb-2 border-b border-slate-100">
                      <span class="text-slate-600">Medium</span>
                      <span class="font-semibold text-[var(--color-primary)]">{{ $priorities['medium'] }}</span>
                    </div>
                    
                    <div class="flex items-center justify-between">
                      <span class="text-slate-600">Low</span>
                      <span class="font-semibold text-slate-400">{{ $priorities['low'] }}</span>
                    </div>
                  </div>
                </div>

              </aside>
              @endif

            </section>
          </div>
        </main>
    </div>
</x-app-layout>