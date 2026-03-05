<?php

namespace app\Services;

use app\Models\PatientModel;

class PatientService
{
    public function getall()
    {
        global $pdo;
        $smtm = $pdo->query("SELECT * FROM patients");
        return $smtm->fetchAll();
    }
    public function create(PatientModel $patient)
    {
        global $pdo;
        $patient->registration_date = date('Y-m-d');
        $stmt = $pdo->prepare("INSERT INTO patients 
        (first_name, last_name, date_of_birth, age, gender, blood_group,
        email, phone, address, city, emergency_contact, emergency_phone,
        medical_history, registration_date, status)
         VALUES(:first_name, :last_name, :date_of_birth, :age, :gender, :blood_group,
        :email, :phone, :address, :city, :emergency_contact, :emergency_phone,
        :medical_history, :registration_date, :status)");

        $stmt->execute([
            ':first_name' => $patient->first_name,
            ':last_name' => $patient->last_name,
            ':date_of_birth' => $patient->date_of_birth,
            ':age' => $patient->age,
            ':gender' => $patient->gender,
            ':blood_group' => $patient->blood_group,
            ':email' => $patient->email,
            ':phone' => $patient->phone,
            ':address' => $patient->address,
            ':city' => $patient->city,
            ':emergency_contact' => $patient->emergency_contact,
            ':emergency_phone' => $patient->emergency_phone,
            ':medical_history' => $patient->medical_history,
            ':registration_date' => $patient->registration_date,
            ':status' => $patient->status
        ]);
    }
}
