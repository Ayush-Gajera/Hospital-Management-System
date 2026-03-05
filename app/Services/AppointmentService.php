<?php
namespace app\Services;

use app\Models\AppointmentModel;

class AppointmentService
{
    public function getAll(): array
    {
        global $pdo;
        $stmt = $pdo->query("
            SELECT a.*,
                   CONCAT(d.first_name,' ',d.last_name) AS doctor_name,
                   d.specialization,
                   CONCAT(p.first_name,' ',p.last_name) AS patient_name
            FROM appointments a
            JOIN doctors  d ON a.doctor_id  = d.doctor_id
            JOIN patients p ON a.patient_id = p.patient_id
            ORDER BY a.appointment_date DESC, a.appointment_time ASC
        ");
        return $stmt->fetchAll();
    }
    public function getNextTokenNumber(int $doctorId, string $date): int
    {
        global $pdo;
        $stmt = $pdo->prepare("
            SELECT COUNT(*) FROM appointments
            WHERE doctor_id = :doc AND appointment_date = :date
              AND status != 'Cancelled'
        ");
        $stmt->execute([':doc' => $doctorId, ':date' => $date]);
        return (int)$stmt->fetchColumn() + 1;
    }
    public function isSlotTaken(int $doctorId, string $date, string $time): bool
    {
        global $pdo;
        $stmt = $pdo->prepare("
            SELECT COUNT(*) FROM appointments
            WHERE doctor_id        = :doc
              AND appointment_date = :date
              AND appointment_time = :time
              AND status          != 'Cancelled'
        ");
        $stmt->execute([':doc' => $doctorId, ':date' => $date, ':time' => $time]);
        return (int)$stmt->fetchColumn() > 0;
    }
    public function hasDuplicateAppointment(int $patientId, int $doctorId, string $date): bool
    {
        global $pdo;
        $stmt = $pdo->prepare("
            SELECT COUNT(*) FROM appointments
            WHERE patient_id = :pat AND doctor_id = :doc AND appointment_date = :date
              AND status != 'Cancelled'
        ");
        $stmt->execute([':pat' => $patientId, ':doc' => $doctorId, ':date' => $date]);
        return (int)$stmt->fetchColumn() > 0;
    }
    public function getDoctorById(int $doctorId): ?array
    {
        global $pdo;
        $stmt = $pdo->prepare("SELECT * FROM doctors WHERE doctor_id = :id");
        $stmt->execute([':id' => $doctorId]);
        $result = $stmt->fetch();
        return $result ?: null;
    }
    public function getDoctorsForDropdown(): array
    {
        global $pdo;
        $stmt = $pdo->query("
            SELECT doctor_id, first_name, last_name, specialization, fees, available_days, available_time
            FROM doctors WHERE status = 'Active' ORDER BY first_name
        ");
        return $stmt->fetchAll();
    }
    public function getPatientsForDropdown(): array
    {
        global $pdo;
        $stmt = $pdo->query("
            SELECT patient_id, first_name, last_name, phone
            FROM patients WHERE status = 'Active' ORDER BY first_name
        ");
        return $stmt->fetchAll();
    }
    public function create(AppointmentModel $appt): void
    {
        global $pdo;


        $appt->appointment_code = 'APT-' . date('Ymd') . '-' . strtoupper(substr(uniqid(), -5));
        $appt->status           = 'Scheduled';
        $appt->payment_status   = 'Pending';

        $stmt = $pdo->prepare("
            INSERT INTO appointments
                (appointment_code, patient_id, doctor_id, appointment_date, appointment_time,
                 reason_for_visit, token_number, consultation_fee, status, payment_status, notes)
            VALUES
                (:code, :pat, :doc, :date, :time,
                 :reason, :token, :fee, :status, :payment, :notes)
        ");
        $stmt->execute([
            ':code'   => $appt->appointment_code,
            ':pat'    => $appt->patient_id,
            ':doc'    => $appt->doctor_id,
            ':date'   => $appt->appointment_date,
            ':time'   => $appt->appointment_time,
            ':reason' => $appt->reason_for_visit,
            ':token'  => $appt->token_number,
            ':fee'    => $appt->consultation_fee,
            ':status' => $appt->status,
            ':payment'=> $appt->payment_status,
            ':notes'  => $appt->notes ?? '',
        ]);
    }
    public function delete(int $appointmentId): ?string
    {
        global $pdo;
        $stmt = $pdo->prepare("SELECT status FROM appointments WHERE appointment_id = :id");
        $stmt->execute([':id' => $appointmentId]);
        $appt = $stmt->fetch();

        if (!$appt) {
            return 'Appointment not found.';
        }
        if ($appt['status'] !== 'Scheduled') {
            return "Cannot cancel a '{$appt['status']}' appointment.";
        }

        $del = $pdo->prepare("UPDATE appointments SET status='Cancelled' WHERE appointment_id = :id");
        $del->execute([':id' => $appointmentId]);
        return null;
    }
}
