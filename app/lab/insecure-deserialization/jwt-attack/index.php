<?php
require "function.php";
require("../../../lang/lang.php");

$key = "dragon";  // Almacena la clave de forma segura (puede ser en un archivo de configuración o variable de entorno)

if(isset($_COOKIE["jwt"])){
    try {
        $decodedJWT = DecodeJWT($_COOKIE["jwt"]);
    } catch(Exception $e){
        // Manejar el error de deserialización de forma segura
        error_log("Error decoding JWT: " . $e->getMessage());
        header("Location:index.php");
    }
}

$lang = tr();

if($_SERVER["REQUEST_METHOD"] == "POST"){
    if(isset($_POST["usernameInput"]) && isset($_POST["passwordInput"]) && $_POST["usernameInput"] != "" && $_POST["passwordInput"] != ""){
        
        $username = filter_input(INPUT_POST, "usernameInput", FILTER_SANITIZE_STRING);
        $password = filter_input(INPUT_POST, "passwordInput", FILTER_SANITIZE_STRING);
        
        $hashedPassword = password_hash("Vulnlab", PASSWORD_DEFAULT);

        if($username == "administrator" && password_verify($password, $hashedPassword)){
            $jwt = CreateJWT($username);
            setcookie("jwt", $jwt, time() + 3600, "/", "", false, true); // Configurar opciones de cookie seguras
            header("Location:index.php");
        } else if($username == "Yavuzlar" && password_verify($password, $hashedPassword)){
            $jwt = CreateJWT($username);
            setcookie("jwt", $jwt, time() + 3600, "/", "", false, true); // Configurar opciones de cookie seguras
            header("Location:index.php");
        }
    }
}
?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $lang["AttackTitle"]?></title>
    <link rel="stylesheet" type="text/css" href="bootstrap.min.css">
</head>

<body>
    <a href="https://github.com/danielmiessler/SecLists/blob/master/Passwords/darkweb2017-top100.txt" class="btn btn-primary mt-3 ml-3"><?php echo $lang["WordList"]?></a>
    <?php if(isset($_COOKIE["jwt"]) && $decodedJWT["username"] == "administrator"):?>
        <a href="clearJWT.php" class="btn btn-primary mt-3 ml-3"><?php echo $lang["Cookie"]?></a>
        <div class="d-flex justify-content-center" style="margin-top: 100px;">
            <h1><?php echo $lang["WelcomeAdmin"]?></h1>
        </div>

    <?php elseif(isset($_COOKIE["jwt"]) && $decodedJWT["username"] == "Yavuzlar"):?>
        <a href="clearJWT.php" class="btn btn-primary mt-3 ml-3"><?php echo $lang["Cookie"]?></a>
        <div class="d-flex justify-content-center" style="margin-top: 100px;">
            <h1><?php echo $lang["WelcomeDefault"]?></h1>
        </div>
        
    <?php else:?>
        <div class="d-flex justify-content-center" style="margin-top: 20vh;text-align:center;">
            <div class="card" style="width: 18rem;">
                <div class="card-body">
                    <h5 class="card-title"><?php echo $lang["Login"]?></h5>
                    <p class="card-text"><?php echo $lang["LoginWith"]?></p>
                    <div class="row">
                        <form method="post">
                            <div>
                                <label for="" class="form-label"><?php echo $lang["Username"]?></label>
                                <input type="text" class="form-control" name="usernameInput">
                            </div>
                            <div>
                                <label for="" class="form-label"><?php echo $lang["Password"]?></label>
                                <input type="password" class="form-control" name="passwordInput">
                            </div>
                            <button class="btn btn-primary mt-3" name="loginButton">
                                <?php echo $lang["Login"]?>
                            </button>
                        </form>
                    </div>
                </div>
                <div class="mb-3">
                    <b><?php echo $lang["LoginCredential"]?>:</b>
                    Yavuzlar:Vulnlab
                </div>
            </div>
        </div>
    <?php endif?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
    <script id="VLBar" title="<?= $strings["title"]; ?>" category-id="9" src="/public/assets/js/vlnav.min.js"></script>
</body>

</html>