<?php ob_start(); ?>

<h1>Create Service</h1>

<form action="/cars/public/service/create" method="POST" enctype="multipart/form-data" class="mt-4">
    <div class="form-group">
        <label for="name">Name</label>
        <input type="text" name="name" id="name" class="form-control" required>
    </div>
    <div class="form-group">
        <label for="image">Image</label>
        <input type="file" name="image" id="image" class="form-control" required>
    </div>
    <button type="submit" class="btn btn-primary">Create</button>
</form>

<?php 
$content = ob_get_clean(); 
require_once(VIEW . 'layout/master.php'); 
?>
