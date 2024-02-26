<?php
require("../../../lang/lang.php");
$strings = tr();

session_start();

// Operaciones de carrito
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

if (isset($_POST['add_to_cart'])) {
    $product_price = $_POST['product'];
    $_SESSION['cart'][] = $product_price;
}

// Operaciones de descuento
if (isset($_POST['apply_discount'])) {
    $coupon_code = $_POST['coupon_code'];

    if (!isset($_SESSION['discount_applied']) && $coupon_code === "sbrvtn50") {
        $old_cart = $_SESSION['cart'];

        // Aplicar el descuento y verificar la validez del total después del descuento
        $discounted_cart = $old_cart;
        $discounted_cart[] = -50;

        $old_total = array_sum(array_filter($old_cart, 'is_numeric'));
        $new_total = array_sum(array_filter($discounted_cart, 'is_numeric'));

        if ($old_total >= 50 && $new_total >= 0) {
            $_SESSION['cart'] = $discounted_cart;
            $_SESSION['discount_applied'] = true;
            $_SESSION['discount_amount'] = 50;
            echo "<script>alert('" . $strings['successful'] . "')</script>";
        } else {
            echo "<script>alert('" . $strings['warning'] . "')</script>";
        }
    } else {
        echo "<script>alert('" . $strings['unsuccessful'] . "')</script>";
    }
}

// Operación de limpieza de descuento
if (isset($_POST['clear_discount'])) {
    unset($_SESSION['discount_applied']);
    $discount_amount = isset($_SESSION['discount_amount']) ? $_SESSION['discount_amount'] : 0;

    if ($discount_amount > 0) {
        $cart_index = array_search(-$discount_amount, $_SESSION['cart']);
        if ($cart_index !== false) {
            unset($_SESSION['cart'][$cart_index]);
        }
    }
    unset($_SESSION['discount_amount']);
}

// Operación de limpieza de carrito
if (isset($_POST['clear_cart'])) {
    $_SESSION['cart'] = [];
}
?>

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo "Race Condition" ?></title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f2f2f2;
            margin: 0;
            padding: 0;
        }

        .info-bar {
            background-color: #4caf50;
            color: #fff;
            text-align: center;
            padding: 10px 0;
        }

        .container {
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            margin-top: 20px;
        }

        h2 {
            text-align: center;
            margin-bottom: 20px;
        }

        .product {
            border: 1px solid #ccc;
            padding: 20px;
            margin-bottom: 20px;
        }

        button {
            padding: 10px 20px;
            background-color: #4caf50;
            color: #fff;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        button:hover {
            background-color: #45a049;
        }

        .discount-code {
            margin-top: 20px;
        }

        .discount-code input[type="text"] {
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        .discount-info {
            margin-top: 20px;
        }

        /* İndirim Yazısı Stili */
        .discount-message {
            margin-top: 10px;
            text-align: center;
            color: #4caf50;
        }
    </style>
</head>
<body>
    <!-- Bilgilendirme Mesajı -->
    <div class="info-bar">
    <?php echo $strings['text']; ?>
    </div>

    <div class="container">
    <h2><?php echo $strings['information']; ?></h2>
        <!-- Ürünler -->
        <div class="product">
        <h3><?php echo $strings['product1']; ?></h3>
            <form method="post">
                <input type="hidden" name="product" value="100">
                <button type="submit" name="add_to_cart" value="<?php echo $strings['add']; ?>"><?php echo $strings['add']; ?></button>

            </form>
        </div>

        <div class="product">
        <h3><?php echo $strings['product2']; ?></h3>
            <form method="post">
                <input type="hidden" name="product" value="150">
                <button type="submit" name="add_to_cart" value="<?php echo $strings['add']; ?>"><?php echo $strings['add']; ?></button>

            </form>
        </div>

        <div class="product">
        <h3><?php echo $strings['product3']; ?></h3>
            <form method="post">
                <input type="hidden" name="product" value="200">
                <button type="submit" name="add_to_cart" value="<?php echo $strings['add']; ?>"><?php echo $strings['add']; ?></button>

            </form>
        </div>

        <div>
            <form method="post">
            <button type="submit" name="clear_cart" value="<?php echo $strings['clr']; ?>"><?php echo $strings['clr']; ?></button>

            </form>
        </div>

        <!-- İndirim Kodu -->
        <div class="discount-code">
            <form method="post">
                <label for="coupon_code" ><?php echo $strings['code']; ?>:</label>
                <input type="text" id="coupon_code" name="coupon_code">
                <button type="submit" name="apply_discount" value="<?php echo $strings['apply']; ?>"><?php echo $strings['apply']; ?></button>
                <button type="submit" name="clear_discount" value="<?php echo $strings['clr2']; ?>"><?php echo $strings['clr2']; ?></button>

            </form>
        </div>

        <!-- İndirim Bilgisi ve Toplam -->
        <div class="discount-info">
            <?php
            
            if (isset($_SESSION['discount_applied']) && $_SESSION['discount_applied']) {
                echo "<p>" . $strings['discount'] . "{$_SESSION['discount_amount']}" . $strings['unit'] . " </p>";
            } elseif (isset($_SESSION['old_total'])) {
                echo "<p>" . $strings['oldamount'] .  "{$_SESSION['old_total']} ". $strings['unit']." </p>";
            }
            
            // Toplam tutarı hesapla ve göster
            $total = array_sum(array_filter($_SESSION['cart'], 'is_numeric')); 
            echo "<p> ". $strings['total'] . "$total " . $strings['unit'] . "</p>";
            ?>
            <!-- İndirim Kodu Mesajı -->
            <?php if (isset($_SESSION['discount_applied']) && $_SESSION['discount_applied'] && $_SESSION['discount_amount'] == 50) : ?>
                <p class="discount-message"><?php echo $strings['message']; ?></p>
            <?php endif; ?>
        </div>
    </div>
    <script id="VLBar" title="<?= $strings['title'] ?>" category-id="11" src="/public/assets/js/vlnav.min.js"></script>
</body>
</html>

