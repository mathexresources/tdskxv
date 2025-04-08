<?php
require_once '../../fileHead.php';

if (!isset($_SESSION['admin']) || !$_SESSION['admin']) {
    http_response_code(403);
    echo json_encode(['success' => false, 'error' => 'Unauthorized']);
    exit();
}

$id = isset($_GET['id']) ? htmlspecialchars($_GET['id']) : '';
$album = new Album($id, $db);
$photosPath = $_SERVER['DOCUMENT_ROOT'] . $album->getAlbumPath();

if (!is_dir($photosPath)) {
    mkdir($photosPath, 0755, true);
}

$response = ['success' => false, 'files' => []];

if (!empty($_FILES['images']['name'][0])) {
    foreach ($_FILES['images']['tmp_name'] as $key => $tmpName) {
        $fileName = uniqid('photo_') . 'www' . pathinfo($_FILES['images']['name'][$key], PATHINFO_EXTENSION);
        $filePath = $photosPath . '/' . $fileName;

        if (move_uploaded_file($tmpName, $filePath)) {
            $response['files'][] = $fileName;
        }
    }

    if (!empty($response['files'])) {
        $response['success'] = true;
    }
}

header('Content-Type: application/json');
echo json_encode($response);
