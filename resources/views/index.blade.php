{{-- <x-app-layout title="Home Page" css='css/style-78.css'>
	<div class="flex-1">
	<header class="sticky top-0 z-20 border-b border-slate-200/70 bg-white/70 backdrop-blur-xl">
		<div class="flex flex-wrap items-center justify-between gap-4 px-6 py-4">
						<div>
			<div class="mb-2 flex items-center gap-3 lg:hidden">
			<img src="{{ asset('logo.png') }}" alt="Mela Support Logo" class="h-10 w-auto" />
			<span class="text-sm font-semibold">Mela Support</span>
			</div>              <p class="text-xs uppercase tracking-[0.25em] text-slate-400">Evidence-based support</p>
			<h1 class="text-2xl font-semibold">Every case, backed by trusted data</h1>
		</div>
		<div class="flex items-center gap-3">
			<button class="flex items-center gap-2 rounded-2xl border border-slate-200/70 bg-white px-4 py-2 text-sm font-medium text-slate-700 shadow-sm transition-all duration-300 hover:-translate-y-0.5 hover:shadow-md">
			<i data-lucide="globe" class="h-4 w-4"></i>
			Amharic
			</button>
			<button class="rounded-2xl bg-[var(--color-action)] px-5 py-2 text-sm font-semibold text-white shadow-sm transition-all duration-300 hover:-translate-y-0.5 hover:shadow-md">Request Demo</button>
		</div>
		
		<button class="mobile-menu-btn lg:hidden rounded-2xl border border-slate-200/70 bg-white px-3 py-2 text-sm font-medium text-slate-700 shadow-sm transition-all duration-300 hover:-translate-y-0.5 hover:shadow-md">
			<i data-lucide="menu" class="h-4 w-4"></i>
		</button>
		</div>
	</header>

	<main class="px-6 py-10">
		<section class="grid gap-10 lg:grid-cols-[1.2fr_0.8fr]">
		<div>
			<p class="inline-flex items-center gap-2 rounded-full bg-[var(--color-primary)]/10 px-4 py-2 text-xs font-semibold uppercase tracking-[0.2em] text-[var(--color-primary)]">
			<span class="h-2 w-2 rounded-full bg-[var(--color-action)]"></span>
			Digital Case Management
			</p>
			<h2 class="mt-6 text-4xl font-semibold leading-tight">Evidence-based support that unifies community service delivery across Ethiopia.</h2>
			<p class="mt-4 text-lg text-slate-600">Mela Support helps agencies prioritize urgent issues, coordinate technicians, and close cases with confidence. Built for ministries, utilities, and enterprise teams.</p>
			<div class="mt-8 flex flex-wrap gap-4">
			<button class="rounded-2xl bg-[var(--color-primary)] px-6 py-3 text-sm font-semibold text-white shadow-sm transition-all duration-300 hover:-translate-y-0.5 hover:shadow-md">Launch Live Demo</button>
			<button class="rounded-2xl border border-slate-200 bg-white px-6 py-3 text-sm font-semibold text-slate-700 shadow-sm transition-all duration-300 hover:-translate-y-0.5 hover:shadow-md">View Case Studies</button>
			</div>
			<div class="mt-10 grid gap-4 sm:grid-cols-3">
			<div class="rounded-2xl border border-slate-200/70 bg-white/70 p-4 shadow-sm">
				<p class="text-2xl font-semibold">96%</p>
				<p class="text-sm text-slate-500">SLA compliance</p>
			</div>
			<div class="rounded-2xl border border-slate-200/70 bg-white/70 p-4 shadow-sm">
				<p class="text-2xl font-semibold">1.2M</p>
				<p class="text-sm text-slate-500">Residents supported</p>
			</div>
			<div class="rounded-2xl border border-slate-200/70 bg-white/70 p-4 shadow-sm">
				<p class="text-2xl font-semibold">4.7x</p>
				<p class="text-sm text-slate-500">Faster resolution</p>
			</div>
			</div>
		</div>
		<div class="rounded-[2rem] border border-slate-200/60 bg-white/70 p-6 shadow-lg">
			<div class="flex items-center justify-between">
			<p class="text-sm font-semibold">Live Service Pulse</p>
			<span class="rounded-full bg-[color:var(--color-action)]/15 px-3 py-1 text-xs font-semibold text-[var(--color-action)]">Stable</span>
			</div>
			<div class="mt-6 space-y-4">
			<div class="rounded-2xl border border-slate-200/70 bg-white/80 p-4">
				<p class="text-xs uppercase tracking-[0.2em] text-slate-400">Priority</p>
				<p class="mt-2 text-lg font-semibold">Water Pipe Leak - Bole</p>
				<p class="text-sm text-slate-500">Assigned to Selam Alemu • ETA 40 mins</p>
			</div>
			<div class="rounded-2xl border border-slate-200/70 bg-white/80 p-4">
				<p class="text-xs uppercase tracking-[0.2em] text-slate-400">Priority</p>
				<p class="mt-2 text-lg font-semibold">ATM Failure - Piassa</p>
				<p class="text-sm text-slate-500">Escalated to Abebe Kebede • 3 updates</p>
			</div>
			<div class="rounded-2xl border border-slate-200/70 bg-white/80 p-4">
				<p class="text-xs uppercase tracking-[0.2em] text-slate-400">Priority</p>
				<p class="mt-2 text-lg font-semibold">Power Grid Outage - Saris</p>
				<p class="text-sm text-slate-500">Technician dispatched • 2 hours ago</p>
			</div>
			</div>
		</div>
		</section>

		<section class="mt-16">
		<div class="flex items-center justify-between">
			<h3 class="text-2xl font-semibold">How it works</h3>
			<button class="rounded-2xl border border-slate-200 bg-white px-5 py-2 text-sm font-semibold text-slate-700 shadow-sm transition-all duration-300 hover:-translate-y-0.5 hover:shadow-md">View Process</button>
		</div>
		<div class="mt-6 grid gap-6 lg:grid-cols-3">
			<div class="rounded-[2rem] border border-slate-200/70 bg-white/70 p-6 shadow-sm">
			<p class="text-xs uppercase tracking-[0.25em] text-slate-400">Step 01</p>
			<h4 class="mt-4 text-lg font-semibold">Capture Evidence</h4>
			<p class="mt-2 text-sm text-slate-600">Frontline teams submit cases with location data, attachments, and clear categorization.</p>
			</div>
			<div class="rounded-[2rem] border border-slate-200/70 bg-white/70 p-6 shadow-sm">
			<p class="text-xs uppercase tracking-[0.25em] text-slate-400">Step 02</p>
			<h4 class="mt-4 text-lg font-semibold">Route Intelligently</h4>
			<p class="mt-2 text-sm text-slate-600">Mela Support matches cases with agents and technicians based on skill, district, and workload.</p>
			</div>
			<div class="rounded-[2rem] border border-slate-200/70 bg-white/70 p-6 shadow-sm">
			<p class="text-xs uppercase tracking-[0.25em] text-slate-400">Step 03</p>
			<h4 class="mt-4 text-lg font-semibold">Resolve with Trust</h4>
			<p class="mt-2 text-sm text-slate-600">Unified timelines, secure chat, and metrics ensure every case is closed responsibly.</p>
			</div>
		</div>
		</section>

		<footer class="mt-16 rounded-[2rem] border border-slate-200/70 bg-white/70 p-6 shadow-sm">
		<div class="flex flex-wrap items-center justify-between gap-4">
			<div>
			<p class="text-sm font-semibold">Mela Support</p>
			<p class="text-xs text-slate-500">Serving federal agencies, utilities, and national enterprises.</p>
			</div>
			<div class="flex gap-4 text-sm text-slate-500">
			<span>Privacy</span>
			<span>Security</span>
			<span>Contact</span>
			</div>
		</div>
		</footer>
	</main>
	</div>
</x-app-layout> --}}

