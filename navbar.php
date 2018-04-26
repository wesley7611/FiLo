<!--Navigation bar to move between different pages-->
<?php
echo '<p> <a href="loggedin.php">Home</a> <a href="reportitem.php">  REPORT FOUND ITEM</a><a href="claim.php"> CLAIM ITEM</a>';
//if logged in as admin, additional option will appear
if(isset($_SESSION['name'])&&$_SESSION['isadmin']==true){
    echo '<a href="admin.php"> MANAGE ITEM REQUESTS</a>';
}
echo '</p>';?>


