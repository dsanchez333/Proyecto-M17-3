<?php
include("user.php");
include("permission.php");
require("../../../lang/lang.php");
error_reporting(0);
ini_set('display_errors', 0);
$strings = tr();
$user;

// Verificar si la cookie existe
if (isset($_COOKIE['Z3JhbnQtZnVsbC1wcml2aWxpZ2VzCg'])) {
    $cookieValue = $_COOKIE['Z3JhbnQtZnVsbC1wcml2aWxpZ2VzCg'];

    // Verificar la integridad de la cookie usando HMAC
    $secretKey = "tu_clave_secreta_aqui"; // Reemplaza esto con tu clave secreta
    list($userData, $signature) = explode(':', $cookieValue);
    
    // Calcular la firma HMAC
    $expectedSignature = hash_hmac('sha256', $userData, $secretKey);

    // Verificar si la firma es válida
    if ($signature === $expectedSignature) {
        // La cookie es válida, continuar con el código actual
        try {
            $user = unserialize(urldecode(base64_decode($userData)));
        } catch (Exception $e) {
            header("Location: login.php?msg=3");
        }
    } else {
        // La cookie ha sido modificada, redirigir al usuario a login.php
        header("Location: login.php?msg=4");
        exit();
    }
} else {
    // Si no hay cookie, redirigir a login.php
    header("Location: login.php?msg=2");
    exit();
}
?>

<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
<!------ Include the above in your HEAD tag ---------->

<!DOCTYPE html><html lang='en' class=''>
<head>
<style>
h1{
    text-align: center;
 }
</style>
<link rel='stylesheet prefetch' href='css/normalize.min.css'><script src='js/prefixfree.min.js'></script>
</head><body>
<div style = "text-align:middle">
<?php
  echo "<h1>";
  echo $strings['welcome-test'];
  echo "</h1>";
 
  echo "<h1>";
  echo $strings["what-can-you-do"];
  echo "</h1>";
  $permissions = $user->permissions;
  $delete = $permissions->canDelete;
  $update = $permissions->canUpdate;
  $add = $permissions->canAdd;
  echo "<h1>".$strings['delete']." : ".canDo($delete,$strings)."</h1>";
  echo "<h1>".$strings['update']." : ".canDo($update,$strings)."</h1>";
  echo "<h1>".$strings['add']." : ".canDo($add,$strings)."</h1>";
  if( $delete === 1 && $add === 1 & $update === 1){
      echo "<h1>".$strings['you-have-all-priviliges']."</h1>";;
  }
?>
</div>
</body>
<script id="VLBar" title="<?= $strings['title']; ?>" category-id="9" src="/public/assets/js/vlnav.min.js"></script>
</html>