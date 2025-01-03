<?php ob_start(); ?>
<main class="main-wrapper">
    <div class="login-section mt-115">
        <div class="container">
            <!-- Start User Event Area -->
            <div class="login-wrapper">
                <div class="section-content">
                    <h1 class="title"><?= __('Sign Up') ?></h1>
                </div>
                <form action="<?= BASE_URL . '/user/register'; ?>" method="POST" class="default-form-wrapper">
                    <ul class="default-form-list">
                        <li class="single-form-item">
                            <label for="username" class="visually-hidden"><?= __('Username') ?></label>
                            <input type="text" name="username" id="username" required>
                            <span class="icon"><i class="icon icon-carce-user"></i></span>
                            <p style="margin-top: -10px;font-size: 12px;" id="username-validation" class="validation-message"></p>
                        </li>
                        <li class="single-form-item">
                            <label for="email" class="visually-hidden"><?= __('Email') ?></label>
                            <input type="email" name="email" id="email" required>
                            <span class="icon"><i class="icon icon-carce-mail"></i></span>
                            <p style="margin-top: -10px;font-size: 12px;" id="email-validation" class="validation-message"></p>

                        </li>
                        <li class="single-form-item">
                            <label for="phone" class="visually-hidden"><?= __('Phone') ?></label>
                            <input type="text" name="phone" id="phone" required>
                            <span class="icon"><i class="icon icon-carce-phone"></i></span>
                            <p style="margin-top: -10px;font-size: 12px;" id="phone-validation" class="validation-message"></p>
                        </li>
                        <li class="single-form-item">
                            <label for="password" class="visually-hidden"><?= __('Password') ?></label>
                            <input type="password" name="password" id="password" required>
                            <span class="icon toggle-password"><i class="icon icon-carce-eye"></i></span>
                        </li>
                        <li class="single-form-item">
                            <label for="confirm_password" class="visually-hidden"><?= __('Confirm Password') ?></label>
                            <input type="password" name="confirm_password" id="confirm_password" required>
                            <span class="icon toggle-password"><i class="icon icon-carce-eye"></i></span>
                        </li>
                    </ul>
                    <button type="submit" style="width: 100%;margin-top: 5px;" class="btn btn--block btn--radius btn--size-xlarge btn--color-white btn--bg-maya-blue text-center register-space-top"><?= __('Sign Up') ?></button>
                </form>
            </div>
            <div class="sign-account-text text-center"> <?= __('Already have an account?') ?><a href="<?= BASE_URL . '/user/login'; ?>" class="btn--color-radical-red"><?= __('Sign In') ?></a></div>
        </div>
    </div>
</main>

<script>
    const validateUsername = () => {
        const usernameInput = document.getElementById('username');
        const usernameValidation = document.getElementById('username-validation');

        let timeout = null;

        usernameInput.addEventListener('input', () => {
            clearTimeout(timeout);
            usernameValidation.textContent = "<?= __('Validating...') ?>";
            usernameValidation.style.color = 'blue';

            timeout = setTimeout(() => {
                const value = usernameInput.value.trim();
                if (!value) {
                    usernameValidation.textContent = "<?= __('This field cannot be empty.') ?>";
                    usernameValidation.style.color = 'red';
                    return;
                }

                fetch('<?= BASE_URL ?>/user/validateUsername', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest'
                    },
                    body: JSON.stringify({ value: value })
                })
                    .then(response => {
                        if (!response.ok) throw response.json();
                        return response.json();
                    })
                    .then(data => {
                        if (data.error) {
                            usernameValidation.textContent = data.error;
                            usernameValidation.style.color = 'red';
                        } else {
                            usernameValidation.textContent = "<?= __('This value is available.') ?>";
                            usernameValidation.style.color = 'green';
                        }
                    })
                    .catch(async errorResponse => {
                        const error = await errorResponse;
                        usernameValidation.textContent = error.error || "<?= __('An unexpected error occurred. Please try again.') ?>";
                        usernameValidation.style.color = 'red';
                    });
            }, 2500);
        });
    };

    validateUsername();

    document.querySelector('.default-form-wrapper').addEventListener('submit', async (event) => {
        event.preventDefault();

        const emailInput = document.getElementById('email');
        const phoneInput = document.getElementById('phone');
        const emailValidation = document.getElementById('email-validation');
        const phoneValidation = document.getElementById('phone-validation');

        const validateFieldOnSubmit = async (input, apiUrl, validationElement) => {
            const value = input.value.trim();
            if (!value) {
                validationElement.textContent = "<?= __('This field cannot be empty.') ?>";
                validationElement.style.color = 'red';
                return false;
            }

            try {
                const response = await fetch(apiUrl, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest'
                    },
                    body: JSON.stringify({ value: value })
                });

                const data = await response.json();
                if (!response.ok || data.error) {
                    validationElement.textContent = data.error || "<?= __('Validation failed.') ?>";
                    validationElement.style.color = 'red';
                    return false;
                }

                validationElement.textContent = "<?= __('This value is available.') ?>";
                validationElement.style.color = 'green';
                return true;
            } catch (error) {
                validationElement.textContent = "<?= __('An unexpected error occurred. Please try again.') ?>";
                validationElement.style.color = 'red';
                return false;
            }
        };

        const isEmailValid = await validateFieldOnSubmit(emailInput, '<?= BASE_URL ?>/user/validateEmail', emailValidation);
        const isPhoneValid = await validateFieldOnSubmit(phoneInput, '<?= BASE_URL ?>/user/validatePhone', phoneValidation);

        const passwordInput = document.getElementById('password');
        const confirmPasswordInput = document.getElementById('confirm_password');
        const passwordValidationMessage = document.createElement('p');

        const existingMessage = document.getElementById('password-validation-message');
        if (existingMessage) existingMessage.remove();

        let isPasswordValid = true;

        if (passwordInput.value.length < 6) {
            isPasswordValid = false;
            passwordValidationMessage.id = 'password-validation-message';
            passwordValidationMessage.textContent = "<?= __('Password must be at least 6 characters long.') ?>";
            passwordValidationMessage.style.color = 'red';
            passwordValidationMessage.style.fontSize = '12px';
            passwordInput.parentElement.appendChild(passwordValidationMessage);
        }

        if (passwordInput.value !== confirmPasswordInput.value) {
            isPasswordValid = false;
            passwordValidationMessage.id = 'password-validation-message';
            passwordValidationMessage.textContent = "<?= __('Passwords do not match.') ?>";
            passwordValidationMessage.style.color = 'red';
            passwordValidationMessage.style.fontSize = '12px';
            confirmPasswordInput.parentElement.appendChild(passwordValidationMessage);
        }

        if (isEmailValid && isPhoneValid && isPasswordValid) {
            event.target.submit();
        }
    });

    const togglePasswordVisibility = () => {
        document.querySelectorAll('.toggle-password').forEach(toggle => {
            toggle.addEventListener('click', () => {
                const input = toggle.previousElementSibling;

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
require_once(VIEW . 'auth/auth-layout.php');
?>