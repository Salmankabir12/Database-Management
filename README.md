# Healthcare Management System

A web-based healthcare management system built with PHP, MySQL, Bootstrap, and JavaScript. Patients can register, book appointments, and view medical history. Doctors manage queues and records. Admins oversee the entire system.

## Features

- **Patient Portal**: Register, login, book/cancel appointments, view queue status and medical history
- **Doctor Portal**: Manage patient queue, update appointment status, add medical records
- **Admin Portal**: Manage doctors, schedules, and system oversight
- **Queue Management**: Token-based waiting system with live status
- **Appointment Booking**: Conflict detection, slot capacity limits, schedule validation

## Tech Stack

- **Frontend**: HTML, CSS, Bootstrap 4/5
- **Backend**: PHP (with prepared statements)
- **Database**: MySQL (phpMyAdmin compatible)
- **Security**: Password hashing with password_hash()/password_verify()

## Directory Structure

```
.
├── index.html          # Landing page
├── index.php           # Alternative homepage
├── config/
│   ├── db.php          # Database connection
│   └── schema.sql      # Full database schema with seed data
├── patient/            # Patient portal files
├── doctor/             # Doctor portal files
├── admin/              # Admin portal files
├── actions/            # Shared action handlers
├── api/                # AJAX endpoint responses
└── common/             # Shared navbar/footer
```

## Installation

1. Install XAMPP/WAMP/LAMP with PHP 8+ and MySQL
2. Clone to htdocs (XAMPP) or web root
3. Import config/schema.sql via phpMyAdmin or CLI
4. Update config/db.php with your MySQL credentials
5. Access at http://localhost/healthcare_system

### Default Logins

| Role    | Email                  | Password |
|---------|------------------------|----------|
| Admin   | admin@gmail.com        | admin123 |
| Patient | (register a new account) |         |

---

## Discussion Topics

### Database Design & Architecture

#### 1. Entity-Relationship (ER) Model

The system revolves around nine core entities:

| Entity            | Description                                  | Key Attributes                                         |
|-------------------|----------------------------------------------|--------------------------------------------------------|
| `patient`         | Individuals seeking healthcare services      | patient_id, name, email, password, phone, address      |
| `doctor`          | Medical professionals providing care         | doctor_id, name, email, specialization, experience_yrs |
| `admin`           | System administrators                        | admin_id, name, email, role, status                    |
| `branch`          | Physical clinic/hospital locations           | branch_id, name, location, city, contact               |
| `timeslot`        | Available time windows for appointments      | timeslot_id, start_time, end_time, max_patients        |
| `doctor_schedule` | Which doctors work when/where                | schedule_id, doctor_id, branch_id, day, timeslot_id    |
| `appointment`     | Booked appointments linking all entities     | appointment_id, patient_id, doctor_id, branch_id, date |
| `queue`           | Token-based waiting list                     | queue_id, appointment_id, token_number, status         |
| `medical_history` | Patient medical records                       | history_id, patient_id, doctor_id, diagnosis, medicines |

Relationships:
- A **patient** books many **appointments** (1:N)
- A **doctor** has many **appointments** and **schedules** (1:N)
- An **appointment** generates one **queue** entry (1:1)
- An **appointment** may produce one **medical_history** record (1:1)
- A **doctor** can work at multiple **branches** via **doctor_schedule** (M:N resolved)

#### 2. Normalization

The schema follows **Third Normal Form (3NF)**:

- **1NF**: All columns are atomic (no multi-valued attributes). Each table has a primary key.
- **2NF**: No partial dependencies. All non-key attributes depend on the full primary key.
  - Example: In `appointment`, `appointment_date` depends on the full `appointment_id`, not just on `patient_id`.
- **3NF**: No transitive dependencies. 
  - Example: `doctor.specialization` depends only on `doctor_id`, not via another attribute.
  - Branch details (`city`, `district`, `contact_number`) depend only on `branch_id`.

**Before normalization (denormalized single table)**:

| appointment_id | patient_name | doctor_name | branch_name | start_time | status |
|----------------|--------------|-------------|-------------|------------|--------|

Problems: data redundancy, update anomalies, insertion anomalies. Normalization splits these into separate tables, eliminating duplication.

#### 3. SQL Concepts Used

- **DDL**: CREATE TABLE, ALTER TABLE (schema definition in `config/schema.sql`)
- **DML**: INSERT, SELECT, UPDATE, DELETE (across all PHP files)
- **Joins**: INNER JOIN to link appointments with patient/doctor/branch data
- **Prepared Statements**: Parameterized queries (`$stmt->bind_param()`) prevent SQL injection
- **Subqueries**: Used in `top_doctors.php` to find max experience years
- **Aggregate Functions**: COUNT, MAX used in queue token assignment
- **Foreign Keys**: Enforce referential integrity across all related tables

