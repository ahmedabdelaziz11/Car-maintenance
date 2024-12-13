<?php ob_start(); ?>
<div class="container">

    <h1>Create Service</h1>

    <form action="<?= BASE_URL . '/service/create'; ?>" method="POST" enctype="multipart/form-data" class="mt-4">
        <div class="form-group">
            <label for="name">Name</label>
            <input type="text" name="name" id="name" class="form-control">
        </div>
        <div class="form-group">
            <label for="image">Image</label>
            <input type="file" name="image" id="image" class="form-control">
        </div>
        <button type="submit" class="btn btn-primary">Create</button>
    </form>
</div>

<?php
$content = ob_get_clean();
require_once(VIEW . 'layout/master-2.php');
?>