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
            $errorMessage = implode("<br>", $errors);

            if (!empty($errors)) {
                $this->view('auth/register', ['errorMessage' => $errorMessage]);
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
        if (!session::Get('user')) {
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
            $errorMessage = implode("<br>", $errors);

            if (!empty($errors)) {
                $this->view('auth/update-profile', ['errorMessage' => $errorMessage]);
                return;
            }
            $user = new user();
            $user->updateRow([
                'id' => session::Get('user')['id'],
                'name' => $_POST['username'],
                'email' => $_POST['email'],
                'phone' => $_POST['phone'],
            ]);

            if ($_POST['phone'] != session::Get('user')['phone']) {
                $user->updateRow([
                    'id' => session::Get('user')['id'],
                    'otp' => rand(100000, 999999),
                    'is_phone_verified' => 0,
                ]);
            }

            if ($_POST['email'] != session::Get('user')['email']) {
                $user->updateRow([
                    'id' => session::Get('user')['id'],
                    'email_otp' => rand(100000, 999999),
                    'is_email_verified' => 0,
                ]);
            }

            if (!empty($_POST['password'])) {
                $user->updateRow([
                    'id' => session::Get('user')['id'],
                    'password' => password_hash($_POST['password'], PASSWORD_BCRYPT),
                ]);
            }

            $authenticatedUser = $user->select(['id', 'name', 'phone', 'email', 'password', 'role', 'is_phone_verified','is_email_verified'])
                ->where('id', '=', session::Get('user')['id'])
                ->row();

            Session::Set('user', [
                'id'    => $authenticatedUser['id'],
                'name'  => $authenticatedUser['name'],
                'phone' => $authenticatedUser['phone'],
                'email' => $authenticatedUser['email'],
                'role'  => $authenticatedUser['role'],
                'is_phone_verified' => $authenticatedUser['is_phone_verified'],
                'is_email_verified' => $authenticatedUser['is_email_verified'],
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
                $errorMessage = __("Username/Phone and password are required!");
            } else {
                $user = new User();

                $authenticatedUser = $user->select(['id', 'name', 'phone', 'email', 'password', 'role', 'is_phone_verified','is_email_verified'])
                    ->where('phone', '=', $identifier)
                    ->row();

                if (!$authenticatedUser) {
                    $authenticatedUser = $user->select(['id', 'name', 'phone', 'email', 'password', 'role', 'is_phone_verified','is_email_verified'])
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
                        'is_email_verified' => $authenticatedUser['is_email_verified'],
                    ]);

                    if ($authenticatedUser['role'] == 1 || $authenticatedUser['role'] == 2) {
                        header('Location: ' . BASE_URL . '/admin/dashboard');
                        exit;
                    }

                    header('Location: ' . BASE_URL . '/');
                    exit;
                } else {
                    $errorMessage = __('Invalid login credentials.');
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

        if ($userId == null) {
            $this->view('auth/update-profile', []);
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

        if (!isset($input['value']) || empty(trim($input['value']))) {
            http_response_code(400);
            echo json_encode(['error' => __('Username is required.')]);
            return;
        }

        $username = trim($input['value']);
        if (strlen($username) < 3) {
            http_response_code(400);
            echo json_encode(['error' => __('Username must be at least 3 characters long.')]);
            return;
        }

        if (strlen($username) > 20) {
            http_response_code(400);
            echo json_encode(['error' => __('Username cannot exceed 20 characters.')]);
            return;
        }

        $userModel = new user();
        $exists = $userModel->getByUsername($username) !== null;

        if ($exists) {
            http_response_code(400);
            echo json_encode(['error' => __('Username is already taken.')]);
            return;
        }

        echo json_encode(['message' => __('Username is available.')]);
    }

    public function validateEmail()
    {
        $input = json_decode(file_get_contents('php://input'), true);

        if (!isset($input['value']) || empty(trim($input['value']))) {
            http_response_code(400);
            echo json_encode(['error' => __('Email is required.')]);
            return;
        }

        $email = trim($input['value']);

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            http_response_code(400);
            echo json_encode(['error' => __('Invalid email format.')]);
            return;
        }

        $userModel = new user();
        $exists = $userModel->getByEmail($email) !== null;

        if ($exists) {
            http_response_code(400);
            echo json_encode(['error' => __('Email is already taken.')]);
            return;
        }

        http_response_code(200);
        echo json_encode(['message' => __('Email is available.')]);
    }

    public function validatePhone()
    {
        $input = json_decode(file_get_contents('php://input'), true);
    
        if (!isset($input['value']) || empty(trim($input['value']))) {
            http_response_code(400);
            echo json_encode(['error' => __('Phone number is required.')]);
            return;
        }
    
        $phone = trim($input['value']);
    
        $userModel = new user();
        $exists = $userModel->getByPhone($phone) !== null;
    
        if ($exists) {
            http_response_code(400);
            echo json_encode(['error' => __('Phone number is already taken.')]);
            return;
        }
    
        http_response_code(200);
        echo json_encode(['message' => __('Phone number is available.')]);
    }

    private function validateRegisterInput($inputData)
    {
        $errors = [];
        $userModel = new user();
    
        $username = $inputData['username'] ?? '';
        if (empty($username)) {
            $errors['username'] = __("Username is required.");
        } else{
            if ($userModel->getByUsername($username) != null) {
                $errors['username'] = __("Username is already taken.");
            }
            if (strlen($username) < 3) {
                $errors['username'] = __('Username must be at least 3 characters long.');
            }
            if (strlen($username) > 20) {
                $errors['username'] = __('Username cannot exceed 20 characters.');
            }
        }

        $email = $inputData['email'] ?? '';
        if (empty($email)) {
            $errors['email'] = __("Email is required.");
        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors['email'] = __("Invalid email format.");
        } elseif ($userModel->getByEmail($email) != null) {
            $errors['email'] = __("Email is already taken.");
        }
    
        $phone = $inputData['phone'] ?? '';
        if (empty($phone)) {
            $errors['phone'] = __("Phone number is required.");
        } elseif ($userModel->getByPhone($phone) != null) {
            $errors['phone'] = __("Phone number is already taken.");
        }
        $password = $inputData['password'] ?? '';
        $confirmPassword = $inputData['confirm_password'] ?? '';
        if (empty($password)) {
            $errors['password'] = __("Password is required.");
        } elseif (strlen($password) < 6) {
            $errors['password'] = __("Password must be at least 6 characters long.");
        } elseif ($password !== $confirmPassword) {
            $errors['confirm_password'] = __("Passwords do not match.");
        }
    
        return $errors;
    }

    private function validateUpdateProfileInput($inputData)
    {
        $errors = [];
        $userModel = new user();
        $currentUserId = session::Get('user')['id'];

        $username = $inputData['username'] ?? '';
        if (empty($username)) {
            $errors['username'] = __("Username is required.");
        } else{
            if ($userModel->getByUsername($username) != null) {
                $errors['username'] = __("Username is already taken.");
            }
            if (strlen($username) < 3) {
                $errors['username'] = __('Username must be at least 3 characters long.');
            }
            if (strlen($username) > 20) {
                $errors['username'] = __('Username cannot exceed 20 characters.');
            }
        }

        $email = $inputData['email'] ?? '';
        if (empty($email)) {
            $errors['email'] = __("Email is required.");
        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors['email'] = __("Invalid email format.");
        } elseif ($userModel->getByEmail($email,$currentUserId) != null) {
            $errors['email'] = __("Email is already taken.");
        }

        $phone = $inputData['phone'] ?? '';
        if (empty($phone)) {
            $errors['phone'] = __("Phone number is required.");
        } elseif ($userModel->getByPhone($phone) != null) {
            $errors['phone'] = __("Phone number is already taken.");
        }

        $password = $inputData['password'] ?? '';
        $confirmPassword = $inputData['confirm_password'] ?? '';
        if (!empty($password) && strlen($password) < 6) {
            $errors['password'] = __("Password must be at least 6 characters long.");
        }

        if (!empty($password) && $password !== $confirmPassword) {
            $errors['confirm_password'] = __("Passwords do not match.");
        }

        return $errors;
    }
}
