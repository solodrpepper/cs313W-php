<?php
    // make sure we have the session data
    session_start();
    // get the products in here
    require_once "products.php";

    if ($_GET['action'] == "addToCart") {
        $_SESSION['in_cart'].array_push($_GET['action']);
    }
?>