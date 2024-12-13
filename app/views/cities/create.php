<?php ob_start(); ?>
<div class="container">
    <h1>Create city</h1>

    <form action="<?= BASE_URL . '/city/create'; ?>" method="POST" class="mt-4">
        <div class="form-group">
            <label for="name">Name</label>
            <input type="text" name="name" id="name" class="form-control">
        </div>
        <div class="form-group">
            <label for="country_id">country</label>
            <select name="country_id" id="country_id" class="form-control" required>
                <option value="">country</option>
                <?php foreach ($countries as $country): ?>
                    <option value="<?= $country['id'] ?>"><?= $country['name'] ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Create</button>
    </form>
</div>
<?php 
$content = ob_get_clean(); 
require_once(VIEW . 'layout/master-2.php'); 
?>
