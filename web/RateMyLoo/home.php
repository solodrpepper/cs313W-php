<?php
require 'db_connect.php';
$db = get_db();


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
   "SELECT bbf.building_id        AS bfid
    ,      bbf.bathroom_id        AS bid
    ,      b.building_name        AS bn
    ,      b.building_id          AS bdid
    ,      f.floor_id             AS fid
    ,      f.floor_value          AS fv
    FROM   bathrooms_building_floor  bbf
    ,      bathrooms                 b
    ,      floors                    f
    WHERE  bbf.bfid = b.bdid
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
    echo "<p>$bathtoom<p>";
}
?>

</body>

</html>