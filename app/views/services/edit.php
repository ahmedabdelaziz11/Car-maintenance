<?php ob_start(); ?>
<div class="container">

    <h1>Edit Service</h1>

    <form action="<?= BASE_URL . '/service/edit/' . $service['id'] ?>" method="POST" enctype="multipart/form-data" class="mt-4">
        <div class="form-group">
            <label for="name">Name</label>
            <input type="text" name="name" id="name" class="form-control" value="<?= $service['name'] ?>" required>
        </div>
        <div class="form-group">
            <label for="image">Image</label>
            <input type="file" name="image" id="image" class="form-control">
            <img src="path/to/upload/directory/<?= $service['image'] ?>" alt="<?= $service['name'] ?>" width="100" class="mt-2">
        </div>
        <button type="submit" class="btn btn-primary">Update</button>
    </form>
</div>

<?php
$content = ob_get_clean();
require_once(VIEW . 'layout/master-2.php');
?>