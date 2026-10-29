@php
    $activeNav = $active ?? (
        request()->routeIs('court-booking.*') ? 'book-a-court' :
        (request()->routeIs('customer.bookings') ? 'my-registrations' :
        (request()->is('admin*') ? 'admin' : 'events'))
    );
@endphp

<!-- ═══ 1. DESKTOP HEADER (hidden on mobile, lg:block) ═══ -->
<header class="hidden lg:block fixed top-0 w-full z-50 bg-surface/90 backdrop-blur-xl shadow-[0_1px_8px_rgba(0,0,0,0.04)] border-b border-outline-variant/20">
    <div class="h-16 max-w-7xl mx-auto px-6 lg:px-12 flex items-center justify-between gap-6">
        <div class="flex items-center gap-8">
            <a href="{{ url('/') }}" class="flex items-center gap-2.5 cursor-pointer text-decoration-none group">
                <div class="w-9 h-9 rounded-xl bg-primary flex items-center justify-center text-on-primary shadow-sm group-hover:scale-105 transition-transform">
                    <span class="material-symbols-outlined text-[20px]">bolt</span>
                </div>
                <div class="flex flex-col">
                    <span class="font-headline-sm text-headline-sm text-on-surface leading-none tracking-tight">Truant</span>
                    <span class="font-label-sm text-label-sm text-on-surface-variant leading-none mt-0.5 tracking-wider uppercase">Enterprises</span>
                </div>
            </a>
            <nav class="flex items-center gap-1.5 p-1" data-active-classes="bg-primary-container text-on-primary font-label-lg rounded-lg">
                <a class="px-3.5 py-2 rounded-lg font-label-lg text-label-lg transition-colors {{ $activeNav === 'events' ? 'bg-primary-container text-on-primary font-bold' : 'text-on-surface-variant hover:bg-surface-container-high hover:text-on-surface' }}" data-path="events" href="{{ url('/') }}" {!! $activeNav === 'events' ? 'aria-current="page"' : '' !!}>Events</a>
                <a class="px-3.5 py-2 rounded-lg font-label-lg text-label-lg transition-colors {{ $activeNav === 'book-a-court' ? 'bg-primary-container text-on-primary font-bold' : 'text-on-surface-variant hover:bg-surface-container-high hover:text-on-surface' }}" data-path="book-a-court" href="{{ route('court-booking.index') }}" {!! $activeNav === 'book-a-court' ? 'aria-current="page"' : '' !!}>Book a Court</a>
                <a class="px-3.5 py-2 rounded-lg font-label-lg text-label-lg transition-colors {{ $activeNav === 'my-registrations' ? 'bg-primary-container text-on-primary font-bold' : 'text-on-surface-variant hover:bg-surface-container-high hover:text-on-surface' }}" data-path="my-registrations" href="{{ route('customer.bookings') }}" {!! $activeNav === 'my-registrations' ? 'aria-current="page"' : '' !!}>My Registrations</a>
                <a class="px-3.5 py-2 rounded-lg font-label-lg text-label-lg transition-colors {{ $activeNav === 'admin' ? 'bg-primary-container text-on-primary font-bold' : 'text-on-surface-variant hover:bg-surface-container-high hover:text-on-surface' }}" data-path="admin" href="{{ url('/admin') }}" {!! $activeNav === 'admin' ? 'aria-current="page"' : '' !!}>Admin</a>
            </nav>
        </div>
        <div class="flex items-center gap-3.5">
            <div class="flex items-center bg-surface-container-low px-3 py-1.5 rounded-xl text-on-surface-variant focus-within:ring-2 focus-within:ring-primary focus-within:bg-surface-container-lowest transition-all w-56 xl:w-64">
                <span class="material-symbols-outlined text-[18px] mr-2 text-on-surface-variant">search</span>
                <input 
                    class="bg-transparent border-0 outline-none w-full text-body-sm font-body-sm placeholder:text-outline text-on-surface" 
                    placeholder="{{ $searchPlaceholder ?? 'Quick search...' }}" 
                    type="text" 
                    id="headerQuickSearchInput"
                    oninput="{{ $searchInputOninput ?? 'if(typeof filterSlotsQuick === \'function\') { filterSlotsQuick(this.value); } if(typeof filterEventsQuick === \'function\') { filterEventsQuick(this.value); } const es = document.getElementById(\'eventsSearch\'); if(es) { es.value = this.value; es.dispatchEvent(new Event(\'input\', { bubbles: true })); }' }}"
                />
            </div>
            <button aria-label="Notifications" class="w-9 h-9 rounded-xl flex items-center justify-center text-on-surface-variant hover:bg-surface-container-high hover:text-on-surface transition-colors relative" type="button">
                <span class="material-symbols-outlined text-[20px]">notifications</span>
                <span class="absolute top-2 right-2 w-2 h-2 rounded-full bg-primary ring-2 ring-surface"></span>
            </button>
            @auth
                <div class="relative group" id="user-menu-desktop">
                    <button type="button" class="flex items-center gap-2 px-3 py-1.5 rounded-xl bg-surface-container-lowest hover:bg-surface-container-low text-on-surface transition-colors shadow-[0_1px_4px_rgba(0,0,0,0.04)]" aria-label="User Profile">
                        <img src="{{ auth()->user()->avatar_url }}" class="w-6 h-6 rounded-full object-cover" alt="{{ auth()->user()->name }}">
                        <span class="font-label-md text-label-md">{{ Str::limit(auth()->user()->name, 14) }}</span>
                        <span class="material-symbols-outlined text-[16px]">expand_more</span>
                    </button>
                    <div class="hidden group-hover:block absolute right-0 top-full mt-1 w-56 bg-surface-container-lowest rounded-xl shadow-lg border border-outline-variant/30 py-1.5 z-50">
                        <div class="px-3.5 py-2 border-b border-outline-variant/20">
                            <p class="font-label-sm text-label-sm font-bold text-on-surface">{{ auth()->user()->name }}</p>
                            <p class="font-body-sm text-body-sm text-on-surface-variant truncate">{{ auth()->user()->email }}</p>
                            @if(auth()->user()->google_id)
                                <span class="mt-1 inline-flex items-center gap-1 font-label-sm text-[10px] text-amber-700 bg-amber-50 px-2 py-0.5 rounded font-semibold">
                                    Google Connected
                                </span>
                            @endif
                        </div>
                        <a href="{{ route('customer.bookings') }}" class="flex items-center gap-2 px-3.5 py-2 font-label-md text-label-md text-on-surface hover:bg-surface-container-low transition-colors">
                            <span class="material-symbols-outlined text-[18px]">confirmation_number</span> My Registrations &amp; Bookings
                        </a>
                        <a href="{{ route('court-booking.index') }}" class="flex items-center gap-2 px-3.5 py-2 font-label-md text-label-md text-on-surface hover:bg-surface-container-low transition-colors">
                            <span class="material-symbols-outlined text-[18px]">sports_tennis</span> Book a Court
                        </a>
                        <a href="{{ url('/') }}" class="flex items-center gap-2 px-3.5 py-2 font-label-md text-label-md text-on-surface hover:bg-surface-container-low transition-colors">
                            <span class="material-symbols-outlined text-[18px]">event</span> Events &amp; Summits
                        </a>
                        @if(auth()->user()->isAdmin())
                            <div class="my-1 border-t border-outline-variant/20"></div>
                            <a href="{{ url('/admin') }}" class="flex items-center gap-2 px-3.5 py-2 font-label-md text-label-md text-primary font-bold hover:bg-surface-container-low transition-colors">
                                <span class="material-symbols-outlined text-[18px]">admin_panel_settings</span> Admin Panel
                            </a>
                        @endif
                        <div class="my-1 border-t border-outline-variant/20"></div>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="w-full text-left flex items-center gap-2 px-3.5 py-2 font-label-md text-label-md text-error hover:bg-surface-container-low transition-colors">
                                <span class="material-symbols-outlined text-[18px]">logout</span> Sign Out
                            </button>
                        </form>
                    </div>
                </div>
            @else
                <div class="flex items-center gap-2">
                    <a href="{{ route('login') }}?redirect={{ urlencode(request()->fullUrl()) }}" class="flex items-center gap-2 px-3 py-1.5 rounded-xl bg-surface-container-lowest hover:bg-surface-container-low text-on-surface transition-colors shadow-[0_1px_4px_rgba(0,0,0,0.04)]" id="btn-login-header">
                        <svg class="w-4 h-4" viewBox="0 0 24 24">
                            <path d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z" fill="#4285F4"></path>
                            <path d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z" fill="#34A853"></path>
                            <path d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.06H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.94l2.85-2.22.81-.63z" fill="#FBBC05"></path>
                            <path d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.06l3.66 2.84c.87-2.6 3.3-4.52 6.16-4.52z" fill="#EA4335"></path>
                        </svg>
                        <span class="font-label-md text-label-md">Login / Sign In</span>
                    </a>
                </div>
            @endauth
        </div>
    </div>
