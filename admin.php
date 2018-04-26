<?php
//starts session, connects to database
session_start();
include_once 'connect.php';

//check if the person is logged in and is an administrator, otherwise redirect to start
if (!isset($_SESSION['name']) || $_SESSION['isadmin'] != true) {
    header("Location: index.php");
};
    
//if the reject button has been pressed for any item
if (isset($_POST['reject']) && isset($_POST['id'])) {
    $id = $_POST['id'];
    
    /*Gets the claimants email address and creates an email to send letting them know their claim has been rejected
     * Email is sent to registered email address. Requires php email to be installed on server
     */
    
    $email = $db->query("select username, email from users where username = (select user from claims where id= $id)");
    $firstrow = $email->fetch();
    $to = $firstrow['email'];
    $subject = "FIlo Property claim rejected";
    $message = "Dear $safe_name \n Your request to claim an item of lost property has been declined. \n For further information please contact customer support. \n Kind Regards \n FILo ";
    mail($to, $subject, $message);
    
    //deletes the claim from the claim table
    $query = "DELETE FROM claims WHERE id=$id";
    $db->exec($query);
}

if (isset($_POST['accept']) && isset($_POST['id'])) {
    //Same as above but for accepted claims
    $id = $_POST['id'];
    $email = $db->query("select username, email from users where username = (select user from claims where id=$id)");
    $firstrow = $email->fetch();
    $to = $firstrow['email'];
    $subject = "FIlo Property claim accepted";
    $message = "Dear $safe_name \n Your request to claim an item of lost property has been accepted. \n We will be in touch shortly to arrange collection of your item. \n Kind Regards \n FILo ";
    mail($to, $subject, $message);

    //deletes claim from both the claim table and the property table, as the item is no longer available
    $id = $_POST['id'];
    $query = ("DELETE FROM property WHERE id = (select item from claims where id =$id)");
    $db->exec($query);
    $query = ("DELETE FROM claims WHERE id=$id");
    $db->exec($query);
}
//includes header and navbar
include 'header.php';
include 'navbar.php';

//fetches and draws each claim into a table. Draws two buttons beside either claim to accept or reject, which when pressed will reload the page
//with the relevant post data.
$requests = $db->query("select claims.id, user, property.Name, reason from claims INNER JOIN property ON item = property.id");
echo '<table>';
foreach ($requests as $row) {
    echo '<tr><td style="width:100px;">' . $row['user'] . '</td><td style="width:100px;" >' . $row['Name'] . "</td><td >" . $row['reason'] . '</td><td><form action="admin.php" method="post">
    <input type="hidden" name="accept" value="yes" />
    <input type="hidden" name="id" value="' . $row['id'] . '" />
    <input type="submit" value="Accept" /></form>
    </td><td><form action="admin.php" method="post">
    <input type="hidden" name="reject" value="yes" />
    <input type="hidden" name="id" value="' . $row['id'] . '" />
    <input type="submit" value="Reject" /></form></td></tr>';
    ;
}
?>
</table>

