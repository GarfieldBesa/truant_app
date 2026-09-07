@php
    $attendeeName = $record->getAttendeeName();
    $events = $record->getAllEventsForReference();
    $teams = $record->getAllTeamsForReference();
    $profileData = $record->getCombinedData();
    
    // Compute initials
    $words = explode(' ', trim($attendeeName));
    $initials = '';
    foreach (array_slice($words, 0, 2) as $w) {
        $initials .= strtoupper(substr($w, 0, 1));
    }
    if (empty($initials)) {
        $initials = 'U';
    }
@endphp

<div class="user-details-modal-wrapper" style="font-family: inherit; color: #1e293b;">
    <!-- 1. Top Summary Banner -->
    <div style="background: linear-gradient(135deg, #f8fafc 0%, #eef2ff 100%); border: 1px solid #e2e8f0; border-radius: 14px; padding: 22px; margin-bottom: 24px;">
        <div style="display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 16px;">
            <div style="display: flex; align-items: center; gap: 16px;">
                <div style="width: 54px; height: 54px; border-radius: 50%; background: linear-gradient(135deg, #4f46e5 0%, #3b82f6 100%); color: #ffffff; display: flex; align-items: center; justify-content: center; font-size: 1.35rem; font-weight: 800; box-shadow: 0 4px 12px rgba(79, 70, 229, 0.25); flex-shrink: 0;">
                    {{ $initials }}
                </div>
                <div>
                    <h2 style="font-size: 1.35rem; font-weight: 800; color: #0f172a; margin: 0; line-height: 1.2;">
                        {{ $attendeeName }}
                    </h2>
                    <div style="display: flex; align-items: center; gap: 8px; margin-top: 6px; flex-wrap: wrap;">
                        <span style="display: inline-flex; align-items: center; gap: 4px; background: #ffffff; border: 1px solid #cbd5e1; padding: 2px 10px; border-radius: 6px; font-family: monospace; font-size: 0.85rem; font-weight: 700; color: #4f46e5;">
                            Ref: {{ $record->registration_reference }}
                        </span>
                        <span style="font-size: 0.85rem; color: #64748b;">
                            First Registered: <strong>{{ $record->created_at ? $record->created_at->format('M d, Y h:i A') : '—' }}</strong>
                        </span>
                    </div>
                </div>
            </div>

            <div style="display: flex; gap: 10px; flex-wrap: wrap;">
                <div style="background: #ffffff; border: 1px solid #e2e8f0; border-radius: 10px; padding: 10px 16px; text-align: center; min-width: 95px; box-shadow: 0 1px 3px rgba(0,0,0,0.03);">
                    <div style="font-size: 0.75rem; font-weight: 700; text-transform: uppercase; color: #64748b; letter-spacing: 0.04em;">Events</div>
                    <div style="font-size: 1.25rem; font-weight: 800; color: #4f46e5;">{{ $events->count() }}</div>
                </div>
                <div style="background: #ffffff; border: 1px solid #e2e8f0; border-radius: 10px; padding: 10px 16px; text-align: center; min-width: 95px; box-shadow: 0 1px 3px rgba(0,0,0,0.03);">
                    <div style="font-size: 0.75rem; font-weight: 700; text-transform: uppercase; color: #64748b; letter-spacing: 0.04em;">Teams</div>
                    <div style="font-size: 1.25rem; font-weight: 800; color: #059669;">{{ $teams->count() }}</div>
                </div>
            </div>
        </div>
    </div>

    <!-- 2. Profile Information / Submitted Form Data -->
    <div style="margin-bottom: 28px;">
        <h3 style="font-size: 1.05rem; font-weight: 700; color: #0f172a; margin-bottom: 12px; display: flex; align-items: center; gap: 8px;">
            <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" style="color: #4f46e5;">
                <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
            </svg>
            <span>Attendee Profile &amp; Submitted Information</span>
        </h3>

        @if (empty($profileData))
            <div style="padding: 14px; background: #f8fafc; border: 1px dashed #cbd5e1; border-radius: 8px; color: #64748b; font-size: 0.875rem; text-align: center;">
                No additional profile fields recorded.
            </div>
        @else
            <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(240px, 1fr)); gap: 12px;">
                @foreach ($profileData as $label => $val)
                    @php
                        $isImage = is_string($val) && (str_starts_with($val, 'events/registrations/') || preg_match('/\.(jpg|jpeg|png|webp|gif)$/i', $val));
                    @endphp
                    <div style="background: #ffffff; border: 1px solid #e2e8f0; border-radius: 10px; padding: 12px 16px;">
                        <div style="font-size: 0.78rem; font-weight: 600; text-transform: uppercase; color: #64748b; letter-spacing: 0.03em; margin-bottom: 4px;">
                            {{ $label }}
                        </div>
                        @if ($isImage)
                            <a href="{{ \Illuminate\Support\Facades\Storage::url($val) }}" target="_blank" style="display: inline-block; margin-top: 4px;">
                                <img src="{{ \Illuminate\Support\Facades\Storage::url($val) }}" alt="{{ $label }}" style="max-height: 80px; border-radius: 6px; border: 1px solid #e2e8f0; object-fit: cover;">
                            </a>
                        @else
                            <div style="font-size: 0.95rem; font-weight: 600; color: #0f172a; word-break: break-word;">
                                {{ is_array($val) ? implode(', ', $val) : ($val ?: '—') }}
                            </div>
                        @endif
                    </div>
                @endforeach
            </div>
        @endif
    </div>

    <!-- 3. Registered Events Table -->
    <div style="margin-bottom: 28px;">
        <h3 style="font-size: 1.05rem; font-weight: 700; color: #0f172a; margin-bottom: 12px; display: flex; align-items: center; gap: 8px;">
            <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" style="color: #4f46e5;">
                <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
            </svg>
            <span>Registered Events ({{ $events->count() }})</span>
        </h3>

        @if ($events->isEmpty())
            <div style="padding: 16px; background: #f8fafc; border: 1px dashed #cbd5e1; border-radius: 8px; color: #64748b; font-size: 0.875rem; text-align: center;">
                No registered events found for this attendee.
            </div>
        @else
            <div style="overflow-x: auto; border: 1px solid #e2e8f0; border-radius: 10px; background: #ffffff;">
                <table style="width: 100%; border-collapse: collapse; font-size: 0.875rem; text-align: left;">
                    <thead>
                        <tr style="background: #f8fafc; border-bottom: 2px solid #e2e8f0;">
                            <th style="padding: 10px 14px; font-weight: 700; color: #475569;">#</th>
                            <th style="padding: 10px 14px; font-weight: 700; color: #475569;">Event Name</th>
                            <th style="padding: 10px 14px; font-weight: 700; color: #475569;">Event Date</th>
                            <th style="padding: 10px 14px; font-weight: 700; color: #475569;">Admission</th>
                            <th style="padding: 10px 14px; font-weight: 700; color: #475569;">Registration Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($events as $index => $reg)
                            @php
                                $evt = $reg->event;
                                $isFree = $evt ? $evt->isFreeAdmission() : true;
                            @endphp
                            <tr style="border-bottom: 1px solid #f1f5f9;">
                                <td style="padding: 12px 14px; color: #64748b; font-weight: 600;">{{ $index + 1 }}</td>
                                <td style="padding: 12px 14px; font-weight: 700; color: #0f172a;">
                                    {{ $evt ? $evt->name : 'Unknown Event #' . $reg->event_id }}
                                </td>
                                <td style="padding: 12px 14px; color: #334155;">
                                    {{ $evt && $evt->event_date ? $evt->event_date->format('M d, Y') : '—' }}
                                </td>
                                <td style="padding: 12px 14px;">
                                    <span style="display: inline-block; padding: 2px 8px; border-radius: 6px; font-size: 0.78rem; font-weight: 700; background: {{ $isFree ? '#ecfdf5' : '#eff6ff' }}; color: {{ $isFree ? '#065f46' : '#1e40af' }}; border: 1px solid {{ $isFree ? '#a7f3d0' : '#bfdbfe' }};">
                                        {{ $evt ? $evt->admission_label : 'Free' }}{{ (! $isFree && $evt && $evt->ticket_price) ? ' (' . $evt->ticket_price . ')' : '' }}
                                    </span>
                                </td>
                                <td style="padding: 12px 14px; color: #64748b;">
                                    {{ $reg->created_at ? $reg->created_at->format('M d, Y h:i A') : '—' }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>

    <!-- 4. Registered Teams Section -->
    <div>
        <h3 style="font-size: 1.05rem; font-weight: 700; color: #0f172a; margin-bottom: 12px; display: flex; align-items: center; gap: 8px;">
            <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" style="color: #059669;">
                <path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
            </svg>
            <span>Registered Teams ({{ $teams->count() }})</span>
        </h3>

        @if ($teams->isEmpty())
            <div style="padding: 16px; background: #f8fafc; border: 1px dashed #cbd5e1; border-radius: 8px; color: #64748b; font-size: 0.875rem; text-align: center;">
                This user has not joined or registered in any teams yet.
            </div>
        @else
            <div style="overflow-x: auto; border: 1px solid #e2e8f0; border-radius: 10px; background: #ffffff;">
                <table style="width: 100%; border-collapse: collapse; font-size: 0.875rem; text-align: left;">
                    <thead>
                        <tr style="background: #f8fafc; border-bottom: 2px solid #e2e8f0;">
                            <th style="padding: 10px 14px; font-weight: 700; color: #475569;">#</th>
                            <th style="padding: 10px 14px; font-weight: 700; color: #475569;">Team Name</th>
                            <th style="padding: 10px 14px; font-weight: 700; color: #475569;">Event</th>
                            <th style="padding: 10px 14px; font-weight: 700; color: #475569;">Team Reference</th>
                            <th style="padding: 10px 14px; font-weight: 700; color: #475569;">Added At</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($teams as $index => $tm)
                            @php
                                $team = $tm->team;
                                $teamEvent = $team ? $team->event : null;
                            @endphp
                            <tr style="border-bottom: 1px solid #f1f5f9;">
                                <td style="padding: 12px 14px; color: #64748b; font-weight: 600;">{{ $index + 1 }}</td>
                                <td style="padding: 12px 14px; font-weight: 700; color: #0f172a;">
                                    {{ $team ? $team->team_name : '—' }}
                                </td>
                                <td style="padding: 12px 14px; color: #334155;">
                                    {{ $teamEvent ? $teamEvent->name : '—' }}
                                </td>
                                <td style="padding: 12px 14px;">
                                    <code style="background: #f1f5f9; padding: 2px 6px; border-radius: 4px; font-family: monospace; font-weight: 600; color: #0f172a;">
                                        {{ $team ? $team->team_reference : '—' }}
                                    </code>
                                </td>
                                <td style="padding: 12px 14px; color: #64748b;">
                                    {{ $tm->created_at ? $tm->created_at->format('M d, Y h:i A') : '—' }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
</div>
