<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>View Stock</title>
</head>
<body>
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
                    <th>Processor</th>
                    <th>RAM</th>
                    <th>MAC Address</th>
                </tr>
<?php
// connect to database
require_once('dbConnect.php');
$con = dbConnect();
// define how many results you want per page
$resultsPerPage = 10;
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
        echo "<tr><td>".$row['serialNo']."</td><td>".$row['vendor']."</td><td>".$row['dateOfPurchase']."</td><td>".$row['valueInRupees']."</td><td>".$row['warranty']."</td><td>".$row['placeOfDeployment']."</td><td>".$row['remarks']."</td><td>".$row['assetRegisterEntry']."</td><td>".$row['processor']."</td><td>".$row['installedRam']."</td><td>".$row['macAddress']."</td><tr>";
    }
    echo "</table>";
}
    else {
        echo "<tr><td>"."-"."</td><td>"."-"."</td><td>"."-"."</td><tr>";
        echo "</table>";
        echo "0 users added";
    }

// display the links to the pages
for ($page=1;$page<=$numberOfPages;$page++) {
  echo '<a href="viewStock.php?page=' . $page . '">' . $page . '</a> ';
}
?>
</body>
</html>