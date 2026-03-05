<?php

$currentPath = $_SERVER['REQUEST_URI'] ?? '/';
function isActive(string $prefix, string $current): string {
    return str_starts_with($current, $prefix) ? 'active' : '';
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($pageTitle ?? 'Hospital Management System') ?></title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/assets/css/style.css">
</head>
<body>

<aside class="sidebar">
    <div class="sidebar-logo">
        
        <div>
            <h2>Hospital Management</h2>
        </div>
    </div>
    <nav class="sidebar-nav">
        <p class="nav-section-title">Management</p>
        <a href="/doctor" class="nav-item <?= isActive('/doctor', $currentPath) ?>">
            <span class="nav-icon"></span> Doctors
        </a>
        <a href="/patient" class="nav-item <?= isActive('/patient', $currentPath) ?>">
            <span class="nav-icon"></span> Patients
        </a>
        <a href="/appointment" class="nav-item <?= isActive('/appointment', $currentPath) ?>">
            <span class="nav-icon"></span> Appointments
        </a>
   
</aside>

<div class="main-content">
    <?= $content ?? '' ?>
</div>

</body>
</html>
