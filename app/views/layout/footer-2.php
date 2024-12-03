<?php
    use MVC\core\notifications;
    use MVC\models\chat;
    $notifications = notifications::userNotifications();
    $chat          = new chat();
    $unreadCount = count(array_filter($notifications, fn($n) => $n['is_read'] == 0));
    $unreadMessages = $chat->getUnreadMessages();
?>
<div class="user-event-section">
    <div class="col pos-relative">
        <div class="user-event-area">
            <div class="user-event user-event--left">
                <a area-label="event link icon" href="<?= BASE_URL . '/'; ?>" class="event-btn-link"><i
                class="icon icon-carce-home"></i></a>
                <a area-label="wishlist icon" href="<?= BASE_URL . '/favorite'; ?>" class="event-btn-link"><i
                class="icon icon-carce-heart"></i></a>
            </div>
            <div class="user-event user-event--center">
                <a area-label="event link icon" href="<?= BASE_URL . '/offer'; ?>" class="event-btn-link"><i
                class="icon icon-carce-plus"></i></a>
            </div>
            <div class="user-event user-event--right">
                <a aria-label="order icon" href="<?= BASE_URL . '/notification'; ?>" class="event-btn-link" style="display: flex; align-items: center; text-decoration: none; color: inherit;">
                    <i class="icon icon-carce-bell" style="margin-right: 5px;"></i>
                    <span style="font-size: 14px; color: <?= $unreadCount > 0 ? '#ff375f' : '#000'; ?>;">
                        <?= $unreadCount ?>
                    </span>
                </a>
                <a aria-label="chat icon" href="<?= BASE_URL . '/chat/index/'; ?>" class="event-btn-link" style="display: flex; align-items: center; text-decoration: none; color: inherit;">
                    <i class="icon icon-carce-bubbles2" style="margin-right: 5px;"></i>
                    <span style="font-size: 14px; color: <?= $unreadMessages > 0 ? '#ff375f' : '#000'; ?>;">
                        <?= $unreadMessages ?>
                    </span>
                </a>
            </div>
        </div>
    </div>
</div>
<footer class="footer-section"></footer>