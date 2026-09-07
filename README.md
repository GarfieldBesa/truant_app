# truant_application - Employee, Compensation, Timesheet & Event Management System

**truant_application** is an enterprise management platform built using **Laravel 11** and **Filament v5 / Livewire 3**. It streamlines employee record keeping, compensation and benefits structures, change auditing, daily employee timesheets with automated meal allowance calculation rules, cash advance requests with automated timesheet deduction synchronization, an advanced automated Payroll processing module, and a complete Events Management system with dynamic attendee registration forms, dynamic column filtering, and printable reports.

---

## 🌟 Key Features & Business Modules

### 1. 👥 Employee Management
- **Complete Employee Directory**: Full CRUD functionality to manage employee records.
- **Detailed Attributes**:
  - First Name & Last Name
  - Address, Birthdate, Mobile Number
  - Username & Hashed Password Credentials
  - **Required Position Assignment**: Links each employee to an established organizational position.
- **Top-Level Sidebar Placement**: Easily accessible directly from the main sidebar.

---

### 2. 💼 Compensations and Benefits (Position Management)
- **Position Catalog**: Pre-configured organizational roles (e.g., *Secretary, Part Time, Production Staff, Production Head, Jr. Graphic Designer, Sr. Graphic Designer, Semi-Skilled, Labor*).
- **Financial & Insurance Attributes**:
  - **Base Rate** & **Overtime Rate** (₱)
  - **SSS, Philhealth, and Pag-ibig Contributions** (₱)
- **📜 Comprehensive Audit Trail / Change History**:
  - Automatically captures every creation and modification on any position.
  - Tracks timestamp, active administrator identity, and transition details (`Field Name: Old Value ➔ New Value`).
  - Viewable in an inline history table at the bottom of the Edit Position view.

---

### 3. ⏱️ Timesheet & Attendance Management
- **Daily Attendance Tracking**: Log employee `Date`, `Time In`, and `Time Out`.
- **Preloaded Employee Selector**: Dropdown input preloads all active employees with a real-time search input at the top.
- **🍱 Automated Meal Allowance Calculation**:
  - **Eligibility Rule**: Automatically granted if `Time In <= 8:30 AM` **AND** `Time Out >= 5:30 PM`.
  - **On Leave Rule**: If an employee is marked **On Leave**, meal allowance is set to blank/disabled by default.
  - **Manual Override ("Force Meal Allowance")**: Bypasses standard time boundary checks to grant meal allowance when authorized.
- **🌴 Leave Tracking**: `On Leave` indicator showing whether an employee was on leave for the given date.
- **💵 Deductions & Extra Income**:
  - Numeric fields for logging penalties, deductions, or bonuses.
  - **Interactive Hover Tooltips**: Dynamic info icon (`ℹ️`) appears next to the amount showing the reason/description.
- **📅 Daily Table Grouping**: Automatically groups timesheet logs by date under collapsible header sections.

---

### 4. 💸 Automated Payroll Processing
- **Bi-Monthly Cutoffs**: Segmented controls to toggle between the 1st–15th and 16th–30th periods.
- **🧮 Core Computation Logic & Business Rules**:
  - **Hourly Rate Calculation**: Standardized at `Base Rate / 8` hours.
  - **Maximum Regular Hours**: Capped at **8 hours per day**. Any worked time exceeding 8 hours is automatically transferred to **Overtime (OT) hours**.
  - **Midday Clamping Rule**: If an employee clocks in between **11:00 AM and 1:00 PM**, the system automatically clamps their effective start time to **1:00 PM** to account for the lunch break policy.
  - **Lunch Break Deduction**: A **1-hour break** is automatically deducted from gross hours if the shift spans past **12:00 PM**.
  - **Late Threshold**: Employees clocking in after **8:45 AM** are visually flagged as `Late` in the daily logs.
  - **Government Deductions**: SSS, PhilHealth, and Pag-ibig monthly contributions configured in the Position are divided by **2** for the bi-monthly cutoffs.
