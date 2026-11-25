        <div class="text-center py-4 mb-3">
            <h1 class="display-5 fw-bold text-dark mb-2">Selamat Datang di PWEB UKRIM</h1>
            <p class="lead text-muted col-lg-8 mx-auto">
                Ini adalah contoh portal berita untuk praktikum PWEB UKRIM
            </p>
        </div>

        <!-- Category Filter Pills -->
        <div class="d-flex gap-2 justify-content-center flex-wrap mb-5">
            <a href="<?= url() ?>" class="btn btn-sm <?= empty($activeCategoryId) ? 'btn-primary' : 'btn-outline-primary' ?> rounded-pill px-3">Semua</a>
            <?php foreach ($categories as $category): ?>
                <a href="<?= url('category/' . $category['id']) ?>" class="btn btn-sm <?= (isset($activeCategoryId) && (string)$activeCategoryId === (string)$category['id']) ? 'btn-primary' : 'btn-outline-primary' ?> rounded-pill px-3">
                    <?= htmlspecialchars($category['name']) ?>
                </a>
            <?php endforeach; ?>
        </div>

        <!-- News Area -->
        <?php if (empty($news)): ?>
            <div class="card shadow-sm border-0 text-center py-5">
                <div class="card-body">
                    <i class="fas fa-folder-open fa-3x text-muted mb-3 d-block"></i>
                    <p class="text-muted mb-0">Tidak ada berita yang tersedia.</p>
                </div>
            </div>
        <?php else: ?>
            <div class="row g-4">
                <?php foreach ($news as $n): ?>
                    <div class="col-md-6 col-lg-4">
                        <article class="card h-100 shadow-sm border-0 overflow-hidden">
                            <?php if (!empty($n['image']) && file_exists(__DIR__ . '/../../uploads/' . $n['image'])): ?>
                                <img src="<?= url('uploads/' . rawurlencode($n['image'])) ?>" alt="<?= htmlspecialchars($n['title']) ?>"
                                    class="card-img-top object-fit-cover" style="height: 200px;">
                            <?php else: ?>
                                <div class="bg-secondary-subtle text-secondary d-flex align-items-center justify-content-center" style="height: 200px;">
                                    <i class="fa-regular fa-image fa-3x opacity-50"></i>
                                </div>
                            <?php endif; ?>

                            <div class="card-body d-flex flex-column">
                                <div class="mb-2 d-flex justify-content-between align-items-center">
                                    <a href="<?= url('category/' . $n['id_category']) ?>"
                                        class="badge text-decoration-none bg-primary-subtle text-primary border border-primary-subtle">
                                        <?= htmlspecialchars($n['category_name']) ?>
                                    </a>
                                    <small class="text-muted"><?= date('d M Y', strtotime($n['created_at'])) ?></small>
                                </div>

                                <h2 class="card-title h5 fw-bold mb-2">
                                    <a href="<?= url('news/' . urlencode($n['slug'])) ?>" class="text-decoration-none text-dark">
                                        <?= htmlspecialchars($n['title']) ?>
                                    </a>
                                </h2>

                                <p class="card-text text-secondary small flex-grow-1 mb-3">
                                    <?= htmlspecialchars(mb_strimwidth($n['content'], 0, 100, '...')) ?>
                                </p>

                                <a href="<?= url('news/' . urlencode($n['slug'])) ?>" class="btn btn-outline-primary btn-sm align-self-start">
                                    Baca Selengkapnya <i class="fa-solid fa-arrow-right ms-1"></i>
                                </a>
                            </div>
                        </article>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
