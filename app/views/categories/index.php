<?php ob_start(); ?>

<h1>Categories</h1>
<a href="<?= BASE_URL . '/category/create'; ?>" class="btn btn-primary">Add Category</a>

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
        <?php foreach ($categories as $category): ?>
            <tr>
                <td><?= $category['id'] ?></td>
                <td><?= $category['name'] ?></td>
                <td><img src="<?= BASE_URL.'/uploads/Categories/' .$category['image'] ?>" alt="<?= $category['name'] ?>" width="100"></td>
                <td>
                    <a href="<?= BASE_URL . '/category/edit/' . $category['id'] ?>" class="btn btn-warning">Edit</a>
                    <form action="<?= BASE_URL . '/category/delete/' . $category['id'] ?>" method="POST" style="display:inline;">
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
