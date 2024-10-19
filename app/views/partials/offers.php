<?php foreach ($offers as $offer): ?>
    <div class="col-md-4">
        <div class="card mb-4">
            <a href="<?= BASE_URL . '/OfferDetails/show/' . $offer['id'] ?>">
                <img src="<?= BASE_URL . '/uploads/offers/' . $offer['image'] ?>" class="card-img-top" alt="<?= $offer['title'] ?>">
            </a>
            <div class="card-body">
                <h5 class="card-title"><?= $offer['title'] ?></h5>
                <p class="card-text"><?= $offer['details'] ?></p>
                <p><strong>Service:</strong> <?= $offer['service_name'] ?></p>
                <p><strong>car type:</strong> <?= $offer['car_type_name'] ?></p>
                <p><strong>Category:</strong> <?= $offer['category_name'] ?></p>
                <p><strong>Car Model:</strong> <?= $offer['car_model_from'] ?> - <?= $offer['car_model_to'] ?></p>
                <p><strong>Country:</strong> <?= $offer['country_name'] ?></p>
                <p><strong>City :</strong> <?= $offer['city_name'] ?></p>
            </div>
        </div>
    </div>
<?php endforeach; ?>
<?php require_once(VIEW . 'pagination-links.php'); ?>
