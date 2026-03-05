<?php
namespace app\Models;
class PatientModel{
    public $patient_id;
    public $first_name;
    public $last_name;
    public $date_of_birth;
    public $age;
    public $gender;
    public $blood_group;
    public $email;
    public $phone;
    public $address;
    public $city;
    public $emergency_contact;
    public $emergency_phone;
    public $medical_history;
    public $registration_date;
    public $status;
    public function __construct($data)
    {
       
        foreach($data as $key=>$v){
                $this->$key=$v;
        }
    }
}