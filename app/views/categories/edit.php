<?php ob_start(); ?>
<div class="container">
    <h1>Edit Category</h1>

    <form action="<?= BASE_URL . '/category/edit/' . $category['id'] ?>" method="POST" enctype="multipart/form-data" class="mt-4">
        <div class="form-group">
            <label for="name">Name</label>
            <input type="text" name="name" id="name" class="form-control" value="<?= $category['name'] ?>" required>
        </div>
        <div class="form-group">
            <label for="car_type_id">car type</label>
            <select name="car_type_id" id="car_type_id" class="form-control" required>
                <option value="">car type</option>
                <?php foreach ($carTypes as $car_type): ?>
                    <option value="<?= $car_type['id'] ?>" <?= $category['car_type_id'] == $car_type['id'] ? 'selected' : '' ?>>
                        <?= $car_type['name'] ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Update</button>
    </form>
</div>
<?php 
$content = ob_get_clean(); 
require_once(VIEW . 'layout/master-2.php'); 
?>
