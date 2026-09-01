# Truant App - Employee, Compensation & Timesheet Management System

**Truant App** is an enterprise management platform built using **Laravel 11** and **Filament v3**. It streamlines employee record keeping, compensation and benefits structures, change auditing, and daily employee timesheets with automated meal allowance calculation rules.

---

## 🌟 Key Features & Business Modules

### 1. 👥 Employee Management
- **Complete Employee Directory**: Full CRUD functionality to manage employee records.
- **Detailed Attributes**:
  - First Name & Last Name
  - Address
  - Birthdate
  - Mobile Number
  - Username & Hashed Password Credentials
  - **Required Position Assignment**: Links each employee to an established organizational position.
- **Top-Level Sidebar Placement**: Easily accessible directly from the main sidebar.

---

### 2. 💼 Compensations and Benefits (Position Management)
- **Position Catalog**: Pre-configured organizational roles (e.g., *Secretary, Part Time, Production Staff, Production Head, Jr. Graphic Designer, Sr. Graphic Designer, Semi-Skilled, Labor*).
- **Financial & Insurance Attributes**:
  - **Base Rate** (₱)
  - **Overtime Rate** (₱)
  - **SSS Contribution** (₱)
  - **Philhealth Contribution** (₱)
  - **Pag-ibig Contribution** (₱)
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
  - **Interactive Hover Tooltips**: When a description is provided, a dynamic info icon (`ℹ️`) appears next to the amount. Hovering over the amount or icon displays the reason/description in a tooltip.
- **📅 Daily Table Grouping**: Automatically groups timesheet logs by date under collapsible header sections.

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
│   └── Resources/
│       ├── Employees/          # Employee directory & form/table schemas
│       ├── Positions/          # Position resource, forms, & AuditLogsRelationManager
│       └── Timesheets/         # Timesheet resource, meal allowance logic, & tooltips
├── Models/
│   ├── Employee.php            # Employee model & relationships
│   ├── Position.php            # Position model & change auditor hooks
│   ├── PositionAuditLog.php    # Audit trail model
│   └── Timesheet.php           # Timesheet model with virtual meal allowance accessor
database/
└── migrations/                 # Schema definitions for employees, positions, audit logs, & timesheets
```
