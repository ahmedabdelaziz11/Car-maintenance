<div class="container">
    <div class="catagories-wrapper">
        <div class="catagories-wrapper-content ">
            <?php foreach ($offers as $offer): ?>
                <div class="single-product-item product-item--style-2">
                    <div class="image product-item--bg-neon-carrot">
                        <button class="btn btn-primary share-button" 
                            onclick="openShareModal(
                                '<?= BASE_URL . '/' . $offer['id']; ?>', 
                                '<?= addslashes($offer['title']); ?>', 
                                '<?= BASE_URL . '/uploads/offers/' . $offer['image']; ?>'
                            )">
                            <i class="fa fa-share-alt" aria-hidden="true" style="color: #ff375f;"></i>
                        </button>
                        <a href="<?= BASE_URL . '/' . $offer['id'] ?>">
                            <img width="150" height="69" class="img-fluid" src="<?= BASE_URL . '/uploads/offers/' . $offer['image'] ?>" alt="<?= $offer['title'] ?>">
                        </a>
                        <?php if (isset($_SESSION['user'])): ?>
                            <button 
                                type="button" 
                                style="
                                    color: <?= $offer['is_favorite'] ? 'crimson' : 'gray' ?>; 
                                    background: none; 
                                    <?= isset($_SESSION['lang']) && $_SESSION['lang'] == 'en' 
                                        ? 'left: 0px;top: 3px;' 
                                        : 'right: 0px;top: 3px;'; ?>"
                                aria-label="Wishlist" 
                                data-favorite="<?= $offer['is_favorite'] ? 'true' : 'false' ?>" 
                                data-offer-id="<?= $offer['id'] ?>" 
                                class="btn btn--size-33-33 btn--center btn--round btn--color-radical-red favorite-btn" 
                                onClick="toggleFavorite(<?= $offer['id'] ?>, this)">
                                <i class="icon icon-carce-heart"></i>
                            </button>
                        <?php endif; ?>
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
    <?php require_once(VIEW . 'pagination-links.php'); ?>
</div>

<input type="hidden" id="is-follow-status" value="<?= $is_follow ? '1' : '0' ?>">