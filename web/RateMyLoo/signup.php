<!-- Found on online tutorial -->
<!-- I write this new comment hours after I wrote the above comment... and
     now would like to say that I have done so much modifying that what is
     below is mostly edited now, they did, however, provide me with an
     amazing foundation and outline
-->
<?php
$uname = "";
$email = "";
$pword = "";
$errorMessage = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    require 'db_connect.php';
    $db = get_db();

    $uname   = $_POST['username'];
    $email   = $_POST['email'];
    $pword   = $_POST['hash_ed'];
    $is_male = $_POST['is_male'];

    $statement = $db->prepare("SELECT email FROM users WHERE email = :email");
    $statement->bindParam(':email', $email);

    try {
        if ($statement->execute()) {
            echo "It worked!!<br>";
        } else {
            echo "It broke.. :(<br>";
        }
    } catch (PDOException $ex) {
        echo 'Error!: ' . $ex->getMessage();
        die();
    }

    $result = $statement->fetch(PDO::FETCH_ASSOC);

    if ($result['email'] == $email) {
        $errorMessage = "Email already used";
    } else {
        // check to see if username is used
        $statement = $db->prepare("SELECT username FROM users WHERE username = :username");
        $statement->bindParam(':username', $uname);
        $statement->execute();
        $result = $statement->fetch(PDO::FETCH_ASSOC);

        if ($result['username'] == $uname) {
            $errorMessage = "Sorry, that username is already taken :(";
        } else {
            $phash = password_hash($pword, PASSWORD_DEFAULT);
            $statement = $db->prepare("INSERT INTO users (email, username, hash_ed) VALUES (:email, :username, :hash_ed, :is_male)");
            $statement->bindParam(':email', $email);
            $statement->bindParam(':username', $uname);
            $statement->bindParam(':hash_ed', $phash);
            $statement->bindParam(':is_male', $is_male);
            $statement->execute();
    
            header("Location: login.php");
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

    <title>Rate My Loo - Sign Up</title>
</head>

<body>
    <?php require 'nav.php';?>
    <div class="container login_form">
        <div class="row justify-content-md-center">
            <div class="col-lg-4">
                <div class="card">
                    <article class="card-body">
                        <h4 class="card-title mb-4 mt-1">Sign up</h4>
                        <form NAME="signUpForm" METHOD="POST" ACTION="signup.php">
                            <div class="form-group">
                                <label>Your Username</label>
                                <input class="form-control" name='username' placeholder="Username" type="text" value="<?php print $uname;?>"
                                    required autofocus maxlength="16">
                            </div> <!-- form-group username// -->
                            <div class="form-group">
                                <label>Your email</label>
                                <input class="form-control" name='email' placeholder="Email" type="email" value="<?php print $email;?>"
                                    required>
                            </div> <!-- form-group email// -->
                            <div class="form-group">
                                <label>Your password</label>
                                <INPUT class="form-control" name='password' value="<?php print $pword;?>"
                                    required placeholder="******" type="password">
                            </div> <!-- form-group password// -->
                            <div class="form-group">
                                <label>Sex</label><br/>
                                <INPUT class="form-control" name='sex'
                                <?php if ($is_male == true) {echo 'checked';}?>
                                    required type='radio'> Male
                                <INPUT class="form-control" name='sex'
                                <?php if ($is_male == false) {echo 'checked';}?>
                                    required type='radio'> Female
                            </div> <!-- form-group sex// -->
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary btn-block" name="loginSubmit"> Sign Up
                                </button>
                            </div> <!-- form-group// -->
                        </form>
                    </article>
                </div> <!-- card.// -->
            </div> <!-- row.// -->
        </div> <!-- col.// -->
    </div>
    <?php print $errorMessage;?>
</body>

</html>