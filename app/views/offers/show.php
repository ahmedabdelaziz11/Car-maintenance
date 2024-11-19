<?php
use MVC\core\session;
ob_start(); 
?>

<div class="product-single-section section-gap-top-30">
    <div class="container">
        <div class="product-gallery">
            <div class="product-gallery-large">
                <div class="swiper">
                    <div class="swiper-wrapper">
                        <div class="swiper-slide">
                            <div class="product-gallery-single-item">
                                <div class="image">
                                    <img class="img-fluid" width="276" height="172" src="<?= BASE_URL . '/uploads/offers/' . $offer['image'] ?>" alt="<?= $offer['title'] ?>">
                                </div>
                            </div>
                        </div>
                        <?php if(isset($offer['other_images'])) :?>
                            <?php foreach ($offer['other_images'] as $other_image): ?>
                                <div class="swiper-slide">
                                    <div class="product-gallery-single-item">
                                        <div class="image">
                                            <img class="img-fluid" width="276" height="172" src="<?= BASE_URL . '/uploads/offers/' . $other_image['image'] ?>" alt="<?= $offer['title'] ?>">
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </div>
                </div>
                <div class="gallery-nav-btn">
                    <div class="text-btn text-button-prev">Prev</div>
                    <div class="text-btn text-button-next">Next</div>
                </div>
                <div class="product-tag">
                    <?php if (session::Get('user')): ?>
                        <button class="custom-btn" style="color:#ff9966" data-toggle="modal" data-target="#reportOfferModal">Report Offer</button>
                    <?php endif; ?>
                    <?php if (isset($_SESSION['user'])): ?>
                        <button type="button" <?php if ($offer['is_favorite']): ?> style="color:crimson" <?php else: ?> style="color:gray" <?php endif; ?> aria-label="Wishlist" data-favorite="<?= $offer['is_favorite'] ? 'true' : 'false' ?>" data-offer-id="<?= $offer['id'] ?>" class="btn btn--size-33-33 btn--center btn--round btn--color-radical-red btn--bg-white btn--box-shadow favorite-btn"><i class="icon icon-carce-heart"></i></button>
                    <?php endif; ?>
                </div>
            </div>
            <div class="product-thumb-image">
                <div class="swiper">
                    <div class="swiper-wrapper">
                        <div class="swiper-slide">
                            <div class="product-thumb-single-item">
                                <div class="image">
                                    <img class="img-fluid" width="45" height="45" src="<?= BASE_URL . '/uploads/offers/' . $offer['image'] ?>" alt="<?= $offer['title'] ?>">
                                </div>
                            </div>
                        </div>
                        <?php if(isset($offer['other_images'])) :?>
                            <?php foreach ($offer['other_images'] as $other_image): ?>
                                <div class="swiper-slide">
                                    <div class="product-thumb-single-item">
                                        <div class="image">
                                            <img class="img-fluid" width="45" height="45" src="<?= BASE_URL . '/uploads/offers/' . $other_image['image'] ?>" alt="<?= $offer['title'] ?>">
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="billing-info section-gap-top-25">
        <div class="container px-0">
            <div class="billing-information-card">
            
                <span class="billing-information-title"><?= $offer['title'] ?></span>
                <ul class="billing-information-lists">
                    <li class="billing-information-list"> <span> Date</span>
                        <span><?= date('F d, Y', strtotime($offer['date'])) ?></span>
                    </li>
                    <li class="billing-information-list"> <span> Service</span>
                        <span><?= $offer['service_name'] ?></span>
                    </li>
                    <li class="billing-information-list"> <span> Car Type</span>
                        <span><?= $offer['car_type_name'] ?></span>
                    </li>
                    <li class="billing-information-list"> <span> Category</span>
                        <span><?= $offer['category_name'] ?></span>
                    </li>
                    <li class="billing-information-list"> <span> Car Model</span> 
                        <span>
                            <p>from : <?= $offer['car_model_from'] ?> to : <?= $offer['car_model_to'] ?></p>
                        </span> 
                    </li>
                    <li class="billing-information-list"> <span> Country</span> 
                        <span>
                            <?= $offer['country_name'] ?>
                        </span> 
                    </li>
                    <li class="billing-information-list"> <span> City</span> 
                        <span>
                            <?= $offer['city_name'] ?>
                        </span> 
                    </li>
                    <li class="billing-information-list"> <span> Contact</span> 
                        <span>
                            <?= $offer['contact'] ?>
                        </span> 
                    </li>
                </ul>

                <span class="shipping-method-title">Details</span>
                <ul class="shipping-method-lists">
                    <p class="text"><?= $offer['details'] ?></p>
                </ul>

                <div class="payment-card">
                    <a style="display: inline;margin-bottom:10px" class="btn-payment" href="<?= BASE_URL . '/chat/index/'.$offer['user_id'] ?>">Send a Message to the Offer Owner</a>
                    <a style="display: inline;margin-bottom:10px" class="btn-payment" href="<?= BASE_URL ?>/user/profile/<?= $offer['user_id'] ?>">View Owner Profile</a>

                    <?php if (session::Get('user')): ?>
                        <form id="followForm" action="<?= BASE_URL ?>/user/follow" method="POST">
                            <input type="hidden" name="follower_id" value="<?= session::Get('user')['id'] ?>">
                            <input type="hidden" name="following_id" value="<?= $offer['user_id'] ?>">
                            <?php if (!$offer['is_follow_owner']): ?>
                                <button class="btn-payment" id="followBtn" type="button">Follow</button>
                            <?php else: ?>
                                <button class="btn-payment" id="followBtn" type="button">Unfollow</button>
                            <?php endif; ?>
                        </form>
                    <?php endif; ?>
                </div>
            </div>

        </div>
    </div>

    <div class="billing-info section-gap-top-25">
        <div class="container px-0">
            <div class="billing-information-card">
                <span class="billing-information-title">Comments</span>
                <ul class="billing-information-lists">
                    <?php if (!empty($offer['comments'])): ?>
                        <div class="comments-list">
                            <?php foreach ($offer['comments'] as $comment): ?>
                                <div class="comment mb-4">
                                    <p><strong><?= $comment['user_name'] ?>:</strong></p>
                                    <p><?= $comment['comment'] ?></p>
                                    <p><small><?= date('F d, Y h:i A', strtotime($comment['date'])) ?></small></p>
                                    <?php if (session::Get('user')): ?>
                                        <a href="#" class="btn btn-warning" data-toggle="modal" data-target="#reportCommentModal" data-comment-id="<?= $comment['id'] ?>">Report Comment</a>
                                    <?php endif; ?>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php else: ?>
                        <div class="comments-list">
                            <p id="default-comment">No comments yet. Be the first to comment!</p>
                        </div>
                    <?php endif; ?>       
                </ul>
                <ul class="billing-information-lists">
                    <!-- Add Comment Form -->
                    <?php if (session::Get('user')): ?>
                        <div class="add-comment mt-4">
                            <form id="comment-form" method="POST">
                                <div class="form-group">
                                    <label for="comment">Comment</label>
                                    <textarea class="form-control" id="comment" name="comment" rows="3" required></textarea>
                                </div>
                                <button type="submit" class="btn btn-payment">Submit Comment</button>
                            </form>
                        </div>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </div>

    <div class="modal fade" id="reportOfferModal" tabindex="-1" role="dialog" aria-labelledby="reportOfferModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form id="report-offer-form">
                    <div class="modal-header">
                        <h5 class="modal-title" id="reportOfferModalLabel">Report Offer</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="reportDescriptionOffer">Details</label>
                            <textarea class="form-control" id="reportDescriptionOffer" name="description" rows="3"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Submit Report</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="modal fade" id="reportCommentModal" tabindex="-1" role="dialog" aria-labelledby="reportCommentModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form id="report-comment-form">
                    <div class="modal-header">
                        <h5 class="modal-title" id="reportCommentModalLabel">Report Comment</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="reportDescriptionComment">Details</label>
                            <textarea class="form-control" id="reportDescriptionComment" name="description" rows="3"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Submit Report</button>
                    </div>
                    <input type="hidden" id="comment_id" name="comment_id">
                </form>
            </div>
        </div>
    </div>

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

                    if (!isFavorite) {
                        this.style.color = 'crimson';
                    } else {
                        this.style.color = 'gray';
                    }
                }
            })
            .catch(error => {
                console.error('Error:', error);
            });
        });
    });

    document.getElementById('comment-form').addEventListener('submit', function (event) {
        event.preventDefault();

        const comment = document.getElementById('comment').value;
        const offerId = '<?= $offer['id'] ?>';

        fetch('<?= BASE_URL ?>/comment/store', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            },
            body: JSON.stringify({
                offer_id: offerId,
                comment: comment
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                const defaultComment = document.getElementById("default-comment");
                if (defaultComment) {
                    defaultComment.remove();
                }
                const commentList = document.querySelector('.comments-list');
                const newComment = `
                    <div class="comment mb-4">
                        <p><strong>${data.user_name}:</strong></p>
                        <p>${data.comment}</p>
                        <p><small>${data.date}</small></p>
                        <a href="#" class="btn btn-warning" data-toggle="modal" data-target="#reportCommentModal" data-comment-id="${data.id}">Report Comment</a>

                    </div>`;
                commentList.insertAdjacentHTML('beforeend', newComment);
                document.getElementById('comment').value = '';
            } else {
            }
        })
        .catch(error => {
            console.error('Error:', error);
        });
    });

    document.getElementById('report-offer-form').addEventListener('submit', function(event) {
    event.preventDefault();

    const description = document.getElementById('reportDescriptionOffer').value;
    const offerId = '<?= $offer['id'] ?>';

    fetch('<?= BASE_URL ?>/report/store', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            },
            body: JSON.stringify({
                offer_id: offerId,
                description: description
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert(data.message);
                $('#reportOfferModal').modal('hide');
            } else {
                alert(data.message);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('An error occurred. Please try again.');
        });
    });


    document.getElementById('report-comment-form').addEventListener('submit', function(event) {
        event.preventDefault();

        const description = document.getElementById('reportDescriptionComment').value;
        const commentId = document.getElementById('comment_id').value;

        fetch('<?= BASE_URL ?>/report/store', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            },
            body: JSON.stringify({
                comment_id: commentId,
                description: description
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert(data.message);
                $('#reportCommentModal').modal('hide');
            } else {
                alert(data.message);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('An error occurred. Please try again.');
        });
    });

    $('#reportCommentModal').on('show.bs.modal', function(event) {
        var button = $(event.relatedTarget); 
        var commentId = button.data('comment-id'); 
        var modal = $(this);
        modal.find('#comment_id').val(commentId);
    });

    document.getElementById('followBtn').addEventListener('click', function () {
        const form = document.getElementById('followForm');
        const followerId = form.querySelector('input[name="follower_id"]').value;
        const followingId = form.querySelector('input[name="following_id"]').value;
        const followBtn = document.getElementById('followBtn');

        fetch(form.action, {
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
                if (followBtn.innerText === 'Follow') {
                    followBtn.innerText = 'Unfollow';
                } else {
                    followBtn.innerText = 'Follow';
                }
            }
        })
        .catch(error => console.error('Error:', error));
    });
</script>

<?php
$content = ob_get_clean();
require_once(VIEW . 'layout/master-2.php');
?>