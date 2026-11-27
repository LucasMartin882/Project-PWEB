<?php
session_start();
date_default_timezone_set('Asia/Jakarta');

require_once __DIR__ . '/vendor/autoload.php';
require_once __DIR__ . '/config/database.php';

use Carbon\Carbon;

Carbon::setLocale('id');

// Helper URL & Flash Message
$scriptDir = dirname($_SERVER['SCRIPT_NAME']);
$basePath  = ($scriptDir === '/' || $scriptDir === '\\') ? '' : rtrim(str_replace('\\', '/', $scriptDir), '/');
define('BASE_URL', $basePath);

function url($path = '') {
    return BASE_URL . '/' . ltrim($path, '/');
}

function set_flash($type, $message) {
    $_SESSION['flash'] = ['type' => $type, 'message' => $message];
}

function get_flash() {
    if (isset($_SESSION['flash'])) {
        $flash = $_SESSION['flash'];
        unset($_SESSION['flash']);
        return $flash;
    }
    return null;
}

function waktuLalu($datetime) {
    if (empty($datetime)) {
        return '-';
    }
    return carbon::parse($datetime,'Asia/Jakarta')->diffForHumans();
}

// Parsing URL
$requestUri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH) ?? '/';
if (BASE_URL !== '' && strpos($requestUri, BASE_URL) === 0) {
    $requestUri = substr($requestUri, strlen(BASE_URL));
}
$cleanPath = trim($requestUri, '/');
$segments  = $cleanPath === '' ? [] : explode('/', $cleanPath);

$isAdmin = isset($segments[0]) && $segments[0] === 'admin';

if ($isAdmin) {
    $controllerName = !empty($segments[1]) ? $segments[1] : 'category';
    $actionName     = !empty($segments[2]) ? $segments[2] : 'index';
    $paramId        = $segments[3] ?? null;
    if (!isset($_SESSION['user']) && $controllerName !== 'auth') {
        set_flash('danger', 'Silakan login terlebih dahulu!');
        header("Location: " . url('admin/auth/login'));
        exit;
    }
} else {
    $controllerName = 'home';
    $actionName     = !empty($segments[0]) ? $segments[0] : 'index';
    $paramId        = $segments[1] ?? null;
}

$controllerClass = ucfirst($controllerName) . 'Controller';
$controllerFile  = __DIR__ . '/controllers/' . $controllerClass . '.php';

if (preg_match('/^[a-zA-Z0-9_]+$/', $controllerName) && file_exists($controllerFile)) {
    require_once $controllerFile;
    if (class_exists($controllerClass)) {
        $controller = new $controllerClass($pdo);
        if (preg_match('/^[a-zA-Z0-9_]+$/', $actionName) && is_callable([$controller, $actionName])) {
            $controller->$actionName($paramId);
            exit;
        }
    }
    http_response_code(404);
    die("Halaman tidak ditemukan (Method $actionName tidak ditemukan).");
} else {
    http_response_code(404);
    die("Halaman tidak ditemukan (Controller $controllerClass tidak ditemukan).");
}
