<?php ob_start(); ?>
<main class="main-wrapper">
    <div class="forgot-password-section">
        <div class="container">
            <div class="forgot-password-wrapper">
                <div class="section-content">
                    <h1 class="title"><?= __('Forgot Your Password ?') ?></h1>
                    <p><?= __('Enter your email address, and we will send you an OTP to reset your password.') ?></p>
                </div>

                <form id="email-form" action="<?= BASE_URL . '/user/send-otp'; ?>" method="POST" class="default-form-wrapper">
                    <ul class="default-form-list">
                        <li class="single-form-item">
                            <label for="email" class="visually-hidden"><?= __('Email Address') ?></label>
                            <input type="email" name="email" id="email" placeholder="<?= __('Email Address') ?>" required>
                        </li>
                    </ul>
                    <button type="submit" style="width: 100%; margin-top: 10px;" class="btn btn--block btn--radius btn--size-xlarge btn--color-white btn--bg-maya-blue text-center"><?= __('Send OTP') ?></button>
                </form>

                <form id="otp-form" action="<?= BASE_URL . '/user/resetPassword'; ?>" method="POST" class="default-form-wrapper" style="display: none;">
                    <ul class="default-form-list">
                        <li class="single-form-item">
                            <label for="otp" class="visually-hidden"><?= __('OTP') ?></label>
                            <input type="text" name="otp" id="otp" placeholder="<?= __('Enter OTP') ?>" required>
                        </li>
                        <li class="single-form-item">
                            <label for="new-password" class="visually-hidden"><?= __('New Password') ?></label>
                            <input type="password" name="new-password" id="new-password" placeholder="<?= __('New Password') ?>" required>
                        </li>
                        <li class="single-form-item">
                            <label for="confirm-password" class="visually-hidden"><?= __('Confirm Password') ?></label>
                            <input type="password" name="confirm-password" id="confirm-password" placeholder="<?= __('Confirm Password') ?>" required>
                        </li>
                    </ul>
                    <button type="submit" style="width: 100%; margin-top: 10px;" class="btn btn--block btn--radius btn--size-xlarge btn--color-white btn--bg-maya-blue text-center"><?= __('Reset Password') ?></button>
                </form>
            </div>
        </div>
    </div>
</main>

<script>
document.getElementById('email-form').addEventListener('submit', function(event) {
    event.preventDefault();

    const email = document.getElementById('email').value;
    fetch('<?= BASE_URL . '/user/sendOtp'; ?>', {
        method: 'POST',
        body: new URLSearchParams({
            email: email
        }),
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            document.getElementById('email-form').style.display = 'none';
            document.getElementById('otp-form').style.display = 'block';
        } else {
            alert('Failed to send OTP. Please try again.');
        }
    });
});
</script>

<?php
$content = ob_get_clean();
require_once(VIEW . 'layout/master-2.php');
?>
