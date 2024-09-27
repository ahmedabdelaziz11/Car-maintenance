<?php ob_start(); ?>

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
    <button type="submit" class="btn btn-primary">Update</button>
</form>

<?php 
$content = ob_get_clean(); 
require_once(VIEW . 'layout/master.php'); 
?>
