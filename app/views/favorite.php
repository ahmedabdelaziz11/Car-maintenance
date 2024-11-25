<?php ob_start(); ?>

<div class="cart-section section-gap-top-30">
    <div class="container">
        <div class="cart-items-wrapper">
            <ul class="cart-item-list">
                <?php foreach ($offers as $offer): ?>
                    <li class="single-cart-item" id="offer-<?= $offer['id'] ?>">
                        <div class="image">
                            <img width="90" height="90" src="<?= BASE_URL . '/uploads/offers/' . $offer['image'] ?>" alt="<?= $offer['title'] ?>">
                        </div>
                        <div class="content">
                            <a href="<?= BASE_URL . '/OfferDetails/show/' . $offer['id'] ?>" class="title"><?= $offer['title'] ?></a>
                            <div class="details">
                                <div class="left">
                                    <span class="brand"><?= $offer['service_name'] ?></span>
                                    <span class="price"><?= $offer['car_type_name'] ?></span>
                                    <span class="price"><?= $offer['category_name'] ?></span>
                                </div>
                                <div class="right">
                                    <button data-offer-id="<?= $offer['id'] ?>" class="remove-favorite btn btn--default btn--radius btn--color-white btn--radical-red"><?= __('Remove From Favorite') ?></button>
                                </div>
                            </div>
                        </div>
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>
    </div>
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
require_once(VIEW . 'layout/master-2.php');
?>