<?php

$servername = "localhost";
$username = "lemanan_root";
$password = "n*Ln&5hWJl6T";
$dbname = "lemanan_techchall";

/* Attempt to connect to MySQL database */
// Create connection
$C = new mysqli($servername, $username, $password, $dbname);
session_start();

//Get list of docs from the DB
$sql = "SELECT * FROM files";
$result = mysqli_query($C, $sql);
$files = mysqli_fetch_all($result, MYSQLI_ASSOC);

//Post request sent through the upload form
if (isset($_POST['upload']) && hash_equals($_SESSION['token'], $_POST['token'])) { //make sure it commes from the signed in user

    $filename = mysqli_real_escape_string($C, $_FILES['myfile']['name']); //get the Filename
    $owner = mysqli_real_escape_string($C, $_POST["ownerId"]); //get the owner id
    $size = mysqli_real_escape_string($C, $_FILES['myfile']['size']); //get the size of the file
    $destination = 'uploads/' . $filename; //create the destination string of the file


    $extension = pathinfo($filename, PATHINFO_EXTENSION); //get the file extension for verification
    $file = $_FILES['myfile']['tmp_name']; //get the path of the tmp file created in the server



    if (!in_array($extension, ['pdf', 'docx', 'png', 'xlsx', 'txt'])) { //verify that the extension is supported
        echo "<script type='text/javascript'>alert('Your file extension must be TXT,PDF,DOCX,PNG or XLSX');</script>";
    } else {
        if (!file_exists($destination)) { //verify if a file with the same name exists to avoid overwriting a file 
            if (move_uploaded_file($file, $destination)) { //save the file to the upload repository of the server
                $sql = "INSERT INTO files(filename,size,owner) VALUES('$filename','$size','$owner')"; //insert in the DB the file info
                if (mysqli_query($C, $sql)) {
                    header("Location: doclist.php"); //refresh page to reload the list
                } else {
                    echo "<script type='text/javascript'>alert('Failed to execute');</script>"; //if the DB failed to execut the query
                }
            }
        } else {
            echo "<script type='text/javascript'>alert('Change your filename!!! a file with the same name already exists');</script>"; //a file with the same name exists
        }
    }
}

//Post request sent to the download the file from the server
if (isset($_POST['download']) && hash_equals($_SESSION['token'], $_POST['token'])) { //make sure it commes from the signed in user

    $id = $_POST['download']; //get the id of the file
    $sql = "SELECT * FROM `files` WHERE ID=$id"; //query to get file info from DB
    $result = mysqli_query($C, $sql);
    $file = mysqli_fetch_assoc($result);
    $filepath = 'uploads/' . $file['Filename'];


    if (file_exists($filepath) === true) { //verify that the file exists in the server
        //create a request to dowload the file
        // echo $filepath;
        header('Content-Description: File Transfer');
        header('Content-Disposition: attachement;filename="' . basename($filepath . '"'));
        header('Content-Type: application/octet-stream');
        header('Expires: 0');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        header('Content-length: ' . filesize($filepath));
        ob_clean();
        flush();
        readfile($filepath);

        exit;
    }
}
//Post request sent to the delet the file from the server
if (isset($_POST['delete']) && hash_equals($_SESSION['token'], $_POST['token']) && $_SESSION['id'] == $_POST['owner']) { //make sure it commes from the signed in user and also verify if he is the owner of the file to delete that file
    $id = mysqli_real_escape_string($C, $_POST['delete']);
    $sql = "SELECT * FROM `files` WHERE ID=$id";
    $result = mysqli_query($C, $sql);
    $file = mysqli_fetch_assoc($result);
    $filepath = 'uploads/' . $file['Filename'];
    //delete DB record for file
    $sql = "DELETE FROM `files` WHERE ID=$id";
    $result = mysqli_query($C, $sql);
    $file = mysqli_fetch_assoc($result);

    if (file_exists($filepath)) { //delete the file from the repository in the server
        unlink($filepath);
        header("Location: doclist.php");
        exit;
    }
}
