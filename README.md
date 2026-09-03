# Truant App - Employee, Compensation & Timesheet Management System

**Truant App** is an enterprise management platform built using **Laravel 11** and **Filament v3**. It streamlines employee record keeping, compensation and benefits structures, change auditing, daily employee timesheets with automated meal allowance calculation rules, cash advance requests with automated timesheet deduction synchronization, and an advanced automated Payroll processing module.

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
  - **Adaptive Card Layout**: Tables automatically transform into stacked, touch-friendly cards on mobile/tablet screens (< 1024px) for seamless readability without awkward horizontal scrolling.
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

## ⚙️ Application Setup & Installation

### Prerequisites
- **PHP**: `>= 8.2` (Ensure the `php_intl` extension is enabled in `php.ini`)
- **Composer**: Latest version
- **Database**: MySQL / MariaDB

### Installation Steps

1. **Clone the Repository**:
   ```bash
   git clone https://github.com/GarfieldBesa/truant_app.git
   cd truant_app
   ```

2. **Install PHP Dependencies**:
   ```bash
   composer install
   ```

3. **Configure Environment File**:
   Copy `.env.example` to `.env` and set your MySQL database credentials:
   ```env
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=my_laravel_app
   DB_USERNAME=root
   DB_PASSWORD=
   ```

4. **Generate Application Key**:
   ```bash
   php artisan key:generate
   ```

5. **Run Migrations & Seeders**:
   ```bash
   php artisan migrate --seed
   ```

6. **Start Development Server**:
   ```bash
   php artisan serve
   ```
   Access the admin dashboard at `http://127.0.0.1:8000/admin`.

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
│   │   └── Payroll.php             # Custom Payroll page logic and UI rendering
│   └── Resources/
│       ├── CashAdvances/           # Cash advance requests, approval workflows, & badges
│       ├── Employees/              # Employee directory & form/table schemas
│       ├── Positions/              # Position resource, forms, & AuditLogsRelationManager
│       └── Timesheets/             # Timesheet resource, meal allowance logic, & tooltips
├── Models/
│   ├── CashAdvance.php             # Cash advance model with approval state
│   ├── Employee.php                # Employee model & relationships
│   ├── Position.php                # Position model & change auditor hooks
│   ├── PositionAuditLog.php        # Audit trail model
│   ├── Timesheet.php               # Timesheet model with virtual meal allowance accessor
│   └── User.php                    # System user & authentication model
├── Services/
│   └── PayrollCalculator.php       # Core business logic for hours and pay processing
database/
└── migrations/                     # Schema definitions for employees, positions, audit logs, timesheets, & cash advances
resources/
└── views/
    └── filament/
        └── pages/
            └── payroll.blade.php   # Detailed custom blade view and Alpine print engine
```
