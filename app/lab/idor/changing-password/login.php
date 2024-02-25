<?php
session_start(); // Iniciar sesión si no está iniciada

// Verificar si el usuario ya inició sesión
if (isset($_SESSION['user_id'])) {
    // Si ya inició sesión, redirigirlo a index.php o cualquier otra página de inicio
    header("Location: index.php");
    exit;
}

require("../../../lang/lang.php");
$strings = tr();

$db = new PDO('sqlite:database.db');

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Consultar la base de datos para verificar las credenciales
    $query = $db->prepare("SELECT * FROM users WHERE email = :email AND password = :password");
    $query->execute(array(
        'email' => $email,
        'password' => $password // En una aplicación real, es importante usar hash de contraseñas en lugar de almacenarlas en texto plano
    ));
    $user = $query->fetch();

    if ($user) {
        // Si las credenciales son válidas, iniciar sesión y redirigir al usuario a index.php
        $_SESSION['user_id'] = $user['id'];
        header("Location: index.php");
        exit;
    } else {
        // Si las credenciales no son válidas, mostrar un mensaje de error
        $error_message = $strings['login_error'];
    }
}
?>

<!DOCTYPE html>
<html lang="<?= $strings['lang']; ?>">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $strings['login_title']; ?></title>
    <link rel="stylesheet" href="bootstrap.min.css">
</head>
<body>
    <div class="container">
        <div class="row pt-5 mt-5 mb-3">
            <div class="col-md-3"></div>
            <div class="col-md-6">
                <h1><?= $strings['login_title']; ?></h1>
            </div>
            <div class="col-md-3"></div>
        </div>
        <div class="row pt-2">
            <div class="col-md-3"></div>
            <div class="col-md-6">
                <?php if (isset($error_message)) echo '<div class="alert alert-danger" role="alert">' . $error_message . '</div>'; ?>
                <form action="index.php" method="post">
                    <div class="mb-3">
                        <label for="email" class="form-label"><?= $strings['email_label']; ?></label>
                        <input class="form-control" type="email" name="email" id="email" required>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label"><?= $strings['password_label']; ?></label>
                        <input class="form-control" type="password" name="password" id="password" required>
                    </div>
                    <div class="d-grid gap-2">
                        <button class="btn btn-primary" type="submit"><?= $strings['login_button']; ?></button>
                    </div>
                </form>
            </div>
            <div class="col-md-3"></div>
        </div>
    </div>
</body>
</html>
