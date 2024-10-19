<?php ob_start(); ?>

<form method="GET" id="search-form" action="<?= BASE_URL . '/home/index' ?>">
    <div class="form-row row">
        <div class="col-md-3">
            <label for="service_id">Service</label>
            <select class="form-control" id="service_id" name="service_id">
                <option value="">Select Service</option>
                <?php foreach ($services as $service): ?>
                    <option value="<?= $service['id']; ?>" <?= isset($_GET['service_id']) && $_GET['service_id'] == $service['id'] ? 'selected' : '' ?>>
                        <?= $service['name']; ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="col-md-3">
            <label for="category_id">car type</label>
            <select name="car_type_id" id="car_type_id" class="form-control">
                <option value="">select car type</option>
                <?php foreach ($carTypes as $carType): ?>
                    <option value="<?= $carType['id'] ?>"><?= $carType['name'] ?></option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="col-md-3">
            <label for="category_id">Category</label>
            <select class="form-control" id="category_id" name="category_id">
                <option value="">Select Category</option>
            </select>
        </div>

        <div class="col-md-3">
            <label for="model_from">Model From</label>
            <input type="text" class="form-control" id="model_from" name="model_from" placeholder="Model From" value="<?= $_GET['model_from'] ?? '' ?>">
        </div>

        <div class="col-md-3">
            <label for="model_to">Model To</label>
            <input type="text" class="form-control" id="model_to" name="model_to" placeholder="Model To" value="<?= $_GET['model_to'] ?? '' ?>">
        </div>

        <div class="form-group col-md-3 mt-4">
            <button type="submit" name="action" value="search" class="btn btn-primary">Search</button>
            <?php if (isset($_SESSION['user'])): ?>
                <button type="button" id="follow-button" class="btn btn-secondary">Follow</button>
            <?php endif; ?>
        </div>
    </div>
</form>


<div class="row elements mt-4">
    <?php foreach ($offers as $offer): ?>
        <div class="col-md-4">
            <div class="card mb-4">
                <a href="<?= BASE_URL . '/offer/details/' . $offer['id'] ?>">
                    <img src="<?= BASE_URL . '/uploads/offers/' . $offer['image'] ?>" class="card-img-top" alt="<?= $offer['title'] ?>">
                </a>
                <div class="card-body">
                    <h5 class="card-title"><?= $offer['title'] ?></h5>
                    <p class="card-text"><?= $offer['details'] ?></p>
                    <p><strong>Service:</strong> <?= $offer['service_name'] ?></p>
                    <p><strong>car type:</strong> <?= $offer['car_type_name'] ?></p>
                    <p><strong>Category:</strong> <?= $offer['category_name'] ?></p>
                    <p><strong>Car Model:</strong> <?= $offer['car_model_from'] ?> - <?= $offer['car_model_to'] ?></p>
                    <p><strong>Country:</strong> <?= $offer['country_name'] ?></p>
                    <p><strong>City :</strong> <?= $offer['city_name'] ?></p>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
    <?php require_once(VIEW . 'pagination-links.php'); ?>
</div>

<script>
    const followButton = document.getElementById('follow-button');
    if (followButton) {
        document.getElementById('follow-button').addEventListener('click', function () {
            const form = document.querySelector('form');
            const queryString = serializeForm(form);
            const url = `<?= BASE_URL ?>/home/index?${queryString}&action=follow`;

            fetch(url, {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert('You are now following this service.');
                } else {
                    alert('Failed to follow. Maybe you are already following this service.');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('An error occurred. Please try again.');
            });
        });
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
            fetch(`<?= BASE_URL ?>/offer/getCategoriesByCarType/${carTypeId}`)
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
</script>


<?php
$content = ob_get_clean();
require_once(VIEW . 'layout/master.php');
?>