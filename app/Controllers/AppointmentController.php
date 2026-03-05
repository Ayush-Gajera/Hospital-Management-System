<?php
namespace app\Controllers;

use app\Models\AppointmentModel;
use app\Services\AppointmentService;
use app\Validators\AppointmentValidator;

class AppointmentController
{
    /**
     * GET /appointment
     * Show the appointments list.
     */
    public function index(): array
    {
        $service      = new AppointmentService();
        $appointments = $service->getAll();

        return [
            'view'   => 'Appointments/index',
            'params' => ['appointments' => $appointments],
        ];
    }

    /**
     * GET /appointment/create
     * Show the booking form with doctor + patient dropdowns.
     */
    public function create(): array
    {
        $service = new AppointmentService();
        $doctors  = $service->getDoctorsForDropdown();
        $patients = $service->getPatientsForDropdown();

        return [
            'view'   => 'Appointments/create',
            'params' => [
                'doctors'  => $doctors,
                'patients' => $patients,
            ],
        ];
    }

    /**
     * POST /create/appointment
     * Validate + persist a new appointment.
     */
    public function store(array $data): string
    {
        $validator = new AppointmentValidator();
        $errors    = $validator->validate($data);

        if ($errors) {
            // Re-render the form with errors
            $service  = new AppointmentService();
            $doctors  = $service->getDoctorsForDropdown();
            $patients = $service->getPatientsForDropdown();
            $pageTitle = 'Book Appointment';

            ob_start();
            include BASE_PATH . '\app\Views\Appointments\create.php';
            $content = ob_get_clean();

            ob_start();
            include BASE_PATH . '\app\Views\layout.php';
            return ob_get_clean();
        }

        $service = new AppointmentService();

    
        $token = $service->getNextTokenNumber((int)$data['doctor_id'], $data['appointment_date']);


        $doctor = $service->getDoctorById((int)$data['doctor_id']);
        $data['token_number']    = $token;
        $data['consultation_fee']= $doctor['fees'] ?? 0;

        $appointment = new AppointmentModel($data);
        $service->create($appointment);


        header('Location: /appointment?success=1');
        exit;
    }

    /**
     * POST /delete/appointment
     * Cancel (soft-delete) a scheduled appointment.
     */
    public function destroy(array $data): string
    {
        $id      = (int)($data['appointment_id'] ?? 0);
        $service = new AppointmentService();
        $error   = $service->delete($id);

        if ($error) {
            header("Location: /appointment?error=" . urlencode($error));
        } else {
            header('Location: /appointment?deleted=1');
        }
        exit;
    }
}
