<?php
namespace app\Controllers;

use app\Services\PatientService;
use app\Models\PatientModel;
use app\Validators\PatientsValidator;

class PatientController
{
    public function index(): array
    {
        $service  = new PatientService();
        $patients = $service->getall();
        return [
            'view'   => 'Patients/index',
            'params' => ['patients' => $patients],
        ];
    }

    public function showCreate(): array
    {
        return ['view' => 'Patients/create', 'params' => []];
    }

    public function store(array $data): string
    {
        $validation = new PatientsValidator();
        $errors     = $validation->validate($data);

        if ($errors) {
            ob_start();
            include BASE_PATH . '\app\Views\Patients\create.php';
            $content = ob_get_clean();
            ob_start();
            include BASE_PATH . '\app\Views\layout.php';
            return ob_get_clean();
        }

        $patient = new PatientModel($data);
        $service = new PatientService();
        $service->create($patient);

        header('Location: /patient?success=1');
        exit;
    }
}