<?php
require("../../../lang/lang.php");
$strings = tr();

try {
    $db = new PDO('sqlite:database.db');
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Veritabanı hatası: " . htmlspecialchars($e->getMessage()));
}

?>

<!DOCTYPE html>
<html lang="tr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>PHP Blog</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>

    <div class="container" style="padding-top:5%;">
        <h1 class="mb-2 text-center"><?php echo htmlspecialchars($strings['welcome']); ?></h1><br>

        <form method="POST" class="text-center">
            <div class="mb-2">
                <label for="content" class="form-label"><?php echo htmlspecialchars($strings['blog_post']); ?></label>
                <textarea class="form-control" id="content" name="content" rows="6" placeholder="<?php echo htmlspecialchars($strings['who']); ?>" required></textarea>
            </div>

            <button type="submit" class="btn btn-primary" name="submit"><?php echo htmlspecialchars($strings['submit']); ?></button>
        </form><br>
        <?php

        if (isset($_POST['submit'])) {
            try {
                require '../../../public/vendor/autoload.php';

                // Evitar el uso directo de Twig para renderizar el contenido del usuario
                $userInput = strip_tags($_POST["content"]);
                $userInput = htmlspecialchars($userInput);

                $query = "INSERT INTO blog_entries (content) VALUES (:content)";
                $stmt = $db->prepare($query);
                $stmt->bindParam(':content', $userInput, PDO::PARAM_STR);
                $stmt->execute();
            } catch (Exception $e) {
                echo ('ERROR:' . htmlspecialchars($e->getMessage()));
            }
        }

        $query = "SELECT * FROM blog_entries ORDER BY id DESC ";
        $stmt = $db->prepare($query);
        $stmt->execute();
        $entries = $stmt->fetchAll(PDO::FETCH_ASSOC);
        ?>
        <h2 class="mt-2 text-center"><?php echo htmlspecialchars($strings['latest_entries']); ?></h2>
        <div id="blogEntries" class="row">
            <?php
            foreach ($entries as $entry) {
                echo '<div class="col-md-12 mb-4">';
                echo '<div class="card shadow">';
                echo '<div class="card-body">';
                echo '<p class="card-text">' . htmlspecialchars($entry['content']) . '</p>';
                echo '</div>';
                echo '</div>';
                echo '</div>';
            }
            ?>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
    <script id="VLBar" title="<?= htmlspecialchars($strings["title"]); ?>" category-id="12" src="/public/assets/js/vlnav.min.js"></script>
</body>

</html>
