<div class="card">
  <div class="card-header">
    <h5><?= $pageTitle ?></h5>
  </div>
  <div class="card-body">
    <a href="/admin/news/create" class="btn btn-primary">Tambah Berita</a>
    <table class="table">
      <thead>
        <th>ID</th>
        <th>Image</th>
        <th>Title</th>
        <th>Category</th>
        <th>Author</th>
        <th>Action</th>
      </thead>
      <tbody>
        <?php foreach ($dataBerita as $berita): ?>
          <tr>
            <td><?= $berita['id'] ?></td>
            <td><img src='/uploads/<?=$berita['image'] ?? 'images.jpg' ?>' height="100" /></td>
            <td><?= $berita['title'] ?></td>
            <td><?= $berita['category_name'] ?></td>
            <td><?= $berita['user_name'] ?></td>
            <td>
              <a href="/admin/news/edit/<?= $berita['id'] ?>" class="btn btn-warning btn-sm">
                <i class="fas fa-edit"></i>
              </a>
              <a href="/admin/news/delete/<?= $berita['id'] ?>" 
              class="btn btn-danger btn-sm"
              onclick="return confirm('Apakah Anda yakin ingin menghapus berita ini?');">
                <i class="fas fa-trash"></i>
              </a>
            </td>
          </tr>
        <?php endforeach ?>
      </tbody>
    </table>
  </div>
</div>