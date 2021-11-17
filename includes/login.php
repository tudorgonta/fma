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

// If delete session button pressed, destroy the session properly 
if (isset($_POST['logout'])) { 
    if ($_SESSION['username'] == 'admin'){
        $fil = fopen('val.txt', 'w');
        fwrite($fil, 'false');
        fclose($fil);
    }
	destroySession();
    header('Location: index.php');
}

// Validate form if it was submitted
if (isset($_POST['login'])) {

    // Username is a required field
    if (isset($_POST['user'])) {
        $name_in = trim($_POST['user']);
        $length = strlen($name_in);
        if ($length >= 1) {
            $clean['user'] = $name_in;
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
        if ($length >= 1) {
            $clean['pass'] = $name_in;
        } else {
            $errors_detected = true;
            $errors[] = 'Password is required';
        }
    } else {
        $errors_detected = true;
        $errors[] = 'Password not submitted';
    }
    // Open data file
    $file = fopen('users.txt', 'r');
    //loop through lines till matching one found/ if not, error message displays
    while(!feof($file)) {
        $line = fgets($file, 4096);
        list($title, $fname, $email, $uname, $pass) = array_pad(explode(';', $line, 5), 5, null);
        if(trim($uname) == $_POST['user'] && trim($pass) == $_POST['pass']) {
            // if user logged is admin then change value to true
            if ($_POST['user'] == 'admin'){
                $fil = fopen('val.txt', 'w');
                fwrite($fil, 'true');
                fclose($fil);
            }
            $form_is_submitted = true;
            break; 
        }
    }
    if($form_is_submitted === false) {
        $errors_detected = true;
        $errors[] = 'Invalid username or password.';
    }
    // close data file
    fclose($file);
}

if ($form_is_submitted === true && $errors_detected === false) {

    //store valid form data in the session super global array
    $_SESSION['username'] = $clean['user'];
    reloadCurrentPage();

}else {
    #decide whether to DISPLAY login form or logout button
    if (!isset($_SESSION['username']))
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
                        <div>
                            <label for="usern">Username:</label>
                            <input type="text" name="user" id="usern"/>
                        </div>

                        <div>
                            <label for="password">Password:</label>
                            <input type="password" name="pass" id="password"/>
                        </div>
                        <input type="submit" name="login" value="Log In" />
                    </fieldset>
                </form>';
    }else {
        #display session destroy/logout button
        $output .= '<form action="' . $self . '" method="post">
            <div>
                <p>'. $_SESSION['username'] .' is logged in: </p>                                                                    
                <input type="submit" name="logout" value="Log Out" />
            
            </div>
        </form>';
    }
}
echo $output;
?>