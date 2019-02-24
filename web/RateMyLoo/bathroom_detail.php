<?php
require_once 'db_connect.php';
$db = get_db();
// Grab the bathroom id that they clicked on
$bathroom_id = htmlspecialchars($_GET['bathroom_id']);

$statement = $db->prepare('SELECT building_name, floor_value FROM bathrooms WHERE bathroom_id = :bid');
$statement->bindParam(':bid', $bathroom_id);
$statement->execute();
$result = $statement->fetch(PDO::FETCH_ASSOC);
$building_name = $result['building_name'];
$floor_value   = $result['floor_value'];


$statement = $db->prepare(
    "SELECT u.username
    ,       r.comment
    FROM    users u
    ,       bathrooms b  INNER JOIN ratings r ON r.user_id = u.user_id       
    WHERE   b.bathroom_id = :bid"
);

$statement->bindParam(':bid', $bathroom_id);
$statement->execute();


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

    <title>Rate My Loo - (NAME) of Bathroom</title>
</head>

<body>
    <?php require 'nav.php';?>

    <div class='container'>
        <!-- Picture here -->
        <?php
            

            $floor_value = $statement['floor_value'];
            $building_name = $statement['building_name'];

            while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
                $comment = $row['comment'];
                $uname = $row['username'];
            }
        ?>

    </div>

</body>

</html>