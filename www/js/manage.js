$('.deleteAlbum').click(function() {
    var albumId = $(this).data('album-id');
    $.ajax({
        url: '/api/album.php',
        type: 'POST',
        data: {
            action: 'delete',
            albumId: albumId,
            data: ''
        },
        success: function(result) {
            console.log(result);
            window.location.reload();

        }
    });
});

$('.createAlbum').click(function() {
    var albumId = $(this).data('album-id');
    $.ajax({
        url: '/api/album.php',
        type: 'POST',
        data: {
            action: 'create',
            albumId: 0,
            data: ''
        },
        success: function(result) {
            console.log(result);
            window.location.replace('/edit?id=' + result.id);

        }
    });
});
