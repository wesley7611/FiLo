<!Header php file, included on each page to provide style sheet formatting and log in form>
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>


        <script type = "text/javascript" src = "https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
        <title>Filo Lost And Found</title>
        <!-- CSS for formatting the page layout-->
        <style type="text/css" media="screen">
            /*
                CSS for pop up window
            
            * The Modal (background) */
            #BigBox {
                display: none; /* Hidden by default */
                position: fixed; /* Stay in place */
                z-index: 1; /* Sit on top */
                left: 0;
                top: 0;
                width: 100%; /* Full width */
                height: 100%; /* Full height */
                overflow: auto; /* Enable scroll if needed */
                background-color: rgb(0,0,0); /* Fallback color */
                background-color: rgba(0,0,0,0.4); /* Black w/ opacity */
            }

            /* Modal Content/Box */
            #Box-content {
                background-color: #fefefe;
                margin: 15% auto; /* 15% from the top and centered */
                padding: 20px;
                border: 1px solid #888;
                width: 80%; /* Could be more or less, depending on screen size */
            }

            /* The Close Button */
            #close {
                color: #aaa;
                float: right;
                font-size: 28px;
                font-weight: bold;
            }

            #close:hover,
            #close:focus {
                color: black;
                text-decoration: none;
                cursor: pointer;
            }


            /*Main page layout CSS*/

            * {
                margin: 0px 0px 0px 0px;
                padding: 0px 0px 0px 0px;
            }

            body, html {
                padding: 3px 3px 3px 3px;

                background-color: #D8DBE2;

                font-family: Verdana, sans-serif;
                font-size: 11pt;
                text-align: center;
            }

            div.main_page {
                position: relative;
                display: table;

                width: 800px;

                margin-bottom: 3px;
                margin-left: auto;
                margin-right: auto;
                padding: 0px 0px 0px 0px;

                border-width: 2px;
                border-color: #212738;
                border-style: solid;

                background-color: #FFFFFF;

                text-align: center;
            }

            div.page_header {
                height: 99px;
                width: 100%;

                background-color: #F5F6F7;
            }

            div.page_header span {
                margin: 15px 0px 0px 50px;

                font-size: 180%;
                font-weight: bold;
            }

            div.page_header img {
                margin: 3px 0px 0px 40px;

                border: 0px 0px 0px;
            }

            div.table_of_contents {
                clear: left;

                min-width: 200px;

                margin: 3px 3px 3px 3px;

                background-color: #FFFFFF;

                text-align: left;
            }

            div.table_of_contents_item {
                clear: left;

                width: 100%;

                margin: 4px 0px 0px 0px;

                background-color: #FFFFFF;

                color: #000000;
                text-align: left;
            }

            div.table_of_contents_item a {
                margin: 6px 0px 0px 6px;
            }

            div.content_section {
                margin: 3px 3px 3px 3px;

                background-color: #FFFFFF;
                width:800px;
                text-align: left;
            }

            div.content_section_text {
                padding: 4px 8px 4px 8px;

                color: #000000;
                font-size: 100%;
            }

            div.content_section_text pre {
                margin: 8px 0px 8px 0px;
                padding: 8px 8px 8px 8px;

                border-width: 1px;
                border-style: dotted;
                border-color: #000000;

                background-color: #F5F6F7;

                font-style: italic;
            }

            div.content_section_text p {
                margin-bottom: 6px;
            }

            div.content_section_text ul, div.content_section_text li {
                padding: 4px 8px 4px 16px;
            }

            div.section_header {
                padding: 3px 6px 3px 6px;

                background-color: #8E9CB2;

                color: #FFFFFF;
                font-weight: bold;
                font-size: 112%;
                text-align: left;
                height:30px;
            }

            table, th, tr, td {
                border:1px solid black;
            }
            table{
                width:780px;
            }
            div.section_header_red {
                background-color: #CD214F;
            }

            div.section_header_grey {
                background-color: #9F9386;
            }

            .floating_element {
                position: relative;
                float: left;
            }

            div.table_of_contents_item a,
            div.content_section_text a {
                text-decoration: none;
                font-weight: bold;
            }

            div.table_of_contents_item a:link,
            div.table_of_contents_item a:visited,
            div.table_of_contents_item a:active {
                color: #000000;
            }

            div.table_of_contents_item a:hover {
                background-color: #000000;

                color: #FFFFFF;
            }

            div.content_section_text a:link,
            div.content_section_text a:visited,
            div.content_section_text a:active {
                background-color: #DCDFE6;

                color: #000000;
            }

            div.content_section_text a:hover {
                background-color: #000000;

                color: #DCDFE6;
            }

            div.validator {
            }
        </style>
    </head>
    <body>
        <div class="main_page">
            <div class="page_header floating_element" align="centre">

                <span>
                    FILo Lost And Found
                </span>
            </div>
            <div class="content_section floating_element">


                <div class="section_header">
                    <!-- Header containing the login script. If the user is logged in, this will display their a welcome message with their username,
                    and the option to log out.
                    
                    If the user is not logged in, this will provide the login form where they can enter their username and password. Once submitted, 
                    it will load/reload the index page to handle the post.-->
                    <?php
                    if (isset($_SESSION['name'])) {
                        echo '<p>Hello ' . $_SESSION['name'];
                        echo '<a href = "logout.php"> Logout </a><p>';
                    } else {
                        echo'<form action = "index.php" method = "post">
                    <p>User Name: <input style = "display: inline; " type = "text" name = "username" size = "10" maxlength = "10" />
                    Password: <input style = "display: inline" type = "password" name = "password" size = "10" maxlength = "10" />
                    <input style = "display: inline" type = "submit" name = "submit" value = "Submit" />
                    <input style = "display: inline"type = "hidden" name = "submitted" value = "TRUE" />
                    <a href = "register.php" style = "display:inline; text-align: right;"> Or click here to register </a></p></form>
                    </div>';
                    }
                    ?>
                </div>
                <div class="content_section_text">