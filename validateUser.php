<?php
session_start();

require_once('dbConnect.php');

if (!isset($_POST['userId'], $_POST['userPassword']) ) {
	die ('Please fill both the username and password field!');
}

$con = dbConnect();
if ($stmt = $con->prepare('SELECT userId, userPassword FROM userdetails WHERE userId = ?')) {
	$stmt->bind_param('s', $_POST['userId']);
	$stmt->execute();
	$stmt->store_result();
}
$stmt->store_result();
if ($stmt->num_rows > 0) {
	$stmt->bind_result($id, $password);
	$stmt->fetch();
	if ($_POST['userPassword'] === $password) {		
		session_regenerate_id();
		$_SESSION['loggedin'] = TRUE;
		$_SESSION['name'] = $_POST['userId'];
		$_SESSION['id'] = $id;
        //header('Location: index.php');
        echo 'correct pwd';
	} else {
		echo 'Incorrect password!';
	}
} else {
	echo 'Incorrect username!';
}
$stmt->close();

?>