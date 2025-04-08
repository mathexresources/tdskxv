<?php
require_once '../fileHead.php';

if (!isset($_SESSION['admin']) || !$_SESSION['admin']) {
    header('Location: /login');
    die('<script>window.location = "/login";</script>');
    exit();
}

$id = isset($_GET['id']) ? htmlspecialchars($_GET['id']) : '';
$album = new Album($id, $db);
$photosPath = $_SERVER['DOCUMENT_ROOT'] . $album->getAlbumPath();
$photos = array_diff(scandir($photosPath), ['.', '..']);
$photosPlaceholders = max(0, 12 - count($photos));
?>

<?php require_once 'components/sidebar.php'; ?>
<div class="container">
    <?php require_once 'components/breadcrumbs.php'; ?>
    <div class="row">
        <h1 class="my-3">Úprava alba</h1>
        <div class="col-6">
            <form>
                <div class="input-group mb-3">
                    <span class="input-group-text"><i class="fa fa-user"></i></span>
                    <div class="form-floating">
                        <input type="text" class="form-control auto-save" id="name" placeholder="Název" value="<?=$album->getName()?>">
                        <label for="name">Název</label>
                    </div>
                </div>
                <div class="input-group mb-3">
                    <span class="input-group-text"><i class="fa fa-location-dot"></i></span>
                    <div class="form-floating">
                        <input type="text" class="form-control auto-save" id="location" placeholder="Lokace" value="<?=$album->getLocation()?>">
                        <label for="location">Lokace</label>
                    </div>
                </div>
                <div class="input-group mb-3">
                    <span class="input-group-text"><i class="fa fa-quote-right"></i></span>
                    <div class="form-floating">
                        <textarea class="form-control auto-save" placeholder="Popis" rows="5" id="description" style="height: 100px"><?=$album->getDescription()?></textarea>
                        <label for="floatingTextarea2">Popis</label>
                    </div>
                </div>
            </form>
        </div>


        <div class="col-6">
            <input type="file" id="fileInput" multiple accept="image/*" hidden>
            <div id="dropArea"
                 class="position-relative overflow-hidden row row-cols-3 row-cols-md-4 g-2 border border-dark border-2 border-striped p-2 rounded rounded-3"
                 style="border-style: dashed !important; cursor: pointer; min-height: 70vh; overflow-y: auto;">
                <div class="position-absolute w-100 h-100 d-flex justify-content-center align-items-center">
                    <div class="text-center">
                        <i class="fa fa-folder-open fa-4x text-muted"></i>
                        <p class="text-muted pt-3 text-center">Přetáhněte fotky, nebo vyberte soubory</p>
                    </div>
                </div>
                <?php foreach ($photos as $photo): ?>
                    <div class="col uploaded-photo">
                        <div class="ratio ratio-1x1 rounded border hover-delete-icon">
                            <img src="<?= $album->getAlbumPath() . $photo ?>" class="img-fluid rounded w-100 h-100"
                                 alt="<?= $photo ?>" style="object-fit: cover; cursor: pointer;"
                                 data-filename="<?= $photo ?>">
                            <i class="fas fa-trash text-white bg-danger p-2 rounded-circle position-absolute top-0 end-0 m-2 delete-icon"
                               style="display: none; cursor: pointer;"></i>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</div>

<div id="savedAlert" class="animate__animated d-none position-fixed top-50 start-50 translate-middle p-4 rounded">
    <i class="text-success fa fa-check-circle mr-2 fa-4x"></i>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        let dropArea = document.getElementById('dropArea');
        let fileInput = document.getElementById('fileInput');

        // Listen for clicks on the drop area, but prevent clicking on images
        dropArea.addEventListener('click', (e) => {
            // If clicking on an image, prevent default behavior
            if (e.target.tagName === 'IMG') {
                e.stopPropagation(); // Stop the event from bubbling up
                e.preventDefault(); // Ensure the file input does not trigger
                deleteImage(e.target); // Call delete function
            } else {
                fileInput.click();
            }
        });

        // File input event listener
        fileInput.addEventListener('change', (e) => uploadFiles(e.target.files));

        // Drag & drop handlers with shake effect on invalid drop
        dropArea.addEventListener('dragover', (e) => {
            e.preventDefault();
            dropArea.classList.add('border-primary');
        });

        dropArea.addEventListener('dragleave', () => {
            dropArea.classList.remove('border-primary');
        });

        dropArea.addEventListener('drop', (e) => {
            e.preventDefault();
            dropArea.classList.remove('border-primary');

            let validFiles = [...e.dataTransfer.files].filter(file => file.type.startsWith('image/'));
            if (validFiles.length === 0) {
                dropArea.style.animation = 'shake 0.3s';
                setTimeout(() => dropArea.style.animation = '', 300);
                return;
            }

            uploadFiles(validFiles);
        });

        // Upload images via AJAX with fade-in animation
        function uploadFiles(files) {
            if (files.length === 0) return;

            let formData = new FormData();
            for (let file of files) {
                if (!file.type.startsWith('image/')) continue;
                formData.append('images[]', file);
            }

            fetch('api/upload.php?id=<?= $id ?>', {
                method: 'POST',
                body: formData
            })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        data.files.forEach(file => {
                            let imgContainer = document.createElement('div');
                            imgContainer.classList.add('col', 'uploaded-photo');
                            imgContainer.innerHTML = `
                        <div class='ratio ratio-1x1 rounded border hover-delete-icon position-relative'>
                            <img src='<?= $album->getAlbumPath() ?>${file}' class='img-fluid rounded w-100 h-100'
                                 style='object-fit: cover; cursor: pointer;' data-filename='${file}'>
                            <i class="fas fa-trash text-white bg-danger p-2 rounded-circle position-absolute top-0 end-0 m-2 delete-icon"></i>
                        </div>`;
                            dropArea.appendChild(imgContainer);
                            setTimeout(() => imgContainer.classList.add('show'), 50);
                        });
                    } else {
                        alert('Error uploading images');
                    }
                })
                .catch(error => {
                    console.error('Upload error:', error);
                    alert('Error uploading images');
                });
        }

        // Function to delete an image with fade-out effect
        function deleteImage(imgElement) {
            let filename = imgElement.getAttribute('data-filename');
            if (!filename || !confirm(`Opravdu chcete smazat ${filename}?`)) return;

            fetch('api/delete.php?id=<?= $id ?>', {
                method: 'POST',
                headers: {'Content-Type': 'application/json'},
                body: JSON.stringify({filename: filename})
            })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        let parentDiv = imgElement.closest('.uploaded-photo');
                        parentDiv.style.opacity = '0';
                        parentDiv.style.transform = 'scale(0.8)';
                        setTimeout(() => parentDiv.remove(), 300);
                    } else {
                        alert('Error deleting image');
                    }
                })
                .catch(error => {
                    console.error('Delete error:', error);
                    alert('Error deleting image');
                });
        }
    });

</script>