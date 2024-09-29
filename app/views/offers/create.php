<?php ob_start(); ?>

<h1>إنشاء عرض جديد</h1>
<form action="<?= BASE_URL . '/offer/create' ?>" method="POST" enctype="multipart/form-data">
    <div class="form-group">
        <label for="title">العنوان</label>
        <input type="text" name="title" id="title" class="form-control" required>
    </div>
    
    <div class="form-group">
        <label for="details">التفاصيل</label>
        <textarea name="details" id="details" class="form-control" required></textarea>
    </div>
    
    <div class="form-group">
        <label for="service_id">الخدمة</label>
        <select name="service_id" id="service_id" class="form-control" required>
            <option value="">اختر الخدمة</option>
            <?php foreach ($services as $service): ?>
                <option value="<?= $service['id'] ?>"><?= $service['name'] ?></option>
            <?php endforeach; ?>
        </select>
    </div>

    <div class="form-group">
        <label for="car_type_id">نوع السيارة</label>
        <select name="car_type_id" id="car_type_id" class="form-control" required>
            <option value="">اختر نوع السيارة</option>
            <?php foreach ($carTypes as $carType): ?>
                <option value="<?= $carType['id'] ?>"><?= $carType['name'] ?></option>
            <?php endforeach; ?>
        </select>
    </div>

    <div class="form-group">
        <label for="category_id">الفئة</label>
        <select name="category_id" id="category_id" class="form-control" required>
            <option value="">اختر الفئة</option>
        </select>
    </div>
    
    <div class="form-group">
        <label for="car_model_from">نموذج السيارة من</label>
        <input type="number" name="car_model_from" id="car_model_from" class="form-control" min="1900" max="2099" placeholder="2010" required>
    </div>
    
    <div class="form-group">
        <label for="car_model_to">نموذج السيارة إلى</label>
        <input type="number" name="car_model_to" id="car_model_to" class="form-control" min="1900" max="2099" placeholder="2020" required>
    </div>

    <div class="form-group">
        <label for="image">الصورة الرئيسية</label>
        <input type="file" name="image" id="image" class="form-control" required>
    </div>

    <div class="form-group">
        <label for="images">صور اخرى</label>
        <input type="file" name="other_images[]" id="other_images" class="form-control" multiple>
    </div>
    
    <div class="form-group">
        <label for="contact">جهة الاتصال</label>
        <input type="text" name="contact" id="contact" class="form-control" required>
    </div>
    
    <button type="submit" class="btn btn-success">إنشاء</button>
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
