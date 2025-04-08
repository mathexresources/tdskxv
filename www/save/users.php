<?php
require_once '../../fileHead.php';
// Check if the form is submitted via POST
if (!isset($_SESSION['admin']) || !$_SESSION['admin'] || !isset($_SESSION['user']['admin']) || $_SESSION['user']['admin'] < 10) {
    header('Location: /login');
    die('<script>window.location = "/login";</script>');
    exit();
}


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Start a transaction to ensure all rows are inserted or none at all
    $db->begin_transaction();

    try {
        // Loop through the posted data to create rows for each user
        foreach ($_POST['username'] as $key => $username) {
            $email = $_POST['email'][$key];
            $password = $_POST['password'][$key];
            $adminRights = $_POST['admin'][$key];

            // Encrypt the password with the default algorithm (bcrypt)
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

            // Prepare the SQL statement to insert the user data
            $stmt = $db->prepare("INSERT INTO users (username, email, password, admin) VALUES (?, ?, ?, ?)");
            if ($stmt === false) {
                throw new Exception('SQL statement preparation failed: ' . $db->error);
            }

            // Bind the parameters
            $stmt->bind_param("sssi", $username, $email, $hashedPassword, $adminRights);

            // Execute the statement
            if (!$stmt->execute()) {
                throw new Exception('SQL execution failed: ' . $stmt->error);
            }

            // Close the statement for this iteration
            $stmt->close();
        }

        // Commit the transaction
        $db->commit();

        // Redirect or display success message
        echo "Users saved successfully!";
    } catch (Exception $e) {
        // Rollback the transaction in case of error
        $db->rollback();

        // Display error message
        echo "Failed to save users: " . $e->getMessage();
    }
}

header('Location: /users');
die('<script>window.location = "/users";</script>');