<!-- Found on online tutorial -->
<?php
$uname = "";
$email = "";
$pword = "";
$errorMessage = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    require_once 'db_connect.php';
    $db = get_db();

    $uname   = $_POST['username'];
    $email   = $_POST['email'];
    $pword   = $_POST['hash_ed'];

    if ($db) {
        $statement = $db->prepare('SELECT email, username, hash_ed, is_male, user_id FROM users WHERE email = :email');
        $statement->bindParam(':email', $email);
        $statement->execute();
        $result = $statement->fetch(PDO::FETCH_ASSOC);

        $is_male = $result['is_male'];
        $user_id = $result['user_id'];

        if ($result['email'] == $email) {
            // Verify the password
            if (password_verify($pword, $result['hash_ed'])) {
                session_start();
                $uname = $result['username'];
                $_SESSION['login'] = "1";
                $_SESSION['uname'] = "$uname";
                $_SESSION['is_male'] = "$is_male";
                $_SESSION['user_id'] = "$user_id";
                // if successfull redirect to the home page
                flush();
                header("Location: home.php");
                die();
            } else {
                $errorMessage = "Login Failed";
                session_start();
                $_SESSION['login'] = '';
            }
        } else {
            $errorMessage = "That login info doesn't match any of our records";
        }
    }
}
?>

<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <!-- Bootstrap CSS -->
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

    <title>Rate My Loo - Login</title>
</head>

<body>
    <?php require 'nav.php';?>
    <div class="container login_form">
        <div class="row justify-content-md-center">
            <div class="col-lg-4">
                <div class="card">
                    <article class="card-body">
                        <a href="signup.php" class="float-right btn btn-outline-primary">Sign up</a>
                        <h4 class="card-title mb-4 mt-1">Login</h4>
                        <form NAME="loginForm" METHOD="POST" ACTION="login.php">
                            <div class="form-group">
                                <label>Your email</label>
                                <input class="form-control" name='email' placeholder="Email" type="email" value="<?php print $email;?>"
                                    required autofocus>
                            </div> <!-- form-group// -->
                            <div class="form-group">
                                <a class="float-right" href="#">Forgot?</a>
                                <label>Your password</label>
                                <INPUT class="form-control" name='password' value="<?php print $pword;?>"
                                    required placeholder="******" type="password">
                            </div> <!-- form-group// -->
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary btn-block" name="loginSubmit"> Login
                                </button>
                            </div> <!-- form-group// -->
                        </form>
                    </article>
                </div> <!-- card.// -->
            </div> <!-- row.// -->
        </div> <!-- col.// -->
    </div>



    <p>
        <?php print $errorMessage;?>
    </p>
</body>

</html>