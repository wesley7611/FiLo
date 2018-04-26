<?php
session_start();
//continue session and connect to database
include_once 'connect.php';
include 'header.php';
?>
</div>
<div class="content_section_text">
    <?php
//if the form has been submitted
    try {
        if (isset($_POST['submitted'])) {

            //get and sanitise the inputsto prevent SQL injection.
            $safe_username = $db->quote($_POST['username']);
            $safe_email = $db->quote($_POST['email']);
            $c_password = md5($_POST['cpassword']);
            $hashed_password = md5($_POST['password']);


            //check for valid email address
            
            if (!filter_var($safe_email, FILTER_VALIDATE_EMAIL) && !preg_match('/@.+\./', $safe_email)) {
                    echo 'invalid email';
                
                }else{
                    if ($c_password == $hashed_password) {
                    $existing_users = $db->query("SELECT COUNT(username) FROM users WHERE username='" . $_POST['username'] . "'");
                    if (existing_users > 0) {
                    //if username already exists, displays an error
                    echo "Username already exists";
                    }
                    //if all checs are ok, create user by adding to database
                    $query = "insert into users values ($safe_username, $safe_email, '$hashed_password', false)";

                $db->exec($query);

                    //if it succeeds, display message, or if passwords dont match, display error.
                    echo "Congratulations! You are now registered.";
                } else {
                    echo "Passwords do not match";
                }
            }
    }} catch (PDOException $ex) {
        //this catches the exception when it is thrown
        echo "Sorry, a database error occurred. Please try again.<br> ";
        echo "Error details:" . $ex->getMessage();
    }

    if (!$registered) {
        //draw registration form
        echo '<form action = "register.php" method = "post">

        <p>User Name: <input type="text" name="username" size="15" maxlength="20" /></p>
        <p>email <input type="text" name="email" size="15" maxlength="30" /></p>
        <p>Password: <input type="password" name="password" size="15" maxlength="20" /></p>
        <p>Confirm Password: <input type="password" name="cpassword" size="15" maxlength="20" /></p>
        <p><input type="submit" name="submit" value="Submit" /></p>
        <input type="hidden" name="submitted" value="TRUE" />    
    </form>';
    }
    include'footer.php'
    ?>

