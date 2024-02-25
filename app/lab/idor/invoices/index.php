<?php

require("../../../lang/lang.php");
$strings = tr();

session_start();

$db = new PDO('sqlite:database.db'); 

$user_id = 1; // Esto debería ser obtenido de la sesión del usuario, por ejemplo $_SESSION['user_id']

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (isset($_POST['view'])) {
        // Redirigir solo si el usuario está autenticado
        if (isset($_SESSION['user_id'])) {
            header("Location: index.php?invoice_id=$user_id");
            exit();
        } else {
            // Manejar el caso en que el usuario no está autenticado
            echo "Por favor, inicia sesión para ver el PDF.";
            exit();
        }
    }
}

if ($_SERVER["REQUEST_METHOD"] === "GET") {
    if (isset($_GET['invoice_id'])) { 
        // Verificar que el usuario autenticado coincide con el ID en la URL
        if ($_SESSION['user_id'] == $_GET['invoice_id']) {
            $query = $db->prepare("SELECT * FROM idor_invoices WHERE id=:id");
            $query->execute(array(
                'id' => $_GET['invoice_id']
            ));
            $row = $query->fetch();

            if ($row) {
                header("Content-type: application/pdf");
                header("Content-Disposition: inline; filename=invoice.pdf");
                @readfile($row['file_url']);
                exit();
            } else {
                echo "No se encontró el PDF.";
                exit();
            }
        } else {
            echo "No tienes permiso para ver este PDF.";
            exit();
        }
    }
}

?>




<!DOCTYPE html>
<html lang="<?= $strings['lang']; ?>">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $strings['title']; ?></title>
    <link rel="stylesheet" href="bootstrap.min.css">
</head>
<body>

    <div class="container">

        <div class="container-wrapper">
        
            <div class="row pt-5 mt-5 mb-3">
                <div class="col-md-3"></div>
                <div class="col-md-6">

                    <h1><?= $strings['title']; ?></h1>
                    
                </div>
                <div class="col-md-3"></div>
            </div>

            <div class="row pt-2">
                <div class="col-md-3"></div>
                <div class="col-md-6">

                    <div class="card border-primary mb-4">
                        <div class="card-header text-primary">
                            <?= $strings['card_alert']; ?>
                        </div>
                    </div>

                    <h3 class="mb-3"><?= $strings['middle_title']; ?></h3>

                    <form action="" method="post">
                        <div class="d-grid gap-2">
                            <button class="btn btn-primary" type="submit" name="view"><?= $strings['button']; ?></button>
                        </div>
                    </form>


                </div>
                <div class="col-md-3"></div>
            </div>

        </div>

    </div>
    <script id="VLBar" title="<?= $strings['title']; ?>" category-id="3" src="/public/assets/js/vlnav.min.js"></script>
</body>
</html>


