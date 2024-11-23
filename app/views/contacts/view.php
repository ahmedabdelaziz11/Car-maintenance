<?php ob_start(); ?>
<div class="search-n-filter-section section-gap-top-25">
    <div class="container">
        <div style="padding: 20px; max-width: 800px; margin: 0 auto; background-color: #f9f9f9; border-radius: 8px; box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);">
            <h1 style="font-size: 24px; color: #333; margin-bottom: 10px; text-align: center;">Conversation</h1>
            <h3 style="font-size: 18px; color: #555; margin-bottom: 15px; text-align: center;">
                <?= htmlspecialchars($contact['contact_type']) ?> - <?= htmlspecialchars($contact['message']) ?>
            </h3>
            <h4 style="font-size: 16px; color: #555; margin-bottom: 20px; text-align: center;">
                User Name - <?= htmlspecialchars($contact['user_name']) ?>
            </h4>

            <div style="max-height: 400px; overflow-y: auto; border: 1px solid #ddd; padding: 15px; background-color: #ffffff; border-radius: 8px; margin-bottom: 20px;">
                <?php if (empty($messages)): ?>
                    <p style="text-align: center; color: #888;">No messages yet.</p>
                <?php else: ?>
                    <?php foreach ($messages as $message): ?>
                        <div style="
                            display: flex;
                            flex-direction: <?= $message['sender'] === 'admin' ? 'row' : 'row-reverse' ?>;
                            margin-bottom: 15px;
                        ">
                            <div style="
                                max-width: 70%;
                                background-color: <?= $message['sender'] === 'admin' ? '#e9f7ef' : '#d1ecf1' ?>;
                                color: #333;
                                border-radius: 8px;
                                padding: 10px;
                                box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
                            ">
                                <p style="margin: 0; font-size: 14px;"><?= htmlspecialchars($message['message']) ?></p>
                                <small style="
                                    display: block;
                                    text-align: <?= $message['sender'] === 'admin' ? 'left' : 'right' ?>;
                                    font-size: 12px;
                                    color: #555;
                                    margin-top: 5px;
                                ">
                                    <?= htmlspecialchars($message['created_at']) ?>
                                </small>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>

            <form method="POST" action="<?= BASE_URL . '/contact/addMessage/' . htmlspecialchars($contact['id']); ?>" style="display: flex; flex-direction: column; gap: 10px;">
                <textarea name="message" style="
                    width: 100%;
                    height: 80px;
                    padding: 10px;
                    font-size: 14px;
                    border: 1px solid #ddd;
                    border-radius: 5px;
                    resize: vertical;
                    box-sizing: border-box;
                " placeholder="Type your reply..." required></textarea>
                <button type="submit" style="
                    background-color: #28a745;
                    color: #fff;
                    border: none;
                    padding: 10px 15px;
                    border-radius: 5px;
                    cursor: pointer;
                    font-size: 14px;
                    transition: background-color 0.3s ease;
                " onmouseover="this.style.backgroundColor='#218838';" onmouseout="this.style.backgroundColor='#28a745';">
                    Reply
                </button>
            </form>
        </div>
    </div>
</div>

<?php $content = ob_get_clean(); ?>
<?php require_once(VIEW . 'layout/master-2.php'); ?>
