<?php
class Category
{
  private $pdo;
  public function __construct($pdo)
  {
    $this->pdo = $pdo;
  }

  # 1.READ : Fungsi untuk mengambil semua data kategori dari database
  public function getAll()
  {
    $stmt = $this->pdo->prepare("SELECT * FROM categories ORDER BY id DESC");
    $stmt->execute();
    return $stmt->fetchAll();
  }

  # 2.READ : Fungsi untuk mengambil data kategori berdasarkan id
  public function getById($id)
  {
    $stmt = $this->pdo->prepare("SELECT * FROM categories WHERE id = :id");
    $stmt->execute(['id' => $id]);
    return $stmt->fetch();
  }

  # 3.CREATE : Fungsi untuk menambahkan data kategori baru
  public function store($name, $description)
  {
    $stmt = $this->pdo->prepare("INSERT INTO categories (name, description) VALUES (:name, :description)");
    return $stmt->execute(['name' => $name, 'description' => $description]);
  }

  # DELETE
  public function delete($id)
  {
    $stmt = $this->pdo->prepare("DELETE FROM categories WHERE id = :id");
    return $stmt->execute(['id' => $id]);
  }

  public function update($id, $name, $description)
  {
    $stmt = $this->pdo->prepare("UPDATE categories SET name = :name, description = :description WHERE id = :id");
    return $stmt->execute(['id' => $id, 'name' => $name, 'description' => $description]);
  }

  public function countNews($id)
  {
    $stmt = $this->pdo->prepare("SELECT COUNT(*) FROM news WHERE id_category = :id");
    $stmt->execute(['id' => $id]);
    return (int) $stmt->fetchColumn();
  }
}
