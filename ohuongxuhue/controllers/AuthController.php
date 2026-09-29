<?php
/**
 * Controller xử lý Đăng nhập & Đăng ký (AuthController)
 * Tích hợp phân quyền Admin & User
 */

class AuthController extends BaseController {
    private $userModel;

    public function __construct() {
        $this->userModel = new UserModel();
    }

    /**
     * Hiển thị và xử lý đăng nhập có phân quyền
     */
    public function login() {
        $error = '';
        $success = '';

        // Nếu đã đăng nhập rồi thì điều hướng theo vai trò
        if (isset($_SESSION['user'])) {
            $this->redirectByRole($_SESSION['user']);
        }

        if (isset($_SESSION['flash_success'])) {
            $success = $_SESSION['flash_success'];
            unset($_SESSION['flash_success']);
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = trim($_POST['username'] ?? '');
            $password = trim($_POST['password'] ?? '');

            if (empty($username) || empty($password)) {
                $error = 'Vui lòng điền đầy đủ tên đăng nhập và mật khẩu!';
            } else {
                $result = $this->userModel->login($username, $password);
                if ($result['status']) {
                    $_SESSION['user'] = $result['user'];
                    
                    // Phân quyền điều hướng: Admin -> Dashboard, User -> Trang chủ
                    $this->redirectByRole($result['user']);
                } else {
                    $error = $result['message'];
                }
            }
        }

        $this->render('auth/login', [
            'pageTitle'  => 'Đăng nhập - O Hương Xứ Huế',
            'currentNav' => 'login',
            'error'      => $error,
            'success'    => $success
        ]);
    }

    /**
     * Điều hướng người dùng theo vai trò (Role)
     */
    private function redirectByRole($user) {
        if (isset($user['role']) && $user['role'] === 'admin') {
            $adminUrl = function_exists('home_url') ? home_url('/?controller=admin') : 'index.php?controller=admin';
            header("Location: " . $adminUrl);
            exit;
        } else {
            $siteUrl = function_exists('home_url') ? home_url('/') : 'index.php';
            header("Location: " . $siteUrl);
            exit;
        }
    }

    /**
     * Hiển thị và xử lý đăng ký tài khoản (Mặc định cấp quyền 'user')
     */
    public function register() {
        $error = '';
        $oldData = [];

        if (isset($_SESSION['user'])) {
            $this->redirectByRole($_SESSION['user']);
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $fullname        = trim($_POST['fullname'] ?? '');
            $username        = trim($_POST['username'] ?? '');
            $email           = trim($_POST['email'] ?? '');
            $phone           = trim($_POST['phone'] ?? '');
            $password        = $_POST['password'] ?? '';
            $confirmPassword = $_POST['confirm_password'] ?? '';

            $oldData = [
                'fullname' => $fullname,
                'username' => $username,
                'email'    => $email,
                'phone'    => $phone
            ];

            if (empty($fullname) || empty($username) || empty($email) || empty($password)) {
                $error = 'Vui lòng điền đầy đủ các trường thông tin bắt buộc!';
            } elseif ($password !== $confirmPassword) {
                $error = 'Mật khẩu xác nhận không trùng khớp!';
            } elseif (strlen($password) < 6) {
                $error = 'Mật khẩu phải có độ dài tối thiểu 6 ký tự!';
            } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $error = 'Địa chỉ email không đúng định dạng!';
            } else {
                // Đăng ký với quyền mặc định là 'user'
                $result = $this->userModel->register($fullname, $username, $email, $password, $phone, 'user');
                if ($result['status']) {
                    $_SESSION['flash_success'] = 'Đăng ký tài khoản thành công! Bạn có thể đăng nhập ngay.';
                    $loginUrl = function_exists('home_url') ? home_url('/?controller=auth&action=login') : 'index.php?controller=auth&action=login';
                    header("Location: " . $loginUrl);
                    exit;
                } else {
                    $error = $result['message'];
                }
            }
        }

        $this->render('auth/register', [
            'pageTitle'  => 'Đăng ký tài khoản - O Hương Xứ Huế',
            'currentNav' => 'register',
            'error'      => $error,
            'oldData'    => $oldData
        ]);
    }

    /**
     * Đăng xuất
     */
    public function logout() {
        unset($_SESSION['user']);
        $siteUrl = function_exists('home_url') ? home_url('/') : 'index.php';
        header("Location: " . $siteUrl);
        exit;
    }
}
