<?php

use MVC\core\session;

ob_start();
?>

<div class="container mt-5">
    <div class="row">
        <!-- Chats List Sidebar -->
        <div class="col-md-3">
            <h4>Chats</h4>
            <div class="list-group" style="border: 1px solid #ddd; border-radius: 8px;">
                <?php foreach ($usersIHaveChatWith as $user): ?>
                    <a href="<?= BASE_URL . '/chat/index/' . $user['id'] ?>"
                        class="list-group-item list-group-item-action d-flex justify-content-between align-items-center <?= isset($receiver) && $receiver['id'] == $user['id'] ? 'active bg-primary text-white' : '' ?>"
                        style="padding: 10px; border-bottom: 1px solid #ddd;">
                        <div class="d-flex align-items-center">
                            <span><?= htmlspecialchars($user['name']) ?></span>
                        </div>
                        <!-- Unread message badge -->
                        <?php if ($user['unread_count'] > 0): ?>
                            <span class="badge bg-danger rounded-pill"><?= $user['unread_count'] ?></span>
                        <?php endif; ?>
                    </a>
                <?php endforeach; ?>
            </div>
        </div>

        <!-- Chat Content Area -->
        <div class="col-md-9">
            <?php if (isset($receiver)): ?>
                <h1 class="mb-4">Chat with <?= htmlspecialchars($receiver['name']) ?></h1>
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
                                <p>No messages yet. Start the conversation!</p>
                            <?php endif; ?>
                        </div>

                        <!-- Message Input -->
                        <form method="POST" action="<?= BASE_URL . '/chat/send/' . $receiver['id'] ?>" class="mt-3">
                            <div class="input-group">
                                <textarea class="form-control" id="message" name="message" rows="2" required placeholder="Type your message..." style="border-radius: 0; border: 1px solid #ddd;"></textarea>
                                <button class="btn btn-primary" type="submit" style="border-radius: 0;">
                                    <i class="fas fa-paper-plane"></i> Send
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            <?php else: ?>
                <div class="alert alert-info">
                    <h4>No chat selected</h4>
                    <p>Please select a user from the list to start chatting.</p>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php
$content = ob_get_clean();
require_once(VIEW . 'layout/master.php');
?>