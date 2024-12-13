<?php ob_start(); ?>
<div class="container">
    <h1>انواع السيارات</h1>
    <a href="<?= BASE_URL . '/carType/create'; ?>" class="btn btn-primary">انشاء نوع سيارة</a>

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
            <?php foreach ($carTypes as $carType): ?>
                <tr>
                    <td><?= $carType['id'] ?></td>
                    <td><?= $carType['name'] ?></td>
                    <td><img src="<?= BASE_URL.'/uploads/car_types/' .$carType['image'] ?>" alt="<?= $carType['name'] ?>" width="100"></td>
                    <td>
                        <a href="<?= BASE_URL . '/carType/edit/' . $carType['id'] ?>" class="btn btn-warning">Edit</a>
                        
                        <button type="button" class="btn btn-danger delete-btn" data-id="<?= $carType['id'] ?>" data-toggle="modal" data-target="#deleteModal">
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
                    Are you sure you want to delete this car type?
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
    document.addEventListener('DOMContentLoaded', function () {
        let typeId = null;
        
        $('#deleteModal').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget);
            typeId = button.data('id');
        });

        document.getElementById('confirmDeleteBtn').addEventListener('click', function () {
            if (typeId) {
                var form = document.createElement('form');
                form.method = 'POST';
                form.action = `<?= BASE_URL . '/carType/delete/' ?>${typeId}`;
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
