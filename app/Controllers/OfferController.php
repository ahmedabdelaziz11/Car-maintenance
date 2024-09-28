<?php

namespace MVC\controllers;

use MVC\Traits\ImageUploaderTrait;
use MVC\core\controller;
use MVC\core\Session;
use MVC\models\category;
use MVC\models\offer;
use MVC\models\offerComment;
use MVC\models\offerImage;
use MVC\models\service;

class OfferController extends controller{
    use ImageUploaderTrait;

    public function __construct()
    {
        if(!Session::Get('user'))
        {
            header('Location: ' . BASE_URL . '/user/login');
            exit;
        }
    }

    public function index()
    {
        $offer = new offer();
        $offers = $offer->getAll();
        $this->view('offers/index', ['offers' => $offers]);
    }

    public function create()
    {
        $serviceModel = new Service();
        $categoryModel = new Category();
        $services = $serviceModel->getAll();
        $categories = $categoryModel->getAll();
    
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $errors = $this->validateCreateRequest();
    
            if (empty($errors)) {
                $uploadedImage = $this->uploadImage($_FILES['image'], ROOT . 'public/uploads/offers/');
    
                $data = [
                    'title' => $_POST['title'],
                    'details' => $_POST['details'],
                    'date' => date("Y-m-d"),
                    'user_id' => $_SESSION['user']['id'],
                    'service_id' => $_POST['service_id'],
                    'category_id' => $_POST['category_id'],
                    'car_model_from' => $_POST['car_model_from'],
                    'car_model_to' => $_POST['car_model_to'],
                    'image' => $uploadedImage,
                    'contact' => $_POST['contact'],
                    'is_active' => 1
                ];
    
                $offerModel = new Offer();
                $offerId = $offerModel->create($data);
    
                if (!empty($_FILES['other_images']['name'][0])) {
                    $uploadedImages = $this->uploadImages($_FILES['other_images'], ROOT . 'public/uploads/offers/');
                
                    foreach ($uploadedImages as $uploadedImage) {
                        $offerImageModel = new offerImage();
                        $offerImageModel->create([
                            'offer_id' => $offerId, 
                            'image' => $uploadedImage
                        ]);
                    }
                }
                header('Location: ' . BASE_URL . '/offer');
                exit;
            } else {
                $errorMessage = implode("<br>", $errors);
                $this->view('offers/create', [
                    'services' => $services,
                    'categories' => $categories,
                    'errorMessage' => $errorMessage
                ]);
            }
        }
    
