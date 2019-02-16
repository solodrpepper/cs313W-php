<!-- Found on online tutorial -->
<!-- I write this new comment hours after I wrote the above comment... and
     now would like to say that I have done so much modifying that what is
     below is mostly edited now, they did, however, provide me with an
     amazing foundation and outline
-->
<?php
// for PHPMailer
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require_once 'PHPMailer/Exception.php';
require_once 'PHPMailer/PHPMailer.php';
 
// for reCAPTCHA
$site_key = "6LcY2ZEUAAAAALPbbE9ial1WhYyF1QGbJnfE8zyV";
$secret_key = "6LcY2ZEUAAAAANv__0gVivf5NPJfLV-rgsYu6IGL";
$google_captcha_url = "https://www.google.com/recaptcha/api/siteverify";

$uname = "";
$email = "";
$pword = "";
$errorMessage = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    require_once 'db_connect.php';
    $db = get_db();

    $uname            = $_POST['username'];
    $email            = $_POST['email'];
    $pword            = $_POST['hash_ed'];
    $isEmailConfirmed = $_POST['isEmailConfirmed'];
    $token            = $_POST['token'];
    $is_male          = $_POST['sex'];

    ///////////////////////
    // DEBUGGING
    //////////////////////

    echo "<script>console.log('$is_male')</script>";

    ///////////////////////
    // DEBUGGING
    //////////////////////

    $statement = $db->prepare("SELECT email FROM users WHERE email = :email");
    $statement->bindParam(':email', $email);

    try {
        $statement->execute();
    } catch (PDOException $ex) {
        echo 'Error!: ' . $ex->getMessage();
        die();
    }

    $result = $statement->fetch(PDO::FETCH_ASSOC);

    // Send verification out to google before we continue
    if (array_key_exists('signUpSubmit', $_POST)) {
        $response_key = $_POST['g-recaptcha-response'];
        // build post query for google
        $g_verification = $google_captcha_url . '?secret=' . $secret_key . '&response=' . $response_key . '&remoteip=' . $_SERVER['REMOTE_ADDR'];
        // send off the response
        $response = file_get_contents($g_verification);
        // decode json response from google
        $response = json_decode($response);
    
        if ($response->success == 1) {
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

                    // Let's create a token for the user
                    $token = 'qwertyuiopasdfghjklzxcvbnmQWERTYUIOPASDFGHJKLZXCVBNM0987654321!$()*';
                    $token = str_shuffle($token);
                    $token = substr($token, 0, 10);

                    // Let's hash the password so we can send the hash to the database
                    $phash = password_hash($pword, PASSWORD_DEFAULT);
                    $statement = $db->prepare("INSERT INTO users (email,  username,  hash_ed,  is_male, isEmailConfirmed, token) 
                                                         VALUES (:email, :username, :hash_ed, :is_male, 0,               :token)");
                    $statement->bindParam(':email',    $email);
                    $statement->bindParam(':username', $uname);
                    $statement->bindParam(':hash_ed',  $phash);
                    $statement->bindParam(':is_male',  $is_male);
                    //$statement->bindParam(':isEmailConfirmed', 0);
                    $statement->bindParam(':token',    $token);
                    $statement->execute();
    
                    // let's send an email to verify them before they have access
                    $mail = new PHPMailer();
                    $mail->setFrom('welcome@ratemyloo.com');
                    $mail->addAddress($email, $uname);
                    $mail->Subject('Please verify your email');
                    $mail->isHTML(true);
                    $mail->Body = "
                        Please click on the link below to verify your email and get rating!<br /><br />

                        <a href='https://morning-citadel-97793.herokuapp.com/RateMyLoo/confirmEmail.php?email=$email&token=$token'>Verify</a>
                    ";

                    if ($mail->send()) {
                        $verify = 'Check your inbox to verify your email and finish registering!';
                    } else {
                        $verify = 'Sorry, I think a pipe got clogged... Try again? ;)'; 
                    }

                    flush();
                    header("Location: login.php");
                    die();
                }
            }
        } else {
            $errorMessage = "Make sure you verify that you're not a robot!";
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

    <!-- This is for the reCAPTCHA -->
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>

    <!-- Check to see if the passwords match before we let them continue -->
    <script>
        function checkIfPasswordsMatch() {
            password  = document.getElementById('password_id').value;
            cPassword = document.getElementById('cpassword_id').value;
            if (password === cPassword) {
                document.getElementById('sign_up_form').submit();
            } else {
                document.getElementById('passwordError').style.visibility = "visible";
                document.getElementById('passwordError').innerHTML = "Sorry, your passwords don't match";
                document.getElementById('passwordError').focus();
            }
        }
    </script>

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
                        <form NAME="signUpForm" METHOD="POST" ACTION="signup.php" id="sign_up_form">
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
                                <INPUT class="form-control" name='password' id='password_id' value="<?php print $pword;?>"
                                    required placeholder="******" type="password">
                            </div> <!-- form-group password// -->
                            <div class="form-group">
                            <label>Confirm password</label>
                                <INPUT class="form-control" name='cpassword' id='cpassword_id'
                                    required placeholder="******" type="password"> 
                                    <p id="passwordError" style="visibility: hidden"></p>
                            </div> <!-- form-group confirm password// -->
                            <div class="form-group">
                                <label>Sex</label><br />
                                <div class='row'>
                                    <div class='col'>
                                        <input class="form-check-inline" name='sex' value='1' <?php if ($is_male == true) {echo 'checked';}?>
                                        required type='radio'>Male
                                    </div> <!-- form-col// -->
                                    <div class='col'>
                                        <input class="form-check-inline" name='sex' value='0' <?php if ($is_male == false) {echo 'checked';}?>
                                        required type='radio'>Female
                                    </div> <!-- form-col// -->
                                </div> <!-- form-row// -->
                            </div> <!-- form-group sex// -->
                            <div class="form-group">
                                <div class="g-recaptcha" data-sitekey="<?php echo $site_key; ?>"></div><br />
                                <button type="button" class="btn btn-primary btn-block" name="signUpSubmit" onClick="checkIfPasswordsMatch()">
                                    Sign Up
                                </button>
                            </div> <!-- form-group// -->
                        </form>
                    </article>
                </div> <!-- card.// -->
            </div> <!-- row.// -->
        </div> <!-- col.// -->
    </div>
    <?php print $errorMessage;?>
    <?php print $verify;?>
</body>

</html>