<?php

namespace app\Services;

use app\Models\DoctorModel;
use Exception;

class DoctorService
{

    public function getAll()
    {
        global $pdo;
        $stmt = $pdo->query("SELECT * FROM doctors");
        $doctors = $stmt->fetchAll();
        return $doctors;
    }
    public function create(DoctorModel $doctor)
    {
        global $pdo;
        $doctor->status = "Active";
        if (!$doctor->room) {
            $doctor->room = 509;
        }
        $smtm = $pdo->prepare("INSERT INTO doctors (first_name,last_name,specialization,qualification,
             experience,email,phone,fees,room,
             available_days,available_time,status) VALUES(:first_name,:last_name,:specialization,:qualification,
             :experience,:email,:phone,:fees,:room,
             :available_days,:available_time,:status)");
        $smtm->execute([
            ':first_name' => $doctor->first_name,
            ':last_name' => $doctor->last_name,
            ':specialization' => $doctor->specialization,
            ':qualification' => $doctor->qualification,
            ':experience' => $doctor->experience,
            ':email' => $doctor->email,
            ':phone' => $doctor->phone,
            ':fees' => $doctor->fees,
            ':room' => $doctor->room,
            ':available_days' => $doctor->available_days,
            ':available_time' => $doctor->available_time,
            ':status' => $doctor->status
        ]);
    }
}
