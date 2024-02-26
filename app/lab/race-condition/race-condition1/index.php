<?php
require("../../../lang/lang.php");
$strings = tr();

include("baglanti.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $ad = htmlspecialchars($_POST['ad']);
    $soyad = htmlspecialchars($_POST['soyad']);
    $email = htmlspecialchars($_POST['email']);
    $tel = htmlspecialchars($_POST['tel']);

    try {
        $db->beginTransaction();

        // Utilizamos una consulta SELECT sin FOR UPDATE
        $kontrolSql = "SELECT * FROM kayit WHERE email = :email";
        $kontrolStatement = $db->prepare($kontrolSql);
        $kontrolStatement->bindParam(':email', $email);
        $kontrolStatement->execute();

        $results = $kontrolStatement->fetchAll(PDO::FETCH_ASSOC);

        if (count($results) > 0) {
            echo $strings['warning'];
        } else {
            $ekleSql = "INSERT INTO kayit (ad, soyad, email, tel) VALUES (:ad, :soyad, :email, :tel)";
            $ekleStatement = $db->prepare($ekleSql);
            $ekleStatement->bindParam(':ad', $ad);
            $ekleStatement->bindParam(':soyad', $soyad);
            $ekleStatement->bindParam(':email', $email);
            $ekleStatement->bindParam(':tel', $tel);

            if ($ekleStatement->execute()) {
                $db->commit();
                echo $strings['successful'];
            } else {
                $db->rollBack();
                echo $strings['unsuccessful'];
            }
        }
    } catch (Exception $e) {
        $db->rollBack();
        echo "Error: " . $e->getMessage();
    } finally {
        $db = null;
    }
}

if (isset($_POST['email'])) {
    session_start();
    $_SESSION['email'] = $_POST['email'];
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="bootstrap.min.css">
    <title><?php echo "Race Condition" ?></title>
   
    
</head>
<body>

<div class="container col-md-4 shadow-lg rounded">
    <div class="d-flex row justify-content-center pt-lg-5 " style="margin-top: 20vh;text-align:center;">
        <div class="alert alert-primary col-md-7 mb-4" role="alert">
            <?php echo $strings['text']; ?>
        </div>

        <h2><?php echo $strings['information']; ?></h2>

        <form action="index.php" method="post">
    <div class="row mb-3">
        <label class="col-sm-5 col-form-label"><?php echo $strings['name']; ?>:</label>
        <div class="col-sm-5">
            <input type="text" name="ad" class="form-control" required>
        </div>
    </div>

    <div class="row mb-3">
        <label class="col-sm-5 col-form-label"><?php echo $strings['surname']; ?>:</label>
        <div class="col-sm-5">
            <input type="text" name="soyad" class="form-control" required>
        </div>
    </div>

    <div class="row mb-3">
        <label class="col-sm-5 col-form-label"><?php echo $strings['email']; ?>:</label>
        <div class="col-sm-5">
            <input type="email" name="email" class="form-control" required>
        </div>
    </div>

    <div class="row mb-3">
        <label class="col-sm-5 col-form-label"><?php echo $strings['phone']; ?>:</label>
        <div class="col-sm-5">
            <input type="number" name="tel" class="form-control" required>
        </div>
    </div>

    <div class="form-group">
        <input type="submit" class="btn btn-primary" value="<?php echo $strings['register']; ?>">
    </div>
</form>


      
        <div style="margin-top: 10px;"></div>

        <a href="kayitlar.php" class="btn btn-danger btn-primary-sm"><?php echo $strings['registers']; ?></a>
    </div>
</div>



    <script id="VLBar" title="<?= $strings["title"]; ?>" category-id="11" src="/public/assets/js/vlnav.min.js"></script>
</body>
</html>
