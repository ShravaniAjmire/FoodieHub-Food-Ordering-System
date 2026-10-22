<?php

session_start();

$order_id =
    $_SESSION['last_order_id'] ?? null;

?>

<!DOCTYPE html>
<html lang="en">

<head>

<meta charset="UTF-8">

<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>FoodieHub | Order Confirmed</title>

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

</nav>


<section class="success-page">

<div class="success-box">


<div class="success-icon">
✓
</div>


<h1>
Order Confirmed!
</h1>


<p>
Thank you for ordering from FoodieHub.
Your delicious food is being prepared.
</p>


<?php if ($order_id) { ?>

<div class="order-number">

Order ID:
#<?php echo $order_id; ?>

</div>

<?php } ?>


<p>
Estimated delivery time:
<strong>30–45 minutes</strong>
</p>


<br>


<a
href="menu.php"
class="main-btn"
>
Order Something Else →
</a>


</div>

</section>


</body>
</html>