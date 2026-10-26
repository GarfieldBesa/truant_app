<x-filament-panels::page>
    <style>
        /* ─── IP Configuration Design System ────────────────────────────────────────── */
        @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800;900&display=swap');

        .ip-container {
            font-family: 'Plus Jakarta Sans', ui-sans-serif, system-ui, -apple-system, sans-serif;
            display: flex;
            flex-direction: column;
            gap: 1.75rem;
        }

        /* ── Header Banner ───────────────────────────────────────────────────────────── */
        .ip-header-banner {
            position: relative;
            background: linear-gradient(135deg, #ffffff 0%, #f8fafc 100%);
            border: 1px solid #e2e8f0;
            border-radius: 1.25rem;
            padding: 1.75rem 2rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 1.25rem;
            box-shadow: 0 4px 20px -2px rgba(0, 0, 0, 0.04);
            overflow: hidden;
        }

        .dark .ip-header-banner {
            background: linear-gradient(135deg, #111827 0%, #1f2937 100%);
            border-color: #374151;
            box-shadow: 0 4px 20px -2px rgba(0, 0, 0, 0.4);
        }

        .ip-header-banner::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 5px;
            height: 100%;
            background: linear-gradient(180deg, #f59e0b 0%, #d97706 100%);
        }

        .ip-header-left {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .ip-header-icon {
            width: 3.25rem;
            height: 3.25rem;
            border-radius: 1rem;
            background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
            color: #ffffff;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 8px 16px -4px rgba(245, 158, 11, 0.35);
            flex-shrink: 0;
        }

        .ip-header-icon svg {
            width: 1.75rem;
            height: 1.75rem;
        }

        .ip-header-title {
            font-size: 1.375rem;
            font-weight: 800;
            color: #0f172a;
            letter-spacing: -0.025em;
            margin: 0;
        }

        .dark .ip-header-title {
            color: #f8fafc;
        }

        .ip-header-desc {
            font-size: 0.875rem;
            color: #64748b;
            margin-top: 0.25rem;
        }

        .dark .ip-header-desc {
            color: #94a3b8;
        }

        .ip-header-actions {
            display: flex;
            align-items: center;
            gap: 0.875rem;
        }

        /* ── Metric Badges ───────────────────────────────────────────────────────────── */
        .ip-stat-pill {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.5rem 1rem;
            border-radius: 0.75rem;
            background: #ffffff;
            border: 1px solid #e2e8f0;
            font-size: 0.8125rem;
            font-weight: 600;
            color: #334155;
            box-shadow: 0 1px 2px rgba(0, 0, 0, 0.03);
        }

        .dark .ip-stat-pill {
            background: #1f2937;
            border-color: #374151;
            color: #e5e7eb;
        }

        .ip-stat-badge {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 0.125rem 0.5rem;
            border-radius: 9999px;
            font-size: 0.75rem;
            font-weight: 700;
            background: #fef3c7;
            color: #b45309;
        }

        .dark .ip-stat-badge {
            background: rgba(245, 158, 11, 0.2);
            color: #fbbf24;
        }

        /* ── Action Buttons ──────────────────────────────────────────────────────────── */
        .ip-btn {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.625rem 1.25rem;
            font-size: 0.875rem;
            font-weight: 600;
            border-radius: 0.75rem;
            border: 1px solid transparent;
            cursor: pointer;
            transition: all 0.15s ease-in-out;
            text-decoration: none;
        }

        .ip-btn-primary {
            background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
            color: #ffffff;
            box-shadow: 0 4px 12px rgba(245, 158, 11, 0.3);
        }

        .ip-btn-primary:hover {
            background: linear-gradient(135deg, #d97706 0%, #b45309 100%);
            box-shadow: 0 6px 16px rgba(245, 158, 11, 0.4);
            transform: translateY(-1px);
        }

        .ip-btn-secondary {
            background: #ffffff;
            border-color: #cbd5e1;
            color: #334155;
        }

        .ip-btn-secondary:hover {
            background: #f8fafc;
            border-color: #94a3b8;
            color: #0f172a;
        }

        .dark .ip-btn-secondary {
            background: #1f2937;
            border-color: #374151;
            color: #e5e7eb;
        }

        .dark .ip-btn-secondary:hover {
            background: #374151;
            color: #ffffff;
        }

        .ip-btn-sm {
            padding: 0.375rem 0.75rem;
            font-size: 0.75rem;
            border-radius: 0.5rem;
        }

        .ip-btn-success {
            background: #10b981;
            color: #ffffff;
        }

        .ip-btn-success:hover {
            background: #059669;
        }

        .ip-btn-danger {
            background: #ef4444;
            color: #ffffff;
        }

        .ip-btn-danger:hover {
            background: #dc2626;
        }

        /* ── Sections & Cards ────────────────────────────────────────────────────────── */
        .ip-section {
            background: #ffffff;
            border: 1px solid #e2e8f0;
            border-radius: 1.25rem;
            overflow: hidden;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.03);
        }

        .dark .ip-section {
            background: #111827;
            border-color: #1f2937;
        }

        .ip-section-header {
            padding: 1.25rem 1.75rem;
            border-bottom: 1px solid #f1f5f9;
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 1rem;
            background: #ffffff;
        }

        .dark .ip-section-header {
            background: #111827;
            border-color: #1f2937;
        }

        .ip-section-title-wrap {
            display: flex;
            align-items: center;
            gap: 0.625rem;
        }

        .ip-section-title {
            font-size: 1.0625rem;
            font-weight: 700;
            color: #0f172a;
            margin: 0;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .dark .ip-section-title {
            color: #f8fafc;
        }

        .ip-section-badge-alert {
            display: inline-flex;
            align-items: center;
            gap: 0.375rem;
            padding: 0.25rem 0.625rem;
            border-radius: 9999px;
            font-size: 0.6875rem;
            font-weight: 800;
            text-transform: uppercase;
            background: #fef3c7;
            color: #b45309;
            border: 1px solid #fde68a;
        }

        .dark .ip-section-badge-alert {
            background: rgba(245, 158, 11, 0.2);
            color: #fbbf24;
            border-color: rgba(245, 158, 11, 0.3);
        }

        /* ── Tables ──────────────────────────────────────────────────────────────────── */
        .ip-table-wrapper {
            width: 100%;
            overflow-x: auto;
        }

        .ip-table {
            width: 100%;
            border-collapse: collapse;
            text-align: left;
            font-size: 0.875rem;
        }

        .ip-table th {
            padding: 0.875rem 1.5rem;
            background: #f8fafc;
            color: #64748b;
            font-size: 0.75rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            border-bottom: 1px solid #e2e8f0;
        }

        .dark .ip-table th {
            background: #1a2234;
            color: #94a3b8;
            border-color: #26334d;
        }

        .ip-table td {
            padding: 1.125rem 1.5rem;
            border-bottom: 1px solid #f1f5f9;
            color: #1e293b;
            vertical-align: middle;
        }

        .dark .ip-table td {
            border-color: #1f2937;
            color: #e2e8f0;
        }

        .ip-table tr:last-child td {
            border-bottom: none;
        }

        .ip-table tr:hover td {
            background: #fafbfc;
        }

        .dark .ip-table tr:hover td {
            background: #172033;
        }

        .ip-ip-pill {
            display: inline-flex;
            align-items: center;
            gap: 0.375rem;
            padding: 0.25rem 0.625rem;
            border-radius: 0.5rem;
            font-family: ui-monospace, SFMono-Regular, Menlo, Monaco, Consolas, monospace;
            font-size: 0.8125rem;
            font-weight: 700;
            background: #f1f5f9;
            color: #0f172a;
            border: 1px solid #e2e8f0;
        }

        .dark .ip-ip-pill {
            background: #1e293b;
            color: #f8fafc;
            border-color: #334155;
        }

        .ip-empty-state {
            padding: 3rem 2rem;
            text-align: center;
            color: #64748b;
        }

        .dark .ip-empty-state {
            color: #94a3b8;
        }

        .ip-empty-icon {
            width: 3.5rem;
            height: 3.5rem;
            margin: 0 auto 1rem auto;
            border-radius: 1rem;
            background: #f1f5f9;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #94a3b8;
        }

        .dark .ip-empty-icon {
            background: #1e293b;
            color: #64748b;
        }

        /* ── Modal Overlay ───────────────────────────────────────────────────────────── */
        .ip-modal-overlay {
            position: fixed;
            inset: 0;
            background: rgba(15, 23, 42, 0.65);
            backdrop-filter: blur(4px);
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 99999;
            padding: 1rem;
            animation: ip-fade-in 0.2s ease-out;
        }

        .ip-modal {
            background: #ffffff;
            border-radius: 1.25rem;
            width: 100%;
            max-width: 520px;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
            border: 1px solid #e2e8f0;
            overflow: hidden;
            animation: ip-zoom-in 0.2s ease-out;
        }

        .dark .ip-modal {
            background: #111827;
            border-color: #374151;
        }

        @keyframes ip-fade-in {
            from { opacity: 0; }
            to { opacity: 1; }
        }

        @keyframes ip-zoom-in {
            from { transform: scale(0.95); opacity: 0; }
            to { transform: scale(1); opacity: 1; }
        }

        .ip-modal-header {
            padding: 1.25rem 1.75rem;
            border-bottom: 1px solid #f1f5f9;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .dark .ip-modal-header {
            border-color: #1f2937;
        }

        .ip-modal-title {
            font-size: 1.125rem;
            font-weight: 700;
            color: #0f172a;
            margin: 0;
        }

        .dark .ip-modal-title {
            color: #f8fafc;
        }

        .ip-modal-close {
            background: none;
            border: none;
            color: #94a3b8;
            cursor: pointer;
            padding: 0.25rem;
            border-radius: 0.375rem;
        }

        .ip-modal-close:hover {
            color: #334155;
            background: #f1f5f9;
        }

        .dark .ip-modal-close:hover {
            color: #e2e8f0;
            background: #1f2937;
        }

        .ip-modal-body {
            padding: 1.75rem;
            display: flex;
            flex-direction: column;
            gap: 1.25rem;
        }

        .ip-form-group {
            display: flex;
            flex-direction: column;
            gap: 0.375rem;
        }

        .ip-label {
            font-size: 0.8125rem;
            font-weight: 700;
            color: #334155;
        }

        .dark .ip-label {
            color: #cbd5e1;
        }

        .ip-input {
            width: 100%;
            padding: 0.6875rem 1rem;
            border-radius: 0.75rem;
            border: 1px solid #cbd5e1;
            background: #ffffff;
            font-size: 0.875rem;
            color: #0f172a;
            outline: none;
            transition: border-color 0.15s ease;
        }

        .ip-input:focus {
            border-color: #f59e0b;
            box-shadow: 0 0 0 3px rgba(245, 158, 11, 0.15);
        }

        .dark .ip-input {
            background: #1f2937;
            border-color: #374151;
            color: #f8fafc;
        }

        .dark .ip-input:focus {
            border-color: #f59e0b;
        }

        .ip-input-hint {
            font-size: 0.75rem;
            color: #64748b;
        }

        .dark .ip-input-hint {
            color: #94a3b8;
        }

        .ip-modal-footer {
            padding: 1.25rem 1.75rem;
            border-top: 1px solid #f1f5f9;
            background: #fafbfc;
            display: flex;
            align-items: center;
            justify-content: flex-end;
            gap: 0.75rem;
        }

        .dark .ip-modal-footer {
            border-color: #1f2937;
            background: #161f30;
        }
    </style>

    <div class="ip-container">
        <!-- ── Top Header Banner ── -->
        <div class="ip-header-banner">
            <div class="ip-header-left">
                <div class="ip-header-icon">
                    <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 21a9.004 9.004 0 008.716-6.747M12 21a9.004 9.004 0 01-8.716-6.747M12 21c2.485 0 4.5-4.03 4.5-9S14.485 3 12 3m0 18c-2.485 0-4.5-4.03-4.5-9S9.515 3 12 3m0 0a8.997 8.997 0 017.843 4.582M12 3a8.997 8.997 0 00-7.843 4.582m15.686 0A11.953 11.953 0 0112 10.5c-2.998 0-5.74-1.1-7.843-2.918m15.686 0A8.959 8.959 0 0121 12c0 .778-.099 1.533-.284 2.253m0 0A17.919 17.919 0 0112 16.5c-3.162 0-6.133-.815-8.716-2.247m0 0A9.015 9.015 0 013 12c0-1.605.42-3.113 1.157-4.418" />
                    </svg>
                </div>
                <div>
                    <h1 class="ip-header-title">IP Configuration &amp; Location Security</h1>
                    <p class="ip-header-desc">Manage physical office locations, registered IP addresses, and approve employee IP registration requests.</p>
                </div>
            </div>

            <div class="ip-header-actions">
                <div class="ip-stat-pill">
                    <span>Configured Locations:</span>
                    <span class="ip-stat-badge">{{ $totalLocations }}</span>
                </div>

                @if($pendingCount > 0)
                    <div class="ip-stat-pill" style="border-color: rgba(245,158,11,0.4); background: #fef3c7; color: #b45309;">
                        <span>Pending Requests:</span>
                        <span class="ip-stat-badge" style="background:#f59e0b; color:#fff;">{{ $pendingCount }}</span>
                    </div>
                @endif

                <button type="button" wire:click="openCreateModal" class="ip-btn ip-btn-primary">
                    <svg style="width:16px;height:16px;" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                    </svg>
                    Add Location
                </button>
            </div>
        </div>

        <!-- ── Pending User IP Requests Section ── -->
        <div class="ip-section">
            <div class="ip-section-header">
                <div class="ip-section-title-wrap">
                    <h2 class="ip-section-title">
                        <svg style="width:20px;height:20px;color:#f59e0b;" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M14.857 17.082a23.848 23.848 0 005.454-1.31A8.967 8.967 0 0118 9.75v-.7V9A6 6 0 006 9v.75a8.967 8.967 0 01-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 01-5.714 0m5.714 0a3 3 0 11-5.714 0" />
                        </svg>
                        User IP Registration Requests
                    </h2>
                    @if($pendingRequests->isNotEmpty())
                        <span class="ip-section-badge-alert">
                            <span style="display:inline-block;width:6px;height:6px;border-radius:9999px;background:#f59e0b;"></span>
                            {{ $pendingRequests->count() }} Awaiting Approval
                        </span>
                    @endif
                </div>
            </div>

            @if($pendingRequests->isNotEmpty())
                <div class="ip-table-wrapper">
                    <table class="ip-table">
                        <thead>
                            <tr>
                                <th>Employee</th>
                                <th>Target Location</th>
                                <th>Requested IP Address</th>
                                <th>Note / Description</th>
                                <th>Date Requested</th>
                                <th style="text-align: right;">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($pendingRequests as $req)
                                <tr>
                                    <td>
                                        <div style="font-weight: 700; color: #0f172a;" class="dark:text-white">
                                            {{ $req->employee ? "{$req->employee->first_name} {$req->employee->last_name}" : 'Unknown Employee' }}
                                        </div>
                                        <div style="font-size: 0.75rem; color: #64748b;" class="dark:text-gray-400">
                                            {{ '@' . ($req->employee?->username ?? 'n/a') }}
                                        </div>
                                    </td>
                                    <td>
                                        <span style="font-weight: 600; display: inline-flex; align-items: center; gap: 0.375rem;">
                                            <svg style="width:14px;height:14px;color:#f59e0b;" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                            </svg>
                                            {{ $req->location?->name ?? $req->location_name ?? 'Unassigned' }}
                                        </span>
                                    </td>
                                    <td>
                                        <span class="ip-ip-pill">
                                            {{ $req->ip_address }}
                                        </span>
                                    </td>
                                    <td>
                                        <div style="max-width: 280px; font-size: 0.8125rem; line-height: 1.4; color: #475569;" class="dark:text-gray-300">
                                            {{ $req->description ?: 'No note provided.' }}
                                        </div>
                                    </td>
                                    <td>
                                        <span style="font-size: 0.8125rem; color: #64748b;" class="dark:text-gray-400">
                                            {{ $req->created_at->format('M d, Y h:i A') }}
                                        </span>
                                    </td>
                                    <td style="text-align: right;">
                                        <div style="display: inline-flex; gap: 0.5rem; justify-content: flex-end;">
                                            <button
                                                type="button"
                                                wire:click="approveRequest({{ $req->id }})"
                                                class="ip-btn ip-btn-sm ip-btn-success"
                                                title="Approve and register IP to location"
                                            >
                                                <svg style="width:14px;height:14px;" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" />
                                                </svg>
                                                Approve
                                            </button>
                                            <button
                                                type="button"
                                                wire:click="rejectRequest({{ $req->id }})"
                                                class="ip-btn ip-btn-sm ip-btn-danger"
                                                title="Reject request"
                                            >
                                                <svg style="width:14px;height:14px;" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                                                </svg>
                                                Reject
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="ip-empty-state">
                    <div class="ip-empty-icon">
                        <svg style="width:24px;height:24px;" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.75">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <div style="font-weight: 700; color: #0f172a; margin-bottom: 0.25rem;" class="dark:text-white">No Pending Requests</div>
                    <div style="font-size: 0.8125rem;">All employee location IP addresses are verified. New requests submitted from the Timesheet Portal will appear here.</div>
                </div>
            @endif
        </div>

        <!-- ── Configured Locations Table Section ── -->
        <div class="ip-section">
            <div class="ip-section-header">
                <div class="ip-section-title-wrap">
                    <h2 class="ip-section-title">
                        <svg style="width:20px;height:20px;color:#f59e0b;" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 11-6 0 3 3 0 016 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1115 0z" />
                        </svg>
                        Locations &amp; Registered IP Addresses
                    </h2>
                </div>

                <div style="display: flex; align-items: center; gap: 0.75rem;">
                    <div style="position: relative; width: 260px;">
                        <input
                            type="text"
                            wire:model.live.debounce.300ms="search"
                            placeholder="Search location or IP..."
                            class="ip-input"
                            style="padding-left: 2.25rem; font-size: 0.8125rem;"
                        />
                        <svg style="position: absolute; left: 0.75rem; top: 50%; transform: translateY(-50%); width: 16px; height: 16px; color: #94a3b8;" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </div>
                </div>
            </div>

            @if($locations->isNotEmpty())
                <div class="ip-table-wrapper">
                    <table class="ip-table">
                        <thead>
                            <tr>
                                <th>Location</th>
                                <th>IP Address</th>
                                <th>Assigned Employees</th>
                                <th style="text-align: right;">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($locations as $loc)
                                <tr>
                                    <td>
                                        <div style="font-weight: 700; color: #0f172a; display: flex; align-items: center; gap: 0.5rem;" class="dark:text-white">
                                            <span style="display: inline-flex; width: 8px; height: 8px; border-radius: 9999px; background: #10b981;"></span>
                                            {{ $loc->name }}
                                        </div>
                                    </td>
                                    <td>
                                        <span class="ip-ip-pill">
                                            {{ $loc->ip_address }}
                                        </span>
                                    </td>
                                    <td>
                                        <span style="font-size: 0.8125rem; font-weight: 600; color: #64748b;" class="dark:text-gray-400">
                                            {{ $loc->employees_count }} {{ Str::plural('employee', $loc->employees_count) }}
                                        </span>
                                    </td>
                                    <td style="text-align: right;">
                                        <div style="display: inline-flex; gap: 0.5rem; justify-content: flex-end;">
                                            <button
                                                type="button"
                                                wire:click="openEditModal({{ $loc->id }})"
                                                class="ip-btn ip-btn-sm ip-btn-secondary"
                                            >
                                                <svg style="width:13px;height:13px;" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" />
                                                </svg>
                                                Edit
                                            </button>
                                            <button
                                                type="button"
                                                wire:click="deleteLocation({{ $loc->id }})"
                                                wire:confirm="Are you sure you want to delete location '{{ $loc->name }}'?"
                                                class="ip-btn ip-btn-sm ip-btn-danger"
                                            >
                                                <svg style="width:13px;height:13px;" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
                                                </svg>
                                                Delete
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="ip-empty-state">
                    <div class="ip-empty-icon">
                        <svg style="width:24px;height:24px;" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.75">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 11-6 0 3 3 0 016 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1115 0z" />
                        </svg>
                    </div>
                    <div style="font-weight: 700; color: #0f172a; margin-bottom: 0.25rem;" class="dark:text-white">No Locations Configured</div>
                    <div style="font-size: 0.8125rem; margin-bottom: 1.25rem;">Add your physical office locations and IP addresses to start enforcing access control.</div>
                    <button type="button" wire:click="openCreateModal" class="ip-btn ip-btn-primary ip-btn-sm">
                        + Add First Location
                    </button>
                </div>
            @endif
        </div>

        <!-- ── Add / Edit Location Modal ── -->
        @if($showLocationModal)
            <div class="ip-modal-overlay">
                <div class="ip-modal" wire:click.outside="closeModal">
                    <div class="ip-modal-header">
                        <h3 class="ip-modal-title">
                            {{ $modalMode === 'edit' ? 'Edit Location' : 'Add New Location' }}
                        </h3>
                        <button type="button" wire:click="closeModal" class="ip-modal-close">
                            <svg style="width:20px;height:20px;" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>

                    <form wire:submit.prevent="saveLocation">
                        <div class="ip-modal-body">
                            <!-- Field 1: Location Name -->
                            <div class="ip-form-group">
                                <label class="ip-label" for="location_name">Location Name <span style="color:#ef4444;">*</span></label>
                                <input
                                    type="text"
                                    id="location_name"
                                    wire:model="name"
                                    placeholder='e.g. Crystal Cave'
                                    class="ip-input"
                                    autofocus
                                    required
                                />
                                <div class="ip-input-hint">The physical office or branch name.</div>
                                @error('name')
                                    <span style="color:#ef4444; font-size:0.75rem; font-weight:600;">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- Field 2: IP Address -->
                            <div class="ip-form-group">
                                <label class="ip-label" for="ip_address">IP Address <span style="color:#ef4444;">*</span></label>
                                <input
                                    type="text"
                                    id="ip_address"
                                    wire:model="ip_address"
                                    placeholder='e.g. 192.168.88.09'
                                    class="ip-input"
                                    required
                                />
                                <div class="ip-input-hint">Public/Static IP or local gateway. Supports leading zeros, CIDR, or comma-separated IPs.</div>
                                @error('ip_address')
                                    <span style="color:#ef4444; font-size:0.75rem; font-weight:600;">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="ip-modal-footer">
                            <button type="button" wire:click="closeModal" class="ip-btn ip-btn-secondary">
                                Cancel
                            </button>
                            <button type="submit" class="ip-btn ip-btn-primary">
                                {{ $modalMode === 'edit' ? 'Update Location' : 'Save Location' }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        @endif
    </div>
</x-filament-panels::page>
