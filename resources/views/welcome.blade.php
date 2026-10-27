<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Truant Enterprises — Upcoming Events & Registrations</title>
    <meta name="description" content="Discover and register for upcoming conferences, summits, and corporate events on Truant Enterprises. Check real-time dates and registration availability.">

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Space+Grotesk:wght@600;700&display=swap" rel="stylesheet">

    <style>
        :root {
            --bg-page: #ffffff;
            --bg-subtle: #f8fafc;
            --bg-card: #ffffff;
            --border-color: #e2e8f0;
            --border-hover: #cbd5e1;
            --text-title: #0f172a;
            --text-body: #334155;
            --text-muted: #64748b;
            --text-light: #94a3b8;
            --primary: #4f46e5;
            --primary-hover: #4338ca;
            --primary-light: #eef2ff;
            --success-bg: #ecfdf5;
            --success-text: #065f46;
            --success-border: #a7f3d0;
            --warning-bg: #fffbeb;
            --warning-text: #92400e;
            --warning-border: #fde68a;
            --danger-bg: #fef2f2;
            --danger-text: #991b1b;
            --danger-border: #fecaca;
            --radius-md: 10px;
            --radius-lg: 16px;
            --shadow-sm: 0 1px 3px rgba(0, 0, 0, 0.05), 0 1px 2px rgba(0, 0, 0, 0.03);
            --shadow-md: 0 4px 16px -2px rgba(0, 0, 0, 0.06), 0 2px 6px -1px rgba(0, 0, 0, 0.04);
            --shadow-hover: 0 16px 32px -4px rgba(15, 23, 42, 0.08), 0 4px 12px -2px rgba(15, 23, 42, 0.04);
            --font-sans: 'Plus Jakarta Sans', system-ui, -apple-system, sans-serif;
            --font-display: 'Space Grotesk', var(--font-sans);
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        html, body {
            min-height: 100vh;
            background-color: var(--bg-page);
            color: var(--text-body);
            font-family: var(--font-sans);
            line-height: 1.6;
            -webkit-font-smoothing: antialiased;
        }

        .site-wrapper {
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        /* ─── Header ─────────────────────────────────────────────── */
        header.site-header {
            position: sticky;
            top: 0;
            z-index: 50;
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(12px);
            border-bottom: 1px solid var(--border-color);
            transition: all 0.2s ease;
        }

        .header-container {
            max-width: 1240px;
            margin: 0 auto;
            padding: 16px 24px;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .brand-link {
            display: flex;
            align-items: center;
            gap: 12px;
            text-decoration: none;
            color: var(--text-title);
        }

        .brand-logo-icon {
            width: 40px;
            height: 40px;
            border-radius: 10px;
            background: linear-gradient(135deg, var(--primary) 0%, #3b82f6 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            color: #ffffff;
            box-shadow: 0 4px 10px rgba(79, 70, 229, 0.25);
        }

        .brand-info {
            display: flex;
            flex-direction: column;
        }

        .brand-title {
            font-family: var(--font-display);
            font-size: 1.25rem;
            font-weight: 700;
            color: var(--text-title);
            letter-spacing: -0.02em;
            line-height: 1.2;
        }

        .brand-subtitle {
            font-size: 0.75rem;
            font-weight: 600;
            color: var(--text-muted);
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }

        nav.header-nav {
            display: flex;
            align-items: center;
            gap: 20px;
        }

        .nav-link {
            text-decoration: none;
            color: var(--text-body);
            font-size: 0.925rem;
            font-weight: 600;
            padding: 8px 14px;
            border-radius: 8px;
            transition: all 0.15s ease;
        }

        .nav-link:hover {
            color: var(--primary);
            background: var(--bg-subtle);
        }

        .nav-link.active {
            color: var(--primary);
            background: var(--primary-light);
        }

        .header-actions {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            padding: 9px 18px;
            font-size: 0.9rem;
            font-weight: 600;
            border-radius: var(--radius-md);
            text-decoration: none;
            cursor: pointer;
            transition: all 0.2s cubic-bezier(0.16, 1, 0.3, 1);
            border: 1px solid transparent;
        }

        .btn-outline {
            color: var(--text-body);
            background: #ffffff;
            border-color: var(--border-color);
        }

        .btn-outline:hover {
            background: var(--bg-subtle);
            border-color: var(--border-hover);
            color: var(--text-title);
        }

        .btn-primary {
            background: var(--primary);
            color: #ffffff;
            box-shadow: 0 2px 8px rgba(79, 70, 229, 0.25);
        }

        .btn-primary:hover {
            background: var(--primary-hover);
            box-shadow: 0 4px 14px rgba(79, 70, 229, 0.35);
            transform: translateY(-1px);
        }

        /* ─── Hero Intro Section ──────────────────────────────────── */
        section.hero-section {
            background: linear-gradient(180deg, #ffffff 0%, var(--bg-subtle) 100%);
            border-bottom: 1px solid var(--border-color);
            padding: 56px 24px 44px;
            text-align: center;
        }

        .hero-container {
            max-width: 860px;
            margin: 0 auto;
        }

        .hero-pill {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 6px 14px;
            border-radius: 9999px;
            background: #ffffff;
            border: 1px solid var(--border-color);
            box-shadow: var(--shadow-sm);
            color: var(--primary);
            font-size: 0.85rem;
            font-weight: 600;
            margin-bottom: 18px;
        }

        .hero-title {
            font-family: var(--font-display);
            font-size: clamp(2rem, 4.5vw, 3rem);
            font-weight: 800;
            color: var(--text-title);
            line-height: 1.2;
            letter-spacing: -0.03em;
            margin-bottom: 16px;
        }

        .hero-description {
            font-size: 1.1rem;
            color: var(--text-muted);
            line-height: 1.6;
            margin-bottom: 24px;
        }

        .hero-stats {
            display: flex;
            justify-content: center;
            gap: 32px;
            margin-top: 20px;
        }

        .stat-item {
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 0.925rem;
            font-weight: 600;
            color: var(--text-body);
        }

        .stat-dot {
            width: 8px;
            height: 8px;
            border-radius: 50%;
            background: #10b981;
            box-shadow: 0 0 8px rgba(16, 185, 129, 0.6);
        }

        /* ─── Main Content / Events Grid ──────────────────────────── */
        main.main-content {
            flex: 1;
            max-width: 1240px;
            width: 100%;
            margin: 0 auto;
            padding: 48px 24px 72px;
        }

        .section-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 36px;
        }

        .section-heading-group {
            display: flex;
            flex-direction: column;
        }

        .section-title {
            font-family: var(--font-display);
            font-size: 1.65rem;
            font-weight: 700;
            color: var(--text-title);
            letter-spacing: -0.02em;
        }

        .section-subtitle {
            font-size: 0.95rem;
            color: var(--text-muted);
        }

        .events-count-badge {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 6px 12px;
            background: var(--bg-subtle);
            border: 1px solid var(--border-color);
            border-radius: 8px;
            font-size: 0.85rem;
            font-weight: 600;
            color: var(--text-body);
        }

        /* ─── 2 Cards Per Row Grid ────────────────────────────────── */
        .events-grid {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 32px;
            margin-bottom: 48px;
        }

        /* ─── Event Card (Equal Height & Size) ────────────────────── */
        .event-card {
            background: var(--bg-card);
            border: 1px solid var(--border-color);
            border-radius: var(--radius-lg);
            overflow: hidden;
            box-shadow: var(--shadow-md);
            transition: all 0.25s cubic-bezier(0.16, 1, 0.3, 1);
            display: flex;
            flex-direction: column;
            height: 100%;
        }

        .event-card:hover {
            transform: translateY(-4px);
            border-color: var(--border-hover);
            box-shadow: var(--shadow-hover);
        }

        /* Fixed Banner Display */
        .card-banner-wrapper {
            position: relative;
            width: 100%;
            height: 220px;
            background-color: #f1f5f9;
            overflow: hidden;
        }

        .card-banner-img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.4s ease;
        }

        .event-card:hover .card-banner-img {
            transform: scale(1.03);
        }

        /* Fallback Graphic Banner if No Image */
        .card-banner-fallback {
            width: 100%;
            height: 100%;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            background: linear-gradient(135deg, #1e293b 0%, #0f172a 100%);
            color: #ffffff;
            padding: 20px;
            text-align: center;
        }

        .card-banner-fallback svg {
            width: 44px;
            height: 44px;
            opacity: 0.6;
            margin-bottom: 8px;
        }

        /* Status Badge on Banner */
        .card-status-badge {
            position: absolute;
            top: 16px;
            right: 16px;
            padding: 6px 12px;
            border-radius: 9999px;
            font-size: 0.8rem;
            font-weight: 700;
            letter-spacing: 0.02em;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.12);
            backdrop-filter: blur(8px);
            z-index: 2;
        }

        .badge-open {
            background: rgba(236, 253, 245, 0.95);
            color: var(--success-text);
            border: 1px solid var(--success-border);
        }

        .badge-upcoming {
            background: rgba(255, 251, 235, 0.95);
            color: var(--warning-text);
            border: 1px solid var(--warning-border);
        }

        .badge-closed {
            background: rgba(241, 245, 249, 0.95);
            color: var(--text-muted);
            border: 1px solid var(--border-color);
        }

        .live-dot {
            width: 6px;
            height: 6px;
            border-radius: 50%;
            background: #10b981;
            box-shadow: 0 0 6px #10b981;
        }

        /* Card Content Area */
        .card-body {
            flex: 1;
            display: flex;
            flex-direction: column;
            padding: 24px;
        }

        /* Date & Timeline meta */
        .card-meta-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 12px;
            gap: 12px;
        }

        .event-date-chip {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            font-size: 0.875rem;
            font-weight: 700;
            color: var(--primary);
        }

        .event-date-chip svg {
            width: 16px;
            height: 16px;
        }

        .registration-deadline {
            font-size: 0.8rem;
            color: var(--text-muted);
            font-weight: 500;
        }

        /* Admission Badge Pill */
        .admission-pill {
            display: inline-flex;
            align-items: center;
            gap: 4px;
            font-size: 0.78rem;
            font-weight: 700;
            padding: 3px 9px;
            border-radius: 6px;
            letter-spacing: 0.01em;
            white-space: nowrap;
        }

        .admission-free {
            background: #ecfdf5;
            color: #065f46;
            border: 1px solid #a7f3d0;
        }

        .admission-paid {
            background: #eff6ff;
            color: #1d4ed8;
            border: 1px solid #bfdbfe;
        }

        .desc-admission-highlight {
            font-weight: 700;
            color: var(--text-title);
            margin-right: 4px;
        }

        .desc-admission-val-free {
            color: #059669;
            font-weight: 700;
        }

        .desc-admission-val-paid {
            color: #2563eb;
            font-weight: 700;
        }

        /* Title */
        .card-event-title {
            font-family: var(--font-display);
            font-size: 1.3rem;
            font-weight: 700;
            color: var(--text-title);
            line-height: 1.35;
            margin-bottom: 12px;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        .card-event-title a {
            color: inherit;
            text-decoration: none;
            transition: color 0.15s ease;
        }

        .card-event-title a:hover {
            color: var(--primary);
        }

        /* Clamped Description for Uniform Card Sizing */
        .card-event-desc {
            font-size: 0.925rem;
            color: var(--text-body);
            line-height: 1.55;
            margin-bottom: 24px;
            display: -webkit-box;
            -webkit-line-clamp: 3;
            -webkit-box-orient: vertical;
            overflow: hidden;
            min-height: 4.3em;
        }

        /* Bottom Action Footer */
        .card-footer-action {
            margin-top: auto;
            padding-top: 18px;
            border-top: 1px solid var(--border-color);
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
        }

        .btn-card-action {
            width: 100%;
            padding: 11px 18px;
            font-size: 0.925rem;
            font-weight: 600;
            border-radius: 8px;
            text-align: center;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            text-decoration: none;
            transition: all 0.2s ease;
        }

        .btn-card-primary {
            background: var(--primary);
            color: #ffffff;
            box-shadow: 0 2px 6px rgba(79, 70, 229, 0.2);
        }

        .btn-card-primary:hover {
            background: var(--primary-hover);
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(79, 70, 229, 0.3);
        }

        .btn-card-roster {
            background: #ffffff;
            color: var(--text-title);
            border: 1px solid var(--border-color);
            cursor: pointer;
            font-family: inherit;
        }

        .btn-card-roster:hover {
            background: #f8fafc;
            border-color: var(--primary);
            color: var(--primary);
            transform: translateY(-1px);
        }

        .event-roster-chip {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            padding: 4px 10px;
            border-radius: 9999px;
            background: #f1f5f9;
            color: #334155;
            font-size: 0.775rem;
            font-weight: 600;
            border: 1px solid var(--border-color);
            cursor: pointer;
            transition: all 0.15s ease;
            font-family: inherit;
        }

        .event-roster-chip:hover {
            background: #e0e7ff;
            color: var(--primary);
            border-color: #c7d2fe;
        }

        /* ─── Registered Players Modal Styles ─── */
        .roster-modal-backdrop {
            position: fixed;
            inset: 0;
            z-index: 9999;
            background: rgba(15, 23, 42, 0.65);
            backdrop-filter: blur(6px);
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
            opacity: 0;
            visibility: hidden;
            transition: opacity 0.22s ease, visibility 0.22s ease;
        }

        .roster-modal-backdrop.is-open {
            opacity: 1;
            visibility: visible;
        }

        .roster-modal-dialog {
            background: #ffffff;
            width: 100%;
            max-width: 860px;
            max-height: 90vh;
            border-radius: 18px;
            box-shadow: 0 20px 45px -10px rgba(15, 23, 42, 0.28);
            display: flex;
            flex-direction: column;
            overflow: hidden;
            transform: scale(0.96) translateY(12px);
            transition: transform 0.22s cubic-bezier(0.16, 1, 0.3, 1);
            border: 1px solid var(--border-color);
        }

        .roster-modal-backdrop.is-open .roster-modal-dialog {
            transform: scale(1) translateY(0);
        }

        .roster-modal-header {
            padding: 20px 24px 16px;
            border-bottom: 1px solid var(--border-color);
            background: linear-gradient(to right, #f8fafc, #ffffff);
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            gap: 16px;
        }

        .modal-badge-group {
            display: flex;
            align-items: center;
            gap: 8px;
            margin-bottom: 6px;
            flex-wrap: wrap;
        }

        .modal-event-badge {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            font-size: 0.75rem;
            font-weight: 700;
            text-transform: uppercase;
            color: var(--primary);
            background: #eef2ff;
            padding: 3px 10px;
            border-radius: 9999px;
            letter-spacing: 0.04em;
        }

        .modal-event-title {
            font-family: var(--font-display);
            font-size: 1.35rem;
            font-weight: 800;
            color: var(--text-title);
            margin: 0 0 4px 0;
            line-height: 1.25;
        }

        .modal-event-meta {
            font-size: 0.85rem;
            color: var(--text-muted);
            display: flex;
            align-items: center;
            gap: 12px;
            flex-wrap: wrap;
        }

        .modal-close-btn {
            background: #f1f5f9;
            border: none;
            width: 36px;
            height: 36px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            color: var(--text-muted);
            font-size: 1.4rem;
            line-height: 1;
            transition: all 0.2s ease;
            flex-shrink: 0;
        }

        .modal-close-btn:hover {
            background: #e2e8f0;
            color: var(--text-title);
        }

        .roster-modal-body {
            padding: 20px 24px;
            overflow-y: auto;
            flex: 1;
        }

        .modal-stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
            gap: 12px;
            margin-bottom: 18px;
        }

        .modal-stat-card {
            background: var(--bg-subtle);
            border: 1px solid var(--border-color);
            border-radius: 10px;
            padding: 12px 16px;
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .modal-stat-icon {
            width: 36px;
            height: 36px;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .modal-stat-val {
            font-family: var(--font-display);
            font-size: 1.35rem;
            font-weight: 800;
            color: var(--text-title);
            line-height: 1;
        }

        .modal-stat-lbl {
            font-size: 0.775rem;
            color: var(--text-muted);
            font-weight: 600;
            margin-top: 2px;
        }

        .modal-toolbar {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
            margin-bottom: 18px;
            flex-wrap: wrap;
        }

        .modal-search-wrapper {
            position: relative;
            flex: 1;
            min-width: 220px;
        }

        .modal-search-icon {
            position: absolute;
            left: 12px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--text-light);
            pointer-events: none;
        }

        .modal-search-input {
            width: 100%;
            padding: 9px 12px 9px 38px;
            border: 1px solid var(--border-color);
            border-radius: 8px;
            font-size: 0.875rem;
            background: var(--bg-subtle);
            outline: none;
            font-family: inherit;
            transition: all 0.2s ease;
        }

        .modal-search-input:focus {
            background: #ffffff;
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.15);
        }

        .modal-filter-tabs {
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .modal-tab-btn {
            padding: 7px 12px;
            border-radius: 6px;
            font-size: 0.8rem;
            font-weight: 600;
            border: 1px solid var(--border-color);
            background: #ffffff;
            color: var(--text-body);
            cursor: pointer;
            font-family: inherit;
            transition: all 0.15s ease;
        }

        .modal-tab-btn.active {
            background: var(--primary);
            color: #ffffff;
            border-color: var(--primary);
        }

        .modal-team-block {
            border: 1px solid var(--border-color);
            border-radius: 12px;
            margin-bottom: 16px;
            overflow: hidden;
            background: #ffffff;
        }

        .modal-team-header {
            background: #f8fafc;
            border-bottom: 1px solid var(--border-color);
            padding: 12px 18px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 10px;
            flex-wrap: wrap;
        }

        .modal-team-title {
            font-family: var(--font-display);
            font-size: 1rem;
            font-weight: 700;
            color: var(--text-title);
            display: flex;
            align-items: center;
            gap: 8px;
            margin: 0;
        }

        .modal-ref-badge {
            font-family: monospace;
            font-size: 0.775rem;
            background: #ffffff;
            border: 1px solid var(--border-color);
            padding: 2px 8px;
            border-radius: 4px;
            color: var(--text-body);
        }

        .modal-member-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 0.875rem;
        }

        .modal-member-table th {
            background: #ffffff;
            color: var(--text-muted);
            font-size: 0.75rem;
            font-weight: 700;
            text-transform: uppercase;
            padding: 9px 16px;
            border-bottom: 1px solid var(--border-color);
            text-align: left;
        }

        .modal-member-table td {
            padding: 11px 16px;
            border-bottom: 1px solid var(--border-color);
            vertical-align: middle;
        }

        .modal-member-table tr:last-child td {
            border-bottom: none;
        }

        .modal-avatar-cell {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .modal-avatar-circle {
            width: 30px;
            height: 30px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            font-size: 0.8rem;
            flex-shrink: 0;
        }

        .avatar-team-theme {
            background: #e0e7ff;
            color: #4338ca;
        }

        .avatar-ind-theme {
            background: #d1fae5;
            color: #065f46;
        }

        .modal-role-pill {
            display: inline-flex;
            align-items: center;
            gap: 4px;
            padding: 2px 8px;
            border-radius: 9999px;
            font-size: 0.725rem;
            font-weight: 700;
        }

        .role-team-member {
            background: #e0e7ff;
            color: #4338ca;
        }

        .role-individual {
            background: #d1fae5;
            color: #065f46;
        }

        .roster-modal-footer {
            padding: 14px 24px;
            border-top: 1px solid var(--border-color);
            background: #f8fafc;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
            flex-wrap: wrap;
        }

        /* ─── Clean Pagination Styling ────────────────────────────── */
        .pagination-wrapper {
            margin-top: 24px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .custom-pagination {
            display: flex;
            align-items: center;
            gap: 8px;
            list-style: none;
        }

        .page-item {
            display: inline-block;
        }

        .page-link {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            min-width: 40px;
            height: 40px;
            padding: 0 14px;
            border-radius: 8px;
            background: #ffffff;
            border: 1px solid var(--border-color);
            color: var(--text-body);
            font-size: 0.9rem;
            font-weight: 600;
            text-decoration: none;
            transition: all 0.15s ease;
        }

        .page-link:hover {
            background: var(--bg-subtle);
            border-color: var(--border-hover);
            color: var(--primary);
        }

        .page-item.active .page-link {
            background: var(--primary);
            border-color: var(--primary);
            color: #ffffff;
            box-shadow: 0 2px 8px rgba(79, 70, 229, 0.25);
        }

        .page-item.disabled .page-link {
            opacity: 0.45;
            cursor: not-allowed;
            pointer-events: none;
            background: var(--bg-subtle);
        }

        /* ─── Empty State ─────────────────────────────────────────── */
        .empty-state-box {
            text-align: center;
            padding: 64px 24px;
            background: var(--bg-subtle);
            border-radius: var(--radius-lg);
            border: 2px dashed var(--border-color);
            grid-column: span 2;
        }

        .empty-state-icon {
            width: 56px;
            height: 56px;
            color: var(--text-light);
            margin: 0 auto 16px;
        }

        .empty-state-title {
            font-size: 1.25rem;
            font-weight: 700;
            color: var(--text-title);
            margin-bottom: 8px;
        }

        .empty-state-desc {
            font-size: 0.95rem;
            color: var(--text-muted);
            max-width: 460px;
            margin: 0 auto;
        }

        /* ─── Footer ──────────────────────────────────────────────── */
        footer.site-footer {
            background: #ffffff;
            border-top: 1px solid var(--border-color);
            margin-top: auto;
            padding: 48px 24px 28px;
        }

        .footer-container {
            max-width: 1240px;
            margin: 0 auto;
        }

        .footer-top {
            display: grid;
            grid-template-columns: 2fr 1fr 1fr;
            gap: 48px;
            margin-bottom: 36px;
        }

        .footer-brand-desc {
            font-size: 0.925rem;
            color: var(--text-muted);
            max-width: 380px;
            line-height: 1.6;
            margin-top: 12px;
        }

        .footer-col-title {
            font-size: 0.85rem;
            font-weight: 700;
            color: var(--text-title);
            text-transform: uppercase;
            letter-spacing: 0.05em;
            margin-bottom: 16px;
        }

        .footer-links-list {
            list-style: none;
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        .footer-link-item a {
            text-decoration: none;
            color: var(--text-muted);
            font-size: 0.9rem;
            transition: color 0.15s ease;
        }

        .footer-link-item a:hover {
            color: var(--primary);
        }

        .footer-bottom {
            padding-top: 24px;
            border-top: 1px solid var(--border-color);
            display: flex;
            align-items: center;
            justify-content: space-between;
            font-size: 0.85rem;
            color: var(--text-muted);
        }

        .footer-status-chip {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            font-weight: 600;
            color: #059669;
        }

        .footer-status-chip .dot {
            width: 7px;
            height: 7px;
            border-radius: 50%;
            background: #10b981;
        }

        /* ─── Responsive Media Queries ────────────────────────────── */
        @media (max-width: 900px) {
            .events-grid {
                grid-template-columns: 1fr;
            }
            .footer-top {
                grid-template-columns: 1fr;
                gap: 32px;
            }
        }

        @media (max-width: 640px) {
            .header-container {
                padding: 14px 16px;
            }
            header nav.header-nav {
                display: none;
            }
            .hero-stats {
                flex-direction: column;
                align-items: center;
                gap: 12px;
            }
            .footer-bottom {
                flex-direction: column;
                gap: 12px;
                text-align: center;
            }
        }
    </style>
</head>
<body>
    <div class="site-wrapper">
        <!-- Professional Header -->
        <header class="site-header">
            <div class="header-container">
                <a href="{{ url('/') }}" class="brand-link" id="header-brand-link">
                    <div class="brand-logo-icon">
                        <svg width="22" height="22" fill="none" stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                        </svg>
                    </div>
                    <div class="brand-info">
                        <span class="brand-title">Truant Enterprises</span>
                        <span class="brand-subtitle">Enterprise Suite</span>
                    </div>
                </a>

                <nav class="header-nav">
                    <a href="{{ url('/') }}" class="nav-link active" id="nav-events-link">Events</a>
                    {{-- 
<a href="{{ route('court-booking.index') }}" class="nav-link" id="nav-book-court-link">Book a Court</a> 
--}}
                </nav>

                <div class="header-actions">
                    <a href="{{ url('/admin/login') }}" class="btn btn-primary" id="btn-login-header">
                        <span>Login</span>
                        <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"/>
                        </svg>
                    </a>
                </div>
            </div>
        </header>

        <!-- Clean Intro Hero -->
        <section class="hero-section">
            <div class="hero-container">
                <div class="hero-pill">
                    <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                    <span>Official Event Registrations &amp; Schedules</span>
                </div>

                <h1 class="hero-title" id="page-hero-heading">Explore Upcoming Events</h1>
                <p class="hero-description">
                    ####
                </p>

                <div class="hero-stats">
                    <div class="stat-item">
                        <span class="stat-dot"></span>
                        <span>Active Registrations Open</span>
                    </div>
                    <div class="stat-item">
                        <svg width="16" height="16" fill="none" stroke="#4f46e5" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <span>Instant Registration Reference</span>
                    </div>
                    <div class="stat-item">
                        <svg width="16" height="16" fill="none" stroke="#4f46e5" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z"/>
                        </svg>
                        <span>Automated Attendee Badges</span>
                    </div>
                </div>
            </div>
        </section>

        <!-- Main Body: 2-Card Per Row Grid -->
        <main class="main-content">
            <div class="section-header">
                <div class="section-heading-group">
                    <h2 class="section-title">Scheduled Events</h2>
                    <p class="section-subtitle">Showing 6 events per page with real-time status</p>
                </div>
                <div class="events-count-badge">
                    <span>Total Events: <strong>{{ $events->total() }}</strong></span>
                </div>
            </div>

            <!-- Events Grid -->
            <div class="events-grid" id="events-grid-container">
                @forelse ($events as $event)
                    @php
                        $isOpen = $event->isRegistrationOpen();
                        $statusText = $event->registration_status;
                        $activeBanner = ($event->registrationForm && $event->registrationForm->banner) ? $event->registrationForm->banner : $event->banner;
                    @endphp
                    <article class="event-card" id="event-card-{{ $event->id }}">
                        <!-- Card Banner -->
                        <div class="card-banner-wrapper">
                            @if ($activeBanner)
                                <img 
                                    src="{{ asset('storage/' . $activeBanner) }}" 
                                    alt="{{ $event->name }} Banner"
                                    class="card-banner-img"
                                    loading="lazy"
                                >
                            @else
                                <div class="card-banner-fallback">
                                    <svg fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                    </svg>
                                    <span style="font-weight: 600; font-size: 0.95rem;">{{ $event->name }}</span>
                                </div>
                            @endif

                            <!-- Status Badge -->
                            <div class="card-status-badge {{ $isOpen ? 'badge-open' : (str_starts_with($statusText, 'Opens') ? 'badge-upcoming' : 'badge-closed') }}">
                                @if ($isOpen)
                                    <span class="live-dot"></span>
                                    <span>Registration Open</span>
                                @elseif (str_starts_with($statusText, 'Opens'))
                                    <svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                    <span>{{ $statusText }}</span>
                                @else
                                    <svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                                    </svg>
                                    <span>Registration Closed</span>
                                @endif
                            </div>
                        </div>

                        <!-- Card Body (Uniform Size) -->
                        <div class="card-body">
                            <!-- Meta: Event Date & Admission Tag -->
                            <div class="card-meta-row">
                                <span class="event-date-chip">
                                    <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                    </svg>
                                    <time datetime="{{ $event->event_date?->toDateString() }}">
                                        {{ $event->event_date ? $event->event_date->format('F d, Y') : 'Date TBA' }}
                                    </time>
                                </span>

                                <span class="admission-pill {{ $event->isFreeAdmission() ? 'admission-free' : 'admission-paid' }}">
                                    @if ($event->isFreeAdmission())
                                        <span>🎟️ Free Admission</span>
                                    @else
                                        <span>💳 Paid Admission{{ $event->ticket_price ? ' (' . $event->ticket_price . ')' : '' }}</span>
                                    @endif
                                </span>
                            </div>

                            <!-- Title -->
                            <h3 class="card-event-title">
                                <a href="{{ route('events.public.show', $event) }}">
                                    {{ $event->name }}
                                </a>
                            </h3>

                            <!-- Description with Admission Status -->
                            <p class="card-event-desc">
                                <span class="desc-admission-highlight">
                                    Admission: 
                                    <span class="{{ $event->isFreeAdmission() ? 'desc-admission-val-free' : 'desc-admission-val-paid' }}">
                                        {{ $event->admission_label }}{{ (! $event->isFreeAdmission() && $event->ticket_price) ? ' (' . $event->ticket_price . ')' : '' }}
                                    </span>
                                    &bull;
                                </span>
                                {{ Str::limit(strip_tags($event->description), 140) }}
                            </p>

                            <!-- Bottom Action Buttons: Roster + Event Details -->
                            <div class="card-footer-action">
                                <button type="button" class="btn-card-action btn-card-roster" onclick="openEventRoster({{ $event->id }})" id="btn-view-players-{{ $event->id }}" title="View all registered players and team rosters for {{ $event->name }}">
                                    <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    </svg>
                                    <span>Registered Players ({{ $event->registrations->count() }})</span>
                                </button>
                                <a href="{{ route('events.public.show', $event) }}" class="btn-card-action btn-card-primary" id="btn-view-event-{{ $event->id }}">
                                    <span>View Event &amp; Register</span>
                                    <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                                    </svg>
                                </a>
                            </div>

                            <!-- Embedded Roster Data for Zero-Lag Popup -->
                            <script id="event-roster-data-{{ $event->id }}" type="application/json">
                                {!! json_encode($event->getGroupedPlayers(), JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP) !!}
                            </script>
                        </div>
                    </article>
                @empty
                    <div class="empty-state-box">
                        <svg class="empty-state-icon" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                        <h4 class="empty-state-title">No Events Available Yet</h4>
                        <p class="empty-state-desc">Please check back soon for new conferences, workshops, and gatherings.</p>
                    </div>
                @endforelse
            </div>

            <!-- Pagination (6 events per page) -->
            @if ($events->hasPages())
                <div class="pagination-wrapper" aria-label="Events pagination">
                    <ul class="custom-pagination">
                        {{-- Previous Page Link --}}
                        @if ($events->onFirstPage())
                            <li class="page-item disabled" aria-disabled="true">
                                <span class="page-link">&laquo; Previous</span>
                            </li>
                        @else
                            <li class="page-item">
                                <a class="page-link" href="{{ $events->previousPageUrl() }}" rel="prev">&laquo; Previous</a>
                            </li>
                        @endif

                        {{-- Pagination Elements --}}
                        @foreach ($events->getUrlRange(1, $events->lastPage()) as $page => $url)
                            @if ($page == $events->currentPage())
                                <li class="page-item active" aria-current="page">
                                    <span class="page-link">{{ $page }}</span>
                                </li>
                            @else
                                <li class="page-item">
                                    <a class="page-link" href="{{ $url }}">{{ $page }}</a>
                                </li>
                            @endif
                        @endforeach

                        {{-- Next Page Link --}}
                        @if ($events->hasMorePages())
                            <li class="page-item">
                                <a class="page-link" href="{{ $events->nextPageUrl() }}" rel="next">Next &raquo;</a>
                            </li>
                        @else
                            <li class="page-item disabled" aria-disabled="true">
                                <span class="page-link">Next &raquo;</span>
                            </li>
                        @endif
                    </ul>
                </div>
            @endif
        </main>

        <!-- Professional Footer -->
        <footer class="site-footer">
            <div class="footer-container">
                <div class="footer-top">
                    <div>
                        <a href="{{ url('/') }}" class="brand-link" style="margin-bottom: 8px;">
                            <div class="brand-logo-icon" style="width: 32px; height: 32px; border-radius: 8px;">
                                <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                                </svg>
                            </div>
                            <span class="brand-title" style="font-size: 1.15rem;">Truant Enterprises</span>
                        </a>
                        <p class="footer-brand-desc">
                            A unified enterprise management suite integrating modern workforce records, biometric timesheets, automated payroll computations, and dynamic event registrations.
                        </p>
                    </div>

                    <div>
                        <h4 class="footer-col-title">Quick Links</h4>
                        <ul class="footer-links-list">
                            <li class="footer-link-item"><a href="{{ url('/') }}">Upcoming Events</a></li>
                            <li class="footer-link-item"><a href="{{ route('court-booking.index') }}">Book a Court</a></li>
                            <li class="footer-link-item"><a href="{{ url('/admin/login') }}">Administrator Login</a></li>
                        </ul>
                    </div>

                    <div>
                        <h4 class="footer-col-title">Administration</h4>
                        <ul class="footer-links-list">
                            <li class="footer-link-item"><a href="{{ url('/admin/login') }}">Administrator Login</a></li>
                            <li class="footer-link-item"><a href="{{ url('/admin/events') }}">Event Form Builder</a></li>
                            <li class="footer-link-item"><a href="{{ url('/admin/payroll') }}">Payroll Management</a></li>
                        </ul>
                    </div>
                </div>

                <div class="footer-bottom">
                    <div>
                        <span>&copy; {{ date('Y') }} Truant Enterprises. All rights reserved.</span>
                    </div>
                    <div class="footer-status-chip">
                        <span class="dot"></span>
                        <span>All Systems Operational</span>
                    </div>
                </div>
            </div>
        </footer>
    </div>

    <!-- Registered Players & Teams Interactive Modal Dialog -->
    <div class="roster-modal-backdrop" id="rosterModalBackdrop" onclick="handleBackdropClick(event)" role="dialog" aria-modal="true" aria-labelledby="modalEventTitle">
        <div class="roster-modal-dialog">
            <!-- Modal Header -->
            <div class="roster-modal-header">
                <div>
                    <div class="modal-badge-group">
                        <span class="modal-event-badge">
                            <svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                            </svg>
                            <span>Official Event Roster</span>
                        </span>
                        <span id="modalEventStatus" style="font-size: 0.75rem; font-weight: 700; color: #059669;">● Registration Open</span>
                    </div>
                    <h2 id="modalEventTitle" class="modal-event-title">Event Title</h2>
                    <div class="modal-event-meta">
                        <span id="modalEventDate">📅 Date TBA</span>
                        <span>&bull;</span>
                        <span id="modalEventSummary">Confirmed registered participants grouped by team squads</span>
                    </div>
                </div>
                <button type="button" class="modal-close-btn" onclick="closeRosterModal()" aria-label="Close roster modal" id="btn-close-roster-modal">&times;</button>
            </div>

            <!-- Modal Body -->
            <div class="roster-modal-body">
                <!-- Metrics -->
                <div class="modal-stats-grid">
                    <div class="modal-stat-card">
                        <div class="modal-stat-icon" style="background: #e0e7ff; color: #4338ca;">
                            <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                            </svg>
                        </div>
                        <div>
                            <div class="modal-stat-val" id="modalStatTotalPlayers">0</div>
                            <div class="modal-stat-lbl">Total Registered Players</div>
                        </div>
                    </div>

                    <div class="modal-stat-card">
                        <div class="modal-stat-icon" style="background: #e0f2fe; color: #0284c7;">
                            <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                            </svg>
                        </div>
                        <div>
                            <div class="modal-stat-val" id="modalStatTotalTeams">0</div>
                            <div class="modal-stat-lbl">Teams Formed</div>
                        </div>
                    </div>

                    <div class="modal-stat-card">
                        <div class="modal-stat-icon" style="background: #ecfdf5; color: #059669;">
                            <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                            </svg>
                        </div>
                        <div>
                            <div class="modal-stat-val" id="modalStatIndividual">0</div>
                            <div class="modal-stat-lbl">Individual / Solo Players</div>
                        </div>
                    </div>
                </div>

                <!-- Search & Filter Controls -->
                <div class="modal-toolbar">
                    <div class="modal-search-wrapper">
                        <svg class="modal-search-icon" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                        </svg>
                        <input 
                            type="text" 
                            id="modalRosterSearch" 
                            class="modal-search-input" 
                            placeholder="Filter player name, team, or Ref#..." 
                            oninput="filterModalRoster()"
                            autocomplete="off"
                        >
                    </div>

                    <div class="modal-filter-tabs">
                        <button type="button" class="modal-tab-btn active" id="modal-tab-all" onclick="setModalTab('all')">
                            All Players
                        </button>
                        <button type="button" class="modal-tab-btn" id="modal-tab-teams" onclick="setModalTab('teams')">
                            Grouped by Teams
                        </button>
                        <button type="button" class="modal-tab-btn" id="modal-tab-individual" onclick="setModalTab('individual')">
                            Individual (No Team)
                        </button>
                    </div>
                </div>

                <!-- Dynamic Content Container -->
                <div id="modalRosterContent">
                    <!-- Populated via JavaScript -->
                </div>
            </div>

            <!-- Modal Footer -->
            <div class="roster-modal-footer">
                <a href="#" id="modalViewDedicatedLink" class="btn btn-outline" style="font-size: 0.85rem; padding: 7px 14px;">
                    <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
                    </svg>
                    <span>Open Full Page Directory</span>
                </a>

                <div style="display: flex; gap: 8px;">
                    <button type="button" class="btn btn-outline" onclick="closeRosterModal()" style="font-size: 0.85rem; padding: 7px 14px;">Close</button>
                    <a href="#" id="modalRegisterCtaLink" class="btn btn-primary" style="font-size: 0.85rem; padding: 7px 16px;">
                        <span>Register for Event</span>
                        <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                        </svg>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Logic Scripts -->
    <script>
        let currentModalRoster = null;
        let currentModalTab = 'all';

        function openEventRoster(eventId) {
            let data = null;
            const scriptTag = document.getElementById('event-roster-data-' + eventId);

            if (scriptTag) {
                try {
                    data = JSON.parse(scriptTag.textContent);
                } catch (e) {
                    console.error('Failed to parse embedded roster JSON:', e);
                }
            }

            if (data) {
                displayRosterModal(data);
            } else {
                // Fetch dynamically via AJAX
                fetch(`/events/${eventId}/players`, {
                    headers: { 'Accept': 'application/json', 'X-Requested-With': 'XMLHttpRequest' }
                })
                .then(res => res.json())
                .then(res => {
                    if (res && res.data) {
                        displayRosterModal(res.data);
                    }
                })
                .catch(err => {
                    console.error('Failed to fetch event roster:', err);
                });
            }
        }

        function displayRosterModal(roster) {
            currentModalRoster = roster;
            currentModalTab = 'all';

            document.getElementById('modalEventTitle').textContent = roster.event_name || 'Event Roster';
            document.getElementById('modalEventDate').textContent = '📅 ' + (roster.event_date || 'Date TBA');
            document.getElementById('modalStatTotalPlayers').textContent = roster.total_players || 0;
            document.getElementById('modalStatTotalTeams').textContent = roster.total_teams || 0;
            document.getElementById('modalStatIndividual').textContent = roster.individual_players_count || 0;

            const statusEl = document.getElementById('modalEventStatus');
            if (statusEl) {
                if (roster.is_open) {
                    statusEl.textContent = '● Registration Open';
                    statusEl.style.color = '#059669';
                } else {
                    statusEl.textContent = '● Registration Closed';
                    statusEl.style.color = '#64748b';
                }
            }

            const dedicatedLink = document.getElementById('modalViewDedicatedLink');
            if (dedicatedLink) {
                dedicatedLink.href = `/events/${roster.event_id}/players`;
            }

            const regLink = document.getElementById('modalRegisterCtaLink');
            if (regLink) {
                regLink.href = `/events/${roster.event_id}#registration-form-section`;
                regLink.style.display = roster.is_open ? 'inline-flex' : 'none';
            }

            const searchInput = document.getElementById('modalRosterSearch');
            if (searchInput) {
                searchInput.value = '';
            }

            document.querySelectorAll('.modal-tab-btn').forEach(btn => btn.classList.remove('active'));
            const allTabBtn = document.getElementById('modal-tab-all');
            if (allTabBtn) allTabBtn.classList.add('active');

            renderModalRosterHtml();

            const backdrop = document.getElementById('rosterModalBackdrop');
            if (backdrop) {
                backdrop.classList.add('is-open');
                document.body.style.overflow = 'hidden';
            }
        }

        function closeRosterModal() {
            const backdrop = document.getElementById('rosterModalBackdrop');
            if (backdrop) {
                backdrop.classList.remove('is-open');
                document.body.style.overflow = '';
            }
        }

        function handleBackdropClick(event) {
            if (event.target.id === 'rosterModalBackdrop') {
                closeRosterModal();
            }
        }

        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                closeRosterModal();
            }
        });

        function setModalTab(tab) {
            currentModalTab = tab;
            document.querySelectorAll('.modal-tab-btn').forEach(btn => btn.classList.remove('active'));
            const activeBtn = document.getElementById('modal-tab-' + tab);
            if (activeBtn) activeBtn.classList.add('active');
            renderModalRosterHtml();
        }

        function filterModalRoster() {
            renderModalRosterHtml();
        }

        function renderModalRosterHtml() {
            const container = document.getElementById('modalRosterContent');
            if (!container || !currentModalRoster) return;

            const searchInput = document.getElementById('modalRosterSearch');
            const query = searchInput ? searchInput.value.toLowerCase().trim() : '';

            const teams = currentModalRoster.teams || [];
            const individuals = currentModalRoster.individual_players || [];

            if (currentModalRoster.total_players === 0) {
                container.innerHTML = `
                    <div style="padding: 36px 16px; text-align: center; color: var(--text-muted);">
                        <svg width="40" height="40" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24" style="margin: 0 auto 12px; color: var(--text-light);">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                        </svg>
                        <h4 style="font-weight: 700; color: var(--text-title); margin-bottom: 4px;">No Players Registered Yet</h4>
                        <p style="font-size: 0.875rem;">Be the first to sign up for this event!</p>
                    </div>
                `;
                return;
            }

            let html = '';
            let totalMatches = 0;

            // 1. TEAMS GROUPING
            if (currentModalTab !== 'individual' && teams.length > 0) {
                let teamsHtml = '';
                teams.forEach(team => {
                    const teamName = team.team_name || '';
                    const teamRef = team.team_reference || '';
                    const members = team.members || [];

                    let matchingMembers = [];
                    if (!query || teamName.toLowerCase().includes(query) || teamRef.toLowerCase().includes(query)) {
                        matchingMembers = members;
                    } else {
                        matchingMembers = members.filter(m => 
                            (m.name && m.name.toLowerCase().includes(query)) || 
                            (m.reference && m.reference.toLowerCase().includes(query))
                        );
                    }

                    if (matchingMembers.length > 0) {
                        totalMatches += matchingMembers.length;
                        let memberRows = '';
                        matchingMembers.forEach((m, idx) => {
                            const initial = m.name ? m.name.charAt(0).toUpperCase() : '?';
                            memberRows += `
                                <tr>
                                    <td style="width: 40px; color: var(--text-light); font-weight: 700;">${idx + 1}</td>
                                    <td>
                                        <div class="modal-avatar-cell">
                                            <div class="modal-avatar-circle avatar-team-theme">${initial}</div>
                                            <div>
                                                <div style="font-weight: 700; color: var(--text-title);">${m.name}</div>
                                                <div style="font-size: 0.75rem; color: var(--text-muted);">${teamName}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td><span class="modal-ref-badge">${m.reference || '—'}</span></td>
                                    <td style="color: var(--text-muted); font-size: 0.8rem;">${m.registered_at || '—'}</td>
                                    <td style="text-align: right;">
                                        <span class="modal-role-pill role-team-member">Team Member</span>
                                    </td>
                                </tr>
                            `;
                        });

                        teamsHtml += `
                            <div class="modal-team-block">
                                <div class="modal-team-header">
                                    <div class="modal-team-title">
                                        <svg width="18" height="18" fill="none" stroke="#0284c7" stroke-width="2" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                                        </svg>
                                        <span>${teamName}</span>
                                    </div>
                                    <div style="display: flex; align-items: center; gap: 8px;">
                                        <span class="modal-ref-badge" title="Team Ref">${teamRef}</span>
                                        <span style="background: #e0f2fe; color: #0284c7; font-size: 0.75rem; font-weight: 700; padding: 2px 8px; border-radius: 9999px;">
                                            ${matchingMembers.length} ${matchingMembers.length === 1 ? 'Player' : 'Players'}
                                        </span>
                                    </div>
                                </div>
                                <div style="overflow-x: auto;">
                                    <table class="modal-member-table">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Player Name</th>
                                                <th>Registration Ref#</th>
                                                <th>Registered Date</th>
                                                <th style="text-align: right;">Role</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            ${memberRows}
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        `;
                    }
                });

                if (teamsHtml) {
                    html += `
                        <div style="margin-bottom: 24px;">
                            <h4 style="font-size: 0.95rem; font-weight: 700; color: var(--text-title); margin-bottom: 12px; display: flex; align-items: center; gap: 8px;">
                                <span>Grouped by Teams</span>
                                <span style="font-size: 0.75rem; color: var(--text-muted); font-weight: 600;">(Official Squads)</span>
                            </h4>
                            ${teamsHtml}
                        </div>
                    `;
                }
            }

            // 2. INDIVIDUAL PLAYERS (NO TEAM)
            if (currentModalTab !== 'teams' && individuals.length > 0) {
                const matchingIndividuals = individuals.filter(ind => 
                    !query || 
                    (ind.name && ind.name.toLowerCase().includes(query)) || 
                    (ind.reference && ind.reference.toLowerCase().includes(query))
                );

                if (matchingIndividuals.length > 0) {
                    totalMatches += matchingIndividuals.length;
                    let indRows = '';
                    matchingIndividuals.forEach((ind, idx) => {
                        const initial = ind.name ? ind.name.charAt(0).toUpperCase() : '?';
                        indRows += `
                            <tr>
                                <td style="width: 40px; color: var(--text-light); font-weight: 700;">${idx + 1}</td>
                                <td>
                                    <div class="modal-avatar-cell">
                                        <div class="modal-avatar-circle avatar-ind-theme">${initial}</div>
                                        <div>
                                            <div style="font-weight: 700; color: var(--text-title);">${ind.name}</div>
                                            <div style="font-size: 0.75rem; color: var(--text-muted);">Solo / Free Agent</div>
                                        </div>
                                    </div>
                                </td>
                                <td><span class="modal-ref-badge">${ind.reference || '—'}</span></td>
                                <td style="color: var(--text-muted); font-size: 0.8rem;">${ind.registered_at || '—'}</td>
                                <td style="text-align: right;">
                                    <span class="modal-role-pill role-individual">No Team Yet</span>
                                </td>
                            </tr>
                        `;
                    });

                    html += `
                        <div>
                            <h4 style="font-size: 0.95rem; font-weight: 700; color: var(--text-title); margin-bottom: 12px; display: flex; align-items: center; gap: 8px;">
                                <span>Individual Players (No Team Yet)</span>
                                <span style="font-size: 0.75rem; color: var(--text-muted); font-weight: 600;">(${matchingIndividuals.length} Players)</span>
                            </h4>
                            <div class="modal-team-block">
                                <div style="overflow-x: auto;">
                                    <table class="modal-member-table">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Player Name</th>
                                                <th>Registration Ref#</th>
                                                <th>Registered Date</th>
                                                <th style="text-align: right;">Status</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            ${indRows}
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    `;
                }
            }

            if (totalMatches === 0) {
                container.innerHTML = `
                    <div style="padding: 32px 16px; text-align: center; color: var(--text-muted);">
                        <p style="margin-bottom: 8px; font-weight: 600;">No players or teams match "${query}".</p>
                        <button type="button" class="btn btn-outline" onclick="document.getElementById('modalRosterSearch').value = ''; renderModalRosterHtml();" style="font-size: 0.8rem; padding: 6px 14px;">Clear Search</button>
                    </div>
                `;
            } else {
                container.innerHTML = html;
            }
        }
    </script>
</body>
</html>
