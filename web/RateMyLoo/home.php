<?php
require 'db_connect.php';
$db = get_db();

session_start();

if (!(isset($_SESSION['login']) && $_SESSION['login'] != '')) {
   $isLoggedIn = 0;
} else {
   $isLoggedIn = 1;
   $is_male = $_SESSION['is_male'];
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <!-- CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm"
        crossorigin="anonymous">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr"
        crossorigin="anonymous">

    <!-- My CSS -->
    <link rel="stylesheet" href="main.css" />

    <!-- JavaScript -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN"
        crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q"
        crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl"
        crossorigin="anonymous"></script>

    <title>Rate My Loo</title>
</head>

<body>
    <?php require 'nav.php';?>
    <!-- My awesome jumbotron -->
    <div class="jumbotron jumbotron-fluid">
        <div class="container">
            <h1 class="display-4">Rate My Loo</h1>
            <p class="lead">Find the perfect bathroom on BYU-Idaho Campus.</p>
        </div>
    </div>

    <!-- Taken and adapted from TA in week 6 from 
         teacher solutio nand adapted to my project -->

<?php
$statement = $db->prepare(
   "SELECT bbf.building_floor_id  AS "Building Floor"
    ,      bbf.bathroom_id        AS "Bathroom ID"
    ,      b.building_name        As "Building Name"
    ,      b.building_id          AS "Building ID"
    FROM   bathrooms_building_floor  bbf
    ,      buildings                 b
    WHERE  bbf.building_floor_id = b.building_id
        SELECT u.is_male 
        ,      u.user_id
        FROM users u
        WHERE 
    "
);
$statement->execute();
// Go through each result
while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
    // The variable "row" now holds the complete record for that
    // row, and we can access the different values based on their
    // name
    $floor = $row['building_floor_id'];
    $bathtoom = $row['bathroom_id'];
    var_dump($row);
}
?>

</body>

</html>