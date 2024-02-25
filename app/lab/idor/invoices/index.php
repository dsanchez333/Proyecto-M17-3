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
        $user_id = 1;

    
    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        if (isset($_POST['view'])) {
            $invoice_id = filter_input(INPUT_POST, 'invoice_id', FILTER_VALIDATE_INT);
            if ($invoice_id !== false) {
                header("Location: index.php?invoice_id=$invoice_id");
                exit();
            }
        }
    }

    if ($_SERVER["REQUEST_METHOD"] === "GET") {
        if (isset($_GET['invoice_id'])) {
            $invoice_id = filter_input(INPUT_GET, 'invoice_id', FILTER_VALIDATE_INT);
            if ($invoice_id !== false) {
                try {
                    $query = $db->prepare("SELECT * FROM idor_invoices WHERE id=:id");
                    $query->execute(array(':id' => $invoice_id));
                    $row = $query->fetch(PDO::FETCH_ASSOC);

                    if ($row) {
                        // Realizar verificación de permisos antes de mostrar el archivo
                        // Aquí deberías tener lógica para verificar si el usuario tiene permisos para ver la factura

                        $file_path = $row['file_url'];

                        if (file_exists($file_path) && is_readable($file_path)) {
                            header("Content-type: application/pdf");
                            header("Content-Disposition: inline; filename=invoice.pdf");
                            readfile($file_path);
                            exit();
                        } else {
                            echo "Archivo no encontrado o no se puede leer.";
                        }
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


