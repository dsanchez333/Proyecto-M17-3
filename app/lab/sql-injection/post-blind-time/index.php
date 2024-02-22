<?php

    require("../../../lang/lang.php");
    $strings = tr();

    try {
        $db = new PDO('mysql:host=localhost; dbname=sql_injection', 'sql_injection', '');
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); // Configurar para que PDO lance excepciones en errores
    } catch (Exception $e) {
        echo $e;
    }

    if (isset($_POST['email'])) {
        $email = $_POST['email'];
    
        try {
            // Preparar la consulta con un marcador de posición
            $query = $db->prepare("SELECT * FROM users WHERE email = :email");
            
            // Vincular el valor del parámetro con el marcador de posición
            $query->bindParam(':email', $email, PDO::PARAM_STR);
            
            // Ejecutar la consulta
            $query->execute();
            
            // Obtener los resultados
            $user = $query->fetch(PDO::FETCH_ASSOC);
    
            // Verificar si se encontraron resultados
            if ($user) {
                $status = "success";
            } else {
                $status = "failure";
            }
        } catch (PDOException $e) {
            // Manejar errores de la consulta preparada
            echo "Error: " . $e->getMessage();
        }
    }

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $strings['title'] ?></title>
    <link rel="stylesheet" href="bootstrap.min.css">
</head>
<body>
    
    <div class="container">
        <div class="container-wrapper">
            <div class="row pt-5 mt-5 mb-3" >
                <div class="col-md-3"></div>
                <div class="col-md-6">
                    <h1><?php echo $strings['h1'] ?></h1>
                </div>
                <div class="col-md-3"></div>    
            </div>
            <div class="row pt-4 " >
                <div class="col-md-3"></div>
                <div class="col-md-6">

                    <div class="alert alert-primary" role="alert">                         
                        <?php echo $strings['box'] ?>
                    </div>
                    
                    <div class="mb-3">
                        
                    <form action="" method="POST" autocomplate="off">
                    <label for="email" class="form-label"><?php echo $strings['label'] ?></label>
                        <input type="text" name="email" class="form-control" id="email" placeholder="name@example.com">
                    </div>
                      <button type="submit" class="btn btn-primary"><?php echo $strings['button'] ?></button>
                    </form>
   
                    <?php
                      if(isset($status)){
                          if($status == "success"){
                              echo '<div class="mt-3 alert alert-success" role="alert">'.$strings['success'].'</div>';
                          }
                      }
                    ?>
        
                </div>
                <div class="col-md-3"></div>      

            </div>
        </div>
    </div>
    <script id="VLBar" title="<?= $strings['title'] ?>" category-id="2" src="/public/assets/js/vlnav.min.js"></script>
</body>
</html>