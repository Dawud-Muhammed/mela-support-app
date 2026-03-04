<x-app-layout title="User Management" css="css/style-78.css">
    <div class="flex-1">
        <header class="sticky top-0 z-20 border-b border-slate-200/70 bg-white/70 backdrop-blur-xl">
          <div class="flex flex-wrap items-center justify-between gap-4 px-6 py-4">
            <div>
              <p class="text-xs uppercase tracking-[0.25em] text-slate-400">Security Center</p>
              <h1 class="text-2xl font-semibold">Campus User Management</h1>
            </div>
          </div>
        </header>

        @if (session('success'))
        <div class="px-6 pt-6">
          <div class="mx-auto w-full max-w-5xl">
            <div id="success-toast" class="flex items-start gap-3 rounded-[1.5rem] border border-emerald-300/50 bg-emerald-50/40 p-4 text-emerald-950 shadow-sm backdrop-blur-md">
              <div class="mt-0.5 rounded-full bg-emerald-500/10 p-2">
                <i data-lucide="check-circle" class="h-5 w-5 text-emerald-600"></i>
              </div>
              <div class="flex-1">
                <p class="text-sm font-semibold uppercase tracking-[0.18em] text-emerald-700">System Update</p>
                <p class="mt-1 text-sm text-emerald-900">{{ session('success') }}</p>
              </div>
            </div>
          </div>
        </div>
        @endif

        <main class="px-6 py-10">
          <div class="mx-auto w-full max-w-5xl space-y-8">

            <div class="rounded-[2rem] border border-slate-200/70 bg-white/70 shadow-sm overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full text-left text-sm text-slate-600">
                        <thead class="bg-slate-50/50 text-xs uppercase tracking-[0.15em] text-slate-500 border-b border-slate-200/70">
                            <tr>
                                <th class="px-6 py-4 font-semibold">User Data</th>
                                <th class="px-6 py-4 font-semibold">Role</th>
                                <th class="px-6 py-4 font-semibold">Status</th>
                                <th class="px-6 py-4 font-semibold text-right">Admin Action</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @foreach($users as $user)
                            <tr class="hover:bg-slate-50/30 transition-colors">
                                <td class="px-6 py-4">
                                    <p class="font-semibold text-slate-800">{{ $user->name }}</p>
                                    <p class="text-xs text-slate-500">{{ $user->email }}</p>
                                </td>
                                <td class="px-6 py-4 capitalize font-medium {{ $user->role === 'technician' ? 'text-[var(--color-primary)]' : 'text-slate-500' }}">
                                    {{ $user->role }}
                                </td>
                                <td class="px-6 py-4">
                                    @if($user->is_banned)
                                        <span class="inline-flex items-center gap-1.5 rounded-full bg-red-100 px-3 py-1 text-xs font-semibold text-red-700">
                                            <i data-lucide="shield-alert" class="h-3 w-3"></i> Suspended
                                        </span>
                                    @else
                                        <span class="inline-flex items-center gap-1.5 rounded-full bg-emerald-100 px-3 py-1 text-xs font-semibold text-emerald-700">
                                            <i data-lucide="shield-check" class="h-3 w-3"></i> Active
                                        </span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <form action="{{ route('admin.users.toggle_ban', $user->id) }}" method="POST" class="inline-block">
                                        @csrf
                                        @method('PATCH')
                                        @if($user->is_banned)
                                            <button type="submit" class="rounded-xl border-2 border-emerald-200 bg-white px-4 py-2 text-xs font-semibold text-emerald-600 shadow-sm transition-all duration-300 hover:bg-emerald-50 hover:-translate-y-0.5">
                                                Restore Access
                                            </button>
                                        @else
                                            <button type="submit" onclick="return confirm('Are you sure you want to suspend this user? They will be logged out immediately.')" class="rounded-xl border border-transparent bg-red-500 px-4 py-2 text-xs font-semibold text-white shadow-sm transition-all duration-300 hover:bg-red-600 hover:-translate-y-0.5 hover:shadow-md">
                                                Suspend User
                                            </button>
                                        @endif
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

          </div>
        </main>
    </div>
</x-app-layout>