<?php

include("user.php");
include("permission.php");
require("../../../lang/lang.php");

error_reporting(0);
ini_set('display_errors', 0);

$strings = tr();
$user;

if (isset($_COOKIE['Z3JhbnQtZnVsbC1wcml2aWxpZ2VzCg'])) {
    try {
        $user = unserialize(urldecode(base64_decode($_COOKIE['Z3JhbnQtZnVsbC1wcml2aWxpZ2VzCg'])));
        checkCookieIntegrity($user);
    } catch (Exception $e) {
        redirectToLogin();
    }
} else {
    redirectToLogin();
}

function checkCookieIntegrity($user) {
    // Aquí puedes agregar lógica adicional para verificar la integridad de la cookie si es necesario
    // Por ejemplo, podrías comparar algún valor dentro del objeto $user con la cookie actual
    // Si la cookie no es válida, redirige a login.php
    if (!isValidCookie($user)) {
        redirectToLogin();
    }
}

function isValidCookie($user) {
    // Lógica para verificar la validez de la cookie (puedes personalizar esto según tus necesidades)
    // Retorna true si la cookie es válida, false de lo contrario
    // Aquí puedes comparar algún valor dentro del objeto $user con la cookie actual
    return true;
}

function redirectToLogin() {
    header("Location: login.php?msg=2");
    exit;
}

function canDo($action, $strings) {
    return $action === 1 ? $strings['yes-sir'] : $strings['no-sir'];
}

?>

<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
<!------ Include the above in your HEAD tag ---------->

<!DOCTYPE html>
<html lang='en' class=''>
<head>
    <style>
        h1 {
            text-align: center;
        }
    </style>
    <link rel='stylesheet prefetch' href='css/normalize.min.css'>
    <script src='js/prefixfree.min.js'></script>
</head>
<body>
    <div style="text-align: middle">
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
        echo "<h1>" . $strings['delete'] . " : " . canDo($delete, $strings) . "</h1>";
        echo "<h1>" . $strings['update'] . " : " . canDo($update, $strings) . "</h1>";
        echo "<h1>" . $strings['add'] . " : " . canDo($add, $strings) . "</h1>";
        if ($delete === 1 && $add === 1 & $update === 1) {
            echo "<h1>" . $strings['you-have-all-priviliges'] . "</h1>";
        }
        ?>
    </div>
</body>
</html>