<?php

use MVC\core\session;

ob_start(); ?>

<div class="container mt-5">
    <h1 class="mb-4"><?= __('Chat with') ?> <?= htmlspecialchars($receiver['name']) ?></h1>
    <div class="card">
        <div class="card-body">
            <div class="chat-box" style="height: 300px; overflow-y: auto; border: 1px solid #ddd; padding: 15px; background-color: #f5f5f5; border-radius: 8px;">
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

            <div class="input-group">
                <textarea class="form-control" id="message" name="message" rows="2" required placeholder="Type your message..." style="border-radius: 0; border: 1px solid #ddd;"></textarea>
                <button id="sendButton" class="custom-btn" type="button" style="border-radius: 0;">
                    <i class="fas fa-paper-plane"></i> <?= __('Send') ?>
                </button>
            </div>
        </div>
    </div>
</div>
<script>
    document.getElementById('sendButton').addEventListener('click', function() {
        const messageBox = document.getElementById('message');
        const message = messageBox.value.trim();
        if (message === '') return;

        const xhr = new XMLHttpRequest();
        xhr.open('POST', '<?= BASE_URL . "/chat/send/" . $receiver["id"] ?>', true);
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        xhr.onload = function() {
            if (xhr.status === 200) {
                const response = JSON.parse(xhr.responseText);
                if (response.status === 'success') {
                    const chatBox = document.querySelector('.chat-box');
                    const messageDiv = document.createElement('div');
                    messageDiv.className = 'message mb-3 text-end';
                    messageDiv.innerHTML = `
                        <div class="d-inline-block p-2 bg-primary text-white" style="border-radius: 12px; max-width: 80%;">
                            <strong>You:</strong>
                            <p class="mb-1">${response.message}</p>
                            <small class="text-muted">${response.created_at}</small>
                        </div>
                    `;
                    chatBox.appendChild(messageDiv);
                    chatBox.scrollTop = chatBox.scrollHeight;
                    messageBox.value = ''; 
                } else {
                    alert(response.message);
                }
            } else {
                alert('Error sending message.');
            }
        };
        xhr.send('message=' + encodeURIComponent(message));
    });

    let typingTimeout;
    const chatBox = document.querySelector('.chat-box');
    const receiverId = <?= json_encode($receiver['id']) ?>;

    function updateChat() {
        const xhr = new XMLHttpRequest();
        xhr.open('GET', '<?= BASE_URL . "/chat/getMessages/" ?>' + receiverId, true);
        xhr.onload = function() {
            if (xhr.status === 200) {
                const response = JSON.parse(xhr.responseText);
                if (response.status === 'success') {
                    chatBox.innerHTML = '';
                    response.messages.forEach(message => {
                        const isSender = message.sender_id === <?= json_encode(session::get('user')['id']) ?>;
                        const messageDiv = document.createElement('div');
                        messageDiv.className = `message mb-3 ${isSender ? 'text-end' : 'text-start'}`;
                        messageDiv.innerHTML = `
                            <div class="d-inline-block p-2 ${isSender ? 'bg-primary text-white' : 'bg-light text-dark'}" style="border-radius: 12px; max-width: 80%;">
                                <strong>${isSender ? 'You' : <?= json_encode($receiver['name']) ?>}:</strong>
                                <p class="mb-1">${message.message}</p>
                                <small class="text-muted">${new Date(message.created_at).toLocaleString()}</small>
                            </div>
                        `;
                        chatBox.appendChild(messageDiv);
                    });
                    chatBox.scrollTop = chatBox.scrollHeight; 
                }
            }
        };
        xhr.send();
    }

    const messageBox = document.getElementById('message');
    messageBox.addEventListener('input', () => {
        clearTimeout(typingTimeout);
        typingTimeout = setTimeout(() => {
            updateChat();
        }, 1000);
    });

    setInterval(updateChat, 10000); 

    function scrollToBottom() {
        const chatBox = document.querySelector('.chat-box');
        chatBox.scrollTop = chatBox.scrollHeight;
    }

    window.onload = scrollToBottom;
</script>

<?php
$content = ob_get_clean();
require_once(VIEW . 'layout/master-2.php');
?>
