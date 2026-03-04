{{-- <x-app-layout title="Admin Analytics" css='css/style-78.css'>
      <div class="flex-1">
        <header class="sticky top-0 z-20 border-b border-slate-200/70 bg-white/70 backdrop-blur-xl">
          <div class="flex flex-wrap items-center justify-between gap-4 px-6 py-4">
            <div>
              <div class="mb-2 flex items-center gap-3 lg:hidden">
                <img src="logo.png" alt="Mela Support Logo" class="h-10 w-auto" />
                <span class="text-sm font-semibold">Mela Support</span>
              </div>
              <p class="text-xs uppercase tracking-[0.25em] text-slate-400">Insights</p>
              <h1 class="text-2xl font-semibold">Admin Analytics</h1>
            </div>
            <div class="flex items-center gap-3">
              <button class="rounded-2xl bg-[var(--color-primary)] px-5 py-2 text-sm font-semibold text-white shadow-sm transition-all duration-300 hover:-translate-y-0.5 hover:shadow-md">Export Report</button>
              <button class="mobile-menu-btn lg:hidden rounded-2xl border border-slate-200/70 bg-white px-3 py-2 text-sm font-medium text-slate-700 shadow-sm transition-all duration-300 hover:-translate-y-0.5 hover:shadow-md">
                <i data-lucide="menu" class="h-4 w-4"></i>
              </button>
            </div>
          </div>
        </header>

        <main class="px-6 py-10">
          <div class="mx-auto w-full max-w-6xl space-y-8">
            <section class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
              <div class="rounded-[2rem] border border-slate-200/70 bg-white/70 p-6 shadow-sm">
                <p class="text-xs uppercase tracking-[0.25em] text-slate-400">Open Cases</p>
                <h2 class="mt-4 text-3xl font-semibold">312</h2>
                <p class="text-sm text-slate-500">Across 9 regions</p>
              </div>
              <div class="rounded-[2rem] border border-slate-200/70 bg-white/70 p-6 shadow-sm">
                <p class="text-xs uppercase tracking-[0.25em] text-slate-400">Resolved Today</p>
                <h2 class="mt-4 text-3xl font-semibold">78</h2>
                <p class="text-sm text-slate-500">Avg resolution 3.4 hrs</p>
              </div>
              <div class="rounded-[2rem] border border-slate-200/70 bg-white/70 p-6 shadow-sm">
                <p class="text-xs uppercase tracking-[0.25em] text-slate-400">SLA Risk</p>
                <h2 class="mt-4 text-3xl font-semibold">14</h2>
                <p class="text-sm text-slate-500">Cases nearing breach</p>
              </div>
            </section>

            <section class="grid gap-8 lg:grid-cols-2">
              <div class="rounded-[2rem] border border-slate-200/70 bg-white/70 p-6 shadow-sm">
                <div class="flex items-center justify-between">
                  <div>
                    <p class="text-xs uppercase tracking-[0.25em] text-slate-400">Daily Ticket Volume</p>
                    <h2 class="text-xl font-semibold">Last 7 days</h2>
                  </div>
                  <span class="rounded-full bg-[color:var(--color-action)]/15 px-3 py-1 text-xs font-semibold text-[var(--color-action)]">+18%</span>
                </div>
                <div class="mt-6 grid grid-cols-7 items-end gap-3">
                  <div class="h-16 rounded-2xl bg-[var(--color-primary)]/20"></div>
                  <div class="h-28 rounded-2xl bg-[var(--color-primary)]/30"></div>
                  <div class="h-20 rounded-2xl bg-[var(--color-primary)]/40"></div>
                  <div class="h-36 rounded-2xl bg-[var(--color-primary)]/60"></div>
                  <div class="h-32 rounded-2xl bg-[var(--color-primary)]/50"></div>
                  <div class="h-24 rounded-2xl bg-[var(--color-primary)]/35"></div>
                  <div class="h-18 rounded-2xl bg-[var(--color-primary)]/25"></div>
                </div>
                <div class="mt-4 flex justify-between text-xs text-slate-400">
                  <span>Mon</span>
                  <span>Tue</span>
                  <span>Wed</span>
                  <span>Thu</span>
                  <span>Fri</span>
                  <span>Sat</span>
                  <span>Sun</span>
                </div>
              </div>

              <div class="rounded-[2rem] border border-slate-200/70 bg-white/70 p-6 shadow-sm">
                <div class="flex items-center justify-between">
                  <div>
                    <p class="text-xs uppercase tracking-[0.25em] text-slate-400">Agent Performance</p>
                    <h2 class="text-xl font-semibold">Resolution index</h2>
                  </div>
                  <span class="rounded-full bg-[var(--color-primary)]/10 px-3 py-1 text-xs font-semibold text-[var(--color-primary)]">Top 5</span>
                </div>
                <div class="mt-6 space-y-4">
                  <div>
                    <div class="flex items-center justify-between text-sm">
                      <span>Selam Alemu</span>
                      <span>96%</span>
                    </div>
                    <div class="mt-2 h-2 rounded-full bg-slate-200">
                      <div class="h-2 rounded-full bg-[var(--color-action)]" style="width: 96%"></div>
                    </div>
                  </div>
                  <div>
                    <div class="flex items-center justify-between text-sm">
                      <span>Abebe Kebede</span>
                      <span>91%</span>
                    </div>
                    <div class="mt-2 h-2 rounded-full bg-slate-200">
                      <div class="h-2 rounded-full bg-[var(--color-action)]" style="width: 91%"></div>
                    </div>
                  </div>
                  <div>
                    <div class="flex items-center justify-between text-sm">
                      <span>Meron Fekadu</span>
                      <span>88%</span>
                    </div>
                    <div class="mt-2 h-2 rounded-full bg-slate-200">
                      <div class="h-2 rounded-full bg-[var(--color-action)]" style="width: 88%"></div>
                    </div>
                  </div>
                  <div>
                    <div class="flex items-center justify-between text-sm">
                      <span>Tesfaye Kassa</span>
                      <span>84%</span>
                    </div>
                    <div class="mt-2 h-2 rounded-full bg-slate-200">
                      <div class="h-2 rounded-full bg-[var(--color-action)]" style="width: 84%"></div>
                    </div>
                  </div>
                  <div>
                    <div class="flex items-center justify-between text-sm">
                      <span>Hanna Yilma</span>
                      <span>81%</span>
                    </div>
                    <div class="mt-2 h-2 rounded-full bg-slate-200">
                      <div class="h-2 rounded-full bg-[var(--color-action)]" style="width: 81%"></div>
                    </div>
                  </div>
                </div>
              </div>
            </section>

        <x-command-center />
      
          </div>
        </main>
      </div>
</x-app-layout> --}}
<x-app-layout title="Admin Analytics" css='css/style-78.css'>
      <div class="flex-1">
        <header class="sticky top-0 z-20 border-b border-slate-200/70 bg-white/70 backdrop-blur-xl">
          <div class="flex flex-wrap items-center justify-between gap-4 px-6 py-4">
            <div>
              <div class="mb-2 flex items-center gap-3 lg:hidden">
                <img src="{{ asset('logo.png') }}" alt="BiT Logo" class="h-10 w-auto" />
                <span class="text-sm font-semibold">Mela Support: BiT Edition</span>
              </div>
              <p class="text-xs uppercase tracking-[0.25em] text-slate-400">Insights</p>
              <h1 class="text-2xl font-semibold">Campus Admin Analytics</h1>
            </div>
            <div class="flex items-center gap-3">
              <button class="rounded-2xl bg-[var(--color-primary)] px-5 py-2 text-sm font-semibold text-white shadow-sm transition-all duration-300 hover:-translate-y-0.5 hover:shadow-md">Export Report</button>
              <button class="mobile-menu-btn lg:hidden rounded-2xl border border-slate-200/70 bg-white px-3 py-2 text-sm font-medium text-slate-700 shadow-sm transition-all duration-300 hover:-translate-y-0.5 hover:shadow-md">
                <i data-lucide="menu" class="h-4 w-4"></i>
              </button>
            </div>
          </div>
        </header>

        <main class="px-6 py-10">
          <div class="mx-auto w-full max-w-6xl space-y-8">
            
            <!-- REAL KPI ROW -->
            <section class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
              <div class="rounded-[2rem] border border-slate-200/70 bg-white/70 p-6 shadow-sm">
                <p class="text-xs uppercase tracking-[0.25em] text-slate-400">Open Cases</p>
                <h2 class="mt-4 text-3xl font-semibold">{{ $openCasesCount }}</h2>
                <p class="text-sm text-slate-500">Across campus buildings</p>
              </div>
              <div class="rounded-[2rem] border border-slate-200/70 bg-white/70 p-6 shadow-sm">
                <p class="text-xs uppercase tracking-[0.25em] text-slate-400">Resolved Today</p>
                <h2 class="mt-4 text-3xl font-semibold">{{ $resolvedTodayCount }}</h2>
                <p class="text-sm text-slate-500">System-wide resolutions</p>
              </div>
              <div class="rounded-[2rem] border border-slate-200/70 bg-white/70 p-6 shadow-sm">
                <p class="text-xs uppercase tracking-[0.25em] text-slate-400">SLA Risk</p>
                <h2 class="mt-4 text-3xl font-semibold text-red-500">{{ $slaRiskCount }}</h2>
                <p class="text-sm text-slate-500">Cases nearing breach</p>
              </div>
            </section>

            <section class="grid gap-8 lg:grid-cols-2">
              
              <!-- DYNAMIC 7-DAY BAR CHART -->
              <div class="rounded-[2rem] border border-slate-200/70 bg-white/70 p-6 shadow-sm flex flex-col justify-between">
                <div class="flex items-center justify-between">
                  <div>
                    <p class="text-xs uppercase tracking-[0.25em] text-slate-400">Daily Ticket Volume</p>
                    <h2 class="text-xl font-semibold">Last 7 days</h2>
                  </div>
                  <span class="rounded-full bg-[color:var(--color-action)]/15 px-3 py-1 text-xs font-semibold text-[var(--color-action)]">Live</span>
                </div>
                
                <div class="mt-6 grid grid-cols-7 items-end gap-3 h-40">
                  @foreach($volumeHeights as $index => $height)
                      <div class="group relative flex justify-center">
                          <!-- The Bar -->
                          <div class="w-full rounded-2xl bg-[var(--color-primary)]/40 hover:bg-[var(--color-primary)] transition-all" style="height: {{ max($height, 10) }}%;"></div>
                          <!-- Hover Tooltip -->
                          <span class="absolute -top-8 hidden rounded bg-slate-800 px-2 py-1 text-xs text-white group-hover:block">
                              {{ $dailyVolumes[$index] }} tickets
                          </span>
                      </div>
                  @endforeach
                </div>
                <div class="mt-4 flex justify-between text-xs text-slate-400">
                  @foreach($dayLabels as $label)
                      <span>{{ $label }}</span>
                  @endforeach
                </div>
              </div>

              <!-- DYNAMIC TECHNICIAN PERFORMANCE -->
              <div class="rounded-[2rem] border border-slate-200/70 bg-white/70 p-6 shadow-sm">
                <div class="flex items-center justify-between">
                  <div>
                    <p class="text-xs uppercase tracking-[0.25em] text-slate-400">Technician Performance</p>
                    <h2 class="text-xl font-semibold">Resolution index</h2>
                  </div>
                  <span class="rounded-full bg-[var(--color-primary)]/10 px-3 py-1 text-xs font-semibold text-[var(--color-primary)]">Top 5</span>
                </div>
                <div class="mt-6 space-y-4">
                  @forelse($topTechnicians as $tech)
                  <div>
                    <div class="flex items-center justify-between text-sm">
                      <span class="font-medium">{{ $tech->name }}</span>
                      <span class="text-slate-600">{{ $tech->resolution_rate }}% ({{ $tech->resolved_count }}/{{ $tech->total_count }})</span>
                    </div>
                    <div class="mt-2 h-2 rounded-full bg-slate-200">
                      <div class="h-2 rounded-full bg-[var(--color-action)]" style="width: {{ $tech->resolution_rate }}%"></div>
                    </div>
                  </div>
                  @empty
                  <div class="text-center text-sm text-slate-500 py-4">
                      No technicians have resolved tickets yet.
                  </div>
                  @endforelse
                </div>
              </div>
            </section>

        <!-- Command Center Include -->
        <x-command-center />
      
          </div>
        </main>
      </div>
</x-app-layout>