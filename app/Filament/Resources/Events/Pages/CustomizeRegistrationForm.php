<?php

namespace App\Filament\Resources\Events\Pages;

use App\Filament\Resources\Events\EventResource;
use App\Models\Event;
use App\Models\EventRegistrationForm;
use Filament\Actions\Action;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TagsInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\Concerns\InteractsWithRecord;
use Filament\Resources\Pages\Page;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Livewire\WithFileUploads;

class CustomizeRegistrationForm extends Page implements HasForms
{
    use InteractsWithRecord;
    use InteractsWithForms;
    use WithFileUploads;

    protected static string $resource = EventResource::class;

    protected string $view = 'filament.resources.events.pages.customize-registration-form';

    public ?array $data = [];

    public function mount(int|string $record): void
    {
        $this->record = $this->resolveRecord($record);

        $existingForm = $this->record->registrationForm;

        $this->form->fill([
            'title' => $existingForm?->title ?? ('Registration Form - ' . $this->record->name),
            'banner' => $existingForm?->banner ?? null,
            'registration_start_date' => $existingForm?->registration_start_date?->format('Y-m-d') ?? ($this->record->registration_start_date?->format('Y-m-d') ?? now()->format('Y-m-d')),
            'registration_end_date' => $existingForm?->registration_end_date?->format('Y-m-d') ?? ($this->record->registration_date?->format('Y-m-d') ?? now()->addDays(7)->format('Y-m-d')),
            'is_open' => $existingForm?->is_open ?? true,
            'description' => $existingForm?->description ?? ('Please fill out the form below to register for ' . $this->record->name . '.'),
            'consent_title' => $existingForm?->consent_title ?? 'Consent & Data Privacy Agreement',
            'consent_body' => $existingForm?->consent_body ?? "By submitting this registration, I hereby grant permission and voluntary consent to the organizers to collect, process, and retain my personal information for the purposes of event coordination, security, and updates.\n\nI confirm that all information provided is true, accurate, and complete to the best of my knowledge.",
            'consent_checkbox_label' => $existingForm?->consent_checkbox_label ?? 'I have read, understood, and voluntarily agree to the consent and privacy policy.',
            'fields' => $existingForm?->fields ?? [
                [
                    'label' => 'Full Name',
                    'type' => 'text',
                    'is_required' => true,
                    'placeholder' => 'Enter your full name',
                    'help_text' => 'First name and last name',
                    'options' => [],
                ],
            ],
        ]);
    }

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Registration Form Details')
                    ->description('Set general title, custom banner, and instructions for this unique event registration form.')
                    ->icon(Heroicon::OutlinedDocumentText)
                    ->schema([
                        TextInput::make('title')
                            ->label('Form Title')
                            ->required()
                            ->maxLength(255)
                            ->placeholder('e.g. Registration Form - Annual Summit'),
                        FileUpload::make('banner')
                            ->label('Form Banner Image')
                            ->image()
                            ->disk('public')
                            ->directory('events/form-banners')
                            ->maxSize(5120)
                            ->columnSpanFull()
                            ->helperText('Upload a banner image specific to this registration form (PNG, JPG, WEBP up to 5MB). If left blank, the event banner will be displayed.'),
                        Grid::make(3)->schema([
                            DatePicker::make('registration_start_date')
                                ->label('Registration Start Date (Opens On)')
                                ->helperText('Date when registration opens for this form.'),
                            DatePicker::make('registration_end_date')
                                ->label('Registration Deadline (Closes On)')
                                ->helperText('Date when registration closes for this form.'),
                            Toggle::make('is_open')
                                ->label('Registration Status: Open')
                                ->helperText('Toggle whether the form is currently open and accepting submissions.')
                                ->default(true)
                                ->inline(false),
                        ]),
                        Textarea::make('description')
                            ->label('Form Description & Guidelines')
                            ->rows(3)
                            ->placeholder('Provide any guidelines, eligibility criteria, or instructions for registrants')
                            ->columnSpanFull(),
                    ]),

                Section::make('Mandatory Consent Form Agreement')
                    ->description('A consent form statement is strictly required when customizing the registration form.')
                    ->icon(Heroicon::OutlinedShieldCheck)
                    ->schema([
                        TextInput::make('consent_title')
                            ->label('Consent Agreement Title')
                            ->required()
                            ->maxLength(255)
                            ->default('Consent & Data Privacy Agreement'),
                        Textarea::make('consent_body')
                            ->label('Consent Statement / Terms')
                            ->required()
                            ->rows(5)
                            ->helperText('Registrants must read and agree to this statement before submitting registration.')
                            ->columnSpanFull(),
                        TextInput::make('consent_checkbox_label')
                            ->label('Agreement Checkbox Text')
                            ->required()
                            ->maxLength(255)
                            ->default('I have read, understood, and voluntarily agree to the consent and privacy policy.')
                            ->helperText('The prompt shown beside the required agreement checkbox.')
                            ->columnSpanFull(),
                    ]),

