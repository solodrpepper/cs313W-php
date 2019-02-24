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
    ,       r.overall_score
    ,       r.cleanliness
    ,       r.traffic
    ,       r.echo_value
    FROM    users u LEFT JOIN ratings r ON r.user_id = u.user_id       
    WHERE   r.bathroom_id = :bid"
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
        <div class='card'>
            <!-- Picture here -->
            <?php

            echo "<h1 style='align-text: center'>$building_name, $floor_value floor</h1>";


            // Comment section of the page
            echo "<div class='card'>";
            echo "<ul class='comment-section'>";

            while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
                $uname = $row['username'];
                $comment = $row['comment'];
                
                echo "<li class='comment user-comment'>
                        <div class='info'>
                            <a href='#'>$uname</a>
                            <span>4 hours ago</span>
                        </div>
                        <a class='avatar' href='#'>
                            <i class='fas fa-user-ninja'></i>
                        </a>
                        <p>$comment</p>
                    </li>";
            }

            echo "<li class='write-new'>
                    <form action='#' method='post'>
                        <textarea placeholder='Write your comment here' name='comment'></textarea>
                        <div>
                            <i class='fas fa-user-ninja'></i>
                            <button type='submit'>Submit</button>
                        </div>
                    </form>
                    </li>
                </ul>";
        ?>
        </div>
        </div>
    </div>





    


</body>

</html>