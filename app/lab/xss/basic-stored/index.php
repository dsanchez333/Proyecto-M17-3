<?php
require("../../../lang/lang.php");
$strings = tr();

$db = new PDO('sqlite:database.db');
session_start();

if (isset($_POST['uname']) && isset($_POST['passwd'])) {
  $q = $db->prepare("SELECT * FROM users WHERE username=:user AND password=:pass");
  $q->execute(array(
    'user' => $_POST['uname'],
    'pass' => $_POST['passwd']
  ));
  $_select = $q->fetch();
  if ($_select) { // Verificar si se encontró un usuario
    $_SESSION['username'] = htmlspecialchars($_POST['uname']); // Escapar el nombre de usuario antes de almacenarlo en la sesión

    header("Location: stored.php");
    exit;
  } else {
    echo '<h1>' . htmlspecialchars($strings['wrong_credentials']) . '</h1>'; // Escapar el mensaje de error
  }
}

?>

<!doctype html>
<html lang="en">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- Bootstrap CSS -->
  <link rel="stylesheet" type="text/css" href="bootstrap.min.css">

  <title><?php echo htmlspecialchars($strings['title']); ?></title>
</head>

<body>
  <div class="container d-flex justify-content-center">
    <div class="shadow p-3 mb-5 rounded column" style="text-align: center; max-width: 1000px;margin-top:15vh;">
      <h4>VULNLAB</h4>

      <form action="#" method="POST" style="text-align: center;margin-top: 20px;padding:30px;">
        <div class="row mb-3">
          <label for="inputEmail3" class="col-sm-2 col-form-label"><?php echo htmlspecialchars($strings['user']); ?></label> <!-- Escapar la etiqueta del campo -->
          <div class="col-sm-10">
            <input type="text" class="form-control" name="uname" id="inputEmail3">
          </div>
        </div>
        <div class="row mb-3">
          <label for="inputPassword3" class="col-sm-2 col-form-label"><?php echo htmlspecialchars($strings['pass']); ?></label> <!-- Escapar la etiqueta del campo -->
          <div class="col-sm-10">
            <input type="password" class="form-control" name="passwd" id="inputPassword3"> <!-- Cambiar el tipo de input a "password" para ocultar la contraseña -->
          </div>
        </div>
        <button type="submit" class="btn btn-primary"><?php echo htmlspecialchars($strings['submit']); ?></button> <!-- Escapar el texto del botón -->
        <p><?php echo htmlspecialchars($strings['default_creds']); ?></p> <!-- Escapar el mensaje -->
      </form>
    </div>
  </div>
  <script id="VLBar" title="<?= htmlspecialchars($strings['title']) ?>" category-id="1" src="/public/assets/js/vlnav.min.js"></script>
</body>

</html>
