<?php
session_start();

require_once('dbConnect.php');

if (!isset($_POST['adminId'], $_POST['adminPassword']) ) {
	die ('Please fill both the username and password field!');
}

$con = dbConnect();
if ($stmt = $con->prepare('SELECT adminId, adminName,adminPassword FROM admindetails WHERE adminId = ?')) {
	$stmt->bind_param('s', $_POST['adminId']);
	$stmt->execute();
	$stmt->store_result();
}
if ($stmt->num_rows > 0) {
	$stmt->bind_result($id,$name,$password);
	$stmt->fetch();
	if ($_POST['adminPassword'] === $password) {		
		session_regenerate_id();
		$_SESSION['loggedin'] = TRUE;
		$_SESSION['adminID'] = $_POST['adminId'];
		$_SESSION['id'] = $id;
		$_SESSION['adminName'] = $name;
        header('Location: adminHome.php');
	} else {
		echo 'Incorrect password!';
	}
} else {
	echo 'Incorrect username!';
}
$stmt->close();
$con->close();
?>