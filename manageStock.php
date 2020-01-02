<?php 
      session_start();

      if (!isset($_SESSION['loggedin'])) {
          header('Location: index.html');
          exit();
      }
      require_once('dbConnect.php');
      $con = dbConnect();
      if(isset($_POST['add']) or isset($_POST['update'])) {
        $serialNo = $con->real_escape_string($_REQUEST['serialNo']);
        $vendor = $con->real_escape_string($_REQUEST['vendor']);
        $dateOfPurchase = $con->real_escape_string($_REQUEST['dateOfPurchase']);
        $valueInRupees = $con->real_escape_string($_REQUEST['valueInRupees']);
        $warranty = $con->real_escape_string($_REQUEST['warranty']);
        $placeOfDeployment = $con->real_escape_string($_REQUEST['placeOfDeployment']);
        $remarks = $con->real_escape_string($_REQUEST['remarks']);
        $assetRegisterEntry = $con->real_escape_string($_REQUEST['assetRegisterEntry']);
        $type = $con->real_escape_string($_REQUEST['type']);
        $deviceName = $con->real_escape_string($_REQUEST['deviceName']);
        $processor = $con->real_escape_string($_REQUEST['processor']);
        $installedRam = $con->real_escape_string($_REQUEST['installedRam']);
        $macAddress = $con->real_escape_string($_REQUEST['macAddress']);
        $newdateOfPurchase = (new DateTime($dateOfPurchase))->format('Y-m-d');
        $newwarranty = (new DateTime($warranty))->format('Y-m-d');
            if(isset($_POST['add'])) {
                $stmt = $con->prepare('INSERT INTO stockdetails (serialNo,vendor,dateOfPurchase,valueInRupees,warranty,placeOfDeployment,remarks,assetRegisterEntry,typeOfStock,deviceName,processor,installedRam,macAddress) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)');
                $stmt->bind_param("sssssssssssss",$serialNo,$vendor,$newdateOfPurchase,$valueInRupees, $newwarranty, $placeOfDeployment,$remarks,$assetRegisterEntry,$type,$deviceName,$processor,$installedRam,$macAddress);
            } 
            else {
                $stmt = $con->prepare('UPDATE stockdetails SET serialNo = ?, vendor = ?,dateOfPurchase = ?,valueInRupees = ?,warranty=?,placeOfDeployment =?,remarks=?,assetRegisterEntry=?,typeOfStock=?,deviceName=?,processor=?,installedRam=?,macAddress=? WHERE serialNo = ?');
                $stmt->bind_param("ssssssssssssss",$serialNo,$vendor,$newdateOfPurchase,$valueInRupees, $newwarranty, $placeOfDeployment,$remarks,$assetRegisterEntry,$type,$deviceName,$processor,$installedRam,$macAddress,$serialNo);
            }   
            if ($stmt) {
                $stmt->execute();
                $stmt->close();
                if(isset($_POST['add'])){
                echo "<script type='text/javascript'>\n";
                echo "alert('Successfully  Added');\n";
                echo "</script>";
                }
                else {
                    echo "<script type='text/javascript'>\n";
                    echo "alert('Successfully  Updated');\n";
                    echo "</script>";
                }
            }
            else {
                if(! empty($con->error)) {
                    echo $con->error;
                }
            }
        }
        elseif(isset($_POST['delete'])) {
            $serialNo = $con->real_escape_string($_REQUEST['serialNo']);
            if ($stmt = $con->prepare('DELETE FROM stockdetails WHERE serialNo = ?')) {
                $stmt->bind_param("s", $serialNo);
                $stmt->execute();
                $stmt->close();
                echo "<script type='text/javascript'>\n";
                echo "alert('Successfully  deleted');\n";
                echo "</script>";
            }else {
            if(! empty($con->error)) {
                echo $con->error;
            }
            }
        }
      $con->close();
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Manage Stock</title>
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
            #addStock,#updateStock,#deleteStock{
                border-radius: 20px;
                border: 1px solid #7da3a1;
                background-color: #7da3a1;
                color: #ffffff;
                font-size: 15px;
                font-weight: bold;
                padding: 12px 45px;
                letter-spacing: 1px;
                text-transform: uppercase;
                transition: transform 80ms ease-in;
                font-family: 'Montserrat', sans-serif;

            }
            #dt{text-indent: -500px;height:25px; width:200px;}

            input {
                background-color: #eee;
                border: none;
                padding: 12px 15px;
                padding-left: 20px;
                margin: 4px 0;
                width: 15%;
                border-radius: 15px;
            }
        </style>
    </head>
    <body>
        <div class="topnav" id="myTopnav">
            <a href="adminHome.php" class="active">Home</a>
            <a href="manageUsers.php">Manage Users</a>
            <a href="findStock.php">Find Stock</a>
            <a href="#about">Hardware</a>
            <a href="#software">Software</a>
            <a href="javascript:void(0);" class="icon" onclick="myFunction()">
              <i class="fa fa-bars"></i>
            </a>
        </div><br>
        <form action="viewStock.php">
        <div class="viewstock">
                <span>View Stock:</span><br>
                <button>View Stock</button>
        </form>
        <form action="manageStock.php" method="POST">
            
            </div>
            <div class="addupdate">
            <span>Add/Update Stock:</span><br>
            <input type="text" name="serialNo" placeholder="Serial Number" required>
            <input type="text" name="vendor" placeholder="Vendor" required>
            <input type="date" name="dateOfPurchase" placeholder="Date of Purchase" required pattern = "">
            <input type="number" name="valueInRupees" placeholder="Value" required>
            <input type="date" name="warranty" placeholder="Warranty" required>
            <input type="text" name="placeOfDeployment" placeholder="Place of Deployment" required>
            <input type="text" name="remarks" placeholder="Remarks" required>
            <input type="text" name="assetRegisterEntry" placeholder="Asset Register Entry" required>
            <input type="text" name="type" placeholder="Type" required>
            <input type="text" name="deviceName" placeholder="Device Number" required>
            <input type="text" name="processor" placeholder="Processor" required>
            <input type="text" name="installedRam" placeholder="RAM" required>
            <input type="text" name="macAddress" placeholder="MAC Address" required><br>
            <input type="submit" name="add" id="addStock" value="Add">
            <input type="submit" name="update" id="updateStock" value="Update"><br>
            </div>
        </form>
        <form action="manageStock.php" method="POST">   
            <span>Delete Stock:</span>
            <input type="text" name="serialNo" placeholder="Serial Number" required>
            <input type="submit" name="delete" id="deleteStock" value="Delete"><br>
        </form>
    </body>    
</html>        