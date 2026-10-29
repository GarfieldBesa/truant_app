@php
    $activeNav = $active ?? (
        request()->routeIs('court-booking.*') ? 'book-a-court' :
        (request()->routeIs('customer.bookings') ? 'my-registrations' :
        (request()->is('admin*') ? 'admin' : 'events'))
    );
@endphp

<!-- ═══ 1. DESKTOP FOOTER (hidden on mobile, lg:block) ═══ -->
<footer class="hidden lg:block w-full bg-surface-container-low mt-16 border-t border-outline-variant/20">
    <div class="max-w-7xl mx-auto px-6 lg:px-12 py-12">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-8 mb-12">
            <div class="md:col-span-1">
                <div class="flex items-center gap-2.5 mb-3">
                    <div class="w-7 h-7 rounded-lg bg-primary flex items-center justify-center text-on-primary shadow-sm">
                        <span class="material-symbols-outlined text-[16px]">bolt</span>
                    </div>
                    <span class="font-headline-sm text-headline-sm text-on-surface">Truant</span>
                </div>
                <p class="font-body-sm text-body-sm text-on-surface-variant max-w-xs leading-relaxed">
                    Executive enterprise event coordination and corporate sports facility management.
                </p>
            </div>
            <div>
                <h4 class="font-label-md text-label-md uppercase tracking-wider text-on-surface mb-3.5 font-bold">Platform</h4>
                <ul class="space-y-2 font-body-sm text-body-sm">
                    <li><a class="hover:text-on-surface text-on-surface-variant transition-colors" href="{{ url('/') }}">Corporate Summits &amp; Events</a></li>
                    <li><a class="hover:text-on-surface text-on-surface-variant transition-colors" href="{{ route('court-booking.index') }}">Court Scheduling</a></li>
                    <li><a class="hover:text-on-surface text-on-surface-variant transition-colors" href="{{ route('customer.bookings') }}">Team Tournaments &amp; Registrations</a></li>
                    <li><a class="hover:text-on-surface text-on-surface-variant transition-colors" href="{{ url('/admin/login') }}">Administrator Portal</a></li>
                </ul>
            </div>
            <div>
                <h4 class="font-label-md text-label-md uppercase tracking-wider text-on-surface mb-3.5 font-bold">Enterprise</h4>
                <ul class="space-y-2 font-body-sm text-body-sm">
                    <li><a class="hover:text-on-surface text-on-surface-variant transition-colors" href="#">Security &amp; Compliance</a></li>
                    <li><a class="hover:text-on-surface text-on-surface-variant transition-colors" href="#">SSO Integration</a></li>
                    <li><a class="hover:text-on-surface text-on-surface-variant transition-colors" href="#">Facility Partners</a></li>
                    <li><a class="hover:text-on-surface text-on-surface-variant transition-colors" href="#">Corporate Billing</a></li>
                </ul>
            </div>
            <div>
                <h4 class="font-label-md text-label-md uppercase tracking-wider text-on-surface mb-3.5 font-bold">Legal &amp; Privacy</h4>
                <ul class="space-y-2 font-body-sm text-body-sm">
                    <li><a class="hover:text-on-surface text-on-surface-variant transition-colors" href="#">Terms of Service</a></li>
                    <li><a class="hover:text-on-surface text-on-surface-variant transition-colors" href="#">Privacy Notice</a></li>
                    <li><a class="hover:text-on-surface text-on-surface-variant transition-colors" href="#">Court Rules &amp; Policy</a></li>
                    <li><a class="hover:text-on-surface text-on-surface-variant transition-colors" href="#">Support Center</a></li>
                </ul>
            </div>
        </div>
        <div class="pt-8 flex flex-col sm:flex-row items-center justify-between gap-4 border-t border-outline-variant/20">
            <p class="font-body-sm text-body-sm text-on-surface-variant">&copy; {{ date('Y') }} Truant Enterprises Inc. All rights reserved.</p>
            <div class="flex items-center gap-6 font-body-sm text-body-sm text-on-surface-variant">
                <a class="hover:text-on-surface transition-colors" href="#">System Status</a>
                <a class="hover:text-on-surface transition-colors" href="#">API Docs</a>
                <a class="hover:text-on-surface transition-colors" href="#">Contact Concierge</a>
            </div>
        </div>
    </div>
</footer>

<!-- ═══ 2. MOBILE BOTTOM NAVIGATION TAB BAR (Fixed bottom-0 with pb-safe, lg:hidden) ═══ -->
<nav class="lg:hidden fixed bottom-0 w-full z-50 pb-safe bg-surface/85 backdrop-blur-xl shadow-[0_-2px_12px_rgba(19,27,46,0.05)] border-t border-outline-variant/20" data-active-classes="text-primary font-label-md">
    <div class="h-16 px-space-xs flex items-center justify-around">
        <!-- Events Tab -->
        <a class="flex flex-col items-center justify-center min-w-[64px] min-h-[44px] py-1 px-2 rounded-xl transition-colors {{ $activeNav === 'events' ? 'text-primary font-label-md font-bold' : 'text-on-surface-variant hover:text-on-surface font-label-sm text-label-sm' }}" data-path="events" href="{{ url('/') }}" {!! $activeNav === 'events' ? 'aria-current="page"' : '' !!}>
            <span class="material-symbols-outlined text-[24px]">event</span>
            <span class="font-label-sm text-label-sm mt-0.5">Events</span>
        </a>

        <!-- Book a Court Tab -->
        <a class="flex flex-col items-center justify-center min-w-[64px] min-h-[44px] py-1 px-2 rounded-xl transition-colors {{ $activeNav === 'book-a-court' ? 'text-primary font-label-md font-bold' : 'text-on-surface-variant hover:text-on-surface font-label-sm text-label-sm' }}" data-path="book-a-court" href="{{ route('court-booking.index') }}" {!! $activeNav === 'book-a-court' ? 'aria-current="page"' : '' !!}>
            <span class="material-symbols-outlined text-[24px]">sports_tennis</span>
            <span class="font-label-sm text-label-sm mt-0.5">Book a Court</span>
        </a>

        <!-- My Registrations Tab -->
        <a class="flex flex-col items-center justify-center min-w-[64px] min-h-[44px] py-1 px-2 rounded-xl transition-colors {{ $activeNav === 'my-registrations' ? 'text-primary font-label-md font-bold' : 'text-on-surface-variant hover:text-on-surface font-label-sm text-label-sm' }}" data-path="my-registrations" href="{{ route('customer.bookings') }}" {!! $activeNav === 'my-registrations' ? 'aria-current="page"' : '' !!}>
            <span class="material-symbols-outlined text-[24px]">confirmation_number</span>
            <span class="font-label-sm text-label-sm mt-0.5">My Registrations</span>
        </a>

        <!-- Admin Tab -->
        <a class="flex flex-col items-center justify-center min-w-[64px] min-h-[44px] py-1 px-2 rounded-xl transition-colors {{ $activeNav === 'admin' ? 'text-primary font-label-md font-bold' : 'text-on-surface-variant hover:text-on-surface font-label-sm text-label-sm' }}" data-path="admin" href="{{ url('/admin') }}" {!! $activeNav === 'admin' ? 'aria-current="page"' : '' !!}>
            <span class="material-symbols-outlined text-[24px]">admin_panel_settings</span>
            <span class="font-label-sm text-label-sm mt-0.5">Admin</span>
        </a>
    </div>
</nav>
