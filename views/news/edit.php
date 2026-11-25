<div class="card">
  <div class="card-header">
    <h5 class="mb-0"><?= htmlspecialchars($pageTitle) ?></h5>
  </div>
  <div class="card-body">
    <form action="<?= url('admin/news/update') ?>" method="post" enctype="multipart/form-data">
      <input type="hidden" name="id" value="<?= htmlspecialchars((string)$news['id']) ?>">
      <div class="mb-3">
        <label for="title" class="form-label">Title</label>
        <input type="text" id="title" name="title" class="form-control" value="<?= htmlspecialchars($news['title']) ?>" required>
      </div>
      <div class="mb-3">
        <label for="content" class="form-label">Content</label>
        <textarea id="content" name="content" class="form-control" rows="6" required><?= htmlspecialchars($news['content']) ?></textarea>
      </div>
      <div class="mb-3">
        <label for="id_category" class="form-label">Category</label>
        <select id="id_category" name="id_category" class="form-select" required>
          <option value="" disabled>Pilih Kategori</option>
          <?php foreach ($categories as $category): ?>
            <option value="<?= htmlspecialchars((string)$category['id']) ?>" <?= (string)$news['id_category'] === (string)$category['id'] ? 'selected' : '' ?>>
              <?= htmlspecialchars($category['name']) ?>
            </option>
          <?php endforeach; ?>
        </select>
      </div>
      <div class="mb-3">
        <label for="image" class="form-label">Image</label>
        <?php if (!empty($news['image']) && file_exists(__DIR__ . '/../../uploads/' . $news['image'])): ?>
          <div class="mb-2">
            <img src="<?= url('uploads/' . rawurlencode($news['image'])) ?>" alt="<?= htmlspecialchars($news['title']) ?>" height="120" class="rounded border">
          </div>
        <?php endif; ?>
        <input type="file" id="image" name="image" class="form-control" accept=".jpg,.jpeg,.png,.webp">
        <div class="form-text">Kosongkan jika tidak ingin mengubah gambar. Format: jpg, jpeg, png, webp (Maks. 2MB).</div>
      </div>
      <a href="<?= url('admin/news') ?>" class="btn btn-secondary">Kembali</a>
      <button type="submit" class="btn btn-primary">Simpan</button>
    </form>
  </div>
</div>
