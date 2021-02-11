<?php

$servername = "localhost";
$username = "lemanan_root";
$password = "n*Ln&5hWJl6T";
$dbname = "lemanan_techchall";
//echo '<script>console.log("Inside config.php")</script>';
/* Attempt to connect to MySQL database */
// Create connection
$C = new mysqli($servername, $username, $password, $dbname);
session_start();

if (hash_equals($_SESSION['token'], $_POST['token'])) { // verify that the post commes from a user

    //SQL query to search DB if the user exists
    $stmt = $C->prepare("SELECT * FROM users WHERE email=? AND password=PASSWORD(?) LIMIT 1");
    $stmt->bind_param("ss", $_POST['email'], $_POST['pass']);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($id, $name, $email, $password);
    if ($stmt->num_rows === 1) { //if user exists
        $_SESSION['verified'] = true; //set Session variable verified true to redirect
        while ($stmt->fetch()) {
            $_SESSION['name'] = $name; //store the name to display on the new page
            $_SESSION['id'] = $id; // //store the ID to save with uploaded file
        }
        echo "true"; //send response as true is user exists
    } else {
        echo "false"; //send response as false if user doesnt exists
    }

    $stmt->close();
    $C->close();
}
