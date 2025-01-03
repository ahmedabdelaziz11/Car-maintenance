<?php ob_start(); ?>

<div class="container my-5">
    <h1 class="text-primary mb-4"><?= __('Edit Offer') ?></h1>
    <form action="<?= BASE_URL . '/offer/edit/' . $offer['id'] ?>" method="POST" enctype="multipart/form-data">
        <div class="form-group">
            <label for="title"><?= __('Title') ?></label>
            <input type="text" name="title" id="title" class="form-control" value="<?= $offer['title'] ?>" required>
        </div>

        <div class="form-group">
            <label for="details"><?= __('Details') ?></label>
            <textarea name="details" id="details" class="form-control" required><?= $offer['details'] ?></textarea>
        </div>

        <div class="form-group">
            <label for="service_id"><?= __('Service') ?></label>
            <select name="service_id" id="service_id" class="form-control" required>
                <option value=""><?= __('Select Service') ?></option>
                <?php foreach ($services as $service): ?>
                    <option value="<?= $service['id'] ?>" <?= $offer['service_id'] == $service['id'] ? 'selected' : '' ?>>
                        <?= $service['name'] ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="form-group">
            <label for="car_type_id"><?= __('Car Type') ?></label>
            <select name="car_type_id" id="car_type_id" class="form-control" required>
                <option value=""><?= __('Select Car Type') ?></option>
                <?php foreach ($carTypes as $carType): ?>
                    <option value="<?= $carType['id'] ?>" <?= $offer['car_type_id'] == $carType['id'] ? 'selected' : '' ?>>
                        <?= $carType['name'] ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="form-group">
            <label for="category_id"><?= __('Category') ?></label>
            <select name="category_id" id="category_id" class="form-control" required>
                <option value=""><?= __('Select Category') ?></option>
                <?php foreach ($categories as $category): ?>
                    <option value="<?= $category['id'] ?>" <?= $offer['category_id'] == $category['id'] ? 'selected' : '' ?>>
                        <?= $category['name'] ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="form-group">
            <label for="country_id"><?= __('Country') ?></label>
            <select name="country_id" id="country_id" class="form-control" required>
                <option value=""><?= __('Select Country') ?></option>
                <?php foreach ($countries as $country): ?>
                    <option value="<?= $country['id'] ?>" <?= $offer['country_id'] == $country['id'] ? 'selected' : '' ?>><?= $country['name'] ?></option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="form-group">
            <label for="city_id"><?= __('City') ?></label>
            <select name="city_id" id="city_id" class="form-control" required>
                <option value=""><?= __('Select City') ?></option>
                <?php foreach ($cities as $city): ?>
                    <option value="<?= $city['id'] ?>" <?= $offer['city_id'] == $city['id'] ? 'selected' : '' ?>>
                        <?= $city['name'] ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="form-group">
            <label for="car_model_from"><?= __('Car Model From') ?></label>
            <select name="car_model_from" id="car_model_from" class="form-control" required>
                <option value="" disabled><?= __('Select Start Year') ?></option>
            </select>
        </div>

        <div class="form-group">
            <label for="car_model_to"><?= __('Car Model To') ?></label>
            <select name="car_model_to" id="car_model_to" class="form-control" required>
                <option value="" disabled><?= __('Select End Year') ?></option>
            </select>
        </div>
        <div id="yearError" style="color: red; display: none;"><?= __('Start year must be less than or equal to the end year.') ?></div>

        <div class="form-group">
            <label for="other_images"><?= __('Other Images') ?></label>
            <input type="file" id="file-selector" class="form-control" multiple>
            <br>
            <ul id="file-list"></ul>
            <br>
        </div>

        <div id="file-hidden-inputs"></div>

        <div class="form-group">
            <label for="contact"><?= __('Contact') ?></label>
            <input type="text" name="contact" id="contact" class="form-control" value="<?= $offer['contact'] ?>" required>
        </div>

        <button type="submit" class="btn custom-btn-warning" id="submitButton"><?= __('Update') ?></button>
    </form>
</div>

