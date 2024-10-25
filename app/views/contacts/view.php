<?php ob_start(); ?>

<h1 style="font-size: 24px; margin-bottom: 10px;">Conversation</h1>
<h2 style="font-size: 18px; color: #555; margin-bottom: 20px;">
    <?= htmlspecialchars($contact['contact_type']) ?> - <?= htmlspecialchars($contact['message']) ?>
</h2>
<h2 style="font-size: 18px; color: #555; margin-bottom: 20px;">
    User Name - <?= htmlspecialchars($contact['user_name']) ?>
</h2>

<div class="messages" style="max-height: 400px; overflow-y: auto; border: 1px solid #ddd; padding: 10px; background-color: #fafafa; border-radius: 5px;">
    <?php if (empty($messages)): ?>
        <p style="text-align: center; color: #888;">No messages yet.</p>
    <?php else: ?>
        <?php foreach ($messages as $message): ?>
            <div style="
                display: flex;
                flex-direction: <?= $message['sender'] === 'admin' ? 'row' : 'row-reverse' ?>;
                margin-bottom: 10px;
            ">
                <div style="
                    max-width: 70%;
                    background-color: <?= $message['sender'] === 'admin' ? '#f1f1f1' : '#d1f1d1' ?>;
                    border-radius: 8px;
                    padding: 10px;
                    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
                ">
                    <p style="margin: 0; font-size: 14px;"><?= htmlspecialchars($message['message']) ?></p>
                    <small style="display: block; text-align: <?= $message['sender'] === 'admin' ? 'left' : 'right' ?>; font-size: 12px; color: #888;">
                        <?= htmlspecialchars($message['created_at']) ?>
                    </small>
                </div>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>
</div>

<form method="POST" action="<?= BASE_URL . '/contact/addMessage/' . htmlspecialchars($contact['id']); ?>" style="margin-top: 20px;">
    <textarea name="message" style="
        width: 100%;
        height: 80px;
        padding: 10px;
        font-size: 14px;
        border: 1px solid #ddd;
        border-radius: 5px;
        resize: vertical;
        box-sizing: border-box;
        margin-bottom: 10px;
    " placeholder="Type your reply..." required></textarea>
    <button type="submit" style="
        background-color: #28a745;
        color: #fff;
        border: none;
        padding: 10px 15px;
        border-radius: 5px;
        cursor: pointer;
        font-size: 14px;
    ">Reply</button>
</form>

<?php $content = ob_get_clean(); ?>
<?php require_once(VIEW . 'layout/master.php'); ?>