#### 4. Indexing Strategy

Primary keys are auto-indexed in MySQL. Additional indexes could be added on:
- `appointment(doctor_id, appointment_date)` — speeds up doctor's daily view
- `appointment(patient_id)` — speeds up patient's appointment history
- `queue(appointment_id)` — speeds up queue lookups

---

### Web Technology Discussion

#### 1. Client-Server Architecture

```
[Browser] <--HTTP/HTTPS--> [Apache/Nginx (PHP)] <--MySQLi--> [MySQL DB]
```

- **Client**: Browser renders HTML/CSS/JS, sends form data via POST/GET
- **Server**: PHP processes requests, validates input, queries database
- **Database**: MySQL stores all persistent data
- **Stateless Protocol**: Each HTTP request is independent; sessions maintained via `$_SESSION`

#### 2. Session Management

PHP sessions (`session_start()`) maintain user state across requests:
- On login: `$_SESSION['patient_id']`, `$_SESSION['doctor_id']`, or `$_SESSION['admin_id']` is set
- On each page: session check guards against unauthorized access
- On logout: `session_destroy()` clears the session
- Sessions stored server-side; only session ID cookie sent to client

#### 3. Form Handling & Validation

Two patterns used:
- **Self-submitting forms** (e.g., `patient/register.php`): The same PHP file renders the form AND processes the POST. Logic branches via `$_SERVER['REQUEST_METHOD'] == 'POST'`.
- **Separate action handlers** (e.g., `actions/book_process.php`): Form submits to a dedicated PHP file, which then redirects.

Validation layers:
- **Client-side**: HTML5 `required` attribute on inputs
- **Server-side**: PHP checks for empty fields, email format, duplicate entries, and date validity

#### 4. Security Measures

- **SQL Injection Prevention**: All queries use prepared statements with bound parameters (`$stmt->bind_param()`)
- **Password Security**: `password_hash(PASSWORD_DEFAULT)` with bcrypt, verified via `password_verify()` — never stored in plain text or MD5
- **Session Security**: Authentication checks on every protected page
- **Input Validation**: Server-side sanitization with `trim()`, `filter_var()`, type checking

#### 5. Frontend Stack

- **HTML5**: Semantic markup, form elements, meta tags
- **CSS**: Bootstrap 4/5 for responsive layout, utility classes
- **Bootstrap**: Grid system, cards, alerts, navbars, buttons, tables
- **JavaScript**: Bootstrap JS bundle for interactive components (dropdowns, modals)

#### 6. AJAX & Dynamic Features

The `api/` directory contains AJAX endpoints (`get_branches.php`, `get_doctor_schedule.php`, `get_slots.php`) that return JSON for dynamic form updates without page reload.

---

### Architectural Decisions & Trade-offs

#### Monolithic vs. Modular

The PHP code uses a role-based directory structure (patient/, doctor/, admin/) rather than a full MVC framework. This is appropriate because:
- The project scope is small and manageable
- No complex routing is needed
- Setup is trivial (just needs Apache + PHP)
- Trade-off: Less separation of concerns compared to Laravel/Symfony

#### Token-Based Queue System

Queue tokens are computed as `COUNT(existing) + 1` rather than using MySQL AUTO_INCREMENT. This ensures tokens are sequential per doctor per day, resetting naturally as old appointments end.

#### Dual Field Names (Backward Compatibility)

The schema includes both `status`/`appointment_status` and `token_number`/`queue_number` columns to maintain compatibility between the local and GitHub codebases. Future cleanup could standardize on one naming convention.

---

### Course Topics (CSE311)

This project demonstrates the following database course concepts:

1. **ER Diagram to Relational Mapping**: Converting entities, attributes, and relationships into normalized tables
2. **Functional Dependencies & Normalization**: Identifying dependencies, decomposing to 3NF
3. **ACID Properties**: The system relies on MySQL's InnoDB engine for Atomicity, Consistency, Isolation, Durability
4. **Transaction Management**: Appointment booking involves multiple INSERTs (appointment + queue) that should be wrapped in a transaction
5. **Query Optimization**: Using prepared statements, proper JOINs, and indexed columns
6. **Integrity Constraints**: PRIMARY KEY, FOREIGN KEY, UNIQUE, NOT NULL, CHECK via application logic
7. **Views & Reports**: Doctor scheduling and appointment summaries can be exposed as SQL views

### Future Improvements & TODO

- [ ] Wrap booking process in a database transaction
- [ ] Add input CSRF protection
- [ ] Implement pagination for appointment lists
- [ ] Add email notification for appointment confirmation
- [ ] Create SQL views for common queries
- [ ] Add REST API endpoints for mobile access
- [ ] Implement role-based access control (RBAC) at the database level
- [ ] Add unit tests with PHPUnit
- [ ] Migrate to a proper PHP framework (Laravel/Symfony) for larger scale
