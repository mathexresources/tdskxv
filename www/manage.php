<?php
require_once '../fileHead.php';

if (!isset($_SESSION['admin']) || !$_SESSION['admin']) {
    header('Location: /login');
    die('<script>window.location = "/login";</script>');
    exit();
}

if (!isset($_SESSION['user']['admin']) || $_SESSION['user']['admin'] < 0) {
    header('Location: /admin');
    die('<script>window.location = "/admin";</script>');
    exit();
}

$albums = $db->query('SELECT id FROM albums ORDER BY albums.id DESC')->fetch_all(MYSQLI_ASSOC);
?>

<?php require_once 'components/sidebar.php'; ?>
<div class="container container-fade">
    <?php require_once 'components/breadcrumbs.php'; ?>
    <div class="row">
        <h1 class="my-3">Alba</h1>
        <!-- Bootstrap grid for responsive cards -->


        <div class="col-lg-3 col-md-4 col-sm-6 col-12 mb-4">
            <div class="card album-placeholder d-flex flex-column h-100 border border-dark border-2 border-striped text-center align-items-center justify-content-center createAlbum"
                 style="border-style: dashed !important; cursor: pointer;">
                <div class="card-body d-flex flex-column align-items-center justify-content-center">
                    <i class="fa fa-plus fa-4x text-muted"></i>
                    <h5 class="mt-3 text-muted">Nové album</h5>
                </div>
            </div>
        </div>

        <?php foreach ($albums as $id): ?>
            <?php
		$album = new Album($id['id'], $db);
	//	var_dump($album->isDeleted());
            ?>
            <div class="col-lg-3 col-md-4 col-sm-6 col-12 mb-4">
                <!-- Card component -->
                <div class="card d-flex flex-column h-100">
                    <img src="<?= $album->getAlbumPath() . $album->getCoverImage() ?>" class="card-img-top"
                         alt="<?= $album->getName() ?>">
                    <div class="card-body d-flex flex-column">
                        <h5 class="card-title"><?= $album->getName() ?></h5>
                        <?php if ($album->getLocation() != ''): ?>
                            <h6 class="card-title"><?= $album->getLocation() ?></h6>
                        <?php endif; ?>
                        <p class="card-text"><?= $album->getDescription() ?></p>
                    </div>
                    <div class="m-2">
                        <a href="album?id=<?= $album->getId() ?>" class="btn btn-dark hover-bg-primary mx-1"><i
                                    class="fa fa-arrow-up-right-from-square"></i></a>
                        <a href="/edit?id=<?=$album->getId()?>" class="btn btn-dark hover-bg-primary mx-1"><i class="fa fa-pencil"></i></a>
                        <?php if (!$album->isDeleted()): ?>
                            <button id="deleteAlbum" data-album-id="<?=$album->getId()?>" class="btn <?=($album->getCreatedById() == $_SESSION['user']['id'] || $_SESSION['user']['admin'] == 10)?'':'disabled'?> btn-dark deleteAlbum float-end mx-1">
                                <i class="fa fa-eye"></i>
                            </button>
                        <?php endif; ?>

                        <?php if ($album->isDeleted()): ?>
                            <button data-album-id="<?=$album->getId()?>" class="btn <?=($_SESSION['user']['admin'] == 10)?'':'disabled'?> btn-dark deleteAlbum float-end mx-1">
                                <i class="fa fa-eye-slash"></i>
                            </button>
                        <?php endif; ?>
                    </div>
                    <div class="card-footer text-body-secondary">
                        <small class="text-muted"><?= ucfirst($album->getCreatedByName()) ?>
                            - <?= $album->getCreatedHumanReadable() ?></small>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>


