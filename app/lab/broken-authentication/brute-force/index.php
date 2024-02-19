<?php
require("../../../lang/lang.php");
$strings = tr();
require("brute.php");


// Inicialitzem la sessio dels intents de login i per fer el ban de temps
session_start();

// Comprovem si els intetns de login i de ban de temps estan establerts, si no, els establim a valors per defecte, 0 en el nostre cas
if (!isset($_SESSION['login_attempts'])) {
    $_SESSION['login_attempts'] = 0;
}

if (!isset($_SESSION['ban_timestamp'])) {
    $_SESSION['ban_timestamp'] = 0;
}

// Funció que comprova si el usuari està banejat
function isBanned()
{
    // Establim la duració del ban a segons (1 dia)
    $banDuration = 86400;

    // Comprovem si el temps del ban està dins de la duració del ban 
    return (time() - $_SESSION['ban_timestamp']) < $banDuration;
}

// Funció que comprova si els intents de login han estat excedits
function isBruteForceAttempt()
{
    // Establim un màxim d'intents per logejar-te
    $maxAttempts = 3;

    // Increment d'intents de login
    $_SESSION['login_attempts']++;

    // Comprovem si l'usuari està banned
    if (isBanned()) {
        return true;
    }

    // Comprovem si els intents de login han excedit el limit
    if ($_SESSION['login_attempts'] > $maxAttempts) {
        // Estableix el temps de ban a l'hora actual 
        $_SESSION['ban_timestamp'] = time();
        return true;
    }

    return false;
}

// Comprova els intents d'iniciar sessió (assegurem atacs de força bruta)
if (isBruteForceAttempt()) {
    // Missatge que mostrem per pantalla
    echo "Masses intents! Torna-ho a provar en una estona.";
    exit();
}
?>
<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" type="text/css" href="./css/bootstrap.min.css">

    <title><?= $strings["title"]; ?></title>
</head>

<body>
    <div class="container d-flex justify-content-center">
        <div class="shadow p-3 mb-5 rounded column" style="text-align: center; max-width: 1000px;margin-top:15vh;">
            <h3><?= $strings["login"]; ?></h3>

            <form action="#" method="POST" class="justify-content-center" style="text-align: center;margin-top: 20px;padding:30px;">
                <div class="justify-content-center row mb-3">
                    <label for="inputUsername3" class=" text-center col-form-label"><?= $strings["username"]; ?></label>
                    <div class="col-sm-10">
                        <input type="text" class="justify-content-center form-control" name="username" id="inputUsername3">
                    </div>
                </div>
                <div class="justify-content-center row mb-3">
                    <label for="inputPassword3" class="text-center col-form-label"><?= $strings["password"]; ?></label>
                    <div class="col-sm-10">
                        <input type="password" class="justify-content-center form-control" name="password" id="inputPassword3">
                    </div>
                </div>
                <button type="submit" class="btn btn-primary"><?= $strings["submit"]; ?></button>
                <p class="mt-3"><?= $strings["hint"]; ?></p>
                <?php
                echo '<h1> '.$html.' </h1>'; 
                ?>

            </form>


        </div>
    </div>
    <script id="VLBar" title="<?= $strings["title"]; ?>" category-id="10" src="/public/assets/js/vlnav.min.js"></script>


</body>

</html>