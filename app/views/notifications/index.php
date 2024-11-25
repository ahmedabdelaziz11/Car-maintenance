<?php ob_start(); ?>

<div class="catagories-section section-gap-top-50">
    <div class="container">
        <div class="product-wrapper">
            <div class="product-wrapper-content--4">
                <?php if (empty($notifications)): ?>
                    <p class="text-center"><?= __('No notifications available at the moment.') ?></p>
                <?php else: ?>
                    <?php foreach ($notifications as $notification): ?>
                        <div class="single-product-item product-item--style-4">
                            <div class="content">
                                <div class="content--left">
                                    <a href="<?= BASE_URL . '/OfferDetails/show/' . $notification['offer_id'] . '/' . $notification['id'] ?>" class="title">
                                        <strong><?= htmlspecialchars($notification['message']); ?></strong>
                                    </a>
                                    <p><?= htmlspecialchars($notification['date']); ?></p>
                                </div>
                            </div>
                            <a href="#?" aria-label="Remove Notification" class="cart-link">
                                <i class="icon icon-carce-x-circle"></i>
                            </a>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<?php 
$content = ob_get_clean(); 
require_once(VIEW . 'layout/master-2.php'); 
?>
