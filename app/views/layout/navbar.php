<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container px-lg-5">
        <a class="navbar-brand" href="#!">CARS</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                <li class="nav-item"><a class="nav-link active" aria-current="page" href="#!">Home</a></li>
                <li class="nav-item"><a class="nav-link" href="#!">About</a></li>
                <li class="nav-item"><a class="nav-link" href="#!">Contact</a></li>
                <?php if (!isset($_SESSION['user'])): ?>
                    <li class="nav-item"><a class="nav-link" href="/cars/public/user/login">Login</a></li>
                    <li class="nav-item"><a class="nav-link" href="/cars/public/user/register">Register</a></li>
                <?php else: ?>
                    <li class="nav-item"><a class="nav-link" href="/cars/public/user/logout">Logout</a></li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</nav>
