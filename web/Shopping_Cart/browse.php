<?php
// This will be the main page of the site

// Start a session
session_start();

// make sure cart is filled if there is anything in it
$in_cart = array();
if (!isset($_SESSION['in_cart'])) {
    $_SESSION['in_cart'] = $in_cart;
}

// create a product object
class product
{
    public $name;
    public $price;
    public $id;
    public $image_path;
    public $type;
}

$product_array = array();

$color_array = array(Red, Blue, Green, Teal);
$lightsaber_image_path_array = array("photos/red-lightsaber.png",
                                     "photos/blue-lightsaber.png",
                                     "photos/green-lightsaber.png",
                                     "photos/teal-lightsaber.png");

for ($i = 0; $i < sizeof($color_array); $i++) {
    $product_array[$i]             = new product();
    $product_array[$i]->name       = $color_array[$i] . " Lightsaber";
    $temp = 10000.00 * (1 + $i);
    $temp = number_format($temp, 2, ".", ",");
    $product_array[$i]->price      = $temp;
    $product_array[$i]->id         = $i;
    $product_array[$i]->image_path = $lightsaber_image_path_array[$i];
    $product_array[$i]->type       = "lightsaber";
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>The Shady Cantina</title>

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
                $obj        = $product_array[$i];
                $name       = $obj->name;
                $price      = $obj->price;      
                $id         = $obj->id;     
                $image_path = $obj->image_path;      


                if (!($i % 2 == 0)) {
                    echo "
                        <div class='col-sm br-product'>
                            <img src='$image_path' alt='$name'>
                            <h2 class='product-name'>$name</h2>
                            <span>$$price</span>
                            <a href='modify_cart.php?action=addToCart&itemId=$id' class='btn btn-primary addToCart'>Add to Cart</a>
                        </div>";
                } else { 
                    echo "<div class='row'>";
                    echo "
                        <div class='col-sm br-product'>
                            <img src='$image_path' alt='$name'>
                            <h2 class='product-name'>$name</h2>
                            <span>$$price</span>
                            <a href='modify_cart.php?action=addToCart&itemId=$id' class='btn btn-primary addToCart'>Add to Cart</a>
                        </div>";
                }
            }
                
        ?>
    </div>
</div>
</body>
</html>
