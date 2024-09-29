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
                    <form action="<?= BASE_URL . '/OfferManagement/toggleStatus/' . $offer['id'] ?>" method="POST">
                        <button type="submit" class="btn btn-<?= $offer['is_active'] ? 'danger' : 'success' ?>">
                            <?= $offer['is_active'] ? 'Deactivate' : 'Activate' ?>
                        </button>
                    </form>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<?php 
$content = ob_get_clean(); 
require_once(VIEW . 'layout/master.php'); 
?>
