<?php
require("../../../lang/lang.php");
$strings = tr();

$db = new PDO('sqlite:database.db');
session_start();

if (isset($_SESSION['username'])) { // Verificar si hay una sesión activa
  $username = htmlspecialchars($_SESSION['username']); // Escapar el nombre de usuario antes de mostrarlo en la página
  echo "<h1>Welcome, $username!</h1>";
} else {
  header("Location: index.php");
  exit;
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
        <button type="submit" class="btn btn-primary"><?php echo htmlspecialchars($strings['logout']); ?></button>
      </form>
    </div>
  </div>
  <script id="VLBar" title="<?= htmlspecialchars($strings['title']) ?>" category-id="1" src="/public/assets/js/vlnav.min.js"></script>
</body>

</html>
