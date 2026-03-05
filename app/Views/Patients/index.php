<?php $pageTitle = 'Patients'; ?>
<div class="topbar">
    <div class="topbar-title">
        <h1> Patients</h1>
        <p>Manage all registered patients</p>
    </div>
    <div class="topbar-actions">
        <span class="topbar-date"><?= date('D, d M Y') ?></span>
        <a href="/patient/create" class="btn btn-primary">+ Add Patient</a>
    </div>
</div>

<div class="page-content">
    <?php if (isset($_GET['success'])): ?>
        <div class="alert alert-success"> Patient has been registered successfully.</div>
    <?php endif; ?>

    <div class="card">
        <div class="card-header">
            <div>
                <h3>All Patients</h3>
                <p><?= count($patients) ?> patient<?= count($patients) !== 1 ? 's' : '' ?> registered</p>
            </div>
        </div>
        <div class="table-wrapper">
            <?php if (empty($patients)): ?>
                <div class="empty-state">
                    <div class="empty-icon"></div>
                    <h4>No Patients Yet</h4>
                    <p>Click "Add Patient" to register the first patient.</p>
                </div>
            <?php else: ?>
            <table>
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Patient</th>
                        <th>DOB</th>
                        <th>Age</th>
                        <th>Gender</th>
                        <th>Blood Group</th>
                        <th>Phone</th>
                        <th>City</th>
                        <th>Emergency Contact</th>
                        <th>Emergency Phone</th>
                        <th>Registered</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                <?php foreach ($patients as $i => $p): ?>
                    <tr>
                        <td style="color:var(--text-secondary);font-size:12px"><?= $i + 1 ?></td>
                        <td>
                            <div style="display:flex;align-items:center;gap:10px">
                                <div class="doctor-avatar" style="background:#e8f2fc;color:#333">
                                    <?= strtoupper(substr($p['first_name'],0,1) . substr($p['last_name'],0,1)) ?>
                                </div>
                                <div>
                                    <div style="font-weight:600"><?= htmlspecialchars($p['first_name'] . ' ' . $p['last_name']) ?></div>
                                    <div style="font-size:11px;color:var(--text-secondary)">ID: <?= $p['patient_id'] ?></div>
                                </div>
                            </div>
                        </td>
                        <td style="font-size:13px"><?= htmlspecialchars($p['date_of_birth'] ?? '—') ?></td>
                        <td><?= htmlspecialchars($p['age'] ?? '—') ?></td>
                        <td>
                            <?php
                            $genderIcon = match($p['gender'] ?? '') {
                                'Male'   => '',
                                'Female' => '',
                                default  => '',
                            };
                            echo $genderIcon . ' ' . htmlspecialchars($p['gender'] ?? '—');
                            ?>
                        </td>
                        <td>
                            <span class="badge badge-info"><?= htmlspecialchars($p['blood_group'] ?? '—') ?></span>
                        </td>
                        <td><?= htmlspecialchars($p['phone']) ?></td>
                        <td><?= htmlspecialchars($p['city']) ?></td>
                        <td style="font-size:13px"><?= htmlspecialchars($p['emergency_contact']) ?></td>
                        <td style="font-size:13px"><?= htmlspecialchars($p['emergency_phone']) ?></td>
                        <td style="font-size:12px;color:var(--text-secondary)"><?= htmlspecialchars($p['registration_date'] ?? '—') ?></td>
                        <td>
                            <span class="badge <?= $p['status'] === 'Active' ? 'badge-success' : 'badge-danger' ?>">
                                <?= htmlspecialchars($p['status']) ?>
                            </span>
                        </td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
            <div class="table-info">Showing <?= count($patients) ?> record<?= count($patients) !== 1 ? 's' : '' ?>.</div>
            <?php endif; ?>
        </div>
    </div>
</div>