<?php ob_start(); ?>

<h1>Admins</h1>
<a href="<?= BASE_URL . '/admin/create'; ?>" class="btn btn-primary">Add Admin</a>

<table class="table mt-4">
    <thead>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>EMAIL</th>
            <th>ROLE</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($admins as $admin): ?>
            <tr>
                <td><?= $admin['id'] ?></td>
                <td><?= $admin['name'] ?></td>
                <td><?= $admin['email'] ?></td>
                <td><?= $admin['role'] == 1 ? "admin" : "supervisor" ?></td>
                <td>
                    <a href="<?= BASE_URL . '/admin/edit/' . $admin['id'] ?>" class="btn btn-warning">Edit</a>
                    <form action="<?= BASE_URL . '/admin/delete/' . $admin['id'] ?>" method="POST" style="display:inline;">
                        <button type="submit" class="btn btn-danger">Delete</button>
                    </form>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<?php 
$content = ob_get_clean(); 
require_once(VIEW . 'layout/master.php'); 
?>
