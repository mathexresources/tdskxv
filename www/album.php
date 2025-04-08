<?php
$albumId = $_GET['id'] ?? null;
if (!$albumId) {
    echo "Album ID is required.";
    exit;
}

$album = new Album($albumId, $db);

if ($album->isDeleted()) {
    echo "This album is no longer available.";
    exit;
}
?>

<div class="position-relative overflow-hidden" style="height: 70vh;">
    <img src="<?= $album->getAlbumPath() . $album->getCoverImage() ?>"
         alt="<?= htmlspecialchars($album->getName()) ?>"
         class="w-100 h-100 object-fit-cover">

    <div class="position-absolute top-0 start-0 w-100 h-100 bg-dark bg-opacity-50 d-flex flex-column justify-content-end p-5 text-white">
        <h1 class="display-4"><?= htmlspecialchars($album->getName()) ?></h1>
        <p class="lead"><?= htmlspecialchars($album->getLocation()) ?> · <?= $album->getCreatedHumanReadable() ?></p>
    </div>
</div>

<!--<div class="container container-fade my-4">-->
<!--    <a href="/albums" class="btn btn-outline-secondary">-->
<!--        <i class="fas fa-arrow-left me-2"></i> Zpět na seznam alb-->
<!--    </a>-->
<!--</div>-->

<!-- Content Section -->
<div class="container container-fade my-5">
    <div class="row">
        <!-- Description -->
        <div class="col-md-7 mb-5">
            <h2 class="mb-3">Popis</h2>
            <p class="fs-5 lh-lg"><?= nl2br($album->getDescriptionFull()) ?></p>

            <div class="text-muted mt-4">
                <i class="fas fa-user me-1"></i> <?= ucfirst($album->getCreatedByName()) ?>
            </div>
        </div>

        <!-- Gallery Swiper -->
        <div class="col-md-5">
            <h2 class="mb-3">Galerie (<?= $album->getPhotoCount() ?>)</h2>

            <?php
            $photos = $album->getPhotos();
            if (count($photos) > 0):
                ?>
                <div class="row g-4">
                    <?php foreach ($photos as $index => $photo): ?>
                        <div class="col-12 col-md-4">
                            <div class="ratio ratio-1x1">
                                <img src="<?= $album->getAlbumPath() . $photo ?>"
                                     class="img-fluid rounded object-fit-cover w-100 h-100"
                                     alt="Photo <?= $index + 1 ?>"
                                     data-bs-toggle="modal" data-bs-target="#photoModal"
                                     data-bs-path="<?= $album->getAlbumPath() . $photo ?>">
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php else: ?>
                <p class="text-muted">Album je prázdné.</p>
            <?php endif; ?>
        </div>
    </div>
</div>

<!-- Photo Modal -->
<div class="modal fade overflow-hidden" id="photoModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-fullscreen">
        <div class="modal-content bg-black ">
            <div class="modal-body mySwiper overflow-hidden p-0">
                <div class="swiper-wrapper">
                    <?php foreach ($photos as $photo): ?>
                        <div class="swiper-slide">
                            <img src="<?= $album->getAlbumPath() . $photo ?>" class="w-100 h-100 object-fit-contain "
                                 alt="Photo">
                        </div>
                    <?php endforeach; ?>
                </div>
                <div class="swiper-button-next text-white"></div>
                <div class="swiper-button-prev text-white"></div>
                <button type="button" class="btn-close btn-close-white position-absolute top-0 end-0 m-3"
                        data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
        </div>
    </div>