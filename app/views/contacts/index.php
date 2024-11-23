<?php ob_start(); ?>

<div class="conversations-section section-gap-top-30">
    <div class="container">
        <div class="section-title">
            <h2>All Conversations</h2>
        </div>
        <div class="button-wrapper mb-4">
            <a href="<?= BASE_URL . '/contact/create'; ?>" class="custom-btn-success">New Conversation</a>
        </div>

        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>User ID</th>
                        <th>User Name</th>
                        <th>Contact Type</th>
                        <th>Message</th>
                        <th>Unread Messages</th>
                        <th>Created At</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($conversations)): ?>
                        <?php foreach ($conversations as $conversation): ?>
                            <tr>
                                <td><?= htmlspecialchars($conversation['user_id']) ?></td>
                                <td><?= htmlspecialchars($conversation['user_name']) ?></td>
                                <td><?= htmlspecialchars($conversation['contact_type']) ?></td>
                                <td><?= htmlspecialchars($conversation['message']) ?></td>
                                <td class="<?= $conversation['unread_count'] > 0 ? 'text-danger' : 'text-success'; ?>">
                                    <?= $conversation['unread_count'] ?> unread
                                </td>
                                <td><?= htmlspecialchars($conversation['created_at']) ?></td>
                                <td>
                                    <a href="<?= BASE_URL . '/contact/show/' . htmlspecialchars($conversation['id']); ?>" class="custom-btn-secondary">
                                        View
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="7" class="text-center">No conversations found.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php $content = ob_get_clean(); ?>
<?php require_once(VIEW . 'layout/master-2.php'); ?>
