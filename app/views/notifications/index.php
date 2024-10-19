<?php ob_start(); ?>

<div class="container mt-4">
    <h1 class="mb-4">الإشعارات</h1>
    
    <?php if (empty($notifications)): ?>
        <div class="alert alert-info" role="alert">
            لا توجد إشعارات حاليًا.
        </div>
    <?php else: ?>
        <ul class="list-group">
            <?php foreach ($notifications as $notification): ?>
                <li class="list-group-item d-flex justify-content-between align-items-start <?= $notification['is_read'] == 0 ? 'bg-light' : ''; ?>">
                    <div class="ms-2 me-auto">
                        <a href="<?= BASE_URL . '/OfferDetails/show/' . $notification['offer_id'] . '/' . $notification['id'] ?>" class="text-decoration-none">
                            <div class="fw-bold">
                                <?= $notification['message']; ?>
                            </div>
                            <small class="text-muted"><?= date('Y-m-d H:i', strtotime($notification['date'])); ?></small>
                        </a>
                    </div>
                    <span class="badge bg-<?= $notification['is_read'] == 0 ? 'primary' : 'secondary'; ?> rounded-pill">
                        <?= $notification['is_read'] == 0 ? 'غير مقروء' : 'مقروء'; ?>
                    </span>
                </li>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>
</div>

<?php 
$content = ob_get_clean(); 
require_once(VIEW . 'layout/master.php'); 
?>
