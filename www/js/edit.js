$(document).ready(function () {
    $('#description').trumbowyg({
        btns: [
            ['strong', 'em', 'del', 'underline'], // Text formatting
            ['link'] // Keep only links
        ],
        removeformatPasted: true, // Remove unwanted styles when pasting
        autogrow: true,
    });
});

$(document).ready(function () {
    let typingTimer;
    let doneTypingInterval = 1000;

    $(".auto-save").on("input", function () {
        let inputField = $(this);
        clearTimeout(typingTimer);

        typingTimer = setTimeout(function () {
            saveInput(inputField);
        }, doneTypingInterval);
    });

    $('.auto-save').on('tbwchange', function () {
        let inputField = $(this);
        clearTimeout(typingTimer);

        typingTimer = setTimeout(function () {
            saveInput(inputField);
        }, doneTypingInterval);
    });

    function saveInput(inputField) {
        let inputId = inputField.attr("id");
        let inputValue = inputField.val();
        let albumId = new URLSearchParams(window.location.search).get('id');
        $.ajax({
            url: '/api/album.php',
            type: 'POST',
            data: {
                action: 'update',
                albumId: albumId,
                key: inputId,
                value: inputValue
            },
            success: function (result) {
                console.log("Saved successfully:", result);
                savedAlert();
            }
        });
    }
});


alertDiv = document.getElementById('savedAlert');

function savedAlert() {
    let alertDiv = document.getElementById('savedAlert');
    alertDiv.style.display = "block";
    void alertDiv.offsetWidth;

    alertDiv.classList.remove('d-none', 'animate__fadeOutDownBig');
    alertDiv.classList.add('animate__fadeInUpBig', 'd-flex');

    alertDiv.addEventListener('animationend', () => {
        alertDiv.classList.remove('animate__fadeInUpBig');
        alertDiv.classList.add('animate__fadeOutDownBig');

        alertDiv.addEventListener('animationend', () => {
            alertDiv.classList.add('d-none');
            alertDiv.classList.remove('d-flex', 'animate__fadeOutDownBig');
        });
    });
}