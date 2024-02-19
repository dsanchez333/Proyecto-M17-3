<?php
require("../../../lang/lang.php");
$strings = tr();
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_SESSION['ban_expiration']) && time() < $_SESSION['ban_expiration']) {
        // User is still banned, you can handle this as needed.
        $errorMessage = 'You are banned. Please try again later.';
    } else {
        $userEnteredCode = $_POST['verification_code'];

        if (isset($_SESSION['2fa_code']) && isset($_SESSION['attempts'])) {
            $correctCode = $_SESSION['2fa_code'];
            $attempts = $_SESSION['attempts'];

            if ($attempts >= 3) {
                // If the user is banned after 3 attempts, set ban expiration time and show error message.
                $_SESSION['ban_expiration'] = time() + 24 * 3600; // 24 hours ban
                $errorMessage = 'Incorrect verification code! You are banned for 24 hours.';
            } elseif ($userEnteredCode == $correctCode) {
                // If the verification code is correct, redirect to the admin page.
                header('Location: admin.php');
                exit();
            } else {
                // Incorrect verification code, increase the attempt count.
                $attempts++;

                // Store the incorrect login attempts count in the session.
                $_SESSION['attempts'] = $attempts;
                $errorMessage = 'Incorrect verification code! Remaining attempts:' . (3 - $attempts);
            }
        } else {
            // If session information is missing, redirect to the index.php page.
            header('Location: index.php');
            exit();
        }
    }
} else {
    // Reset the attempt count when the page is loaded for the first time.
    $_SESSION['attempts'] = 0;

    // Generate a new 2FA code and display it to the user.
    $newCode = rand(10000, 99999);
    $_SESSION['2fa_code'] = $newCode;
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $strings["twofa"]; ?></title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container mt-5"style="padding-top:5%;">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card mx-auto">
                    <div class="card-header bg-primary text-white text-center">
                        <h2><?= $strings["twofa"]; ?></h2>
                    </div>
                    <div class="card-body">
                        <?php if (isset($errorMessage)) : ?>
                            <div class="alert alert-danger" role="alert"><?= $errorMessage; ?></div>
                        <?php else : ?>
                            <p class="text-center"><?= $strings["kod"]; ?></p>
                        <?php endif; ?>
                        <form action="2fa.php" method="post">
                            <div class="mb-3">
                                <label for="verification_code" class="form-label"><?= $strings["dogk"]; ?></label>
                                <input type="text" id="verification_code" name="verification_code" class="form-control" required>
                            </div>
                            <button type="submit" class="btn btn-primary"><?= $strings["dog"]; ?></button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script id="VLBar" title="<?= $strings["title"]; ?>" category-id="10" src="/public/assets/js/vlnav.min.js"></script>

    <!-- Bootstrap JS ve Popper.js (JavaScript kütüphaneleri) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>