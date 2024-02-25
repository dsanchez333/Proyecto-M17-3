<?php
session_start();

// Verificar si el usuario ya está autenticado, si es así, redirigir a index.php
if (isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit;
}

// Verificar si se ha enviado el formulario de inicio de sesión
if (isset($_POST['username']) && isset($_POST['password'])) {
    // Validar las credenciales del usuario en la base de datos (sustituir con tu lógica de autenticación)
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Aquí deberías realizar la validación con tu base de datos
    // Si las credenciales son válidas, iniciar sesión y generar un token único
    // Por ejemplo:
    if ($username === 'usuario' && $password === 'contraseña') {
        // Generar un token único para el usuario
        $token = bin2hex(random_bytes(32));

        // Iniciar sesión y guardar el ID de usuario y el token
        $_SESSION['user_id'] = 1; // ID de usuario obtenido de la base de datos
        $_SESSION['token'] = $token;

        // Redirigir a index.php
        header("Location: index.php");
        exit;
    } else {
        // Si las credenciales no son válidas, mostrar un mensaje de error
        $error = "Usuario o contraseña incorrectos";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
</head>
<body>
    <h1>Login</h1>
    <?php if (isset($error)) : ?>
        <p><?= $error ?></p>
    <?php endif; ?>
    <form action="login.php" method="post">
        <label for="username">Usuario:</label><br>
        <input type="text" id="username" name="username" required><br>
        <label for="password">Contraseña:</label><br>
        <input type="password" id="password" name="password" required><br><br>
        <input type="submit" value="Iniciar sesión">
    </form>
</body>
</html>
