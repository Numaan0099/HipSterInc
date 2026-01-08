# Junior Laravel Developer – Technical Assessment

**Applicant:** Syed Numaan Ali  
**Role:** Junior Laravel Developer (L1)  
**Company:** Hipster Inc.

---

## 📌 Overview

This repository contains my submission for the Junior Laravel Developer (L1) Technical Assessment.
The project demonstrates my approach to building scalable, production-ready Laravel features, following the requirements specified in the provided assessment PDF.

**Key focus areas include:**

- clean architecture
- real-time systems using WebSockets
- multi-guard authentication
- data integrity
- maintainable frontend structure with Inertia + Vue

---

## 🧱 Tech Stack

- **Backend:** Laravel (latest)
- **Frontend:** Vue 3 + Inertia.js + TypeScript
- **Database:** MySQL
- **Real-time:** Laravel Broadcasting + WebSockets (Laravel Echo)
- **Authentication:** Multi-guard (admin, customer)
- **Styling:** Bootstrap 5
- **Build Tool:** Vite

---

## 🔐 Authentication & Guards

The application uses two separate guards with separate tables, as required:

| Role     | Guard    | Table     |
|----------|----------|-----------|
| Admin    | admin    | admins    |
| Customer | customer | customers |

**Each guard has:**

- independent authentication flow
- separate dashboard access
- isolated online presence tracking

---

## 🟢 Real-Time User Presence (WebSockets Only)

As required by the assessment PDF, **no polling or AJAX-based updates are used**.

**Implemented using:**

- Presence Channels
- Laravel Echo
- WebSockets
- Database-persisted online status

**How it works:**

1. Admins and customers authenticate using their respective guards
2. Users join guard-specific presence channels
3. Online status is updated in the database
4. Admin dashboard reflects real-time online/offline users
5. On logout, users are marked offline

**The Admin dashboard displays:**

- Online Admins
- Online Customers

in real time.

---

## 📦 Product Management

**Implemented Features:**

- Product CRUD
- Bulk product import (CSV / XLSX)
- Chunked & queued imports
- Validation and error handling
- Import history with status tracking
- Search and filters with debounce
- Pagination with preserved filters

**A sample file is included:**

`products_sample_import.csv`

---

## 📊 Import Reliability

Each import tracks:

- status (pending, processing, completed, failed)
- processed rows
- failed rows

Admins can review import history from the admin panel.

---

## 🧭 UI Structure

- Separate Admin Layout and Customer Layout

**Displays:**

- Name
- Email
- Logout option

Clean and minimal UI for clarity.

---

## ▶️ Setup Instructions

**1. Clone the repository:**
```bash
git clone <https://github.com/Numaan0099/HipSterInc>
cd project
```

**2. Install dependencies:**
```bash
composer install
composer require maatwebsite/excel
composer require pusher/pusher-php-server

npm install
npm install --save laravel-echo pusher-js
```

**3. Environment setup:**
```bash
cp .env.example .env
php artisan key:generate
```

**4. Database setup:**

**Option A - Using SQL Dump (Recommended):**
```bash
# Import the provided SQL dump file
mysql -u your_username -p your_database_name < hipsterinc.sql
```

**Option B - Fresh Migration:**
```bash
php artisan migrate
```

**Note:** A complete SQL dump file `hipsterinc.sql` is available in the root directory with sample data and structure.

**5. Run the application:**
```bash
php artisan serve
npm run dev
```

**6. Start background jobs:**
```bash
php artisan queue:work
```

---

## 📝 Notes

- WebSockets are used strictly for real-time features
- No polling is used, per assessment instructions
- Code is structured for readability and extensibility
- Decisions prioritize correctness and maintainability

---

## ✅ Assessment Status

All requirements outlined in the assessment PDF have been implemented and tested locally.

---

## 🙏 Thank You

Thank you for the opportunity to complete this assessment.  
I look forward to discussing my approach and decisions during the interview.

— **Syed Numaan Ali**

---
