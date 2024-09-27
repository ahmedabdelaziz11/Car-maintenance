<?php ob_start(); ?>

<h1>Services</h1>
<a href="<?= BASE_URL . '/service/create'; ?>" class="btn btn-primary">Add Service</a>

<table class="table mt-4">
    <thead>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Image</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($services as $service): ?>
            <tr>
                <td><?= $service['id'] ?></td>
                <td><?= $service['name'] ?></td>
                <td><img src="<?= BASE_URL.'/uploads/services/' .$service['image'] ?>" alt="<?= $service['name'] ?>" width="100"></td>
                <td>
                    <a href="<?= BASE_URL . '/service/edit/' . $service['id'] ?>" class="btn btn-warning">Edit</a>
                    <form action="<?= BASE_URL . '/service/delete/' . $service['id'] ?>" method="POST" style="display:inline;">
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
