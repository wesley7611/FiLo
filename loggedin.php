<!--User login area-->
<?php

include_once 'connect.php';
//check if the person is logged in, otherwise redirect to start
if (!isset($_SESSION['name'])) {
    header("Location: index.php");
}

include 'header.php';
include 'navbar.php';
?>
<div id="BigBox">
    <div id="Box-content">
        <div id="Box-header">
            <span id="close" onclick="closeBox()">&times;</span>
        </div>
        <div id="Box-body">
            
        </div>
    </div>
</div>
<script>
// When the user clicks on <span> (x), close the modal
    function closeBox() {
        BigBox.style.display = "none";
    }
</script>
<h1 onclick='pets()'>PETS</h1><h1 onclick='electronics()'>ELECTRONICS</h1><h1 onclick='jewellery()'>JEWELLERY</h1>
<div id="propertytable">
    <?php
//SQL Queries retrieves each category of item
    $allItems = $db->query("select * from property");
    foreach ($allItems as $row) {
        echo '<script>function expand' . $row['id'] . '(){document.getElementById("BigBox").style.display="block";'
        . 'document.getElementById("Box-body").innerHTML="<h1>' . $row['Name'] . '</h2>"; '
        . 'document.getElementById("Box-body").innerHTML="<p>' . $row['Description'] . '<br/><img src="'.$row['image'].'"</p>"}'
        . '</script>';
    }

    //SQL query for each different category of item in the property table
    $pets = $db->query("select * from property where Category='pets'");
    $electronics = $db->query("select * from property where Category='electronics'");
    $jewellery = $db->query("select * from property where Category='jewellery'");
    echo '</div>';

//footer closes open tags on page
    include 'footer.php';

    /*
     * 3 blocks of functions below will fetch the different categories of items from the property table, and create a javascript function
     * to create a table with each type of item when it is clicked. Function is invoked from clicking the category headers above,
     * and the dynamic HTML to display the table of the chosen item type is placed in the propertytable Div
     */
    

    //load the functions to handle the table changes when the relevant header is selected
    drawtable("pets", $pets);
    drawTable("electronics", $electronics);
    drawTable("jewellery", $jewellery);

    //function to draw the various item category tables when called. Internal script will change HTML of propertytable div.
    function drawTable($cat, $content) {
        echo '<script>function ' . $cat . '(){document.getElementById("propertytable").innerHTML = "<table ><tr></tr><tr> <th >Name</th> <th >Date</th><th >Place</th><th>button</th></tr>';
        foreach ($content as $row) {
            echo '<tr><td >' . $row['Name'] . '</td><td >' . $row['Date'] . "</td><td >" . $row['Place'] . "</td><td ><button onclick='expand" . $row['id'] . "()'>more details</button></td></tr>";
        }
        echo '"}</script>';
        echo "</table> <br>";
    }
    ?>
    
    <!--Load pets table by default-->
    <script>window.onload = pets();</script>;
