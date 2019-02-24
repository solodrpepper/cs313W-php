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
            

            echo $floor_value;
            echo $building_name;

            while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
                $comment = $row['comment'];
                $uname = $row['username'];

                echo $comment;
                echo "<br />-- ";
                echo $uname;
            }
        ?>
        </div>
    </div>

    <!-- Comment section of the page -->
    <ul class="comment-section">
        <li class="comment user-comment">
            <div class="info">
                <a href="#">Anie Silverston</a>
                <span>4 hours ago</span>
            </div>
            <a class="avatar" href="#">
                <img src="images/avatar_user_1.jpg" width="35" alt="Profile Avatar" title="Anie Silverston" />
            </a>
            <p>Suspendisse gravida sem?</p>
        </li>
        <li class="comment author-comment">
            <div class="info">
                <a href="#">Jack Smith</a>
                <span>3 hours ago</span>
            </div>
            <a class="avatar" href="#">
                <img src="images/avatar_author.jpg" width="35" alt="Profile Avatar" title="Jack Smith" />
            </a>
            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Suspendisse gravida sem sit amet molestie
                portitor.</p>
        </li>
        <li class="comment user-comment">
            <div class="info">
                <a href="#">Bradley Jones</a>
                <span>1 hour ago</span>
            </div>
            <a class="avatar" href="#">
                <img src="images/avatar_user_2.jpg" width="35" alt="Profile Avatar" title="Bradley Jones" />
            </a>
            <p>Suspendisse gravida sem sit amet molestie portitor?</p>
        </li>
        <li class="comment author-comment">
            <div class="info">
                <a href="#">Jack Smith</a>
                <span>1 hour ago</span>
            </div>
            <a class="avatar" href="#">
                <img src="images/avatar_author.jpg" width="35" alt="Profile Avatar" title="Jack Smith" />
            </a>
            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Suspendisee gravida sem sit amet molestie
                porttitor.</p>
        </li>
        <li class="write-new">
            <form action="#" method="post">
                <textarea placeholder="Write your comment here" name="comment"></textarea>
                <div>
                    <img src="images/avatar_user_2.jpg" width="35" alt="Profile of Bradley Jones" title="Bradley Jones" />
                    <button type="submit">Submit</button>
                </div>
            </form>
        </li>
    </ul>

</body>

</html>