</header>

<!-- ═══ 2. MOBILE HEADER (lg:hidden, consistent across all pages) ═══ -->
<header class="lg:hidden fixed top-0 w-full z-50 pt-safe bg-surface/80 backdrop-blur-xl shadow-[0_1px_8px_rgba(0,0,0,0.04)] border-b border-outline-variant/20">
    <div class="h-16 px-gutter-mobile flex items-center justify-between gap-space-sm">
        <a href="{{ url('/') }}" class="flex items-center gap-space-sm min-w-0">
            <img alt="Truant Enterprises Logo" class="h-8 w-auto object-contain flex-shrink-0" src="https://lh3.googleusercontent.com/aida/AEtjO1WpzETmgBoH2y8JACFB8wvqlsEuDTMKNjxzaHBkfahYx9kTr948GdRcn0ZIMGdaaDHDBozDQjZ4EzdJrEOVvvtfgAzmPMwzTgrmBce874NILVGwGVL9ALDkmXZtNr2aP9EkCLwm490uQekzW_xTnTLwXvaxrFDuXzRuwQkzvhQ0kJb3MCEgdKp9l9EJMgjQmsjCpV3Fj5NnnwPBX1DifP-OXXuZRuri4EFCkjB3l-A3o5LTgHm4twF-Z3U"/>
            <div class="flex flex-col min-w-0">
                <span class="font-headline-sm text-headline-sm text-on-surface tracking-tight truncate leading-none">Truant Enterprises</span>
                <span class="font-label-sm text-label-sm text-on-surface-variant truncate mt-0.5">{{ $mobileSubtitle ?? 'Court & Event Hub' }}</span>
            </div>
        </a>
        <div class="flex items-center gap-space-xs flex-shrink-0">
            <button aria-label="Notifications" class="relative w-11 h-11 min-w-[44px] min-h-[44px] flex items-center justify-center rounded-full text-on-surface-variant hover:text-on-surface hover:bg-surface-container active:scale-95 transition-all" type="button">
                <span class="material-symbols-outlined text-[22px]">notifications</span>
                <span class="absolute top-2.5 right-2.5 w-2 h-2 rounded-full bg-primary ring-2 ring-surface"></span>
            </button>
            @auth
                <a href="{{ route('customer.bookings') }}" aria-label="User Profile" class="w-11 h-11 min-w-[44px] min-h-[44px] flex items-center justify-center rounded-full p-0.5 hover:bg-surface-container active:scale-95 transition-all">
                    <img alt="{{ auth()->user()->name }}" class="w-8 h-8 rounded-full object-cover" src="{{ auth()->user()->avatar_url }}"/>
                </a>
            @else
                <a href="{{ route('login') }}?redirect={{ urlencode(request()->fullUrl()) }}" aria-label="Sign In" class="w-11 h-11 min-w-[44px] min-h-[44px] flex items-center justify-center rounded-full p-0.5 hover:bg-surface-container active:scale-95 transition-all" id="btn-login-header-mobile">
                    <div class="w-8 h-8 rounded-full bg-primary flex items-center justify-center text-on-primary shadow-sm">
                        <span class="material-symbols-outlined text-[18px]">person</span>
                    </div>
                </a>
            @endauth
        </div>
    </div>
</header>
