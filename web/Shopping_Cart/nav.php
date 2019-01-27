<?php
// Got this code from sburton42
$file = pathinfo($_SERVER['PHP_SELF'], PATHINFO_FILENAME);
// now $file will contain something like "about" and we can check later
// for this variable and use it to include the "active" class on the appropriate
// link item.

// Start a session
session_start();

// if there is anything in the cart, add it up in the top right
$sizeof_cart = 0;

if (isset($_SESSION['in_cart'])) {
    $sizeof_cart = sizeof($_SESSION['in_cart']);
}


?>

<nav class="navbar navbar-inverse"> 
    <div class="container-fluid"> 
        <div class="navbar-header"> 
            <button type="button" class="collapsed navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-9" aria-expanded="false"> 
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span> 
            <span class="icon-bar"></span> 
            <span class="icon-bar"></span> 
            </button> <a href="#" class="navbar-brand">The Shady Cantina</a> 
        </div> 
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-9"> 
            <ul class="nav navbar-nav"> 
                <li class="active"><a href="#">Home</a></li>
            </ul> 
        </div>
        <div class="collapse navbar-collapse navbar-right"> 
            <ul class="nav navbar-nav"> 
                <li>
                    <button type="button" class="btn btn-default btn-sm">
                        <span class="glyphicon glyphicon-shopping-cart"> Cart</span>
                        <span><?php if ($sizeof_cart > 0) { echo " ($sizeof_cart)"; }?></span>
                    </button>
                </li>
            </ul> 
        </div> 
    </div>
</nav>
