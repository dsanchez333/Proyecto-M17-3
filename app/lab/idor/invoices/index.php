<?php

require("../../../lang/lang.php");
$strings = tr();

// Establecer una conexión PDO segura
try {
    $db = new PDO('sqlite:database.db');
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Error de conexión: " . $e->getMessage();
    die();
}

// ID de usuario deseado para ver el PDF
$user_id = 1;

// Verificar si se ha enviado una solicitud POST
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Si se ha enviado una solicitud POST, redirigir a la página de visualización del PDF con el ID de usuario
    if (isset($_POST['view'])) {
        header("Location: index.php?invoice_id=$user_id");
        exit();
    }
}

// Verificar si se ha enviado una solicitud GET
if ($_SERVER["REQUEST_METHOD"] === "GET") {
    // Si se ha enviado una solicitud GET y se ha proporcionado un ID de factura
    if (isset($_GET['invoice_id'])) {
        // Verificar si el ID de usuario actual coincide con el ID de usuario deseado (en este caso, 1)
        if ($user_id == 1) {
            // Consultar la base de datos para obtener la factura con el ID proporcionado
            $query = $db->prepare("SELECT * FROM idor_invoices WHERE id=:id");
            $query->execute(array(':id' => $_GET['invoice_id']));
            $row = $query->fetch();

            // Verificar si se encontró la factura
            if ($row) {
                // Si se encontró la factura, mostrar el PDF
                header("Content-type: application/pdf");
                header("Content-Disposition: inline; filename=invoice.pdf");
                @readfile($row['file_url']);
                exit();
            } else {
                // Si la factura no fue encontrada, mostrar un mensaje de error
                echo "Error: Factura no encontrada.";
                exit();
            }
        } else {
            // Si el ID de usuario actual no coincide con el ID de usuario deseado, mostrar un mensaje de error
            echo "Error: No tiene permiso para ver esta factura.";
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


