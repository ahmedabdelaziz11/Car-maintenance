<?php ob_start(); ?>

<h1>Create Admin</h1>

<form action="<?= BASE_URL . '/admin/create'; ?>" method="POST" class="mt-4">
    <div class="form-group">
        <label for="name">Name</label>
        <input type="text" name="name" id="name" class="form-control">
    </div>

    <div class="form-group">
        <label for="email">Email</label>
        <input type="email" name="email" id="email" class="form-control">
    </div>

    <div class="form-group">
        <label for="password">Password</label>
        <input type="password" name="password" id="password" class="form-control">
    </div>

    <div class="form-group">
        <label for="role">Role</label>
        <select name="role" id="role" class="form-control">
            <option value="" disabled>اخنر دور المسؤول</option>
            <option value="1">Super Admin</option>
            <option value="2">Supervisor</option>
        </select>
    </div>

    <button type="submit" class="btn btn-primary">Create</button>
</form>

<?php 
$content = ob_get_clean(); 
require_once(VIEW . 'layout/master.php'); 
?>
