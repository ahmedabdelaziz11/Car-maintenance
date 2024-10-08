<?php ob_start(); ?>

<h1>ادارة عروضك</h1>
<a href="<?= BASE_URL . '/offer/create' ?>" class="btn btn-primary">انشاء عرض جديد</a>
<table class="table">
    <thead>
        <tr>
            <th>العنوان</th>
            <th>التفاصيل</th>
            <th>التاريخ</th>
            <th>العمليات</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($offers as $offer): ?>
            <tr>
                <td><?= $offer['title'] ?></td>
                <td><?= $offer['details'] ?></td>
                <td><?= $offer['date'] ?></td>
                <td>
                    <a href="<?= BASE_URL . '/offer/edit/' . $offer['id'] ?>" class="btn btn-warning">Edit</a>
                    <button type="button" class="btn btn-danger delete-btn" data-id="<?= $offer['id'] ?>" data-toggle="modal" data-target="#deleteModal">
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
                Are you sure you want to delete this offer?
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
require_once(VIEW . 'layout/master.php'); 
?>
