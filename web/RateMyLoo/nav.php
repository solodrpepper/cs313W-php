<?php
session_start();

if (!(isset($_SESSION['login']) && $_SESSION['login'] != '')) {
   $isLoggedIn = 0;
} else {
   $isLoggedIn = 1;
   $uname = $_SESSION['uname'];
}
?>

<!-- HTML to display if user is not logged in -->
<?php ob_start(); ?>
<li class="nav-item">
   <a class="nav-link" href="login.php">Login</a>
</li>
<li class="nav-item">
   <a class="nav-link" href="signup.php">Sign Up</a>
</li>
<?php $notLoggedIn = ob_get_clean(); ?>

<!-- HTML to display if user is logged in -->
<?php ob_start(); ?>
<li class="nav-item">
   <a class="nav-link" href="logout.php">Logout</a>
</li>
<?php $loggedIn = ob_get_clean(); ?>

<!-- Navbar elements -->
<nav class="navbar navbar-expand-lg navbar-light bg-light nav-pills">
   <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarTogglerDemo03" aria-controls="navbarTogglerDemo03"
      aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
   </button>
   <a class="navbar-brand" href="home.php"><span class="fas fa-toilet" style="font-size: 18"></span> Rate My Loo</a>

   <div class="collapse navbar-collapse" id="navbarTogglerDemo03">
      <ul class="navbar-nav mr-auto mt-2 mt-lg-0">
         <li class="nav-item active">
            <a class="nav-link" href="home.php">Home <span class="sr-only">(current)</span></a>
         </li>
         <li class="nav-item">
            <a class="nav-link" href="aboutRML.php">About RML</a>
         </li>
      </ul>
      <ul class="navbar-nav mt-2 mt-lg-0 navbar-right">
         <?php
            if ($isLoggedIn == 0) {
               echo "$notLoggedIn";
            } else {
               echo '<li class="nav-item">';
               echo   '<a class="nav-link" href="#">Welcome, </a>';
               echo '</li>';
               echo "$loggedIn";
            }
         ?>
      </ul>
   </div>
</nav>