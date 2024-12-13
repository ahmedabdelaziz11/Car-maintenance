<?php ob_start(); ?>
<div class="container">

    <h1>Admins</h1>
    <a href="<?= BASE_URL . '/admin/create'; ?>" class="btn btn-primary">Add Admin</a>

    <table class="table mt-4">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>EMAIL</th>
                <th>ROLE</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($admins as $admin): ?>
                <tr>
                    <td><?= $admin['id'] ?></td>
                    <td><?= $admin['name'] ?></td>
                    <td><?= $admin['email'] ?></td>
                    <td><?= $admin['role'] == 1 ? "admin" : "supervisor" ?></td>
                    <td>
                        <a href="<?= BASE_URL . '/admin/edit/' . $admin['id'] ?>" class="btn btn-warning">Edit</a>
                        <button type="button" class="btn btn-danger delete-btn" data-id="<?= $admin['id'] ?>" data-toggle="modal" data-target="#deleteModal">
                            Delete
                        </button>
                    </td>
                </tr>
            <?php endforeach; ?>
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
                Are you sure you want to delete this admin?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-danger" id="confirmDeleteBtn">Delete</button>
            </div>
        </div>
    </div>
</div>


<script>
    document.addEventListener('DOMContentLoaded', function () {
        let serviceId = null;
        
        $('#deleteModal').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget);
            serviceId = button.data('id');
        });

        document.getElementById('confirmDeleteBtn').addEventListener('click', function () {
            if (serviceId) {
                var form = document.createElement('form');
                form.method = 'POST';
                form.action = `<?= BASE_URL . '/admin/delete/' ?>${serviceId}`;
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
