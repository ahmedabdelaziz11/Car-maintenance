<?php ob_start(); ?>

<div class="container my-5">
    <h1 class="text-primary mb-4">Edit Offer</h1>
    <form action="<?= BASE_URL . '/offer/edit/' . $offer['id'] ?>" method="POST" enctype="multipart/form-data">
        <div class="form-group">
            <label for="title">Title</label>
            <input type="text" name="title" id="title" class="form-control" value="<?= $offer['title'] ?>" required>
        </div>
        
        <div class="form-group">
            <label for="details">Details</label>
            <textarea name="details" id="details" class="form-control" required><?= $offer['details'] ?></textarea>
        </div>

        <div class="form-group">
            <label for="service_id">Service</label>
            <select name="service_id" id="service_id" class="form-control" required>
                <option value="">Select Service</option>
                <?php foreach ($services as $service): ?>
                    <option value="<?= $service['id'] ?>" <?= $offer['service_id'] == $service['id'] ? 'selected' : '' ?>>
                        <?= $service['name'] ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="form-group">
            <label for="car_type_id">Car Type</label>
            <select name="car_type_id" id="car_type_id" class="form-control" required>
                <option value="">Select Car Type</option>
                <?php foreach ($carTypes as $carType): ?>
                    <option value="<?= $carType['id'] ?>" <?= $offer['car_type_id'] == $carType['id'] ? 'selected' : '' ?>>
                        <?= $carType['name'] ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="form-group">
            <label for="category_id">Category</label>
            <select name="category_id" id="category_id" class="form-control" required>
                <option value="">Select Category</option>
                <?php foreach ($categories as $category): ?>
                    <option value="<?= $category['id'] ?>" <?= $offer['category_id'] == $category['id'] ? 'selected' : '' ?>>
                        <?= $category['name'] ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="form-group">
            <label for="country_id">Country</label>
            <select name="country_id" id="country_id" class="form-control" required>
                <option value="">Select Country</option>
                <?php foreach ($countries as $country): ?>
                    <option value="<?= $country['id'] ?>"  <?= $offer['country_id'] == $country['id'] ? 'selected' : '' ?>><?= $country['name'] ?></option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="form-group">
            <label for="city_id">City</label>
            <select name="city_id" id="city_id" class="form-control" required>
                <option value="">Select City</option>
                <?php foreach ($cities as $city): ?>
                    <option value="<?= $city['id'] ?>" <?= $offer['city_id'] == $city['id'] ? 'selected' : '' ?>>
                        <?= $city['name'] ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="form-group">
            <label for="car_model_from">Car Model From</label>
            <select name="car_model_from" id="car_model_from" class="form-control" required>
                <option value="" disabled>Select Start Year</option>
            </select>
        </div>

        <div class="form-group">
            <label for="car_model_to">Car Model To</label>
            <select name="car_model_to" id="car_model_to" class="form-control" required>
                <option value="" disabled>Select End Year</option>
            </select>
        </div>
        <div id="yearError" style="color: red; display: none;">Start year must be less than or equal to the end year.</div>

        <div class="form-group">
            <label for="image">Image</label>
            <input type="file" name="image" id="image" class="form-control">
            <?php if (!empty($offer['image'])): ?>
                <img src="<?= BASE_URL . '/uploads/offers/' . $offer['image'] ?>" alt="Offer Image" style="width: 100px;">
            <?php endif; ?>
        </div>

        <div class="form-group">
            <label for="other_images">Other Images</label>
            <input type="file" name="other_images[]" id="other_images" class="form-control" multiple>
            <?php if (!empty($offer['other_images'])): ?>
                <?php foreach ($offer['other_images'] as $img): ?>
                    <img src="<?= BASE_URL . '/uploads/offers/' . $img['image'] ?>" alt="Other Image" style="width: 100px; margin: 5px;">
                <?php endforeach; ?>
            <?php endif; ?>
        </div>

        <div class="form-group">
            <label for="contact">Contact</label>
            <input type="text" name="contact" id="contact" class="form-control" value="<?= $offer['contact'] ?>" required>
        </div>

        <button type="submit" class="btn custom-btn-warning">Update</button>
    </form>
</div>

<script>
    document.getElementById('car_type_id').addEventListener('change', function() {
        var carTypeId = this.value;
        var categorySelect = document.getElementById('category_id');

        categorySelect.innerHTML = '<option value="">اختر الفئة</option>';

        if (carTypeId) {
            var xhr = new XMLHttpRequest();
            xhr.open('GET', '<?= BASE_URL ?>/offerDetails/getCategoriesByCarType/' + carTypeId, true);
            xhr.onload = function() {
                if (xhr.status === 200) {
                    var categories = JSON.parse(xhr.responseText);

                    categories.forEach(function(category) {
                        var option = document.createElement('option');
                        option.value = category.id;
                        option.textContent = category.name;
                        categorySelect.appendChild(option);
                    });
                }
            };
            xhr.send();
        }
    });
    document.getElementById('country_id').addEventListener('change', function() {
        var countryId = this.value;
        var citySelect = document.getElementById('city_id');

        citySelect.innerHTML = '<option value="">اختر المدينة</option>';

        if (countryId) {
            var xhr = new XMLHttpRequest();
            xhr.open('GET', '<?= BASE_URL ?>/offer/getCitiesByCountry/' + countryId, true);
            xhr.onload = function() {
                if (xhr.status === 200) {
                    var cities = JSON.parse(xhr.responseText);

                    cities.forEach(function(city) {
                        var option = document.createElement('option');
                        option.value = city.id;
                        option.textContent = city.name;
                        citySelect.appendChild(option);
                    });
                }
            };
            xhr.send();
        }
    });
    
    document.addEventListener('DOMContentLoaded', function () {
        const currentYear = new Date().getFullYear();
        const startYear = 1980;
        
        const carModelFrom = document.getElementById('car_model_from');
        const carModelTo = document.getElementById('car_model_to');
        const yearError = document.getElementById('yearError');

        const selectedFromYear = '<?= $offer['car_model_from'] ?>';
        const selectedToYear = '<?= $offer['car_model_to'] ?>';

        populateYearOptions(carModelFrom, startYear, currentYear, selectedFromYear);

        populateYearOptions(carModelTo, parseInt(selectedFromYear) + 1, currentYear, selectedToYear);

        carModelFrom.addEventListener('change', handleFromYearChange);
        carModelTo.addEventListener('change', validateYearSelection);

        function populateYearOptions(selectElement, start, end, selectedYear = null) {
            selectElement.innerHTML = '<option value="" disabled>اختر سنة</option>'; // Clear options
            for (let year = start; year <= end; year++) {
                let option = document.createElement('option');
                option.value = year;
                option.text = year;

                if (year == selectedYear) {
                    option.selected = true;
                }

                selectElement.appendChild(option);
            }
        }

        function handleFromYearChange() {
            const fromYear = parseInt(carModelFrom.value);
            if (!isNaN(fromYear)) {
                populateYearOptions(carModelTo, fromYear + 1, currentYear); // Update 'To' dropdown
                validateYearSelection();
            }
        }

        function validateYearSelection() {
            const fromYear = parseInt(carModelFrom.value);
            const toYear = parseInt(carModelTo.value);

            if (fromYear && toYear && fromYear > toYear) {
                yearError.style.display = 'block';
            } else {
                yearError.style.display = 'none';
            }
        }
    });
</script>
<?php 
$content = ob_get_clean(); 
require_once(VIEW . 'layout/master-2.php'); 
?>
