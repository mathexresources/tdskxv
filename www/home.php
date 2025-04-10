<?php
$images = [];
// Get last 3 albums
$albums = $db->query('SELECT id FROM albums WHERE deleted = 0 ORDER BY id DESC')->fetch_all(MYSQLI_ASSOC);
foreach ($albums as $id) {
    $album = new Album($id['id'], $db);
    $imgs = $album->getPhotos();
    foreach ($imgs as $img) {
        $path = $album->getAlbumPath() . $img;
        $images[] = $path;
    }
}

// Check resolution and aspect ratio (around 600x1080)
$aspectRatio = 600 / 1080;
$validImages = [];
foreach ($images as $image) {
    [$width, $height] = getimagesize($_SERVER['DOCUMENT_ROOT'].$image);
    if ($width >= 300 && $height >= 540) {
        $ratio = $width / $height;
        if ($ratio >= ($aspectRatio - 0.1) && $ratio <= ($aspectRatio + 0.1)) {
            $validImages[] = $image;
        }
    }
}
if (count($validImages) < 9) {
    $defaultImagesDir = $_SERVER['DOCUMENT_ROOT'] . '/img/home';
    $defaultImages = array_diff(scandir($defaultImagesDir), ['.', '..']);
    shuffle($defaultImages);

    foreach ($defaultImages as $img) {
        if (count($validImages) >= 9) break;
        $validImages[] = '/img/home/' . $img;
    }
}
$images = array_slice($validImages, 0, 9); // Always max 9 images
?>


<div class="swiper mySwiper-desktop shadow d-none d-lg-block d-xl-block d-xxl-block">
    <div class="swiper-wrapper">
        <?php foreach ($images as $image): ?>
            <div class="swiper-slide">
                <img src="<?= $image ?>" loading="lazy" width="600" height="1080" style="object-fit: cover;" alt="Swipper image">
            </div>
        <?php endforeach; ?>
    </div>
    <div class="swiper-gradient-overlay"></div>
</div>

<div class="swiper mySwiper-mobile dark-effect shadow d-lg-none d-xl-none d-xxl-none">
    <div class="swiper-wrapper">
        <?php foreach ($images as $image): ?>
            <div class="swiper-slide">
                <img src="<?= $image ?>" loading="lazy"  style="object-fit: cover; height: 50vh" alt="Swipper image">
            </div>
        <?php endforeach; ?>
    </div>
    <div class="swiper-gradient-overlay"></div>
</div>

<div class="container container-fade mt-5" style="min-width: 90vw">
    <div class="row">
        <div class="col-12 col-md-6">
            <h1 class="asset-regular"><?= $CONF_TITLE ?></h1>
            <p class="fs-4">Hi, I’m Tadeáš, also known as TDSKXV. I’m a graphic artist who works with programs like Adobe Photoshop, Illustrator, and Blender. I enjoy creating 3D designs, posters, and I also like exploring new projects with new techniques.</p>
            <p class="fs-4"><a href="/about-me" class="">Learn more</a></p>
        </div>
    </div>
    <hr>
    <h2 class="fs-1">Poslední Alba</h2>
    <a href="albums" class="btn btn-link">Všechna alba <i class="fa fa-arrow-right"></i></a>
    <hr class="mb-5">

    <div class="row g-4">
        <?php
        $albums = $db->query('SELECT id FROM albums WHERE deleted = 0 ORDER BY albums.id DESC LIMIT 3')->fetch_all(MYSQLI_ASSOC);
        foreach ($albums as $id) {
            $album = new Album($id['id'], $db);
            ?>
            <div class="col-lg-4 col-md-6 col-12 fade-in-up">
                <div class="card card-hover position-relative h-100"
                     onclick="window.location.href = '/album?id=<?= $album->getId() ?>'">
                    <img src="<?= $album->getAlbumPath() . $album->getCoverImage() ?>"
                         class="card-img-top object-fit-cover rounded-top"
                         style="height: 250px;"
                         alt="<?= htmlspecialchars($album->getName()) ?>">

                    <!-- Optional badge for photo count -->
                    <span class="position-absolute top-0 end-0 m-2 badge bg-dark bg-opacity-50 text-white">
                    <?= $album->getPhotoCount() ?> <i class="fas fa-images"></i>
                </span>

                    <div class="card-body d-flex flex-column">
                        <p class="fs-4 card-title fw-bold"><?= htmlspecialchars($album->getName()) ?></p>

                        <?php if ($album->getLocation() != ''): ?>
                            <p class="fs-6 card-subtitle text-muted mb-2"><?= htmlspecialchars($album->getLocation()) ?></p>
                        <?php endif; ?>

                        <!-- Author and date -->
                        <div class="d-flex align-items-center text-muted small mb-2 gap-3">
                            <span><i class="fas fa-user me-1"></i><?= ucfirst($album->getCreatedByName()) ?></span>
                            <span><i class="fas fa-calendar-alt me-1"></i><?= $album->getCreatedHumanReadable() ?></span>
                        </div>

                        <p class="card-text mt-auto"><?= $album->getDescription() ?></p>
                    </div>
                </div>
            </div>
        <?php } ?>
    </div>
    <hr class="mt-5">
    <h2 class="fs-1">Sleduj mě</h2>
    <div class="d-flex gap-3">
        <div class="d-flex justify-content-center align-items-center border" style="height: 25vh; width: 25vh;" onclick="window.location.href = ('https://www.instagram.com/tdskxvdesign/')">
            <div class="text-center">
                <i class="fa-brands mx-auto text-center fa-instagram fa-6x"></i>
                <p class="text-muted mx-auto text-center">@tdskxvdesign</p>
            </div>
        </div>
    <hr>
</div>
