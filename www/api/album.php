<?php
require_once '../../fileHead.php';
header('Content-Type: application/json');

if (!isset($_SESSION['user']['admin']) || !$_SESSION['user']['admin']) {
    echo json_encode(['success' => false, 'message' => 'Unauthorized access.']);
    exit();
}

if (!isset($_POST['action'], $_POST['albumId'])) {
    echo json_encode(['success' => false, 'message' => 'Missing required parameters.']);
    exit();
}


if ($_POST['action'] === 'delete') {
    $id = $_POST['albumId'];
    $album = new Album($id, $db);
    if (!is_numeric($id)) {
        echo json_encode(['success' => false, 'message' => 'Invalid album ID.']);
        exit();
    }

    $album->switchDeleted();

    //if (!$stmt) {
    //    echo json_encode(['success' => false, 'message' => 'Database error: ' . $db->error]);
    //    exit();
    //}

    //$stmt->bind_param('i', $id);
    //$success = $stmt->execute();

    //if ($success) {
        echo json_encode(['success' => true, 'message' => 'Album deleted successfully.', 'albumId' => $id]);
    //} else {
    //    echo json_encode(['success' => false, 'message' => 'Failed to delete album.']);
    //}

    //$stmt->close();
    exit();
}

if ($_POST['action'] === 'create') {
    //create album in database
    $userId = $_SESSION['user']['id'];
    $sql = "INSERT INTO albums (name, created_by, texts, deleted) VALUES ('Nové album', $userId, '{}', 1)";
    $db->query($sql);
    $albumId = $db->insert_id;
    mkdir('../img/albums/' . $albumId);
    //copy thumbnail.jpg to new album
    copy('../img/albums/default/thumbnail.jpg', '../img/albums/' . $albumId . '/thumbnail.jpg');
    echo json_encode(['success' => true, 'id' => $albumId, 'message' => 'Album created successfully.', 'albumId' => $albumId]);
    exit();
}

if ($_POST['action'] === 'update') {
    $id = $_POST['albumId'];
    $key = $_POST['key'];
    $value = $_POST['value'];
    $sql = "UPDATE albums SET $key = '$value' WHERE id = $id";
    $db->query($sql);
    echo json_encode(['success' => true]);
    exit();
}

echo json_encode(['success' => false, 'message' => 'Invalid action.']);
exit();
