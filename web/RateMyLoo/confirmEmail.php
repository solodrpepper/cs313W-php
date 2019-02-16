<?php
    // create a redirect function
    function redirect($whereTo)
    {
        flush();
        header("Location:  $whereTO");
        die();
    }

    if (!isset($_GET['email']) || !isset($_GET['token'])) {
        redirect('signup.php');
    } else {
        $email = htmlspecialchars($_GET['email']);
        $token = htmlspecialchars($_GET['token']);
        $errorMessage = "";

        // get connected to the database
        require_once 'db_connect.php';
        $db = get_db();

        // let's check out if we got a legit registration
        $query = "SELECT id FROM users WHERE email = :email AND token = :token AND isEmailConfirmed = 0";
        $statement = $db->prepare($query);
        $statement->bindParam(':email', $email);
        $statement->bindParam(':token', $token);
        $statement->execute();
        // capture the query results
        $result = $statement->fetch(PDO::FETCH_ASSOC);

        // see if we got any matches
        if ($result->num_rows > 0) {
            // let's update the table and get them on there way!
            $query = "UPDATE users SET isEmailConfirmed = :isEmailConfirmed, token = :token WHERE email = :email";
            $statement = $db->prepare($query);
            $statement->bindParam(':email', $email);
            $statement->bindParam(':isEmailConfirmed', 1);
            $statement->bindParam(':token', '');
            $statement->execute();

            // now we can redirect them to the login page
            redirect('login.php');
        } else {
            // let's redirec them to the signup page because they got it wrong!
            redirect('signup.php'); 
        }
    }
