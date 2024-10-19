<?php ob_start(); ?>

<h1>البلدان</h1>
<a href="<?= BASE_URL . '/country/create'; ?>" class="btn btn-primary">انشاء بلد</a>

<table class="table mt-4">
    <thead>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($countries as $country): ?>
            <tr>
                <td><?= $country['id'] ?></td>
                <td><?= $country['name'] ?></td>
                <td>
                    <a href="<?= BASE_URL . '/country/edit/' . $country['id'] ?>" class="btn btn-warning">Edit</a>
                    
                    <button type="button" class="btn btn-danger delete-btn" data-id="<?= $country['id'] ?>" data-toggle="modal" data-target="#deleteModal">
                        Delete
                    </button>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

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
                Are you sure you want to delete this country?
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
        let countryId = null;
        
        $('#deleteModal').on('show.bs.modal', function (event) {
            console.log("dssdds")
            var button = $(event.relatedTarget);
            countryId = button.data('id');
        });

        document.getElementById('confirmDeleteBtn').addEventListener('click', function () {
            if (countryId) {
                var form = document.createElement('form');
                form.method = 'POST';
                form.action = `<?= BASE_URL . '/country/delete/' ?>${countryId}`;
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
