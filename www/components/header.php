<?php
require_once '../fileHead.php';
if (isset($CONF_NO_HEADER_PAGES) && in_array($page, $CONF_NO_HEADER_PAGES)) {
    return;
}
?>
<nav class="navbar container-fade navbar-expand-md border-bottom customNavbar <?= ($page == 'home' || $page == 'album') ? 'position-absolute start-50 translate-middle-x' : '' ?> mx-auto" style="z-index: 3; width: 90vw;">
    <div class="container-fluid">
        <a href="/" class="navbar-brand d-flex align-items-center">
            <svg class="bi me-2" width="40" height="32">
                <use xlink:href="#bootstrap"></use>
            </svg>
            <span class="fs-4 asset-regular" style="font-family: Asset !important;">TDSKXV</span>
        </a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNavbar" aria-controls="mainNavbar" aria-expanded="false" aria-label="Toggle navigation">
            Menu
        </button>

        <div class="collapse navbar-collapse justify-content-md-end" id="mainNavbar">
            <ul class="navbar-nav mb-2 mb-md-0">
                <?php
                $fePage = $page ?? 'home';

                $nav = [
                    '' => 'Domů',
                    'albums' => 'Alba',
                    'about-me' => 'Kdo jsem',
                ];
                if (!empty($_SESSION['admin'])) {
                    $nav['admin'] = 'Administrace';
                }

                foreach ($nav as $key => $value) {
                    $activeClass = ($key === $fePage) ? 'link-secondary fw-bold' : 'text-black';
                    echo '<li class="nav-item">
                        <a href="/' . $key . '" class="nav-link px-2 ' . $activeClass . '">' . $value . '</a>
                    </li>';
                }
                ?>
            </ul>
        </div>
    </div>
</nav>
