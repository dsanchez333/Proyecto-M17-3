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

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (isset($_POST['view'])) {
        // Validar y obtener el ID de la factura
        $user_id = filter_input(INPUT_POST, 'user_id', FILTER_VALIDATE_INT);
        if ($user_id !== false) {
            // Redirigir con el ID de la factura
            header("Location: index.php?invoice_id=$user_id");
            exit();
        }
    }
}

if ($_SERVER["REQUEST_METHOD"] === "GET") {
    if (isset($_GET['invoice_id'])) {
        // Validar y obtener el ID de la factura
        $invoice_id = filter_input(INPUT_GET, 'invoice_id', FILTER_VALIDATE_INT);
        if ($invoice_id !== false) {
            try {
                // Consultar la base de datos para obtener la factura
                $query = $db->prepare("SELECT * FROM idor_invoices WHERE id=:id");
                $query->execute(array(':id' => $invoice_id));
                $row = $query->fetch(PDO::FETCH_ASSOC);

                if ($row) {
                    // Realizar verificación de permisos antes de mostrar la factura
                    // Esto podría implicar verificar si el usuario tiene permisos para acceder a esta factura específica
                    // y si el usuario tiene permisos para ver facturas en general

                    // Si el usuario tiene permiso, mostrar la factura
                    header("Content-type: application/pdf");
                    header("Content-Disposition: inline; filename=invoice.pdf");
                    readfile($row['file_url']);
                    exit();
                } else {
                    echo "Factura no encontrada.";
                }
            } catch (PDOException $e) {
                echo "Error al acceder a la base de datos: " . $e->getMessage();
            }
        } else {
            echo "ID de factura no válido.";
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


