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

// Verificar si se envió un formulario con la clave
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['key'])) {
    $key_entered = $_POST['key'];
    
    // Consultar la base de datos para verificar si la clave es válida
    $query = $db->prepare("SELECT * FROM access_keys WHERE `key` = :key");
    $query->execute(array(':key' => $key_entered));
    $row = $query->fetch(PDO::FETCH_ASSOC);
    
    if ($row) {
        // Si la clave es válida, redirigir al usuario a la página con la factura
        header("Location: index.php?invoice_id=1"); // Cambiar 1 por el ID de la factura que desees mostrar
        exit();
    } else {
        // Si la clave no es válida, mostrar un mensaje de error
        echo "Clave incorrecta. Por favor, inténtalo de nuevo.";
        exit();
    }
}

// Si se accede directamente a la página sin la clave, mostrar el formulario para ingresar la clave
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

                    <!-- Formulario para ingresar la clave -->
                    <form action="" method="post">
                        <div class="mb-3">
                            <label for="key" class="form-label">Clave de acceso:</label>
                            <input type="password" class="form-control" id="key" name="key" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Acceder</button>
                    </form>

                </div>
                <div class="col-md-3"></div>
            </div>

        </div>

    </div>
    <script id="VLBar" title="<?= $strings['title']; ?>" category-id="3" src="/public/assets/js/vlnav.min.js"></script>
</body>
</html>


