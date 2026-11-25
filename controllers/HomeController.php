<?php

require_once __DIR__ . '/Controller.php';
require_once __DIR__ . '/../models/News.php';
require_once __DIR__ . '/../models/Category.php';

class HomeController extends Controller
{
    private $newsModel;
    private $categoryModel;

    public function __construct($pdo)
    {
        $this->newsModel = new News($pdo);
        $this->categoryModel = new Category($pdo);
    }

    public function index()
    {
        $this->viewPublic('home/index', [
            'pageTitle'  => 'Home',
            'news'       => $this->newsModel->getAll(),
            'categories' => $this->categoryModel->getAll()
        ]);
    }

    public function category($id_category = null)
    {
        if (empty($id_category)) {
            $this->redirect('');
        }

        $category = $this->categoryModel->getById($id_category);

        if (!$category) {
            http_response_code(404);
            echo "Kategori tidak ditemukan.";
            exit;
        }

        $this->viewPublic('home/index', [
            'pageTitle'        => 'Category: ' . $category['name'],
            'news'             => $this->newsModel->getByCategoryId($id_category),
            'categories'       => $this->categoryModel->getAll(),
            'activeCategoryId' => $id_category
        ]);
    }

    public function news($slug = null)
    {
        if (empty($slug)) {
            $this->redirect('');
        }

        $newsItem = $this->newsModel->getBySlug($slug);
        if (!$newsItem) {
            http_response_code(404);
            echo "Berita tidak ditemukan.";
            exit;
        }
        $this->viewPublic('home/detail', [
            'pageTitle' => $newsItem['title'],
            'news'      => $newsItem
        ]);
    }
}
