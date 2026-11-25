<div class="card">
  <div class="card-header">
    <h5 class="mb-0"><?= htmlspecialchars($pageTitle) ?></h5>
  </div>
  <div class="card-body">
    <a class="btn btn-primary mb-3" href="<?= url('admin/category/create') ?>">Tambah kategori</a>
    <div class="table-responsive">
      <table class="table table-striped align-middle">
        <thead>
          <tr>
            <th>ID</th>
            <th>Nama Kategori</th>
            <th>Deskripsi Kategori</th>
            <th>Aksi</th>
          </tr>
        </thead>
        <tbody>
          <?php if (empty($dataKategori)): ?>
            <tr>
              <td colspan="4" class="text-center text-muted py-4">Belum ada kategori.</td>
            </tr>
          <?php else: ?>
            <?php foreach ($dataKategori as $kategori): ?>
              <tr>
                <td><?= htmlspecialchars((string)$kategori['id']) ?></td>
                <td><?= htmlspecialchars($kategori['name']) ?></td>
                <td><?= htmlspecialchars($kategori['description'] ?? '') ?></td>
                <td>
                  <a href="<?= url('admin/category/edit/' . $kategori['id']) ?>" class="btn btn-warning btn-sm">
                    <i class="fas fa-edit"></i>
                  </a>
                  <a href="<?= url('admin/category/delete/' . $kategori['id']) ?>"
                    class="btn btn-danger btn-sm"
                    onclick="return confirm('Apakah Anda yakin ingin menghapus kategori ini?');">
                    <i class="fas fa-trash"></i>
                  </a>
                </td>
              </tr>
            <?php endforeach; ?>
          <?php endif; ?>
        </tbody>
      </table>
    </div>
  </div>
</div>
