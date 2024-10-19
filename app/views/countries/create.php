<?php ob_start(); ?>

<h1>انشاء بلد</h1>

<form action="<?= BASE_URL . '/country/create'; ?>" method="POST" enctype="multipart/form-data" class="mt-4">
    <div class="form-group">
        <label for="name">Name</label>
        <input type="text" name="name" id="name" class="form-control">
    </div>
    <button type="submit" class="btn btn-primary">Create</button>
</form>

<?php 
$content = ob_get_clean(); 
require_once(VIEW . 'layout/master.php'); 
?>
