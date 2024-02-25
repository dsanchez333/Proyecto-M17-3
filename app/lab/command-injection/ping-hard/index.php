<?php
require("../../../lang/lang.php");

$strings = tr();

?>
<!DOCTYPE HTML>
<html lang="en-US">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= $strings['title1']; ?></title>
    <link rel="stylesheet" href="./../bootstrap.min.css">
</head>

<body>
    <div class="container text-center">
        <div class="main-wrapper" style="margin-top: 25vh;">
            <div class="header-wrapper">
                <h2 class="col">PING</h2>
            </div>
            <div class="col-md-auto mt-3 d-flex justify-content-center">
                <form method="POST" class="flex-column">
                    <input class="form-control" type="text" name="ip" style="width: 500px;">
                    <button type="submit" class="btn btn-primary mt-4" style=" width: 500px;">Ping</button>
                </form>
            </div>

            <div class="col-md-auto d-flex justify-content-center" style="">

                <?php
                if (isset($_POST["ip"])) {
                    $input = $_POST["ip"];
                    // Validar que solo se permitan caracteres alfanuméricos y puntos (para direcciones IP y nombres de dominio)
                    if (!preg_match('/^[a-zA-Z0-9.]+$/', $input)) {
                        echo '<div class="mt-5 alert alert-danger" role="alert" style="width:500px;"><strong><p style="text-align:center;">Input inválido. Solo se permiten caracteres alfanuméricos y puntos.</p></strong></div>';
                    } else {
                        // Ejecutar el comando ping solo si el input es válido
                        exec("ping -c5 $input", $out);
                        if (!empty($out)) {
                            echo '<div class="mt-5 alert alert-primary" role="alert" style="width:500px;"><strong><p style="text-align:center;">';
                            foreach ($out as $line) {
                                echo $line;
                                echo "<br>";
                            }
                            echo '</p></strong></div>';
                        }
                    }
                }
                ?>
            </div>
        </div>
    </div>
    <script id="VLBar" title="<?= $strings['title1'] ?>" category-id="4" src="/public/assets/js/vlnav.min.js"></script>
</body>

</html>
