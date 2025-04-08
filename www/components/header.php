<?php
require_once '../fileHead.php';
if (isset($CONF_NO_HEADER_PAGES) && in_array($page, $CONF_NO_HEADER_PAGES)) {
    return;
}
?>
<div class="container <?= ($page == 'home' || $page == 'album') ? 'position-absolute start-50 translate-middle-x' : '' ?> customNavbar" style="z-index: 3; min-width: 90vw">
    <header class="d-flex flex-wrap justify-content-center py-3 mb-4 border-bottom">
        <a href="/" class="d-flex align-items-center mb-3 mb-md-0 me-md-auto link-body-emphasis text-decoration-none">
            <svg class="bi me-2" width="40" height="32">
                <use xlink:href="#bootstrap"></use>
            </svg>
            <span class="fs-4 asset-regular" style="font-family: Asset !important;">TDSKXV</span>
        </a>

        <ul class="nav col-12 col-md-auto mb-2 justify-content-center mb-md-0">
            <?php
            $fePage = $page ?? 'home';

            $nav = [
                '' => 'Domů',
                'albums' => 'Alba',
                'about' => 'Kdo jsem',
            ];
            if (!empty($_SESSION['admin'])) {
                $nav['admin'] = 'Administrace';
            }

            foreach ($nav as $key => $value) {
                $activeClass = ($key === $fePage) ? 'link-secondary fw-bold' : 'text-black';
                echo '<li><a href="/' . $key . '" class="nav-link  px-2 ' . $activeClass . '">' . $value . '</a></li>';
            }
            ?>
        </ul>
    </header>
</div>