<?php ob_start(); ?>
<div class="container">
    <h1>Edit Admin</h1>

    <form action="<?= BASE_URL . '/admin/edit/' . $admin['id'] ?>" method="POST" class="mt-4">

        <div class="form-group">
            <label for="name">Name</label>
            <input type="text" name="name" id="name" value="<?= $admin['name'] ?>" class="form-control">
        </div>

        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" name="email" id="email" value="<?= $admin['email'] ?>" class="form-control">
        </div>

        <div class="form-group">
            <label for="email">Phone</label>
            <input type="text" name="phone" id="phone" value="<?= $admin['phone'] ?>" class="form-control">
        </div>

        <div class="form-group">
            <label for="password">Password</label>
            <input type="password" name="password" id="password" class="form-control">
        </div>

        <div class="form-group">
            <label for="role">Role</label>
            <select name="role" id="role">
                <option value="" disabled>اخنر دور المسؤول</option>
                <option value="1" <?= $admin['role'] == 1 ? 'selected' : '' ?>>Super Admin</option>
                <option value="2" <?= $admin['role'] == 2 ? 'selected' : '' ?>>Supervisor</option>
            </select>
        </div>
        <div class="form-group">
            <label for="role">Allowed Contact Types</label>
            <br>
            <label>
                <input type="checkbox" name="contact_types[]" value="Complaint" <?= in_array('Complaint', $assignedTypes) ? 'checked' : '' ?>> Complaint
            </label><br>
            <label>
                <input type="checkbox" name="contact_types[]" value="Suggestion" <?= in_array('Suggestion', $assignedTypes) ? 'checked' : '' ?>> Suggestion
            </label><br>
            <label>
                <input type="checkbox" name="contact_types[]" value="Inquiry" <?= in_array('Inquiry', $assignedTypes) ? 'checked' : '' ?>> Inquiry
            </label><br>
        </div>
        <button type="submit" class="btn btn-primary">Update</button>
    </form>
</div>
<?php 
$content = ob_get_clean(); 
require_once(VIEW . 'layout/master-2.php'); 
?>
