<?php ob_start(); ?>
<div class="offcanvas-overlay"></div>
<div class="container">
    <?php if (isset($_SESSION['user']) && $_SESSION['user']['is_phone_verified'] == 0) : ?>
        <div class="search-box product-item--style-4 mb-2" style="display: flex; justify-content: space-between;">
            <p> <?= __('Verify your phone number') ?> </p>
            <a href="<?= BASE_URL . '/home/verifyPhoneNumberView' ?>" class="custom-btn-success"><?= __('Verify') ?></a>
        </div>
    <?php endif; ?>
    <?php if (isset($_SESSION['user']) && $_SESSION['user']['is_email_verified'] == 0) : ?>
        <div class="search-box product-item--style-4 mb-2" style="display: flex; justify-content: space-between;">
            <p> <?= __('Verify your email number') ?> </p>
            <a href="<?= BASE_URL . '/home/verifyEmailView' ?>" class="custom-btn-success"><?= __('Verify') ?></a>
        </div>
    <?php endif; ?>
    <div class="search-n-filter-area">
        <div class="search-box product-item--style-4">
            <div style="width: 100%" class="">
                <form style="width: 100%" method="GET" id="search-form" action="<?= BASE_URL . '/home/index' ?>">
                    <div style="width: 100%" class="container">
                        <div class="catagories-wrapper">
                            <div class="catagories-wrapper-content ">
                                <div class="single-product-item product-item--style-2">
                                    <select id="service_id" name="service_id" class="custom-select">
                                        <option value=""><?= __('Select Service') ?></option>
                                        <?php foreach ($services as $service): ?>
                                            <option value="<?= $service['id']; ?>" <?= isset($_GET['service_id']) && $_GET['service_id'] == $service['id'] ? 'selected' : '' ?>>
                                                <?= $service['name']; ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div class="single-product-item product-item--style-2">
                                    <select name="car_type_id" id="car_type_id" class="custom-select">
                                        <option value=""><?= __('Select Car Type') ?></option>
                                        <?php foreach ($carTypes as $carType): ?>
                                            <option value="<?= $carType['id'] ?>"><?= $carType['name'] ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div class="single-product-item product-item--style-2">
                                    <select id="category_id" name="category_id" class="custom-select">
                                        <option value=""><?= __('Select Category') ?></option>
                                    </select>
                                </div>
                                <div class="single-product-item product-item--style-2">
                                    <select id="country_id" name="country_id" class="custom-select">
                                        <option value=""><?= __('Select Country') ?></option>
                                        <?php foreach ($countries as $country): ?>
                                            <option value="<?= $country['id'] ?>"><?= $country['name'] ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div class="single-product-item product-item--style-2">
                                    <select id="model_from" name="model_from" class="custom-select">
                                        <option value="" selected><?= __('Choose Model') ?></option>
                                    </select>
                                </div>
                                <div class="single-product-item product-item--style-2">
                                    <?php if (isset($_SESSION['user'])): ?>
                                        <?php if (isset($is_follow) && $is_follow): ?>
                                            <button type="button" id="follow-button" style="width:100%" class="custom-btn">Unfollow</button>
                                        <?php else : ?>
                                            <button type="button" id="follow-button" style="width:100%" class="custom-btn-success">Follow</button>
                                        <?php endif; ?>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="search-box mt-2">
        <a href="<?= BASE_URL . '/offer/create' ?>" class="btn-primary custom-btn m-1 text-center" style="width:100%"><?= __('Create New Offer') ?></a>
    </div>
</div>



<div class="catagories-section section-gap-top-25 elements">

</div>


