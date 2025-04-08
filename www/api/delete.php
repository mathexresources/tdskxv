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

$data = json_decode(file_get_contents('php://input'), true);
$filename = isset($data['filename']) ? basename($data['filename']) : '';

$response = ['success' => false];

if ($filename && file_exists("$photosPath/$filename")) {
    if (unlink("$photosPath/$filename")) {
        $response['success'] = true;
    } else {
        $response['error'] = 'Unable to delete file';
    }
} else {
    $response['error'] = 'File not found';
}

header('Content-Type: application/json');
echo json_encode($response);
?>
