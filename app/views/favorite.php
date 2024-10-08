<?php ob_start(); ?>


<!-- Display Offers in Cards -->
<div class="row mt-4">
    <?php foreach ($offers as $offer): ?>
        <div class="col-md-4" id="offer-<?= $offer['id'] ?>">
            <div class="card mb-4">
                <img src="<?= BASE_URL . '/uploads/offers/' . $offer['image'] ?>" class="card-img-top" alt="<?= $offer['title'] ?>">
                <div class="card-body">
                    <h5 class="card-title"><?= $offer['title'] ?></h5>
                    <p class="card-text"><?= $offer['details'] ?></p>
                    <p><strong>Service:</strong> <?= $offer['service_name'] ?></p>
                    <p><strong>car type:</strong> <?= $offer['car_type_name'] ?></p>
                    <p><strong>Category:</strong> <?= $offer['category_name'] ?></p>
                    <p><strong>Car Model:</strong> <?= $offer['car_model_from'] ?> - <?= $offer['car_model_to'] ?></p>
                    <button class="btn btn-danger remove-favorite" data-offer-id="<?= $offer['id'] ?>">إزالة من المفضلة</button>
                    <a href="<?= BASE_URL . '/offer/details/' . $offer['id'] ?>" class="btn btn-primary">View Details</a>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
</div>

<script>
    document.querySelectorAll('.remove-favorite').forEach(button => {
        button.addEventListener('click', function () {
            const offerId = this.getAttribute('data-offer-id');

            fetch(`<?= BASE_URL . "/offer/favorite/" ?>${offerId}`, {
                method: 'POST',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    const offerElement = document.getElementById(`offer-${offerId}`);
                    if (offerElement) {
                        offerElement.remove();
                    }
                }
            })
            .catch(console.error);
        });
    });

</script>


<?php
$content = ob_get_clean();
require_once(VIEW . 'layout/master.php');
?>