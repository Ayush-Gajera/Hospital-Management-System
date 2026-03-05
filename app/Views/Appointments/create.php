<?php $pageTitle = 'Book Appointment'; ?>
<!-- Topbar -->
<div class="topbar">
    <div class="topbar-title">
        <h1> Book Appointment</h1>
        <p>Schedule a new patient appointment</p>
    </div>
    <div class="topbar-actions">
        <a href="/appointment" class="btn btn-outline">← Back to Appointments</a>
    </div>
</div>

<div class="page-content">
    <div class="breadcrumb">
        <a href="/appointment">Appointments</a>
        <span class="sep">›</span>
        <span>Book Appointment</span>
    </div>

    <?php if (!empty($errors)): ?>
        <div class="alert alert-danger">
            <div>
                <strong>⚠️ Booking failed — please fix the following:</strong>
                <ul style="margin-top:6px;padding-left:16px">
                    <?php foreach ($errors as $err): ?><li><?= htmlspecialchars($err) ?></li><?php endforeach; ?>
                </ul>
            </div>
        </div>
    <?php endif; ?>

    <div style="display:grid;grid-template-columns:1fr 320px;gap:24px;align-items:start">


        <div class="card">
            <div class="card-header">
                <h3>Appointment Details</h3>
            </div>
            <div class="card-body">
                <form action="/create/appointment" method="POST" id="appt-form" novalidate>
                    <div class="form-grid" style="margin-bottom:22px">
                        <p class="form-section-title">Select Patient &amp; Doctor</p>
                        <div class="form-group">
                            <label for="patient_id">Patient <span class="required">*</span></label>
                            <select id="patient_id" name="patient_id" required>
                                <option value="">-- Select Patient --</option>
                                <?php foreach ($patients as $pat): ?>
                                    <option value="<?= $pat['patient_id'] ?>"
                                        <?= (($_POST['patient_id'] ?? '') == $pat['patient_id']) ? 'selected' : '' ?>>
                                        <?= htmlspecialchars($pat['first_name'] . ' ' . $pat['last_name']) ?>
                                        &nbsp;(<?= htmlspecialchars($pat['phone']) ?>)
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="doctor_id">Doctor <span class="required">*</span></label>
                            <select id="doctor_id" name="doctor_id" required>
                                <option value="">-- Select Doctor --</option>
                                <?php foreach ($doctors as $doc): ?>
                                    <option value="<?= $doc['doctor_id'] ?>"
                                            data-days="<?= htmlspecialchars($doc['available_days']) ?>"
                                            data-time="<?= htmlspecialchars($doc['available_time']) ?>"
                                            data-fee="<?= $doc['fees'] ?>"
                                            data-spec="<?= htmlspecialchars($doc['specialization']) ?>"
                                        <?= (($_POST['doctor_id'] ?? '') == $doc['doctor_id']) ? 'selected' : '' ?>>
                                        Dr. <?= htmlspecialchars($doc['first_name'] . ' ' . $doc['last_name']) ?>
                                        — <?= htmlspecialchars($doc['specialization']) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>

                    <div class="form-grid" style="margin-bottom:22px">
                        <p class="form-section-title">Date &amp; Time</p>
                        <div class="form-group">
                            <label for="appointment_date">Appointment Date <span class="required">*</span></label>
                            <input type="date" id="appointment_date" name="appointment_date"
                                   min="<?= date('Y-m-d') ?>"
                                   value="<?= htmlspecialchars($_POST['appointment_date'] ?? '') ?>" required>
                        </div>
                        <div class="form-group">
                            <label for="appointment_time">Time Slot <span class="required">*</span></label>
                            <select id="appointment_time" name="appointment_time" required>
                                <option value="">-- Select a time --</option>
                                <option value="09:00" <?= (($_POST['appointment_time'] ?? '') === '09:00') ? 'selected' : '' ?>>09:00 AM</option>
                                <option value="09:30" <?= (($_POST['appointment_time'] ?? '') === '09:30') ? 'selected' : '' ?>>09:30 AM</option>
                                <option value="10:00" <?= (($_POST['appointment_time'] ?? '') === '10:00') ? 'selected' : '' ?>>10:00 AM</option>
                                <option value="10:30" <?= (($_POST['appointment_time'] ?? '') === '10:30') ? 'selected' : '' ?>>10:30 AM</option>
                                <option value="11:00" <?= (($_POST['appointment_time'] ?? '') === '11:00') ? 'selected' : '' ?>>11:00 AM</option>
                                <option value="11:30" <?= (($_POST['appointment_time'] ?? '') === '11:30') ? 'selected' : '' ?>>11:30 AM</option>
                                <option value="12:00" <?= (($_POST['appointment_time'] ?? '') === '12:00') ? 'selected' : '' ?>>12:00 PM</option>
                                <option value="12:30" <?= (($_POST['appointment_time'] ?? '') === '12:30') ? 'selected' : '' ?>>12:30 PM</option>
                                <option value="13:00" <?= (($_POST['appointment_time'] ?? '') === '13:00') ? 'selected' : '' ?>>01:00 PM</option>
                                <option value="13:30" <?= (($_POST['appointment_time'] ?? '') === '13:30') ? 'selected' : '' ?>>01:30 PM</option>
                                <option value="14:00" <?= (($_POST['appointment_time'] ?? '') === '14:00') ? 'selected' : '' ?>>02:00 PM</option>
                                <option value="14:30" <?= (($_POST['appointment_time'] ?? '') === '14:30') ? 'selected' : '' ?>>02:30 PM</option>
                                <option value="15:00" <?= (($_POST['appointment_time'] ?? '') === '15:00') ? 'selected' : '' ?>>03:00 PM</option>
                                <option value="15:30" <?= (($_POST['appointment_time'] ?? '') === '15:30') ? 'selected' : '' ?>>03:30 PM</option>
                                <option value="16:00" <?= (($_POST['appointment_time'] ?? '') === '16:00') ? 'selected' : '' ?>>04:00 PM</option>
                                <option value="16:30" <?= (($_POST['appointment_time'] ?? '') === '16:30') ? 'selected' : '' ?>>04:30 PM</option>
                                <option value="17:00" <?= (($_POST['appointment_time'] ?? '') === '17:00') ? 'selected' : '' ?>>05:00 PM</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-grid" style="margin-bottom:22px">
                        <p class="form-section-title">Visit Information</p>
                        <div class="form-group full-width">
                            <label for="reason_for_visit">Reason for Visit <span class="required">*</span></label>
                            <textarea id="reason_for_visit" name="reason_for_visit" required
                                      placeholder="Describe the patient's symptoms or reason for the visit..."><?= htmlspecialchars($_POST['reason_for_visit'] ?? '') ?></textarea>
                        </div>
                        <div class="form-group full-width">
                            <label for="notes">Additional Notes (optional)</label>
                            <textarea id="notes" name="notes"
                                      placeholder="Any extra notes for the doctor..."><?= htmlspecialchars($_POST['notes'] ?? '') ?></textarea>
                        </div>
                    </div>

                    <div style="display:flex;gap:12px">
                        <button type="submit" class="btn btn-primary">📋 Book Appointment</button>
                        <a href="/appointment" class="btn btn-outline">Cancel</a>
                    </div>
                </form>
            </div>
        </div>

        <!-- Side Info Panel -->
        <div>
            <!-- Doctor Info Card (populated by JS) -->
            <div class="card" id="doctor-info" style="display:none">
                <div class="card-header">
                    <h3>Doctor Info</h3>
                </div>
                <div class="card-body" style="padding:18px">
                    <div style="display:flex;align-items:center;gap:12px;margin-bottom:16px">
                        <div class="doctor-avatar" id="doc-avatar" style="width:50px;height:50px;font-size:18px;flex-shrink:0"></div>
                        <div>
                            <div style="font-weight:700" id="doc-name"></div>
                            <div style="font-size:13px;color:var(--text-secondary)" id="doc-spec"></div>
                        </div>
                    </div>
                    <div style="display:flex;flex-direction:column;gap:10px;font-size:13px">
                        <div style="display:flex;justify-content:space-between">
                            <span style="color:var(--text-secondary)">Available Days</span>
                            <span style="font-weight:600;text-align:right;max-width:160px" id="doc-days"></span>
                        </div>
                        <div style="display:flex;justify-content:space-between">
                            <span style="color:var(--text-secondary)">Hours</span>
                            <span style="font-weight:600" id="doc-hours"></span>
                        </div>
                        <div style="display:flex;justify-content:space-between">
                            <span style="color:var(--text-secondary)">Consultation Fee</span>
                            <span style="font-weight:700;color:var(--primary)" id="doc-fee"></span>
                        </div>
                    </div>
                </div>
            </div>

            
            <div class="card" style="margin-top:0">
                <div class="card-header"><h3>Booking Rules</h3></div>
                <div class="card-body" style="padding:16px;font-size:13px;color:var(--text-secondary)">
                    <ul style="padding-left:16px;line-height:1.9">
                        <li>One appointment per patient per doctor per day</li>
                        <li>Must book on doctor's available days</li>
                        <li>Slots are every <strong>30 minutes</strong></li>
                        <li>Cannot book on past dates</li>
                        <li>Token numbers start from 1 each day</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
