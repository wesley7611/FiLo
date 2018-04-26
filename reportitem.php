<?php
session_start();
include_once 'connect.php';
try {
    if (isset($_POST['submitted'])) {

        //get and sanitise the inputs to prevent SQL injection
        $safe_category = $db->quote($_POST['category']);
        $safe_item = $db->quote($_POST['item']);
        $safe_location = $db->quote($_POST['location']);
        $safe_date = $db->quote($_POST['date']);
        $safe_description = $db->quote($_POST['description']);
        $safe_image = $db->quote($_POST['image']);
        
        //Image variables TO COMPLETE
        $target_dir = "images/";
        $target_file = $target_dir . basename($_FILES["userfile"]["name"]);
        $uploadOk = 1;
        $imageFileType = pathinfo($target_file, PATHINFO_EXTENSION);

        $tmpname = $_FILES["userfile"]["tmp_name"];

        echo $tmpname;

        if (move_uploaded_file($_FILES["userfile"]["tmp_name"], $target_file)) {
            echo "The file " . basename($_FILES["userfile"]["name"]) . " has been uploaded.";
        } else {
            echo "Sorry, there was an error uploading your file.";
        }

        $image = basename($_FILES["userfile"]["name"], ".jpg"); // used to store the filename in a variable
        //insert the values from the form into the database
        $query = "insert into property values (default, $safe_category, $safe_item, $safe_date,$safe_location, $safe_description, $safe_description)";
        $db->exec($query);
    }
} catch (PDOException $ex) {
//this catches the exception when it is thrown
    echo "Sorry, a database error occurred. Please try again.<br> ";
    echo "Error details:" . $ex->getMessage();
}


//check if the person is logged in, otherwise redirect to index
if (!isset($_SESSION['name'])) {
    header("Location: index.php");
}

//include header and navbar for formatting and layout
include 'header.php';
include 'navbar.php';
?>

<!--User input form to submit the new item details-->
<form action="reportitem.php" method="post" id ="form" enctype="multipart/form-data">
    <table> 
        <tr><td>
                Category: </td><td><select name="category">
                    <option value="pets">Pets</option>
                    <option value="electronics">Electronics</option>
                    <option value="jewellery">Jewellery</option>
                </select>
            </td>
        <tr><td style="width:150px;">Item: </td><td><input type="text" name="item" size="90" maxlength="10" /></td></tr>
        <tr><td>Location found: </td><td><input  type="text" name="location" size="90" maxlength="10" /></td></tr>
        <tr><td>Date: </td><td><input type="text" id="date" name="date"></td></tr>
        <tr><td>Description: </td><td><textarea style="width:680px;" name="description" form="form" rows="10" size="90"></textarea></td></tr>
        <tr><td>Image: </td><td>
                <!--TO COMPLETE -->
                <!-- MAX_FILE_SIZE must precede the file input field -->
                <input type="hidden" name="maxsize" value="30000">
                <!-- Name of input element determines name in $_FILES array -->
                <input name="userfile" type="file" />
            </td></tr>
        <tr><td><input type="submit" name="submit" value="Submit" </td></tr>
        <input type="hidden" name="submitted" value="TRUE" />
</form>
</table>
    <!--Javascript for jquery datepicker, formatted to be consistent with SQL format-->
<script>
    $(function () {
        $("#date").datepicker({dateFormat: 'yy-mm-dd'});

    });
</script>
<!--Load external scripts and stylesheets for date picker-->
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<link rel="stylesheet" href="/resources/demos/style.css">
<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

/
<?php include 'footer.php' ?>
