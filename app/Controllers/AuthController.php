<?php

require_once __DIR__ . '/../Models/UserModel.php';
require_once __DIR__ . '/../Models/AdminModel.php';

class AuthController extends Controller {
    public function login() {
        $this->view('auth/login');
    }

    public function loginPost() {
        $email = $_POST['email'];
        $password = $_POST['password'];

        $userModel = new UserModel();
        $user = $userModel->login($email, $password);

        if ($user) {
            session_start();
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_name'] = $user['name'];
            $_SESSION['role'] = $user['role'];
            
            $this->redirect('/');
        } else {
            $this->view('auth/login', ['error' => 'Invalid email or password']);
        }
    }

    public function adminLogin() {
        $this->view('auth/admin_login');
    }

    public function adminLoginPost() {
        $email = $_POST['email'];
        $password = $_POST['password'];

        // Admin tablosu ile kontrol
        $adminModel = new AdminModel();
        $admin = $adminModel->findByEmail($email);
        if ($admin && password_verify($password, $admin['password'])) {
            session_start();
            $_SESSION['user_id'] = $admin['id'];
            $_SESSION['user_name'] = $admin['email'];
            $_SESSION['role'] = 'admin';
            $this->redirect('/admin');
            return;
        }

        // Geriye dönük: users tablosundaki admin hesabı
        $userModel = new UserModel();
        $user = $userModel->login($email, $password);

        if ($user && $user['role'] === 'admin') {
            session_start();
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_name'] = $user['name'];
            $_SESSION['role'] = $user['role'];
            $this->redirect('/admin');
        } else {
            $this->view('auth/admin_login', ['error' => 'Bu giriş sadece admin kullanıcılar içindir.']);
        }
    }

    public function register() {
        $this->view('auth/register');
    }

    public function registerPost() {
        $data = [
            'name' => $_POST['name'],
            'surname' => $_POST['surname'],
            'email' => $_POST['email'],
            'password' => $_POST['password'],
            'student_number' => $_POST['student_number'],
            'faculty' => $_POST['faculty'],
            'department' => $_POST['department'],
            'class_level' => $_POST['class_level'],
            'residence' => $_POST['residence'],
            'phone' => $_POST['phone']
        ];

        // Basic validation could go here

        $userModel = new UserModel();
        if ($userModel->register($data)) {
            $this->redirect('/login');
        } else {
            $this->view('auth/register', ['error' => 'Registration failed. Email or Student Number might already exist.']);
        }
    }

    public function logout() {
        session_start();
        session_destroy();
        $this->redirect('/login');
    }
}
