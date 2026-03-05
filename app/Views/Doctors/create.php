<?php $pageTitle = 'Add New Doctor'; ?>
<!-- Topbar -->
<div class="topbar">
    <div class="topbar-title">
        <h1> Add New Doctor</h1>
        <p>Register a new doctor in the system</p>
    </div>
    <div class="topbar-actions">
        <a href="/doctor" class="btn btn-outline">← Back to Doctors</a>
    </div>
</div>

<div class="page-content">
    <div class="breadcrumb">
        <a href="/doctor">Doctors</a>
        <span class="sep">›</span>
        <span>Add New Doctor</span>
    </div>

    <?php if (!empty($errors)): ?>
        <div class="alert alert-danger">
            <div>
                <strong>⚠️ Please fix the following errors:</strong>
                <ul style="margin-top:6px;padding-left:16px">
                    <?php foreach ($errors as $err): ?><li><?= htmlspecialchars($err) ?></li><?php endforeach; ?>
                </ul>
            </div>
        </div>
    <?php endif; ?>

    <div class="card">
        <div class="card-header">
            <h3>Doctor Information</h3>
        </div>
        <div class="card-body">
            <form action="doctor/create" method="POST" novalidate>

                <!-- Personal Info -->
                <div class="form-grid" style="margin-bottom:24px">
                    <p class="form-section-title">Personal Information</p>
                    <div class="form-group">
                        <label for="first_name">First Name <span class="required">*</span></label>
                        <input type="text" id="first_name" name="first_name" placeholder="e.g. John"
                               value="<?= htmlspecialchars($_POST['first_name'] ?? '') ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="last_name">Last Name <span class="required">*</span></label>
                        <input type="text" id="last_name" name="last_name" placeholder="e.g. Doe"
                               value="<?= htmlspecialchars($_POST['last_name'] ?? '') ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="email">Email Address</label>
                        <input type="email" id="email" name="email" placeholder="doctor@hospital.com"
                               value="<?= htmlspecialchars($_POST['email'] ?? '') ?>">
                    </div>
                    <div class="form-group">
                        <label for="phone">Phone Number <span class="required">*</span></label>
                        <input type="tel" id="phone" name="phone" placeholder="+91 98765 43210"
                               value="<?= htmlspecialchars($_POST['phone'] ?? '') ?>" required>
                    </div>
                </div>

                <!-- Professional Info -->
                <div class="form-grid" style="margin-bottom:24px">
                    <p class="form-section-title">Professional Details</p>
                    <div class="form-group">
                        <label for="specialization">Specialization <span class="required">*</span></label>
                        <input type="text" id="specialization" name="specialization" placeholder="e.g. Cardiology"
                               value="<?= htmlspecialchars($_POST['specialization'] ?? '') ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="qualification">Qualification <span class="required">*</span></label>
                        <input type="text" id="qualification" name="qualification" placeholder="e.g. MBBS, MD"
                               value="<?= htmlspecialchars($_POST['qualification'] ?? '') ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="experience">Years of Experience <span class="required">*</span></label>
                        <input type="number" id="experience" name="experience" min="0" max="60" placeholder="10"
                               value="<?= htmlspecialchars($_POST['experience'] ?? '') ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="fees">Consultation Fees (₹) <span class="required">*</span></label>
                        <input type="number" id="fees" name="fees" min="0" step="0.01" placeholder="500.00"
                               value="<?= htmlspecialchars($_POST['fees'] ?? '') ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="room">Room / Cabin No.</label>
                        <input type="text" id="room" name="room" placeholder="e.g. 204"
                               value="<?= htmlspecialchars($_POST['room'] ?? '') ?>">
                    </div>
                </div>

                <!-- Availability -->
                <div class="form-grid" style="margin-bottom:24px">
                    <p class="form-section-title">Availability Schedule</p>
                    <div class="form-group full-width">
                        <label>Available Days <span class="required">*</span></label>
                        <div class="checkbox-group" id="days-group">
                            <?php
                            $days        = ['Monday','Tuesday','Wednesday','Thursday','Friday','Saturday','Sunday'];
                            $selectedDays = isset($_POST['available_days_arr'])
                                ? (array)$_POST['available_days_arr']
                                : [];
                            foreach ($days as $day): ?>
                            <div class="checkbox-chip">
                                <input type="checkbox" id="day-<?= $day ?>" name="available_days_arr[]"
                                       value="<?= $day ?>"
                                       <?= in_array($day, $selectedDays) ? 'checked' : '' ?>>
                                <label for="day-<?= $day ?>"><?= $day ?></label>
                            </div>
                            <?php endforeach; ?>
                        </div>
                        <!-- Hidden field built by JS -->
                        <input type="hidden" id="available_days" name="available_days" value="">
                    </div>
                    <div class="form-group">
                        <label for="time_start">Available From <span class="required">*</span></label>
                        <input type="time" id="time_start" name="time_start"
                               value="<?= htmlspecialchars($_POST['time_start'] ?? '09:00') ?>">
                    </div>
                    <div class="form-group">
                        <label for="time_end">Available Until <span class="required">*</span></label>
                        <input type="time" id="time_end" name="time_end"
                               value="<?= htmlspecialchars($_POST['time_end'] ?? '17:00') ?>">
                    </div>
                    <input type="hidden" id="available_time" name="available_time" value="">
                </div>

                <div style="display:flex;gap:12px;margin-top:8px">
                    <button type="submit" class="btn btn-primary" id="submit-btn"> Save Doctor</button>
                    <a href="/doctor" class="btn btn-outline">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
// Build comma-separated available_days from checkboxes before submit
document.getElementById('submit-btn').closest('form').addEventListener('submit', function() {
    const checked = [...document.querySelectorAll('input[name="available_days_arr[]"]:checked')]
        .map(cb => cb.value);
    document.getElementById('available_days').value = checked.join(',');

    const start = document.getElementById('time_start').value;
    const end   = document.getElementById('time_end').value;
    document.getElementById('available_time').value = start + '-' + end;
});
</script>
