<?php

class News
{
  private $pdo;

  public function __construct($pdo)
  {
    $this->pdo = $pdo;
  }

  public function getAll()
  {
    $query = "SELECT c.name AS category_name, c.description, u.name AS user_name, n.*
              FROM news AS n
              JOIN categories AS c ON n.id_category = c.id
              JOIN users AS u ON n.id_user = u.id
              ORDER BY n.created_at DESC, n.id DESC";
    $stmt = $this->pdo->query($query);
    return $stmt->fetchAll();
  }

  public function getByCategoryId($id_category)
  {
    $query = "SELECT c.name AS category_name, c.description, u.name AS user_name, n.*
              FROM news AS n
              JOIN categories AS c ON n.id_category = c.id
              JOIN users AS u ON n.id_user = u.id
              WHERE n.id_category = :id_category
              ORDER BY n.created_at DESC, n.id DESC";
    $stmt = $this->pdo->prepare($query);
    $stmt->execute(['id_category' => $id_category]);
    return $stmt->fetchAll();
  }

  public function getById($id)
  {
    $query = "SELECT c.name AS category_name, c.description, u.name AS user_name, n.*
              FROM news AS n
              JOIN categories AS c ON n.id_category = c.id
              JOIN users AS u ON n.id_user = u.id
              WHERE n.id = :id";
    $stmt = $this->pdo->prepare($query);
    $stmt->execute(['id' => $id]);
    return $stmt->fetch();
  }

  public function getBySlug($slug)
  {
    $query = "SELECT c.name AS category_name, c.description, u.name AS user_name, n.*
              FROM news AS n
              JOIN categories AS c ON n.id_category = c.id
              JOIN users AS u ON n.id_user = u.id
              WHERE n.slug = :slug";
    $stmt = $this->pdo->prepare($query);
    $stmt->execute(['slug' => $slug]);
    return $stmt->fetch();
  }

  public function slugExists($slug, $excludeId = null)
  {
    if ($excludeId !== null) {
      $stmt = $this->pdo->prepare("SELECT COUNT(*) FROM news WHERE slug = :slug AND id != :id");
      $stmt->execute(['slug' => $slug, 'id' => $excludeId]);
    } else {
      $stmt = $this->pdo->prepare("SELECT COUNT(*) FROM news WHERE slug = :slug");
      $stmt->execute(['slug' => $slug]);
    }
    return (int) $stmt->fetchColumn() > 0;
  }

  public function store(array $news)
  {
    $query = "INSERT INTO news (title, content, slug, id_category, id_user, image)
              VALUES (:title, :content, :slug, :id_category, :id_user, :image)";
    $stmt = $this->pdo->prepare($query);
    return $stmt->execute([
      'title'       => $news['title'],
      'content'     => $news['content'],
      'slug'        => $news['slug'],
      'id_category' => $news['id_category'],
      'id_user'     => $news['id_user'],
      'image'       => $news['image'],
    ]);
  }

  public function update(array $news)
  {
    if ($news['image'] !== null) {
      $query = "UPDATE news
                SET title = :title, content = :content, slug = :slug,
                    id_category = :id_category, id_user = :id_user, image = :image
                WHERE id = :id";
      $stmt = $this->pdo->prepare($query);
      return $stmt->execute([
        'title'       => $news['title'],
        'content'     => $news['content'],
        'slug'        => $news['slug'],
        'id_category' => $news['id_category'],
        'id_user'     => $news['id_user'],
        'image'       => $news['image'],
        'id'          => $news['id'],
      ]);
    }

    # Kondisi dimana image null -> tidak diupdate
    $query = "UPDATE news
              SET title = :title, content = :content, slug = :slug,
                  id_category = :id_category, id_user = :id_user
              WHERE id = :id";
    $stmt = $this->pdo->prepare($query);
    return $stmt->execute([
      'title'       => $news['title'],
      'content'     => $news['content'],
      'slug'        => $news['slug'],
      'id_category' => $news['id_category'],
      'id_user'     => $news['id_user'],
      'id'          => $news['id'],
    ]);
  }

  public function delete($id)
  {
    $query = "DELETE FROM news WHERE id = :id";
    $stmt = $this->pdo->prepare($query);
    return $stmt->execute(['id' => $id]);
  }
}
