<?php ob_start(); ?>
<div class="container">

    <h1>Services</h1>
    <a href="<?= BASE_URL . '/service/create'; ?>" class="btn btn-primary">Add Service</a>

    <table class="table mt-4">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Image</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($services as $service): ?>
                <tr>
                    <td><?= $service['id'] ?></td>
                    <td><?= $service['name'] ?></td>
                    <td><img src="<?= BASE_URL . '/uploads/services/' . $service['image'] ?>" alt="<?= $service['name'] ?>" width="100"></td>
                    <td>
                        <a href="<?= BASE_URL . '/service/edit/' . $service['id'] ?>" class="btn btn-warning">Edit</a>
                        <button type="button" class="btn btn-danger delete-btn" data-id="<?= $service['id'] ?>" data-toggle="modal" data-target="#deleteModal">
                            Delete
                        </button>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

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
                    Are you sure you want to delete this service?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-danger" id="confirmDeleteBtn">Delete</button>
                </div>
            </div>
        </div>
    </div>
</div>


<script>
    document.addEventListener('DOMContentLoaded', function() {
        let serviceId = null;

        $('#deleteModal').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget);
            serviceId = button.data('id');
        });

        document.getElementById('confirmDeleteBtn').addEventListener('click', function() {
            if (serviceId) {
                var form = document.createElement('form');
                form.method = 'POST';
                form.action = `<?= BASE_URL . '/service/delete/' ?>${serviceId}`;
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