<?php

namespace MVC\controllers;

use MVC\Traits\ImageUploaderTrait;
use MVC\core\controller;
use MVC\core\session;
use MVC\models\carType;
use MVC\models\category;
use MVC\models\city;
use MVC\models\country;
use MVC\models\favorite;
use MVC\models\follow;
use MVC\models\notification;
use MVC\models\offer;
use MVC\models\offerImage;
use MVC\models\service;
use MVC\models\userFollow;

class OfferController extends controller{
    use ImageUploaderTrait;

    public function __construct()
    {
        if(!session::Get('user'))
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
        $serviceModel  = new service();
        $categoryModel = new category();
        $carTypeModel  = new carType();
        $countryModel  = new country();
        $services   = $serviceModel->getAll();
        $carTypes   = $carTypeModel->getAll();
        $categories = $categoryModel->getAll();
        $countries  = $countryModel->getAll();
    
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
                    'car_type_id' => $_POST['car_type_id'],
                    'country_id' => $_POST['country_id'],
                    'city_id' => $_POST['city_id'],
                    'car_model_from' => $_POST['car_model_from'],
                    'car_model_to' => $_POST['car_model_to'],
                    'image' => $uploadedImage,
                    'contact' => $_POST['contact'],
                    'is_active' => 1
                ];
    
                $offerModel = new Offer();
                $followModel = new follow();
                $userFollowModel = new userFollow();
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
                $userIdsFollowsOffer = $followModel->getUserIdsFollowsOffer($_POST['service_id'],$_POST['category_id']);
                foreach($userIdsFollowsOffer as $row)
                {
                    $notificationModel = new notification();
                    $notificationModel->create([
                        'offer_id' => $offerId,
                        'user_id'  => $row['user_id'],
                        'date'     => date('Y-m-d H:i:s'),
                        'message'  => 'عرض جديد من العروض التي تتابعها',
                    ]);
                } 
                $userFollowers = $userFollowModel->getFollowers($_SESSION['user']['id']);
                foreach($userFollowers as $row)
                {
                    $notificationModel = new notification();
                    $notificationModel->create([
                        'offer_id' => $offerId,
                        'user_id'  => $row['follower_id'],
                        'date'     => date('Y-m-d H:i:s'),
                        'message'  => 'عرض جديد من المستخدميين التي تتابعها',
                    ]);
                } 
                header('Location: ' . BASE_URL . '/offer');
                exit;
            } else {
                $errorMessage = implode("<br>", $errors);
                $this->view('offers/create', [
                    'services' => $services,
                    'categories' => $categories,
                    'countries' => $countries,
                    'carTypes' => $carTypes,
                    'errorMessage' => $errorMessage
                ]);
            }
        }
    
        $this->view('offers/create', ['services' => $services, 'categories' => $categories,'carTypes' => $carTypes,'countries' => $countries]);
    }
    
    public function edit($id)
    {
        $countryModel  = new country();
        $offerModel = new offer();
        $serviceModel = new service();
        $categoryModel = new category();
        $carTypeModel = new CarType();
        $cityModel = new city();
        
        $offer      = $offerModel->getById($id);
        $services   = $serviceModel->getAll();
        $carTypes   = $carTypeModel->getAll();
        $countries  = $countryModel->getAll();
        $cities     = $cityModel->getAll();

        $categories = $categoryModel->categoryByCarTypeId($offer['car_type_id']);
    
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $errors = $this->validateEditRequest();
            if (empty($errors)) {
                $data = [
                    'id' => $id,
                    'title' => $_POST['title'],
                    'details' => $_POST['details'],
                    'user_id' => $_SESSION['user']['id'],
                    'service_id' => $_POST['service_id'],
                    'car_type_id' => $_POST['car_type_id'],
                    'category_id' => $_POST['category_id'],
                    'country_id' => $_POST['country_id'],
                    'city_id' => $_POST['city_id'],
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
                    'carTypes' => $carTypes,
                    'categories' => $categories,
                    'errorMessage' => $errorMessage,
                    'offer' => $offer,
                    'cities' => $cities,
                    'countries' => $countries,
                ]);
            }
        }
    
        $this->view('offers/edit', [
            'services' => $services,
            'carTypes' => $carTypes,
            'categories' => $categories,
            'offer' => $offer,
            'cities' => $cities,
            'countries' => $countries,
        ]);
    }

    public function getCitiesByCountry($countryId)
    {
        $cityModel = new city();
        $cities = $cityModel->cityByCountryId($countryId);

        echo json_encode($cities);
    }

    public function favorite($offer_id)
    {
        $favoriteModel = new favorite();
        $favoriteModel->toggleFavorite($offer_id);
        $response = ['success' => true];
        echo json_encode($response);
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
        header('Location: ' . $_SERVER['HTTP_REFERER']);
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
    
        if (empty($_POST['car_type_id'])) {
            $errors[] = 'نوع السيارة مطلوب.';
        } else {
            $carTypeModel = new CarType();
            if (!$carTypeModel->getById($_POST['car_type_id'])) {
                $errors[] = 'نوع السيارة غير موجود.';
            }
        }
    
        if (empty($_POST['category_id'])) {
            $errors[] = 'معرف الفئة مطلوب.';
        } else {
            $categoryModel = new Category();
            
            if (!$categoryModel->checkCategoryWithCarType($_POST['category_id'], $_POST['car_type_id'])) {
                $errors[] = 'الفئة غير متاحة لنوع السيارة المختار.';
            }
        }

        if (empty($_POST['country_id'])) {
            $errors[] = 'البلد مطلوب.';
        } else {
            $countryModel = new country();
            if (!$countryModel->getById($_POST['country_id'])) {
                $errors[] = 'البلد غير موجود.';
            }
        }
    
        if (empty($_POST['city_id'])) {
            $errors[] = 'المدينة مطلوبة';
        } else {
            $cityModel = new city();
            
            if (!$cityModel->checkCityWithCountry($_POST['city_id'], $_POST['country_id'])) {
                $errors[] = 'المدينة غير متاحة للبلد المختار.';
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

        if (empty($_POST['car_type_id'])) {
            $errors[] = 'نوع السيارة مطلوب.';
        } else {
            $carTypeModel = new CarType();
            if (!$carTypeModel->getById($_POST['car_type_id'])) {
                $errors[] = 'نوع السيارة غير موجود.';
            }
        }
    
        if (empty($_POST['category_id'])) {
            $errors[] = 'معرف الفئة مطلوب.';
        } else {
            $categoryModel = new Category();
            
            if (!$categoryModel->checkCategoryWithCarType($_POST['category_id'], $_POST['car_type_id'])) {
                $errors[] = 'الفئة غير متاحة لنوع السيارة المختار.';
            }
        }

        if (empty($_POST['country_id'])) {
            $errors[] = 'البلد مطلوب.';
        } else {
            $countryModel = new country();
            if (!$countryModel->getById($_POST['country_id'])) {
                $errors[] = 'البلد غير موجود.';
            }
        }
    
        if (empty($_POST['city_id'])) {
            $errors[] = 'المدينة مطلوبة';
        } else {
            $cityModel = new city();
            
            if (!$cityModel->checkCityWithCountry($_POST['city_id'], $_POST['country_id'])) {
                $errors[] = 'المدينة غير متاحة للبلد المختار.';
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