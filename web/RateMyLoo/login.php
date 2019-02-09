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
        $SQL = $db->prepare('SELECT * FROM login WHERE email = ?');
        $SQL->bind_param('s', $uname);
        $SQL->execute();
        $result = $SQL->get_result();

        if ($result->num_rows == 1) {
            $db_field = $result->fetch_assoc();

            if (password_verify($pword, $db_field['hash_ed'])) {
                session_start();
                $_SESSION['login'] = "1";
                header("Location: home.php");
            } else {
                $errorMessage = "Login FAILED";
                session_start();
                $_SESSION['login'] = '';
            }
        } else {
            $errorMessage = "email FAILED";
        }
    }
}
?>


<html>

<head>
    <title>Basic Login Script</title>
</head>

<body>

    <FORM NAME="loginForm" METHOD="POST" ACTION="login.php">

        Username: <INPUT TYPE='TEXT' Name='username' value="<?php print $uname;?>"
            maxlength="20">
        Password: <INPUT TYPE='TEXT' Name='password' value="<?php print $pword;?>"
            maxlength="16">

        <p>
            <INPUT TYPE="Submit" Name="loginSubmit" VALUE="Login">
        </p>
    </FORM>
    <p>
        <?php print $errorMessage;?>
    </p>
</body>
</html>