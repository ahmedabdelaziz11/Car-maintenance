<?php ob_start(); ?>

<div class="container my-5">
    <h1 class="text-primary mb-4"><?= __('Verify your phone number') ?></h1>
    <form id="verifyPhoneForm">
        <div class="form-group">
            <label for="otp"><?= __('OTP') ?></label>
            <input type="text" name="otp" id="otp" class="form-control" required>
        </div>

        <button type="submit" class="btn custom-btn-success"><?= __('Verify') ?></button>
    </form>
    <div id="responseMessage" class="mt-3"></div>
</div>

<script>
    document.getElementById('verifyPhoneForm').addEventListener('submit', function(event) {
        event.preventDefault(); 

        const formData = new FormData(this);

        fetch('<?= BASE_URL . "/home/verifyPhoneNumber" ?>', {
            method: 'POST',
            body: formData,
        })
        .then(response => response.json())
        .then(data => {
            const responseMessage = document.getElementById('responseMessage');

            if (data.success) {
                responseMessage.innerHTML = `<div class="alert alert-success">${data.message}</div>`;
                setTimeout(() => {
                    window.location.href = data.redirectUrl || '<?= BASE_URL ?>';
                }, 2000);
            } else {
                responseMessage.innerHTML = `<div class="alert alert-danger">${data.message}</div>`;
            }
        })
        .catch(error => {
            console.error('Error:', error);
            document.getElementById('responseMessage').innerHTML = `<div class="alert alert-danger">An error occurred while verifying your phone number.</div>`;
        });
    });
</script>

<?php
$content = ob_get_clean();
require_once(VIEW . 'layout/master-2.php');
?>
