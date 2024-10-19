<?php ob_start(); ?>

<h1>Edit City</h1>

<form action="<?= BASE_URL . '/city/edit/' . $city['id'] ?>" method="POST" class="mt-4">
    <div class="form-group">
        <label for="name">Name</label>
        <input type="text" name="name" id="name" class="form-control" value="<?= $city['name'] ?>" required>
    </div>
    <div class="form-group">
        <label for="country_id">country</label>
        <select name="country_id" id="country_id" class="form-control" required>
            <option value="">country</option>
            <?php foreach ($countries as $country): ?>
                <option value="<?= $country['id'] ?>" <?= $city['country_id'] == $country['id'] ? 'selected' : '' ?>>
                    <?= $country['name'] ?>
                </option>
            <?php endforeach; ?>
        </select>
    </div>
    <button type="submit" class="btn btn-primary">Update</button>
</form>

<?php 
$content = ob_get_clean(); 
require_once(VIEW . 'layout/master.php'); 
?>
