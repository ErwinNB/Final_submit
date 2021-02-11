<?php
$servername = "localhost";
$username = "lemanan_root";
$password = "n*Ln&5hWJl6T";
$dbname = "lemanan_techchall";

/* Attempt to connect to MySQL database */
// Create connection
$C = new mysqli($servername, $username, $password, $dbname);
session_start();



if (hash_equals($_SESSION['token'], $_POST['token'])) { // verify that the request commes from the user logged in to prevent csrf
	$stmt = $C->prepare("SELECT Email FROM users WHERE Email=?");
	$stmt->bind_param("s", $_POST['emailreg']);
	$stmt->execute();
	$found = $stmt->fetch();
	$stmt->close();

	if ($found) {
		echo "This email already exists";
	} else {
		$stmt =  $C->prepare("INSERT INTO users(Name, Email, Password) VALUES (?,?,PASSWORD(?))");
		$stmt->bind_param("sss", $_POST['name'], $_POST['emailreg'], $_POST['confpassreg']);
		$stmt->execute();
		$stmt->close();
		echo "true";
	}
}
