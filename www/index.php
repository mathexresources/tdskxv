<?php
require_once '../fileHead.php';
$page = $_SERVER['REQUEST_URI'] ?? '';
$page = ltrim($page, '/');
$page = rtrim($page, '/');
$pageArr = explode('?', $page);
$page = $pageArr[0];
$pageget = $pageArr[1] ?? [];
if ($page == '') {
    $page = 'home';
}
?>
<!doctype html>
<html lang="cs">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="/css/bootstrap.min.css" rel="stylesheet">
    <link href="/css/dataTables.dataTables.min.css" rel="stylesheet">
    <script src="https://kit.fontawesome.com/e8daec485b.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="css/main.css">
    <link rel="stylesheet" href="css/animate.css">
    <link rel="stylesheet" href="trumbowyg/dist/ui/trumbowyg.min.css">
    <script src="/js/jquery.min.js"></script>
    <script src="trumbowyg/dist/trumbowyg.min.js"></script>
    <script src="/js/dataTables.min.js"></script>
    <meta name="description"
          content="Hi, I’m Tadeáš, also known as TDSKXV. I’m a graphic artist who works with programs like Adobe Photoshop, Illustrator, and Blender. I enjoy creating 3D designs, posters, and I also like exploring new projects with new techniques.">
    <meta name="keywords"
          content="Tadeáš, TDSKXV, graphic, artist, Adobe, Photoshop, Illustrator, Blender, 3D, designs, posters, creative, projects, new techniques, digital art, design, software">
    <link rel="shortcut icon" href="/img/logo/favicon.png" type="image/x-icon">
    <script src="https://kit.fontawesome.com/e8daec485b.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css">
    <script src="/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Asset&family=Monoton&family=Roboto+Flex:opsz,wght@8..144,100..1000&family=Rubik+Glitch&display=swap"
          rel="stylesheet">
    <?php
    if (file_exists('./css/' . $page . '.css')) {
        echo '<link rel="stylesheet" href="/css/' . $page . '.css">';
    } elseif (str_starts_with($page, 'join/')) {
        echo '<link rel="stylesheet" href="/css/join.css">';
    }
    ?>
    <title><?= $CONF_TITLE ?></title>
    <meta property="og:title" content="TDSKXV"/>
    <meta property="og:description" content="Hi, I’m Tadeáš, also known as TDSKXV. I’m a graphic artist who works with programs like Adobe Photoshop, Illustrator, and Blender. I enjoy creating 3D designs, posters, and I also like exploring new projects with new techniques."/>
    <meta property="og:url" content="https://tdskxv.cz"/>
    <meta property="og:type" content="website"/>
    <meta property="og:image" content="https://tdskxv.cz/img/about-me/1.webp"/>
</head>
<body>
<?php
if ($CONF_DEBUG) {
    print_r($_SESSION);
    echo '<br>';
    echo 'page: ';
    echo $page;
}

if (file_exists($page . '.php')) {
    require_once './components/header.php';
    require_once $page . '.php';
    require_once './components/footer.php';
    if (file_exists('./js/' . $page . '.js')) {
        echo '<script src="js/' . $page . '.js"></script>';
    }
} else
    require_once '404.php';
?>
<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
<script type="application/ld+json">
    {
        "@context": "http://schema.org",
        "@type": "Organization",
        "name": "TDSKXV",
        "url": "https://tdskxv.cz",
        "logo": "https://tdskxv.cz/img/about-me/1.webp"
    }
</script>

</body>
</html>
