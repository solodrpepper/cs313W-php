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
    <title>Rate My Loo - Login</title>
</head>
<body>
<?php require 'nav.php';?>
    <FORM NAME="loginForm" METHOD="POST" ACTION="login.php">
        <!-- Here the user will enter in their credentials -->
        Email:    <INPUT TYPE='TEXT' Name='username' value="<?php print $uname;?>"
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