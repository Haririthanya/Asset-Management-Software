<?php
session_start();
// If the user is not logged in redirect to the login page...
if (!isset($_SESSION['loggedin'])) {
	header('Location: index.html');
	exit();
}
require_once('dbConnect.php');
if (!isset($_POST['userId'], $_POST['userPassword'],$_POST['userName'],$_POST['userLabInCharge']) ) {
	die ('Please fill in all the details');
}

$con = dbConnect();
$userid = $con->real_escape_string($_REQUEST['userId']);
$username = $con->real_escape_string($_REQUEST['userName']);
$userpassword = $con->real_escape_string($_REQUEST['userPassword']);
$userlabincharge = $con->real_escape_string($_REQUEST['userLabInCharge']);
if ($stmt = $con->prepare('INSERT INTO userdetails (userId,userName,userPassword,userLabInCharge,userAddedBy) VALUES (?, ?, ?, ?, ?)')) {
	$stmt->bind_param("sssss", $userid, $username, $userpassword,$userlabincharge,$_SESSION['adminID']);
	$stmt->execute();
	die ('Successfully added');
	$stmt->close();
}
if(! empty($con->error)) {
	echo $con->error;
}
$con->close();
?>