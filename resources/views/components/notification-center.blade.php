@auth
<div class="relative ml-auto" x-data="{ open: false }">
    <!-- Bell Button -->
    <button @click="open = !open" @click.away="open = false" class="relative flex h-10 w-10 items-center justify-center rounded-2xl border border-white/15 bg-white/10 text-indigo-100 transition hover:bg-indigo-800">
        <i data-lucide="bell" class="h-5 w-5"></i>
        
        <!-- Unread Badge -->
        @if(auth()->user()->unreadNotifications->count() > 0)
            <span class="absolute -right-1 -top-1 flex h-4 w-4 items-center justify-center rounded-full bg-red-500 text-[10px] font-bold text-white shadow-sm">
                {{ auth()->user()->unreadNotifications->count() }}
            </span>
        @endif
    </button>

    <!-- Dropdown Panel -->
    <div x-show="open" style="display: none;" 
         class="fixed left-6 top-20 z-[9999] w-80 rounded-2xl bg-white shadow-2xl ring-1 ring-black/5 focus:outline-none lg:left-[270px] lg:top-6 lg:ml-4 lg:origin-top-left overflow-hidden"
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0 scale-95"
         x-transition:enter-end="opacity-100 scale-100"
         x-transition:leave="transition ease-in duration-75"
         x-transition:leave-start="opacity-100 scale-100"
         x-transition:leave-end="opacity-0 scale-95">
         
        <div class="flex items-center justify-between border-b border-slate-100 px-4 py-3 bg-slate-50/50">
            <h3 class="text-sm font-semibold text-slate-800">Notifications</h3>
            
            @if(auth()->user()->unreadNotifications->count() > 0)
            <!-- Mark Read Button -->
            <button @click="
                        fetch('/notifications/mark-read', {
                            method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').content,
                                'Accept': 'application/json'
                            }
                        }).then(() => {
                            $el.closest('.relative').querySelector('.bg-red-500')?.remove();
                            document.querySelector('#notification-list').innerHTML = '<div class=\'px-4 py-8 text-center text-sm text-slate-500\'><i data-lucide=\'check-circle-2\' class=\'h-8 w-8 mx-auto mb-2 text-slate-300\'></i>All caught up!</div>';
                            lucide.createIcons();
                        });
                    " 
                    class="text-[10px] font-semibold uppercase tracking-wider text-indigo-600 hover:text-indigo-800 transition">
                Mark all read
            </button>
            @endif
        </div>

        <div id="notification-list" class="max-h-[320px] overflow-y-auto">
            @forelse(auth()->user()->notifications()->take(5)->get() as $notification)
                @php
                    $type = $notification->data['type'] ?? 'info';
                    $colorClass = match($type) {
                        'auto-assigned' => 'bg-[#0b285c] text-[#fcd116]', // BiT Blue & Gold
                        'resolved'      => 'bg-[#078930] text-white',     // Ethiopian Green
                        'thread-reply'  => 'bg-[#fcd116] text-slate-900', // Ethiopian Yellow
                        'closed'        => 'bg-[#da121a] text-white',     // Ethiopian Red
                        'rejected'      => 'bg-[#da121a] text-white',     // Ethiopian Red (Urgent)
                        default         => 'bg-[#0b285c] text-white'      // BiT Default
                    };
                    $isUnread = is_null($notification->read_at); // THIS IS THE LINE THAT WAS MISSING!
                @endphp

                <a href="{{ route('notifications.redirect', $notification->id) }}" 
                   class="flex items-start gap-3 border-b border-slate-50 px-4 py-3 transition {{ $isUnread ? 'bg-indigo-50/50 hover:bg-indigo-50' : 'hover:bg-slate-50' }}">
                    
                    <!-- THE PROUD CIRCLE -->
                    <div class="mt-0.5 flex h-9 w-9 shrink-0 items-center justify-center rounded-full {{ $colorClass }} shadow-md border border-white/20">
                        <i data-lucide="{{ $notification->data['icon'] ?? 'info' }}" class="h-4 w-4 stroke-[2.5px]"></i>
                    </div>

                    <div class="flex-1 space-y-1">
                        <p class="text-sm {{ $isUnread ? 'font-bold text-slate-900' : 'font-medium text-slate-700' }}">
                            {{ $notification->data['title'] ?? 'Notification' }}
                        </p>
                        <p class="text-xs {{ $isUnread ? 'text-slate-600' : 'text-slate-500' }} line-clamp-2">
                            {{ $notification->data['message'] ?? '' }}
                        </p>
                        <p class="text-[10px] font-medium text-slate-400">{{ $notification->created_at->diffForHumans() }}</p>
                    </div>
                    
                    @if($isUnread)
                        <div class="mt-2 h-2 w-2 shrink-0 rounded-full bg-[#da121a] shadow-[0_0_5px_rgba(218,18,26,0.6)]"></div>
                    @endif
                </a>
            @empty
                <div class="px-4 py-8 text-center text-sm text-slate-500">
                    <i data-lucide="bell-off" class="h-8 w-8 mx-auto mb-2 text-slate-300"></i>
                    No notifications yet.
                </div>
            @endforelse
        </div>

        <!-- The View All Portal -->
        <div class="border-t border-slate-100 bg-slate-50 p-2">
            <a href="{{ route('notifications.index') }}" class="block rounded-lg py-2 text-center text-xs font-semibold text-slate-600 hover:bg-slate-200 hover:text-slate-900 transition">
                View All Notifications
            </a>
        </div>
    </div>
</div>
@endauth