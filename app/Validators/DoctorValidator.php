<?php
namespace app\Validators;
class DoctorValidator{
    public function validate($data){
        $errors=[];
        if(empty($data["first_name"])){
            $errors[]="First name is required.";
        }
        if(empty($data["last_name"])){
            $errors[]="Last name is required.";
        }
        if(empty($data["specialization"])){
            $errors[]="Specialization is required.";
        }
        if(empty($data["qualification"])){
            $errors[]="Qualification is required.";
        }
        if(empty($data["experience"]) && $data["experience"] !== '0'){
            $errors[]="Experience is required.";
        }
        if(empty($data["phone"])){
            $errors[]="Phone number is required.";
        }
        if(empty($data["fees"])){
            $errors[]="Consultation fees is required.";
        }
        if(empty($data["available_days"])){
            $errors[]="Please select at least one available day.";
        }
        if(empty($data["available_time"])){
            $errors[]="Please set available time hours.";
        }
        return $errors;
    }

}