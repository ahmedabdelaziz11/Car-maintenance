<?php ob_start(); ?>

<div class="contact-section section-gap-top-30">
    <div class="container">
        <div class="section-title">
            <h2><?= __('Contact Us') ?></h2>
        </div>
        <form method="POST" action="<?= BASE_URL . '/contact/create'; ?>" class="default-form-wrapper">
            <ul class="default-form-list">
                <li class="single-form-item">
                    <label for="contact_type" class="visually-hidden"><?= __('Contact Type') ?></label>
                    <select id="contact_type" name="contact_type" class="form-control">
                        <option value="Complaint"><?= __('Complaint') ?></option>
                        <option value="Suggestion"><?= __('Suggestion') ?></option>
                        <option value="Inquiry"><?= __('Inquiry') ?></option>
                    </select>
                </li>

                <li class="single-form-item">
                    <label for="title" class="visually-hidden"><?= __('Title') ?></label>
                    <input id="title" name="title" type="text" class="form-control" placeholder="Type your title here..." required>
                </li>

                <li class="single-form-item">
                    <label for="message" class="visually-hidden"><?= __('Message') ?></label>
                    <textarea id="message" name="message" class="form-control" placeholder="Type your message here..." required></textarea>
                </li>

                <li class="single-form-item text-center">
                    <button type="submit" class="custom-btn-success"><?= __('Send') ?></button>
                </li>
            </ul>
        </form>
    </div>
</div>

<?php $content = ob_get_clean(); ?>
<?php require_once(VIEW . 'layout/master-2.php'); ?>
