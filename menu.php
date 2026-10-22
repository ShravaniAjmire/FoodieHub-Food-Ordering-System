<?php

include "db/connection.php";

$sql = "SELECT * FROM food_items";

$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>FoodieHub | Menu</title>

    <link rel="stylesheet" href="css/style.css">

    <link rel="preconnect" href="https://fonts.googleapis.com">

    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&family=Playfair+Display:wght@500;600;700&display=swap" rel="stylesheet">

</head>

<body>


<!-- NAVBAR -->

<nav class="navbar">

    <a href="index.php" class="logo">
        🍴 FoodieHub
    </a>

    <div class="nav-links">

        <a href="index.php">
            Home
        </a>

        <a href="menu.php" class="active">
            Menu
        </a>

        <a href="index.php#about">
            About
        </a>

        <a href="index.php#contact">
            Contact
        </a>

    </div>

    <a href="cart.php" class="cart-nav">
        🛒 Cart
    </a>

</nav>


<!-- MENU -->

<section class="menu-page">

    <div class="menu-title">

        <span>EXPLORE OUR MENU</span>

        <h1>
            Made for food lovers.
        </h1>

        <p>
            Choose your favourite dishes and
            add them to your cart.
        </p>

    </div>


    <div class="search-box">

        <input
            type="text"
            id="foodSearch"
            placeholder="🔍 Search your favourite food..."
            onkeyup="searchFood()"
        >

    </div>


    <div class="food-grid" id="foodGrid">

        <?php

        if ($result->num_rows > 0) {

            while ($food = $result->fetch_assoc()) {

                $name = $food['food_name'];

                $category = $food['category'];

                $price = $food['price'];

                /*
                 * Images are selected based on category.
                 */

                if ($category == "Pizza") {

                    $image = "https://images.unsplash.com/photo-1565299624946-b28f40a0ae38?auto=format&fit=crop&w=700&q=80";

                } elseif ($category == "Burger") {

                    $image = "https://images.unsplash.com/photo-1572802419224-296b0aeee0d9?auto=format&fit=crop&w=700&q=85";

                } elseif ($category == "Biryani") {

                    $image = "https://images.unsplash.com/photo-1585937421612-70a008356fbe?auto=format&fit=crop&w=700&q=80";

                } elseif ($category == "Pasta") {

                    $image = "https://images.unsplash.com/photo-1551892374-ecf8754cf8b0?auto=format&fit=crop&w=700&q=80";

                } elseif ($category == "Sandwich") {

                    $image = "https://images.unsplash.com/photo-1528735602780-2552fd46c7af?auto=format&fit=crop&w=700&q=80";

                } else {

                    $image = "https://images.unsplash.com/photo-1517701604599-bb29b565090c?auto=format&fit=crop&w=700&q=80";

                }

        ?>

        <div class="food-card">

            <div class="food-card-image">

                <img
                    src="<?php echo $image; ?>"
                    alt="<?php echo htmlspecialchars($name); ?>"
                >

                <div class="food-badge">
                    <?php echo htmlspecialchars($category); ?>
                </div>

            </div>


            <div class="food-content">

                <h2>
                    <?php echo htmlspecialchars($name); ?>
                </h2>

                <p class="food-category">
                    Freshly prepared • ★ 4.8
                </p>


                <div class="food-bottom">

                    <div class="food-price">
                        ₹<?php echo $price; ?>
                    </div>


                    <form action="cart.php" method="POST">

                        <input
                            type="hidden"
                            name="food_id"
                            value="<?php echo $food['food_id']; ?>"
                        >

                        <input
                            type="hidden"
                            name="action"
                            value="add"
                        >

                        <button
                            type="submit"
                            class="add-btn"
                        >
                            + Add
                        </button>

                    </form>

                </div>

            </div>

        </div>

        <?php

            }

        } else {

            echo "<p>No food items found.</p>";

        }

        ?>

    </div>

</section>


<script>

function searchFood() {

    let input =
        document.getElementById("foodSearch").value.toLowerCase();

    let cards =
        document.querySelectorAll(".food-card");

    cards.forEach(function(card) {

        let name =
            card.querySelector("h2").innerText.toLowerCase();

        let category =
            card.querySelector(".food-category").innerText.toLowerCase();

        if (
            name.includes(input) ||
            category.includes(input)
        ) {

            card.style.display = "";

        } else {

            card.style.display = "none";

        }

    });

}

</script>

</body>
</html>