        $this->view('offers/create', ['services' => $services, 'categories' => $categories]);
    }
    
    public function edit($id)
    {
        $offerModel = new offer();
        $serviceModel = new service();
        $categoryModel = new category();
    
        $offer = $offerModel->getById($id);
    
        $services = $serviceModel->getAll();
        $categories = $categoryModel->getAll();
    
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $errors = $this->validateEditRequest();
            if (empty($errors)) {
                $data = [
                    'id' => $id,
                    'title' => $_POST['title'],
                    'details' => $_POST['details'],
                    'user_id' => $_SESSION['user']['id'],
                    'service_id' => $_POST['service_id'],
                    'category_id' => $_POST['category_id'],
                    'car_model_from' => $_POST['car_model_from'],
                    'car_model_to' => $_POST['car_model_to'],
                    'contact' => $_POST['contact'],
                    'is_active' => 1
                ];
    
                if (!empty($_FILES['other_images']['name'][0])) {
                    foreach ($offer['other_images'] as $img) {
                        $oldImagePath = ROOT . 'public/uploads/offers/' . $img['image'];
                        if (file_exists($oldImagePath)) {
                            unlink($oldImagePath);
                        }
                        $offerImageModel = new offerImage();
                        $offerImageModel->deleteRow($img['id']);
                    }
                    $uploadedImages = $this->uploadImages($_FILES['other_images'], ROOT . 'public/uploads/offers/');
                
                    foreach ($uploadedImages as $uploadedImage) {
                        $offerImageModel = new offerImage();
                        $offerImageModel->create([
                            'offer_id' => $id, 
                            'image' => $uploadedImage
                        ]);
                    }
                }    
    
                $offerModel->updateRow($data);
    
                header('Location: ' . BASE_URL . '/offer');
                exit;
            } else {
                $errorMessage = implode("<br>", $errors);
                $this->view('offers/edit', [
                    'services' => $services,
                    'categories' => $categories,
                    'errorMessage' => $errorMessage,
                    'offer' => $offer
                ]);
            }
        }
    
        $this->view('offers/edit', [
            'services' => $services,
            'categories' => $categories,
            'offer' => $offer
        ]);
    }

    public function details($id)
    {
        $offerModel = new offer();
        $offerCommentModel = new offerComment();
        $offer = $offerModel->getById($id);

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $comment = $_POST['comment'] ?? '';
    
            if (!empty($comment)) {
                $offerCommentModel->create([
                    'offer_id' => $id,
                    'user_id' => $_SESSION['user']['id'],
                    'date' => date('Y-m-d'),
                    'comment' => $_POST['comment'],
                ]);
                header('Location: ' . BASE_URL . '/offer/details/' . $id);
                exit;
            }
        }
    
        $this->view('offers/show', [
            'offer' => $offer
        ]);
    }
    

    public function delete($id)
    {
        $offerModel = new offer();
        $offer = $offerModel->getById($id);
        $oldImagePath = ROOT . 'public/uploads/offers/' . $offer['image'];
        if (file_exists($oldImagePath)) {
            unlink($oldImagePath);
        }

        foreach ($offer['other_images'] as $img) {
            $oldImagePath = ROOT . 'public/uploads/offers/' . $img['image'];
            if (file_exists($oldImagePath)) {
                unlink($oldImagePath);
            }
            $offerImageModel = new offerImage();
            $offerImageModel->deleteRow($img['id']);
        }
        $offerModel->deleteRow($id);
        header('Location: ' . BASE_URL . '/offer');
        exit;
    }

    public function validateCreateRequest()
    {
        $errors = [];
        
        if (empty($_POST['title'])) {
            $errors[] = 'العنوان مطلوب.';
        }
        
        if (empty($_POST['details'])) {
            $errors[] = 'الوصف مطلوب.';
        }
    
        if (empty($_POST['service_id'])) {
            $errors[] = 'معرف الخدمة مطلوب.';
        } else {
            $serviceModel = new Service();
            if (!$serviceModel->getById($_POST['service_id'])) {
                $errors[] = 'الخدمة غير موجودة.';
            }
        }
    
        if (empty($_POST['category_id'])) {
            $errors[] = 'معرف الفئة مطلوب.';
        } else {
            $categoryModel = new Category();
            if (!$categoryModel->getById($_POST['category_id'])) {
                $errors[] = 'الفئة غير موجودة.';
            }
        }
    
        if (empty($_POST['car_model_from'])) {
            $errors[] = 'سنة بدء السيارة مطلوبة.';
        }
    
        if (empty($_POST['car_model_to'])) {
            $errors[] = 'سنة انتهاء السيارة مطلوبة.';
        }
    
        if (!empty($_POST['car_model_from']) && !empty($_POST['car_model_to'])) {
            if ($_POST['car_model_from'] > $_POST['car_model_to']) {
                $errors[] = 'سنة بدء السيارة يجب أن تكون أقل من أو تساوي سنة انتهاء السيارة.';
            }
        }
    
        if (empty($_POST['contact'])) {
            $errors[] = 'جهة الاتصال مطلوبة.';
        }
    
        if (empty($_FILES['image']['name'])) {
            $errors[] = 'الصورة مطلوبة.';
        } else {
            $imageErrors = $this->validateImage($_FILES['image']);
            if (!empty($imageErrors)) {
                $errors = array_merge($errors, $imageErrors);
            }
        }

        if (!empty($_FILES['other_images']['name'][0])) {
            foreach ($_FILES['other_images']['name'] as $key => $imageName) {
                if ($_FILES['other_images']['error'][$key] === UPLOAD_ERR_OK) {
                    $imageErrors = $this->validateImage([
                        'name' => $_FILES['other_images']['name'][$key],
                        'type' => $_FILES['other_images']['type'][$key],
                        'tmp_name' => $_FILES['other_images']['tmp_name'][$key],
                        'error' => $_FILES['other_images']['error'][$key],
                        'size' => $_FILES['other_images']['size'][$key],
                    ]);
                    
                    if (!empty($imageErrors)) {
                        $errors = array_merge($errors, $imageErrors);
                    }
                } else {
                    $errors[] = 'خطأ في تحميل الصورة رقم ' . ($key + 1) . '.';
                }
            }
        }
    
        return $errors;
    }    

    public function validateEditRequest()
    {
        $errors = [];
        
        if (empty($_POST['title'])) {
            $errors[] = 'العنوان مطلوب.';
        }
        
        if (empty($_POST['details'])) {
            $errors[] = 'الوصف مطلوب.';
        }
    
        if (empty($_POST['service_id'])) {
            $errors[] = 'معرف الخدمة مطلوب.';
        } else {
            $serviceModel = new Service();
            if (!$serviceModel->getById($_POST['service_id'])) {
                $errors[] = 'الخدمة غير موجودة.';
            }
        }
    
        if (empty($_POST['category_id'])) {
            $errors[] = 'معرف الفئة مطلوب.';
        } else {
            $categoryModel = new Category();
            if (!$categoryModel->getById($_POST['category_id'])) {
                $errors[] = 'الفئة غير موجودة.';
            }
        }
    
        if (empty($_POST['car_model_from'])) {
            $errors[] = 'سنة بدء السيارة مطلوبة.';
        }
    
        if (empty($_POST['car_model_to'])) {
            $errors[] = 'سنة انتهاء السيارة مطلوبة.';
        }
    
        if (!empty($_POST['car_model_from']) && !empty($_POST['car_model_to'])) {
            if ($_POST['car_model_from'] > $_POST['car_model_to']) {
                $errors[] = 'سنة بدء السيارة يجب أن تكون أقل من أو تساوي سنة انتهاء السيارة.';
            }
        }
    
        if (empty($_POST['contact'])) {
            $errors[] = 'جهة الاتصال مطلوبة.';
        }
    
        if (!empty($_FILES['image']['name'])) {        
            $imageErrors = $this->validateImage($_FILES['image']);
            if (!empty($imageErrors)) {
                $errors = array_merge($errors, $imageErrors);
            }
        }

        if (!empty($_FILES['other_images']['name'][0])) {
            foreach ($_FILES['other_images']['name'] as $key => $imageName) {
                if ($_FILES['other_images']['error'][$key] === UPLOAD_ERR_OK) {
                    $imageErrors = $this->validateImage([
                        'name' => $_FILES['other_images']['name'][$key],
                        'type' => $_FILES['other_images']['type'][$key],
                        'tmp_name' => $_FILES['other_images']['tmp_name'][$key],
                        'error' => $_FILES['other_images']['error'][$key],
                        'size' => $_FILES['other_images']['size'][$key],
                    ]);
                    
                    if (!empty($imageErrors)) {
                        $errors = array_merge($errors, $imageErrors);
                    }
                } else {
                    $errors[] = 'خطأ في تحميل الصورة رقم ' . ($key + 1) . '.';
                }
            }
        }
    
        return $errors;
    }
}