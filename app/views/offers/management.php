<?php ob_start(); ?>

<h1>ادارة العروض</h1>
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
                    <button 
                        data-id="<?= $offer['id'] ?>" 
                        data-status="<?= $offer['is_active'] ?>" 
                        class="btn btn-<?= $offer['is_active'] ? 'danger' : 'success' ?> toggle-status-btn">
                        <?= $offer['is_active'] ? 'Deactivate' : 'Activate' ?>
                    </button>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const buttons = document.querySelectorAll('.toggle-status-btn');

    buttons.forEach(button => {
        button.addEventListener('click', function () {
            const offerId = this.getAttribute('data-id');
            const currentStatus = this.getAttribute('data-status');
            
            fetch('<?= BASE_URL ?>/OfferManagement/toggleStatus/' + offerId, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({
                    status: currentStatus
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    const newStatus = data.newStatus;
                    button.textContent = newStatus ? 'Deactivate' : 'Activate';
                    button.classList.toggle('btn-success', !newStatus);
                    button.classList.toggle('btn-danger', newStatus);
                    button.setAttribute('data-status', newStatus);
                } else {
                    alert('Failed to update the offer status.');
                }
            })
            .catch(error => console.error('Error:', error));
        });
    });
});
</script>

<?php 
$content = ob_get_clean(); 
require_once(VIEW . 'layout/master.php'); 
?>
