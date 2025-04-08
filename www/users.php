<?php
require_once '../fileHead.php';

if (!isset($_SESSION['admin']) || !$_SESSION['admin']) {
    header('Location: /login');
    die('<script>window.location = "/login";</script>');
    exit();
}

if (!isset($_SESSION['user']['admin']) || $_SESSION['user']['admin'] < 10) {
    header('Location: /admin');
    die('<script>window.location = "/admin";</script>');
    exit();
}

$users = $db->query("SELECT * FROM users WHERE deleted = 0")->fetch_all(MYSQLI_ASSOC);
?>
<?php require_once 'components/sidebar.php'; ?>
<div class="container container-fade">
    <?php require_once 'components/breadcrumbs.php'; ?>
    <div class="row">
        <h1 class="my-3">Správa uživatelů</h1>
        <div class="col-5">
            <table class="table table-striped">
                <thead>
                <colgroup>
                    <col span="1" style="width: 5%;">
                    <col span="1" style="width: 25%;">
                    <col span="1" style="width: 35%;">
                    <col span="1" style="width: 10%;">
                    <col span="1" style="width: 20%;">


                </colgroup>
                <tr>
                    <th scope="col">ID</th>
                    <th scope="col">Jméno</th>
                    <th scope="col">Email</th>
                    <th scope="col">Admin</th>
                    <th scope="col">Akce</th>
                </tr>
                </thead>
                <tbody>
                <?php
                foreach ($users as $user) {
                    echo '<tr>';
                    echo '<th scope="row">' . $user['id'] . '</th>';
                    echo '<td>' . $user['username'] . '</td>';
                    echo '<td>' . $user['email'] . '</td>';
                    echo '<td>' . $user['admin'] . '</td>';
                    echo '<td>';
                    echo '<a href="/user?id=' . $user['id'] . '" class="btn btn-link text-dark hover-text-dark"><i class="fa fa-pen"></i></a>';
                    echo '<a href="/deleteUser?id=' . $user['id'] . '" class="btn btn-link text-dark text-danger-hover"><i class="fa fa-trash"></i></a>';
                    echo '</td>';
                    echo '</tr>';
                }
                ?>
                </tbody>
            </table>
        </div>
        <div class="col-7">
            <h2>Přidat uživatele</h2>
            <form action="/save/users.php" method="post">
                <div id="userInputs">
                </div>
                <div class="text-center d-flex justify-content-center align-items-center">
                    <div class="mx-4 w-100 border border-dark-subtle"></div>
                    <button type="button" id="addUser" onclick="generateRow()" class="btn rounded-circle bg-dark-subtle text-dark"><i class="fa fa-plus"></i></button>
                    <div class="mx-4 w-100 border border-dark-subtle"></div>
                </div>
                <button type="submit" class="btn btn-dark mb-3">Přidat</button>
            </form>
        </div>
    </div>
</div>
