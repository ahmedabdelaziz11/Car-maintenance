<?php ob_start(); ?>

<h1>تعديل العرض</h1>
<form action="<?= BASE_URL . '/offer/edit/' . $offer['id'] ?>" method="POST" enctype="multipart/form-data">
    <div class="form-group">
        <label for="title">العنوان</label>
        <input type="text" name="title" id="title" class="form-control" value="<?= $offer['title'] ?>">
    </div>
    
    <div class="form-group">
        <label for="details">التفاصيل</label>
        <textarea name="details" id="details" class="form-control"><?= $offer['details'] ?></textarea>
    </div>

    <div class="form-group">
        <label for="service_id">الخدمة</label>
        <select name="service_id" id="service_id" class="form-control">
            <option value="">اختر الخدمة</option>
            <?php foreach ($services as $service): ?>
                <option value="<?= $service['id'] ?>" <?= $offer['service_id'] == $service['id'] ? 'selected' : '' ?>>
                    <?= $service['name'] ?>
                </option>
            <?php endforeach; ?>
        </select>
    </div>

    <div class="form-group">
        <label for="car_type_id">نوع السيارة</label>
        <select name="car_type_id" id="car_type_id" class="form-control">
            <option value="">اختر نوع السيارة</option>
            <?php foreach ($carTypes as $carType): ?>
                <option value="<?= $carType['id'] ?>" <?= $offer['car_type_id'] == $carType['id'] ? 'selected' : '' ?>>
                    <?= $carType['name'] ?>
                </option>
            <?php endforeach; ?>
        </select>
    </div>

    <div class="form-group">
        <label for="category_id">الفئة</label>
        <select name="category_id" id="category_id" class="form-control">
            <option value="">اختر الفئة</option>
            <?php foreach ($categories as $category): ?>
                <option value="<?= $category['id'] ?>" <?= $offer['category_id'] == $category['id'] ? 'selected' : '' ?>>
                    <?= $category['name'] ?>
                </option>
            <?php endforeach; ?>
        </select>
    </div>

    <div class="form-group">
        <label for="car_model_from">نموذج السيارة من</label>
        <input type="number" name="car_model_from" id="car_model_from" class="form-control" value="<?= $offer['car_model_from'] ?>" placeholder="السنة (مثل 2010)">
    </div>

    <div class="form-group">
        <label for="car_model_to">نموذج السيارة إلى</label>
        <input type="number" name="car_model_to" id="car_model_to" class="form-control" value="<?= $offer['car_model_to'] ?>" placeholder="السنة (مثل 2020)">
    </div>

    <div class="form-group">
        <label for="contact">جهة الاتصال</label>
        <input type="text" name="contact" id="contact" class="form-control" value="<?= $offer['contact'] ?>" placeholder="أدخل تفاصيل جهة الاتصال">
    </div>

    <div class="form-group">
        <label for="image">الصورة</label>
        <input type="file" name="image" id="image" class="form-control">
        <?php if (!empty($offer['image'])): ?>
            <img src="<?= BASE_URL . '/uploads/offers/' . $offer['image'] ?>" alt="صورة العرض" style="width: 100px;">
        <?php endif; ?>
    </div>

    <div class="form-group">
        <label for="other_images">صور أخرى</label>
        <input type="file" name="other_images[]" id="other_images" class="form-control" multiple>
        <?php if (!empty($offer['other_images'])): ?>
            <?php foreach ($offer['other_images'] as $img): ?>
                <img src="<?= BASE_URL . '/uploads/offers/' . $img['image'] ?>" alt="صورة أخرى" style="width: 100px; margin: 5px;">
            <?php endforeach; ?>
        <?php endif; ?>
    </div>

    <button type="submit" class="btn btn-warning">تحديث</button>
</form>

<script>
document.getElementById('car_type_id').addEventListener('change', function() {
    var carTypeId = this.value;
    var categorySelect = document.getElementById('category_id');

    categorySelect.innerHTML = '<option value="">اختر الفئة</option>';

    if (carTypeId) {
        var xhr = new XMLHttpRequest();
        xhr.open('GET', '<?= BASE_URL ?>/offer/getCategoriesByCarType/' + carTypeId, true);
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

</script>

<?php 
$content = ob_get_clean(); 
require_once(VIEW . 'layout/master.php'); 
?>
