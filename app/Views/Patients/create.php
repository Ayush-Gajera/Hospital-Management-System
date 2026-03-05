<?php $pageTitle = 'Register Patient'; ?>
<!-- Topbar -->
<div class="topbar">
    <div class="topbar-title">
        <h1>Register New Patient</h1>
        <p>Add a new patient to the system</p>
    </div>
    <div class="topbar-actions">
        <a href="/patient" class="btn btn-outline">← Back to Patients</a>
    </div>
</div>

<div class="page-content">
    <div class="breadcrumb">
        <a href="/patient">Patients</a>
        <span class="sep">›</span>
        <span>Register Patient</span>
    </div>

    <?php if (!empty($errors)): ?>
        <div class="alert alert-danger">
            <div>
                <strong> Please fix the following errors:</strong>
                <ul style="margin-top:6px;padding-left:16px">
                    <?php foreach ($errors as $err): ?><li><?= htmlspecialchars($err) ?></li><?php endforeach; ?>
                </ul>
            </div>
        </div>
    <?php endif; ?>

    <div class="card">
        <div class="card-header">
            <h3>Patient Information</h3>
        </div>
        <div class="card-body">
            <form action="patient/create" method="POST" novalidate>

                <div class="form-grid" style="margin-bottom:24px">
                    <p class="form-section-title">Personal Information</p>
                    <div class="form-group">
                        <label for="first_name">First Name <span class="required">*</span></label>
                        <input type="text" id="first_name" name="first_name" placeholder="e.g. Ravi"
                               value="<?= htmlspecialchars($_POST['first_name'] ?? '') ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="last_name">Last Name <span class="required">*</span></label>
                        <input type="text" id="last_name" name="last_name" placeholder="e.g. Sharma"
                               value="<?= htmlspecialchars($_POST['last_name'] ?? '') ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="date_of_birth">Date of Birth <span class="required">*</span></label>
                        <input type="date" id="date_of_birth" name="date_of_birth"
                               value="<?= htmlspecialchars($_POST['date_of_birth'] ?? '') ?>"
                               max="<?= date('Y-m-d') ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="age">Age <span class="required">*</span></label>
                        <input type="number" id="age" name="age" min="0" max="150" placeholder="25"
                               value="<?= htmlspecialchars($_POST['age'] ?? '') ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="gender">Gender</label>
                        <select id="gender" name="gender">
                            <option value="">-- Select Gender --</option>
                            <?php foreach (['Male','Female','Other'] as $g): ?>
                                <option value="<?= $g ?>" <?= (($_POST['gender'] ?? '') === $g) ? 'selected' : '' ?>>
                                    <?= $g ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="blood_group">Blood Group <span class="required">*</span></label>
                        <select id="blood_group" name="blood_group" required>
                            <option value="">-- Select Blood Group --</option>
                            <?php foreach (['A+','A-','B+','B-','O+','O-','AB+','AB-'] as $bg): ?>
                                <option value="<?= $bg ?>" <?= (($_POST['blood_group'] ?? '') === $bg) ? 'selected' : '' ?>>
                                    <?= $bg ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
                <div class="form-grid" style="margin-bottom:24px">
                    <p class="form-section-title">Contact Information</p>
                    <div class="form-group">
                        <label for="email">Email Address</label>
                        <input type="email" id="email" name="email" placeholder="patient@email.com"
                               value="<?= htmlspecialchars($_POST['email'] ?? '') ?>">
                    </div>
                    <div class="form-group">
                        <label for="phone">Phone Number <span class="required">*</span></label>
                        <input type="tel" id="phone" name="phone" placeholder="+91 98765 43210"
                               value="<?= htmlspecialchars($_POST['phone'] ?? '') ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="city">City <span class="required">*</span></label>
                        <input type="text" id="city" name="city" placeholder="e.g. Mumbai"
                               value="<?= htmlspecialchars($_POST['city'] ?? '') ?>" required>
                    </div>
                    <div class="form-group full-width">
                        <label for="address">Address <span class="required">*</span></label>
                        <textarea id="address" name="address" placeholder="Full address..." required><?= htmlspecialchars($_POST['address'] ?? '') ?></textarea>
                    </div>
                </div>

              
                <div class="form-grid" style="margin-bottom:24px">
                    <p class="form-section-title">Emergency Contact</p>
                    <div class="form-group">
                        <label for="emergency_contact">Contact Name <span class="required">*</span></label>
                        <input type="text" id="emergency_contact" name="emergency_contact" placeholder="e.g. Meena Sharma"
                               value="<?= htmlspecialchars($_POST['emergency_contact'] ?? '') ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="emergency_phone">Contact Phone <span class="required">*</span></label>
                        <input type="tel" id="emergency_phone" name="emergency_phone" placeholder="+91 98765 11111"
                               value="<?= htmlspecialchars($_POST['emergency_phone'] ?? '') ?>" required>
                    </div>
                </div>

             
                <div class="form-grid" style="margin-bottom:24px">
                    <p class="form-section-title">Medical History</p>
                    <div class="form-group full-width">
                        <label for="medical_history">Medical History (optional)</label>
                        <textarea id="medical_history" name="medical_history" style="min-height:100px"
                                  placeholder="Previous conditions, surgeries, allergies..."><?= htmlspecialchars($_POST['medical_history'] ?? '') ?></textarea>
                    </div>
                    <input type="hidden" name="status" value="Active">
                </div>

                <div style="display:flex;gap:12px;margin-top:8px">
                    <button type="submit" class="btn btn-primary">💾 Register Patient</button>
                    <a href="/patient" class="btn btn-outline">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</div>

<script>

document.getElementById('date_of_birth').addEventListener('change', function() {
    const dob = new Date(this.value);
    const today = new Date();
    let age = today.getFullYear() - dob.getFullYear();
    const m = today.getMonth() - dob.getMonth();
    if (m < 0 || (m === 0 && today.getDate() < dob.getDate())) age--;
    if (age >= 0) document.getElementById('age').value = age;
});
</script>
