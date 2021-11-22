<?php
// Sanitise the current URL for use in the "action" attribute of a form
$self = htmlentities($_SERVER['PHP_SELF']);
// State variables
$form_is_submitted = false;
$errors_detected = false;

// Arrays to gather data
$clean = array();
$errors = array();

// Collect output in a variable, tidier than multiple "echo" calls
$output = '';

// Validate form if it was submitted
if (isset($_POST['reg'])) {

    // Username is a required field
    if (isset($_POST['uname'])) {
        $name_in = trim($_POST['uname']);
        $length = strlen($name_in);
        if (ctype_alpha($name_in) && $length >= 4 && $length <=11) {
            $clean['uname'] = $name_in;
        } else {
            $errors_detected = true;
            $errors[] = 'Username is required';
        }
    } else {
        $errors_detected = true;
        $errors[] = 'Username not submitted';
    }

    // password is a required field
    if (isset($_POST['pass'])) {
        $name_in = trim($_POST['pass']);
        $length = strlen($name_in);
        if ($length >= 4 && $length <= 12) {
            // generate random salt 32 byte
            $salt = bin2hex(random_bytes(32));
            // convert salt and append to array
            $clean['salt'] = $salt;
            // hash the password using pdkdf2 function
            $clean['pass'] = pbkdf2("sha256", $name_in, $salt, 1000, 32, false);
        } else {
            $errors_detected = true;
            $errors[] = 'Password is required';
        }
    } else {
        $errors_detected = true;
        $errors[] = 'Password not submitted';
    }

    // email is a required field
    if(isset($_POST['email'])) {
        $name_in = trim($_POST['email']);
        $length = strlen($name_in);
        if (filter_var($name_in, FILTER_VALIDATE_EMAIL)) {
            $clean['email'] = $name_in;
        } else {
            $errors_detected = true;
            $errors[] = 'Please enter a valid email.';
        }
    } else {
        $errors_detected = true;
        $errors[] = 'Email not submitted';
    }

    // Full name is a required field
    if(isset($_POST['fname'])) {
        $name_in = trim($_POST['fname']);
        $length = strlen($name_in);
        if (preg_match("/^[a-zA-Z-' ]*$/", $name_in) && $length > 1) {
            $clean['fname'] = $name_in;
        } else {
            $errors_detected = true;
            $errors[] = 'Full name should contain only alphabetic numbers and white spaces.';
        }
    } else {
        $errors_detected = true;
        $errors[] = 'Full Name not submitted';
    }

    //Check if user exists

    // Open data file
    $file = fopen('users.txt', 'r') or die("Couldn't open the file.");
    //loop through lines till matching one found/ if not, error message displays
    $name = $_POST['uname'] ?? '';
    $email = $_POST['email'] ?? '';
    $user_det = array();
    while(!feof($file)) {
        $line = fgets($file, 4096);
        list($title, $fname, $email, $uname, $salt, $pass) = array_pad(explode(';', $line, 6), 6, null);
        if(trim($uname) == $_POST['uname'] || trim($email) == $_POST['email']) {
            $errors_detected = true;
            $errors[] = 'User already exists';
            break; 
        } 
    }
    // close data file
    fclose($file);
    $form_is_submitted = true;
    // append the title value
    $title_name_in = trim($_POST['title']);
    $clean['title'] = $title_name_in;

}

if ($form_is_submitted === true && $errors_detected === false) {

    //Add data to a var to be submitted
    $data = $clean['title'] .';';
    $data .= $clean['fname'] .';';
    $data .= $clean['email'] .';';
    $data .= $clean['uname'] .';';
    //store salt in user data
    $data .= $clean['salt'] . ';';
    $data .= $clean['pass'] . "\n";
    //open data file
    $file = fopen('users.txt', 'a') or die("Couldn't open the file.");
    // write data to file
    fwrite($file, $data) or die("Couldn't not write into the file.");
    fclose($file);

    // display the form
    $output .= '<p>User registered:'. $clean['uname'] .'</p>
                <form action="' . $self . '"method="post">
                <fieldset>
                <legend>All fields are required</legend>
                    <div>
                        <label for="titl">Title *</label>
                        <select id="titl" name="title">
                            <option value="mr">Mr</option>
                            <option value="mrs">Mrs</option>
                            <option value="ms">Ms</option>
                            <option value="dr">Dr</option>
                        </select>
                    </div>
                    <div>
                        <label for="fullname">Full Name *</label>
                        <input type="text" name="fname" id="fullname"/>
                    </div>
                    <div>
                        <label for="emails">Email *</label>
                        <input type="text" name="email" id="emails"/>
                    </div>
                    <div>
                        <label for="username">Username *</label>
                        <input type="text" name="uname" id="username"/>
                    </div>

                    <div>
                        <label for="password">Password:</label>
                        <input type="password" name="pass" id="password"/>
                    </div>
                    <input type="submit" name="reg" value="Register" />
                </fieldset>
            </form>';
}else {
    #decide whether to DISPLAY login form or logout button
    if ($_SESSION['username'] == 'admin')
    {
        // Display error messages, if there are any
		if ($errors_detected === true) {
			$output .= '<p>Sorry, we found some errors with your data:</p>';
			$output .= '<ul>';
			foreach ($errors as $reason) {
				$output .= '<li>'.htmlentities($reason).'</li>';
			}
			$output .= '</ul>';
		}
        // display the form
        $output .= '<form action="' . $self . '"method="post">
                    <fieldset>
                    <legend>All fields are required</legend>
                        <div>
                            <label for="titl">Title *</label>
                            <select id="titl" name="title">
                                <option value="mr">Mr</option>
                                <option value="mrs">Mrs</option>
                                <option value="ms">Ms</option>
                                <option value="dr">Dr</option>
                            </select>
                        </div>
                        <div>
                            <label for="fullname">Full Name *</label>
                            <input type="text" name="fname" id="fullname"/>
                        </div>
                        <div>
                            <label for="emails">Email *</label>
                            <input type="text" name="email" id="emails"/>
                        </div>
                        <div>
                            <label for="username">Username *</label>
                            <input type="text" name="uname" id="username"/>
                        </div>

                        <div>
                            <label for="password">Password *</label>
                            <input type="password" name="pass" id="password"/>
                        </div>
                        <input type="submit" name="reg" value="Register" />
                    </fieldset>
                </form>';
    }else {
        #display session destroy/logout button
        $output .= '<p>You must be an admin to view this page!</p>';
    }
}
echo $output;
?>