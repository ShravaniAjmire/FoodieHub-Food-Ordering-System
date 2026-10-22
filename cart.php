<?php

session_start();

include "db/connection.php";


/* ADD FOOD TO CART */

if (
    isset($_POST['action']) &&
    $_POST['action'] == "add"
) {

    $food_id = intval($_POST['food_id']);

    if (!isset($_SESSION['cart'])) {

        $_SESSION['cart'] = [];

    }

    if (isset($_SESSION['cart'][$food_id])) {

        $_SESSION['cart'][$food_id]++;

    } else {

        $_SESSION['cart'][$food_id] = 1;

    }

}


/* INCREASE */

if (
    isset($_POST['action']) &&
    $_POST['action'] == "increase"
) {

    $food_id = intval($_POST['food_id']);

    $_SESSION['cart'][$food_id]++;

}


/* DECREASE */

if (
    isset($_POST['action']) &&
    $_POST['action'] == "decrease"
) {

    $food_id = intval($_POST['food_id']);

    if ($_SESSION['cart'][$food_id] > 1) {

        $_SESSION['cart'][$food_id]--;

    } else {

        unset($_SESSION['cart'][$food_id]);

    }

}


/* REMOVE */

if (
    isset($_POST['action']) &&
    $_POST['action'] == "remove"
) {

    $food_id = intval($_POST['food_id']);

    unset($_SESSION['cart'][$food_id]);

}


$cart = $_SESSION['cart'] ?? [];

$total = 0;

?>

<!DOCTYPE html>
<html lang="en">

<head>

<meta charset="UTF-8">

<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>FoodieHub | Your Cart</title>

<link rel="stylesheet" href="css/style.css">

<link rel="preconnect" href="https://fonts.googleapis.com">

<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

<link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&family=Playfair+Display:wght@500;600;700&display=swap" rel="stylesheet">

</head>

<body>


<nav class="navbar">

<a href="index.php" class="logo">
🍴 FoodieHub
</a>

<div class="nav-links">

<a href="index.php">Home</a>

<a href="menu.php">Menu</a>

<a href="index.php#about">About</a>

</div>

<a href="cart.php" class="cart-nav">
🛒 Cart
</a>

</nav>


<section class="cart-page">

<div class="page-heading">

<span>YOUR ORDER</span>

<h1>Your shopping cart</h1>

</div>


<?php if (empty($cart)) { ?>

<div class="success-box">

<div class="success-icon">
🛒
</div>

<h1>Your cart is empty</h1>

<p>
Looks like you haven't added anything yet.
</p>

<br>

<a href="menu.php" class="main-btn">
Explore Menu →
</a>

</div>

<?php } else { ?>


<div class="cart-layout">


<div class="cart-items">

<?php

foreach ($cart as $food_id => $quantity) {

    $food_id = intval($food_id);

    $query =
        "SELECT * FROM food_items WHERE food_id = $food_id";

    $result = $conn->query($query);

    if ($result && $result->num_rows > 0) {

        $food = $result->fetch_assoc();

        $subtotal =
            $food['price'] * $quantity;

        $total += $subtotal;

?>

<div class="cart-item">


<div class="cart-item-info">

<h3>
<?php echo htmlspecialchars($food['food_name']); ?>
</h3>

<p>
₹<?php echo $food['price']; ?> each
</p>

</div>


<div class="quantity">

<form method="POST">

<input
type="hidden"
name="food_id"
value="<?php echo $food_id; ?>"
>

<input
type="hidden"
name="action"
value="decrease"
>

<button>
−
</button>

</form>


<strong>
<?php echo $quantity; ?>
</strong>


<form method="POST">

<input
type="hidden"
name="food_id"
value="<?php echo $food_id; ?>"
>

<input
type="hidden"
name="action"
value="increase"
>

<button>
+
</button>

</form>

</div>


<strong>
₹<?php echo $subtotal; ?>
</strong>


<form method="POST">

<input
type="hidden"
name="food_id"
value="<?php echo $food_id; ?>"
>

<input
type="hidden"
name="action"
value="remove"
>

<button
style="
border:none;
background:none;
cursor:pointer;
font-size:18px;
"
>
🗑️
</button>

</form>


</div>

<?php

    }

}

?>

</div>


<div class="cart-total">

<h2>Order Summary</h2>

<div class="total-line">

<span>Subtotal</span>

<span>
₹<?php echo $total; ?>
</span>

</div>


<div class="total-line">

<span>Delivery</span>

<span>
FREE
</span>

</div>


<div class="grand-total">

<span>Total</span>

<span>
₹<?php echo $total; ?>
</span>

</div>


<a
href="checkout.php"
class="checkout-btn"
>
Proceed to Checkout →
</a>

</div>


</div>

<?php } ?>

</section>

</body>
</html>