<x-app-layout title="BiT Campus Support" css='css/style-78.css'>
	<div class="flex-1">
	<header class="sticky top-0 z-20 border-b border-slate-200/70 bg-white/70 backdrop-blur-xl">
		<div class="flex flex-wrap items-center justify-between gap-4 px-6 py-4">
		    <div>
			<div class="mb-2 flex items-center gap-3 lg:hidden">
			<img src="{{ asset('logo.png') }}" alt="BiT Logo" class="h-10 w-auto" />
			<span class="text-sm font-semibold">Mela Support: BiT</span>
			</div>              
            <p class="text-xs uppercase tracking-[0.25em] text-slate-400">Smart Campus Management</p>
			<h1 class="text-2xl font-semibold">Bahir Dar Institute of Technology</h1>
		</div>
		<div class="flex items-center gap-3">
            @guest
                <a href="{{ route('login') }}" class="flex items-center gap-2 rounded-2xl border border-slate-200/70 bg-white px-5 py-2 text-sm font-medium text-slate-700 shadow-sm transition-all duration-300 hover:-translate-y-0.5 hover:shadow-md">
                    Log in
                </a>
                <a href="{{ route('register') }}" class="rounded-2xl bg-[var(--color-action)] px-5 py-2 text-sm font-semibold text-white shadow-sm transition-all duration-300 hover:-translate-y-0.5 hover:shadow-md">
                    Register
                </a>
            @endguest
            @auth
                <a href="{{ route('dashboard') }}" class="rounded-2xl bg-[var(--color-primary)] px-5 py-2 text-sm font-semibold text-white shadow-sm transition-all duration-300 hover:-translate-y-0.5 hover:shadow-md">
                    Go to Dashboard
                </a>
            @endauth
		</div>
		
		<button class="mobile-menu-btn lg:hidden rounded-2xl border border-slate-200/70 bg-white px-3 py-2 text-sm font-medium text-slate-700 shadow-sm transition-all duration-300 hover:-translate-y-0.5 hover:shadow-md">
			<i data-lucide="menu" class="h-4 w-4"></i>
		</button>
		</div>
	</header>

	<main class="px-6 py-10">
		<section class="grid gap-10 lg:grid-cols-[1.2fr_0.8fr]">
		<div>
			<p class="inline-flex items-center gap-2 rounded-full bg-[var(--color-primary)]/10 px-4 py-2 text-xs font-semibold uppercase tracking-[0.2em] text-[var(--color-primary)]">
			<span class="h-2 w-2 rounded-full bg-[var(--color-action)]"></span>
			Facility Management System
			</p>
			<h2 class="mt-6 text-4xl font-semibold leading-tight">Evidence-based maintenance that keeps the BiT Campus running flawlessly.</h2>
			<p class="mt-4 text-lg text-slate-600">Mela Support empowers students and staff to report broken facilities, intelligently routes the issue to the correct campus technician, and ensures dorms, labs, and classrooms are fixed fast.</p>
			<div class="mt-8 flex flex-wrap gap-4">
                @auth
                    <a href="{{ route('tickets.create') }}" class="rounded-2xl bg-[var(--color-primary)] px-6 py-3 text-sm font-semibold text-white shadow-sm transition-all duration-300 hover:-translate-y-0.5 hover:shadow-md">Report an Issue</a>
                @else
                    <a href="{{ route('register') }}" class="rounded-2xl bg-[var(--color-primary)] px-6 py-3 text-sm font-semibold text-white shadow-sm transition-all duration-300 hover:-translate-y-0.5 hover:shadow-md">Join Campus Network</a>
                @endauth
			    <a href="#how-it-works" class="rounded-2xl border border-slate-200 bg-white px-6 py-3 text-sm font-semibold text-slate-700 shadow-sm transition-all duration-300 hover:-translate-y-0.5 hover:shadow-md">See How it Works</a>
			</div>
			<div class="mt-10 grid gap-4 sm:grid-cols-3">
			<div class="rounded-2xl border border-slate-200/70 bg-white/70 p-4 shadow-sm">
				<p class="text-2xl font-semibold">98%</p>
				<p class="text-sm text-slate-500">SLA compliance</p>
			</div>
			<div class="rounded-2xl border border-slate-200/70 bg-white/70 p-4 shadow-sm">
				<p class="text-2xl font-semibold">15,000+</p>
				<p class="text-sm text-slate-500">Students Supported</p>
			</div>
			<div class="rounded-2xl border border-slate-200/70 bg-white/70 p-4 shadow-sm">
				<p class="text-2xl font-semibold">3.5x</p>
				<p class="text-sm text-slate-500">Faster resolution</p>
			</div>
			</div>
		</div>

		<div class="rounded-[2rem] border border-slate-200/60 bg-white/70 p-6 shadow-lg">
			<div class="flex items-center justify-between">
			    <p class="text-sm font-semibold">Live Campus Pulse</p>
			    <span class="rounded-full bg-[color:var(--color-action)]/15 px-3 py-1 text-xs font-semibold text-[var(--color-action)]">Active</span>
			</div>
			
			<div class="mt-6 space-y-4">
                {{-- 🧠 THE BRAIN: Fetch the 3 most recent tickets that are NOT closed --}}
                @php
                    $pulseTickets = \App\Models\Ticket::with('assignedTechnician')
                        ->where('status', '!=', 'closed')
                        ->latest()
                        ->take(3)
                        ->get();
                @endphp

                @forelse($pulseTickets as $ticket)
                    <div class="rounded-2xl border border-slate-200/70 bg-white/80 p-4 transition-all hover:bg-white hover:shadow-sm">
                        
                        {{-- Priority Color Logic --}}
                        @if($ticket->priority === 'urgent' || $ticket->priority === 'high')
                            <p class="text-xs uppercase tracking-[0.2em] text-[var(--color-urgent)] font-bold">
                                {{ ucfirst($ticket->priority) }} Priority
                            </p>
                        @else
                            <p class="text-xs uppercase tracking-[0.2em] text-slate-400 font-bold">
                                {{ ucfirst($ticket->priority) }} Priority
                            </p>
                        @endif

                        {{-- Ticket Subject and Building --}}
                        <p class="mt-2 text-lg font-semibold truncate" title="{{ $ticket->subject }}">
                            {{ $ticket->subject }} - {{ $ticket->building }}
                        </p>
                        
                        {{-- Assignment and Status --}}
                        <p class="text-sm text-slate-500">
                            @if($ticket->assignedTechnician)
                                Assigned to {{ $ticket->assignedTechnician->name }}
                            @else
                                <span class="text-amber-600 font-medium">Pending Assignment</span>
                            @endif 
                            • 
                            <span class="capitalize">{{ str_replace('_', ' ', $ticket->status) }}</span>
                        </p>
                    </div>
                @empty
                    {{-- Empty State (When the campus is perfectly fine) --}}
                    <div class="rounded-2xl border border-dashed border-slate-300 bg-slate-50/50 p-6 text-center">
                        <i data-lucide="check-circle" class="mx-auto h-6 w-6 text-emerald-500 opacity-50 mb-2"></i>
                        <p class="text-sm font-medium text-slate-500">All quiet on campus!</p>
                        <p class="text-xs text-slate-400">No active issues at the moment.</p>
                    </div>
                @endforelse
			</div>
		</div>
		</section>

		<section id="how-it-works" class="mt-16 pt-8 border-t border-slate-200/50">
		<div class="flex items-center justify-between">
			<h3 class="text-2xl font-semibold">How the System Works</h3>
		</div>
		<div class="mt-6 grid gap-6 lg:grid-cols-3">
			<div class="rounded-[2rem] border border-slate-200/70 bg-white/70 p-6 shadow-sm hover:shadow-md transition-all">
			<div class="h-10 w-10 bg-indigo-100 text-indigo-600 rounded-xl flex items-center justify-center font-bold mb-4">1</div>
			<h4 class="text-lg font-semibold">Capture Evidence</h4>
			<p class="mt-2 text-sm text-slate-600">Students and staff submit maintenance requests specifying the exact building, floor, and a photo of the broken facility.</p>
			</div>
			<div class="rounded-[2rem] border border-slate-200/70 bg-white/70 p-6 shadow-sm hover:shadow-md transition-all">
			<div class="h-10 w-10 bg-indigo-100 text-indigo-600 rounded-xl flex items-center justify-center font-bold mb-4">2</div>
			<h4 class="text-lg font-semibold">Intelligent Dispatch</h4>
			<p class="mt-2 text-sm text-slate-600">Our Robot Dispatcher automatically matches the ticket with the exact campus technician responsible for that specific dorm or block.</p>
			</div>
			<div class="rounded-[2rem] border border-slate-200/70 bg-white/70 p-6 shadow-sm hover:shadow-md transition-all">
			<div class="h-10 w-10 bg-indigo-100 text-indigo-600 rounded-xl flex items-center justify-center font-bold mb-4">3</div>
			<h4 class="text-lg font-semibold">Resolve & Verify</h4>
			<p class="mt-2 text-sm text-slate-600">Technicians upload a photo when the job is done, and the student verifies the fix via live chat before the ticket is officially closed.</p>
			</div>
		</div>
		</section>

		<footer class="mt-16 rounded-[2rem] border border-slate-200/70 bg-white/70 p-6 shadow-sm">
		<div class="flex flex-wrap items-center justify-between gap-4">
			<div>
			<p class="text-sm font-semibold">Mela Support: BiT Edition</p>
			<p class="text-xs text-slate-500">Engineered for Bahir Dar Institute of Technology.</p>
			</div>
			<div class="flex gap-4 text-sm text-slate-500">
			<a href="#" class="hover:text-indigo-600">Privacy Policy</a>
			<a href="#" class="hover:text-indigo-600">Campus IT Guidelines</a>
			<a href="#" class="hover:text-indigo-600">Contact Facility Manager</a>
			</div>
		</div>
		</footer>
	</main>
	</div>
</x-app-layout>