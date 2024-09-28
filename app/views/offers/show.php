<?php ob_start(); ?>

<div class="container mt-5">
    <div class="row">
        <!-- Offer Image -->
        <div class="col-md-6">
            <img src="<?= BASE_URL . '/uploads/offers/' . $offer['image'] ?>" alt="Offer Image" class="img-fluid rounded">
        </div>

        <!-- Offer Details -->
        <div class="col-md-6">
            <h1 class="mb-4"><?= $offer['title'] ?></h1>

            <!-- Description -->
            <p class="lead"><strong>Details:</strong></p>
            <p><?= $offer['details'] ?></p>

            <!-- Service and Category -->
            <p><strong>Service:</strong> <?= $offer['service_name'] ?></p>
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
                    </div>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <p>No comments yet. Be the first to comment!</p>
        <?php endif; ?>

        <!-- Add Comment Form -->
        <div class="add-comment mt-4">
            <form method="POST" action="<?= BASE_URL . '/offer/details/' . $offer['id'] ?>">
                <div class="form-group">
                    <label for="comment">Comment</label>
                    <textarea class="form-control" id="comment" name="comment" rows="3" required></textarea>
                </div>
                <button type="submit" class="btn btn-primary">Submit Comment</button>
            </form>
        </div>
    </div>

    <!-- Extra Section: Optionally, you can add buttons or links to go back or perform actions -->
    <div class="mt-4">
        <a href="<?= BASE_URL . '/home/index' ?>" class="btn btn-secondary">Back to Offers</a>
    </div>
</div>

<?php 
$content = ob_get_clean(); 
require_once(VIEW . 'layout/master.php'); 
?>