<?php

//Set Refresh header using PHP.
header( "refresh:3;url=https://morning-citadel-97793.herokuapp.com/RateMyLoo/login.php" );
 
//Print out some content for example purposes.
echo "<h2 style='align-self: center; align-text: center;'>
        Thank you for signing up!<br/>
        We'll redirect you in just a moment to the Login screen!
        <br/>Happy Flushing!!<h2><br /><br />";

echo "<h3 style='align-self: center; align-text: center;'>If you're not redirected in a few seconds, click here: ";
echo "<a href='https://morning-citadel-97793.herokuapp.com/RateMyLoo/login.php'>Login</a></h3>";

?>
