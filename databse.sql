CREATE DATABASE hospital_managment;
USE hospital_managment;
CREATE TABLE doctors(
		doctor_id INT AUTO_INCREMENT PRIMARY KEY,
		first_name varchar(50) NOT NULL,
		last_name varchar(50) NOT NULL,
		specialization varchar(50) NOT NULL,
		qualification VARCHAR(50 NOT NULL,
		experience INT NOT NULL,
		email varchar(100) NOT NULL,
		phone  varchar(100) NOT NULL,
		fees DECIMAL(10,2) NOT NULL,
		room varchar(20),
		available_days VARCHAR(100) NOT NULL,
        available_time VARCHAR(50) NOT NULL,
        status ENUM('Active','On Leave','Inactive') DEFAULT 'Active',
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
)
CREATE TABLE patients (
    patient_id INT AUTO_INCREMENT PRIMARY KEY,
    first_name VARCHAR(50) NOT NULL,
    last_name VARCHAR(50) NOT NULL,
    date_of_birth DATE NOT NULL,
    age INT,
    gender ENUM('Male','Female','Other'),
    blood_group ENUM('A+','A-','B+','B-','O+','O-','AB+','AB-'),
    email VARCHAR(100),
    phone VARCHAR(20) NOT NULL,
    address TEXT NOT NULL,
    city VARCHAR(50) NOT NULL,
    emergency_contact VARCHAR(100) NOT NULL,
    emergency_phone VARCHAR(20) NOT NULL,
    medical_history TEXT,
    registration_date DATE DEFAULT (CURRENT_DATE),
    status ENUM('Active','Inactive') DEFAULT 'Active',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);
CREATE TABLE appointments (
    appointment_id INT AUTO_INCREMENT PRIMARY KEY,

    appointment_code VARCHAR(20) UNIQUE,

    patient_id INT NOT NULL,
    doctor_id INT NOT NULL,

    appointment_date DATE NOT NULL,
    appointment_time TIME NOT NULL,

    reason_for_visit TEXT NOT NULL,

    token_number INT NOT NULL,

    consultation_fee DECIMAL(10,2) NOT NULL,

    status ENUM('Scheduled','Completed','Cancelled','No Show')
        DEFAULT 'Scheduled',

    payment_status ENUM('Pending','Paid')
        DEFAULT 'Pending',

    notes TEXT,

    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,

    CONSTRAINT fk_patient
        FOREIGN KEY (patient_id) REFERENCES patients(patient_id)
        ON DELETE RESTRICT ON UPDATE CASCADE,

    CONSTRAINT fk_doctor
        FOREIGN KEY (doctor_id) REFERENCES doctors(doctor_id)
        ON DELETE RESTRICT ON UPDATE CASCADE
);

CREATE INDEX idx_appointment_date ON appointments(appointment_date);
CREATE INDEX idx_doctor_date ON appointments(doctor_id, appointment_date);