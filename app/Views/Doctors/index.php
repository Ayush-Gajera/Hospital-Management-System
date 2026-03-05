<?php $pageTitle = 'Doctors'; ?>
<!-- Topbar -->
<div class="topbar">
    <div class="topbar-title">
        <h1>👨‍⚕️ Doctors</h1>
        <p>Manage all registered doctors</p>
    </div>
    <div class="topbar-actions">
        <span class="topbar-date"><?= date('D, d M Y') ?></span>
        <a href="/doctor/create" class="btn btn-primary">+ Add Doctor</a>
    </div>
</div>

<div class="page-content">
    <?php if (isset($_GET['success'])): ?>
        <div class="alert alert-success"> Doctor has been added successfully.</div>
    <?php endif; ?>

    <div class="card">
        <div class="card-header">
            <div>
                <h3>All Doctors</h3>
                <p><?= count($doctors) ?> doctor<?= count($doctors) !== 1 ? 's' : '' ?> registered</p>
            </div>
        </div>
        <div class="table-wrapper">
            <?php if (empty($doctors)): ?>
                <div class="empty-state">
                    <div class="empty-icon">👨‍⚕️</div>
                    <h4>No Doctors Yet</h4>
                    <p>Click "Add Doctor" to register the first doctor.</p>
                </div>
            <?php else: ?>
            <table>
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Doctor</th>
                        <th>Specialization</th>
                        <th>Qualification</th>
                        <th>Exp.</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Fees</th>
                        <th>Room</th>
                        <th>Available Days</th>
                        <th>Hours</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                <?php foreach ($doctors as $i => $doc): ?>
                    <tr>
                        <td style="color:var(--text-secondary);font-size:12px"><?= $i + 1 ?></td>
                        <td>
                            <div style="display:flex;align-items:center;gap:10px">
                                <div class="doctor-avatar">
                                    <?= strtoupper(substr($doc['first_name'],0,1) . substr($doc['last_name'],0,1)) ?>
                                </div>
                                <div>
                                    <div style="font-weight:600">Dr. <?= htmlspecialchars($doc['first_name'] . ' ' . $doc['last_name']) ?></div>
                                    <div style="font-size:11px;color:var(--text-secondary)">ID: <?= $doc['doctor_id'] ?></div>
                                </div>
                            </div>
                        </td>
                        <td><?= htmlspecialchars($doc['specialization']) ?></td>
                        <td><?= htmlspecialchars($doc['qualification']) ?></td>
                        <td><?= htmlspecialchars($doc['experience']) ?> yr<?= $doc['experience'] != 1 ? 's' : '' ?></td>
                        <td style="font-size:13px"><?= htmlspecialchars($doc['email']) ?></td>
                        <td><?= htmlspecialchars($doc['phone']) ?></td>
                        <td style="font-weight:600;color:var(--primary)">₹<?= number_format($doc['fees'], 2) ?></td>
                        <td><?= htmlspecialchars($doc['room'] ?? '—') ?></td>
                        <td style="font-size:12px;max-width:140px"><?= htmlspecialchars($doc['available_days']) ?></td>
                        <td style="font-size:12px"><?= htmlspecialchars($doc['available_time']) ?></td>
                        <td>
                            <?php
                            $badgeClass = match($doc['status']) {
                                'Active'   => 'badge-success',
                                'On Leave' => 'badge-warning',
                                'Inactive' => 'badge-danger',
                                default    => 'badge-secondary',
                            };
                            ?>
                            <span class="badge <?= $badgeClass ?>"><?= htmlspecialchars($doc['status']) ?></span>
                        </td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
            <div class="table-info">Showing <?= count($doctors) ?> record<?= count($doctors) !== 1 ? 's' : '' ?>.</div>
            <?php endif; ?>
        </div>
    </div>
</div>