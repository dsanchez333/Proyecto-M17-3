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

// Verificar si se ha enviado una solicitud GET y si se proporcionó un invoice_id
if ($_SERVER["REQUEST_METHOD"] === "GET" && isset($_GET['invoice_id'])) {
    // Obtener el user_id de la sesión
    session_start();
    $user_id_session = $_SESSION['user_id'] ?? null;

    // Obtener el user_id de la URL
    $user_id_url = $_GET['invoice_id'];

    // Verificar si el user_id de la sesión coincide con el user_id de la URL
    if ($user_id_session == $user_id_url) {
        // Consultar la base de datos para obtener el PDF correspondiente al user_id
        $query = $db->prepare("SELECT * FROM idor_invoices WHERE id = :id");
        $query->execute(array(':id' => $user_id_url));
        $row = $query->fetch();

        // Verificar si se encontró el PDF
        if ($row) {
            // Mostrar el PDF
            header("Content-type: application/pdf");
            header("Content-Disposition: inline; filename=invoice.pdf");
            @readfile($row['file_url']);
            exit();
        } else {
            echo "Error: Factura no encontrada.";
        }
    } else {
        echo "Error: No tiene permiso para ver esta factura.";
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


