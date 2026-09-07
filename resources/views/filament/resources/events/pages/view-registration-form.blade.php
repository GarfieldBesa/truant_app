<x-filament-panels::page>
    <style>
        /* ─── Events Registration Form Design System ──────────────────────────────── */
        @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap');

        .ev-root {
            font-family: 'Plus Jakarta Sans', ui-sans-serif, system-ui, -apple-system, sans-serif;
            color: #1e293b;
            max-width: 900px;
            margin: 0 auto;
            display: flex;
            flex-direction: column;
            gap: 1.5rem;
        }

        .dark .ev-root {
            color: #f1f5f9;
        }

        /* ─── Preview Mode Top Banner ─────────────────────────────────────────────── */
        .ev-preview-banner {
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 1rem;
            background: linear-gradient(135deg, rgba(99, 102, 241, 0.08) 0%, rgba(168, 85, 247, 0.08) 100%);
            border: 1px solid rgba(99, 102, 241, 0.25);
            border-radius: 1rem;
            padding: 1rem 1.25rem;
        }

        .dark .ev-preview-banner {
            background: linear-gradient(135deg, rgba(99, 102, 241, 0.15) 0%, rgba(168, 85, 247, 0.15) 100%);
            border-color: rgba(99, 102, 241, 0.35);
        }

        .ev-preview-left {
            display: flex;
            align-items: center;
            gap: 0.875rem;
        }

        .ev-preview-icon {
            width: 2.5rem;
            height: 2.5rem;
            border-radius: 0.75rem;
            background: linear-gradient(135deg, #6366f1 0%, #4f46e5 100%);
            color: #ffffff;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 4px 12px rgba(99, 102, 241, 0.3);
            flex-shrink: 0;
        }

        .ev-preview-icon svg {
            width: 1.25rem;
            height: 1.25rem;
        }

        .ev-preview-title {
            font-size: 0.8125rem;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            color: #4338ca;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .dark .ev-preview-title {
            color: #a5b4fc;
        }

        .ev-pulse-dot {
            width: 0.5rem;
            height: 0.5rem;
            border-radius: 9999px;
            background-color: #10b981;
            box-shadow: 0 0 0 2px rgba(16, 185, 129, 0.3);
            animation: ev-pulse 2s cubic-bezier(0.4, 0, 0.6, 1) infinite;
        }

        @keyframes ev-pulse {
            0%, 100% { opacity: 1; }
            50% { opacity: .4; }
        }

        .ev-preview-desc {
            font-size: 0.8125rem;
            color: #64748b;
            margin-top: 0.125rem;
        }

        .dark .ev-preview-desc {
            color: #94a3b8;
        }

        /* ─── Event Header Card ───────────────────────────────────────────────────── */
        .ev-card {
            background: #ffffff;
            border: 1px solid #e2e8f0;
            border-radius: 1.25rem;
            box-shadow: 0 4px 20px -2px rgba(0, 0, 0, 0.05);
            overflow: hidden;
            transition: box-shadow 0.2s ease;
        }

        .dark .ev-card {
            background: #0f172a;
            border-color: #1e293b;
            box-shadow: 0 4px 20px -2px rgba(0, 0, 0, 0.3);
        }

        .ev-hero-banner {
            width: 100%;
            height: 16rem;
            position: relative;
            background-color: #1e293b;
            overflow: hidden;
        }

        .ev-hero-img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .ev-hero-overlay {
            position: absolute;
            inset: 0;
            background: linear-gradient(180deg, rgba(0,0,0,0.1) 0%, rgba(15,23,42,0.85) 100%);
            display: flex;
            flex-direction: column;
            justify-content: flex-end;
            padding: 1.75rem 2rem;
        }

        .ev-hero-badge {
            display: inline-flex;
            align-items: center;
            gap: 0.375rem;
            padding: 0.3125rem 0.75rem;
            border-radius: 9999px;
            font-size: 0.75rem;
            font-weight: 700;
            background: rgba(255, 255, 255, 0.2);
            backdrop-filter: blur(8px);
            color: #ffffff;
            width: fit-content;
            margin-bottom: 0.5rem;
            text-transform: uppercase;
            letter-spacing: 0.04em;
        }

        .ev-hero-title {
            font-size: 1.875rem;
            font-weight: 800;
            color: #ffffff;
            line-height: 1.2;
            text-shadow: 0 2px 4px rgba(0,0,0,0.3);
        }

        /* Fallback Header (no banner image) */
        .ev-header-fallback {
            background: linear-gradient(135deg, #4f46e5 0%, #7c3aed 50%, #d946ef 100%);
            padding: 2.25rem 2rem;
            color: #ffffff;
        }

        .ev-header-fallback .ev-hero-badge {
            background: rgba(255, 255, 255, 0.25);
        }

        .ev-card-body {
            padding: 2rem;
        }

        /* ─── Date Badges Row ─────────────────────────────────────────────────────── */
        .ev-dates-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
            gap: 1rem;
            padding-bottom: 1.5rem;
            border-bottom: 1px solid #f1f5f9;
        }

        .dark .ev-dates-grid {
            border-color: #1e293b;
        }

        .ev-date-pill {
            display: flex;
            align-items: center;
            gap: 0.875rem;
            padding: 1rem 1.25rem;
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 1rem;
        }

        .dark .ev-date-pill {
            background: #1e293b;
            border-color: #334155;
        }

        .ev-date-icon {
            width: 2.5rem;
            height: 2.5rem;
            border-radius: 0.75rem;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .ev-date-icon-blue {
            background: #eff6ff;
            color: #2563eb;
        }

        .dark .ev-date-icon-blue {
            background: rgba(37, 99, 235, 0.2);
            color: #60a5fa;
        }

        .ev-date-icon-emerald {
            background: #ecfdf5;
            color: #059669;
        }

        .dark .ev-date-icon-emerald {
            background: rgba(5, 150, 105, 0.2);
            color: #34d399;
        }

        .ev-date-icon svg {
            width: 1.25rem;
            height: 1.25rem;
        }

        .ev-date-label {
            font-size: 0.75rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.04em;
            color: #64748b;
        }

        .dark .ev-date-label {
            color: #94a3b8;
        }

        .ev-date-val {
            font-size: 0.9375rem;
            font-weight: 700;
            color: #0f172a;
            margin-top: 0.125rem;
        }

        .dark .ev-date-val {
            color: #f8fafc;
        }

        /* ─── Event Description Area ──────────────────────────────────────────────── */
        .ev-desc-section {
            margin-top: 1.5rem;
        }

        .ev-section-subtitle {
            font-size: 0.75rem;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 0.06em;
            color: #94a3b8;
            margin-bottom: 0.625rem;
        }

        .ev-desc-content {
            font-size: 0.9375rem;
            line-height: 1.7;
            color: #334155;
        }

        .dark .ev-desc-content {
            color: #cbd5e1;
        }

        .ev-desc-content p {
            margin-bottom: 0.75rem;
        }

        .ev-desc-content p:last-child {
            margin-bottom: 0;
        }

        /* ─── Registration Form Container ─────────────────────────────────────────── */
        .ev-form-header {
            padding-bottom: 1.25rem;
            margin-bottom: 2rem;
            border-bottom: 2px solid #f1f5f9;
        }

        .dark .ev-form-header {
            border-color: #1e293b;
        }

        .ev-form-title {
            font-size: 1.375rem;
            font-weight: 800;
            color: #0f172a;
            letter-spacing: -0.02em;
        }

        .dark .ev-form-title {
            color: #f8fafc;
        }

        .ev-form-instructions {
            font-size: 0.875rem;
            color: #64748b;
            margin-top: 0.375rem;
            line-height: 1.5;
        }

        .dark .ev-form-instructions {
            color: #94a3b8;
        }

        /* ─── Form Alert / Result Banner ──────────────────────────────────────────── */
        .ev-alert-success {
            background: #ecfdf5;
            border: 1px solid #a7f3d0;
            border-radius: 0.875rem;
            padding: 1rem 1.25rem;
            margin-bottom: 2rem;
            display: flex;
            align-items: center;
            gap: 0.875rem;
            color: #065f46;
        }

        .dark .ev-alert-success {
            background: rgba(6, 95, 70, 0.2);
            border-color: rgba(16, 185, 129, 0.3);
            color: #a7f3d0;
        }

        .ev-alert-success svg {
            width: 1.5rem;
            height: 1.5rem;
            color: #10b981;
            flex-shrink: 0;
        }

        /* ─── Field Group ─────────────────────────────────────────────────────────── */
        .ev-fields-stack {
            display: flex;
            flex-direction: column;
            gap: 1.75rem;
        }

        .ev-field-group {
            display: flex;
            flex-direction: column;
            gap: 0.5rem;
            width: 100%;
        }

        .ev-label {
            display: block;
            font-size: 0.875rem;
            font-weight: 600;
            color: #1e293b;
        }

        .dark .ev-label {
            color: #e2e8f0;
        }

        .ev-req {
            color: #ef4444;
            font-weight: 700;
            margin-left: 0.25rem;
        }

        .ev-help {
            font-size: 0.75rem;
            color: #64748b;
        }

        .dark .ev-help {
            color: #94a3b8;
        }

        /* ─── Form Inputs ─────────────────────────────────────────────────────────── */
        .ev-input, .ev-textarea, .ev-select {
            width: 100%;
            border-radius: 0.75rem;
            border: 1.5px solid #cbd5e1;
            background-color: #ffffff;
            padding: 0.75rem 1rem;
            font-size: 0.875rem;
            color: #0f172a;
            outline: none;
            transition: border-color 0.15s ease, box-shadow 0.15s ease;
            box-sizing: border-box;
            display: block;
        }

        .dark .ev-input, .dark .ev-textarea, .dark .ev-select {
            background-color: #1e293b;
            border-color: #334155;
            color: #f8fafc;
        }

        .ev-input:focus, .ev-textarea:focus, .ev-select:focus {
            border-color: #6366f1;
            box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.18);
        }

        .ev-input::placeholder, .ev-textarea::placeholder {
            color: #94a3b8;
        }

        .ev-textarea {
            min-height: 6.5rem;
            resize: vertical;
        }

        /* ─── Radio Button Pills ─────────────────────────────────────────────────── */
        .ev-radio-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 0.75rem;
            width: 100%;
        }

        .ev-radio-card {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            padding: 0.875rem 1.125rem;
            border-radius: 0.75rem;
            border: 1.5px solid #e2e8f0;
            background-color: #f8fafc;
            cursor: pointer;
            transition: all 0.15s ease;
            user-select: none;
            box-sizing: border-box;
        }

        .dark .ev-radio-card {
            background-color: #1e293b;
            border-color: #334155;
        }

        .ev-radio-card:hover {
            border-color: #a5b4fc;
            background-color: #f1f5f9;
        }

        .dark .ev-radio-card:hover {
            border-color: #6366f1;
            background-color: #26334d;
        }

        .ev-radio-card input[type="radio"] {
            width: 1.125rem;
            height: 1.125rem;
            accent-color: #6366f1;
            cursor: pointer;
        }

        .ev-radio-card span {
            font-size: 0.875rem;
            font-weight: 500;
            color: #334155;
        }

        .dark .ev-radio-card span {
            color: #e2e8f0;
        }

        /* ─── Upload Image Dropzone ──────────────────────────────────────────────── */
        .ev-upload-container {
            width: 100%;
            display: block;
        }

        .ev-dropzone {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
            width: 100%;
            box-sizing: border-box;
            border: 2px dashed #cbd5e1;
            border-radius: 1rem;
            padding: 2rem 1.5rem;
            text-align: center;
            background-color: #f8fafc;
            cursor: pointer;
            transition: all 0.15s ease;
        }

        .dark .ev-dropzone {
            background-color: #1e293b;
            border-color: #334155;
        }

        .ev-dropzone:hover {
            border-color: #6366f1;
            background-color: rgba(99, 102, 241, 0.04);
        }

        .ev-dropzone-icon {
            width: 3rem;
            height: 3rem;
            border-radius: 0.75rem;
            background: #eff6ff;
            color: #3b82f6;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 0.25rem;
        }

        .dark .ev-dropzone-icon {
            background: rgba(59, 130, 246, 0.2);
            color: #60a5fa;
        }

        .ev-dropzone-icon svg {
            width: 1.5rem;
            height: 1.5rem;
        }

        .ev-dropzone-btn {
            font-size: 0.875rem;
            font-weight: 700;
            color: #4f46e5;
        }

        .dark .ev-dropzone-btn {
            color: #818cf8;
        }

        .ev-dropzone-hint {
            font-size: 0.75rem;
            color: #64748b;
        }

        .dark .ev-dropzone-hint {
            color: #94a3b8;
        }

        .ev-file-chip {
            margin-top: 0.75rem;
            padding: 0.75rem 1rem;
            border-radius: 0.75rem;
            background: #eff6ff;
            border: 1px solid #bfdbfe;
            display: flex;
            align-items: center;
            gap: 0.625rem;
            color: #1e40af;
            font-size: 0.8125rem;
            font-weight: 600;
            box-sizing: border-box;
        }

        .dark .ev-file-chip {
            background: rgba(30, 64, 175, 0.2);
            border-color: rgba(96, 165, 250, 0.3);
            color: #bfdbfe;
        }

        .ev-file-chip svg {
            width: 1.125rem;
            height: 1.125rem;
            color: #3b82f6;
            flex-shrink: 0;
        }

        /* ─── Mandatory Consent Agreement Section ─────────────────────────────────── */
        .ev-consent-box {
            margin-top: 2.25rem;
            padding-top: 2rem;
            border-top: 2px solid #f1f5f9;
            display: flex;
            flex-direction: column;
            gap: 1.25rem;
            width: 100%;
            box-sizing: border-box;
        }

        .dark .ev-consent-box {
            border-color: #1e293b;
        }

        .ev-consent-heading {
            display: flex;
            align-items: center;
            gap: 0.625rem;
        }

        .ev-consent-badge-icon {
            width: 2rem;
            height: 2rem;
            border-radius: 0.5rem;
            background: rgba(168, 85, 247, 0.12);
            color: #9333ea;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .dark .ev-consent-badge-icon {
            background: rgba(168, 85, 247, 0.25);
            color: #c084fc;
        }

        .ev-consent-badge-icon svg {
            width: 1.125rem;
            height: 1.125rem;
        }

        .ev-consent-title {
            font-size: 0.9375rem;
            font-weight: 800;
            color: #0f172a;
        }

        .dark .ev-consent-title {
            color: #f8fafc;
        }

        .ev-consent-terms {
            padding: 1.25rem;
            border-radius: 0.875rem;
            background-color: #f8fafc;
            border: 1px solid #e2e8f0;
            font-size: 0.8125rem;
            line-height: 1.7;
            color: #475569;
            max-height: 12rem;
            overflow-y: auto;
            white-space: pre-line;
            box-shadow: inset 0 2px 4px rgba(0, 0, 0, 0.02);
            box-sizing: border-box;
        }

        .dark .ev-consent-terms {
            background-color: #1e293b;
            border-color: #334155;
            color: #94a3b8;
        }

        .ev-agreement-card {
            display: flex;
            align-items: flex-start;
            gap: 0.875rem;
            padding: 1.125rem 1.25rem;
            border-radius: 0.875rem;
            background: linear-gradient(135deg, rgba(168, 85, 247, 0.05) 0%, rgba(99, 102, 241, 0.05) 100%);
            border: 1.5px solid rgba(168, 85, 247, 0.3);
            cursor: pointer;
            transition: background-color 0.15s ease;
            box-sizing: border-box;
        }

        .dark .ev-agreement-card {
            background: rgba(168, 85, 247, 0.1);
            border-color: rgba(168, 85, 247, 0.35);
        }

        .ev-agreement-card:hover {
            background: rgba(168, 85, 247, 0.09);
        }

        .ev-agreement-card input[type="checkbox"] {
            width: 1.25rem;
            height: 1.25rem;
            border-radius: 0.375rem;
            accent-color: #9333ea;
            cursor: pointer;
            margin-top: 0.125rem;
            flex-shrink: 0;
        }

        .ev-agreement-text {
            font-size: 0.875rem;
            font-weight: 600;
            color: #0f172a;
            line-height: 1.4;
        }

        .dark .ev-agreement-text {
            color: #f8fafc;
        }

        /* ─── Action Footer ───────────────────────────────────────────────────────── */
        .ev-footer {
            margin-top: 2.25rem;
            padding-top: 1.75rem;
            border-top: 2px solid #f1f5f9;
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 1rem;
        }

        .dark .ev-footer {
            border-color: #1e293b;
        }

        .ev-footer-left {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            flex-wrap: wrap;
        }

        .ev-btn-primary {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
            background: linear-gradient(135deg, #6366f1 0%, #4f46e5 100%);
            color: #ffffff;
            font-size: 0.9375rem;
            font-weight: 700;
            padding: 0.8125rem 1.5rem;
            border-radius: 0.75rem;
            border: none;
            cursor: pointer;
            box-shadow: 0 4px 14px rgba(79, 70, 229, 0.35);
            transition: all 0.15s ease;
        }

        .ev-btn-primary:hover {
            background: linear-gradient(135deg, #4f46e5 0%, #4338ca 100%);
            box-shadow: 0 6px 18px rgba(79, 70, 229, 0.45);
            transform: translateY(-1px);
        }

        .ev-btn-primary:active {
            transform: translateY(0);
        }

        .ev-btn-primary svg {
            width: 1.125rem;
            height: 1.125rem;
        }

        .ev-btn-secondary {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
            background: #ffffff;
            color: #475569;
            font-size: 0.9375rem;
            font-weight: 600;
            padding: 0.8125rem 1.25rem;
            border-radius: 0.75rem;
            border: 1.5px solid #cbd5e1;
            cursor: pointer;
            transition: all 0.15s ease;
        }

        .dark .ev-btn-secondary {
            background: #1e293b;
            color: #cbd5e1;
            border-color: #334155;
        }

        .ev-btn-secondary:hover {
            background: #f1f5f9;
            color: #0f172a;
        }

        .dark .ev-btn-secondary:hover {
            background: #334155;
            color: #f8fafc;
        }

        .ev-btn-link {
            display: inline-flex;
            align-items: center;
            gap: 0.375rem;
            color: #6366f1;
            font-size: 0.875rem;
            font-weight: 700;
            text-decoration: none;
            padding: 0.5rem 0.75rem;
            border-radius: 0.5rem;
            transition: background 0.15s ease;
        }

        .ev-btn-link:hover {
            background: rgba(99, 102, 241, 0.08);
        }

        /* ─── Empty State ─────────────────────────────────────────────────────────── */
        .ev-empty-card {
            background: #ffffff;
            border: 1px solid #e2e8f0;
            border-radius: 1.25rem;
            padding: 4rem 2rem;
            text-align: center;
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 1rem;
        }

        .dark .ev-empty-card {
            background: #0f172a;
            border-color: #1e293b;
        }

        .ev-empty-icon {
            width: 4.5rem;
            height: 4.5rem;
            border-radius: 1.25rem;
            background: #fef3c7;
            color: #d97706;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .dark .ev-empty-icon {
            background: rgba(217, 119, 6, 0.15);
            color: #fbbf24;
        }

        .ev-empty-icon svg {
            width: 2.25rem;
            height: 2.25rem;
        }

        .ev-empty-title {
            font-size: 1.25rem;
            font-weight: 800;
            color: #0f172a;
        }

        .dark .ev-empty-title {
            color: #f8fafc;
        }

        .ev-empty-desc {
            font-size: 0.875rem;
            color: #64748b;
            max-width: 28rem;
            line-height: 1.5;
        }

        .dark .ev-empty-desc {
            color: #94a3b8;
        }
    </style>

    @php
        $form = $record->registrationForm;
    @endphp

    <div class="ev-root">
        <!-- Live Form Preview Mode Banner -->
        <div class="ev-preview-banner">
            <div class="ev-preview-left">
                <div class="ev-preview-icon">
                    <svg fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z" />
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                    </svg>
                </div>
                <div>
                    <div class="ev-preview-title">
                        <span class="ev-pulse-dot"></span>
                        Live Interactive Form Preview Mode
                    </div>
                    <div class="ev-preview-desc">
                        Showing actual registration form for <strong>{{ $record->name }}</strong>. Test inputs and simulate submission below.
                    </div>
                </div>
            </div>
            <div>
                <a
                    href="{{ \App\Filament\Resources\Events\EventResource::getUrl('form', ['record' => $record]) }}"
                    class="ev-btn-link"
                >
                    <svg style="width:1rem;height:1rem" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
                    </svg>
                    Edit Form Builder
                </a>
            </div>
        </div>

        @if(!$form)
            <!-- Empty State -->
            <div class="ev-empty-card">
                <div class="ev-empty-icon">
                    <svg fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m3.75 9v6m3-3H9m1.5-12H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z" />
                    </svg>
                </div>
                <div class="ev-empty-title">No Registration Form Configured</div>
                <div class="ev-empty-desc">
                    This event does not have a customized registration form yet. Configure custom attendee fields and the required consent agreement in the form builder.
                </div>
                <a
                    href="{{ \App\Filament\Resources\Events\EventResource::getUrl('form', ['record' => $record]) }}"
                    class="ev-btn-primary"
                    style="margin-top: 0.5rem;"
                >
                    <svg fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                    </svg>
                    Customize Registration Form Now
                </a>
            </div>
        @else
            <!-- Main Event & Form Card -->
            <div class="ev-card">
                <!-- Banner / Header -->
                @php
                    $activeBanner = ($form && $form->banner) ? $form->banner : $record->banner;
                @endphp

                @if($activeBanner)
                    <div class="ev-hero-banner">
                        <img
                            src="{{ asset('storage/' . $activeBanner) }}"
                            alt="{{ $record->name }} Banner"
                            class="ev-hero-img"
                            onerror="this.style.display='none'"
                        />
                        <div class="ev-hero-overlay">
                            <div class="ev-hero-badge">
                                Official Event Registration
                            </div>
                            <div class="ev-hero-title">
                                {{ $record->name }}
                            </div>
                        </div>
                    </div>
                @else
                    <div class="ev-header-fallback">
                        <div class="ev-hero-badge">
                            Official Event Registration
                        </div>
                        <div class="ev-hero-title">
                            {{ $record->name }}
                        </div>
                    </div>
                @endif

                <div class="ev-card-body">
                    <!-- Key Dates Row -->
                    <div class="ev-dates-grid" style="grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));">
                        <div class="ev-date-pill">
                            <div class="ev-date-icon ev-date-icon-blue">
                                <svg fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 7.5v11.25m-18 0A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75m-18 0v-7.5A2.25 2.25 0 0 1 5.25 9h13.5A2.25 2.25 0 0 1 21 11.25v7.5" />
                                </svg>
                            </div>
                            <div>
                                <div class="ev-date-label">Event Date</div>
                                <div class="ev-date-val">
                                    {{ \Carbon\Carbon::parse($record->event_date)->format('F d, Y') }}
                                </div>
                            </div>
                        </div>

                        <div class="ev-date-pill">
                            <div class="ev-date-icon" style="background: rgba(99, 102, 241, 0.12); color: #4f46e5;">
                                <svg fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 10.5V6.75a4.5 4.5 0 1 1 9 0v3.75M3.75 21.75h10.5a2.25 2.25 0 0 0 2.25-2.25v-6.75a2.25 2.25 0 0 0-2.25-2.25H3.75a2.25 2.25 0 0 0-2.25 2.25v6.75a2.25 2.25 0 0 0 2.25 2.25Z" />
                                </svg>
                            </div>
                            <div>
                                <div class="ev-date-label">Registration Opens</div>
                                <div class="ev-date-val">
                                    @php
                                        $startDate = $form->registration_start_date ?? ($record->registration_start_date ?? $record->created_at);
                                    @endphp
                                    {{ \Carbon\Carbon::parse($startDate)->format('F d, Y') }}
                                </div>
                            </div>
                        </div>

                        <div class="ev-date-pill">
                            <div class="ev-date-icon ev-date-icon-emerald">
                                <svg fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                                </svg>
                            </div>
                            <div>
                                <div class="ev-date-label">Registration Deadline</div>
                                <div class="ev-date-val">
                                    @php
                                        $endDate = $form->registration_end_date ?? $record->registration_date;
                                    @endphp
                                    {{ \Carbon\Carbon::parse($endDate)->format('F d, Y') }}
                                </div>
                            </div>
                        </div>

                        <div class="ev-date-pill">
                            @php
                                $isOpen = $record->isRegistrationOpen() && ($form->is_open ?? true);
                            @endphp
                            <div class="ev-date-icon" style="background: {{ $isOpen ? 'rgba(16, 185, 129, 0.15)' : 'rgba(239, 68, 68, 0.15)' }}; color: {{ $isOpen ? '#059669' : '#dc2626' }};">
                                <svg fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                                </svg>
                            </div>
                            <div>
                                <div class="ev-date-label">Registration Status</div>
                                <div class="ev-date-val" style="color: {{ $isOpen ? '#059669' : '#dc2626' }};">
                                    {{ $isOpen ? 'Open Now' : ($form->is_open === false ? 'Closed' : $record->registration_status) }}
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Event Description -->
                    @if($record->description)
                        <div class="ev-desc-section">
                            <div class="ev-section-subtitle">About The Event</div>
                            <div class="ev-desc-content">
                                {!! $record->description !!}
                            </div>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Actual Registration Form Fields Card -->
            <div class="ev-card">
                <div class="ev-card-body">
                    <!-- Form Title & Instructions -->
                    <div class="ev-form-header">
                        <div class="ev-form-title">
                            {{ $form->title ?: ('Registration Form - ' . $record->name) }}
                        </div>
                        @if($form->description)
                            <div class="ev-form-instructions">
                                {{ $form->description }}
                            </div>
                        @endif
                    </div>

                    <!-- Validation Success Result Alert -->
                    @if($previewValidationResult)
                        <div class="ev-alert-success">
                            <svg fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                            </svg>
                            <div>
                                <strong style="font-size: 0.9375rem;">Registration Validated!</strong>
                                <div style="font-size: 0.8125rem; margin-top: 0.125rem;">
                                    {{ $previewValidationResult }}
                                </div>
                            </div>
                        </div>
                    @endif

                    <!-- Dynamic Fields -->
                    <div class="ev-fields-stack">
                        <div class="ev-section-subtitle" style="display:flex; align-items:center; gap:0.375rem;">
                            <svg style="width:0.875rem;height:0.875rem" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L6.832 19.82a4.5 4.5 0 0 1-1.897 1.13l-2.685.8.8-2.685a4.5 4.5 0 0 1 1.13-1.897L16.863 4.487Zm0 0L19.5 7.125" />
                            </svg>
                            Attendee Information
                        </div>

                        @php
                            $fields = $form->fields ?? [];
                        @endphp

                        @forelse($fields as $index => $field)
                            @php
                                $key = 'field_' . $index;
                                $type = $field['type'] ?? 'text';
                                $label = $field['label'] ?? ('Field ' . ($index + 1));
                                $isRequired = (bool)($field['is_required'] ?? false);
                                $placeholder = $field['placeholder'] ?? '';
                                $helpText = $field['help_text'] ?? '';
                                $options = (array)($field['options'] ?? []);
                            @endphp

                            <div class="ev-field-group">
                                <label class="ev-label">
                                    {{ $label }}
                                    @if($isRequired)
                                        <span class="ev-req">*</span>
                                    @endif
                                </label>

                                <!-- 1. Single-line Text -->
                                @if($type === 'text')
                                    <input
                                        type="text"
                                        wire:model="formData.{{ $key }}"
                                        placeholder="{{ $placeholder ?: 'Enter text...' }}"
                                        class="ev-input"
                                    />

                                <!-- 2. Multi-line Textarea -->
                                @elseif($type === 'textarea')
                                    <textarea
                                        wire:model="formData.{{ $key }}"
                                        placeholder="{{ $placeholder ?: 'Type your response here...' }}"
                                        class="ev-textarea"
                                    ></textarea>

                                <!-- 3. Radio Box -->
                                @elseif($type === 'radio')
                                    <div class="ev-radio-grid">
                                        @forelse($options as $opt)
                                            <label class="ev-radio-card">
                                                <input
                                                    type="radio"
                                                    name="radio_{{ $key }}"
                                                    value="{{ $opt }}"
                                                    wire:model.live="formData.{{ $key }}"
                                                />
                                                <span>{{ $opt }}</span>
                                            </label>
                                        @empty
                                            <span style="font-size: 0.8125rem; color: #94a3b8; font-style: italic;">No options specified</span>
                                        @endforelse
                                    </div>

                                <!-- 4. Selection Box (Dropdown) -->
                                @elseif($type === 'select')
                                    <select
                                        wire:model.live="formData.{{ $key }}"
                                        class="ev-select"
                                    >
                                        <option value="">{{ $placeholder ?: '-- Please Select an Option --' }}</option>
                                        @foreach($options as $opt)
                                            <option value="{{ $opt }}">{{ $opt }}</option>
                                        @endforeach
                                    </select>

                                <!-- 5. Upload Images -->
                                @elseif($type === 'image_upload')
                                    <div class="ev-upload-container">
                                        <input
                                            type="file"
                                            accept="image/*"
                                            wire:model="uploadedImages.{{ $key }}"
                                            id="input_{{ $key }}"
                                            style="display:none;"
                                        />
                                        <label for="input_{{ $key }}" class="ev-dropzone">
                                            <div class="ev-dropzone-icon">
                                                <svg fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="m2.25 15.75 5.159-5.159a2.25 2.25 0 0 1 3.182 0l5.159 5.159m-1.5-1.5 1.409-1.409a2.25 2.25 0 0 1 3.182 0l2.909 2.909m-18 3.75h16.5a1.5 1.5 0 0 0 1.5-1.5V6a1.5 1.5 0 0 0-1.5-1.5H3.75A1.5 1.5 0 0 0 2.25 6v12a1.5 1.5 0 0 0 1.5 1.5Zm10.5-11.25h.008v.008h-.008V8.25Zm.375 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Z" />
                                                </svg>
                                            </div>
                                            <span class="ev-dropzone-btn">Click to browse image or photo</span>
                                            <span class="ev-dropzone-hint">PNG, JPG, WEBP, GIF up to 5MB</span>
                                        </label>

                                        @if(!empty($uploadedImages[$key]))
                                            <div class="ev-file-chip">
                                                <svg fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                                                </svg>
                                                <span>Image Selected: {{ $uploadedImages[$key]->getClientOriginalName() }}</span>
                                            </div>
                                        @endif
                                    </div>
                                @endif

                                @if($helpText)
                                    <div class="ev-help">{{ $helpText }}</div>
                                @endif
                            </div>
                        @empty
                            <div style="font-size: 0.875rem; color: #94a3b8; font-style: italic;">
                                No custom fields configured yet. Go to Form Builder to add fields.
                            </div>
                        @endforelse
                    </div>

                    <!-- Mandatory Consent Agreement -->
                    <div class="ev-consent-box">
                        <div class="ev-consent-heading">
                            <div class="ev-consent-badge-icon">
                                <svg fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75m-3-7.036A11.959 11.959 0 0 1 3.598 6 11.99 11.99 0 0 0 3 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751h-.152c-3.196 0-6.1-1.248-8.25-3.285Z" />
                                </svg>
                            </div>
                            <div class="ev-consent-title">
                                {{ $form->consent_title ?: 'Consent & Data Privacy Agreement' }}
                                <span class="ev-req">*</span>
                            </div>
                        </div>

                        <!-- Terms Text Box -->
                        <div class="ev-consent-terms">{{ $form->consent_body }}</div>

                        <!-- Agreement Checkbox -->
                        <label class="ev-agreement-card">
                            <input
                                type="checkbox"
                                wire:model.live="consentAgreed"
                            />
                            <div class="ev-agreement-text">
                                {{ $form->consent_checkbox_label ?: 'I have read, understood, and voluntarily agree to the terms and privacy consent.' }}
                                <span class="ev-req">*</span>
                            </div>
                        </label>
                    </div>

                    <!-- Actions -->
                    <div class="ev-footer">
                        <div class="ev-footer-left">
                            <button
                                type="button"
                                wire:click="testSubmit"
                                class="ev-btn-primary"
                            >
                                <svg fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 12 3.269 3.125A59.769 59.769 0 0 1 21.485 12 59.768 59.768 0 0 1 3.27 20.875L5.999 12Zm0 0h7.5" />
                                </svg>
                                Submit Registration (Preview Test)
                            </button>

                            <button
                                type="button"
                                wire:click="resetPreviewForm"
                                class="ev-btn-secondary"
                            >
                                <svg style="width:1rem;height:1rem" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.993m-4.993 0 3.181 3.183a8.25 8.25 0 0 0 13.803-3.7M4.031 9.865a8.25 8.25 0 0 1 13.803-3.7l3.181 3.182m0-4.991v4.99" />
                                </svg>
                                Clear / Reset
                            </button>
                        </div>

                        <a
                            href="{{ \App\Filament\Resources\Events\EventResource::getUrl('form', ['record' => $record]) }}"
                            class="ev-btn-link"
                        >
                            <svg style="width:1rem;height:1rem" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
                            </svg>
                            Back to Form Builder
                        </a>
                    </div>
                </div>
            </div>
        @endif
    </div>
</x-filament-panels::page>
