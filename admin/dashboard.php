<?php

include "../db/connection.php";


/* TOTAL ORDERS */

$order_result =
    $conn->query(
        "SELECT COUNT(*) AS total
         FROM orders"
    );

$total_orders =
    $order_result->fetch_assoc()['total'];


/* TOTAL CUSTOMERS */

$customer_result =
    $conn->query(
        "SELECT COUNT(*) AS total
         FROM customers"
    );

$total_customers =
    $customer_result->fetch_assoc()['total'];


/* TOTAL FOOD */

$food_result =
    $conn->query(
        "SELECT COUNT(*) AS total
         FROM food_items"
    );

$total_food =
    $food_result->fetch_assoc()['total'];


/* TOTAL SALES */

$sales_result =
    $conn->query(
        "SELECT SUM(total_amount) AS total
         FROM orders"
    );

$total_sales =
    $sales_result->fetch_assoc()['total'];

if (!$total_sales) {
    $total_sales = 0;
}

?>

<!DOCTYPE html>
<html lang="en">

<head>

<meta charset="UTF-8">

<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>FoodieHub | Admin Dashboard</title>

<link rel="stylesheet" href="../css/style.css">

<link rel="preconnect" href="https://fonts.googleapis.com">

<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

<link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&family=Playfair+Display:wght@500;600;700&display=swap" rel="stylesheet">

</head>

<body>


<nav class="navbar">

<a href="../index.php" class="logo">
🍴 FoodieHub
</a>

<div class="nav-links">

<a href="../index.php">
Website
</a>

<a href="../menu.php">
Menu
</a>

</div>

<div class="cart-nav">
Admin Panel
</div>

</nav>


<section class="menu-page">


<div class="menu-title">

<span>FOODIEHUB ADMIN</span>

<h1>
Dashboard
</h1>

<p>
Manage your food ordering system.
</p>

</div>


<div class="feature-grid">


<div class="feature-card">

<div class="feature-icon">
📦
</div>

<h3>
Total Orders
</h3>

<p style="font-size:30px;font-weight:700;color:#4b2e20;">
<?php echo $total_orders; ?>
</p>

</div>


<div class="feature-card">

<div class="feature-icon">
👥
</div>

<h3>
Customers
</h3>

<p style="font-size:30px;font-weight:700;color:#4b2e20;">
<?php echo $total_customers; ?>
</p>

</div>


<div class="feature-card">

<div class="feature-icon">
🍕
</div>

<h3>
Food Items
</h3>

<p style="font-size:30px;font-weight:700;color:#4b2e20;">
<?php echo $total_food; ?>
</p>

</div>


<div class="feature-card">

<div class="feature-icon">
💰
</div>

<h3>
Total Sales
</h3>

<p style="font-size:30px;font-weight:700;color:#4b2e20;">
₹<?php echo $total_sales; ?>
</p>

</div>

</div>


<br><br>


<div class="checkout-box">

<h2>
Recent Orders
</h2>


<table style="
width:100%;
border-collapse:collapse;
text-align:left;
">

<tr style="
background:#f5eadf;
">

<th style="padding:15px;">
Order ID
</th>

<th style="padding:15px;">
Customer
</th>

<th style="padding:15px;">
Amount
</th>

<th style="padding:15px;">
Status
</th>

<th style="padding:15px;">
Date
</th>

</tr>


<?php

$query = "
SELECT
orders.order_id,
customers.name,
orders.total_amount,
orders.status,
orders.order_date

FROM orders

INNER JOIN customers

ON orders.customer_id =
customers.customer_id

ORDER BY orders.order_id DESC

LIMIT 10
";


$result =
    $conn->query($query);


if (
    $result &&
    $result->num_rows > 0
) {

    while (
        $row =
        $result->fetch_assoc()
    ) {

?>

<tr style="border-bottom:1px solid #eee1d4;">

<td style="padding:15px;">
#<?php echo $row['order_id']; ?>
</td>

<td style="padding:15px;">
<?php echo htmlspecialchars($row['name']); ?>
</td>

<td style="padding:15px;">
₹<?php echo $row['total_amount']; ?>
</td>

<td style="padding:15px;">
<?php echo $row['status']; ?>
</td>

<td style="padding:15px;">
<?php echo $row['order_date']; ?>
</td>

</tr>

<?php

    }

} else {

?>

<tr>

<td
colspan="5"
style="padding:25px;text-align:center;"
>
No orders yet.
</td>

</tr>

<?php

}

?>

</table>

</div>


</section>

</body>
</html>