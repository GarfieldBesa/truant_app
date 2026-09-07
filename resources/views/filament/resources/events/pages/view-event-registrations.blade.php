<x-filament-panels::page>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap');

        .ev-reg-root {
            font-family: 'Plus Jakarta Sans', ui-sans-serif, system-ui, -apple-system, sans-serif;
            color: #1e293b;
            display: flex;
            flex-direction: column;
            gap: 1.5rem;
        }

        .dark .ev-reg-root {
            color: #f1f5f9;
        }

        /* ─── Top Stats & Info Card ───────────────────────────────────────────────── */
        .ev-reg-card {
            background: #ffffff;
            border: 1px solid #e2e8f0;
            border-radius: 1.25rem;
            box-shadow: 0 4px 20px -2px rgba(0, 0, 0, 0.05);
            overflow: hidden;
            padding: 1.5rem;
        }

        .dark .ev-reg-card {
            background: #0f172a;
            border-color: #1e293b;
            box-shadow: 0 4px 20px -2px rgba(0, 0, 0, 0.3);
        }

        .ev-reg-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 1rem;
            margin-bottom: 1.25rem;
        }

        .ev-reg-title-wrap {
            display: flex;
            align-items: center;
            gap: 0.875rem;
        }

        .ev-reg-icon {
            width: 3rem;
            height: 3rem;
            border-radius: 0.875rem;
            background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%);
            color: #ffffff;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 4px 12px rgba(37, 99, 235, 0.3);
            flex-shrink: 0;
        }

        .ev-reg-icon svg {
            width: 1.5rem;
            height: 1.5rem;
        }

        .ev-reg-title {
            font-size: 1.375rem;
            font-weight: 800;
            letter-spacing: -0.02em;
            color: #0f172a;
        }

        .dark .ev-reg-title {
            color: #f8fafc;
        }

        .ev-reg-subtitle {
            font-size: 0.875rem;
            color: #64748b;
            margin-top: 0.125rem;
        }

        .dark .ev-reg-subtitle {
            color: #94a3b8;
        }

        .ev-reg-stats-row {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
            gap: 1rem;
        }

        .ev-stat-pill {
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 0.875rem;
            padding: 0.875rem 1rem;
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .dark .ev-stat-pill {
            background: #1e293b;
            border-color: #334155;
        }

        .ev-stat-icon {
            width: 2.25rem;
            height: 2.25rem;
            border-radius: 0.625rem;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .ev-stat-label {
            font-size: 0.75rem;
            font-weight: 600;
            color: #64748b;
            text-transform: uppercase;
            letter-spacing: 0.04em;
        }

        .dark .ev-stat-label {
            color: #94a3b8;
        }

        .ev-stat-value {
            font-size: 1rem;
            font-weight: 800;
            color: #0f172a;
            margin-top: 0.125rem;
        }

        .dark .ev-stat-value {
            color: #f8fafc;
        }

        /* ─── Filter Control Bar ─────────────────────────────────────────────────── */
        .ev-filter-bar {
            background: #ffffff;
            border: 1px solid #e2e8f0;
            border-radius: 1.25rem;
            padding: 1.25rem;
            box-shadow: 0 4px 20px -2px rgba(0, 0, 0, 0.05);
            display: flex;
            flex-direction: column;
            gap: 1rem;
        }

        .dark .ev-filter-bar {
            background: #0f172a;
            border-color: #1e293b;
        }

        .ev-filter-top-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 0.75rem;
        }

        .ev-filter-heading {
            font-size: 0.875rem;
            font-weight: 700;
            color: #0f172a;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }

        .dark .ev-filter-heading {
            color: #f8fafc;
        }

        .ev-filter-actions {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            flex-wrap: wrap;
        }

        .ev-filter-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
            gap: 1rem;
            align-items: flex-end;
        }

        .ev-form-group {
            display: flex;
            flex-direction: column;
            gap: 0.375rem;
        }

        .ev-label {
            font-size: 0.75rem;
            font-weight: 700;
            color: #475569;
            text-transform: uppercase;
            letter-spacing: 0.04em;
        }

        .dark .ev-label {
            color: #94a3b8;
        }

        .ev-input, .ev-select {
            width: 100%;
            padding: 0.625rem 0.875rem;
            border-radius: 0.625rem;
            border: 1px solid #cbd5e1;
            background-color: #ffffff;
            color: #0f172a;
            font-size: 0.875rem;
            font-weight: 500;
            outline: none;
            transition: all 0.15s ease;
            box-sizing: border-box;
        }

        .dark .ev-input, .dark .ev-select {
            background-color: #1e293b;
            border-color: #334155;
            color: #f8fafc;
        }

        .ev-input:focus, .ev-select:focus {
            border-color: #3b82f6;
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.2);
        }

        /* ─── Buttons ─────────────────────────────────────────────────────────────── */
        .ev-btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
            padding: 0.625rem 1.125rem;
            border-radius: 0.625rem;
            font-size: 0.875rem;
            font-weight: 700;
            cursor: pointer;
            transition: all 0.15s ease;
            border: 1px solid transparent;
            text-decoration: none;
            white-space: nowrap;
        }

        .ev-btn svg {
            width: 1.125rem;
            height: 1.125rem;
            flex-shrink: 0;
        }

        .ev-btn-primary {
            background: linear-gradient(135deg, #2563eb 0%, #1d4ed8 100%);
            color: #ffffff;
            box-shadow: 0 4px 12px rgba(37, 99, 235, 0.25);
        }

        .ev-btn-primary:hover {
            background: linear-gradient(135deg, #1d4ed8 0%, #1e40af 100%);
            transform: translateY(-1px);
        }

        .ev-btn-print {
            background: linear-gradient(135deg, #059669 0%, #047857 100%);
            color: #ffffff;
            box-shadow: 0 4px 12px rgba(5, 150, 105, 0.25);
        }

        .ev-btn-print:hover {
            background: linear-gradient(135deg, #047857 0%, #065f46 100%);
            transform: translateY(-1px);
        }

        .ev-btn-secondary {
            background: #f1f5f9;
            color: #475569;
            border-color: #e2e8f0;
        }

        .dark .ev-btn-secondary {
            background: #1e293b;
            color: #cbd5e1;
            border-color: #334155;
        }

        .ev-btn-secondary:hover {
            background: #e2e8f0;
            color: #0f172a;
        }

        .dark .ev-btn-secondary:hover {
            background: #334155;
            color: #f8fafc;
        }

        .ev-btn-danger-sm {
            padding: 0.375rem 0.625rem;
            font-size: 0.75rem;
            border-radius: 0.5rem;
            background: rgba(239, 68, 68, 0.1);
            color: #dc2626;
            border: 1px solid rgba(239, 68, 68, 0.2);
            cursor: pointer;
            transition: all 0.15s ease;
        }

        .ev-btn-danger-sm:hover {
            background: #dc2626;
            color: #ffffff;
        }

        /* ─── Table ───────────────────────────────────────────────────────────────── */
        .ev-table-container {
            background: #ffffff;
            border: 1px solid #e2e8f0;
            border-radius: 1.25rem;
            box-shadow: 0 4px 20px -2px rgba(0, 0, 0, 0.05);
            overflow-x: auto;
        }

        .dark .ev-table-container {
            background: #0f172a;
            border-color: #1e293b;
        }

        .ev-table {
            width: 100%;
            border-collapse: collapse;
            text-align: left;
            font-size: 0.875rem;
        }

        .ev-table th {
            background: #f8fafc;
            color: #475569;
            font-size: 0.75rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            padding: 0.875rem 1rem;
            border-bottom: 1px solid #e2e8f0;
            white-space: nowrap;
        }

        .dark .ev-table th {
            background: #1e293b;
            color: #94a3b8;
            border-bottom-color: #334155;
        }

        .ev-table td {
            padding: 1rem;
            border-bottom: 1px solid #f1f5f9;
            vertical-align: middle;
            color: #334155;
        }

        .dark .ev-table td {
            border-bottom-color: #1e293b;
            color: #cbd5e1;
        }

        .ev-table tr:hover td {
            background: #f8fafc;
        }

        .dark .ev-table tr:hover td {
            background: rgba(30, 41, 59, 0.5);
        }

        .ev-ref-badge {
            font-family: ui-monospace, SFMono-Regular, Menlo, Monaco, Consolas, monospace;
            font-weight: 700;
            font-size: 0.75rem;
            background: #eff6ff;
            color: #1d4ed8;
            padding: 0.25rem 0.5rem;
            border-radius: 0.375rem;
            border: 1px solid #bfdbfe;
            white-space: nowrap;
        }

        .dark .ev-ref-badge {
            background: rgba(37, 99, 235, 0.15);
            color: #60a5fa;
            border-color: rgba(37, 99, 235, 0.3);
        }

        .ev-badge-chip {
            display: inline-flex;
            align-items: center;
            gap: 0.25rem;
            padding: 0.25rem 0.625rem;
            border-radius: 9999px;
            font-size: 0.75rem;
            font-weight: 700;
            background: #e0f2fe;
            color: #0369a1;
            white-space: nowrap;
        }

        .dark .ev-badge-chip {
            background: rgba(3, 105, 161, 0.2);
            color: #38bdf8;
        }

        .ev-badge-consent {
            display: inline-flex;
            align-items: center;
            gap: 0.25rem;
            padding: 0.25rem 0.625rem;
            border-radius: 9999px;
            font-size: 0.75rem;
            font-weight: 700;
            background: #ecfdf5;
            color: #059669;
            white-space: nowrap;
        }

        .dark .ev-badge-consent {
            background: rgba(5, 150, 105, 0.15);
            color: #34d399;
        }

        .ev-img-thumb {
            width: 2.75rem;
            height: 2.75rem;
            border-radius: 0.5rem;
            object-fit: cover;
            border: 1px solid #cbd5e1;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        }

        /* ─── Empty State ─────────────────────────────────────────────────────────── */
        .ev-empty-box {
            padding: 4rem 1.5rem;
            text-align: center;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            gap: 0.75rem;
        }

        .ev-empty-box-icon {
            width: 4rem;
            height: 4rem;
            border-radius: 1rem;
            background: #f1f5f9;
            color: #94a3b8;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .dark .ev-empty-box-icon {
            background: #1e293b;
            color: #64748b;
        }

        .ev-empty-box-icon svg {
            width: 2rem;
            height: 2rem;
        }

        .ev-empty-box-title {
            font-size: 1.125rem;
            font-weight: 800;
            color: #0f172a;
        }

        .dark .ev-empty-box-title {
            color: #f8fafc;
        }

        .ev-empty-box-desc {
            font-size: 0.875rem;
            color: #64748b;
            max-width: 24rem;
        }

        .dark .ev-empty-box-desc {
            color: #94a3b8;
        }

        /* ─── PRINT ONLY STYLESHEET ───────────────────────────────────────────────── */
        .ev-print-header {
            display: none;
        }

        @media print {
            /* Hide UI chrome */
            .fi-topbar,
            .fi-sidebar,
            .fi-header,
            .ev-filter-bar,
            .ev-no-print,
            header,
            nav,
            button,
            .ev-btn {
                display: none !important;
            }

            body, .fi-body, .ev-reg-root {
                background: #ffffff !important;
                color: #000000 !important;
                font-size: 10pt !important;
                padding: 0 !important;
                margin: 0 !important;
            }

            .ev-reg-card {
                border: none !important;
                box-shadow: none !important;
                padding: 0 !important;
                margin-bottom: 1.5rem !important;
            }

            .ev-print-header {
                display: block !important;
                border-bottom: 2px solid #000000;
                padding-bottom: 1rem;
                margin-bottom: 1.5rem;
            }

            .ev-print-title {
                font-size: 18pt !important;
                font-weight: bold !important;
                color: #000000 !important;
            }

            .ev-print-meta {
                font-size: 9pt !important;
                color: #444444 !important;
                margin-top: 0.25rem;
            }

            .ev-table-container {
                border: none !important;
                box-shadow: none !important;
                overflow: visible !important;
            }

            .ev-table {
                width: 100% !important;
                border: 1px solid #000000 !important;
            }

            .ev-table th {
                background: #f0f0f0 !important;
                color: #000000 !important;
                border: 1px solid #000000 !important;
                font-size: 8.5pt !important;
                padding: 6px 8px !important;
            }

            .ev-table td {
                border: 1px solid #cccccc !important;
                color: #000000 !important;
                font-size: 8.5pt !important;
                padding: 6px 8px !important;
            }

            .ev-table tr {
                page-break-inside: avoid !important;
            }

            .ev-ref-badge, .ev-badge-chip, .ev-badge-consent {
                background: none !important;
                border: none !important;
                color: #000000 !important;
                font-weight: bold !important;
                padding: 0 !important;
            }
        }
    </style>

    <div class="ev-reg-root">
        <!-- Printable Report Header (Active during print) -->
        <div class="ev-print-header">
            <div class="ev-print-title">{{ $record->name }} — Official Registered Attendees</div>
            <div class="ev-print-meta">
                <strong>Event Date:</strong> {{ $record->event_date ? $record->event_date->format('F d, Y') : 'TBD' }} &nbsp;|&nbsp;
                <strong>Generated On:</strong> {{ now()->format('F d, Y h:i A') }} &nbsp;|&nbsp;
                <strong>Total Attendees:</strong> {{ $this->registrations->count() }} Registered
                @if($selectedColumn !== 'all' && $filterValue)
                    &nbsp;|&nbsp; <strong>Filter Applied:</strong> {{ $selectedColumn }} = "{{ $filterValue }}"
                @elseif($searchQuery)
                    &nbsp;|&nbsp; <strong>Keyword Filter:</strong> "{{ $searchQuery }}"
                @endif
            </div>
        </div>

        <!-- Event Overview & Key Figures -->
        <div class="ev-reg-card ev-no-print">
            <div class="ev-reg-header">
                <div class="ev-reg-title-wrap">
                    <div class="ev-reg-icon">
                        <svg fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M18 18.72a9.094 9.094 0 0 0 3.741-.479 3 3 0 0 0-4.682-2.72m.94 3.198.001.031c0 .225-.012.447-.037.666A11.944 11.944 0 0 1 12 21c-2.17 0-4.207-.576-5.963-1.584A6.062 6.062 0 0 1 6 18.719m12 0a5.971 5.971 0 0 0-.941-3.197m0 0A5.995 5.995 0 0 0 12 12.75a5.995 5.995 0 0 0-5.058 2.772m0 0a3 3 0 0 0-4.681 2.72 8.986 8.986 0 0 0 3.74.477m.94-3.197a5.971 5.971 0 0 0-.94 3.197M15 6.75a3 3 0 1 1-6 0 3 3 0 0 1 6 0Zm6 3a2.25 2.25 0 1 1-4.5 0 2.25 2.25 0 0 1 4.5 0Zm-13.5 0a2.25 2.25 0 1 1-4.5 0 2.25 2.25 0 0 1 4.5 0Z" />
                        </svg>
                    </div>
                    <div>
                        <div class="ev-reg-title">{{ $record->name }}</div>
                        <div class="ev-reg-subtitle">
                            Registered Attendees & Submissions &bull; Dynamic Form Columns
                        </div>
                    </div>
                </div>
            </div>

            <!-- Stats Pills Row -->
            <div class="ev-reg-stats-row">
                <div class="ev-stat-pill">
                    <div class="ev-stat-icon" style="background: rgba(37, 99, 235, 0.12); color: #2563eb;">
                        <svg fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 0 0 2.625.372 9.337 9.337 0 0 0 4.121-.952 4.125 4.125 0 0 0-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 0 1 8.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0 1 11.964-3.07M12 6.375a3.375 3.375 0 1 1-6.75 0 3.375 3.375 0 0 1 6.75 0Zm8.25 2.25a2.625 2.625 0 1 1-5.25 0 2.625 2.625 0 0 1 5.25 0Z" />
                        </svg>
                    </div>
                    <div>
                        <div class="ev-stat-label">Total Registered</div>
                        <div class="ev-stat-value">{{ $record->registrations()->count() }} Attendees</div>
                    </div>
                </div>

                <div class="ev-stat-pill">
                    <div class="ev-stat-icon" style="background: rgba(16, 185, 129, 0.12); color: #059669;">
                        <svg fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 7.5v11.25m-18 0A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75m-18 0v-7.5A2.25 2.25 0 0 1 5.25 9h13.5A2.25 2.25 0 0 1 21 11.25v7.5" />
                        </svg>
                    </div>
                    <div>
                        <div class="ev-stat-label">Event Date</div>
                        <div class="ev-stat-value">{{ $record->event_date ? $record->event_date->format('M d, Y') : 'TBD' }}</div>
                    </div>
                </div>

                <div class="ev-stat-pill">
                    <div class="ev-stat-icon" style="background: rgba(245, 158, 11, 0.12); color: #d97706;">
                        <svg fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                        </svg>
                    </div>
                    <div>
                        <div class="ev-stat-label">Registration Deadline</div>
                        <div class="ev-stat-value">{{ $record->registration_date ? $record->registration_date->format('M d, Y') : 'TBD' }}</div>
                    </div>
                </div>

                <div class="ev-stat-pill">
                    <div class="ev-stat-icon" style="background: rgba(99, 102, 241, 0.12); color: #4f46e5;">
                        <svg fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                        </svg>
                    </div>
                    <div>
                        <div class="ev-stat-label">Status</div>
                        <div class="ev-stat-value" style="color: {{ $record->isRegistrationOpen() ? '#059669' : '#dc2626' }};">
                            {{ $record->registration_status }}
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Dynamic Filter Control Bar (Screen only) -->
        <div class="ev-filter-bar ev-no-print">
            <div class="ev-filter-top-row">
                <div class="ev-filter-heading">
                    <svg style="width:1.125rem;height:1.125rem;color:#3b82f6;" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 6h9.75M10.5 6a1.5 1.5 0 1 1-3 0m3 0a1.5 1.5 0 1 0-3 0M3.75 6H7.5m3 12h9.75m-9.75 0a1.5 1.5 0 0 1-3 0m3 0a1.5 1.5 0 0 0-3 0m-3.75 0H7.5m9-6h3.75m-3.75 0a1.5 1.5 0 0 1-3 0m3 0a1.5 1.5 0 0 0-3 0m-9.75 0h9.75" />
                    </svg>
                    Dynamic Column Filters
                </div>

                <div class="ev-filter-actions">
                    @if($selectedColumn !== 'all' || $filterValue || $searchQuery || $dateFrom || $dateTo)
                        <button
                            type="button"
                            wire:click="clearFilters"
                            class="ev-btn ev-btn-secondary"
                            style="padding: 0.375rem 0.75rem; font-size: 0.75rem;"
                        >
                            <svg fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                            </svg>
                            Clear Filters
                        </button>
                    @endif

                    <div style="font-size: 0.8125rem; font-weight: 700; color: #64748b;">
                        Showing: <span style="color: #2563eb;">{{ $this->registrations->count() }}</span> of {{ $record->registrations()->count() }}
                    </div>
                </div>
            </div>

            <div class="ev-filter-grid">
                <!-- 1. Select Form Column to Filter -->
                <div class="ev-form-group">
                    <label class="ev-label">Filter By Column</label>
                    <select wire:model.live="selectedColumn" class="ev-select">
                        @foreach($this->filterColumnOptions as $colKey => $colLabel)
                            <option value="{{ $colKey }}">{{ $colLabel }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- 2. Dynamic Filter Value Input (Context-Aware) -->
                @php
                    $fieldDef = $this->selectedFieldDefinition;
                @endphp

                <div class="ev-form-group">
                    <label class="ev-label">
                        @if($selectedColumn === 'all')
                            Column Value
                        @else
                            {{ $selectedColumn }} Filter
                        @endif
                    </label>

                    @if($fieldDef && in_array($fieldDef['type'] ?? '', ['radio', 'select']) && !empty($fieldDef['options']))
                        <!-- Dropdown of predefined choices for this field -->
                        <select wire:model.live="filterValue" class="ev-select">
                            <option value="">— All {{ $selectedColumn }} Options —</option>
                            @foreach($fieldDef['options'] as $opt)
                                <option value="{{ $opt }}">{{ $opt }}</option>
                            @endforeach
                        </select>
                    @else
                        <!-- Text query input -->
                        <input
                            type="text"
                            wire:model.live.debounce.300ms="filterValue"
                            class="ev-input"
                            placeholder="{{ $selectedColumn === 'all' ? 'Select column above or type keyword...' : 'Type filter keyword for ' . $selectedColumn . '...' }}"
                            @disabled($selectedColumn === 'all')
                        />
                    @endif
                </div>

                <!-- 3. Global Keyword Search -->
                <div class="ev-form-group">
                    <label class="ev-label">Global Keyword Search</label>
                    <input
                        type="text"
                        wire:model.live.debounce.300ms="searchQuery"
                        class="ev-input"
                        placeholder="Search across all fields & ref..."
                    />
                </div>

                <!-- 4. Registered Date From -->
                <div class="ev-form-group">
                    <label class="ev-label">Registered From</label>
                    <input
                        type="date"
                        wire:model.live="dateFrom"
                        class="ev-input"
                    />
                </div>

                <!-- 5. Registered Date To -->
                <div class="ev-form-group">
                    <label class="ev-label">Registered To</label>
                    <input
                        type="date"
                        wire:model.live="dateTo"
                        class="ev-input"
                    />
                </div>
            </div>
        </div>

        <!-- Dynamic Registrations Table -->
        <div class="ev-table-container">
            @if($this->registrations->isEmpty())
                <div class="ev-empty-box">
                    <div class="ev-empty-box-icon">
                        <svg fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 0 0 2.625.372 9.337 9.337 0 0 0 4.121-.952 4.125 4.125 0 0 0-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 0 1 8.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0 1 11.964-3.07M12 6.375a3.375 3.375 0 1 1-6.75 0 3.375 3.375 0 0 1 6.75 0Zm8.25 2.25a2.625 2.625 0 1 1-5.25 0 2.625 2.625 0 0 1 5.25 0Z" />
                        </svg>
                    </div>
                    <div class="ev-empty-box-title">No Registered Attendees Found</div>
                    <div class="ev-empty-box-desc">
                        @if($record->registrations()->count() === 0)
                            No attendees have registered for this event yet. You can click "Populate Sample Attendees" above to generate demo test records with dynamic columns.
                        @else
                            No registrations matched the selected dynamic filter criteria. Try adjusting or clearing your filters.
                        @endif
                    </div>
                    @if($record->registrations()->count() === 0 && !empty($this->formFields))
                        <button
                            type="button"
                            wire:click="seedDemoRegistrations"
                            class="ev-btn ev-btn-primary ev-no-print"
                            style="margin-top: 0.5rem;"
                        >
                            <svg fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                            </svg>
                            Populate Demo Attendees
                        </button>
                    @endif
                </div>
            @else
                <table class="ev-table">
                    <thead>
                        <tr>
                            <th>Ref #</th>
                            <!-- Dynamic Columns created for this form -->
                            @foreach($this->formFields as $field)
                                <th>{{ $field['label'] ?? 'Field' }}</th>
                            @endforeach
                            <th>Consent</th>
                            <th>Registered Date</th>
                            <th class="ev-no-print" style="text-align: right;">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($this->registrations as $reg)
                            <tr>
                                <td>
                                    <span class="ev-ref-badge">{{ $reg->registration_reference }}</span>
                                </td>

                                <!-- Dynamic Field Values -->
                                @foreach($this->formFields as $field)
                                    @php
                                        $fLabel = $field['label'] ?? '';
                                        $fType = $field['type'] ?? 'text';
                                        $fVal = $reg->getFieldValue($fLabel, '—');
                                    @endphp

                                    <td>
                                        @if($fType === 'image_upload' && $fVal !== '—')
                                            <a href="{{ asset('storage/' . $fVal) }}" target="_blank" title="View Image">
                                                <img
                                                    src="{{ asset('storage/' . $fVal) }}"
                                                    alt="{{ $fLabel }}"
                                                    class="ev-img-thumb"
                                                    onerror="this.style.display='none'"
                                                />
                                            </a>
                                        @elseif(in_array($fType, ['radio', 'select']) && $fVal !== '—')
                                            <span class="ev-badge-chip">{{ $fVal }}</span>
                                        @else
                                            <span style="font-weight: 500;">{{ $fVal }}</span>
                                        @endif
                                    </td>
                                @endforeach

                                <td>
                                    @if($reg->consent_agreed)
                                        <span class="ev-badge-consent">
                                            <svg style="width:0.875rem;height:0.875rem" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5" />
                                            </svg>
                                            Agreed
                                        </span>
                                    @else
                                        <span style="color: #ef4444; font-weight: bold;">No</span>
                                    @endif
                                </td>

                                <td style="white-space: nowrap; font-size: 0.8125rem; color: #64748b;">
                                    {{ $reg->created_at->format('M d, Y h:i A') }}
                                </td>

                                <td class="ev-no-print" style="text-align: right; white-space: nowrap;">
                                    <button
                                        type="button"
                                        wire:click="deleteRegistration({{ $reg->id }})"
                                        wire:confirm="Are you sure you want to delete this registration record?"
                                        class="ev-btn-danger-sm"
                                        title="Delete Registration"
                                    >
                                        Delete
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
        </div>
    </div>
</x-filament-panels::page>