- **Dynamic KPI Dashboard**: Real-time summary cards displaying Total Net Payable, Gross Payroll, Total Work/OT Hours, and Total Employees Processed.
- **Detailed Data Table & Mobile-Ready Responsive Design**:
  - High-level employee summary showing Reg/OT hours, pay, allowances, govt deductions, and Net Payable.
  - **Adaptive Card Layout**: Tables automatically transform into stacked, touch-friendly cards on mobile/tablet screens (< 1024px) for seamless readability without horizontal scrolling.
  - **Strict Value Formatting**: Tabular monospace numbers with non-breaking negative currencies (e.g., `-₱477.50`).
  - **Desktop Sticky Headers/Columns**: Sticky positioning keeps employee and action columns visible on wide viewports.
- **Interactive Daily Breakdown**: Collapsible rows revealing a detailed day-by-day attendance log.
  - Highlights Late arrivals (>8:45 AM) and automatically clamps midday breaks (12:00 PM - 1:00 PM).
- **🖨️ Printable Payslip Engine**:
  - Integrated "Print" button on each employee's daily log.
  - Uses an advanced Alpine.js rendering overlay to generate a clean, printer-friendly single-page document.
  - Features a custom UI optimized for standard paper sizes (A4/Letter).
  - Includes a full summary breakdown grid, daily attendance logs, the company header, and signature acknowledgment lines.

---

### 5. 💳 Cash Advance Management
- **Request Lifecycle & Approvals**: Streamlined management of employee cash advance requests with `Pending`, `Approved`, and `Declined` statuses.
- **🔔 Real-Time Navigation Badge**: Top-level sidebar item features a dynamic badge counter highlighting pending requests requiring administrative action.
- **Submitted Date & Request Tracking**: Captures submission timestamps, employee profiles, requested amounts, and detailed notes/reasons.
- **⚡ Automated Timesheet & Deduction Synchronization**:
  - Upon admin approval, the requested cash advance amount is automatically converted into a timesheet deduction.
  - **Cutoff Matching Rule**: Inserts the deduction into the timesheet record matching the approval date, or locates the nearest existing record within the current bi-monthly cutoff.
  - **Auto-Provisioning**: If no timesheet record exists within the cutoff window, a blank timesheet entry is automatically initialized on the approval date.
  - **Standardized Tagging**: Deductions are systematically labeled or appended with the description `Cash Advance`.

---

### 6. 🌐 Standalone Timesheet Portal & Employee Time Tracker
- **Dedicated External Portal**: Operates outside the Filament administrative dashboard at `/portal` (aliased as `/timesheet-portal`) tailored for employee daily timesheet logging.
- **Reused Unified Login Form**: Reuses the core login form (`/admin/login`) across both administrative staff and standard employees:
  - Administrators authenticate with their **Email** and are routed directly to the administrative dashboard (`/admin`).
  - Employees authenticate with their **Username** and are routed directly to the **Timesheet Portal** (`/portal`).
- **Multi-Access Permissions Checkbox (Edit Employee)**:
  - Administrators assign portal and system permissions using a flexible **Checkbox List** rather than a single dropdown:
    - **Administrator Access**: Elevates the employee to an administrator, automatically syncing credentials to the administrative dashboard (`/admin`) to manage employees, positions, payroll, and approvals.
    - **Timesheet Portal Access**: Permits the employee to log in and use the external `/portal` attendance tracker.
  - Employees granted Administrator access can log in directly at `/admin/login` using their username and password and access the full admin dashboard.
  - The employee directory table displays distinct status badges (`Administrator`, `Timesheet Portal`, or `Standard`).
- **🇵🇭 Live Philippine Time Clock (PST, UTC+8)**:
  - Prominent ticking digital clock and date display strictly locked to Philippine Standard Time (`Asia/Manila`) regardless of user machine or server timezone.
- **⏱️ Time In & Time Out Feature with Single-Entry Validation**:
  - Direct database persistence to the central `timesheets` table for zero-friction integration with the Payroll module.
  - **Strict Daily Validation**: Enforces a single Time In and a single Time Out per calendar day (PH date), completely preventing duplicate entries.
  - **Sequencing Enforcement**: Prevents Time Out attempts prior to recording a valid Time In.
