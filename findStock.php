<?php 
    session_start();

    if (!isset($_SESSION['loggedin'])) {
        header('Location: index.html');
        exit();
    }
    require_once('dbConnect.php');
    $con = dbConnect();
    $stmts = new stdClass();
    $stmtm = new stdClass();
    if(isset($_POST['searchs'])){
        $serialNo = $_POST['serialNo'];
        if ($stmts = $con->prepare('SELECT serialNo,vendor,dateOfPurchase,valueInRupees,warranty,placeOfDeployment,remarks,assetRegisterEntry,processor,installedRam,macAddress FROM stockdetails WHERE serialNo = ?')) {
            $stmts->bind_param('s', $serialNo);
            $stmts->execute();
            $stmts=$stmts->get_result();
        }
    }
    else {
        $stmts->num_rows = 0;
    }
    if(isset($_POST['searchm'])){
        $macAddress = $_POST['macAddress'];
        if ($stmtm = $con->prepare('SELECT serialNo,vendor,dateOfPurchase,valueInRupees,warranty,placeOfDeployment,remarks,assetRegisterEntry,processor,installedRam,macAddress FROM stockdetails WHERE macAddress = ?')) {
            $stmtm->bind_param('s', $macAddress);
            $stmtm->execute();
            $stmtm=$stmtm->get_result();
        }
    }
    else {
        $stmtm->num_rows = 0;
    }
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Manage Users</title>
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
                padding-left: 10px;
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
            #searchm,#searchs{
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
            <a href="manageStock.php">Manage Stock</a>
            <a href="#about">Hardware</a>
            <a href="#software">Software</a>
            <a href="javascript:void(0);" class="icon" onclick="myFunction()">
              <i class="fa fa-bars"></i>
            </a>
        </div><br><br>
        <form action="findStock.php" method="POST">
            <span>Find Stock by Serial No:</span>
            <input name="serialNo" type="text" placeholder="Serial NUmber" required />
            <input type="submit" id="searchs" name="searchs" value="Search"><br><br>
            <table>
                <tr>
                    <th>Serial No</th>
                    <th>Vendor</th>
                    <th>Date of Purchase</th>
                    <th>Value</th>
                    <th>Warranty</th>
                    <th>Place of Deployment</th>
                    <th>Remarks</th>
                    <th>Asset Register</th>
                    <th>Processor</th>
                    <th>RAM</th>
                    <th>MAC Address</th>
                </tr>
                <?php if($stmts->num_rows >0):?>
                <?php while($rows = mysqli_fetch_assoc($stmts)):?>
                    <tr>
                        <td><?php echo $rows['serialNo'];?></td>
                        <td><?php echo $rows['vendor'];?></td>
                        <td><?php echo $rows['dateOfPurchase'];?></td>
                        <td><?php echo $rows['valueInRupees'];?></td>
                        <td><?php echo $rows['warranty'];?></td>
                        <td><?php echo $rows['placeOfDeployment'];?></td>
                        <td><?php echo $rows['remarks'];?></td>
                        <td><?php echo $rows['assetRegisterEntry'];?></td>
                        <td><?php echo $rows['processor'];?></td>
                        <td><?php echo $rows['installedRam'];?></td>
                        <td><?php echo $rows['macAddress'];?></td>
                    </tr>
                <?php endwhile;?> 
                <?php else :?>
                    <tr>
                        <td>-</td>
                        <td>-</td>
                        <td>-</td>
                        <td>-</td>
                        <td>-</td>
                        <td>-</td>
                        <td>-</td>
                        <td>-</td>
                        <td>-</td>
                        <td>-</td>
                        <td>-</td>
                    </tr>
                <?php endif?>
            </table>
        </form>
        <br><br>
        <form action="findStock.php" method="POST">
            <span>Find Stock by MAC Address:</span>
            <input name="macAddress" type="text" placeholder="MAC Address" required />
            <input type="submit" id="searchm" name="searchm" value="Search"><br><br>
            <table>
                <tr>
                    <th>Serial No</th>
                    <th>Vendor</th>
                    <th>Date of Purchase</th>
                    <th>Value</th>
                    <th>Warranty</th>
                    <th>Place of Deployment</th>
                    <th>Remarks</th>
                    <th>Asset Register</th>
                    <th>Processor</th>
                    <th>RAM</th>
                    <th>MAC Address</th>
                </tr>
                <?php if($stmtm->num_rows >0):?>
                <?php while($rowm = mysqli_fetch_assoc($stmtm)):?>
                    <tr>
                        <td><?php echo $rowm['serialNo'];?></td>
                        <td><?php echo $rowm['vendor'];?></td>
                        <td><?php echo $rowm['dateOfPurchase'];?></td>
                        <td><?php echo $rowm['valueInRupees'];?></td>
                        <td><?php echo $rowm['warranty'];?></td>
                        <td><?php echo $rowm['placeOfDeployment'];?></td>
                        <td><?php echo $rowm['remarks'];?></td>
                        <td><?php echo $rowm['assetRegisterEntry'];?></td>
                        <td><?php echo $rowm['processor'];?></td>
                        <td><?php echo $rowm['installedRam'];?></td>
                        <td><?php echo $rowm['macAddress'];?></td>
                    </tr>
                <?php endwhile;?> 
                <?php else :?>
                    <tr>
                        <td>-</td>
                        <td>-</td>
                        <td>-</td>
                        <td>-</td>
                        <td>-</td>
                        <td>-</td>
                        <td>-</td>
                        <td>-</td>
                        <td>-</td>
                        <td>-</td>
                        <td>-</td>
                    </tr>
                <?php endif?>
            </table>
        </form>
    </body>
</html>