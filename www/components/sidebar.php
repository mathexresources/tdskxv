<?php
$path = $_SERVER['REQUEST_URI'];
?>
<style>
    .active {
        background-color: #212529 !important;
    }
</style>
<div class="col">
    <div class="position-fixed top-0 d-flex flex-column flex-shrink-0 p-3 bg-body-tertiary"
         style="width: 280px; height: 100vh">
        <a href="/admin" class="mb-3 mb-md-0 me-md-auto link-body-emphasis text-decoration-none fs-4 text-center">Administrace
        </a>
        <hr>
        <ul class="nav nav-pills flex-column mb-auto">
            <li class="nav-item">
                <a href="/admin" class="nav-link <?= ($path == '/admin') ? 'active' : 'text-dark' ?>">
                    <i class="fa fa-user-tie pe-none me-2"></i>
                    Administrace
                </a>
            </li>
            <li class="nav-item">
                <a href="/manage" class="nav-link  <?= ($path == '/manage') ? 'active' : 'text-dark' ?>">
                    <i class="fa fa-photo-video pe-none me-2"></i>
                    Alba
                </a>
            </li>
            <li class="nav-item">
                <a href="/texts" class="nav-link disabled">
                    <i class="fa fa-font pe-none me-2"></i>
                    Texty na hl. stránce
                </a>
            </li>
            <li class="nav-item">
                <a href="/contactDetails"
                   class="nav-link  disabled">
                    <i class="fa fa-address-book pe-none me-2"></i>
                    Kontaktní údaje
                </a>
            </li>
            <li class="nav-item">
                <a href="/stats" class="nav-link disabled">
                    <i class="fa fa-book pe-none me-2"></i>
                    Blog
                </a>
            </li>
            <li class="nav-item">
                <a href="/stats" class="nav-link disabled">
                    <i class="fa fa-gears pe-none me-2"></i>
                    Nastavení
                </a>
            </li>
            <li class="nav-item">
                <a href="/stats" class="nav-link disabled">
                    <i class="fa fa-cloud-upload pe-none me-2"></i>
                    Nahrát fotky
                </a>
            </li>
            <li class="nav-item">
                <a href="/stats" class="nav-link disabled">
                    <i class="fa fa-message pe-none me-2"></i>
                    Zprávy
                </a>
            </li>
            <?php if ($_SESSION['user']['admin'] >= 10) { ?>
                <hr>
            <?php } ?>
            <?php if ($_SESSION['user']['admin'] >= 10) { ?>
                <li class="nav-item">
                    <a href="/users" class="nav-link  <?= ($path == '/users') ? 'active' : 'text-dark' ?>">
                        <i class="fa fa-users pe-none me-2"></i>
                        Správa uživatelů
                    </a>
                </li>
            <?php } ?>
            <hr>
            <li class="nav-item">
                <a href="/" class="nav-link  <?= ($path == '/') ? 'active' : 'text-dark' ?>">
                    <i class="fa fa-globe pe-none me-2"></i>
                    Zpět na Web
                </a>
            </li>
        </ul>
        <hr>
        <div class="dropdown">
            <a href="#"
               class="d-flex align-items-center link-body-emphasis text-decoration-none dropdown-toggle"
               data-bs-toggle="dropdown" aria-expanded="false">
                <i class="rounded-circle me-2 fa <?= $_SESSION['user']['icon'] ?>" width="32" height="32"></i>
                <strong><?= ucfirst($_SESSION['user']['username']) ?></strong>
            </a>
            <ul class="dropdown-menu text-small shadow">
                <li><a class="dropdown-item" data-bs-toggle="modal" data-bs-target="#changePasswordModal" href="#">Změnit
                        heslo</a></li>
                <!--                <li><a class="dropdown-item" href="#">Settings</a></li>-->
                <!--                <li><a class="dropdown-item" href="#">Profile</a></li>-->
                <li>
                    <hr class="dropdown-divider">
                </li>
                <li><a class="dropdown-item" href="/logout">Odhlásit se</a></li>
            </ul>
        </div>
    </div>
</div>

<div class="modal fade" id="changePasswordModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
     aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="staticBackdropLabel">Změna hesla</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="/save/password.php" method="post">
                <div class="modal-body">
                    <input type="hidden" name="id" value="<?= $_SESSION['user']['id'] ?>">
                    <div class="mb-3">
                        <label for="oldPassword" class="form-label">Staré heslo</label>
                        <input type="password" class="form-control" id="oldPassword" name="oldPassword" required>
                    </div>
                    <div class="mb-3">
                        <label for="newPassword" class="form-label">Nové heslo</label>
                        <input type="password" class="form-control" id="newPassword" name="newPassword" required>
                    </div>
                    <div class="mb-3">
                        <label for="newPassword2" class="form-label">Nové heslo znovu</label>
                        <input type="password" class="form-control" id="newPassword2" name="newPassword2" required>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Zrušit</button>
                        <button type="submit" class="btn btn-danger">Změnit</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