// Show doctor info panel when a doctor is selected
const doctorsData = <?= json_encode(array_combine(
    array_column($doctors, 'doctor_id'),
    $doctors
), JSON_HEX_TAG) ?>;

const doctorSelect = document.getElementById('doctor_id');
const docInfoCard  = document.getElementById('doctor-info');

function updateDoctorInfo(doc) {
    if (!doc) { docInfoCard.style.display = 'none'; return; }
    docInfoCard.style.display = '';
    const parts = (doc.first_name + ' ' + doc.last_name).split(' ');
    document.getElementById('doc-avatar').textContent =
        (parts[0][0] + (parts[1] ? parts[1][0] : '')).toUpperCase();
    document.getElementById('doc-name').textContent  = 'Dr. ' + doc.first_name + ' ' + doc.last_name;
    document.getElementById('doc-spec').textContent  = doc.specialization;
    document.getElementById('doc-days').textContent  = doc.available_days;
    document.getElementById('doc-hours').textContent = doc.available_time;
    document.getElementById('doc-fee').textContent   = '\u20B9' + parseFloat(doc.fees).toFixed(2);
}

doctorSelect.addEventListener('change', function () {
    updateDoctorInfo(doctorsData[this.value] || null);
});

// On page load (e.g. POST re-render after errors)
if (doctorSelect.value) updateDoctorInfo(doctorsData[doctorSelect.value] || null);
</script>
