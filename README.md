# 🏥 Hospital Management System

A simple **Hospital Management System** built with **Core PHP** following the **MVC (Model-View-Controller)** architectural pattern. This project was developed as an internship practice to demonstrate clean separation of concerns using vanilla PHP — no heavy framework required.

---

## ✨ Features

- **Patient Management** — Register, view patients
- **Doctor Management** — Register, view doctors
- **Appointment Booking** — Book appointments with business rule enforcement
- **Token System** — Auto-generated daily token numbers per doctor
- **30-Minute Time Slots** — Appointments every 30 minutes (9:00, 9:30, 10:00 …)
- **Validation Layer** — Server-side validators for all forms
- **Service Layer** — Business logic separated from controllers

---

## 🏗️ Project Structure

```
HOSPITAL-MANAGEMENT-SYSTEM/
├── app/
│   ├── Controllers/
│   │   ├── PatientController.php
│   │   ├── DoctorController.php
│   │   └── AppointmentController.php
│   ├── Models/
│   │   ├── Patient.php
│   │   ├── Doctor.php
│   │   └── Appointment.php
│   ├── Services/
│   │   ├── PatientService.php
│   │   ├── DoctorService.php
│   │   └── AppointmentService.php
│   ├── Validators/
│   │   ├── PatientsValidator.php
│   │   ├── DoctorValidator.php
│   │   └── AppointmentValidator.php
│   ├── Http/
│   └── Views/
│       ├── Patients/
│       ├── Doctors/
│       ├── Appointments/
│       └── layout.php
├── public/
│   ├── index.php          ← Entry point
│   └── assets/
├── routes/
├── config.php
├── composer.json
└── databse.sql            ← Database schema
```

---

## 🧠 Business Rules

| Rule | Details |
|------|---------|
| One appointment per day | A patient can book only **one appointment per day** with the same doctor |
| Token numbers | Token numbers **start from 1** each day per doctor |
| No past dates | Appointments **cannot be booked on past dates** |
| Time slots | Every **30 minutes** — 9:00, 9:30, 10:00, 10:30 … |

---

## 🗄️ Database Schema

Three core tables:

- **`doctors`** — doctor details, specialization, availability, fees, status
- **`patients`** — patient info, blood group, emergency contact, medical history
- **`appointments`** — links patients & doctors, stores token, time, payment status

---

## ⚙️ Prerequisites

| Requirement | Details |
|-------------|---------|
| PHP | >= 7.4 |
| XAMPP | Apache + MySQL (phpMyAdmin) |
| Composer | For autoloading |

---

## 🚀 Getting Started

### 1. Clone the Repository

```bash
git clone https://github.com/your-username/hospital-management-system.git
cd hospital-management-system
```

### 2. Start XAMPP

- Open **XAMPP Control Panel**
- Start **Apache** and **MySQL** services

### 3. Set Up the Database

1. Open your browser and go to [http://localhost/phpmyadmin](http://localhost/phpmyadmin)
2. Click **New** → create a database named `hospital_managment`
3. Select the database → go to the **SQL** tab
4. Copy and paste the contents of `databse.sql` and click **Go**

### 4. Configure Database Connection

Open `config.php` and update your credentials if needed:

```php
define('DB_HOST', 'localhost');
define('DB_NAME', 'hospital_managment');
define('DB_USER', 'root');
define('DB_PASS', '');          // default XAMPP password is empty
```

### 5. Install Dependencies

```bash
composer install
```

### 6. Run the Development Server

> ⚠️ **Important:** The PHP built-in server must be started from the `public/` directory.

```bash
cd public
php -S localhost:5000
```

### 7. Open in Browser

```
http://localhost:5000
```

---

## 🛣️ Available Routes

| Method | Endpoint | Description |
|--------|----------|-------------|
| GET | `/patients` | List all patients |
| GET | `/patients/create` | Show add patient form |
| POST | `/patients/store` | Store new patient |
| GET | `/doctors` | List all doctors |
| GET | `/doctors/create` | Show add doctor form |
| POST | `/doctors/store` | Store new doctor |
| GET | `/appointments` | List all appointments |
| GET | `/appointments/create` | Show book appointment form |
| POST | `/appointments/store` | Book new appointment |
| POST | `/appointments/delete/{id}` | Cancel appointment |

---

## 🧩 MVC Architecture Overview

```
Request → Router → Controller → Service → Model → Database
                      ↓
                   Validator
                      ↓
                    View (Response)
```

- **Model** — Handles direct database queries (PDO)
- **Controller** — Receives HTTP requests, calls services, returns views
- **Service** — Contains business logic and orchestration
- **Validator** — Validates incoming form data before processing
- **View** — PHP HTML templates rendered by the controller

---

## 🛠️ Tech Stack

| Layer | Technology |
|-------|-----------|
| Language | Core PHP (no framework) |
| Architecture | MVC Pattern |
| Database | MySQL via phpMyAdmin |
| Server | PHP Built-in Dev Server / Apache (XAMPP) |
| Autoloading | Composer PSR-4 |
| Frontend | HTML, CSS, Vanilla JS |
