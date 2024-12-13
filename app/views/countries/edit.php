<?php ob_start(); ?>
<div class="container">

    <h1>تعديل بلد</h1>

    <form action="<?= BASE_URL . '/country/edit/' . $country['id'] ?>" method="POST" class="mt-4">
        <div class="form-group">
            <label for="name">Name</label>
            <input type="text" name="name" id="name" class="form-control" value="<?= $country['name'] ?>" required>
        </div>
        <button type="submit" class="btn btn-primary">Update</button>
    </form>
</div>

<?php
$content = ob_get_clean();
require_once(VIEW . 'layout/master-2.php');
?>