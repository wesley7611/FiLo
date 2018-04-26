<?php
include_once 'connect.php';

//if user has logged, send to admin page if they are an admin, or loggedin page if regular user
if (isset($_SESSION['name']) && $_SESSION['isadmin'] == true) {
    header("Location: admin.php");
} elseif (isset($_SESSION['name'])) {
    header("Location: loggedin.php");
}

//Checks if login details have been submitted
if (isset($_POST['submitted'])) {
    //retrieves username and password from the form
    $username = $_POST['username'];
    $password = $_POST['password'];

    //sanitise the input, binding username to parameter to prevent SQL injection
    $safe_username = $db->quote($username);

    //run a query to get the user associated with that username
    $query = "select * from users where username = $safe_username";
    $result = $db->query($query);
    $firstrow = $result->fetch(); //get the first row. Usernames are unique in SQL table, so there will be only 1 value

    if (!empty($firstrow)) {
        //check the passwords, if correct reloads page with session info
        $hashed_password = md5($password);

        if ($firstrow['password'] == $hashed_password) {
            $_SESSION['id'] = $firstrow['id'];
            $_SESSION['name'] = $firstrow['username'];
            $_SESSION['isadmin'] = $firstrow['isadmin'];

            header('Location: index.php');
            exit();
        } else {
            //if password doesnt match, set error message
            $error = "<p>Error logging in, password does not match</p>";
        }
    } else {
        //if username isnt found, set error
        $error = "<p>Error logging in, Username not found </p>";
    }
}
//include the header php file
include'header.php';

//displays error, if one exists
echo $error;
?>


<!-- HTML table to  display  all the property records -->

<!--provide item categories, when clicked will display all items of that table-->
<h1 onclick='pets()'>PETS</h1><h1 onclick='electronics()'>ELECTRONICS</h1><h1 onclick='jewellery()'>JEWELLERY</h1>

<div id='propertytable'>
    <script> function loginAlert(){
        window.alert("Please login to see more item details");
    </script>

        
        <?php
        //SQL Queries retrieves each category of item
        $pets = $db->query("select * from property where Category='pets'");
        $electronics = $db->query("select * from property where Category='electronics'");
        $jewellery = $db->query("select * from property where Category='jewellery'");

        //By default, page will display a table showing the lost pets

        echo '</div>';
        
        //footer closes open tags on page
        include 'footer.php';

/*
 * 3 blocks of function calls below will fetch the different categories of items from the property table    . Function is invoked from clicking the category headers above,
 * and the dynamic HTML to display the table of the chosen item type is placed in the propertytable Div
 */

        
        
    //load the functions to handle the table changes when the relevant header is selected
    drawtable("pets", $pets);
    drawTable("electronics", $electronics);
    drawTable("jewellery", $jewellery);

    //function to draw the various item category tables when called. Internal script will change HTML of propertytable div.
    function drawTable($cat, $content) {
        echo '<script>function ' . $cat . '(){document.getElementById("propertytable").innerHTML = "<table ><tr></tr><tr> <th >Name</th> <th >Date</th><th >Place</th></tr>';
        foreach ($content as $row) {
            echo '<tr><td >' . $row['Name'] . '</td><td >' . $row['Date'] . "</td><td >" . $row['Place'] . "</td></tr>";
        }
        echo '"}</script>';
        echo "</table> <br>";
    }
    
?>
    <!--Load pets table by default-->
    <script>window.onload = pets();</script>;
        
