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
use Illuminate\Support\Collection;

class ViewEventRegistrations extends Page
{
    use InteractsWithRecord;

    protected static string $resource = EventResource::class;

    protected string $view = 'filament.resources.events.pages.view-event-registrations';

    public string $selectedColumn = 'all';
    public string $filterValue = '';
    public string $searchQuery = '';
    public ?string $dateFrom = null;
    public ?string $dateTo = null;

    public function mount(int|string $record): void
    {
        $this->record = $this->resolveRecord($record);
    }

    public function getFormFieldsProperty(): array
    {
        return $this->record->registrationForm?->fields ?? [];
    }

    public function getFilterColumnOptionsProperty(): array
    {
        $options = [
            'all' => '— All Form Columns (Global) —',
            'registration_reference' => 'Registration Ref / Code',
        ];

        foreach ($this->formFields as $field) {
            $label = $field['label'] ?? '';
            if ($label) {
                $options[$label] = $label . ' [' . ucfirst(str_replace('_', ' ', $field['type'] ?? 'text')) . ']';
            }
        }

        return $options;
    }

    public function getSelectedFieldDefinitionProperty(): ?array
    {
        if ($this->selectedColumn === 'all' || $this->selectedColumn === 'registration_reference') {
            return null;
        }

        foreach ($this->formFields as $field) {
            if (($field['label'] ?? '') === $this->selectedColumn) {
                return $field;
            }
        }

        return null;
    }

    public function updatedSelectedColumn(): void
    {
        $this->filterValue = '';
    }

    public function clearFilters(): void
    {
        $this->selectedColumn = 'all';
        $this->filterValue = '';
        $this->searchQuery = '';
        $this->dateFrom = null;
        $this->dateTo = null;

        Notification::make()
            ->info()
            ->title('Filters Reset')
            ->body('All registration filters have been cleared.')
            ->send();
    }

    public function getRegistrationsProperty(): Collection
    {
        $query = $this->record->registrations()->latest();

        if ($this->dateFrom) {
            $query->whereDate('created_at', '>=', $this->dateFrom);
        }

        if ($this->dateTo) {
            $query->whereDate('created_at', '<=', $this->dateTo);
        }

        $records = $query->get();

        // Dynamic in-memory filtering for JSON field matching
        return $records->filter(function (EventRegistration $reg) {
            // 1. Global Search
            if (! empty(trim($this->searchQuery))) {
                $needle = mb_strtolower(trim($this->searchQuery));
                $haystack = mb_strtolower($reg->registration_reference . ' ' . json_encode($reg->data));
                if (! str_contains($haystack, $needle)) {
                    return false;
                }
            }

            // 2. Specific Column Dynamic Filter
            if ($this->selectedColumn === 'registration_reference' && ! empty(trim($this->filterValue))) {
                $needle = mb_strtolower(trim($this->filterValue));
                if (! str_contains(mb_strtolower($reg->registration_reference), $needle)) {
                    return false;
                }
            } elseif ($this->selectedColumn !== 'all' && ! empty(trim($this->filterValue))) {
                $val = $reg->getFieldValue($this->selectedColumn, '');
                $needle = mb_strtolower(trim($this->filterValue));

                if (is_array($val)) {
                    $matched = false;
                    foreach ($val as $item) {
                        if (str_contains(mb_strtolower((string) $item), $needle)) {
                            $matched = true;
                            break;
                        }
                    }
                    if (! $matched) {
                        return false;
                    }
                } else {
                    if (! str_contains(mb_strtolower((string) $val), $needle)) {
                        return false;
                    }
                }
            }

            return true;
        });
    }

    public function deleteRegistration(int $id): void
    {
        $reg = $this->record->registrations()->find($id);

        if ($reg) {
            $ref = $reg->registration_reference;
            $reg->delete();

            Notification::make()
                ->success()
                ->title('Registration Deleted')
                ->body("Registration record {$ref} was removed successfully.")
                ->send();
        }
    }

