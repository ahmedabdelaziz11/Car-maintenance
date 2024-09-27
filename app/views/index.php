<!-- register.php -->
<?php ob_start(); ?>

<!-- Search Form -->
<form method="GET" action="<?= BASE_URL . '/home/index' ?>">
    <div class="form-row">
        <div class="form-group col-md-3">
            <label for="service_id">Service</label>
            <select class="form-control" id="service_id" name="service_id">
                <option value="">Select Service</option>
                <?php foreach ($services as $service): ?>
                    <option value="<?= $service['id']; ?>" <?= isset($_GET['service_id']) && $_GET['service_id'] == $service['id'] ? 'selected' : '' ?>>
                        <?= $service['name']; ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="form-group col-md-3">
            <label for="category_id">Category</label>
            <select class="form-control" id="category_id" name="category_id">
                <option value="">Select Category</option>
                <?php foreach ($categories as $category): ?>
                    <option value="<?= $category['id']; ?>" <?= isset($_GET['category_id']) && $_GET['category_id'] == $category['id'] ? 'selected' : '' ?>>
                        <?= $category['name']; ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="form-group col-md-3">
            <label for="model_from">Model From</label>
            <input type="text" class="form-control" id="model_from" name="model_from" placeholder="Model From" value="<?= $_GET['model_from'] ?? '' ?>">
        </div>

        <div class="form-group col-md-3">
            <label for="model_to">Model To</label>
            <input type="text" class="form-control" id="model_to" name="model_to" placeholder="Model To" value="<?= $_GET['model_to'] ?? '' ?>">
        </div>
    </div>
    <button type="submit" class="btn btn-primary">Search</button>
</form>


<!-- Display Offers in Cards -->
<div class="row mt-4">
    <?php foreach ($offers as $offer): ?>
        <div class="col-md-4">
            <div class="card mb-4">
                <img src="<?= BASE_URL . '/uploads/offers/' . $offer['image'] ?>" class="card-img-top" alt="<?= $offer['title'] ?>">
                <div class="card-body">
                    <h5 class="card-title"><?= $offer['title'] ?></h5>
                    <p class="card-text"><?= $offer['details'] ?></p>
                    <p><strong>Service:</strong> <?= $offer['service_name'] ?></p>
                    <p><strong>Category:</strong> <?= $offer['category_name'] ?></p>
                    <p><strong>Car Model:</strong> <?= $offer['car_model_from'] ?> - <?= $offer['car_model_to'] ?></p>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
</div>




<?php require_once(VIEW . 'pagination-links.php'); ?>


<?php
$content = ob_get_clean();
require_once(VIEW . 'layout/master.php');
?>