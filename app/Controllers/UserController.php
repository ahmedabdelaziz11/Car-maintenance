<?php


namespace MVC\controllers;

use MVC\core\controller;
use MVC\core\session;
use MVC\models\offer;
use MVC\models\user;
use MVC\models\userFollow;

class UserController extends controller
{
    public function register()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $inputData = [
                'username'         => isset($_POST['username']) ? htmlspecialchars(trim($_POST['username'])) : null,
                'email'            => isset($_POST['email']) ? htmlspecialchars(trim($_POST['email'])) : null,
                'phone'            => isset($_POST['phone']) ? htmlspecialchars(trim($_POST['phone'])) : null,
                'password'         => isset($_POST['password']) ? htmlspecialchars(trim($_POST['password'])) : null,
                'confirm_password' => isset($_POST['confirm_password']) ? htmlspecialchars(trim($_POST['confirm_password'])) : null,
            ];

            $errors = $this->validateRegisterInput($inputData);

            if (!empty($errors)) {
                $this->view('auth/register', ['errors' => $errors]);
                return;
            }
            
            $user = new user();

            $result = $user->register([
                'name'     => $inputData['username'],
                'email'    => $inputData['email'],
                'phone'    => $inputData['phone'],
                'password' => $inputData['password'],
                'role'     => 3
            ]);

