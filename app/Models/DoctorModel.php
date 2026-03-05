<?php
namespace app\Models;
class DoctorModel{
    public $doctor_id;
    public $first_name;
    public $last_name;
    public $specialization;
    public $qualification;
    public $experience;
    public $email;
    public $phone;
    public $fees;
    public $room;
    public $available_days;
    public $available_time;
    public $status;
    public function __construct($data)
    {
        foreach($data as $key=>$v){
                $this->$key=$v;
        }
    }
}