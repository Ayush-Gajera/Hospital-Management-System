<?php

namespace app\Validators;

use app\Models\PatientModel;

class PatientsValidator
{
    public function validate($patient)
    {
        $error = [];
        if (!isset($patient["first_name"])) {
            $error[] = "is required";
        }
        if (!isset($patient["last_name"])) {
            $error[] = "last_name is required";
        }
        if (!isset($patient["age"])) {
            $error[] = "age is required";
        }
        if (!isset($patient["phone"])) {
            $error[] = "phone is required";
        }
        if (!isset($patient["emergency_contact"])) {
            $error[] = "emergency_contact is required";
        }
        if (!isset($patient["blood_group"])) {
            $error[] = "blood_group is required";
        }
        return $error;
    }
}
