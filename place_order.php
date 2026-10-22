<?php

session_start();

include "db/connection.php";


if (
    !isset($_SESSION['cart']) ||
    empty($_SESSION['cart'])
) {

    header("Location: menu.php");

    exit();

}


$name =
    $conn->real_escape_string($_POST['name']);

$phone =
    $conn->real_escape_string($_POST['phone']);

$email =
    $conn->real_escape_string($_POST['email']);

$address =
    $conn->real_escape_string($_POST['address']);


$total_amount =
    floatval($_POST['total_amount']);


/* INSERT CUSTOMER */

$sql_customer = "
INSERT INTO customers
(name, phone, email, address)
VALUES
('$name', '$phone', '$email', '$address')
";

$conn->query($sql_customer);


$customer_id =
    $conn->insert_id;


/* INSERT ORDER */

$sql_order = "
INSERT INTO orders
(customer_id, total_amount, status)
VALUES
('$customer_id', '$total_amount', 'Pending')
";

$conn->query($sql_order);


$order_id =
    $conn->insert_id;


/* INSERT ORDER ITEMS */

foreach ($_SESSION['cart'] as $food_id => $quantity) {

    $food_id = intval($food_id);

    $quantity = intval($quantity);


    $result =
        $conn->query(
            "SELECT price
             FROM food_items
             WHERE food_id = $food_id"
        );


    if (
        $result &&
        $result->num_rows > 0
    ) {

        $food =
            $result->fetch_assoc();


        $price =
            $food['price'];


        $sql_item = "
        INSERT INTO order_items
        (order_id, food_id, quantity, price)
        VALUES
        ('$order_id', '$food_id', '$quantity', '$price')
        ";


        $conn->query($sql_item);

    }

}


/* CLEAR CART */

unset($_SESSION['cart']);


/* SAVE ORDER ID */

$_SESSION['last_order_id'] =
    $order_id;


/* GO TO SUCCESS PAGE */

header(
    "Location: order_success.php"
);

exit();

?>