<?php
require("../../../lang/lang.php");
$strings = tr();

$db = new PDO('sqlite:database.db');

?>
<!doctype html>
<html lang="en">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- Bootstrap CSS -->
  <link rel="stylesheet" type="text/css" href="bootstrap.min.css">

  <title><?php echo htmlspecialchars($strings['title']); ?></title>
</head>

<body>
  <div class="container d-flex justify-content-center">
    <div class="shadow p-3 mb-5 rounded column" style="text-align: center; max-width: 1000px;margin-top:15vh;">
      <h4>VULNLAB</h4>

      <form action="#" method="POST" style="text-align: center;margin-top: 20px;padding:30px;">
        <button type="submit" class="btn btn-primary"><?php echo htmlspecialchars($strings['logout']); ?></button> <!-- Botón de cierre de sesión -->
      </form>

                        echo '<div class="msg col-md-6 m-3 px-4 bg-primary text-wrap " style="border-radius: 20px; padding: 5px;width: fit-content;color: aliceblue;">';
                        echo $cikti['content'];
                        echo '</div>';
                    }
                }
                #}

            </div>
            </div>
            <div class="p-3 pb-0" style="text-align: center;">
                <form action="#" method="POST" style="margin: 0;">
                    <textarea placeholder="<?php echo $strings['message']; ?>" class="form-control" rows="3" name="mes"></textarea>
                    <button type="submit" class="btn btn-primary m-3"><?php echo $strings['submit']; ?></button>
                </form>
    </div>
            <div class="p-3 pb-0" style="text-align: center;">
                <form action="#" method="POST" style="margin: 0;">
                    <textarea placeholder="<?php echo $strings['message']; ?>" class="form-control" rows="3" name="mes"></textarea>
                    <button type="submit" class="btn btn-primary m-3"><?php echo $strings['submit']; ?></button>
                </form>
  </div>
  <script id="VLBar" title="<?= htmlspecialchars($strings['title']) ?>" category-id="1" src="/public/assets/js/vlnav.min.js"></script>
</body>

</html>