- **📝 Leave Requests & Cash Advance Submissions**:
  - Direct modal action buttons positioned beside the Live Clock.
  - **Leave Request Past-Date Guard**: Past dates are prohibited on both client and server (only today and future dates are selectable).
  - **Cash Advance Requests**: Employees enter the desired amount and reason, queued for administrator approval.
- **📑 Request History & Attendance Tabs**:
  - **Attendance History Tab**: Cutoff log list (1st–15th & 16th–End), KPI cards, and one-click **Print DTR** button producing official Daily Time Records.
  - **Leave Requests Tab**: Historical list of employee leave requests with duration, reason, submitted timestamp, and real-time status badges (`Pending`, `Approved`, `Declined`).
  - **Cash Advances Tab**: History of employee cash advance requests with amounts, purpose, and status tracking.

---

### 7. 🌴 Leave Request Management (Admin Panel)
- **Centralized Administration**: Dedicated resource in Filament (`/admin/leave-requests`) with real-time navigation badge counting pending requests.
- **⚡ Automated Timesheet Synchronization**:
  - Upon approving a leave request, timesheets for each calendar day in the requested date range are automatically created or updated with `is_on_leave = true`.
- **Decisive Review Actions**: Interactive `Approve` and `Decline` action triggers with confirmation modals and notification alerts.

---

### 8. 📅 Events & Dynamic Registration Form System
- **Full Events Lifecycle (CRUD)**:
  - Create, edit, and delete events with Name, Event Date (future date enforcement), Registration Start Date, Registration Deadline, Event Banner, and rich-text formatted Description.
  - Cascading deletion automatically removes associated custom forms and attendee registration records.
- **Events List Table & Metrics**:
  - Displays Banner thumbnail, Event Name, Event Date, Registration Period (`Start — Deadline`), real-time Status badge (`Open`, `Opens <Date>`, `Registration Closed`), and a dynamic **Registered** attendee counter badge.
  - Grouped action dropdown containing: **Registered People**, **Customize Form**, **View Form**, **Edit**, and **Delete** (preventing table overflow).
- **Dynamic Registration Form Builder (`/admin/events/{record}/registration-form`)**:
  - Dedicated form title and custom **Form Banner Image** upload (PNG, JPG, WEBP).
  - Registration window controls: Start Date, Deadline, and real-time **Registration Status: Open** toggle.
  - **Mandatory Consent Form Agreement**: Required consent title, statement/terms, and agreement checkbox text.
  - **Dynamic Registration Fields**: Text (Single-line), Radio Box, Selection Box (Dropdown), Textarea (Multi-line), and Upload Images.
  - Pre-initializes with 1 visible field ("Full Name"), allowing admins to add additional custom fields on demand.
- **Live Interactive Form Preview (`/admin/events/{record}/view-form`)**:
  - Custom scoped CSS design system with hero banner, key date chips, and responsive form controls.
  - Interactive submission validation ensuring all required dynamic fields and the mandatory consent agreement are met.
- **Registered People & Attendees Roster (`/admin/events/{record}/registrations`)**:
  - **Dynamic Table Columns**: Automatically adapts to show columns for all custom fields defined for that specific event.
  - **Dynamic Column-Based Filtering**: Administrators select any form column from a dynamic dropdown; the filter value input automatically provides choices for radio/select fields or a search input for text fields.
  - **Global Keyword Search & Date Range**: Search across all fields and filter by registration submission date.
  - **🖨️ Printable Attendees Report**: One-click "Print Attendees Report" generating an official printed attendee roster with document letterhead, active filter criteria, attendee count, and crisp tabular layout.

---

## ⚙️ Application Setup & Installation

### Prerequisites
- **PHP**: `>= 8.2` (Ensure `php_intl`, `pdo_mysql`, and `fileinfo` extensions are enabled in `php.ini`)
- **Composer**: Latest version
- **Database**: MySQL / MariaDB
- **Web Server**: `php artisan serve` or Nginx / Apache

### Installation Steps

1. **Clone the Repository**:
   ```bash
   git clone https://github.com/GarfieldBesa/truant_app.git truant_application
   cd truant_application
   ```