            if ($result === "Registration successful!") {
                header('Location: ' . BASE_URL . '/user/login');
                exit;
            } else {
                $this->view('auth/register', ['errorMessage' => $result]);
            }
        }
        $this->view('auth/register', []);
    }

    public function updateProfile()
    {
        if(!session::Get('user'))
        {
            header('Location: ' . BASE_URL . '/user/login');
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $inputData = [
                'username'         => isset($_POST['username']) ? htmlspecialchars(trim($_POST['username'])) : null,
                'email'            => isset($_POST['email']) ? htmlspecialchars(trim($_POST['email'])) : null,
                'phone'            => isset($_POST['phone']) ? htmlspecialchars(trim($_POST['phone'])) : null,
                'password'         => isset($_POST['password']) ? htmlspecialchars(trim($_POST['password'])) : null,
                'confirm_password' => isset($_POST['confirm_password']) ? htmlspecialchars(trim($_POST['confirm_password'])) : null,
            ];
            
            $errors = $this->validateUpdateProfileInput($inputData);

            if (!empty($errors)) {
                $this->view('auth/update-profile', ['errors' => $errors]);
                return;
            }
            $user = new user();
            $user->updateRow([
                'id' => session::Get('user')['id'],
                'name' => $_POST['username'],
                'email' => $_POST['email'],
                'phone' => $_POST['phone'],
            ]);

            if($_POST['phone'] != session::Get('user')['id'])
            {
                $user->updateRow([
                    'id' => session::Get('user')['id'],
                    'otp' => rand(100000,999999),
                    'is_phone_verified' => 0,
                ]);
            }

            if(!empty($_POST['password']))
            {
                $user->updateRow([
                    'id' => session::Get('user')['id'],
                    'password' => password_hash($_POST['password'], PASSWORD_BCRYPT),
                ]);
            }
            $authenticatedUser = $user->select(['id', 'name', 'phone','email', 'password', 'role','is_phone_verified'])
                ->where('id', '=', session::Get('user')['id'])
                ->row();
            Session::Set('user', [
                'id' => $authenticatedUser['id'],
                'name' => $authenticatedUser['name'],
                'phone' => $authenticatedUser['phone'],
                'email' => $authenticatedUser['email'],
                'role' => $authenticatedUser['role'],
                'is_phone_verified' => $authenticatedUser['is_phone_verified'],
            ]);

            header('Location: ' . BASE_URL . '/user/profile');
            exit;
        }
        header('Location: ' . BASE_URL . '/user/profile');
        exit;
    }


    public function login()
    {
        $errorMessage = "";
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $identifier = trim($_POST['identifier']);
            $password = trim($_POST['password']);
    
            if (empty($identifier) || empty($password)) {
                $errorMessage = "Username/Phone and password are required!";
            } else {
                $user = new User();

                $authenticatedUser = $user->select(['id', 'name', 'phone','email', 'password', 'role','is_phone_verified'])
                    ->where('phone', '=', $identifier)
                    ->row();
                if(!$authenticatedUser) {
                    $authenticatedUser = $user->select(['id', 'name', 'phone','email', 'password', 'role','is_phone_verified'])
                        ->where('name', '=', $identifier)
                        ->row();
                }
    
                if ($authenticatedUser && password_verify($password, $authenticatedUser['password'])) {
                    Session::Set('user', [
                        'id' => $authenticatedUser['id'],
                        'name' => $authenticatedUser['name'],
                        'phone' => $authenticatedUser['phone'],
                        'email' => $authenticatedUser['email'],
                        'role' => $authenticatedUser['role'],
                        'is_phone_verified' => $authenticatedUser['is_phone_verified'],
                    ]);
    
                    if ($authenticatedUser['role'] == 1 || $authenticatedUser['role'] == 2) {
                        header('Location: ' . BASE_URL . '/admin/dashboard');
                        exit;
                    }
    
                    header('Location: ' . BASE_URL . '/');
                    exit;
                } else {
                    $errorMessage = 'Invalid login credentials.';
                }
            }
        }
    
        $this->view('auth/login', ['errorMessage' => $errorMessage]);
    }

    public function logout()
    {
        session::Stop();
        header('Location: ' . BASE_URL . '/');
        exit;
    }

    public function follow()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $input = json_decode(file_get_contents("php://input"), true);
            $followModel = new userFollow();

            $followModel->create([
                'follower_id' => $input['follower_id'],
                'following_id' => $input['following_id']
            ]);

            echo json_encode(['success' => true]);
            exit;
        }
    }

    public function profile($userId = null)
    {
        $userModel = new user();
        $offerModel = new offer();

        if($userId == null)
        {
            $this->view('auth/update-profile',[]);
        }

        $user = $userModel->getById($userId);
        if (!$user) {
            $this->view('404', []);
        }
        $offers = $offerModel->getOffersByUserId($userId);

        $this->view('users/profile', [
            'user' => $user,
            'offers' => $offers
        ]);
    }

    public function validateUsername()
    {
        $input = json_decode(file_get_contents('php://input'), true);

        if (!isset($input['value']) || empty($input['value'])) {
            echo json_encode(['error' => 'Username is required.']);
            http_response_code(400);
            return;
        }

        $username = trim($input['value']);
        $userModel = new user();

        $exists = $userModel->getByUsername($username) == null ? false : true;

        echo json_encode(['exists' => $exists]);
    }

    public function validateEmail()
    {
        $input = json_decode(file_get_contents('php://input'), true);

        if (!isset($input['value']) || empty($input['value'])) {
            echo json_encode(['error' => 'Email is required.']);
            http_response_code(400);
            return;
        }

        $email = trim($input['value']);

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            echo json_encode(['error' => 'Invalid email format.']);
            http_response_code(400);
            return;
        }
        $userModel = new user();

        $exists =  $userModel->getByEmail($email) == null ? false : true;

        echo json_encode(['exists' => $exists]);
    }

    public function validatePhone()
    {
        $input = json_decode(file_get_contents('php://input'), true);

        if (!isset($input['value']) || empty($input['value'])) {
            echo json_encode(['error' => 'Phone number is required.']);
            http_response_code(400);
            return;
        }

        $phone = trim($input['value']);
        $userModel = new user();

        $exists = $userModel->getByPhone($phone) == null ? false : true;

        echo json_encode(['exists' => $exists]);
    }

    private function validateRegisterInput($inputData)
    {
        $errors = [];
        $userModel = new user();

        if (empty($inputData['username'])) {
            $errors['username'] = "Username is required.";
        }elseif ($userModel->getByUsername($inputData['username']) != null){
            $errors['username'] = "Username is already taken.";
        }

        if (empty($inputData['email'])) {
            $errors['email'] = "Email is required.";
        } elseif (!filter_var($inputData['email'], FILTER_VALIDATE_EMAIL)) {
            $errors['email'] = "Invalid email format.";
        } elseif ($userModel->getByEmail($inputData['email']) != null) {
            $errors['email'] = "Email is already taken.";
        }

        if (empty($inputData['phone'])) {
            $errors['phone'] = "Phone number is required.";
        } elseif ($userModel->getByPhone($inputData['phone']) != null) {
            $errors['phone'] = "phone number is already taken.";
        }

        if (empty($inputData['password'])) {
            $errors['password'] = "Password is required.";
        } elseif (strlen($inputData['password']) < 6) {
            $errors['password'] = "Password must be at least 6 characters long.";
        }

        if ($inputData['password'] !== $inputData['confirm_password']) {
            $errors['confirm_password'] = "Passwords do not match.";
        }

        return $errors;
    }

    private function validateUpdateProfileInput($inputData)
    {
        $errors = [];
        $userModel = new user();

        if (empty($inputData['username'])) {
            $errors['username'] = "Username is required.";
        }elseif ($userModel->getByUsername($inputData['username']) != null){
            $errors['username'] = "Username is already taken.";
        }

        if (empty($inputData['email'])) {
            $errors['email'] = "Email is required.";
        } elseif (!filter_var($inputData['email'], FILTER_VALIDATE_EMAIL)) {
            $errors['email'] = "Invalid email format.";
        } elseif ($userModel->getByEmail($inputData['email'],session::Get('user')['id']) != null) {
            $errors['email'] = "Email is already taken.";
        }

        if (empty($inputData['phone'])) {
            $errors['phone'] = "Phone number is required.";
        } elseif ($userModel->getByPhone($inputData['phone']) != null) {
            $errors['phone'] = "phone number is already taken.";
        }

        if (!empty($inputData['password']) && strlen($inputData['password']) < 6) {
            $errors['password'] = "Password must be at least 6 characters long.";
        }

        if (!empty($inputData['password']) && $inputData['password'] !== $inputData['confirm_password']) {
            $errors['confirm_password'] = "Passwords do not match.";
        }

        return $errors;
    }
}
