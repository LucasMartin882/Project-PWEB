<div class="card">
  <div class="card-header">
    <h5><?= $pageTitle ?></h5>
  </div>
  <div class="card-body">
    <form action="/admin/news/update" method="post" enctype="multipart/form-data">
      <input type="hidden" name="id" value="<?= $news['id'] ?>">
      <div class="mb-3">
        <label for="">Title</label>
        <input type="text" name="title" class="form-control" value="<?= $news['title'] ?>" required>
      </div>
      <div class="mb-3">
        <label for="">Content</label>
        <textarea name="content" id="" class="form-control" required><?= $news['content'] ?></textarea>
      </div>
      <div class="mb-3">
        <label for="">Category</label>
        <select name="id_category" class="form-control" id="">
          <option value="" disabled selected>Pilih Kategori</option>
          <?php foreach ($categories as $category): ?>
            <option value="<?= $category['id'] ?>" <?= $news['id_category'] == $category['id'] ? 'selected' : '' ?>><?= $category['name'] ?></option>

          <?php endforeach ?>
        </select>
      </div>
      <div class="mb-3">
        <label for="">Image</label>
        <input type="file" name="image" class="form-control">
      </div>
      <input type="submit" value="Simpan" class="btn btn-primary">
    </form>
  </div>
</div>