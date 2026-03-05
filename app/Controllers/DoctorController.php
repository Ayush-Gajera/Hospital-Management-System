<?php
namespace app\Controllers;

use app\Models\DoctorModel;
use app\Services\DoctorService;
use app\Validators\DoctorValidator;

class DoctorController
{
    public function index(): array
    {
        $service = new DoctorService();
        $doctors = $service->getAll();
        return [
            'view'   => 'Doctors/index',
            'params' => ['doctors' => $doctors],
        ];
    }

    public function showCreate(): array
    {
        return ['view' => 'Doctors/create', 'params' => []];
    }

    public function store(array $data): string
    {
        $validator = new DoctorValidator();
        $errors    = $validator->validate($data);

        if ($errors) {
            ob_start();
            include BASE_PATH . '\app\Views\Doctors\create.php';
            $content = ob_get_clean();
            ob_start();
            include BASE_PATH . '\app\Views\layout.php';
            return ob_get_clean();
        }

        $doctor  = new DoctorModel($data);
        $service = new DoctorService();
        $service->create($doctor);

        header('Location: /doctor?success=1');
        exit;
    }
}