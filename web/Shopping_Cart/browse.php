<?php
// This will be the main page of the site

// Start a session
session_start();

// make sure cart is filled if there is anything in it
$in_cart = array();
if (!isset($_SESSION['in_cart'])) {
    $_SESSION['in_cart'] = $in_cart;
}
require_once "products.php";

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>

    <!-- CSS -->
<link 
    rel="stylesheet" 
    href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" 
    integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" 
    crossorigin="anonymous"
/>

<link
    rel="stylesheet"
    href="main.css"
/>

<!-- JavaScript -->
<script 
    src="https://code.jquery.com/jquery-3.2.1.slim.min.js" 
    integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" 
    crossorigin="anonymous">
</script>
<script 
    src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" 
    integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" 
    crossorigin="anonymous">
</script>
<script 
    src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" 
    integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" 
    crossorigin="anonymous">
</script>
</head>
<body>
<!-- For Navbar -->
<?php
// By using require here, instead of include, we have decided that if that nav.php
// page is not available, we want the page to crash.
require "nav.php";
?>

<!-- We need to put in the products -->
<div class="container-fluid">
        <h1>Begin Your Journey...</h1>

        <div class="container products">
        <?php
            for ($i = 0; $i < sizeof($product_array); $i++) {
                if (!($i % 2 == 0)) {
                    echo "
                        <div class='col-sm br-product'>
                            <img src="$product_array[$i]->image_path" alt="$name">
                            <h2 class='product-name'>$name</h2>
                            <span>$$price</span>
                            <a href='modify_cart.php?action=addToCart&itemId="$id"' class='btn btn-primary addToCart'>Add to Cart</a>
                        </div></div>";
                } else { 
                    echo "<div class='row'>";
                    echo "
                        <div class='col-sm br-product'>
                            <img src="$product_array[$i]->image_path" alt="$name">
                            <h2 class='product-name'>$name</h2>
                            <span>$$price</span>
                            <a href='modify_cart.php?action=addToCart&itemId="$id"' class='btn btn-primary addToCart'>Add to Cart</a>
                        </div>";
                }
            }
                
        ?>
    </div>
</div>
</body>
</html>
