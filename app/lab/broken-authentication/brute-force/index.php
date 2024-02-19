<?php
require("../../../lang/lang.php");
$strings = tr();
require("brute.php");


// Initialize session for login attempts and ban timestamp
session_start();

// Check if login attempts and ban timestamp are set, if not, set them to default values
if (!isset($_SESSION['login_attempts'])) {
    $_SESSION['login_attempts'] = 0;
}

if (!isset($_SESSION['ban_timestamp'])) {
    $_SESSION['ban_timestamp'] = 0;
}

// Function to check if the user is banned
function isBanned()
{
    // Set the ban duration in seconds (1 minute in this case)
    $banDuration = 60;

    // Check if the ban timestamp is within the ban duration
    return (time() - $_SESSION['ban_timestamp']) < $banDuration;
}

// Function to check if login attempts exceed the limit
function isBruteForceAttempt()
{
    // Set the maximum number of login attempts
    $maxAttempts = 3;

    // Increment login attempts
    $_SESSION['login_attempts']++;

    // Check if the user is banned
    if (isBanned()) {
        return true;
    }

    // Check if login attempts exceed the limit
    if ($_SESSION['login_attempts'] > $maxAttempts) {
        // Set the ban timestamp to the current time
        $_SESSION['ban_timestamp'] = time();
        return true;
    }

    return false;
}

// Check for brute force attempts
if (isBruteForceAttempt()) {
    // You can display a message or perform other actions here.
    echo "Too many login attempts. Please try again later.";
    exit();
}
?>
<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" type="text/css" href="./css/bootstrap.min.css">

    <title><?= $strings["title"]; ?></title>
</head>

<body>
    <div class="container d-flex justify-content-center">
        <div class="shadow p-3 mb-5 rounded column" style="text-align: center; max-width: 1000px;margin-top:15vh;">
            <h3><?= $strings["login"]; ?></h3>

            <form action="#" method="POST" class="justify-content-center" style="text-align: center;margin-top: 20px;padding:30px;">
                <div class="justify-content-center row mb-3">
                    <label for="inputUsername3" class=" text-center col-form-label"><?= $strings["username"]; ?></label>
                    <div class="col-sm-10">
                        <input type="text" class="justify-content-center form-control" name="username" id="inputUsername3">
                    </div>
                </div>
                <div class="justify-content-center row mb-3">
                    <label for="inputPassword3" class="text-center col-form-label"><?= $strings["password"]; ?></label>
                    <div class="col-sm-10">
                        <input type="password" class="justify-content-center form-control" name="password" id="inputPassword3">
                    </div>
                </div>
                <button type="submit" class="btn btn-primary"><?= $strings["submit"]; ?></button>
                <p class="mt-3"><?= $strings["hint"]; ?></p>
                <?php
                echo '<h1> '.$html.' </h1>'; 
                ?>

            </form>


        </div>
    </div>
    <script id="VLBar" title="<?= $strings["title"]; ?>" category-id="10" src="/public/assets/js/vlnav.min.js"></script>


</body>

</html>