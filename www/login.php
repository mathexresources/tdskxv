<?php
if (isset($_SESSION['admin']) && $_SESSION['admin']) {
    header('Location: /admin');
    exit();
}
?>

<div class="container vh-100 d-flex justify-content-center align-items-center">
    <div class="card shadow p-4" style="width: 400px;">
        <h3 class="text-center mb-4">Administrace</h3>
        <form id="loginForm" novalidate method="post" action="auth.php" name="loginForm">
            <div class="mb-3">
                <label for="email" class="form-label">Email nebo jméno</label>
                <input name="loginForm[email]" type="email" class="form-control" id="email" placeholder="Zadejte email, nebo jméno" required>
                <div class="invalid-feedback">Zadejte platnou emailovou adresu.</div>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Heslo</label>
                <input name="loginForm[password]" type="password" class="form-control" id="password" placeholder="Zadejte heslo" required>
                <div class="invalid-feedback">Heslo musí být minimálně 6 znaků dlouhé.</div>
                <?php
                if (isset($_GET['error'])) {
                    echo '<div class="text-danger">Neplatný email nebo heslo.</div>';
                }
                ?>
            </div>
            <div class="d-grid">
                <button id="loginFormButton" class="btn btn-dark">Přihlásit se</button>
            </div>
        </form>
    </div>
</div>
