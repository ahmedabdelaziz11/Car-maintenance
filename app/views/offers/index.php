<?php ob_start(); ?>

<div class="container my-5">
    <div class="d-flex justify-content-between align-items-center">
        <h1 class="text-primary">Manage Your Offers</h1>
        <a href="<?= BASE_URL . '/offer/create' ?>" class="btn custom-btn-success">
            <i class="fas fa-plus"></i> Create New Offer
        </a>
    </div>

    <div class="table-responsive mt-4">
        <table class="table table-striped table-hover">
            <thead class="thead-dark">
                <tr>
                    <th>Title</th>
                    <th>Details</th>
                    <th>Date</th>
                    <th class="text-center">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($offers as $offer): ?>
                    <tr>
                        <td><?= $offer['title'] ?></td>
                        <td><?= $offer['details'] ?></td>
                        <td><?= $offer['date'] ?></td>
                        <td class="text-center">
                            <a href="<?= BASE_URL . '/offer/edit/' . $offer['id'] ?>" class="btn custom-btn-warning">
                                <i class="fas fa-edit"></i> Edit
                            </a>
                            <button type="button" class="btn custom-btn-danger delete-btn" data-id="<?= $offer['id'] ?>" data-toggle="modal" data-target="#deleteModal">
                                <i class="fas fa-trash-alt"></i> Delete
                            </button>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title" id="deleteModalLabel">Confirm Deletion</h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                Are you sure you want to delete this offer?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn custom-btn-secondary" data-dismiss="modal">Cancel</button>
                <button type="button" class="btn custom-btn-danger" id="confirmDeleteBtn">Delete</button>
            </div>
        </div>
    </div>
</div>


<script>
    document.addEventListener('DOMContentLoaded', function () {
        let offerId = null;

        $('#deleteModal').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget);
            offerId = button.data('id');
        });

        document.getElementById('confirmDeleteBtn').addEventListener('click', function () {
            if (offerId) {
                var form = document.createElement('form');
                form.method = 'POST';
                form.action = `<?= BASE_URL . '/offer/delete/' ?>${offerId}`;
                document.body.appendChild(form);
                form.submit();
            }
        });
    });
</script>

<?php 
$content = ob_get_clean(); 
require_once(VIEW . 'layout/master-2.php'); 
?>
