<?php

session_start();

if (
    !isset($_SESSION['cart']) ||
    empty($_SESSION['cart'])
) {

    header("Location: menu.php");

    exit();

}

include "db/connection.php";


$cart = $_SESSION['cart'];

$total = 0;


foreach ($cart as $food_id => $quantity) {

    $food_id = intval($food_id);

    $result =
        $conn->query(
            "SELECT price FROM food_items
             WHERE food_id = $food_id"
        );

    if ($result && $result->num_rows > 0) {

        $food = $result->fetch_assoc();

        $total +=
            $food['price'] * $quantity;

    }

}

?>

<!DOCTYPE html>
<html lang="en">

<head>

<meta charset="UTF-8">

<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>FoodieHub | Checkout</title>

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

<a href="cart.php">Cart</a>

</div>

<a href="cart.php" class="cart-nav">
🛒 Cart
</a>

</nav>


<section class="checkout-page">

<div class="page-heading">

<span>FINAL STEP</span>

<h1>Complete your order</h1>

</div>


<div class="checkout-layout">


<div class="checkout-box">

<h2>Delivery Details</h2>


<form action="place_order.php" method="POST">


<div class="form-group">

<label>
Full Name
</label>

<input
type="text"
name="name"
placeholder="Enter your full name"
required
>

</div>


<div class="form-group">

<label>
Phone Number
</label>

<input
type="tel"
name="phone"
placeholder="Enter your phone number"
required
>

</div>


<div class="form-group">

<label>
Email Address
</label>

<input
type="email"
name="email"
placeholder="Enter your email"
>

</div>


<div class="form-group">

<label>
Delivery Address
</label>

<textarea
name="address"
placeholder="Enter your complete delivery address"
required
></textarea>

</div>


<div class="form-group">

<label>
Payment Method
</label>

<select name="payment">

<option>
Cash on Delivery
</option>

<option>
Online Payment
</option>

</select>

</div>


<input
type="hidden"
name="total_amount"
value="<?php echo $total; ?>"
>


<button
type="submit"
class="place-order-btn"
>
Place Order • ₹<?php echo $total; ?>
</button>


</form>

</div>


<div class="cart-total">

<h2>Your Order</h2>

<div class="total-line">

<span>Items</span>

<span>
<?php echo count($cart); ?>
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

<p style="
margin-top:20px;
color:#d9c6b8;
font-size:14px;
line-height:1.6;
">

Your order details will be securely
saved in our database.

</p>

</div>


</div>

</section>

</body>
</html>