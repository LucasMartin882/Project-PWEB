<?php
require_once __DIR__ . '/Controller.php';
require_once __DIR__ . '/../models/User.php';

class AuthController extends Controller {
    private $userModel;

    public function __construct($pdo) {
        $this->userModel = new User($pdo);
    }

    public function index() {
        $this->login();
    }

    public function login() {
        # Periksa apakah pengguna sudah login, jika ya, arahkan ke halaman kategori
        if (isset($_SESSION['user'])) {
            $this->redirect('admin/category');
        }

        # Periksa apakah form login telah disubmit
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = trim($_POST['username'] ?? '');
            $password = trim($_POST['password'] ?? '');

            if ($username === '' || $password === '') {
                set_flash('danger', 'Username dan password wajib diisi!');
                $this->redirect('admin/auth/login');
            }

            $user = $this->userModel->verifyLogin($username, $password);

            # Jika login berhasil, simpan data pengguna ke session dan arahkan ke halaman kategori
            if ($user) {
                session_regenerate_id(true);
                $_SESSION['user'] = [
                    'id'       => $user['id'],
                    'username' => $user['username'],
                    'name'     => $user['name']
                ];
                set_flash('success', 'Selamat datang, ' . $user['name']);
                $this->redirect('admin/category');
            } else {
                set_flash('danger', 'Username atau password salah!');
                $this->redirect('admin/auth/login');
            }
        }

        $pageTitle = 'Login Admin';
        require_once __DIR__ . '/../views/auth/login.php';
    }

    public function logout() {
        # Hapus data pengguna dari session dan arahkan ke halaman login
        $_SESSION = [];
        session_destroy();
        session_start();
        session_regenerate_id(true);
        set_flash('success', 'Anda telah berhasil logout.');
        $this->redirect('admin/auth/login');
    }
}
