<?php ob_start(); ?>
    <main class="main-wrapper">
        <div class="login-section">
            <div class="container">
                <div class="login-wrapper">
                    <div class="section-content">
                        <h1 class="title">Welcome Back</h1>
                        <p>Login with your account to continue.</p>
                    </div>
                    <form action="<?= BASE_URL . '/user/login'; ?>" method="POST" class="default-form-wrapper">
                        <ul class="default-form-list">
                            <li class="single-form-item">
                                <label for="email" class="visually-hidden">Email</label>
                                <input type="email" name="email" placeholder="email">
                                <span class="icon"><i class="icon icon-carce-user"></i></span>
                            </li>
                            <li class="single-form-item">
                                <label for="password" class="visually-hidden">Password</label>
                                <input type="password" name="password" placeholder="password">
                                <span class="icon"><i class="icon icon-carce-eye"></i></span>
                            </li>
                        </ul>
                        <button type="submit" style="width: 100%;margin-top: 10px;" class="btn btn--block btn--radius btn--size-xlarge btn--color-white btn--bg-maya-blue text-center">LogIn</button>
                    </form>

                </div>
                <div class="create-account-text text-center">Don't have an account? <a href="<?= BASE_URL . '/user/register'; ?>" class="btn--color-radical-red">Create now</a></div>
                <div class="page-progress-wrapper">
                    <a href="<?= BASE_URL . '/user/register'; ?>" class="btn--center btn--round btn--size-58-58 btn--color-white btn--radical-red progress-btn progress-btn--50"><i class="icon icon-carce-ios-arrow-forward"></i></a>
                </div>
            </div>
        </div>
    </main>
<?php 
$content = ob_get_clean();
require_once(VIEW . 'auth/auth-layout.php');
?>
