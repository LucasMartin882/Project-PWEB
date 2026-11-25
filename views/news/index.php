<div class="card">
  <div class="card-header">
    <h5 class="mb-0"><?= htmlspecialchars($pageTitle) ?></h5>
  </div>
  <div class="card-body">
    <a href="<?= url('admin/news/create') ?>" class="btn btn-primary mb-3">Tambah Berita</a>
    <div class="table-responsive">
      <table class="table table-striped align-middle">
        <thead>
          <tr>
            <th>ID</th>
            <th>Image</th>
            <th>Title</th>
            <th>Category</th>
            <th>Author</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody>
          <?php if (empty($dataBerita)): ?>
            <tr>
              <td colspan="6" class="text-center text-muted py-4">Belum ada berita.</td>
            </tr>
          <?php else: ?>
            <?php foreach ($dataBerita as $berita): ?>
              <tr>
                <td><?= htmlspecialchars((string)$berita['id']) ?></td>
                <td>
                  <?php if (!empty($berita['image']) && file_exists(__DIR__ . '/../../uploads/' . $berita['image'])): ?>
                    <img src="<?= url('uploads/' . rawurlencode($berita['image'])) ?>" alt="<?= htmlspecialchars($berita['title']) ?>" height="80" class="rounded object-fit-cover" style="width: 120px;" />
                  <?php else: ?>
                    <span class="badge bg-secondary">No Image</span>
                  <?php endif; ?>
                </td>
                <td><?= htmlspecialchars($berita['title']) ?></td>
                <td><?= htmlspecialchars($berita['category_name']) ?></td>
                <td><?= htmlspecialchars($berita['user_name']) ?></td>
                <td>
                  <a href="<?= url('news/' . urlencode($berita['slug'])) ?>" target="_blank" class="btn btn-info btn-sm text-white" title="Lihat">
                    <i class="fas fa-eye"></i>
                  </a>
                  <a href="<?= url('admin/news/edit/' . $berita['id']) ?>" class="btn btn-warning btn-sm" title="Edit">
                    <i class="fas fa-edit"></i>
                  </a>
                  <a href="<?= url('admin/news/delete/' . $berita['id']) ?>"
                    class="btn btn-danger btn-sm"
                    title="Hapus"
                    onclick="return confirm('Apakah Anda yakin ingin menghapus berita ini?');">
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
