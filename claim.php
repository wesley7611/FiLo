<?php
//continue session, connect to database
session_start();
include_once 'connect.php';

//sanitise inputs to prevent SQL injection
$safe_item = $db->quote($_POST['item']);
$safe_reason = $db->quote($_POST['reason']);
$safe_name = $_SESSION['name'];

try {
    if (isset($_POST['submitted'])) {
        $query = "insert into claims values (default, '$safe_name', $safe_item, $safe_reason)";
        $db->exec($query);
    }
} catch (PDOException $ex) {
//this catches the exception when it is thrown and displays db error
    echo "Sorry, a database error occurred. Please try again.<br> ";
    echo "Error details:" . $ex->getMessage();
}


include 'header.php';
include 'navbar.php';
//if the form hasnt been submitted, it is drawn onto the page
    if (!isset($_POST['submitted'])) {
        
        echo '<form id="claimform" action="claim.php" method="post">
        <h3>Item you wish to claim:</h3>
        <select name="item">';
        //<?php
        $items = $db->query("select * from property");

        //draws a dropdown list with each item in database as an option
        foreach ($items as $row) {
            echo '<option value = ' . $row["id"] . '>ID ' . $row["id"] . ': ' . $row["Name"] . '</option>';
        };

        echo' </select>
        <h3>Reason for Claim:</h3>
        <textarea style="width:680px;" name="reason" form="claimform" rows="10" size="90">Please give details of why you are making this claim, such as where you lost the item, how, and any distinguishing features or markings. If the item is serialised and you can provide the serial number please do so.</textarea>
        </select>
        <input type="submit" name="submit" value="Submit" </td></tr>
        <input type="hidden" name="submitted" value="TRUE" />
    </form>
    ';
    }
    else{
        //if the form has been submitted, a message is shown.
        echo '<p>Thank you, your claim is being reviewed, and you will be contacted soon to notify you whether it has been approved</p>';
    }
    ?>


