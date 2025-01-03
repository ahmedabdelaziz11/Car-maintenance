<?php ob_start(); ?>
    <!-- ...:::Start Contact Section:::... -->
    <div class="contact-section section-gap-top-30">
        <div class="container">
            <div class="profile-card-section section-gap-top-25">
                <div class="profile-card-wrapper">
                    <div class="content">
                        <h2 class="setting-name"><?= $user['name'] ?></h2>
                        <span class="setting-email email"><?= $user['email'] ?></span>
                    </div>
                    <a style="margin-top:5px" class="btn-payment" href="<?= BASE_URL . '/chat/index/'.$user['id'] ?>"><?= __('Private Message') ?></a>
                </div>
            </div>
        </div>
    </div>
    <div class="catagories-section section-gap-top-50 elements">
        <div class="container">
            <div class="catagories-wrapper">
                <div class="catagories-wrapper-content ">
                    <?php foreach ($offers as $offer): ?>
                        <div class="single-product-item product-item--style-2">
                            <div class="image product-item--bg-neon-carrot">
                                <a href="<?= BASE_URL . '/' . $offer['id'] ?>">
                                    <img width="150" height="69" class="img-fluid" src="<?= BASE_URL . '/uploads/offers/' . $offer['image'] ?>" alt="<?= $offer['title'] ?>">
                                </a>
                            </div>
                            <div class="content">
                                <div class="content--left">
                                    <div style="margin-bottom:15px;">
                                        <a href="<?= BASE_URL . '/' . $offer['id'] ?>" class="title">
                                                <?= $offer['car_type_name'] ?>
                                        </a>
                                        <a style="padding:10px;" href="<?= BASE_URL . '/' . $offer['id'] ?>" class="title">
                                            <?= $offer['category_name'] ?>
                                        </a>
                                    </div>
                                    <span class="price"><?= $offer['service_name'] ?></span>
                                    <span class="price"><?= $offer['country_name'] ?></span>
                                </div>
                                <div class="content--right">

                                    <span class="review-star-text"><i class="icon-carce-ios-star"></i><?= $offer['car_model_from'] ?> - <?= $offer['car_model_to'] ?></span>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
            <div class="offcanvas-overlay"></div>
        </div>
    </div>
    <!-- ...:::End Contact Section:::... -->
<?php 
$content = ob_get_clean(); 
require_once(VIEW . 'layout/master-2.php'); 
?>
