afafa
<?php
require_once '../fileHead.php';
if (empty($_SESSION['admin'])) {
    header('Location: /login');
    die('<script>window.location = "/login";</script>');
}

$alerts = [
    'pass1' => 'Všechna pole musí být vyplněna',
    'pass2' => 'Hesla se neshodují',
    'pass3' => 'Staré heslo je špatné',
];
$name = ucfirst($_SESSION['user']['username']);
?>
<?php require_once 'components/sidebar.php'; ?>
<div class="container mb-5 pb-5 container-fade overflow-hidden" id="adminPanel">
    <div class="row">
        <div class="col">
            <?php if (isset($_GET['alert']) && isset($alerts[$_GET['alert']])): ?>
                <div class="alert alert-danger" role="alert"><?= $alerts[$_GET['alert']] ?></div>
            <?php endif; ?>
            <div class="col-12">
                <?php

                $tiles[] = ["id" => "hello-name", "title" => "Ahoj, $name", "size" => "col-md-6 col-lg-4"];
                $tiles[] = ["title" => "Kontaktní údaje", "icon" => "fa-address-book", "link" => "contactDetails", "size" => "col-md-3 col-lg-2"];
                $tiles[] = ["title" => "Alba", "icon" => "fa-photo-video", "link" => "manage", "size" => "col-md-3 col-lg-2"];
                $tiles[] = ["id" => "time-now", "title" => "Aktuální čas", "size" => "col-md-6 col-lg-4"];
                $tiles[] = ["id" => "server-load", "title" => "Vytížení serveru", "icon" => "fa-microchip", "size" => "col-md-6 col-lg-4"];
                $tiles[] = ["id" => "storage-load", "title" => "Využité uložiště", "icon" => "fa-hard-drive", "size" => "col-md-6 col-lg-4"];

                if ($_SESSION['user']['admin'] >= 10) {
                    $tiles[] = ["title" => "Správa uživatelů", "icon" => "fa-users", "link" => "users", "size" => "col-md-3 col-lg-2"];
                    $tiles[] = ["link" => 'logout', "title" => "Odhlásit se", "icon" => "fa-right-from-bracket", "size" => "col-md-3 col-lg-2"];
                } else {
                    $tiles[] = ["link" => 'logout', "title" => "Odhlásit se", "icon" => "fa-right-from-bracket", "size" => "col-md-6 col-lg-4"];
                }
                $tiles[] = ["title" => "Texty na hl. stránce", "icon" => "fa-font", "link" => "texts", "size" => "col-md-3 col-lg-2", "disabled" => true];
                $tiles[] = ["title" => "Nastavení", "icon" => "fa-cog", "link" => "settings", "size" => "col-md-3 col-lg-2", "disabled" => true];
                $tiles[] = ["title" => "Nahrát fotky", "icon" => "fa-cloud-arrow-up", "link" => 'upload', 'size' => 'col-md-3 col-lg-2', "disabled" => true];
                //                $tiles[] = ["title" => "Změnit heslo", "icon" => "fa-key", "link" => "password", "size" => "col-md-3 col-lg-2", "disabled" => true];
                $tiles[] = ["title" => "Zprávy", "icon" => "fa-message", "link" => "messages", "size" => "col-md-3 col-lg-2", "disabled" => true];
                $tiles[] = ["title" => "Blog", "icon" => "fa-book", "link" => "stats", "size" => "col-md-6 col-lg-4", "disabled" => true];
                $tiles[] = ["id" => "last-update", "title" => "Poslední aktualizace", "icon" => "fa-message", "size" => "col-md-6 col-lg-6"];
                $tiles[] = ["id" => "hukot-status", "title" => "Stav Hukot", "icon" => "fa-server", "size" => "col-md-6 col-lg-6"];

                $load = sys_getloadavg();
                $cpuCores = (int)trim(shell_exec("nproc"));
                $loadPercent = array_map(fn($l) => min(100, round(($l / $cpuCores) * 100)), $load);

                $total = disk_total_space('/');
                $free = disk_free_space('/')
                ?>
                <div class="d-none" id="data-loads" data-loads="[<?= implode(', ', $loadPercent) ?>]"></div>
                <div class="d-none" id="data-storage" data-loads="[<?= $free ?>, <?= $total ?>]"></div>
                <div class="container mt-5">
                    <div class="row row-cols-md-3 row-cols-lg-4 g-3">
                        <?php foreach ($tiles as $tile): ?>
                        <div class=" <?= $tile['size'] ?> d-flex tile">
                            <<?= isset($tile['link']) ? 'a href="/' . $tile['link'] . '"' : 'button' ?> class="btn
                            btn-secondary card d-flex flex-column h-100 w-100 text-dark text-decoration-none text-center
                            p-3 <?= ($tile['disabled']??false) ? 'disabled' : false ?>">
                            <div class="card-body d-flex flex-column justify-content-center align-items-center">
                                <i class="fa <?= $tile['icon'] ?? '' ?> fa-2x"></i>
                                <h5 id="<?= $tile['id'] ?? '' ?>" class="card-title mt-2"><?= $tile['title'] ?></h5>
                            </div>
                        </<?= isset($tile['link']) ? 'a' : 'button' ?>>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>
</div>
</div>

<div class="modal fade" id="statusModal" tabindex="-1" aria-labelledby="statusModal" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Stav Hukot</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div id="hukot-status-table"></div>
            </div>
        </div>
    </div>
</div>

