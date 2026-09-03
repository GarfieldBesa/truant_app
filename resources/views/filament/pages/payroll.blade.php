<x-filament-panels::page>
    <style>
        /* ─── Payroll Design System ──────────────────────────────────────────── */
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap');

        .pr-wrap {
            font-family: 'Inter', ui-sans-serif, system-ui, -apple-system, sans-serif;
            display: flex;
            flex-direction: column;
            gap: 1.5rem;
        }

        /* ── Panel / Card ─────────────────────────────────────────────────────── */
        .pr-panel {
            background: #ffffff;
            border: 1px solid #e5e7eb;
            border-radius: 1rem;
            box-shadow: 0 1px 4px rgba(0,0,0,.04), 0 4px 16px rgba(0,0,0,.04);
            overflow: hidden;
        }

        .dark .pr-panel {
            background: #111827;
            border-color: #1f2937;
            box-shadow: 0 1px 4px rgba(0,0,0,.3);
        }

        .pr-panel-body {
            padding: 1.5rem;
        }

        /* ── Page Header ──────────────────────────────────────────────────────── */
        .pr-header {
            display: flex;
            flex-direction: column;
            gap: .25rem;
        }

        .pr-header-title {
            font-size: 1.25rem;
            font-weight: 800;
            color: #0f172a;
            letter-spacing: -.025em;
            display: flex;
            align-items: center;
            gap: .625rem;
        }

        .dark .pr-header-title { color: #f8fafc; }

        .pr-header-icon {
            width: 36px; height: 36px;
            border-radius: .625rem;
            background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
            display: flex; align-items: center; justify-content: center;
            box-shadow: 0 2px 8px rgba(245,158,11,.35);
            flex-shrink: 0;
        }

        .pr-header-icon svg { color: #fff; }

        .pr-header-sub {
            font-size: .75rem;
            color: #6b7280;
            margin-top: .125rem;
        }

        .dark .pr-header-sub { color: #9ca3af; }

        /* ── Cutoff Segmented Control ─────────────────────────────────────────── */
        .pr-seg {
            display: inline-flex;
            background: #f1f5f9;
            border-radius: .75rem;
            padding: .25rem;
            gap: .25rem;
        }

        .dark .pr-seg {
            background: #1e293b;
        }

        .pr-seg-btn {
            padding: .4rem 1rem;
            border-radius: .5rem;
            font-size: .75rem;
            font-weight: 600;
            transition: all .2s ease;
            cursor: pointer;
            border: none;
            letter-spacing: .01em;
            
        }

        .pr-seg-btn-on {
            background: #ffffff;
            color: #92400e;
            box-shadow: 0 1px 3px rgba(0,0,0,.12), 0 1px 2px rgba(0,0,0,.06);
            border: 1px solid #fde68a;
        }

        .dark .pr-seg-btn-on {
            background: #1f2937;
            color: #fbbf24;
            border-color: #374151;
            box-shadow: 0 1px 3px rgba(0,0,0,.4);
        }

        .pr-seg-btn-off {
            background: transparent;
            color: #64748b;
        }

        .pr-seg-btn-off:hover {
            color: #0f172a;
            background: rgba(255,255,255,.6);
        }

        .dark .pr-seg-btn-off { color: #94a3b8; }
        .dark .pr-seg-btn-off:hover { color: #e2e8f0; background: rgba(255,255,255,.04); }

        /* ── Print Styles ─────────────────────────────────────────────────────── */
        @media print {
            body { background: white !important; }
            body > *:not(.pr-print-overlay) { display: none !important; }
            .pr-print-overlay {
                display: block !important;
                color: black !important;
                font-family: 'Inter', Arial, sans-serif;
                width: 100%;
            }
            .pr-print-header { text-align: center; margin-bottom: 2rem; }
            .pr-print-header h2 {
                font-size: 1.75rem; font-weight: 800; margin-bottom: 0.25rem; text-transform: uppercase;
            }
            .pr-print-emp-details {
                display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; margin-bottom: 2rem; font-size: 1.1rem;
            }
            .pr-print-tbl {
                width: 100%; border-collapse: collapse; margin-bottom: 2rem;
            }
            .pr-print-tbl th, .pr-print-tbl td {
                border: 1px solid #cbd5e1; padding: 0.35rem 0.25rem; text-align: left; font-size: 0.75rem; 
            }
            .pr-print-tbl th {
                background: #f1f5f9 !important; -webkit-print-color-adjust: exact; print-color-adjust: exact; font-weight: 700;
            }
            .pr-print-tbl .text-right { text-align: right; }
            .pr-print-summary {
                display: grid; grid-template-columns: repeat(4, 1fr); gap: 1rem; margin-bottom: 2rem;
                padding: 1rem; background: #f8fafc !important; -webkit-print-color-adjust: exact; print-color-adjust: exact;
                border: 1px solid #e2e8f0; border-radius: 0.5rem; font-size: 0.85rem;
            }
            .pr-print-summary-item { display: flex; flex-direction: column; gap: 0.25rem; }
            .pr-print-summary-item strong { color: #64748b; text-transform: uppercase; font-size: 0.7rem; }
            .pr-print-summary-item span { font-weight: 700; font-size: 1rem; }
            .pr-print-net span { font-size: 1.25rem; }
            .pr-print-footer {
                margin-top: 4rem; page-break-inside: avoid; break-inside: avoid;
            }
            .pr-print-footer p { margin-bottom: 4rem; font-size: 1.1rem; }
            .pr-print-signature {
                display: flex; justify-content: space-around;
            }
            .pr-print-signature > div { width: 40%; text-align: center; }
            .pr-print-signature .pr-line {
                border-bottom: 1px solid #000; margin-bottom: 0.5rem; height: 20px;
            }
        }
        @media screen {
            .pr-print-overlay { display: none !important; }
        }

        /* ── Form Controls ────────────────────────────────────────────────────── */
        .pr-filter-grid {
            display: grid;
            grid-template-columns: repeat(1, 1fr);
            gap: 1rem;
        }
        @media (min-width: 640px)  { .pr-filter-grid { grid-template-columns: repeat(2, 1fr); } }
        @media (min-width: 768px)  { .pr-filter-grid { grid-template-columns: repeat(4, 1fr); } }

        .pr-label {
            display: block;
            font-size: .6875rem;
            font-weight: 600;
            letter-spacing: .06em;
            text-transform: uppercase;
            color: #64748b;
            margin-bottom: .375rem;
        }

        .dark .pr-label { color: #94a3b8; }

        .pr-select, .pr-input-text {
            width: 100%;
            font-size: .875rem;
            font-family: inherit;
            border-radius: .625rem;
            border: 1px solid #e2e8f0;
            background: #f8fafc;
            padding: .5625rem .875rem;
            color: #0f172a;
            transition: border-color .15s, box-shadow .15s;
            appearance: none;
            -webkit-appearance: none;
        }

        .pr-select:focus, .pr-input-text:focus {
            outline: none;
            border-color: #f59e0b;
            background: #ffffff;
            box-shadow: 0 0 0 3px rgba(245,158,11,.12);
        }

        .dark .pr-select, .dark .pr-input-text {
            border-color: #334155;
            background: #1e293b;
            color: #f1f5f9;
        }

        .dark .pr-select:focus, .dark .pr-input-text:focus {
            border-color: #f59e0b;
            background: #1e293b;
        }

        .pr-select-wrap {
            position: relative;
        }

        .pr-select-wrap::after {
            content: '';
            position: absolute;
            right: .75rem;
            top: 50%;
            transform: translateY(-50%);
            width: 0; height: 0;
            border-left: 4px solid transparent;
            border-right: 4px solid transparent;
            border-top: 5px solid #94a3b8;
            pointer-events: none;
        }

        .pr-search-wrap {
            position: relative;
        }

        .pr-search-icon {
            position: absolute;
            left: .75rem;
            top: 50%;
            transform: translateY(-50%);
            pointer-events: none;
            color: #94a3b8;
        }

        /* ── KPI / Summary Cards ──────────────────────────────────────────────── */
        .pr-kpi-grid {
            display: grid;
            grid-template-columns: repeat(1, 1fr);
            gap: 1rem;
        }

        @media (min-width: 640px)  { .pr-kpi-grid { grid-template-columns: repeat(2, 1fr); } }
        @media (min-width: 1024px) { .pr-kpi-grid { grid-template-columns: repeat(4, 1fr); } }

        .pr-kpi {
            border-radius: 1rem;
            padding: 1.25rem 1.375rem;
            border: 1px solid #e5e7eb;
            background: #ffffff;
            transition: transform .2s ease, box-shadow .2s ease;
            position: relative;
            overflow: hidden;
        }

        .pr-kpi::before {
            content: '';
            position: absolute;
            top: 0; left: 0; right: 0;
            height: 3px;
            background: #e5e7eb;
            border-radius: 1rem 1rem 0 0;
        }

        .pr-kpi:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 24px rgba(0,0,0,.08);
        }

        .dark .pr-kpi {
            background: #111827;
            border-color: #1f2937;
        }

        .dark .pr-kpi::before { background: #1f2937; }

        .pr-kpi-primary {
            background: linear-gradient(145deg, #fffbeb 0%, #fef3c7 100%);
            border-color: #fde68a;
        }

        .pr-kpi-primary::before { background: linear-gradient(90deg, #f59e0b, #d97706); }

        .dark .pr-kpi-primary {
            background: linear-gradient(145deg, #1c1709 0%, #231c0a 100%);
            border-color: #44370f;
        }

        .pr-kpi-label {
            font-size: .6875rem;
            font-weight: 700;
            letter-spacing: .06em;
            text-transform: uppercase;
            color: #64748b;
            display: flex;
            align-items: center;
            gap: .375rem;
        }

        .pr-kpi-primary .pr-kpi-label { color: #92400e; }

        .dark .pr-kpi-label { color: #94a3b8; }
        .dark .pr-kpi-primary .pr-kpi-label { color: #fbbf24; }

        .pr-kpi-value {
            font-size: 1.75rem;
            font-weight: 900;
            letter-spacing: -.03em;
            line-height: 1.1;
            margin-top: .625rem;
            color: #0f172a;
        }

        .pr-kpi-primary .pr-kpi-value { color: #92400e; }

        .dark .pr-kpi-value { color: #f8fafc; }
        .dark .pr-kpi-primary .pr-kpi-value { color: #fbbf24; }

        .pr-kpi-sub {
            font-size: .7rem;
            color: #94a3b8;
            margin-top: .375rem;
        }

        .pr-kpi-primary .pr-kpi-sub { color: #b45309; }
        .dark .pr-kpi-primary .pr-kpi-sub { color: #d97706; }

        /* ── Table ─────────────────────────────────────────────────────────────── */
        .pr-table-outer {
            border-radius: 1rem;
            border: 1px solid #e5e7eb;
            overflow: hidden;
            background: #ffffff;
            box-shadow: 0 1px 3px rgba(0,0,0,.04);
        }

        .dark .pr-table-outer {
            border-color: #1f2937;
            background: #111827;
        }

        .pr-tbl {
            width: 100%;
            border-collapse: collapse;
            font-size: .8125rem;
        }

        /* Header */
        .pr-tbl thead tr {
            background: #f8fafc;
            border-bottom: 1.5px solid #e2e8f0;
        }

        .dark .pr-tbl thead tr {
            background: #1e293b;
            border-color: #334155;
        }

        .pr-tbl th {
            padding: .75rem 1rem;
            font-size: .625rem;
            font-weight: 700;
            letter-spacing: .08em;
            text-transform: uppercase;
            color: #64748b;
            
        }

        .dark .pr-tbl th { color: #94a3b8; }

        /* Cells */
        .pr-tbl td {
            padding: .875rem 1rem;
            border-bottom: 1px solid #f1f5f9;
            color: #0f172a;
            vertical-align: middle;
        }

        .dark .pr-tbl td {
            border-color: #1e293b;
            color: #f1f5f9;
        }

        .pr-tbl tr.pr-row:last-child td { border-bottom: none; }

        .pr-tbl tr.pr-row:hover td {
            background: #fffbeb;
        }

        .dark .pr-tbl tr.pr-row:hover td {
            background: rgba(255,255,255,.025);
        }

        /* Sticky Columns */
        .pr-sticky-col-left {
            position: sticky; left: 0; background: #ffffff; z-index: 10;
            box-shadow: 4px 0 8px rgba(0,0,0,0.02);
        }
        .pr-sticky-col-right {
            position: sticky; right: 0; background: #ffffff; z-index: 10;
            box-shadow: -4px 0 8px rgba(0,0,0,0.02);
        }
        .dark .pr-sticky-col-left, .dark .pr-sticky-col-right {
            background: #111827;
            box-shadow: none;
        }
        
        /* Match hover state for sticky columns */
        .pr-tbl tr.pr-row:hover .pr-sticky-col-left,
        .pr-tbl tr.pr-row:hover .pr-sticky-col-right {
            background: #fffbeb;
        }
        
        .dark .pr-tbl tr.pr-row:hover .pr-sticky-col-left,
        .dark .pr-tbl tr.pr-row:hover .pr-sticky-col-right {
            background: #182030; /* slight lighter than #111827 for dark mode hover */
        }
        
        .pr-tbl thead .pr-sticky-col-left,
        .pr-tbl thead .pr-sticky-col-right {
            background: #f8fafc;
            z-index: 20;
        }
        
        .dark .pr-tbl thead .pr-sticky-col-left,
        .dark .pr-tbl thead .pr-sticky-col-right {
            background: #1e293b;
        }

        /* ── Expanded Breakdown ───────────────────────────────────────────────── */
        .pr-expand-cell {
            background: #f8fafc !important;
            border-top: 1.5px solid #e2e8f0;
            border-bottom: 1.5px solid #e2e8f0;
            padding: 0 !important;
        }

        .dark .pr-expand-cell {
            background: #0f172a !important;
            border-color: #1e293b;
        }

        .pr-expand-inner {
            padding: 1.125rem 1.25rem;
        }

        .pr-expand-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: .875rem;
        }

        .pr-expand-title {
            font-size: .6875rem;
            font-weight: 800;
            letter-spacing: .07em;
            text-transform: uppercase;
            color: #475569;
        }

        .dark .pr-expand-title { color: #94a3b8; }

        .pr-legend {
            display: flex;
            gap: .75rem;
        }

        .pr-legend-item {
            display: inline-flex;
            align-items: center;
            gap: .3rem;
            font-size: .65rem;
            color: #94a3b8;
            font-weight: 500;
        }

        .pr-legend-dot {
            width: 7px; height: 7px;
            border-radius: 50%;
            flex-shrink: 0;
        }

        /* Sub-table (daily) */
        .pr-sub-tbl {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0;
            font-size: .7875rem;
            border-radius: .625rem;
            overflow: hidden;
            border: 1px solid #e2e8f0;
            background: #ffffff;
        }

        .dark .pr-sub-tbl {
            border-color: #1e293b;
            background: #111827;
        }

        .pr-sub-tbl thead tr {
            background: #f1f5f9;
            border-bottom: 1px solid #e2e8f0;
        }

        .dark .pr-sub-tbl thead tr {
            background: #1e293b;
            border-color: #334155;
        }

        .pr-sub-tbl th {
            padding: .5625rem .875rem;
            font-size: .6rem;
            font-weight: 700;
            letter-spacing: .08em;
            text-transform: uppercase;
            color: #64748b;
            
        }

        .dark .pr-sub-tbl th { color: #94a3b8; }

        .pr-sub-tbl td {
            padding: .625rem .875rem;
            border-bottom: 1px solid #f1f5f9;
            color: #0f172a;
            vertical-align: middle;
        }

        .dark .pr-sub-tbl td {
            border-color: #1e293b;
            color: #f1f5f9;
        }

        .pr-sub-tbl tr:last-child td { border-bottom: none; }

        .pr-sub-tbl tr:hover td { background: rgba(245,158,11,.04); }

        /* ── Avatar ───────────────────────────────────────────────────────────── */
        .pr-avatar {
            width: 34px; height: 34px;
            border-radius: .5rem;
            background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
            color: #ffffff;
            font-weight: 800;
            font-size: .75rem;
            display: flex; align-items: center; justify-content: center;
            box-shadow: 0 2px 6px rgba(245,158,11,.3);
            flex-shrink: 0;
            letter-spacing: .02em;
        }

        /* ── Badges ───────────────────────────────────────────────────────────── */
        .pr-badge {
            display: inline-flex; align-items: center;
            padding: .175rem .45rem;
            border-radius: .375rem;
            font-size: .6rem;
            font-weight: 700;
            letter-spacing: .05em;
            text-transform: uppercase;
            line-height: 1;
        }

        .pr-badge-amber { background: #fef3c7; color: #92400e; }
        .pr-badge-red   { background: #fee2e2; color: #991b1b; }
        .pr-badge-blue  { background: #dbeafe; color: #1e40af; }
        .pr-badge-slate { background: #f1f5f9; color: #475569; border: 1px solid #e2e8f0; }

        .dark .pr-badge-amber { background: #78350f; color: #fef3c7; }
        .dark .pr-badge-red   { background: #7f1d1d; color: #fca5a5; }
        .dark .pr-badge-blue  { background: #1e3a8a; color: #bfdbfe; }
        .dark .pr-badge-slate { background: #1e293b; color: #94a3b8; border-color: #334155; }

        /* ── Action Button ────────────────────────────────────────────────────── */
        .pr-action-btn {
            display: inline-flex; align-items: center; gap: .3rem;
            padding: .375rem .75rem;
            border-radius: .5rem;
            font-size: .7rem;
            font-weight: 600;
            cursor: pointer;
            transition: all .15s ease;
            border: 1px solid #e2e8f0;
            background: #ffffff;
            color: #475569;
            letter-spacing: .01em;
        }

        .pr-action-btn:hover {
            background: #f8fafc;
            border-color: #cbd5e1;
            color: #0f172a;
        }

        .dark .pr-action-btn {
            background: #1e293b;
            border-color: #334155;
            color: #94a3b8;
        }

        .dark .pr-action-btn:hover {
            background: #334155;
            color: #f1f5f9;
        }

        /* ── Monospace numbers ────────────────────────────────────────────────── */
        .pr-num {
            font-family: ui-monospace, SFMono-Regular, Menlo, Monaco, Consolas, monospace;
            font-variant-numeric: tabular-nums;
            white-space: nowrap;
        }

        /* ── Empty state ──────────────────────────────────────────────────────── */
        .pr-empty {
            padding: 4rem 2rem;
            text-align: center;
        }

        .pr-empty-icon {
            width: 52px; height: 52px;
            margin: 0 auto .875rem;
            background: #f1f5f9;
            border-radius: 1rem;
            display: flex; align-items: center; justify-content: center;
            color: #94a3b8;
        }

        .dark .pr-empty-icon { background: #1e293b; }

        /* ── Divider ──────────────────────────────────────────────────────────── */
        .pr-divider {
            border: none;
            border-top: 1px solid #f1f5f9;
            margin: 0;
        }

        .dark .pr-divider { border-color: #1e293b; }

        /* ── Net Pay highlight cell ───────────────────────────────────────────── */
        .pr-net-cell {
            background: linear-gradient(90deg, transparent 0%, rgba(245,158,11,.06) 100%);
        }

        .dark .pr-net-cell {
            background: linear-gradient(90deg, transparent 0%, rgba(245,158,11,.08) 100%);
        }

        /* ── Mobile Responsive Tables ─────────────────────────────────────────── */
        @media (max-width: 1024px) {
            .pr-tbl, .pr-tbl thead, .pr-tbl tbody, .pr-tbl th, .pr-tbl td, .pr-tbl tr { display: block; }
            .pr-tbl thead tr { position: absolute; top: -9999px; left: -9999px; }
            .pr-tbl tr.pr-row { margin-bottom: 1rem; border: 1px solid #e2e8f0; border-radius: .75rem; background: #ffffff; box-shadow: 0 1px 3px rgba(0,0,0,.05); }
            .dark .pr-tbl tr.pr-row { background: #1e293b; border-color: #334155; }
            .pr-tbl td { border: none; border-bottom: 1px solid #f1f5f9; position: relative; padding: .75rem 1rem .75rem 40% !important; text-align: right !important; min-height: 3rem; }
            .dark .pr-tbl td { border-color: #334155; }
            .pr-tbl td:before { position: absolute; top: 50%; transform: translateY(-50%); left: 1rem; width: 35%; padding-right: 10px; font-size: .625rem; font-weight: 700; text-transform: uppercase; color: #64748b; text-align: left; }
            .dark .pr-tbl td:before { color: #94a3b8; }
            .pr-tbl tr.pr-row td:last-child { border-bottom: 0; }
            
            .pr-tbl td:nth-of-type(1):before { content: "Employee"; }
            .pr-tbl td:nth-of-type(2):before { content: "Daily Rate"; }
            .pr-tbl td:nth-of-type(3):before { content: "Reg / OT Hours"; }
            .pr-tbl td:nth-of-type(4):before { content: "Regular Pay"; }
            .pr-tbl td:nth-of-type(5):before { content: "OT Pay"; }
            .pr-tbl td:nth-of-type(6):before { content: "Allowances"; }
            .pr-tbl td:nth-of-type(7):before { content: "Gross"; }
            .pr-tbl td:nth-of-type(8):before { content: "Govt Ded."; }
            .pr-tbl td:nth-of-type(9):before { content: "Other Ded."; }
            .pr-tbl td:nth-of-type(10):before { content: "Net Payable"; }
            .pr-tbl td:nth-of-type(11):before { content: "Action"; }

            .pr-tbl td:nth-of-type(1) > div { justify-content: flex-end; text-align: right; }
            .pr-tbl td:nth-of-type(1) > div > div { text-align: right; }
            
            /* Make action button right aligned */
            .pr-tbl td:nth-of-type(11) > button { float: right; margin-bottom: .25rem; }

            .pr-sub-tbl, .pr-sub-tbl thead, .pr-sub-tbl tbody, .pr-sub-tbl th, .pr-sub-tbl td, .pr-sub-tbl tr { display: block; }
            .pr-sub-tbl thead tr { position: absolute; top: -9999px; left: -9999px; }
            .pr-sub-tbl tr { margin-bottom: .75rem; border: 1px solid #e2e8f0; border-radius: .5rem; }
            .dark .pr-sub-tbl tr { border-color: #334155; }
            .pr-sub-tbl td { border: none; border-bottom: 1px solid #f1f5f9; position: relative; padding: .625rem 1rem .625rem 40% !important; text-align: right !important; min-height: 2.5rem; }
            .dark .pr-sub-tbl td { border-color: #334155; }
            .pr-sub-tbl td:before { position: absolute; top: 50%; transform: translateY(-50%); left: 1rem; width: 35%; padding-right: 10px; font-size: .6rem; font-weight: 700; text-transform: uppercase; color: #64748b; text-align: left; }
            .dark .pr-sub-tbl td:before { color: #94a3b8; }
            
            .pr-sub-tbl td:nth-of-type(1):before { content: "Date"; }
            .pr-sub-tbl td:nth-of-type(2):before { content: "Time In"; }
            .pr-sub-tbl td:nth-of-type(3):before { content: "Time Out"; }
            .pr-sub-tbl td:nth-of-type(4):before { content: "Gross Hrs"; }
            .pr-sub-tbl td:nth-of-type(5):before { content: "Breaks"; }
            .pr-sub-tbl td:nth-of-type(6):before { content: "Reg Hrs"; }
            .pr-sub-tbl td:nth-of-type(7):before { content: "OT Hrs"; }
            .pr-sub-tbl td:nth-of-type(8):before { content: "Reg Pay"; }
            .pr-sub-tbl td:nth-of-type(9):before { content: "OT Pay"; }
            .pr-sub-tbl td:nth-of-type(10):before { content: "Allowance"; }
            .pr-sub-tbl td:nth-of-type(11):before { content: "Deduction"; }
            .pr-sub-tbl td:nth-of-type(12):before { content: "Day Total"; }

            .pr-tbl td.pr-expand-cell { padding: 0 !important; border-bottom: none !important; }
            .pr-tbl td.pr-expand-cell:before { content: none !important; }
            .pr-expand-inner { padding: 1rem; }
            
            .pr-sticky-col-left, .pr-sticky-col-right { position: static; box-shadow: none !important; }
        }
    </style>

    <div class="pr-wrap space-y-5">

        {{-- ╔═ Controls Panel ══════════════════════════════════════════════════╗ --}}
        <div class="pr-panel">
            <div class="pr-panel-body">

                {{-- Header row --}}
                <div class="flex flex-col sm:flex-row sm:items-start sm:justify-between gap-4 mb-5">
                    <div class="pr-header">
                        <div class="pr-header-title">
                            <span class="pr-header-icon">
                                <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                            </span>
                            Payroll Processing
                        </div>
                        <p class="pr-header-sub">Bimonthly cutoff — every 15th &amp; 30th of the month</p>
                    </div>

                    {{-- Cutoff segmented control --}}
                    <div class="pr-seg shrink-0">
                        <button type="button"
                            wire:click="$set('selectedCutoff', '1-15')"
                            class="pr-seg-btn {{ $selectedCutoff === '1-15' ? 'pr-seg-btn-on' : 'pr-seg-btn-off' }}">
                            1st – 15th
                        </button>
                        <button type="button"
                            wire:click="$set('selectedCutoff', '16-30')"
                            class="pr-seg-btn {{ $selectedCutoff === '16-30' ? 'pr-seg-btn-on' : 'pr-seg-btn-off' }}">
                            16th – 30th
                        </button>
                    </div>
                </div>

                <hr class="pr-divider mb-5">

                {{-- Filter row --}}
                <div class="pr-filter-grid">

                    {{-- Year --}}
                    <div>
                        <label class="pr-label">Year</label>
                        <div class="pr-select-wrap">
                            <select wire:model.live="selectedYear" class="pr-select">
                                @foreach($years as $year)
                                    <option value="{{ $year }}">{{ $year }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    {{-- Month --}}
                    <div>
                        <label class="pr-label">Month</label>
                        <div class="pr-select-wrap">
                            <select wire:model.live="selectedMonth" class="pr-select">
                                @foreach($months as $num => $name)
                                    <option value="{{ $num }}">{{ $name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    {{-- Employee --}}
                    <div>
                        <label class="pr-label">Employee</label>
                        <div class="pr-select-wrap">
                            <select wire:model.live="selectedEmployeeId" class="pr-select">
                                <option value="">All Employees</option>
                                @foreach($allEmployees as $emp)
                                    <option value="{{ $emp->id }}">{{ $emp->last_name }}, {{ $emp->first_name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    {{-- Search --}}
                    <div>
                        <label class="pr-label">Quick Search</label>
                        <div class="pr-search-wrap">
                            <input type="text"
                                wire:model.live.debounce.250ms="searchQuery"
                                placeholder="Name or position…"
                                class="pr-input-text"
                                style="padding-left: 2.25rem;" />
                            <svg class="pr-search-icon"
                                width="15" height="15" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                            </svg>
                        </div>
                    </div>

                </div>
            </div>
        </div>

        {{-- ╔═ KPI Summary Cards ═══════════════════════════════════════════════╗ --}}
        <div class="pr-kpi-grid">

            {{-- Total Net Payable --}}
            <div class="pr-kpi pr-kpi-primary">
                <div class="pr-kpi-label">
                    <svg width="13" height="13" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                            d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    Total Net Payable
                </div>
                <div class="pr-kpi-value pr-num">
                    ₱{{ number_format($payrollData['grand_summary']['total_net_payable'], 2) }}
                </div>
                <div class="pr-kpi-sub">
                    {{ Carbon\Carbon::parse($payrollData['start_date'])->format('M d') }}
                    –
                    {{ Carbon\Carbon::parse($payrollData['end_date'])->format('M d, Y') }}
                </div>
            </div>

            {{-- Gross Payroll --}}
            <div class="pr-kpi">
                <div class="pr-kpi-label">
                    <svg width="13" height="13" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                            d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z"/>
                    </svg>
                    Gross Payroll
                </div>
                <div class="pr-kpi-value pr-num">
                    ₱{{ number_format($payrollData['grand_summary']['total_gross_pay'], 2) }}
                </div>
                <div class="pr-kpi-sub">Before deductions &amp; contributions</div>
            </div>

            {{-- Total Work Hours --}}
            <div class="pr-kpi">
                <div class="pr-kpi-label">
                    <svg width="13" height="13" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                            d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    Work Hours
                </div>
                <div class="pr-kpi-value pr-num">
                    {{ number_format($payrollData['grand_summary']['total_regular_hours'], 1) }}
                    <span style="font-size:.95rem; font-weight:600; color:#94a3b8;">hrs</span>
                </div>
                <div class="pr-kpi-sub">
                    Overtime:
                    <span style="color:#d97706; font-weight:700;">
                        {{ number_format($payrollData['grand_summary']['total_ot_hours'], 1) }} hrs
                    </span>
                </div>
            </div>

            {{-- Employees Processed --}}
            <div class="pr-kpi">
                <div class="pr-kpi-label">
                    <svg width="13" height="13" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                            d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                    </svg>
                    Employees
                </div>
                <div class="pr-kpi-value">
                    {{ $payrollData['grand_summary']['total_employees'] }}
                </div>
                <div class="pr-kpi-sub">Active staff this period</div>
            </div>

        </div>

        {{-- ╔═ Main Payroll Table ═══════════════════════════════════════════════╗ --}}
        @if(empty($payrollData['employees']))
            <div class="pr-panel">
                <div class="pr-empty">
                    <div class="pr-empty-icon">
                        <svg width="26" height="26" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                        </svg>
                    </div>
                    <h3 style="font-size:1rem; font-weight:700; color:#0f172a;" class="dark:text-white">No Employees Found</h3>
                    <p style="font-size:.75rem; color:#94a3b8; margin-top:.375rem;">
                        Try clearing your search or selecting a different cutoff period.
                    </p>
                </div>
            </div>
        @else
            <div class="pr-table-outer" x-data="{ 
                expanded: {},
                printData: null,
                printStartDate: null,
                printEndDate: null,
                printPayslip(empData, startDate, endDate) {
                    this.printData = empData;
                    this.printStartDate = startDate;
                    this.printEndDate = endDate;
                    setTimeout(() => { window.print(); }, 150);
                }
            }">
                <div class="overflow-x-auto">
                    <table class="pr-tbl">
                        <thead>
                            <tr>
                                <th class="pr-sticky-col-left" style="min-width:180px;">Employee</th>
                                <th class="text-center">Daily Rate</th>
                                <th class="text-center">Reg / OT Hours</th>
                                <th class="text-right">Regular Pay</th>
                                <th class="text-right">OT Pay</th>
                                <th class="text-right">Allowances</th>
                                <th class="text-right">Gross</th>
                                <th class="text-right">Govt Ded.</th>
                                <th class="text-right">Other Ded.</th>
                                <th class="text-right" style="min-width:180px; padding-right: 3rem;">Net Payable</th>
                                <th class="pr-sticky-col-right text-center" style="min-width:120px;"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($payrollData['employees'] as $emp)
                                {{-- ── Employee summary row ── --}}
                                <tr class="pr-row">
                                    <td class="pr-sticky-col-left" style="">
                                        <div style="display:flex; align-items:center; gap:.75rem;">
                                            <div class="pr-avatar">
                                                {{ strtoupper(substr($emp['employee_name'], 0, 1)) }}
                                            </div>
                                            <div>
                                                <div style="font-weight:700; font-size:.8125rem; color:inherit; line-height:1.3;">
                                                    {{ $emp['employee_name'] }}
                                                </div>
                                                <span class="pr-badge pr-badge-slate" style="margin-top:.2rem;">
                                                    {{ $emp['position_name'] }}
                                                </span>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="text-center" style="">
                                        <div class="pr-num" style="font-weight:600; font-size:.8125rem;">
                                            ₱{{ number_format($emp['base_rate'], 2) }}
                                        </div>
                                        <div style="font-size:.6875rem; color:#94a3b8; margin-top:.1rem;">
                                            ₱{{ number_format($emp['overtime_rate'], 2) }}/hr OT
                                        </div>
                                    </td>
                                    <td class="text-center" style="">
                                        <div class="pr-num" style="font-weight:700;">
                                            {{ $emp['total_regular_hours'] }} hrs
                                        </div>
                                        <div class="pr-num" style="font-size:.6875rem; color:#d97706; font-weight:600; margin-top:.1rem;">
                                            +{{ $emp['total_ot_hours'] }} hrs OT
                                        </div>
                                    </td>
                                    <td class="text-right pr-num" style=" color:#374151;">
                                        ₱{{ number_format($emp['total_regular_pay'], 2) }}
                                    </td>
                                    <td class="text-right pr-num" style=" color:#d97706; font-weight:600;">
                                        ₱{{ number_format($emp['total_ot_pay'], 2) }}
                                    </td>
                                    <td class="text-right pr-num" style=" color:#16a34a; font-weight:600;">
                                        +₱{{ number_format($emp['total_allowance'] + $emp['total_extra_income'], 2) }}
                                    </td>
                                    <td class="text-right pr-num" style=" font-weight:700;">
                                        ₱{{ number_format($emp['gross_pay'], 2) }}
                                    </td>
                                    <td class="text-right pr-num" style=" color:#dc2626;">
                                        −₱{{ number_format($emp['total_govt_deductions'], 2) }}
                                    </td>
                                    <td class="text-right pr-num" style=" color:#dc2626;">
                                        −₱{{ number_format($emp['total_deductions'], 2) }}
                                    </td>
                                    <td class="text-right pr-num pr-net-cell" style=" font-weight:900; font-size:.875rem; color:#b45309; padding-right: 3rem;">
                                        ₱{{ number_format($emp['net_pay'], 2) }}
                                    </td>
                                    <td class="pr-sticky-col-right text-center" style="">
                                        <button type="button"
                                            @click="expanded[{{ $emp['id'] }}] = !expanded[{{ $emp['id'] }}]"
                                            class="pr-action-btn">
                                            <svg width="12" height="12" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                                class="transition-transform duration-200"
                                                :class="expanded[{{ $emp['id'] }}] ? 'rotate-180' : ''">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7"/>
                                            </svg>
                                            <span x-text="expanded[{{ $emp['id'] }}] ? 'Collapse' : 'Details'"></span>
                                        </button>
                                    </td>
                                </tr>

                                {{-- ── Expandable daily breakdown ── --}}
                                <tr x-show="expanded[{{ $emp['id'] }}]" x-collapse>
                                    <td colspan="11" class="pr-expand-cell">
                                        <div class="pr-expand-inner">
                                            <div class="pr-expand-header">
                                                <div style="display:flex; align-items:center; gap:1rem;">
                                                    <div class="pr-expand-title">
                                                        Daily Attendance Log — {{ $emp['employee_name'] }}
                                                    </div>
                                                    <button type="button" class="pr-action-btn" style="padding:.25rem .5rem;" @click="printPayslip({{ json_encode($emp) }}, '{{ $payrollData['start_date'] }}', '{{ $payrollData['end_date'] }}')">
                                                        <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" />
                                                        </svg>
                                                        Print
                                                    </button>
                                                </div>
                                                <div class="pr-legend">
                                                    <span class="pr-legend-item">
                                                        <span class="pr-legend-dot" style="background:#ef4444;"></span>
                                                        Late (&gt;8:45 AM)
                                                    </span>
                                                    <span class="pr-legend-item">
                                                        <span class="pr-legend-dot" style="background:#f59e0b;"></span>
                                                        Midday Clamped
                                                    </span>
                                                </div>
                                            </div>

                                            <div>
                                                <table class="pr-sub-tbl">
                                                    <thead>
                                                        <tr>
                                                            <th>Date</th>
                                                            <th>Time In</th>
                                                            <th>Time Out</th>
                                                            <th class="text-center">Gross Hrs</th>
                                                            <th class="text-center">Breaks</th>
                                                            <th class="text-center">Reg Hrs</th>
                                                            <th class="text-center">OT Hrs</th>
                                                            <th class="text-right">Reg Pay</th>
                                                            <th class="text-right">OT Pay</th>
                                                            <th class="text-right">Allowance</th>
                                                            <th class="text-right">Deduction</th>
                                                            <th class="text-right">Day Total</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach($emp['days'] as $day)
                                                            <tr style="{{ $day['is_absent'] ? 'background:rgba(239,68,68,.04);' : ($day['is_on_leave'] ? 'background:rgba(59,130,246,.04);' : '') }}">
                                                                <td style="font-weight:600; ">
                                                                    {{ Carbon\Carbon::parse($day['date'])->format('M d (D)') }}
                                                                    @if($day['is_late'])
                                                                        <span class="pr-badge pr-badge-red" style="margin-left:.3rem;">Late</span>
                                                                    @endif
                                                                    @if($day['is_on_leave'])
                                                                        <span class="pr-badge pr-badge-blue" style="margin-left:.3rem;">Leave</span>
                                                                    @endif
                                                                    @if($day['is_absent'])
                                                                        <span class="pr-badge pr-badge-slate" style="margin-left:.3rem;">No Log</span>
                                                                    @endif
                                                                </td>
                                                                <td style="">
                                                                    {{ $day['time_in'] ? Carbon\Carbon::parse($day['time_in'])->format('h:i A') : '—' }}
                                                                    @if($day['time_adjusted'])
                                                                        <span style="font-size:.6rem; color:#d97706; font-weight:700;" title="Adjusted to 1:00 PM">(1:00 PM)</span>
                                                                    @endif
                                                                </td>
                                                                <td style="">
                                                                    {{ $day['time_out'] ? Carbon\Carbon::parse($day['time_out'])->format('h:i A') : '—' }}
                                                                </td>
                                                                <td class="text-center pr-num">{{ $day['gross_hours'] > 0 ? $day['gross_hours'] : '—' }}</td>
                                                                <td class="text-center pr-num" style="color:#94a3b8;">
                                                                    @if($day['total_breaks'] > 0)
                                                                        {{ $day['total_breaks'] }}h
                                                                    @else
                                                                        —
                                                                    @endif
                                                                </td>
                                                                <td class="text-center pr-num" style="font-weight:600;">
                                                                    {{ $day['regular_hours'] > 0 ? $day['regular_hours'] : '—' }}
                                                                </td>
                                                                <td class="text-center pr-num" style="color:#d97706; font-weight:600;">
                                                                    {{ $day['ot_hours'] > 0 ? $day['ot_hours'] : '—' }}
                                                                </td>
                                                                <td class="text-right pr-num">₱{{ number_format($day['regular_pay'], 2) }}</td>
                                                                <td class="text-right pr-num" style="color:#d97706;">₱{{ number_format($day['ot_pay'], 2) }}</td>
                                                                <td class="text-right pr-num" style="color:#16a34a;">
                                                                    ₱{{ number_format($day['allowance'] + $day['extra_income'], 2) }}
                                                                </td>
                                                                <td class="text-right pr-num" style="color:#dc2626;">
                                                                    −₱{{ number_format($day['deduction'], 2) }}
                                                                </td>
                                                                <td class="text-right pr-num" style="font-weight:800;">
                                                                    ₱{{ number_format($day['day_total'], 2) }}
                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                {{-- ── Print Overlay ── --}}
                <template x-teleport="body">
                    <div class="pr-print-overlay" x-show="printData" style="display: none;">
                        <div class="pr-print-header">
                            <h2>Truant Enterprises Payroll</h2>
                            <p>Payslip for the period of <strong x-text="printStartDate"></strong> to <strong x-text="printEndDate"></strong></p>
                        </div>
                        <div class="pr-print-emp-details">
                            <div><strong>Employee:</strong> <span x-text="printData?.employee_name"></span></div>
                            <div><strong>Position:</strong> <span x-text="printData?.position_name"></span></div>
                            <div><strong>Base Rate:</strong> ₱<span x-text="parseFloat(printData?.base_rate || 0).toFixed(2)"></span></div>
                            <div><strong>OT Rate:</strong> ₱<span x-text="parseFloat(printData?.overtime_rate || 0).toFixed(2)"></span>/hr</div>
                        </div>

                        <table class="pr-print-tbl">
                            <thead>
                                <tr>
                                    <th>Date</th>
                                    <th>Time In</th>
                                    <th>Time Out</th>
                                    <th class="text-center">Gross Hrs</th>
                                    <th class="text-center">Breaks</th>
                                    <th class="text-center">Reg Hrs</th>
                                    <th class="text-center">OT Hrs</th>
                                    <th class="text-right">Reg Pay</th>
                                    <th class="text-right">OT Pay</th>
                                    <th class="text-right">Allowance</th>
                                    <th class="text-right">Deduction</th>
                                    <th class="text-right">Day Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                <template x-for="day in (printData?.days || [])" :key="day.date">
                                    <tr>
                                        <td x-text="new Date(day.date).toLocaleDateString('en-US', {month: 'short', day: 'numeric', weekday: 'short'})"></td>
                                        <td x-text="day.time_in ? (parseInt(day.time_in.substring(0,2)) % 12 || 12) + ':' + day.time_in.substring(3,5) + (parseInt(day.time_in.substring(0,2)) >= 12 ? ' PM' : ' AM') : '—'"></td>
                                        <td x-text="day.time_out ? (parseInt(day.time_out.substring(0,2)) % 12 || 12) + ':' + day.time_out.substring(3,5) + (parseInt(day.time_out.substring(0,2)) >= 12 ? ' PM' : ' AM') : '—'"></td>
                                        <td class="text-center" x-text="day.gross_hours > 0 ? day.gross_hours : '—'"></td>
                                        <td class="text-center" x-text="day.total_breaks > 0 ? day.total_breaks + 'h' : '—'"></td>
                                        <td class="text-center" x-text="day.regular_hours > 0 ? day.regular_hours : '—'"></td>
                                        <td class="text-center" x-text="day.ot_hours > 0 ? day.ot_hours : '—'"></td>
                                        <td class="text-right" x-text="day.regular_pay > 0 ? '₱' + parseFloat(day.regular_pay).toFixed(2) : '—'"></td>
                                        <td class="text-right" x-text="day.ot_pay > 0 ? '₱' + parseFloat(day.ot_pay).toFixed(2) : '—'"></td>
                                        <td class="text-right" x-text="(day.allowance + day.extra_income) > 0 ? '₱' + parseFloat(day.allowance + day.extra_income).toFixed(2) : '—'"></td>
                                        <td class="text-right" x-text="day.deduction > 0 ? '−₱' + parseFloat(day.deduction).toFixed(2) : '—'"></td>
                                        <td class="text-right" style="font-weight:bold;" x-text="'₱' + parseFloat(day.day_total).toFixed(2)"></td>
                                    </tr>
                                </template>
                            </tbody>
                        </table>

                        <div class="pr-print-summary">
                            <div class="pr-print-summary-item">
                                <strong>Reg / OT Hours</strong>
                                <span><span x-text="printData?.total_regular_hours || 0"></span> / <span x-text="printData?.total_ot_hours || 0"></span> <span style="font-size: 0.75rem; font-weight:normal;">hrs</span></span>
                            </div>
                            <div class="pr-print-summary-item">
                                <strong>Regular Pay</strong>
                                <span>₱<span x-text="parseFloat(printData?.total_regular_pay || 0).toFixed(2)"></span></span>
                            </div>
                            <div class="pr-print-summary-item">
                                <strong>OT Pay</strong>
                                <span>₱<span x-text="parseFloat(printData?.total_ot_pay || 0).toFixed(2)"></span></span>
                            </div>
                            <div class="pr-print-summary-item">
                                <strong>Allowances</strong>
                                <span>₱<span x-text="parseFloat((printData?.total_allowance || 0) + (printData?.total_extra_income || 0)).toFixed(2)"></span></span>
                            </div>
                            <div class="pr-print-summary-item">
                                <strong>Gross Pay</strong>
                                <span>₱<span x-text="parseFloat(printData?.gross_pay || 0).toFixed(2)"></span></span>
                            </div>
                            <div class="pr-print-summary-item">
                                <strong>Govt Ded.</strong>
                                <span>−₱<span x-text="parseFloat(printData?.total_govt_deductions || 0).toFixed(2)"></span></span>
                            </div>
                            <div class="pr-print-summary-item">
                                <strong>Other Ded.</strong>
                                <span>−₱<span x-text="parseFloat(printData?.total_deductions || 0).toFixed(2)"></span></span>
                            </div>
                            <div class="pr-print-summary-item pr-print-net">
                                <strong style="color: #0f172a;">Net Payable</strong>
                                <span>₱<span x-text="parseFloat(printData?.net_pay || 0).toFixed(2)"></span></span>
                            </div>
                        </div>

                        <div class="pr-print-footer">
                            <p>I hereby acknowledge receipt of the above payroll computation and confirm that it is true and correct to the best of my knowledge.</p>
                            <div class="pr-print-signature">
                                <div>
                                    <div class="pr-line"></div>
                                    <p>Employee Signature</p>
                                </div>
                                <div>
                                    <div class="pr-line"></div>
                                    <p>Date</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </template>

            </div>
        @endif

    </div>
</x-filament-panels::page>
