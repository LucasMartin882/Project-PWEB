<?php
class User {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    # Method untuk memverifikasi login pengguna berdasarkan username dan password
    public function verifyLogin($username, $password) {
        $stmt = $this->pdo->prepare("SELECT * FROM users WHERE username = :u LIMIT 1");
        $stmt->execute(['u' => $username]);
        $user = $stmt->fetch();

        # Periksa apakah pengguna ditemukan dan password cocok
        if ($user && password_verify($password, $user['password'])) {
            return $user;
        }
        return false;
    }
}