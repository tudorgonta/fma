<?php 
require '../includes/functions.php';
startSession();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
    <head>
        <title>Web Programming using PHP - P1 Results</title>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
		<style>
			table {
				font-family: arial, sans-serif;
				border-collapse: collapse;
				width: 50%;
			}

			td, th {
				border: 1px solid #dddddd;
				text-align: left;
				padding: 5px;
			}

			tr:nth-child(even) {
				background-color: #dddddd;
			}
		</style>
    </head>
    <body>
        <?php 
            require "../includes/login.php";
        ?>
        <h1>Department of computer science intranet.</h1>
        <ul>
            <li><a href="../index.php">Home</a></li>
            <li><a href="../intranet.php">Intranet</a></li>
            <?php 
                if ($_SESSION['username'] == 'admin') {
                    echo '<li><a href="../admin.php">Registration Form</a></li>';
                }
            ?>
        </ul>

		<?php
            if(isset($_SESSION['username'])){
                echo '<ul>
                        <li><a href="dtr.php">DT Results</a></li>
                        <li><a href="p1r.php">P1 Results</a></li>
                        <li><a href="pfpr.php">PfP Results</a></li>
                    </ul>
					<h1>Web Programming using PHP - P1 Results</h1>
					<table>
					<tr>
						<th>Year</th>
						<th>Students</th>
						<th>Pass</th>
						<th>Fail (no resit)</th>
						<th>Resit</th>
						<th>Withdrawn</th>
					</tr>
					<tr>
						<td>2012/13</td>
						<td>50</td>
						<td>30</td>
						<td>5</td>
						<td>5</td>
						<td>10</td>
					</tr>
					<tr>
						<td>2013/14</td>
						<td>60</td>
						<td>35</td>
						<td>5</td>
						<td>12</td>
						<td>8</td>
					</tr>
					<tr>
						<td>2014/15</td>
						<td>45</td>
						<td>20</td>
						<td>3</td>
						<td>7</td>
						<td>15</td>
					</tr>
					<tr>
						<td>2015/16</td>
						<td>40</td>
						<td>25</td>
						<td>3</td>
						<td>5</td>
						<td>7</td>
					</tr>
					</table>';
            } else {
                echo '<p>Sorry, you have to be logged in to view view the data.';
            }
        ?>
	</body>		
</html>

