<?php $pageTitle = 'Appointments'; ?>
<div class="topbar">
    <div class="topbar-title">
        <h1> Appointments</h1>
        <p>Manage all patient appointments</p>
    </div>
    <div class="topbar-actions">
        <span class="topbar-date"><?= date('D, d M Y') ?></span>
        <a href="/appointment/create" class="btn btn-primary">+ Book Appointment</a>
    </div>
</div>

<div class="page-content">
    <?php if (isset($_GET['success'])): ?>
        <div class="alert alert-success"> Appointment booked successfully.</div>
    <?php endif; ?>
    <?php if (isset($_GET['deleted'])): ?>
        <div class="alert alert-success"> Appointment has been cancelled.</div>
    <?php endif; ?>
    <?php if (isset($_GET['error'])): ?>
        <div class="alert alert-danger">⚠️ <?= htmlspecialchars($_GET['error']) ?></div>
    <?php endif; ?>

    <div class="card">
        <div class="card-header">
            <div>
                <h3>All Appointments</h3>
                <p><?= count($appointments) ?> appointment<?= count($appointments) !== 1 ? 's' : '' ?> found</p>
            </div>
        </div>
        <div class="table-wrapper">
            <?php if (empty($appointments)): ?>
                <div class="empty-state">
                    <div class="empty-icon">📅</div>
                    <h4>No Appointments Yet</h4>
                    <p>Click "Book Appointment" to create the first appointment.</p>
                </div>
            <?php else: ?>
            <table>
                <thead>
                    <tr>
                        <th>Code</th>
                        <th>Patient</th>
                        <th>Doctor</th>
                        <th>Specialization</th>
                        <th>Date</th>
                        <th>Time</th>
                        <th>Token</th>
                        <th>Fee</th>
                        <th>Status</th>
                        <th>Payment</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                <?php foreach ($appointments as $appt): ?>
                    <tr>
                        <td>
                            <span style="font-family:monospace;font-size:12px;background:#f0f2f5;padding:2px 7px;border-radius:4px">
                                <?= htmlspecialchars($appt['appointment_code']) ?>
                            </span>
                        </td>
                        <td>
                            <div style="font-weight:600"><?= htmlspecialchars($appt['patient_name']) ?></div>
                        </td>
                        <td>
                            <div style="display:flex;align-items:center;gap:8px">
                                <div class="doctor-avatar" style="width:28px;height:28px;font-size:11px">
                                    <?php
                                    $nameParts = explode(' ', $appt['doctor_name']);
                                    echo strtoupper(substr($nameParts[0],0,1) . (isset($nameParts[1]) ? substr($nameParts[1],0,1) : ''));
                                    ?>
                                </div>
                                Dr. <?= htmlspecialchars($appt['doctor_name']) ?>
                            </div>
                        </td>
                        <td style="font-size:12px;color:var(--text-secondary)"><?= htmlspecialchars($appt['specialization']) ?></td>
                        <td style="font-weight:500"><?= htmlspecialchars(date('d M Y', strtotime($appt['appointment_date']))) ?></td>
                        <td><?= htmlspecialchars(date('h:i A', strtotime($appt['appointment_time']))) ?></td>
                        <td><span class="token"><?= (int)$appt['token_number'] ?></span></td>
                        <td style="font-weight:600;color:var(--primary)">₹<?= number_format($appt['consultation_fee'], 2) ?></td>
                        <td>
                            <?php
                            $sClass = match($appt['status']) {
                                'Scheduled'  => 'badge-info',
                                'Completed'  => 'badge-success',
                                'Cancelled'  => 'badge-danger',
                                'No Show'    => 'badge-warning',
                                default      => 'badge-secondary',
                            };
                            ?>
                            <span class="badge <?= $sClass ?>"><?= htmlspecialchars($appt['status']) ?></span>
                        </td>
                        <td>
                            <span class="badge <?= $appt['payment_status'] === 'Paid' ? 'badge-success' : 'badge-warning' ?>">
                                <?= htmlspecialchars($appt['payment_status']) ?>
                            </span>
                        </td>
                        <td>
                            <?php if ($appt['status'] === 'Scheduled'): ?>
                            <form action="/delete/appointment" method="POST"
                                  onsubmit="return confirm('Cancel appointment <?= htmlspecialchars($appt['appointment_code']) ?>?')">
                                <input type="hidden" name="appointment_id" value="<?= $appt['appointment_id'] ?>">
                                <button type="submit" class="btn btn-sm btn-danger">Cancel</button>
                            </form>
                            <?php else: ?>
                                <span style="color:var(--text-secondary);font-size:12px">—</span>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
            <div class="table-info">Showing <?= count($appointments) ?> record<?= count($appointments) !== 1 ? 's' : '' ?>.</div>
            <?php endif; ?>
        </div>
    </div>
</div>
