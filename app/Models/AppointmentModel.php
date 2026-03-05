<?php
namespace app\Models;
class AppointmentModel{  
     public $appointment_id;
    public $appointment_code;
    public $patient_id;
    public $doctor_id;
    public $appointment_date;
    public $appointment_time;
    public $reason_for_visit;
    public $token_number;
    public $consultation_fee;
    public $status;
    public $payment_status;
    public $notes;
    public function __construct($data)
    {
        foreach($data as $key=>$v){
                $this->$key=$v;
        }
    }
}