                Section::make('Dynamic Registration Fields')
                    ->description('Design custom fields for attendees. You can choose: Text, Radio Box, Selection Box, Textarea, or Upload Images.')
                    ->icon(Heroicon::OutlinedSquaresPlus)
                    ->schema([
                        Repeater::make('fields')
                            ->label('Configured Fields')
                            ->itemLabel(fn (array $state): ?string => ($state['label'] ?? null)
                                ? ($state['label'] . ' [' . ucfirst(str_replace('_', ' ', $state['type'] ?? 'text')) . ']' . (($state['is_required'] ?? false) ? ' (Required)' : ''))
                                : 'New Field')
                            ->collapsible()
                            ->cloneable()
                            ->reorderable()
                            ->addActionLabel('Add New Field')
                            ->schema([
                                Grid::make(2)->schema([
                                    TextInput::make('label')
                                        ->label('Field Label')
                                        ->required()
                                        ->placeholder('e.g. Full Name, Dietary Preference, ID Photo'),
                                    Select::make('type')
                                        ->label('Field Type')
                                        ->required()
                                        ->options([
                                            'text' => 'Text (Single-line)',
                                            'radio' => 'Radio Box',
                                            'select' => 'Selection Box (Dropdown)',
                                            'textarea' => 'Textarea (Multi-line)',
                                            'image_upload' => 'Upload Images',
                                        ])
                                        ->live(),
                                ]),
                                TagsInput::make('options')
                                    ->label('Choices / Options')
                                    ->placeholder('Type option and press Enter')
                                    ->helperText('Provide the choices available for the Radio Box or Selection Box.')
                                    ->visible(fn ($get) => in_array($get('type'), ['radio', 'select']))
                                    ->required(fn ($get) => in_array($get('type'), ['radio', 'select'])),
                                Grid::make(2)->schema([
                                    TextInput::make('placeholder')
                                        ->label('Placeholder Text')
                                        ->placeholder('e.g. Type your answer here...')
                                        ->visible(fn ($get) => in_array($get('type'), ['text', 'textarea'])),
                                    TextInput::make('help_text')
                                        ->label('Helper Text / Note')
                                        ->placeholder('e.g. Maximum 200 characters'),
                                ]),
                                Toggle::make('is_required')
                                    ->label('Required Field (Registrants must fill this out)')
                                    ->default(false),
                            ]),
                    ]),
            ])
            ->statePath('data');
    }

    public function save(): void
    {
        $data = $this->form->getState();

        // Enforce mandatory consent form
        if (empty(trim($data['consent_body'] ?? ''))) {
            Notification::make()
                ->danger()
                ->title('Consent Form Statement Required')
                ->body('A consent form statement is mandatory when setting up a registration form.')
                ->send();
            return;
        }

        EventRegistrationForm::updateOrCreate(
            ['event_id' => $this->record->id],
            [
                'title' => $data['title'] ?? ('Registration Form - ' . $this->record->name),
                'description' => $data['description'] ?? null,
                'banner' => $data['banner'] ?? null,
                'registration_start_date' => $data['registration_start_date'] ?? null,
                'registration_end_date' => $data['registration_end_date'] ?? null,
                'is_open' => (bool) ($data['is_open'] ?? true),
                'consent_title' => $data['consent_title'] ?? 'Consent & Data Privacy Agreement',
                'consent_body' => $data['consent_body'],
                'consent_checkbox_label' => $data['consent_checkbox_label'] ?? 'I have read, understood, and voluntarily agree to the consent and privacy policy.',
                'fields' => $data['fields'] ?? [],
            ]
        );

        // Keep parent event registration dates in sync
        if (! empty($data['registration_start_date'])) {
            $this->record->registration_start_date = $data['registration_start_date'];
        }
        if (! empty($data['registration_end_date'])) {
            $this->record->registration_date = $data['registration_end_date'];
        }
        $this->record->save();

        Notification::make()
            ->success()
            ->title('Registration Form Saved')
            ->body('The dynamic registration form and mandatory consent agreement have been saved for this event.')
            ->send();
    }

    protected function getHeaderActions(): array
    {
        return [
            Action::make('view_form')
                ->label('View / Preview Form')
                ->icon(Heroicon::OutlinedEye)
                ->color('info')
                ->url(fn (): string => EventResource::getUrl('view-form', ['record' => $this->record])),
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
