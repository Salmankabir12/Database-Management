-- Healthcare Management System Database Schema
-- Compatible with both local and GitHub versions

CREATE DATABASE IF NOT EXISTS healthcare_system;
USE healthcare_system;

-- Admin table
CREATE TABLE IF NOT EXISTS admin (
    admin_id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    role VARCHAR(50) DEFAULT 'manager',
    admin_status VARCHAR(20) DEFAULT 'active'
);

-- Patient table
CREATE TABLE IF NOT EXISTS patient (
    patient_id INT AUTO_INCREMENT PRIMARY KEY,
    first_name VARCHAR(100) NOT NULL,
    last_name VARCHAR(100),
    name VARCHAR(100),
    email VARCHAR(100) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    phone VARCHAR(20),
    gender VARCHAR(10),
    date_of_birth DATE,
    address TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Doctor table
CREATE TABLE IF NOT EXISTS doctor (
    doctor_id INT AUTO_INCREMENT PRIMARY KEY,
    first_name VARCHAR(100) NOT NULL,
    last_name VARCHAR(100),
    name VARCHAR(100),
    email VARCHAR(100) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    specialization VARCHAR(100),
    phone VARCHAR(20),
    experience_years INT DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Branch table
CREATE TABLE IF NOT EXISTS branch (
    branch_id INT AUTO_INCREMENT PRIMARY KEY,
    branch_name VARCHAR(100) NOT NULL,
    location VARCHAR(100),
    address TEXT,
    city VARCHAR(50),
    district VARCHAR(50),
    contact_number VARCHAR(20),
    phone VARCHAR(20)
);

-- Timeslot table
CREATE TABLE IF NOT EXISTS timeslot (
    timeslot_id INT AUTO_INCREMENT PRIMARY KEY,
    slot_id INT,
    start_time TIME NOT NULL,
    end_time TIME NOT NULL,
    max_patients INT DEFAULT 10
);

-- Doctor schedule table
CREATE TABLE IF NOT EXISTS doctor_schedule (
    schedule_id INT AUTO_INCREMENT PRIMARY KEY,
    doctor_id INT,
    branch_id INT,
    day_of_week VARCHAR(10),
    timeslot_id INT,
    FOREIGN KEY (doctor_id) REFERENCES doctor(doctor_id),
    FOREIGN KEY (branch_id) REFERENCES branch(branch_id),
    FOREIGN KEY (timeslot_id) REFERENCES timeslot(timeslot_id)
);

-- Appointment table
CREATE TABLE IF NOT EXISTS appointment (
    appointment_id INT AUTO_INCREMENT PRIMARY KEY,
    patient_id INT,
    doctor_id INT,
    branch_id INT,
    timeslot_id INT,
    slot_id INT,
    appointment_date DATE NOT NULL,
    booking_time TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    status VARCHAR(20) DEFAULT 'Pending',
    appointment_status VARCHAR(20) DEFAULT 'Pending',
    reason_for_visit TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (patient_id) REFERENCES patient(patient_id),
    FOREIGN KEY (doctor_id) REFERENCES doctor(doctor_id),
    FOREIGN KEY (branch_id) REFERENCES branch(branch_id),
    FOREIGN KEY (timeslot_id) REFERENCES timeslot(timeslot_id)
);

-- Queue table
CREATE TABLE IF NOT EXISTS queue (
    queue_id INT AUTO_INCREMENT PRIMARY KEY,
    appointment_id INT,
    branch_id INT,
    token_number INT NOT NULL,
    queue_number INT,
    status VARCHAR(20) DEFAULT 'Waiting',
    queue_status VARCHAR(20) DEFAULT 'Waiting',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (appointment_id) REFERENCES appointment(appointment_id)
);

-- Medical history table
CREATE TABLE IF NOT EXISTS medical_history (
    history_id INT AUTO_INCREMENT PRIMARY KEY,
    patient_id INT,
    doctor_id INT,
    appointment_id INT,
    diagnosis TEXT,
    prescribed_medicine TEXT,
    medicines TEXT,
    recommended_tests TEXT,
    tests TEXT,
    notes TEXT,
    visit_date DATE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (patient_id) REFERENCES patient(patient_id),
    FOREIGN KEY (doctor_id) REFERENCES doctor(doctor_id),
    FOREIGN KEY (appointment_id) REFERENCES appointment(appointment_id)
);

-- Seed data
INSERT INTO branch (branch_name, location, city, district, contact_number) VALUES
('Uttara', 'Sector 10', 'Dhaka', 'Dhaka', '01736579131'),
('Banani', 'Block H', 'Dhaka', 'Dhaka', '01736579132'),
('Mirpur', 'Road 1', 'Dhaka', 'Dhaka', '01736579133'),
('Gulshan', 'Road 45', 'Dhaka', 'Dhaka', '01736579134'),
('Dhanmondi', 'Road 15', 'Dhaka', 'Dhaka', '01736579135'),
('Mohammadpur', 'Road 2', 'Dhaka', 'Dhaka', '01736579136'),
('Motijheel', 'Road 3', 'Dhaka', 'Dhaka', '01736579137');

INSERT INTO timeslot (start_time, end_time, max_patients) VALUES
('09:00:00', '09:30:00', 5),
('09:30:00', '10:00:00', 5),
('10:00:00', '10:30:00', 5),
('10:30:00', '11:00:00', 5),
('11:00:00', '11:30:00', 5),
('11:30:00', '12:00:00', 5),
('14:00:00', '14:30:00', 5),
('14:30:00', '15:00:00', 5),
('15:00:00', '15:30:00', 5),
('15:30:00', '16:00:00', 5);

INSERT INTO admin (name, email, password, role, admin_status) VALUES
('Admin', 'admin@gmail.com', '$2y$10$3aqUZhlKjOE/e41qhhhtO.u4x7eI/DWCXcXlmGJ3oONQWu98agOE.', 'manager', 'active');

INSERT INTO doctor (first_name, last_name, name, email, password, specialization, experience_years) VALUES
('Dr. Smith', '', 'Dr. Smith', 'dr.smith@healthcare.com', '$2y$10$3aqUZhlKjOE/e41qhhhtO.u4x7eI/DWCXcXlmGJ3oONQWu98agOE.', 'General', 10),
('Dr. Johnson', '', 'Dr. Johnson', 'dr.johnson@healthcare.com', '$2y$10$3aqUZhlKjOE/e41qhhhtO.u4x7eI/DWCXcXlmGJ3oONQWu98agOE.', 'Cardiology', 15),
('Dr. Williams', '', 'Dr. Williams', 'dr.williams@healthcare.com', '$2y$10$3aqUZhlKjOE/e41qhhhtO.u4x7eI/DWCXcXlmGJ3oONQWu98agOE.', 'Pediatrics', 8);

-- Default password for all seeded accounts: admin123
