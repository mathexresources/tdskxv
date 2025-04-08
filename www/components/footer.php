<?php
if (isset($CONF_NO_FOOTER_PAGES) && in_array($page, $CONF_NO_FOOTER_PAGES)) {
    return;
}
?>

<footer class=" text-center py-4">
    <!-- Copyright Section -->
    <div class="container">
        <p class="mb-0">
            &copy; <?= date('Y') ?> TDSKXV | Všechna práva vyhrazena
        </p>
        <div class="mt-3">
            <a href="https://facebook.com" class="text-muted mx-2" target="_blank"><i class="fab fa-facebook-f"></i></a>
            <a href="https://twitter.com" class="text-muted mx-2" target="_blank"><i class="fab fa-twitter"></i></a>
            <a href="https://instagram.com" class="text-muted mx-2" target="_blank"><i class="fab fa-instagram"></i></a>
            <!-- Add more social media links here -->
        </div>
    </div>
</footer>

