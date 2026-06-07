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

## Database Schema

Includes tables: admin, patient, doctor, branch, timeslot, doctor_schedule, appointment, queue, medical_history. See config/schema.sql for full details.
