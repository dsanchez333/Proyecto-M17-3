<?php
require("../../../lang/lang.php");
$strings = tr();

if( isset($_POST['submit']) ){
    $tmpName = $_FILES['input_image']['tmp_name'];
    $fileName = $_FILES['input_image']['name'];
    $fileSize = $_FILES['input_image']['size'];
    $fileType = $_FILES['input_image']['type'];

    // 1. Limitar tipos de archivo permitidos
    $allowedExtensions = array("gif", "jpg", "jpeg", "png");
    $fileExtension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
    if(!in_array($fileExtension, $allowedExtensions)){
        $status = "invalid_extension";
    } elseif ($fileSize > 1000000) { // 2. Verificar el tamaño del archivo (1MB)
        $status = "file_too_large";
    } else {
        if(!file_exists("uploads")){
            mkdir("uploads");
        }

        // 3. Cambiar el nombre del archivo cargado
        $newFileName = uniqid() . '.' . $fileExtension;
        $uploadPath = "uploads/" . $newFileName;

        // 4. Almacenar los archivos fuera del directorio web raíz
        if(move_uploaded_file($tmpName, $uploadPath)){
            $status = "success";
        } else {
            $status = "unsuccess";
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

                    <a href="delete.php"><button type="button" href="" class="btn btn-secondary btn-sm"><?= $strings['delete_button']; ?></button></a>
                </div>
                <div class="col-md-3"></div>
            </div>
            <div class="row pt-3">
                <div class="col-md-3"></div>
                <div class="col-md-6">
                    
                    <div class="card border-primary mb-4">
                        <div class="card-header text-primary">
                        <?= $strings['card_formats']; ?> <b><?= $strings['card_formats_type']; ?> </b>
                        </div>
                    </div>

                    <h3 class="mb-3"><?= $strings['middle_title']; ?></h3>

                    <?php
                        if( isset($status) ){
                            if( $status == "success" ){
                                echo '<div class="alert alert-success" role="alert">
                                <b>'.$strings['alert_success'].'</b> 
                                <hr>'
                                .$strings['alert_success_file_path'].'<a class="text-success" href="'.$uploadPath.'"> <b>'.$uploadPath.'</b> </a> 
                                </div>';
                            }
                            if( $status == "unsuccess" ){
                                echo '<div class="alert alert-danger" role="alert">
                                <b>'.$strings['alert_unsuccess'].'</b> 
                                </div>';
                            }
                            if( $status == "empty" ){
                                echo '<div class="alert alert-danger" role="alert">
                                <b>'.$strings['alert_empty'].'</b> 
                                </div>';
                            }
                        }
                    ?>

                    <form action="" method="post" enctype="multipart/form-data">
                        <div class="mb-3">
                            <label for="input_image" class="form-label"><?= $strings['input_label']; ?></label>
                            <input class="form-control" type="file" id="input_image" name="input_image"> 
                        </div>
                        <div class="d-grid gap-2">
                            <button class="btn btn-primary" type="submit" name="submit"><?= $strings['button']; ?></button>
                        </div>
                    </form>

                </div>
                <div class="col-md-3"></div>
            </div>
        </div>

    </div>
    <script id="VLBar" title="<?= $strings['title']; ?>" category-id="7" src="/public/assets/js/vlnav.min.js"></script>
</body>
</html>