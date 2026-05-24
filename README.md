# RozMed Enterprises Inc. Management System

A Laravel-based modular monolith management system for RozMed Enterprises Inc., a medical and laboratory equipment supplier. Built as a course requirement for CS12L Software Engineering 1 at the University of Mindanao.

**Submitted by:** Mantua, Gabriel T. · Picardal, Liea Maegan C. · Pintor, Tristhan Alfie  
**Submitted to:** Ms. Feranz Salonga

---

## System Overview

The RozMed Management System replaces fully manual business operations with a centralized digital platform. It is built on the **Modular Monolith Architecture** pattern using Laravel 12, organized into five core subsystems that share a single SQLite database.

### Core Subsystems

| Module | Description |
|--------|-------------|
| **Product Catalog Management** | Public-facing product browsing, search, and inquiry submission. Admin CRUD for products with image upload, category filtering, and availability badges. |
| **Inventory Management** | Real-time stock tracking across multiple warehouse locations. Supports Stock In, Stock Out, inter-location transfers, aging inventory reports, and daily scan logs. |
| **Customer Management (CRM)** | Centralized customer profiles, quotation pipeline tracking, interaction logging, follow-up scheduling, and conversion analytics. |
| **Financial Management & Payment Tracking** | Invoice generation with auto-numbering, multi-channel payment recording (GCash, Bank Transfer, Check, Cash), payment plan creation with installment schedules, and overdue alerts. |
| **Document Management** | Quotation generation from templates, version control, supporting document uploads (FDA certificates, compliance docs), and document status tracking. |

### Key Features

- Dynamic product catalog with category-based navigation and inquiry forms
- Multi-location inventory with aging reports and replenishment alerts
- Quotation pipeline (Draft → Sent → Pending → Won/Lost) with VAT-inclusive calculations (12% Philippine VAT)
- Payment plan creation supporting 2–24 installment schedules
- Role-based access control (Admin, SalesStaff, FinanceStaff, InventoryManager, SystemAdmin)
- Soft deletes across critical tables for data preservation
- Dual-currency support (PHP and USD) with exchange rate monitoring

---

## Tech Stack

- **Framework:** Laravel 12 (PHP 8.2+)
- **Database:** SQLite
- **Frontend:** Blade Templates, Tailwind CSS v4, Vanilla JavaScript (AJAX modals)
- **Build Tool:** Vite with Laravel Vite Plugin
- **Date Picker:** Flatpickr
- **Icons:** Font Awesome 6
- **Fonts:** Google Fonts — Instrument Sans

---

## Requirements

Before installing, ensure the following are available on your machine:

- PHP >= 8.2
- Composer
- Node.js >= 18 and npm
- Git
- SQLite (bundled with PHP on most systems)

---

## Installation Instructions

### 1. Clone the Repository

```bash
git clone https://github.com/your-username/rozmed-management-system.git
cd rozmed-management-system
```

### 2. Install PHP Dependencies

```bash
composer install
```

### 3. Install Node.js Dependencies

```bash
npm install
```

### 4. Set Up Environment File

```bash
cp .env.example .env
```

Open `.env` and verify the following settings are correct:

```env
APP_NAME=RozMed
APP_ENV=local
APP_KEY=
APP_DEBUG=true
APP_URL=http://localhost

DB_CONNECTION=sqlite
```

> The database file will be created automatically at `database/database.sqlite`.

### 5. Generate Application Key

```bash
php artisan key:generate
```

### 6. Create the SQLite Database File

```bash
touch database/database.sqlite
```

### 7. Run Migrations

```bash
php artisan migrate
```

This will create all 18 tables including: `users`, `customers`, `products`, `inventories`, `inventory_transactions`, `quotations`, `quotation_line_items`, `sales`, `payment_plans`, `payment_installments`, `documents`, `quotation_templates`, `suppliers`, `locations`, `customer_interactions`, `exchange_rates`, `alert_logs`, and `sessions`.

### 8. (Optional) Seed the Database

```bash
php artisan db:seed
```

### 9. Create Storage Symlink

```bash
php artisan storage:link
```

This allows product images uploaded to `storage/app/public` to be served publicly.

### 10. Build Frontend Assets

For development (with hot reload):

```bash
npm run dev
```

For production:

```bash
npm run build
```

---

## Running the System

### Option 1: Run All Services at Once (Recommended for Development)

