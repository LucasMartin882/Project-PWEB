<?php

require_once __DIR__ . '/Controller.php';
require_once __DIR__ . '/../models/Category.php';

class CategoryController extends Controller
{
  private $categoryModel;

  public function __construct($pdo)
  {
    $this->categoryModel = new Category($pdo);
  }

  public function index()
  {
    $pageTitle = "List Kategori";
    $dataKategori = $this->categoryModel->getAll();

    $this->view('category/index', [
      'pageTitle'    => $pageTitle,
      'dataKategori' => $dataKategori
    ]);
  }

  public function create()
  {
    $this->view('category/create', [
      'pageTitle' => "Tambah Kategori"
    ]);
  }

  public function store()
  {
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
      $this->redirect('admin/category');
    }

    $name = trim($_POST['name'] ?? '');
    $description = trim($_POST['description'] ?? '');

    if ($name === '') {
      set_flash('danger', "Nama kategori wajib diisi.");
      $this->redirect('admin/category/create');
    }

    $this->categoryModel->store($name, $description);
    set_flash('success', "Kategori Berhasil disimpan");
    $this->redirect('admin/category');
  }

  public function delete($id = null)
  {
    if (empty($id)) {
      set_flash('danger', "ID Kategori tidak valid");
      $this->redirect('admin/category');
    }

    $category = $this->categoryModel->getById($id);
    if (!$category) {
      set_flash('danger', "Kategori tidak ditemukan");
      $this->redirect('admin/category');
    }

    if ($this->categoryModel->countNews($id) > 0) {
      set_flash('danger', "Kategori tidak dapat dihapus karena masih digunakan oleh berita.");
      $this->redirect('admin/category');
    }

    $this->categoryModel->delete($id);
    set_flash('success', "Kategori Berhasil dihapus");
    $this->redirect('admin/category');
  }

  public function edit($id = null)
  {
    if (empty($id)) {
      set_flash('danger', "ID Kategori tidak valid");
      $this->redirect('admin/category');
    }

    $category = $this->categoryModel->getById($id);
    if (!$category) {
      set_flash('danger', "Kategori tidak ditemukan");
      $this->redirect('admin/category');
    }

    $this->view('category/update', [
      'pageTitle' => "Edit Kategori",
      'category'  => $category
    ]);
  }

  public function update()
  {
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
      $this->redirect('admin/category');
    }

    $id = $_POST['id'] ?? '';
    $name = trim($_POST['name'] ?? '');
    $description = trim($_POST['description'] ?? '');

    if (empty($id) || !$this->categoryModel->getById($id)) {
      set_flash('danger', "Kategori tidak ditemukan");
      $this->redirect('admin/category');
    }

    if ($name === '') {
      set_flash('danger', "Nama kategori wajib diisi.");
      $this->redirect('admin/category/edit/' . $id);
    }

    $this->categoryModel->update($id, $name, $description);
    set_flash('info', "Kategori Berhasil diubah");
    $this->redirect('admin/category');
  }
}
