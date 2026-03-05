<?php
namespace app\Validators;

use app\Services\AppointmentService;

class AppointmentValidator
{
    public function validate(array $data): array
    {
        $errors  = [];
        $service = new AppointmentService();

        $required = [
            'patient_id'        => 'Patient',
            'doctor_id'         => 'Doctor',
            'appointment_date'  => 'Appointment date',
            'appointment_time'  => 'Appointment time',
            'reason_for_visit'  => 'Reason for visit',
        ];
        foreach ($required as $field => $label) {
            if (empty($data[$field])) {
                $errors[] = "$label is required.";
            }
        }
        if ($errors) return $errors;

        $doctorId  = (int)$data['doctor_id'];
        $patientId = (int)$data['patient_id'];
        $date      = $data['appointment_date'];
        $time      = $data['appointment_time'];
        if ($date < date('Y-m-d')) {
            $errors[] = 'Cannot book an appointment on a past date.';
        }
        if ($service->hasDuplicateAppointment($patientId, $doctorId, $date)) {
            $errors[] = 'This patient already has an appointment with this doctor on the selected date.';
        }
        if ($service->isSlotTaken($doctorId, $date, $time)) {
            $errors[] = 'This time slot is already booked for the selected doctor on that date. Please choose a different time.';
        }
        $doctor = $service->getDoctorById($doctorId);
        if (!$doctor) {
            $errors[] = 'Selected doctor not found.';
            return $errors;
        }

      

        return $errors;
    }
}
