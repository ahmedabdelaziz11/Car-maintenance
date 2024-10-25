<?php ob_start(); ?>

<h1 style="font-size: 24px; margin-bottom: 20px;">All Conversations</h1>
<a href="<?= BASE_URL . '/contact/create'; ?>" style="
    display: inline-block;
    background-color: #28a745;
    color: #fff;
    text-decoration: none;
    padding: 10px 15px;
    border-radius: 5px;
    margin-bottom: 20px;
    font-size: 14px;
">New Conversation</a>

<table style="width: 100%; border-collapse: collapse;">
    <thead>
        <tr style="background-color: #f4f4f4; border-bottom: 2px solid #ddd;">
            <th style="padding: 10px; text-align: left;">User ID</th>
            <th style="padding: 10px; text-align: left;">User Name</th>
            <th style="padding: 10px; text-align: left;">Contact Type</th>
            <th style="padding: 10px; text-align: left;">Message</th>
            <th style="padding: 10px; text-align: left;">Unread Messages</th>
            <th style="padding: 10px; text-align: left;">Created At</th>
            <th style="padding: 10px; text-align: left;">Action</th>
        </tr>
    </thead>
    <tbody>
        <?php if (!empty($conversations)): ?>
            <?php foreach ($conversations as $conversation): ?>
                <tr style="border-bottom: 1px solid #ddd;">
                    <td style="padding: 10px;"><?= htmlspecialchars($conversation['user_id']) ?></td>
                    <td style="padding: 10px;"><?= htmlspecialchars($conversation['user_name']) ?></td>
                    <td style="padding: 10px;"><?= htmlspecialchars($conversation['contact_type']) ?></td>
                    <td style="padding: 10px;"><?= htmlspecialchars($conversation['message']) ?></td>
                    <td style="padding: 10px; color: <?= $conversation['unread_count'] > 0 ? 'red' : 'green' ?>;">
                        <?= $conversation['unread_count'] ?> unread
                    </td>
                    <td style="padding: 10px;"><?= htmlspecialchars($conversation['created_at']) ?></td>
                    <td style="padding: 10px;">
                        <a href="<?= BASE_URL . '/contact/show/' . htmlspecialchars($conversation['id']); ?>" style="
                            background-color: #007bff;
                            color: #fff;
                            text-decoration: none;
                            padding: 5px 10px;
                            border-radius: 5px;
                        ">View Conversation</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr>
                <td colspan="6" style="padding: 10px; text-align: center;">No conversations found.</td>
            </tr>
        <?php endif; ?>
    </tbody>
</table>

<?php $content = ob_get_clean(); ?>
<?php require_once(VIEW . 'layout/master.php'); ?>