<script>
    function toggleFavorite(offerId, button) {
        const isFavorite = button.getAttribute('data-favorite') === 'true';

        fetch('<?= BASE_URL . "/offer/favorite/" ?>' + offerId, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: JSON.stringify({
                    favorite: !isFavorite
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    button.setAttribute('data-favorite', !isFavorite);
                    button.style.color = !isFavorite ? 'crimson' : 'gray';
                }
            })
            .catch(error => {
                console.error('Error:', error);
            });
    }

    document.querySelectorAll('.favorite-btn').forEach(button => {
        button.addEventListener('click', function() {
            const offerId = this.getAttribute('data-offer-id'); 
            toggleFavorite(offerId, this); 
        });
    });

    const followButton = document.getElementById('follow-button');
    if (followButton) {
        setButtonColor(followButton.textContent.trim());

        followButton.addEventListener('click', function() {
            const form = document.getElementById('search-form');
            const queryString = serializeForm(form);
            const action = followButton.textContent.trim() === 'Follow' ? 'follow' : 'unfollow';
            const url = `<?= BASE_URL ?>/home/index?${queryString}&action=${action}`;

            fetch(url, {
                    method: 'GET',
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        const newText = action === 'follow' ? 'Unfollow' : 'Follow';
                        followButton.textContent = newText;
                        setButtonColor(newText);
                    } else {
                        alert('Failed to update follow status.');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('An error occurred. Please try again.');
                });
        });
    }

    function setButtonColor(actionText) {
        if (actionText === 'Unfollow') {
            followButton.style.backgroundColor = 'green';
            followButton.style.color = 'white';
            followButton.style.borderColor = 'green';
        } else {
            followButton.style.backgroundColor = 'gray';
            followButton.style.color = 'white';
            followButton.style.borderColor = 'gray';
        }
    }

    function fetchOffers(page = 1, pushState = false) {
        const form = document.querySelector('form');
        const queryString = serializeForm(form);
        const url = `<?= BASE_URL ?>/home/index?${queryString}&page=${page}`;

        fetch(url, {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(response => response.text())
            .then(html => {
                document.querySelector('.elements').innerHTML = html;
                const isFollowInput = document.getElementById('is-follow-status');
                if (isFollowInput) {
                    const isFollow = isFollowInput.value === '1';
                    const followButton = document.getElementById('follow-button');
                    followButton.textContent = isFollow ? 'Unfollow' : 'Follow';
                    if (isFollow) {
                        followButton.classList.remove('custom-btn-success');
                        followButton.classList.add('custom-btn');
                    } else {
                        followButton.classList.remove('custom-btn');
                        followButton.classList.add('custom-btn-success');
                    }
                }
                attachPaginationListeners();
            })
            .catch(console.error);
    }

    function serializeForm(form) {
        const formData = new FormData(form);
        return new URLSearchParams([...formData.entries()]).toString();
    }

    function debounce(func, wait = 300) {
        let timeout;
        return function(...args) {
            clearTimeout(timeout);
            timeout = setTimeout(() => func.apply(this, args), wait);
        };
    }

    function attachInputListeners() {
        const formInputs = document.querySelectorAll('#search-form input, #search-form select');

        formInputs.forEach(input => {
            input.addEventListener('input', debounce(() => {
                fetchOffers();
            }));
        });
    }

    document.getElementById('car_type_id').addEventListener('change', function() {
        const carTypeId = this.value;
        const categorySelect = document.getElementById('category_id');
        categorySelect.innerHTML = '<option value="">Select Category</option>';

        if (carTypeId) {
            fetch(`<?= BASE_URL ?>/offerDetails/getCategoriesByCarType/${carTypeId}`)
                .then(response => response.json())
                .then(categories => {
                    categories.forEach(category => {
                        const option = document.createElement('option');
                        option.value = category.id;
                        option.textContent = category.name;
                        categorySelect.appendChild(option);
                    });
                    fetchOffers();
                });
        } else {
            fetchOffers();
        }
    });

    function attachPaginationListeners() {
        document.querySelectorAll('.pagination-link').forEach(link => {
            link.addEventListener('click', event => {
                event.preventDefault();
                const page = link.getAttribute('data-page');
                if (!link.closest('li').classList.contains('disabled')) {
                    fetchOffers(page, true);
                }
            });
        });
    }

    window.addEventListener('popstate', () => {
        const page = new URLSearchParams(window.location.search).get('page') || 1;
        fetchOffers(page);
    });

    document.addEventListener('DOMContentLoaded', () => {
        const page = new URLSearchParams(window.location.search).get('page') || 1;
        fetchOffers(page);
        attachInputListeners();
        attachPaginationListeners();
    });

    window.addEventListener('popstate', () => {
        const page = new URLSearchParams(window.location.search).get('page') || 1;
        fetchOffers(page);
    });

    document.addEventListener('DOMContentLoaded', () => {
        const page = new URLSearchParams(window.location.search).get('page') || 1;
        fetchOffers(page);
    });

    document.querySelector('form').addEventListener('submit', event => {
        event.preventDefault();
        fetchOffers();
    });

    attachPaginationListeners();


    document.addEventListener('DOMContentLoaded', function() {
        const currentYear = new Date().getFullYear();
        const startYear = 1980;
        const carModelFrom = document.getElementById('model_from');

        function populateYearOptions(selectElement) {
            for (let year = startYear; year <= currentYear; year++) {
                let option = document.createElement('option');
                option.value = year;
                option.text = year;
                selectElement.appendChild(option);
            }
        }
        populateYearOptions(carModelFrom);
    });
</script>

<?php require_once(VIEW . 'partials/share-modal.php'); ?>


<?php
$content = ob_get_clean();
require_once(VIEW . 'layout/master-2.php');
?>