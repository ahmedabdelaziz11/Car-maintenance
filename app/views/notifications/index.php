<?php ob_start(); ?>

<div class="catagories-section section-gap-top-50">
    <div class="container">
        <div class="product-wrapper">
            <div class="product-wrapper-content--4">
                <?php if (empty($notifications)): ?>
                    <p class="text-center"><?= __('No notifications available at the moment.') ?></p>
                <?php else: ?>
                    <?php foreach ($notifications as $notification): ?>
                        <a style="margin: 20px;" href="<?= BASE_URL . '/OfferDetails/show/' . $notification['offer_id'] . '/' . $notification['id'] ?>">
                            <div class="single-product-item product-item--style-4" style="<?= $notification['is_read'] ? 'background-color: #EAEBE8;' : ''; ?>">
                                <div class="content">
                                    <div class="content--left">
                                        <div class="title">
                                            <strong><?= htmlspecialchars($notification['message']); ?></strong>
                                            <p><?= htmlspecialchars($notification['date']); ?></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </a>
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
