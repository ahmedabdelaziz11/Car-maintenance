<?php

namespace MVC\Traits;

trait ImageUploaderTrait
{
    protected $maxImageSize = 2 * 1024 * 1024; // 2MB
    protected $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif'];

    public function validateImage($image)
    {
        $errors = [];

        if (empty($image['name'])) {
            $errors[] = 'صورة الخدمة مطلوبة';
        } else {
            $fileInfo = pathinfo($image['name']);
            $extension = strtolower($fileInfo['extension']);

            if (!in_array($extension, $this->allowedExtensions)) {
                $errors[] = 'نوع الصورة غير صالح. يُسمح فقط بالصيغ JPG وJPEG وPNG وGIF.';
            }
            if ($image['size'] > $this->maxImageSize) {
                $errors[] = 'لا يمكن ان يتخطى حجم الصورة 2 ميجا بايت';
            }
        }

        return $errors;
    }

    public function uploadImage($image, $uploadDirectory)
    {
        $uniqueId = uniqid('', true) . '_' . mt_rand(1000, 9999);
        $fileInfo = pathinfo($image['name']);
        $extension = strtolower($fileInfo['extension']);
        $newFileName = $uniqueId . '.' . $extension;

        $destination = $uploadDirectory . $newFileName;

        if (move_uploaded_file($image['tmp_name'], $destination)) {
            return $newFileName;
        }

        return false;
    }

    public function uploadImages($images, $uploadDirectory)
    {
        $uploadedFiles = [];

        foreach ($images['name'] as $key => $imageName) {
            if ($images['error'][$key] === UPLOAD_ERR_OK) {
                $uniqueId = uniqid('', true) . '_' . mt_rand(1000, 9999);
                $fileInfo = pathinfo($imageName);
                $extension = strtolower($fileInfo['extension']);
                $newFileName = $uniqueId . '.' . $extension;

                $destination = $uploadDirectory . $newFileName;

                if (move_uploaded_file($images['tmp_name'][$key], $destination)) {
                    $uploadedFiles[] = $newFileName;
                }
            }
        }

        return $uploadedFiles;
    }
}