2. **Install PHP Dependencies**:
   ```bash
   composer install
   ```

3. **Configure Environment File**:
   Copy `.env.example` to `.env` and set your database and server credentials:
   ```env
   APP_NAME=truant_application
   APP_URL=http://127.0.0.1:8000

   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=truant_application
   DB_USERNAME=root
   DB_PASSWORD=
   ```

4. **Generate Application Key**:
   ```bash
   php artisan key:generate
   ```

5. **Link Public Storage Directory**:
   ```bash
   php artisan storage:link
   ```

6. **Run Migrations & Seeders**:
   ```bash
   php artisan migrate --seed
   ```

7. **Start Development Server**:
   ```bash
   php artisan serve
   ```
   Access the admin dashboard at `http://127.0.0.1:8000/admin` and the employee timesheet portal at `http://127.0.0.1:8000/portal`.

---

## 🔐 Default Access Credentials
- **Administrator Email**: `admin@example.com`
- **Administrator Password**: `password`

---

## 📂 Project Architecture

```
app/
├── Filament/
│   ├── Pages/
│   │   ├── Auth/
│   │   │   └── Login.php           # Unified login page supporting admin emails & employee usernames
│   │   └── Payroll.php             # Custom Payroll page logic, cutoff calculations, & print engine
│   └── Resources/
│       ├── CashAdvances/           # Cash advance requests, approval workflows, & badges
│       ├── Employees/              # Employee directory, multi-access permissions, & schemas
│       ├── Events/                 # Events management module
│       │   ├── Pages/
│       │   │   ├── CreateEvent.php
│       │   │   ├── EditEvent.php
│       │   │   ├── ListEvents.php
│       │   │   ├── CustomizeRegistrationForm.php # Dynamic form builder & consent configuration
│       │   │   ├── ViewRegistrationForm.php      # Live interactive form preview & tester
│       │   │   └── ViewEventRegistrations.php    # Registered attendees roster with dynamic filters & print
│       │   ├── Schemas/
│       │   │   └── EventForm.php   # Event schema with past-date validations & banner uploader
│       │   └── Tables/
│       │       └── EventsTable.php # Events table with registration count badge & action dropdown
│       ├── LeaveRequests/          # Employee leave management, approvals, & timesheet sync
│       ├── Positions/              # Position resource, forms, & AuditLogsRelationManager
│       └── Timesheets/             # Timesheet resource, meal allowance logic, & tooltips
├── Http/
│   └── Controllers/
│       └── TimesheetPortalController.php # Timesheet portal routing, time in/out, leave/advance forms
├── Models/
│   ├── CashAdvance.php             # Cash advance model with approval state
│   ├── Employee.php                # Employee authenticatable model & portal access methods
│   ├── Event.php                   # Event model, dates, registration status accessor, & relations
│   ├── EventRegistration.php       # Attendee registration model with dynamic JSON data & helper
│   ├── EventRegistrationForm.php   # Form configuration, consent terms, & dynamic fields JSON
│   ├── LeaveRequest.php            # Leave request model with approval lifecycle
│   ├── Position.php                # Position model & change auditor hooks
│   ├── PositionAuditLog.php        # Audit trail model
│   ├── Timesheet.php               # Timesheet model with virtual meal allowance accessor
│   └── User.php                    # System user, authentication, & FilamentUser panel access
├── Services/
│   └── PayrollCalculator.php       # Core business logic for hours, clamping, and pay processing
database/
└── migrations/                     # Schema definitions for employees, positions, timesheets, cash advances, leaves, events, forms, & registrations
resources/
└── views/
    ├── filament/
    │   ├── pages/
    │   │   └── payroll.blade.php   # Detailed custom blade view and Alpine print engine
    │   └── resources/
    │       └── events/
    │           └── pages/
    │               ├── customize-registration-form.blade.php # Customizer notice layout
    │               ├── view-registration-form.blade.php      # Live interactive form preview view
    │               └── view-event-registrations.blade.php    # Attendees list with dynamic filters & print CSS
    └── portal/
        └── timesheet.blade.php     # Standalone employee timesheet portal view with tabs & modals
```
