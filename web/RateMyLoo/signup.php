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
        $SQL = $db->prepare('SELECT  FROM login WHERE email = ?');
        $SQL->bind_param('s', $uname);
        $SQL->execute();
        $result = $SQL->get_result();

        if ($result->num_rows > 0) {
            $errorMessage = "Username already taken";
        } else {
            $phash = password_hash($pword, PASSWORD_DEFAULT);
            $SQL = $db_found->prepare("INSERT INTO users (email, hash_ed) VALUES (?, ?)");
            $SQL->bind_param('ss', $uname, $phash);
            $SQL->execute();

            header("Location: login.php");
        }
    } else {
        $errorMessage = "Database Not Found";
    }
}
?>

<html>
<head>
    <title>Rate My Loo - Sign Up</title>
</head>
<body>
<?php require 'nav.php';?>
    <FORM NAME="signUpForm" METHOD="POST" ACTION="signup.php">
        Email:    <INPUT TYPE='TEXT' Name='email' value="<?php print $uname;?>"><br/>
        Password: <INPUT TYPE='TEXT' Name='password' value="<?php print $pword;?>">
    <p>
        <INPUT TYPE="Submit" Name="signUpSubmit" VALUE="Register">
    </p>
    </FORM>
        <?php print $errorMessage;?>
</body>
</html>