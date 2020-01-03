<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>View Stock</title>
  <style>
     @import url('https://fonts.googleapis.com/css?family=Montserrat:400,800');
            body {
                font-family: 'Montserrat', sans-serif;
                margin: 0;
            }
            span {
                padding-left: 20px;
            }
            /* Add a black background color to the top navigation */
            .topnav {
                background-color:#f5f6f7;
                overflow: hidden;
            }
            .topnav a {
            float: left;
            display: block;
            color: #3d3d3d;
            text-align: center;
            padding: 14px 16px;
            text-decoration: none;
            font-size: 20px;
            font-family: 'Montserrat', 'sans-serif';

            }
            .topnav a:hover {
            background-color: #ddd;
            color: #7da3a1;
            }

            .topnav a.active {
            background-color: #7da3a1;
            color: white;
            }
            .addupdate,.viewstock {
                padding-left: 20px;
            }
        /* Hide the link that should open and close the topnav on small screens */
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
            .
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
        table, td, th {  
            border: 1px solid #ddd;
            text-align: left;
            }

            table {
            border-collapse: collapse;
            width: 90%;
            margin : 0px auto;
            }

            th, td {
            padding: 15px;
            text-align: left;
            }
            tr:hover {background-color: #3d3d3d;}
            tr:nth-child(even) {background-color: #ffffff;}
            th {
            background-color: #7da3a1;
            color: white;
            }
            select {
                border-radius: 10px;
                padding: 12px 15px;
            }
            input {
                background-color: #eee;
                border: none;
                padding: 12px 15px;
                padding-left: 20px;
                margin: 4px 0;
                width: 15%;
                border-radius: 15px;
            }
            #hw,#place,#viewStock{
                border-radius: 20px;
    border: 1px solid #7da3a1;
    background-color: #7da3a1;
    color: #ffffff;
    font-size: 12px;
    font-weight: bold;
    padding: 12px 45px;
    letter-spacing: 1px;
    text-transform: uppercase;
    transition: transform 80ms ease-in;
    font-family: 'Montserrat', sans-serif;
            }
  </style>
</head>
<body>
<div class="topnav" id="myTopnav">
            <a href="adminHome.php" class="active">Home</a>
            <a href="manageUsers.php">Manage Users</a>
            <a href="manageStock.php">Manage Stock</a>
            <a href="findStock.php">Find Stock</a>
            <a href="javascript:void(0);" class="icon" onclick="myFunction()">
              <i class="fa fa-bars"></i>
            </a>
        </div><br>
        <form action='<?php echo $_SERVER['PHP_SELF']; ?>' method='post' name='form_filter' >
        <div class="viewstock">
                <br>
                <button  name="viewStock" id="viewStock">View Entire Stock</button><br><br>
                <select name="value" >
                <option value="">Lab..</option>
                <option value="alanKay">Alan Kay</option>
                <option value="jimGray">Jim Gray</option>
                <option value="efCodd">E.F.Codd</option>
            </select>
            <button id="place" name="valuebyplace">Filter</button>
            <select name="valuebyhardware" >
                <option value="">Hardware..</option>
                <option value="desktop">Desktops</option>
                <option value="laptop">Laptops</option>
                <option value="printers">Printers</option>
            </select>
            <button id="hw" name="valuebyhw">Filter</button><br><br>
        </div>  
<div class="usersList" style="overflow-x:auto;">
            <table >
                <tr>
                    <th>Serial No</th>
                    <th>Vendor</th>
                    <th>Date of Purchase</th>
                    <th>Value</th>
                    <th>Warranty</th>
                    <th>Place of Deployment</th>
                    <th>Remarks</th>
                    <th>Asset Register</th>
                    <th>Hardware type</th>
                    <th>Device Name</th>
                    <th>Processor</th>
                    <th>RAM</th>
                    <th>MAC Address</th>
                </tr>
        </form>                
<?php
// connect to database
require_once('dbConnect.php');
$con = dbConnect();
// define how many results you want per page
if(isset($_POST['viewStock'])) {
$resultsPerPage = 15;
// find out the number of results stored in database
$stmtr=$con->prepare('SELECT * FROM stockdetails');
$stmtr->execute();
$stmtr=$stmtr->get_result();
$numberOfResults = $stmtr->num_rows;
// determine number of total pages available
$numberOfPages = ceil($numberOfResults/$resultsPerPage);
// determine which page number visitor is currently on
if (!isset($_GET['page'])) {
  $page = 1;
} else {
  $page = $_GET['page'];
}
// determine the sql LIMIT starting number for the results on the displaying page
$thisPageFirstResult = ($page-1)*$resultsPerPage;
// retrieve selected results from database and display them on page
$stmts=$con->prepare('SELECT * FROM stockdetails LIMIT ' . $thisPageFirstResult . ',' .  $resultsPerPage);
$stmts->execute();
$stmts=$stmts->get_result();
if ($stmts->num_rows > 0) {
    while ($row = mysqli_fetch_assoc($stmts)) {
        echo "<tr><td>".$row['serialNo']."</td><td>".$row['vendor']."</td><td>".$row['dateOfPurchase']."</td><td>".$row['valueInRupees']."</td><td>".$row['warranty']."</td><td>".$row['placeOfDeployment']."</td><td>".$row['remarks']."</td><td>".$row['assetRegisterEntry']."</td><td>".$row['typeofStock']."</td><td>".$row['deviceName']."</td><td>".$row['processor']."</td><td>".$row['installedRam']."</td><td>".$row['macAddress']."</td><tr>";
    }
    echo "</table>";
}
    else {
        echo "<tr><td>".'-'."</td><td>".'-'."</td><td>".'-'."</td><td>".'-'."</td><td>".'-'."</td><td>".'-'."</td><td>".'-'."</td><td>".'-'."</td><td>".'-'."</td><td>".'-'."</td><td>".'-'."</td><td>".'-'."</td><td>".'-'."</td><tr>";
        echo "<script type='text/javascript'>\n";
        echo "alert('0 stocks to display');\n";
        echo "</script>";
        echo "</table>";
    }

// display the links to the pages
for ($page=1;$page<=$numberOfPages;$page++) {
  echo '<a href="viewStock.php?page=' . $page . '">' . $page . '</a> ';
}
}elseif (isset($_POST['valuebyplace']) or isset($_POST['valuebyhw'])) {
    $con = dbConnect();
        $query = "";
        if($_POST['value'] == 'alanKay') {
        // query to get all Fitzgerald records
        $query = "SELECT * FROM stockdetails WHERE placeOfDeployment='Alan Kay'";
        }
        elseif($_POST['value'] == 'jimGray') {
            // query to get all Herring records
            $query = "SELECT * FROM stockdetails WHERE placeOfDeployment='Jim Gray'";
        } elseif($_POST['value'] == 'efCodd') {
            // query to get all records
            $query = "SELECT * FROM stockdetails WHERE placeOfDeployment='E.F.Codd'";
        } elseif ($_POST['valuebyhardware']=='desktop') {
            $query = "SELECT * FROM stockdetails WHERE typeofStock = 'Desktop'";
        } elseif ($_POST['valuebyhardware']=='laptop') {
            $query = "SELECT * FROM stockdetails WHERE typeofStock = 'Laptop'";
        } elseif ($_POST['valuebyhardware'] == 'printers') {
            $query = "SELECT * FROM stockdetails WHERE typeofStock = 'Printer'";
        } 
        error_reporting(E_ERROR | E_PARSE); //suppress the error
        if($sql = mysqli_query($con,$query)){
        if(mysqli_num_rows($sql) > 0){
        while ($row = mysqli_fetch_array($sql)){
            echo "<tr><td>".$row['serialNo']."</td><td>".$row['vendor']."</td><td>".$row['dateOfPurchase']."</td><td>".$row['valueInRupees']."</td><td>".$row['warranty']."</td><td>".$row['placeOfDeployment']."</td><td>".$row['remarks']."</td><td>".$row['assetRegisterEntry']."</td><td>".$row['typeofStock']."</td><td>".$row['deviceName']."</td><td>".$row['processor']."</td><td>".$row['installedRam']."</td><td>".$row['macAddress']."</td><tr>";
        }
        echo "</table>";
        }
        else{
            echo "<tr><td>".'-'."</td><td>".'-'."</td><td>".'-'."</td><td>".'-'."</td><td>".'-'."</td><td>".'-'."</td><td>".'-'."</td><td>".'-'."</td><td>".'-'."</td><td>".'-'."</td><td>".'-'."</td><td>".'-'."</td><td>".'-'."</td><tr>";
            echo "<script type='text/javascript'>\n";
            echo "alert('0 stocks matching the filter');\n";
            echo "</script>";
            echo "</table>";
        }
        }
        else {
            echo "<script type='text/javascript'>\n";
            echo "alert('choose a filter to apply');\n";
            echo "</script>";
            echo "<tr><td>".'-'."</td><td>".'-'."</td><td>".'-'."</td><td>".'-'."</td><td>".'-'."</td><td>".'-'."</td><td>".'-'."</td><td>".'-'."</td><td>".'-'."</td><td>".'-'."</td><td>".'-'."</td><td>".'-'."</td><td>".'-'."</td><tr>";
            echo "</table>";
        }
    
}
else {
    echo "<tr><td>".'-'."</td><td>".'-'."</td><td>".'-'."</td><td>".'-'."</td><td>".'-'."</td><td>".'-'."</td><td>".'-'."</td><td>".'-'."</td><td>".'-'."</td><td>".'-'."</td><td>".'-'."</td><td>".'-'."</td><td>".'-'."</td><tr>";
}
?>
</body>
</html>