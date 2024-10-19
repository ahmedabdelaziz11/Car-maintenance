<?php

use MVC\core\session;

ob_start(); ?>

<div class="container mt-5">
    <div class="row">
        <!-- Offer Image -->
        <div class="col-md-6">
            <img src="<?= BASE_URL . '/uploads/offers/' . $offer['image'] ?>" alt="Offer Image" class="img-fluid rounded">
            <div class="mt-4">
                <button class="btn btn-warning" data-toggle="modal" data-target="#reportOfferModal">Report Offer</button>
                <a href="<?= BASE_URL . '/chat/index/'.$offer['user_id'] ?>" class="btn btn-secondary">Send a Message to the Offer Owner</a>
                <br>

                <?php if (session::Get('user') && session::Get('user')['id'] !== $offer['user_id']): ?>
                    <form id="followForm" action="<?= BASE_URL ?>/user/follow" method="POST">
                        <input type="hidden" name="follower_id" value="<?= session::Get('user')['id'] ?>">
                        <input type="hidden" name="following_id" value="<?= $offer['user_id'] ?>">
                        <?php if (!$offer['is_follow_owner']): ?>
                            <button class="btn btn-primary" id="followBtn" type="button">Follow</button>
                        <?php else: ?>
                            <button class="btn btn-primary" id="followBtn" type="button">Unfollow</button>
                        <?php endif; ?>
                    </form>
                <?php endif; ?>

            </div>


            <a href="<?= BASE_URL ?>/user/profile/<?= $offer['user_id'] ?>">View Owner Profile</a>
            <?php if (isset($_SESSION['user'])): ?>
                <button class="btn bg-primary favorite-btn" data-favorite="<?= $offer['is_favorite'] ? 'true' : 'false' ?>" data-offer-id="<?= $offer['id'] ?>">
                    <?php if ($offer['is_favorite']): ?> 
                        ازالة من المفضة
                    <?php else: ?>
                        اضافة الى المفضلة
                    <?php endif; ?>
                </button>
            <?php endif; ?>
        </div>

        <!-- Offer Details -->
        <div class="col-md-6">
            <h1 class="mb-4"><?= $offer['title'] ?></h1>

            <!-- Description -->
            <p class="lead"><strong>Details:</strong></p>
            <p><?= $offer['details'] ?></p>

            <!-- Service and Category -->
            <p><strong>Service:</strong> <?= $offer['service_name'] ?></p>
            <p><strong>Car Type:</strong> <?= $offer['car_type_name'] ?></p>
            <p><strong>Category:</strong> <?= $offer['category_name'] ?></p>

            <!-- Car Model Information -->
            <p><strong>Car Model From:</strong> <?= $offer['car_model_from'] ?></p>
            <p><strong>Car Model To:</strong> <?= $offer['car_model_to'] ?></p>

            <!-- Contact Information -->
            <p><strong>Contact:</strong> <?= $offer['contact'] ?></p>

            <!-- Date -->
            <p><strong>Date:</strong> <?= date('F d, Y', strtotime($offer['date'])) ?></p>
        </div>

    </div>

    <?php if (!empty($offer['other_images'])): ?>
        <div class="mt-5">
            <h3>Additional Images</h3>
            <div class="row">
                <?php foreach ($offer['other_images'] as $other_image): ?>
                    <div class="col-md-3 mb-4">
                        <img src="<?= BASE_URL . '/uploads/offers/' . $other_image['image'] ?>" alt="Additional Image" class="img-fluid rounded">
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    <?php endif; ?>

    <div class="mt-5">
        <h3>Comments</h3>
        
        <?php if (!empty($offer['comments'])): ?>
            <div class="comments-list">
                <?php foreach ($offer['comments'] as $comment): ?>
                    <div class="comment mb-4">
                        <p><strong><?= $comment['user_name'] ?>:</strong></p>
                        <p><?= $comment['comment'] ?></p>
                        <p><small><?= date('F d, Y h:i A', strtotime($comment['date'])) ?></small></p>
                        <a href="#" class="btn btn-warning" data-toggle="modal" data-target="#reportCommentModal" data-comment-id="<?= $comment['id'] ?>">Report Comment</a>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <p>No comments yet. Be the first to comment!</p>
        <?php endif; ?>

        <!-- Add Comment Form -->
        <div class="add-comment mt-4">
            <form id="comment-form" method="POST">
                <div class="form-group">
                    <label for="comment">Comment</label>
                    <textarea class="form-control" id="comment" name="comment" rows="3" required></textarea>
                </div>
                <button type="submit" class="btn btn-primary">Submit Comment</button>
            </form>
        </div>
    </div>
</div>
<!-- Report Offer Modal -->
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

<!-- Report Comment Modal -->
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
                        this.innerText = 'ازالة من المفضلة'; 
                    } else {
                        this.innerText = 'اضافة الى المفضلة';
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
require_once(VIEW . 'layout/master.php'); 
?>