    public function seedDemoRegistrations(): void
    {
        $fields = $this->formFields;

        if (empty($fields)) {
            Notification::make()
                ->warning()
                ->title('Form Not Configured')
                ->body('Please customize registration fields first before adding sample attendees.')
                ->send();
            return;
        }

        $sampleNames = [
            'Alex Morgan', 'Carlos Santos', 'Danielle Reyes', 'Elena Rostova',
            'Franklin Moore', 'Grace Kim', 'Hannah Abbott', 'Ian Wright',
        ];

        foreach ($sampleNames as $index => $name) {
            $data = [];
            foreach ($fields as $field) {
                $label = $field['label'] ?? 'Field';
                $type = $field['type'] ?? 'text';
                $options = $field['options'] ?? [];

                switch ($type) {
                    case 'text':
                        if (stripos($label, 'name') !== false) {
                            $data[$label] = $name;
                        } elseif (stripos($label, 'email') !== false) {
                            $data[$label] = strtolower(str_replace(' ', '.', $name)) . '@example.com';
                        } elseif (stripos($label, 'phone') !== false) {
                            $data[$label] = '+63 917 ' . rand(100, 999) . ' ' . rand(1000, 9999);
                        } elseif (stripos($label, 'company') !== false || stripos($label, 'org') !== false) {
                            $companies = ['Truant Tech', 'Apex Solutions', 'Global Innovations', 'NextGen Dynamics'];
                            $data[$label] = $companies[$index % count($companies)];
                        } else {
                            $data[$label] = 'Sample ' . $label . ' #' . ($index + 1);
                        }
                        break;

                    case 'radio':
                    case 'select':
                        if (! empty($options)) {
                            $data[$label] = $options[$index % count($options)];
                        } else {
                            $data[$label] = 'Option ' . (($index % 3) + 1);
                        }
                        break;

                    case 'textarea':
                        $data[$label] = "Excited to participate in {$this->record->name} and explore collaboration opportunities.";
                        break;

                    case 'image_upload':
                        $data[$label] = $this->record->banner ?: 'events/banners/sample_attendee.png';
                        break;

                    default:
                        $data[$label] = 'Value ' . ($index + 1);
                        break;
                }
            }

            EventRegistration::create([
                'event_id' => $this->record->id,
                'data' => $data,
                'consent_agreed' => true,
                'ip_address' => '127.0.0.1',
                'created_at' => now()->subHours(($index * 3) + 1),
            ]);
        }

        Notification::make()
            ->success()
            ->title('Sample Attendees Added')
            ->body(count($sampleNames) . ' sample registrations populated successfully with dynamic columns.')
            ->send();
    }

    protected function getHeaderActions(): array
    {
        return [
            Action::make('print')
                ->label('Print Attendees Report')
                ->icon(Heroicon::OutlinedPrinter)
                ->color('primary')
                ->extraAttributes(['onclick' => 'window.print(); return false;']),
            Action::make('seed_samples')
                ->label('Populate Sample Attendees')
                ->icon(Heroicon::OutlinedUserPlus)
                ->color('gray')
                ->visible(fn (): bool => $this->record->registrations()->count() === 0)
                ->action('seedDemoRegistrations'),
            Action::make('view_form')
                ->label('Preview Form')
                ->icon(Heroicon::OutlinedEye)
                ->color('info')
                ->url(fn (): string => EventResource::getUrl('view-form', ['record' => $this->record])),
            Action::make('customize_form')
                ->label('Form Builder')
                ->icon(Heroicon::OutlinedPencilSquare)
                ->color('gray')
                ->url(fn (): string => EventResource::getUrl('form', ['record' => $this->record])),
            Action::make('back')
                ->label('Back to Events')
                ->icon(Heroicon::OutlinedArrowLeft)
                ->color('gray')
                ->url(fn (): string => EventResource::getUrl('index')),
        ];
    }
}
