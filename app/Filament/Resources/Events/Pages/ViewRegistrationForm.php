<?php

namespace App\Filament\Resources\Events\Pages;

use App\Filament\Resources\Events\EventResource;
use App\Models\Event;
use App\Models\EventRegistration;
use Filament\Actions\Action;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\Concerns\InteractsWithRecord;
use Filament\Resources\Pages\Page;
use Filament\Support\Icons\Heroicon;
use Livewire\WithFileUploads;

class ViewRegistrationForm extends Page
{
    use InteractsWithRecord;
    use WithFileUploads;

    protected static string $resource = EventResource::class;

    protected string $view = 'filament.resources.events.pages.view-registration-form';

    public array $formData = [];
    public $uploadedImages = [];
    public bool $consentAgreed = false;
    public ?string $previewValidationResult = null;

    public function mount(int|string $record): void
    {
        $this->record = $this->resolveRecord($record);
        $this->resetPreviewForm();
    }

    public function resetPreviewForm(): void
    {
        $fields = $this->record->registrationForm?->fields ?? [];
        $this->formData = [];
        $this->uploadedImages = [];
        foreach ($fields as $index => $field) {
            $key = 'field_' . $index;
            $this->formData[$key] = '';
            $this->uploadedImages[$key] = null;
        }
        $this->consentAgreed = false;
        $this->previewValidationResult = null;
    }

    public function testSubmit(): void
    {
        $form = $this->record->registrationForm;

        if (! $form) {
            Notification::make()
                ->warning()
                ->title('No Form Setup')
                ->body('Please customize the registration form first.')
                ->send();
            return;
        }

        $fields = $form->fields ?? [];
        $errors = [];

        // 1. Check each field requirement
        foreach ($fields as $index => $field) {
            $key = 'field_' . $index;
            $isRequired = (bool) ($field['is_required'] ?? false);
            $type = $field['type'] ?? 'text';

            if ($isRequired) {
                if ($type === 'image_upload') {
                    if (empty($this->uploadedImages[$key])) {
                        $errors[] = "Field '{$field['label']}' is required (please select an image).";
                    }
                } else {
                    $val = $this->formData[$key] ?? '';
                    if (is_array($val)) {
                        if (empty($val)) {
                            $errors[] = "Field '{$field['label']}' is required.";
                        }
                    } elseif (trim((string) $val) === '') {
                        $errors[] = "Field '{$field['label']}' is required.";
                    }
                }
            }
        }

        // 2. Validate mandatory consent agreement
        if (! $this->consentAgreed) {
            $errors[] = 'You must review and agree to the ' . ($form->consent_title ?: 'Consent Agreement') . '.';
        }

        if (! empty($errors)) {
            $this->previewValidationResult = null;
            Notification::make()
                ->danger()
                ->title('Preview Validation Failed')
                ->body(implode(' ', $errors))
                ->send();
            return;
        }

        $this->previewValidationResult = 'All fields and consent requirements passed validation successfully!';
        Notification::make()
            ->success()
            ->title('Registration Simulation Passed')
            ->body('All inputs and the mandatory consent form are valid.')
            ->send();
    }

    public function submitRegistration(): void
    {
        $form = $this->record->registrationForm;

        if (! $form) {
            Notification::make()
                ->warning()
                ->title('No Form Setup')
                ->body('Please customize the registration form first.')
                ->send();
            return;
        }

        $fields = $form->fields ?? [];
        $data = [];
        $errors = [];

        foreach ($fields as $index => $field) {
            $key = 'field_' . $index;
            $label = $field['label'] ?? "Field {$index}";
            $isRequired = (bool) ($field['is_required'] ?? false);
            $type = $field['type'] ?? 'text';

            if ($type === 'image_upload') {
                if ($this->uploadedImages[$key] ?? null) {
                    $path = $this->uploadedImages[$key]->store('events/registrations', 'public');
                    $data[$label] = $path;
                } else {
                    $data[$label] = null;
                    if ($isRequired) {
                        $errors[] = "Field '{$label}' is required.";
                    }
                }
            } else {
                $val = $this->formData[$key] ?? '';
                $data[$label] = $val;
                if ($isRequired && (is_array($val) ? empty($val) : trim((string) $val) === '')) {
                    $errors[] = "Field '{$label}' is required.";
                }
            }
        }

        if (! $this->consentAgreed) {
            $errors[] = 'You must review and agree to the ' . ($form->consent_title ?: 'Consent Agreement') . '.';
        }

        if (! empty($errors)) {
            Notification::make()
                ->danger()
                ->title('Registration Submission Failed')
                ->body(implode(' ', $errors))
                ->send();
            return;
        }

        $registration = EventRegistration::create([
            'event_id' => $this->record->id,
            'data' => $data,
            'consent_agreed' => true,
            'ip_address' => request()->ip(),
        ]);

        $this->resetPreviewForm();

        Notification::make()
            ->success()
            ->title('Registration Submitted Successfully!')
            ->body("Your registration reference code is {$registration->registration_reference}.")
            ->send();
    }

    protected function getHeaderActions(): array
    {
        return [
            Action::make('registrations')
                ->label('Registered People (' . $this->record->registrations()->count() . ')')
                ->icon(Heroicon::OutlinedUsers)
                ->color('success')
                ->url(fn (): string => EventResource::getUrl('registrations', ['record' => $this->record])),
            Action::make('customize_form')
                ->label('Customize Form Builder')
                ->icon(Heroicon::OutlinedPencilSquare)
                ->color('primary')
                ->url(fn (): string => EventResource::getUrl('form', ['record' => $this->record])),
            Action::make('edit_event')
                ->label('Event Details')
                ->icon(Heroicon::OutlinedPencil)
                ->color('gray')
                ->url(fn (): string => EventResource::getUrl('edit', ['record' => $this->record])),
            Action::make('back')
                ->label('Back to Events')
                ->icon(Heroicon::OutlinedArrowLeft)
                ->color('gray')
                ->url(fn (): string => EventResource::getUrl('index')),
        ];
    }
}
