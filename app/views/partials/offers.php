<?php foreach ($offers as $offer): ?>
    <div class="col-md-4">
        <div class="card mb-4">
            <img src="<?= BASE_URL . '/uploads/offers/' . $offer['image'] ?>" class="card-img-top" alt="<?= $offer['title'] ?>">
            <div class="card-body">
                <h5 class="card-title"><?= $offer['title'] ?></h5>
                <p class="card-text"><?= $offer['details'] ?></p>
                <p><strong>Service:</strong> <?= $offer['service_name'] ?></p>
                <p><strong>car type:</strong> <?= $offer['car_type_name'] ?></p>
                <p><strong>Category:</strong> <?= $offer['category_name'] ?></p>
                <p><strong>Car Model:</strong> <?= $offer['car_model_from'] ?> - <?= $offer['car_model_to'] ?></p>
                <a href="<?= BASE_URL . '/offer/details/' . $offer['id'] ?>" class="btn btn-primary">View Details</a>
            </div>
        </div>
    </div>
<?php endforeach; ?>
<?php require_once(VIEW . 'pagination-links.php'); ?>
