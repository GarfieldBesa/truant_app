<?php

namespace Database\Seeders;

use App\Models\Event;
use App\Models\EventRegistrationForm;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class SampleEventsSeeder extends Seeder
{
    public function run(): void
    {
        $eventsData = [
            [
                'name' => 'InnovateTech Global Summit 2026',
                'description' => 'Join us for the largest tech summit of the year featuring AI & Cloud innovations! Connect with global pioneers, engineers, and digital innovators.',
                'event_date' => Carbon::now()->addDays(38)->toDateString(),
                'registration_start_date' => Carbon::now()->subDays(5)->toDateString(),
                'registration_date' => Carbon::now()->addDays(24)->toDateString(),
                'banner' => 'events/banners/01M1X4YD0BMNAB3QW332XFHPRE.png',
                'admission' => 'free',
                'ticket_price' => null,
                'is_open' => true,
                'fields' => [
                    ['type' => 'text', 'label' => 'Full Name', 'placeholder' => 'Enter your full name', 'is_required' => true],
                    ['type' => 'text', 'label' => 'Job Title', 'placeholder' => 'Enter your role', 'is_required' => true],
                ],
            ],
            [
                'name' => 'Executive Leadership & AI Strategy Forum 2026',
                'description' => 'A premier executive gathering bringing together C-level leaders, strategists, and decision makers to explore enterprise artificial intelligence adoption, governance, and business transformation.',
                'event_date' => Carbon::now()->addDays(45)->toDateString(),
                'registration_start_date' => Carbon::now()->subDays(5)->toDateString(),
                'registration_date' => Carbon::now()->addDays(40)->toDateString(),
                'banner' => 'events/banners/banner_leadership.jpg',
                'admission' => 'paid',
                'ticket_price' => '₱2,500',
                'is_open' => true,
                'fields' => [
                    ['type' => 'text', 'label' => 'Full Name', 'placeholder' => 'Enter your full name', 'is_required' => true],
                    ['type' => 'text', 'label' => 'Job Title & Company', 'placeholder' => 'e.g. Chief Technology Officer, Acme Corp', 'is_required' => true],
                    ['type' => 'select', 'label' => 'Executive Track', 'options' => ['AI Governance & Policy', 'Enterprise Cloud & Data', 'Strategic Leadership'], 'is_required' => true],
                ],
            ],
            [
                'name' => 'Corporate Wellness Marathon & Sports Festival',
                'description' => 'Unite and thrive! An action-packed community wellness festival featuring 5K/10K fun runs, corporate relay tournaments, fitness workshops, and health vitality booths.',
                'event_date' => Carbon::now()->addDays(60)->toDateString(),
                'registration_start_date' => Carbon::now()->subDays(2)->toDateString(),
                'registration_date' => Carbon::now()->addDays(50)->toDateString(),
                'banner' => 'events/banners/banner_sports.jpg',
                'admission' => 'free',
                'ticket_price' => null,
                'is_open' => true,
                'fields' => [
                    ['type' => 'text', 'label' => 'Runner Name', 'placeholder' => 'Full name of participant', 'is_required' => true],
                    ['type' => 'radio', 'label' => 'Race Category', 'options' => ['3K Fun Walk', '5K Speed Run', '10K Challenge Run'], 'is_required' => true],
                    ['type' => 'select', 'label' => 'Singlet Size', 'options' => ['XS', 'S', 'M', 'L', 'XL', '2XL'], 'is_required' => true],
                ],
            ],
            [
                'name' => 'Cloud Architecture & DevOps Masterclass',
                'description' => 'Deep dive into microservices, automated CI/CD pipelines, Kubernetes orchestration, and resilient cloud architectures with industry enterprise cloud practitioners.',
                'event_date' => Carbon::now()->addDays(75)->toDateString(),
                'registration_start_date' => Carbon::now()->subDays(1)->toDateString(),
                'registration_date' => Carbon::now()->addDays(65)->toDateString(),
                'banner' => 'events/banners/banner_tech.jpg',
                'admission' => 'paid',
                'ticket_price' => '$35.00',
                'is_open' => true,
                'fields' => [
                    ['type' => 'text', 'label' => 'Developer Name', 'placeholder' => 'Your full name', 'is_required' => true],
                    ['type' => 'text', 'label' => 'GitHub Username', 'placeholder' => 'e.g. octocat', 'is_required' => false],
                    ['type' => 'radio', 'label' => 'Experience Level', 'options' => ['Intermediate', 'Advanced', 'Staff / Principal'], 'is_required' => true],
                ],
            ],
            [
                'name' => 'Annual Corporate Gala & Excellence Awards',
                'description' => 'An evening honoring standout performers, breakthrough innovations, and exemplary leadership. Formal black-tie gala dinner, live performances, and awards ceremony.',
                'event_date' => Carbon::now()->addDays(95)->toDateString(),
                'registration_start_date' => Carbon::now()->addDays(20)->toDateString(),
                'registration_date' => Carbon::now()->addDays(80)->toDateString(),
                'banner' => 'events/banners/banner_leadership.jpg',
                'admission' => 'free',
                'ticket_price' => null,
                'is_open' => true,
                'fields' => [
                    ['type' => 'text', 'label' => 'Employee Name', 'placeholder' => 'Enter official name', 'is_required' => true],
                    ['type' => 'select', 'label' => 'Department', 'options' => ['Engineering', 'Finance', 'Operations', 'Human Resources', 'Marketing'], 'is_required' => true],
                    ['type' => 'radio', 'label' => 'Dietary Restrictions', 'options' => ['None (Standard Menu)', 'Vegetarian', 'Halal', 'Gluten-Free'], 'is_required' => true],
                ],
            ],
            [
                'name' => 'Fintech & Cybersecurity Summit 2026',
                'description' => 'Explore the modern landscape of zero-trust security, real-time fraud mitigation, decentralized finance compliance, and threat intelligence in the financial sector.',
                'event_date' => Carbon::now()->addDays(85)->toDateString(),
                'registration_start_date' => Carbon::now()->subDays(3)->toDateString(),
                'registration_date' => Carbon::now()->addDays(70)->toDateString(),
                'banner' => 'events/banners/banner_tech.jpg',
                'admission' => 'paid',
                'ticket_price' => '₱1,800',
                'is_open' => true,
                'fields' => [
                    ['type' => 'text', 'label' => 'Attendee Name', 'placeholder' => 'Full name', 'is_required' => true],
                    ['type' => 'text', 'label' => 'Organization / Bank', 'placeholder' => 'Institution name', 'is_required' => true],
                    ['type' => 'select', 'label' => 'Primary Interest', 'options' => ['Zero Trust Architecture', 'Payment Fraud Prevention', 'Cloud Compliance'], 'is_required' => true],
                ],
            ],
            [
                'name' => 'HR Leaders & People Culture Symposium',
                'description' => 'Empower your workplace. Discuss progressive compensation benchmarks, hybrid team engagement, agile talent acquisition, and employee retention strategies.',
                'event_date' => Carbon::now()->addDays(110)->toDateString(),
                'registration_start_date' => Carbon::now()->subDays(4)->toDateString(),
                'registration_date' => Carbon::now()->addDays(100)->toDateString(),
                'banner' => 'events/banners/banner_leadership.jpg',
                'admission' => 'free',
                'ticket_price' => null,
                'is_open' => true,
                'fields' => [
                    ['type' => 'text', 'label' => 'Delegate Name', 'placeholder' => 'Full name', 'is_required' => true],
                    ['type' => 'text', 'label' => 'Email Address', 'placeholder' => 'work.email@company.com', 'is_required' => true],
                    ['type' => 'select', 'label' => 'Company Size', 'options' => ['1-50 employees', '51-200 employees', '201-1,000 employees', '1,000+ employees'], 'is_required' => true],
                ],
            ],
            [
                'name' => 'Summer Hackathon & Rapid Prototyping Sprint',
                'description' => 'A past 48-hour intensive coding sprint where developers competed to prototype next-generation employee automation and workforce workflow tools.',
                'event_date' => Carbon::now()->subDays(25)->toDateString(),
                'registration_start_date' => Carbon::now()->subDays(40)->toDateString(),
                'registration_date' => Carbon::now()->subDays(30)->toDateString(),
                'banner' => 'events/banners/banner_sports.jpg',
                'admission' => 'free',
                'ticket_price' => null,
                'is_open' => false,
                'fields' => [
                    ['type' => 'text', 'label' => 'Hacker Name', 'placeholder' => 'Full name', 'is_required' => true],
                    ['type' => 'text', 'label' => 'Team Name', 'placeholder' => 'Team codename', 'is_required' => true],
                ],
            ],
        ];

        foreach ($eventsData as $data) {
            $event = Event::updateOrCreate(
                ['name' => $data['name']],
                [
                    'description' => $data['description'],
                    'event_date' => $data['event_date'],
                    'registration_start_date' => $data['registration_start_date'],
                    'registration_date' => $data['registration_date'],
                    'banner' => $data['banner'],
                    'admission' => $data['admission'],
                    'ticket_price' => $data['ticket_price'],
                ]
            );

            if (! $event->registrationForm) {
                EventRegistrationForm::create([
                    'event_id' => $event->id,
                    'title' => 'Registration - ' . $event->name,
                    'description' => 'Complete this form to reserve your registration pass for ' . $event->name . '.',
                    'banner' => $data['banner'],
                    'registration_start_date' => $data['registration_start_date'],
                    'registration_end_date' => $data['registration_date'],
                    'is_open' => $data['is_open'],
                    'consent_title' => 'Terms & Privacy Consent',
                    'consent_body' => "By registering for this event, I agree to the terms of attendance, event guidelines, and data processing policies.\nI confirm all details provided are accurate.",
                    'consent_checkbox_label' => 'I understand and agree to the event registration guidelines and privacy terms.',
                    'fields' => $data['fields'],
                ]);
            }
        }
    }
}
