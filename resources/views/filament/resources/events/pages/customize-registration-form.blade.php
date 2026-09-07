<x-filament-panels::page>
    <div style="background: linear-gradient(135deg, rgba(245, 158, 11, 0.08) 0%, rgba(217, 119, 6, 0.08) 100%); border: 1px solid rgba(245, 158, 11, 0.3); border-radius: 1rem; padding: 1.125rem 1.25rem; display: flex; align-items: flex-start; gap: 0.875rem; margin-bottom: 1.5rem;">
        <div style="width: 2.25rem; height: 2.25rem; border-radius: 0.625rem; background: #fef3c7; color: #d97706; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
            <svg style="width: 1.25rem; height: 1.25rem;" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="m11.25 11.25.041-.02a.75.75 0 0 1 1.063.852l-.708 2.836a.75.75 0 0 0 1.063.853l.041-.021M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-9-3.75h.008v.008H12V8.25Z" />
            </svg>
        </div>
        <div>
            <div style="font-size: 0.9375rem; font-weight: 700; color: #92400e;">
                Customizing Registration Form for: {{ $record->name }}
            </div>
            <div style="font-size: 0.8125rem; color: #b45309; margin-top: 0.25rem; line-height: 1.5;">
                This registration form is <strong>unique to this event</strong>. Customize the title, mandatory consent agreement, and custom attendee fields (Text, Radio Box, Selection Box, Textarea, or Upload Images). Once saved, click <strong>"View / Preview Form"</strong> to see the live form.
            </div>
        </div>
    </div>

    <form wire:submit="save">
        {{ $this->form }}

        <div style="margin-top: 2rem; padding-top: 1.5rem; border-top: 1px solid #e2e8f0; display: flex; align-items: center; gap: 0.75rem; flex-wrap: wrap;">
            <x-filament::button type="submit" size="lg" icon="heroicon-o-check">
                Save Registration Form
            </x-filament::button>

            <x-filament::button
                tag="a"
                href="{{ \App\Filament\Resources\Events\EventResource::getUrl('view-form', ['record' => $record]) }}"
                color="info"
                size="lg"
                icon="heroicon-o-eye"
                outlined
            >
                View / Preview Form
            </x-filament::button>

            <x-filament::button
                tag="a"
                href="{{ \App\Filament\Resources\Events\EventResource::getUrl('index') }}"
                color="gray"
                size="lg"
                outlined
            >
                Back to Events
            </x-filament::button>
        </div>
    </form>
</x-filament-panels::page>
