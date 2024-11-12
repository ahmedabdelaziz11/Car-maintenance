<div class="container">
    <div class="catagories-wrapper">
        <div class="catagories-wrapper-content ">
            <?php foreach ($offers as $offer): ?>
                <div class="single-product-item product-item--style-2">
                    <div class="image product-item--bg-neon-carrot">
                        <a href="<?= BASE_URL . '/OfferDetails/show/' . $offer['id'] ?>">
                            <img width="58" height="69" class="img-fluid" src="<?= BASE_URL . '/uploads/offers/' . $offer['image'] ?>" alt="<?= $offer['title'] ?>">
                        </a>
                        <!-- <a href="wishlist.html" aria-label="Wishlist" class="btn btn--size-33-33 btn--center btn--round btn--color-radical-red btn--bg-white btn--box-shadow"><i class="icon icon-carce-heart"></i></a> -->
                    </div>
                    <div class="content">
                        <div class="content--left">
                            <a href="<?= BASE_URL . '/OfferDetails/show/' . $offer['id'] ?>" class="title"><?= $offer['title'] ?></a>
                            <span class="price"><?= $offer['service_name'] ?></span>
                        </div>
                        <div class="content--right">
                            <span class="review-star-text"><i class="icon-carce-ios-star"></i> 4.5</span>
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

