<?php

require_once __DIR__ . '/Controller.php';
require_once __DIR__ . '/../models/Category.php';
require_once __DIR__ . '/../models/News.php';

class NewsController extends Controller
{
  private $categoryModel;
  private $newsModel;
  private $uploadDir;

  public function __construct($pdo)
  {
    $this->categoryModel = new Category($pdo);
    $this->newsModel = new News($pdo);
    $this->uploadDir = __DIR__ . '/../uploads/';

    if (!is_dir($this->uploadDir)) {
      mkdir($this->uploadDir, 0777, true);
    }
  }

  private function generateSlug($title, $excludeId = null)
  {
    $baseSlug = strtolower(trim($title));
    $baseSlug = preg_replace('/[^a-z0-9]+/', '-', $baseSlug);
    $baseSlug = trim($baseSlug, '-');
    if ($baseSlug === '') {
      $baseSlug = 'berita';
    }

    $slug = $baseSlug;
    $counter = 1;
    while ($this->newsModel->slugExists($slug, $excludeId)) {
      $slug = $baseSlug . '-' . $counter;
      $counter++;
    }
    return $slug;
  }

  private function handleImageUpload($redirectPath)
  {
    if (!isset($_FILES['image']) || $_FILES['image']['error'] === UPLOAD_ERR_NO_FILE) {
      return null;
    }

    if ($_FILES['image']['error'] !== UPLOAD_ERR_OK) {
      set_flash('danger', 'Terjadi kesalahan saat mengunggah gambar.');
      $this->redirect($redirectPath);
    }

    $originalName = $_FILES['image']['name'];
    $tmpFile = $_FILES['image']['tmp_name'];
    $fileExt = strtolower(pathinfo($originalName, PATHINFO_EXTENSION));
    $allowedExt = ['jpg', 'jpeg', 'png', 'webp'];

    if (!in_array($fileExt, $allowedExt, true)) {
      set_flash('danger', 'Ekstensi file tidak diizinkan. Hanya jpg, jpeg, png, dan webp yang diperbolehkan.');
      $this->redirect($redirectPath);
    }

    $maxSize = 2 * 1024 * 1024; // 2MB
    if ($_FILES['image']['size'] > $maxSize) {
      set_flash('danger', 'Ukuran file terlalu besar. Maksimal 2MB.');
      $this->redirect($redirectPath);
    }

    $namaFile = uniqid("img_", true) . '.' . $fileExt;
    if (!move_uploaded_file($tmpFile, $this->uploadDir . $namaFile)) {
      set_flash('danger', 'Gagal menyimpan file gambar.');
      $this->redirect($redirectPath);
    }

    return $namaFile;
  }

  private function deleteImageFile($filename)
  {
    if (!empty($filename)) {
      $imagePath = $this->uploadDir . $filename;
      if (file_exists($imagePath) && is_file($imagePath)) {
        unlink($imagePath);
      }
    }
  }

  public function index()
  {
    $this->view('news/index', [
      'pageTitle'  => "Daftar Berita",
      'dataBerita' => $this->newsModel->getAll()
    ]);
  }

  public function create()
  {
    $this->view('news/create', [
      'pageTitle'  => "Tambah Berita",
      'categories' => $this->categoryModel->getAll()
    ]);
  }

  public function store()
  {
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
      $this->redirect('admin/news');
    }

    $id_category = $_POST['id_category'] ?? '';
    $title = trim($_POST['title'] ?? '');
    $content = trim($_POST['content'] ?? '');
    $id_user = $_SESSION['user']['id'];

    if ($title === '' || $content === '' || empty($id_category) || !$this->categoryModel->getById($id_category)) {
      set_flash('danger', 'Judul, konten, dan kategori wajib diisi dengan valid.');
      $this->redirect('admin/news/create');
    }

    $namaFile = $this->handleImageUpload('admin/news/create');

    $news = [
      'title'       => $title,
      'content'     => $content,
      'slug'        => $this->generateSlug($title),
      'id_category' => $id_category,
      'id_user'     => $id_user,
      'image'       => $namaFile
    ];
    $this->newsModel->store($news);
    set_flash('success', 'Berita berhasil ditambahkan.');
    $this->redirect('admin/news');
  }

  public function edit($id = null)
  {
    if (empty($id)) {
      set_flash('danger', 'ID berita tidak valid.');
      $this->redirect('admin/news');
    }

    $news = $this->newsModel->getById($id);
    if (!$news) {
      set_flash('danger', 'Berita tidak ditemukan.');
      $this->redirect('admin/news');
    }

    $this->view('news/edit', [
      'pageTitle'  => "Edit Berita",
      'categories' => $this->categoryModel->getAll(),
      'news'       => $news
    ]);
  }

  public function update()
  {
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
      $this->redirect('admin/news');
    }

    $id = $_POST['id'] ?? '';
    $existingNews = !empty($id) ? $this->newsModel->getById($id) : false;
    if (!$existingNews) {
      set_flash('danger', 'Berita tidak ditemukan.');
      $this->redirect('admin/news');
    }

    $id_category = $_POST['id_category'] ?? '';
    $title = trim($_POST['title'] ?? '');
    $content = trim($_POST['content'] ?? '');
    $id_user = $_SESSION['user']['id'];

    if ($title === '' || $content === '' || empty($id_category) || !$this->categoryModel->getById($id_category)) {
      set_flash('danger', 'Judul, konten, dan kategori wajib diisi dengan valid.');
      $this->redirect('admin/news/edit/' . $id);
    }

    $namaFile = $this->handleImageUpload('admin/news/edit/' . $id);
    if ($namaFile !== null) {
      $this->deleteImageFile($existingNews['image']);
    }

    $news = [
      'id'          => $id,
      'title'       => $title,
      'content'     => $content,
      'slug'        => $this->generateSlug($title, $id),
      'id_category' => $id_category,
      'id_user'     => $id_user,
      'image'       => $namaFile
    ];
    $this->newsModel->update($news);
    set_flash('success', 'Berita berhasil diperbarui.');
    $this->redirect('admin/news');
  }

  public function delete($id = null)
  {
    if (empty($id)) {
      set_flash('danger', 'ID berita tidak valid.');
      $this->redirect('admin/news');
    }

    $news = $this->newsModel->getById($id);
    if (!$news) {
      set_flash('danger', 'Berita tidak ditemukan.');
      $this->redirect('admin/news');
    }

    $this->deleteImageFile($news['image']);
    $this->newsModel->delete($id);
    set_flash('success', 'Berita berhasil dihapus.');
    $this->redirect('admin/news');
  }
}
