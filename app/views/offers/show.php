<?php ob_start(); ?>

<div class="container mt-5">
    <div class="row">
        <!-- Offer Image -->
        <div class="col-md-6">
            <img src="<?= BASE_URL . '/uploads/offers/' . $offer['image'] ?>" alt="Offer Image" class="img-fluid rounded">
            <div class="mt-4">
                <button class="btn btn-warning" data-toggle="modal" data-target="#reportOfferModal">Report Offer</button>
                <a href="<?= BASE_URL . '/chat/index/'.$offer['user_id'] ?>" class="btn btn-secondary">Send a Message to the Offer Owner</a>
            </div>

            <?php if (isset($_SESSION['user'])): ?>
                <button class="btn p-0 border-0 bg-transparent favorite-btn" data-favorite="<?= $offer['is_favorite'] ? 'true' : 'false' ?>" data-offer-id="<?= $offer['id'] ?>">
                    <?php if ($offer['is_favorite']): ?> 
                        <i class="fas fa-heart heart-icon" style="color: red; font-size: 1.5rem;"></i> 
                    <?php else: ?>
                        <i class="far fa-heart heart-icon" style="color: gray; font-size: 1.5rem;"></i>
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
                    const icon = this.querySelector('i');
                    if (!isFavorite) {
                        icon.style.color = 'red';
                    } else {
                        icon.style.color = 'gray';
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


    // Report Comment Submission
    document.getElementById('report-comment-form').addEventListener('submit', function(event) {
        event.preventDefault();

        const description = document.getElementById('reportDescriptionComment').value;
        const commentId = document.getElementById('comment_id').value;

        // Debug: Check if comment ID is set correctly
        console.log("Submitting report for comment ID: ", commentId);

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

    // When the report comment modal opens, set the comment_id
    $('#reportCommentModal').on('show.bs.modal', function(event) {
        var button = $(event.relatedTarget); // Button that triggered the modal
        var commentId = button.data('comment-id'); // Extract comment ID from the data-* attribute
        var modal = $(this);

        // Debug: Log the comment ID to ensure it's being set correctly
        console.log("Opening modal for comment ID: ", commentId);

        // Set the comment ID in the hidden input field
        modal.find('#comment_id').val(commentId);
    });


</script>

<?php 
$content = ob_get_clean(); 
require_once(VIEW . 'layout/master.php'); 
?>