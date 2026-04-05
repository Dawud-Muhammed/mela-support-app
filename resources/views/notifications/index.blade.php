<x-app-layout title="All Notifications">
    <main class="flex-1 p-4 lg:p-8">
        <div class="mx-auto max-w-4xl space-y-6">
            
            <!-- Header -->
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-2xl font-bold text-slate-900">Notifications</h1>
                    <p class="text-sm text-slate-500">Your complete history of system alerts and ticket updates.</p>
                </div>
            </div>

            <!-- Notifications List -->
            <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">
                @forelse($notifications as $notification)
                    <a href="{{ route('notifications.redirect', $notification->id) }}" 
                       class="flex items-start gap-4 border-b border-slate-100 p-5 transition hover:bg-slate-50 {{ is_null($notification->read_at) ? 'bg-indigo-50/30' : '' }}">
                        
                        @php
                            $type = $notification->data['type'] ?? 'info';
                            $colorClass = match($type) {
                                'auto-assigned' => 'bg-[#0b285c] text-[#fcd116]', 
                                'resolved'      => 'bg-[#078930] text-white',     
                                'thread-reply'  => 'bg-[#fcd116] text-slate-900', 
                                'closed'        => 'bg-[#da1244] text-white',     
                                'rejected'      => 'bg-[#da121a] text-white', // <-- ADD THIS LINE!
                                default         => 'bg-[#0b285c] text-white'
                            };
                        @endphp
                        <!-- THE PROUD CIRCLE (Larger for the main page) -->
                        <div class="mt-1 flex h-12 w-12 shrink-0 items-center justify-center rounded-full {{ $colorClass }} shadow-md border-2 border-white">
                            <i data-lucide="{{ $notification->data['icon'] ?? 'info' }}" class="h-6 w-6 stroke-[2.5px]"></i>
                        </div>

                        <!-- Content -->
                        <div class="flex-1">
                            <div class="flex items-center justify-between">
                                <p class="text-sm font-semibold {{ is_null($notification->read_at) ? 'text-slate-900' : 'text-slate-700' }}">
                                    {{ $notification->data['title'] ?? 'System Notification' }}
                                </p>
                                <span class="text-xs text-slate-400">{{ $notification->created_at->format('M d, Y h:i A') }}</span>
                            </div>
                            <p class="mt-1 text-sm text-slate-500">{{ $notification->data['message'] ?? '' }}</p>
                        </div>

                        <!-- Unread Dot Indicator -->
                        @if(is_null($notification->read_at))
                            <div class="mt-3 h-2.5 w-2.5 rounded-full bg-[#da121a] shadow-sm"></div>
                        @endif
                    </a>
                @empty
                    <div class="p-12 text-center">
                        <i data-lucide="bell-off" class="mx-auto mb-3 h-12 w-12 text-slate-300"></i>
                        <p class="text-lg font-medium text-slate-900">You're all caught up!</p>
                        <p class="text-sm text-slate-500">You don't have any notifications yet.</p>
                    </div>
                @endforelse
            </div>

            <!-- Pagination -->
            <div class="mt-6">
                {{ $notifications->links() }}
            </div>

        </div>
    </main>
</x-app-layout>