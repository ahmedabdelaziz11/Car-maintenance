<?php ob_start(); ?>

<h1>انواع السيارات</h1>
<a href="<?= BASE_URL . '/carType/create'; ?>" class="btn btn-primary">انشاء نوع سيارة</a>

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
        <?php foreach ($carTypes as $carType): ?>
            <tr>
                <td><?= $carType['id'] ?></td>
                <td><?= $carType['name'] ?></td>
                <td><img src="<?= BASE_URL.'/uploads/car_types/' .$carType['image'] ?>" alt="<?= $carType['name'] ?>" width="100"></td>
                <td>
                    <a href="<?= BASE_URL . '/carType/edit/' . $carType['id'] ?>" class="btn btn-warning">Edit</a>
                    <form action="<?= BASE_URL . '/carType/delete/' . $carType['id'] ?>" method="POST" style="display:inline;">
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
