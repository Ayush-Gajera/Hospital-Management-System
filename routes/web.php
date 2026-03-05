<?php

use app\Controllers\DoctorController;
use app\Controllers\PatientController;
use app\Controllers\AppointmentController;
use app\Http\Request;
use app\Http\Router;

$router = new Router();


$router->get('/', function () {
    header('Location: /appointment');
    exit;
});

$router->get('/doctor', function () {
    return (new DoctorController)->index();
});

$router->get('/doctor/create', function () {
    return (new DoctorController)->showCreate();
});

$router->post('doctor/create', function (Request $request) {
    $body = $request->getBody();
    return (new DoctorController)->store($body);
});


$router->get('/patient', function () {
    return (new PatientController)->index();
});

$router->get('/patient/create', function () {
    return (new PatientController)->showCreate();
});

$router->post('patient/create', function (Request $request) {
    $body = $request->getBody();
    return (new PatientController)->store($body);
});


$router->get('/appointment', function () {
    return (new AppointmentController)->index();
});

$router->get('/appointment/create', function () {
    return (new AppointmentController)->create();
});

$router->post('/create/appointment', function (Request $request) {
    $body = $request->getBody();
    return (new AppointmentController)->store($body);
});

$router->post('/delete/appointment', function (Request $request) {
    $body = $request->getBody();
    return (new AppointmentController)->destroy($body);
});