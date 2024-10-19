<?php ob_start(); ?>



<div class="container mt-5">
    <h1>Reports List</h1>
    <table class="table table-bordered table-hover mt-4">
        <thead>
            <tr>
                <th>Reported Content</th>
                <th>Content Owner</th>
                <th>Reporter</th>
                <th>Report Details</th>
                <th>Date</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($reports)): ?>
                <?php foreach ($reports as $report): ?>
                    <tr>
                        <td>
                            <?php if (!empty($report['offer_id'])): ?>
                                <!-- Link to the offer if it's an offer report -->
                                <a href="<?= BASE_URL . '/OfferDetails/show/' . $report['offer_id']; ?>"><?= htmlspecialchars($report['offer_title']); ?></a>
                            <?php elseif (!empty($report['comment_id'])): ?>
                                <!-- Display the comment text if it's a comment report -->
                                Comment: <?= htmlspecialchars($report['comment_text']); ?>
                            <?php endif; ?>
                        </td>
                        <td>
                            <?php if (!empty($report['offer_id'])): ?>
                                <?= htmlspecialchars($report['offer_user_name']); ?>
                            <?php elseif (!empty($report['comment_id'])): ?>
                                <?= htmlspecialchars($report['comment_user_name']); ?>
                            <?php endif; ?>
                        </td>
                        <td><?= htmlspecialchars($report['reporter_name']); ?></td>
                        <td><?= htmlspecialchars($report['description']); ?></td>
                        <td><?= date('F d, Y', strtotime($report['created_at'])); ?></td>
                        <td> 
                            <?php if (!empty($report['offer_id'])): ?>
                                <!-- Button to delete an offer -->
                                <button type="button" class="btn btn-danger delete-btn" data-id="<?= $report['offer_id'] ?>" data-type="offer" data-toggle="modal" data-target="#deleteModal">
                                    Delete Offer
                                </button>
                            <?php elseif (!empty($report['comment_id'])): ?>
                                <!-- Button to delete a comment -->
                                <button type="button" class="btn btn-danger delete-btn" data-id="<?= $report['comment_id'] ?>" data-type="comment" data-toggle="modal" data-target="#deleteModal">
                                    Delete Comment
                                </button>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="6" class="text-center">No reports found.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteModalLabel">Confirm Deletion</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                Are you sure you want to delete this content?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-danger" id="confirmDeleteBtn">Delete</button>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        let contentId = null;
        let contentType = null;

        $('#deleteModal').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget);
            contentId = button.data('id');  // Get the content ID (offer_id or comment_id)
            contentType = button.data('type');  // Get the content type (offer or comment)
        });

        document.getElementById('confirmDeleteBtn').addEventListener('click', function() {
            if (contentId && contentType) {
                var form = document.createElement('form');
                form.method = 'POST';
                // Set the form action based on whether it's an offer or a comment
                form.action = contentType === 'offer' ? `<?= BASE_URL . '/offer/delete/' ?>${contentId}` : `<?= BASE_URL . '/comment/delete/' ?>${contentId}`;
                document.body.appendChild(form);
                form.submit();
            }
        });
    });
</script>

<?php
$content = ob_get_clean();
require_once(VIEW . 'layout/master.php');
?>
