<?php ob_start(); ?>

<div class="favorite-section section-gap-top-30">
    <div class="container">
        <div class="favorite-offers">
            <h2 class="mb-2"><?= __('Favorite Offers') ?></h2>
            <div class="cart-items-wrapper">
                <ul class="cart-item-list">
                    <?php if (!empty($offers)): ?>
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
                    <?php else: ?>
                        <p><?= __('No offers found in your favorites.') ?></p>
                    <?php endif; ?>
                </ul>
            </div>
        </div>

        <div class="favorite-offers mt-5">
            <h2 class="mb-2"><?= __('Following Users') ?></h2>
            <div class="cart-items-wrapper">
                <ul class="cart-item-list">
                    <?php if (!empty($users)): ?>
                        <?php foreach ($users as $user): ?>
                            <li class="single-cart-item" style="justify-content: flex-end;" id="user-<?= $user['id'] ?>">
                                <div class="content">
                                    <div class="details">
                                        <div class="left">
                                            <span class="brand"><?= $user['name'] ?></span>
                                            <span class="price"><?= $user['email'] ?></span>
                                        </div>
                                        <div class="right">
                                            <button
                                                data-following-id="<?= $user['id'] ?>"
                                                data-follower-id="<?= $_SESSION['user']['id'] ?>"
                                                class="follow-user btn btn--default btn--radius btn--color-white btn--radical-red">
                                                <?= __('Remove From Favorite') ?>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </li>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <p><?= __('No users found in your favorites.') ?></p>
                    <?php endif; ?>
                </ul>
            </div>
        </div>

        <div class="favorite-offers mt-5">
            <h2 class="mb-2"><?= __('Following Services') ?></h2>
            <div class="cart-items-wrapper">
                <ul class="cart-item-list">
                    <?php if (!empty($services)): ?>
                        <?php foreach ($services as $service): ?>
                            <li class="single-cart-item" style="justify-content: flex-end;" id="service-<?= $service['id'] ?>">
                                <div class="content">
                                    <div class="details">
                                        <div class="left">
                                            <span class="brand"><?= $service['service_name'] ?></span>
                                            <span class="price"><?= $service['category_name'] ?></span>
                                        </div>
                                        <div class="right">
                                            <button
                                                data-follow-id="<?= $service['id'] ?>"
                                                class="follow-service btn btn--default btn--radius btn--color-white btn--radical-red">
                                                <?= __('Remove From Favorite') ?>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </li>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <p><?= __('No services found in your favorites.') ?></p>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </div>
</div>

<script>
    document.querySelectorAll('.remove-favorite').forEach(button => {
        button.addEventListener('click', function() {
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
    document.querySelectorAll('.follow-user').forEach(button => {
        button.addEventListener('click', function() {
            const followerId = this.getAttribute('data-follower-id');
            const followingId = this.getAttribute('data-following-id');

            fetch('<?= BASE_URL ?>/user/follow', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest'
                    },
                    body: JSON.stringify({
                        follower_id: followerId,
                        following_id: followingId
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        const userElement = document.getElementById(`user-${followingId}`);
                        if (userElement) {
                            userElement.remove();
                        }
                    }
                })
                .catch(console.error);
        });
    });
    document.querySelectorAll('.follow-service').forEach(button => {
        button.addEventListener('click', function() {
            const followId = this.getAttribute('data-follow-id');

            fetch('<?= BASE_URL ?>/favorite/deleteFollow', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest'
                    },
                    body: JSON.stringify({
                        follow_id: followId,
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        const userElement = document.getElementById(`service-${followId}`);
                        if (userElement) {
                            userElement.remove();
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