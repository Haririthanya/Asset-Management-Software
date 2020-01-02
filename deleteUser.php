<?php
session_start();

if (!isset($_SESSION['loggedin'])) {
	header('Location: index.html');
	exit();
}
require_once('dbConnect.php');
if (!isset($_POST['userId']) ) {
	die ('Please fill in all the details');
}

$con = dbConnect();
$userid = $con->real_escape_string($_REQUEST['userId']);

if ($stmt = $con->prepare('DELETE FROM userdetails WHERE userId = ?')) {
	$stmt->bind_param("s", $userid);
    $stmt->execute();
    echo 'Successfully deleted';
	$stmt->close();
}
if(! empty($con->error)) {
	echo $con->error;
}
$con->close();
?>