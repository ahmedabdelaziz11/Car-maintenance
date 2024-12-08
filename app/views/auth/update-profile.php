<?php ob_start(); ?>
<main class="main-wrapper">
    <div class="login-section mt-115">
        <div class="container">
            <!-- Start User Event Area -->
            <div class="login-wrapper">
                <div class="section-content">
                    <h1 class="title"><?= __('Profile Update') ?></h1>
                </div>
                <form action="<?= BASE_URL . '/user/updateProfile'; ?>" method="POST" class="default-form-wrapper">
                    <ul class="default-form-list">
                        <li class="single-form-item">
                            <label for="username" class="visually-hidden"><?= __('Username') ?></label>
                            <input type="text" name="username" id="username" value="<?= $_SESSION['user']['name']?>" required>
                            <span class="icon"><i class="icon icon-carce-user"></i></span>
                            <p style="margin-top: -10px;font-size: 12px;" id="username-validation" class="validation-message"></p>
                        </li>
                        <li class="single-form-item">
                            <label for="email" class="visually-hidden"><?= __('Email') ?></label>
                            <input type="email" name="email" id="email" value="<?= $_SESSION['user']['email']?>" required>
                            <span class="icon"><i class="icon icon-carce-mail"></i></span>
                            <p style="margin-top: -10px;font-size: 12px;" id="email-validation" class="validation-message"></p>

                        </li>
                        <li class="single-form-item">
                            <label for="phone" class="visually-hidden"><?= __('Phone') ?></label>
                            <input type="text" name="phone" id="phone" value="<?= $_SESSION['user']['phone']?>" required>
                            <span class="icon"><i class="icon icon-carce-phone"></i></span>
                            <p style="margin-top: -10px;font-size: 12px;" id="phone-validation" class="validation-message"></p>
                        </li>
                        <li class="single-form-item">
                            <label for="password" class="visually-hidden"><?= __('Password') ?></label>
                            <input type="password" name="password" id="password">
                            <span class="icon toggle-password"><i class="icon icon-carce-eye"></i></span>
                        </li>
                        <li class="single-form-item">
                            <label for="confirm_password" class="visually-hidden"><?= __('Confirm Password') ?></label>
                            <input type="password" name="confirm_password" id="confirm_password">
                            <span class="icon toggle-password"><i class="icon icon-carce-eye"></i></span>
                        </li>
                    </ul>
                    <button type="submit" style="width: 100%;margin-top: 5px;" class="btn btn--block btn--radius btn--size-xlarge btn--color-white btn--bg-maya-blue text-center register-space-top"><?= __('Update') ?></button>
                </form>
            </div>
        </div>
    </div>
</main>

<script>
    const validateField = (inputId, apiUrl, validationId) => {
        const inputElement = document.getElementById(inputId);
        const validationElement = document.getElementById(validationId);

        let timeout = null; 

        inputElement.addEventListener('input', () => {
            clearTimeout(timeout); 
            validationElement.textContent = 'Validating...'; 
            validationElement.style.color = 'blue';

            timeout = setTimeout(() => {
                const value = inputElement.value.trim();
                if (!value) {
                    validationElement.textContent = `${inputId.charAt(0).toUpperCase() + inputId.slice(1)} cannot be empty.`;
                    validationElement.style.color = 'red';
                    return;
                }

                fetch(apiUrl, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest'
                    },
                    body: JSON.stringify({ value: value })
                })
                    .then(response => {
                        if (!response.ok) throw new Error('Network response was not ok');
                        return response.json();
                    })
                    .then(data => {
                        if (data.exists) {
                            validationElement.textContent = `${inputId.charAt(0).toUpperCase() + inputId.slice(1)} is already taken.`;
                            validationElement.style.color = 'red';
                        } else {
                            validationElement.textContent = `${inputId.charAt(0).toUpperCase() + inputId.slice(1)} is available.`;
                            validationElement.style.color = 'green';
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        validationElement.textContent = 'Error validating field. Please try again.';
                        validationElement.style.color = 'red';
                    });
            }, 2500); 
        });
    };

    validateField('username', '<?= BASE_URL ?>/user/validateUsername', 'username-validation');
    validateField('email', '<?= BASE_URL ?>/user/validateEmail', 'email-validation');
    validateField('phone', '<?= BASE_URL ?>/user/validatePhone', 'phone-validation');

    const togglePasswordVisibility = () => {
        document.querySelectorAll('.toggle-password').forEach(toggle => {
            toggle.addEventListener('click', () => {
                const input = toggle.previousElementSibling;
                const icon = toggle.querySelector('i');

                if (input.type === 'password') {
                    input.type = 'text';
                } else {
                    input.type = 'password';
                }
            });
        });
    };

    togglePasswordVisibility();
</script>

<?php
$content = ob_get_clean();
require_once(VIEW . 'layout/master-2.php');
?>