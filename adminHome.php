<?php
session_start();
// If the user is not logged in redirect to the login page...
if (!isset($_SESSION['loggedin'])) {
	header('Location: index.html');
	exit();
}
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Admin Home</title>
        <script src="https://kit.fontawesome.com/5b04b82caa.js" crossorigin="anonymous"></script>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <script src="adminJS.js"></script>        
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <style>
           @import url('https://fonts.googleapis.com/css?family=Montserrat:400,800');

body {
    font-family: 'Montserrat', sans-serif;
    margin: 0;
}
        /* Add a black background color to the top navigation */
        .topnav {
        background-color:#f5f6f7;
        overflow: hidden;

        }

        .text-area a{
            color: #3d3d3d;
            text-decoration: none;
        }

        .text-area p{
            letter-spacing: 1px;
            padding-left: 20px;
        }
        /* Style the links inside the navigation bar */
        .topnav a {
        float: left;
        display: block;
        color: #3d3d3d;
        text-align: center;
        padding: 14px 16px;
        text-decoration: none;
        font-size: 20px;
        font-family: 'Montserrat', 'sans-serif';
        padding-left: 10px;
        }

        /* Change the color of links on hover */
        .topnav a:hover {
        background-color: #ddd;
        color: #7da3a1;
        }

        .text-area {
            margin: 0px auto;
            padding-left: 20px;
        }

        /* Add an active class to highlight the current page */
        .topnav a.active {
        background-color: #7da3a1;
        color: white;
        }

        .topnav .icon {
        display: none;
        }

        @media screen and (max-width: 600px) {
            .topnav a:not(:first-child) {display: none;}
            .topnav a.icon {
            float: right;
            display: block;
            }
        }
        h1 {
            padding-left: 20px;
        }
        /* The "responsive" class is added to the topnav with JavaScript when the user clicks on the icon. This class makes the topnav look good on small screens (display the links vertically instead of horizontally) */
        @media screen and (max-width: 600px) {
            .topnav.responsive {position: relative;}
            .topnav.responsive a.icon {
            position: absolute;
            right: 0;
            top: 0;
            }
            .topnav.responsive a {
            float: none;
            display: block;
            text-align: left;
            }
        }
 
        </style>
    </head>
    <body>
        <div class="topnav" id="myTopnav">
            <a href="adminHome.php" class="active">Home</a>
            <a href="manageUsers.php">Manage Users</a>
            <a href="manageStock.php">Manage Stock</a>
            <a href="findStock.php">Find Stock</a>
            <a href="#about">Hardware</a>
            <a href="#software">Software</a>
            <a href="javascript:void(0);" class="icon" onclick="myFunction()">
              <i class="fa fa-bars"></i>
            </a>
          </div>
          <div>
            <p><h1>Welcome back,<?php echo $_SESSION['adminName']?> !</h1></p>
          </div>
          <div class="text-area">
              <p >
                  <a href="manageUsers.php"><h2>Manage Users <i class="fas fa-users"></i></h2></a>
                  <p>
                      Allows you to manage the Users and their details. Lets you add and delete users and also change user details.
                  </p>
              </p>
              <p>
                <a href="manageStock.php"><h2>Manage Stock <i class="fas fa-layer-group"></i></h2></a>
                <p>
                    Manage the stock across laboratories. Keep track of the hardware and software available in each laboratory.
                </p>
            </p>
            <p>
                <a href="findStock.php"><h2>Find Stock <i class="fas fa-search-location"></i></h2></a>
                <p>
                    Find the location of a particular hardware using the hardware's unique id.
                </p>
            </p>
            <p>
                <a href="hardware.html"><h2>Hardware <i class="fas fa-laptop"></i></h2></a>
                <p>
                    Get a list of all the hardware components available in the campus.
                </p>
            </p>
            <p>
                <a href="software.html"><h2>Software <i class="fas fa-file-code"></i></h2></a>
                <p>
                    Get a list of all the softwares installed and used in the campus.
                </p>
            </p>
          </div>
    </body>
</html>