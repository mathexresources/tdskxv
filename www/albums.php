<div class="container my-5">
    <h1 class="mb-3">Alba</h1>
    <hr>
    <div class="row g-4">
        <?php
	$albums = $db->query('SELECT id FROM albums where DELETED = 0 ORDER BY albums.id DESC')->fetch_all(MYSQLI_ASSOC);
	foreach ($albums as $id){
		$album = new Album($id['id'], $db);
            ?>
            <div class="col-lg-4 col-md-6 col-12 fade-in-up">
                <div class="card card-hover position-relative h-100" onclick="window.location.href = '/album?id=<?=$album->getId()?>'">
                    <img src="<?= $album->getAlbumPath() . $album->getCoverImage() ?>"
                         class="card-img-top object-fit-cover rounded-top"
                         style="height: 250px;"
                         alt="<?= htmlspecialchars($album->getName()) ?>">

                    <!-- Optional badge for photo count -->
                    <span class="position-absolute top-0 end-0 m-2 badge bg-dark bg-opacity-50 text-white">
                    <?= $album->getPhotoCount() ?> <i class="fas fa-images"></i>
                </span>

                    <div class="card-body d-flex flex-column">
                        <h5 class="card-title fw-bold"><?= htmlspecialchars($album->getName()) ?></h5>

                        <?php if ($album->getLocation() != ''): ?>
                            <h6 class="card-subtitle text-muted mb-2"><?= htmlspecialchars($album->getLocation()) ?></h6>
                        <?php endif; ?>

                        <!-- Author and date -->
                        <div class="d-flex align-items-center text-muted small mb-2 gap-3">
                            <span><i class="fas fa-user me-1"></i><?= ucfirst($album->getCreatedByName()) ?></span>
                            <span><i class="fas fa-calendar-alt me-1"></i><?= $album->getCreatedHumanReadable() ?></span>
                        </div>

                        <p class="card-text mt-auto"><?= htmlspecialchars($album->getDescription()) ?></p>
                    </div>
                </div>
            </div>
        <?php } ?>
    </div>
</div>
