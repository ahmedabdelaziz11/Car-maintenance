<?php ob_start(); ?>

<div class="cart-section section-gap-top-30">
    <div class="container">
        <div class="cart-items-wrapper">
            <ul class="cart-item-list">
                <?php foreach ($usersIHaveChatWith as $user): ?>
                    <li class="single-cart-item" id="chat-<?= $user['id'] ?>">
                        <div class="content">
                            <a href="<?= BASE_URL . '/chat/index/' . $user['id'] ?>" class="title"><?= htmlspecialchars($user['name']) ?></a>
                            <div class="details">
                                <div class="right">
                                    <?php if ($user['unread_count'] > 0): ?>
                                        <span class="badge bg-danger"><?= $user['unread_count'] ?></span>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>
    </div>
</div>
<script>
    document.querySelectorAll('.remove-favorite').forEach(button => {
        button.addEventListener('click', function () {
            const offerId = this.getAttribute('data-offer-id');

            fetch(`<?= BASE_URL . "/offer/favorite/" ?>${offerId}`, {
                method: 'POST',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    const offerElement = document.getElementById(`offer-${offerId}`);
                    if (offerElement) {
                        offerElement.remove();
                    }
                }
            })
            .catch(console.error);
        });
    });
</script>
<?php
$content = ob_get_clean();
require_once(VIEW . 'layout/master-2.php');
?>