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
    
    <button type="submit" name="action" value="search" class="btn btn-primary">Search</button>
    <?php if (isset($_SESSION['user'])): ?>
        <button type="submit" name="action" value="follow" class="btn btn-secondary">Follow</button>
    <?php endif; ?>

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
                    <?php if (isset($_SESSION['user'])): ?>
                        <button class="btn p-0 border-0 bg-transparent favorite-btn" data-favorite="<?= $offer['is_favorite'] ? 'true' : 'false' ?>" data-offer-id="<?= $offer['id'] ?>">
                            <?php if ($offer['is_favorite']): ?> 
                                <i class="fas fa-heart heart-icon" style="color: red; font-size: 1.5rem;"></i> 
                            <?php else: ?>
                                <i class="far fa-heart heart-icon" style="color: gray; font-size: 1.5rem;"></i>
                            <?php endif; ?>
                        </button>
                    <?php endif; ?>
                    <p><strong>Service:</strong> <?= $offer['service_name'] ?></p>
                    <p><strong>car type:</strong> <?= $offer['car_type_name'] ?></p>
                    <p><strong>Category:</strong> <?= $offer['category_name'] ?></p>
                    <p><strong>Car Model:</strong> <?= $offer['car_model_from'] ?> - <?= $offer['car_model_to'] ?></p>
                    <a href="<?= BASE_URL . '/offer/details/' . $offer['id'] ?>" class="btn btn-primary">View Details</a>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
</div>

<script>
document.querySelectorAll('.favorite-btn').forEach(button => {
    button.addEventListener('click', function () {
        const offerId = this.getAttribute('data-offer-id');
        const isFavorite = this.getAttribute('data-favorite') === 'true';

        fetch('<?= BASE_URL . "/offer/favorite/" ?>' + offerId, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            },
            body: JSON.stringify({
                favorite: !isFavorite
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                this.setAttribute('data-favorite', !isFavorite);
                const icon = this.querySelector('i');
                if (!isFavorite) {
                    icon.style.color = 'red';
                } else {
                    icon.style.color = 'gray';
                }
            }
        })
        .catch(error => {
            console.error('Error:', error);
        });
    });
});

</script>
<?php require_once(VIEW . 'pagination-links.php'); ?>


<?php
$content = ob_get_clean();
require_once(VIEW . 'layout/master.php');
?>