<?php

    require("../../../lang/lang.php");
    $strings = tr();

    $db = new PDO('sqlite:database.db'); 

    $user_id =1;

    if( isset($_POST['view']) ){
        header("Location: index.php?invoice_id=$user_id");
    }

    if ($_SERVER["REQUEST_METHOD"] === "GET" && isset($_GET['invoice_id'])) {
        $user_id = $_GET['invoice_id'];
    
        // Validar que el usuario tenga permiso para ver esta factura
    
        $query = $db->prepare("SELECT * FROM idor_invoices WHERE id = :id");
        $query->execute(array(':id' => $user_id));
        $row = $query->fetch();
    
        if ($row) {
            // Guardar el contenido del archivo en una variable
            $file_content = file_get_contents($row['file_url']);
    
            // Configurar las cabeceras para descargar el archivo
            header('Content-Type: application/pdf');
            header('Content-Disposition: attachment; filename="invoice.pdf"');
    
            // Enviar el archivo al cliente
            echo $file_content;
    
            // Eliminar el archivo temporal (opcional, si se desea)
            // unlink($row['file_url']); // Descomenta esta línea para eliminar el archivo temporal
    
            exit();
        } else {
            echo "Error: Factura no encontrada.";
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


