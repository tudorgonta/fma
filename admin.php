<?php 
require 'includes/functions.php';
startSession();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
    <head>
        <title>Admin page</title>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    </head>
    <body>

        <?php 
            require "includes/login.php";
        ?>
        <h1>Welcome to the department of computer science.</h1>
        <ul>
            <li><a href="index.php">Home</a></li>
            <?php 
                // Check if admin is logged in / if yes then display link to intranet
                $file = fopen('val.txt', 'r');
                $line = fgets($file, 4096);
                if (trim($line) == 'true') {
                    echo '<li><a href="intranet.php">Intranet</a></li>';
                }
                $username = $_SESSION['username'];
                if ($username == 'admin') {
                    echo '<li><a href="admin.php">Registration Form</a></li>';
                }
            ?>

        </ul>

        <h2>Please enter details below to register.</h2>
        <p>Please note the following:</p>
        <p>Username can be alphanumeric (a-z, 0-9) and has to be 4 to 11 charachters in length.</p>
        <p>Password has to be 4 to 12 charachters in length.</p>
        <?php 
            require "includes/reg.php";
        ?>
    </body>
</html>
