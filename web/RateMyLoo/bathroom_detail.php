<?php
require_once 'db_connect.php';
$db = get_db();

session_start();
$user_id = $_SESSION['user_id'];

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
    WHERE   r.bathroom_id = :bid
    ORDER BY r.rating_id ASC"
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

    <!-- jQuery -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

    <!-- To Insert New Comments -->
    <script>
        $(document).ready(function() {
            $("#commentSubmit").click(function() {
                $.post("insert_comment.php", $( "#commentForm" ).serialize());
            });
        });
    </script>


    <title>Rate My Loo - <?php echo $building_name . ", " . $floor_value . " Floor";?>
    </title>
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
                            <span></span>
                        </div>
                        <a class='avatar' href='#'>
                            <i class='fas fa-user-ninja'></i>
                        </a>
                        <p>$comment</p>
                    </li>";
            }

            echo "<li class='write-new'>
                    <form id='commentForm' action='' method='post'>
                        <div class='wrap'>
                            <label class='statement'>What's your overall score of this bathroom?</label>
                            <ul class='likert'>
                                <li>
                                    <input type='radio' name='overall_score' value='5'>
                                    <label>Awesome!</label>
                                </li>
                                <li>
                                    <input type='radio' name='overall_score' value='4'>
                                    <label>Pretty Great</label>
                                </li>
                                <li>
                                    <input type='radio' name='overall_score' value='3'>
                                    <label>Eh..</label>
                                </li>
                                <li>
                                    <input type='radio' name='overall_score' value='2'>
                                    <label>If I Can't Hold It</label>
                                </li>
                                <li>
                                    <input type='radio' name='overall_score' value='1'>
                                    <label>Beyond Awful</label>
                                </li>
                            </ul>
                            <label class='statement'>How Clean is it?</label>
                            <ul class='likert'>
                                <li>
                                    <input type='radio' name='cleanliness' value='5'>
                                    <label>I Can See Sparkles!</label>
                                </li>
                                <li>
                                    <input type='radio' name='cleanliness' value='4'>
                                    <label>Real Clean</label>
                                </li>
                                <li>
                                    <input type='radio' name='cleanliness' value='3'>
                                    <label>It's Alright</label>
                                </li>
                                <li>
                                    <input type='radio' name='cleanliness' value='2'>
                                    <label>Gross</label>
                                </li>
                                <li>
                                    <input type='radio' name='cleanliness' value='1'>
                                    <label>Who Died in Here?</label>
                                </li>
                            </ul>
                    </div>
                        <textarea placeholder='Write your comment here' name='comment'></textarea>
                        <div>
                            <input type='text' name='user_id'     value='$user_id'     style='visibility: hidden'/>
                            <input type='text' name='bathroom_id' value='$bathroom_id' style='visibility: hidden'/>
                            <i class='fas fa-user-ninja'></i>
                            <button id='commentSubmit' type='button'>Submit</button>
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