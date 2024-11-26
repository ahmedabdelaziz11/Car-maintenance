<?php ob_start(); ?>
    <main class="main-wrapper">
        <div class="login-section mt-115">
            <div class="container">
                <!-- Start User Event Area -->
                <div class="login-wrapper">
                    <div class="section-content">
                        <h1 class="title"><?= __('Sign Up') ?></h1>
                        <p><?= __('Signup is simply dummy text of the printing and typesetting industry.') ?></p>
                    </div>
                    <form action="<?= BASE_URL . '/user/register'; ?>" method="POST" class="default-form-wrapper">
                        <ul class="default-form-list">
                            <li class="single-form-item">
                                <label for="name" class="visually-hidden"><?= __('Name') ?></label>
                                <input type="text" name="name" required>
                                <span class="icon"><i class="icon icon-carce-user"></i></span>
                            </li>
                            <li class="single-form-item">
                                <label for="email" class="visually-hidden"><?= __('Email') ?></label>
                                <input type="email" name="email" required>
                                <span class="icon"><i class="icon icon-carce-mail"></i></span>
                            </li>
                            <li class="single-form-item">
                                <label for="password" class="visually-hidden"><?= __('Password') ?></label>
                                <input type="password" name="password" required>
                                <span class="icon"><i class="icon icon-carce-eye"></i></span>
                            </li>
                        </ul>
                        <button type="submit" style="width: 100%;margin-top: 5px;" class="btn btn--block btn--radius btn--size-xlarge btn--color-white btn--bg-maya-blue text-center register-space-top"><?= __('Sign Up') ?></button>
                    </form>
                </div>

                <div class="sign-account-text text-center"> <?= __('Already have an account?') ?><a href="<?= BASE_URL . '/user/login'; ?>" class="btn--color-radical-red"><?= __('Sign Up') ?></a></div>
                <div class="page-progress-wrapper">
                    <a href="<?= BASE_URL . '/user/login'; ?>" class="btn--center btn--round btn--size-58-58 btn--color-white btn--radical-red progress-btn progress-btn--100"><i
                            class="icon icon-carce-ios-arrow-forward"></i></a>
                </div>
            </div>
        </div>
    </main>
<?php 
$content = ob_get_clean();
require_once(VIEW . 'auth/auth-layout.php');
?>