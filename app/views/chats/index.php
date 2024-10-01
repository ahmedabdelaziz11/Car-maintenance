<?php

use MVC\core\session;
ob_start(); 
?>

<div class="container mt-5">
    <div class="row">
        <div class="col-md-3">
            <h4>Chats List</h4>
            <div class="list-group">
                <?php foreach ($usersIHaveChatWith as $user): ?>
                    <a href="<?= BASE_URL . '/chat/index/' . $user['id'] ?>" class="list-group-item list-group-item-action <?= isset($receiver) && $receiver['id'] == $user['id'] ? 'active' : '' ?>">
                        <?= htmlspecialchars($user['name']) ?>
                    </a>
                <?php endforeach; ?>
            </div>
        </div>

        <!-- Chat content -->
        <div class="col-md-9">
            <?php if (isset($receiver)): ?>
                <h1 class="mb-4">Chat with <?= htmlspecialchars($receiver['name']) ?></h1>
                <div class="card">
                    <div class="card-body">
                        <div class="chat-box" style="height: 400px; overflow-y: auto; border: 1px solid #ddd; padding: 10px; background-color: #f9f9f9;">
                            <?php if (!empty($messages)): ?>
                                <?php foreach ($messages as $message): ?>
                                    <div class="message mb-3 <?= $message['sender_id'] == session::get('user')['id'] ? 'text-end' : '' ?>">
                                        <strong><?= $message['sender_id'] == session::get('user')['id'] ? 'You' : htmlspecialchars($receiver['name']) ?>:</strong>
                                        <p><?= htmlspecialchars($message['message']) ?></p>
                                        <small class="text-muted"><?= date('F d, Y h:i A', strtotime($message['created_at'])) ?></small>
                                    </div>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <p>No messages yet. Start the conversation!</p>
                            <?php endif; ?>
                        </div>

                        <form method="POST" action="<?= BASE_URL . '/chat/send/' . $receiver['id'] ?>" class="mt-3">
                            <div class="input-group">
                                <textarea class="form-control" id="message" name="message" rows="3" required placeholder="Type your message..."></textarea>
                                <button class="btn btn-primary" type="submit">Send</button>
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
