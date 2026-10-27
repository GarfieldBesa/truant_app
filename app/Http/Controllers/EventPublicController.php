<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\EventRegistration;
use App\Models\EventTeam;
use App\Models\EventTeamMember;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class EventPublicController extends Controller
{
    /**
     * Display the public landing page with events list.
     */
    public function index(Request $request)
    {
        if (! Schema::hasTable('events')) {
            $events = new LengthAwarePaginator([], 0, 6);
            return view('welcome', compact('events'));
        }

        $events = Event::with(['registrationForm', 'registrations', 'teams.members.registration'])
            ->orderByRaw("CASE WHEN event_date >= ? THEN 0 ELSE 1 END, event_date ASC", [now()->toDateString()])
            ->paginate(6);

        return view('welcome', compact('events'));
    }

    /**
     * Display the dedicated public event content page with registration option.
     */
    public function show(Event $event)
    {
        $event->load(['registrationForm', 'registrations', 'teams.members.registration']);

        return view('events.show', compact('event'));
    }

    /**
     * Display or return all registered players for the event, grouped by teams.
     */
    public function registeredPlayers(Request $request, Event $event)
    {
        $roster = $event->getGroupedPlayers();

        if ($request->wantsJson() || $request->ajax()) {
            return response()->json([
                'success' => true,
                'data' => $roster,
            ]);
        }

        return view('events.players', compact('event', 'roster'));
    }

    /**
     * Handle public registration submission for an event.
     */
    public function register(Request $request, Event $event)
    {
        $form = $event->registrationForm;

        if (! $form || ! $event->isRegistrationOpen()) {
            return back()->with('error', 'Registration for this event is currently closed.');
        }

        $fields = $form->fields ?? [];
        $rules = [];
        $customMessages = [];

        // Validate mandatory consent
        $rules['consent_agreed'] = ['required', 'accepted'];
        $consentTitle = $form->consent_title ?: 'Consent Agreement';
        $customMessages['consent_agreed.accepted'] = "You must review and agree to the {$consentTitle} to submit your registration.";
        $customMessages['consent_agreed.required'] = "You must agree to the {$consentTitle}.";

        // Dynamic form field validations
        foreach ($fields as $index => $field) {
            $fieldName = 'field_' . $index;
            $label = $field['label'] ?? "Field {$index}";
            $isRequired = (bool) ($field['is_required'] ?? false);
            $type = $field['type'] ?? 'text';

            if ($type === 'image_upload') {
                $fieldRules = ['nullable', 'image', 'max:5120']; // 5MB max
                if ($isRequired) {
                    $fieldRules = ['required', 'image', 'max:5120'];
                }
            } elseif ($type === 'select' || $type === 'radio') {
                $fieldRules = $isRequired ? ['required'] : ['nullable'];
            } else {
                $fieldRules = $isRequired ? ['required', 'string'] : ['nullable', 'string'];
            }

            $rules[$fieldName] = $fieldRules;
            $customMessages["{$fieldName}.required"] = "The '{$label}' field is required.";
            $customMessages["{$fieldName}.image"] = "The '{$label}' must be a valid image file.";
        }

        $validated = $request->validate($rules, $customMessages);

        // Process dynamic fields
        $data = [];
        foreach ($fields as $index => $field) {
            $fieldName = 'field_' . $index;
            $label = $field['label'] ?? "Field {$index}";
            $type = $field['type'] ?? 'text';

            if ($type === 'image_upload') {
                if ($request->hasFile($fieldName)) {
                    $path = $request->file($fieldName)->store('events/registrations', 'public');
                    $data[$label] = $path;
                } else {
                    $data[$label] = null;
                }
            } else {
                $data[$label] = $request->input($fieldName, '');
            }
        }

        // Check if Name & Last Name or Full Name is already registered
        $candidateName = EventRegistration::extractNameFromData($data);
        $reusedRef = null;

        if ($candidateName) {
            // Check if already registered for this specific event
            $alreadyInThisEvent = EventRegistration::findInEventByName($candidateName, $event->id);
            if ($alreadyInThisEvent) {
                return back()
                    ->withInput()
                    ->with('error', "You are already registered for this event with Ref# {$alreadyInThisEvent->registration_reference}.");
            }

            // Check if existing information exists in database (e.g. from another event)
            $existingOther = EventRegistration::findExistingByName($candidateName, $event->id);
            if ($existingOther) {
                $reusedRef = $existingOther->registration_reference;

                // If not yet confirmed by user, prompt with confirmation message
                if ($request->input('confirm_reuse_ref') != '1') {
                    return back()
                        ->withInput()
                        ->with('ref_reuse_prompt', true)
                        ->with('existing_ref', $reusedRef)
                        ->with('existing_name', $existingOther->getAttendeeName())
                        ->with('reuse_message', 'Information already exist Ref# will be reused to register on this event. Click to confirm and register');
                }
            }
        }

        // Determine reference number to use
        $referenceToSave = null;
        if ($request->input('confirm_reuse_ref') == '1' && $request->filled('reused_reference')) {
            $referenceToSave = trim((string) $request->input('reused_reference'));
        } elseif ($reusedRef) {
            $referenceToSave = $reusedRef;
        }

        $regAttributes = [
            'event_id' => $event->id,
            'data' => $data,
            'consent_agreed' => true,
            'ip_address' => $request->ip(),
        ];

        if ($referenceToSave) {
            $regAttributes['registration_reference'] = $referenceToSave;
        }

        $registration = EventRegistration::create($regAttributes);

        return redirect()->route('events.public.show', $event)
            ->with('registration_success', true)
            ->with('reference_code', $registration->registration_reference)
            ->with('message', "Your registration was successful! Please save your reference code: {$registration->registration_reference}");
    }

    /**
     * Handle quick registration using an existing attendee Ref# for this event.
     */
    public function registerByReference(Request $request, Event $event)
    {
        if (! $event->isRegistrationOpen()) {
            return back()->with('error', 'Registration for this event is currently closed.');
        }

        $request->validate([
            'ref_code' => ['required', 'string', 'max:100'],
        ], [
            'ref_code.required' => 'Please enter your registration reference number.',
        ]);

        $refCode = trim((string) $request->input('ref_code'));

        // Search for existing registration with this Ref# across any event in the database
        $existing = EventRegistration::whereRaw('LOWER(registration_reference) = ?', [strtolower($refCode)])
            ->latest('id')
            ->first();

        if (! $existing) {
            return back()
                ->withInput()
                ->with('quick_reg_error', "Reference number '{$refCode}' was not found. Please check your reference code or complete the registration form below.");
        }

        // Check if already registered for THIS specific event
        $alreadyInThisEvent = EventRegistration::where('event_id', $event->id)
            ->whereRaw('LOWER(registration_reference) = ?', [strtolower($existing->registration_reference)])
            ->first();

        if ($alreadyInThisEvent) {
            return back()
                ->withInput()
                ->with('error', "You are already registered for this event with Ref# {$alreadyInThisEvent->registration_reference}.");
        }

        // Check if attendee name is already registered for this event under another reference
        $attendeeName = $existing->getAttendeeName();
        $alreadyByName = EventRegistration::findInEventByName($attendeeName, $event->id);
        if ($alreadyByName) {
            return back()
                ->withInput()
                ->with('error', "Attendee '{$attendeeName}' is already registered for this event with Ref# {$alreadyByName->registration_reference}.");
        }

        // Automatically register the attendee to this event reusing their reference number and profile data
        $registration = EventRegistration::create([
            'event_id' => $event->id,
            'registration_reference' => $existing->registration_reference,
            'data' => $existing->data ?? [],
            'consent_agreed' => true,
            'ip_address' => $request->ip(),
        ]);

        return redirect()->route('events.public.show', $event)
            ->with('registration_success', true)
            ->with('reference_code', $registration->registration_reference)
            ->with('message', "Welcome back, {$attendeeName}! You have been automatically registered for {$event->name} with Ref# {$registration->registration_reference}. You can now also be added to a team for this event!");
    }

    /**
     * AJAX/API endpoint: Lookup an attendee by Ref# for team registration.
     */
    public function lookupTeamMember(Request $request, Event $event)
    {
        $ref = trim((string) $request->input('ref_code', ''));

        if (empty($ref)) {
            return response()->json([
                'success' => false,
                'message' => 'Please enter a registration reference number.',
            ], 422);
        }

        // Verify if registered to THIS event (case-insensitive)
        $registration = EventRegistration::where('event_id', $event->id)
            ->whereRaw('LOWER(registration_reference) = ?', [strtolower($ref)])
            ->first();

        if (! $registration) {
            return response()->json([
                'success' => false,
                'message' => 'Ref# is not registered to this event.',
            ]);
        }

        return response()->json([
            'success' => true,
            'id' => $registration->id,
            'ref' => $registration->registration_reference,
            'name' => $registration->getAttendeeName(),
        ]);
    }

    /**
     * Handle public team registration submission.
     */
    public function registerTeam(Request $request, Event $event)
    {
        $request->validate([
            'team_name' => ['required', 'string', 'max:120'],
            'member_refs' => ['required', 'array', 'min:1'],
        ], [
            'team_name.required' => 'Please provide a team name.',
            'member_refs.required' => 'Please add at least one registered player to the team.',
            'member_refs.min' => 'Please add at least one registered player to the team.',
        ]);

        $teamName = trim((string) $request->input('team_name'));

        // Validation: Avoid duplicate team name for this event (case-insensitive)
        $existingTeam = EventTeam::where('event_id', $event->id)
            ->whereRaw('LOWER(team_name) = ?', [strtolower($teamName)])
            ->first();

        if ($existingTeam) {
            return back()
                ->withInput()
                ->withErrors(['team_name' => "The team name '{$teamName}' has already been registered for this event. Please choose a different team name."]);
        }

        // Validate all member reference numbers belong to THIS event
        $memberRefs = array_unique(array_filter(array_map('trim', (array) $request->input('member_refs'))));
        if (empty($memberRefs)) {
            return back()
                ->withInput()
                ->withErrors(['member_refs' => 'Please add at least one verified team member.']);
        }

        $validMembers = [];
        foreach ($memberRefs as $ref) {
            $reg = EventRegistration::where('event_id', $event->id)
                ->whereRaw('LOWER(registration_reference) = ?', [strtolower($ref)])
                ->first();

            if (! $reg) {
                return back()
                    ->withInput()
                    ->withErrors(['member_refs' => "Ref# {$ref} is not registered to this event."]);
            }

            $validMembers[] = $reg;
        }

        // Create EventTeam
        $team = EventTeam::create([
            'event_id' => $event->id,
            'team_name' => $teamName,
        ]);

        // Attach members
        foreach ($validMembers as $memberReg) {
            EventTeamMember::create([
                'event_team_id' => $team->id,
                'event_registration_id' => $memberReg->id,
                'registration_reference' => $memberReg->registration_reference,
                'member_name' => $memberReg->getAttendeeName(),
            ]);
        }

        return redirect()->route('events.public.show', $event)
            ->with('team_registration_success', true)
            ->with('team_name', $team->team_name)
            ->with('team_reference', $team->team_reference)
            ->with('team_members_count', count($validMembers))
            ->with('message', "Team '{$team->team_name}' successfully registered! Reference: {$team->team_reference}");
    }
}
