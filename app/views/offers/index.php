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
                    <form action="<?= BASE_URL . '/offer/delete/' . $offer['id'] ?>" method="POST" style="display:inline;">
                        <button type="submit" class="btn btn-danger">Delete</button>
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
