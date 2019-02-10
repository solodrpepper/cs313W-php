<!-- Found on online tutorial -->
<?php
$uname = "";
$pword = "";
$errorMessage = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    require 'db_connect.php';
    $db = get_db();

    $uname = $_POST['email'];
    $pword = $_POST['hash_ed'];

    if ($db) {
        $statement = $db->prepare('SELECT * FROM login WHERE email = ?');
        $statement->bind_param('s', $uname);
        $statement->execute();
        $result = $statement->get_result();

        if ($result->num_rows == 1) {
            $db_field = $result->fetch_assoc();
            // Verify the password
            if (password_verify($pword, $db_field['hash_ed'])) {
                session_start();
                $_SESSION['login'] = "1";
                // if successfull redirect to the home page
                header("Location: home.php");
            } else {
                $errorMessage = "Login Failed";
                session_start();
                $_SESSION['login'] = '';
            }
        } else {
            $errorMessage = "Login Failed";
        }
    }
}
?>

<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <!-- CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm"
        crossorigin="anonymous">

    <!-- JavaScript -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN"
        crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q"
        crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl"
        crossorigin="anonymous"></script>

    <title>Rate My Loo - Login</title>
</head>

<body>
    <?php require 'nav.php';?>
    <FORM NAME="loginForm" METHOD="POST" ACTION="login.php">
        <!-- Here the user will enter in their credentials -->
        Email: <INPUT TYPE='TEXT' Name='username' value="<?php print $uname;?>"
            maxlength="30" required autofocus>
        Password: <INPUT TYPE='TEXT' Name='password' value="<?php print $pword;?>"
            maxlength="16" required>
        <p>
            <INPUT TYPE="Submit" Name="loginSubmit" VALUE="Login">
        </p>
    </FORM>
    <p>
        <?php print $errorMessage;?>
    </p>
</body>

</html>