<?php
require_once 'db_connect.php';
$db = get_db();

$user_id       = $_POST['user_id'];
$bathroom_id   = $_POST['bathroom_id'];
$comment       = $_POST['comment'];
$overall_score = $_POST['overall_score'];
$cleanliness   = $_POST['cleanliness'];


$statement = $db->prepare("INSERT INTO ratings ( user_id,  bathroom_id,  comment,  overall_score,  cleanliness) 
                           VALUES              (:user_id, :bathroom_id, :comment, :overall_score, :cleanliness)");
$statement->bindParam(':user_id', $user_id);
$statement->bindParam(':bathroom_id', $bathroom_id);
$statement->bindParam(':comment', $comment);
$statement->bindParam(':overall_score', $overall_score);
$statement->bindParam(':cleanliness', $cleanliness);
$statement->execute();

?>