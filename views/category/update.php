<div class="card">
  <div class="card-header">
    <h5 class="mb-0">Ubah Kategori</h5>
  </div>
  <div class="card-body">
    <form action="<?= url('admin/category/update') ?>" method="POST">
      <input type="hidden" name="id" value="<?= htmlspecialchars((string)$category['id']) ?>">
      <div class="mb-3">
        <label for="name" class="form-label">Nama Kategori</label>
        <input type="text" id="name" value="<?= htmlspecialchars($category['name']) ?>" name="name" class="form-control" required>
      </div>
      <div class="mb-3">
        <label for="description" class="form-label">Deskripsi Kategori</label>
        <textarea id="description" name="description" class="form-control" rows="3"><?= htmlspecialchars($category['description'] ?? '') ?></textarea>
      </div>
      <div class="mb-3">
        <a href="<?= url('admin/category') ?>" class="btn btn-secondary">Kembali</a>
        <button type="submit" class="btn btn-success">Simpan</button>
      </div>
    </form>
  </div>
</div>
