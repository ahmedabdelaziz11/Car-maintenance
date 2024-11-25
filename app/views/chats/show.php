<?php

use MVC\core\session;

ob_start(); ?>

<div class="container mt-5">
    <h1 class="mb-4"><?= __('Chat with') ?> <?= htmlspecialchars($receiver['name']) ?></h1>
    <div class="card">
        <div class="card-body">
            <div class="chat-box" style="height: 400px; overflow-y: auto; border: 1px solid #ddd; padding: 15px; background-color: #f5f5f5; border-radius: 8px;">
                <?php if (!empty($messages)): ?>
                    <?php foreach ($messages as $message): ?>
                        <div class="message mb-3 <?= $message['sender_id'] == session::get('user')['id'] ? 'text-end' : 'text-start' ?>">
                            <div class="d-inline-block p-2 <?= $message['sender_id'] == session::get('user')['id'] ? 'bg-primary text-white' : 'bg-light text-dark' ?>" style="border-radius: 12px; max-width: 80%;">
                                <strong><?= $message['sender_id'] == session::get('user')['id'] ? 'You' : htmlspecialchars($receiver['name']) ?>:</strong>
                                <p class="mb-1"><?= htmlspecialchars($message['message']) ?></p>
                                <small class="text-muted"><?= date('F d, Y h:i A', strtotime($message['created_at'])) ?></small>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p><?= __('No messages yet. Start the conversation!') ?></p>
                <?php endif; ?>
            </div>

            <!-- Message Input -->
            <form method="POST" action="<?= BASE_URL . '/chat/send/' . $receiver['id'] ?>" class="mt-3">
                <div class="input-group">
                    <textarea class="form-control" id="message" name="message" rows="2" required placeholder="Type your message..." style="border-radius: 0; border: 1px solid #ddd;"></textarea>
                    <button class="btn btn-primary" type="submit" style="border-radius: 0;">
                        <i class="fas fa-paper-plane"></i> <?= __('Send') ?> 
                    </button>
                </div>
            </form>
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
