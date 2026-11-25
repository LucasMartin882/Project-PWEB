<div class="card">
  <div class="card-header">
    <h5 class="mb-0"><?= htmlspecialchars($pageTitle) ?></h5>
  </div>
  <div class="card-body">
    <form action="<?= url('admin/news/store') ?>" method="post" enctype="multipart/form-data">
      <div class="mb-3">
        <label for="title" class="form-label">Title</label>
        <input type="text" id="title" name="title" class="form-control" required>
      </div>
      <div class="mb-3">
        <label for="content" class="form-label">Content</label>
        <textarea id="content" name="content" class="form-control" rows="6" required></textarea>
      </div>
      <div class="mb-3">
        <label for="id_category" class="form-label">Category</label>
        <select id="id_category" name="id_category" class="form-select" required>
          <option value="" disabled selected>Pilih Kategori</option>
          <?php foreach ($categories as $category): ?>
            <option value="<?= htmlspecialchars((string)$category['id']) ?>"><?= htmlspecialchars($category['name']) ?></option>
          <?php endforeach; ?>
        </select>
      </div>
      <div class="mb-3">
        <label for="image" class="form-label">Image</label>
        <input type="file" id="image" name="image" class="form-control" accept=".jpg,.jpeg,.png,.webp">
        <div class="form-text">Format yang diperbolehkan: jpg, jpeg, png, webp. Maksimal 2MB.</div>
      </div>
      <a href="<?= url('admin/news') ?>" class="btn btn-secondary">Kembali</a>
      <button type="submit" class="btn btn-primary">Simpan</button>
    </form>
  </div>
</div>