The project is configured with a `dev` script in `composer.json` that starts the web server, queue worker, and Vite dev server concurrently:

```bash
composer dev
```

This runs:
- `php artisan serve` — Laravel development server at `http://localhost:8000`
- `php artisan queue:listen --tries=1` — Queue worker for background jobs
- `npm run dev` — Vite dev server for hot module replacement

### Option 2: Run Services Manually

Open three separate terminal windows:

**Terminal 1 — Laravel Server:**
```bash
php artisan serve
```

**Terminal 2 — Queue Worker:**
```bash
php artisan queue:listen --tries=1
```

**Terminal 3 — Vite Dev Server:**
```bash
npm run dev
```

### Accessing the Application

Once running, open your browser and navigate to:
http://localhost:8000

| Page | URL |
|------|-----|
| Home / Landing Page | `http://localhost:8000` |
| Product Catalog (Public) | `http://localhost:8000/products` |
| About Us | `http://localhost:8000/about` |
| Contact / Inquiry | `http://localhost:8000/contact` |
| Admin Dashboard | `http://localhost:8000/admin` |
| Admin — Products | `http://localhost:8000/admin/products` |
| Admin — Inventory | `http://localhost:8000/admin/inventory` |
| Admin — Customers (CRM) | `http://localhost:8000/admin/customers` |
| Admin — Finance | `http://localhost:8000/admin/finance` |
| Admin — Documents | `http://localhost:8000/admin/documents` |

---

## Project Structure
app/
├── Http/Controllers/          # Route handlers for all modules
├── Models/                    # Eloquent models (shared across modules)
├── Modules/
│   ├── Shared/                # Logging, Validation, Sanitization, Custom Exceptions
│   ├── Product/               # ProductService, ProductRepository, InquiryRequest
│   ├── Customer/              # CustomerService, CustomerRepository, Form Requests
│   ├── Inventory/             # InventoryService, InventoryRepository
│   └── Finance/               # FinanceService, TransactionRepository
├── Mail/                      # InquiryConfirmation, InquiryReceived
└── Providers/
database/
├── migrations/                # All 18+ table migrations
└── factories/                 # User and Customer factories
resources/
├── views/
│   ├── home/                  # Public landing page
│   ├── products/              # Public product catalog
│   ├── contact/               # Contact and inquiry page
│   ├── about/                 # About us page
│   ├── dashboard/             # Admin dashboard
│   ├── productdetails/        # Admin product management
│   ├── inventory/             # Admin inventory management
│   ├── customer/              # Admin CRM
│   ├── finance/               # Admin financial management
│   ├── document/              # Admin document management
│   └── components/            # Shared header, footer, sidebar, modals
├── css/                       # Per-page CSS files
└── js/                        # JavaScript modules and modal services
routes/
└── web.php                    # All public and admin routes

---

## Database Schema Summary

All product categories use PascalCase enum values:
DiagnosticEquipment | MedicalInstruments | MonitoringDevices
EmergencyEquipment  | InfusionSystems    | LaboratoryEquipment

User roles:
Admin | SalesStaff | FinanceStaff | InventoryManager | SystemAdmin

Quotation status flow:
Draft → Sent → Pending → Won / Lost

Payment installment statuses:
Pending → Paid / Overdue / Partial

> **Note:** Philippine 12% VAT (VAT-inclusive) is applied to all financial calculations throughout the system.

---

## Common Artisan Commands

```bash
# Clear all caches
php artisan optimize:clear

# Run migrations fresh (drops and recreates all tables)
php artisan migrate:fresh

# Run migrations fresh with seeding
php artisan migrate:fresh --seed

# View all registered routes
php artisan route:list

# Run tests
php artisan test
```

---

## Troubleshooting

**SQLite file not found:**  
Run `touch database/database.sqlite` before migrating.

**Storage images not loading:**  
Run `php artisan storage:link` to create the public symlink.

**Assets not loading (blank styles):**  
Make sure `npm run dev` or `npm run build` has been run. Check that Vite is running if using dev mode.

**Queue jobs not processing:**  
Start the queue worker with `php artisan queue:listen`.

**Migration errors about missing tables:**  
Run migrations in order using `php artisan migrate:fresh` if setting up for the first time.

---

## License

This project is an academic submission for CS12L Software Engineering 1, University of Mindanao. All rights reserved by the authors.