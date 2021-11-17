<?php 
require 'includes/functions.php';
startSession();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
    <head>
        <title>Intranet</title>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    </head>
    <body>

        <?php 
            require "includes/login.php";
        ?>
        <h1>Department of computer science intranet.</h1>
        <ul>
            <li><a href="index.php">Home</a></li>
            <?php 
                // Check if admin is logged in / if yes then display link to intranet
                $file = fopen('val.txt', 'r');
                $line = fgets($file, 4096);
                if (trim($line) == 'true' && isset($_SESSION['username'])) {
                    echo '<li><a href="intranet.php">Intranet</a></li>';
                }
                $username = $_SESSION['username'] ?? '';
                if ($username == 'admin') {
                    echo '<li><a href="admin.php">Registration Form</a></li>';
                }
            ?>
        </ul>
        <?php
            if(isset($_SESSION['username'])){
                echo '<ul>
                        <li><a href="intranet/dtr.php">DT Results</a></li>
                        <li><a href="intranet/p1r.php">P1 Results</a></li>
                        <li><a href="intranet/pfpr.php">PfP Results</a></li>
                    </ul>';
            } else {
                echo '<p>Sorry, you have to be logged in to view view the data.';
            }
        ?>

</body>
</html>