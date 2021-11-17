<?php 
require 'includes/functions.php';
startSession();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
    <head>
        <title>Index page</title>
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
                if (trim($line) == 'true' && isset($_SESSION['username'])) {
                    echo '<li><a href="intranet.php">Intranet</a></li>';
                }
                $username = $_SESSION['username'] ?? '';
                if ($username == 'admin') {
                    echo '<li><a href="admin.php">Registration Form</a></li>';
                }
            ?>
        </ul>

        <p>The Department of Computer Science and Information Systems at Birkbeck is one of the first computing departments established in the UK, celebrating our 64th anniversary in 2021. <br>We provide a stimulating teaching and research environment for both part-time and full-time students, and a friendly, inclusive space for learning, working and collaborating.</p>
    </body>
    <?php 
    fclose($file);
    ?>
</html>
