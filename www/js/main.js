$(document).ready(function () {
    const $html = $('html');
    const themeKey = 'bootstrapTheme';
    const themeIcon = $('.themeToggle i');

    // Load saved theme from localStorage
    const savedTheme = localStorage.getItem(themeKey) || 'light';
    $html.attr('data-bs-theme', savedTheme);
    themeIcon.addClass(savedTheme === 'light' ? 'fa-moon' : 'fa-sun');

    // Toggle theme on button click
    $('.themeToggle').click(function () {
        const currentTheme = $html.attr('data-bs-theme');
        const newTheme = currentTheme === 'dark' ? 'light' : 'dark';

        $html.attr('data-bs-theme', newTheme);
        localStorage.setItem(themeKey, newTheme);
        themeIcon.removeClass('fa-moon fa-sun').addClass(newTheme === 'light' ? 'fa-moon' : 'fa-sun');

        // Trigger theme change event so TinyMCE can update
        $(document).trigger('themeChanged');
    });
});