<script>
    document.querySelector('form').addEventListener('submit', function(event) {
        const submitButton = this.querySelector('[type="submit"]');
        if (submitButton.disabled) {
            event.preventDefault();
            return;
        }
        submitButton.disabled = true;
        submitButton.textContent = "<?= __('Submitting...') ?>";
    });
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

    document.addEventListener('DOMContentLoaded', function() {
        const currentYear = new Date().getFullYear();
        const startYear = 1980;

        const carModelFrom = document.getElementById('car_model_from');
        const carModelTo = document.getElementById('car_model_to');
        const yearError = document.getElementById('yearError');

        const selectedFromYear = '<?= $offer['car_model_from'] ?>';
        const selectedToYear = '<?= $offer['car_model_to'] ?>';

        populateYearOptions(carModelFrom, startYear, currentYear, selectedFromYear);

        populateYearOptions(carModelTo, parseInt(selectedFromYear), currentYear, selectedToYear);

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


        const fileSelector = document.getElementById('file-selector');
        const fileList = document.getElementById('file-list');
        let files = [];

        <?php if (!empty($offer['other_images'])): ?>
            const existingImages = <?php echo json_encode($offer['other_images']); ?>;

            const fetchImage = (img, index) => {
                const imageUrl = `<?= BASE_URL . '/uploads/offers/' ?>${img.image}`;
                return fetch(imageUrl)
                    .then(response => {
                        if (!response.ok) {
                            throw new Error(`Failed to fetch image: ${imageUrl}`);
                        }
                        return response.blob();
                    })
                    .then(blob => {
                        const file = new File([blob], `image_${index}.jpg`, {
                            type: blob.type
                        });
                        return file;
                    });
            };

            // Use Promise.all to ensure order is maintained
            Promise.all(existingImages.map((img, index) => fetchImage(img, index)))
                .then(filesArray => {
                    filesArray.forEach(file => {
                        files.push(file);
                    });
                    updateFileList();
                })
                .catch(error => {
                    console.error('Error fetching images:', error);
                });
        <?php endif; ?>


        fileSelector.addEventListener('change', function(event) {
            for (let i = 0; i < event.target.files.length; i++) {
                files.push(event.target.files[i]);
            }
            updateFileList();
        });

        function updateFileList() {
            fileList.innerHTML = '';
            files.forEach((file, index) => {
                const listItem = document.createElement('li');
                listItem.className = 'd-flex justify-content-between align-items-center mb-2';

                const thumbnail = document.createElement('img');
                thumbnail.src = URL.createObjectURL(file);
                thumbnail.alt = file.name;
                thumbnail.style.width = '80px';
                thumbnail.style.height = 'auto';
                thumbnail.style.marginRight = '10px';

                const removeButton = document.createElement('button');
                removeButton.textContent = 'Remove';
                removeButton.className = 'btn custom-btn-danger btn-sm';
                removeButton.addEventListener('click', function() {
                    files.splice(index, 1);
                    updateFileList();
                });

                const upButton = document.createElement('button');
                upButton.textContent = 'Up';
                upButton.className = 'btn btn-sm custom-btn-secondary mr-2';
                upButton.disabled = index === 0;
                upButton.addEventListener('click', function() {
                    moveImage(index, index - 1);
                });

                const downButton = document.createElement('button');
                downButton.textContent = 'Down';
                downButton.className = 'btn btn-sm custom-btn-secondary';
                downButton.disabled = index === files.length - 1;
                downButton.addEventListener('click', function() {
                    moveImage(index, index + 1);
                });

                listItem.appendChild(thumbnail);
                listItem.appendChild(removeButton);
                listItem.appendChild(upButton);
                listItem.appendChild(downButton);
                fileList.appendChild(listItem);
            });
        }

        function moveImage(fromIndex, toIndex) {
            const [movedImage] = files.splice(fromIndex, 1);
            files.splice(toIndex, 0, movedImage);
            updateFileList();
        }

        document.querySelector('form').addEventListener('submit', function(event) {
            const fileInput = document.createElement('input');
            fileInput.type = 'file';
            fileInput.name = 'other_images[]';
            fileInput.multiple = true;
            fileInput.style.display = 'none';
            const dataTransfer = new DataTransfer();
            files.forEach(file => {
                dataTransfer.items.add(file);
            });
            fileInput.files = dataTransfer.files;
            event.target.appendChild(fileInput);
            files.forEach((file, index) => {
                const orderInput = document.createElement('input');
                orderInput.type = 'hidden';
                orderInput.name = 'image_order[]';
                orderInput.value = index + 1;

                event.target.appendChild(orderInput);
            });
        });
    });
</script>
<?php
$content = ob_get_clean();
require_once(VIEW . 'layout/master-2.php');
?>