<?php
include 'php/upload.php';
//Verify if the user is logged in
session_start();

if (!isset($_SESSION["verified"]) || $_SESSION['verified'] !== true) {
    header("location:index.php");
    die();
}
//Session Variable to store the page language
if (!isset($_SESSION['lang'])) {
    $_SESSION['lang'] = "en";
} elseif (isset($_GET['lang']) && $_SESSION['lang'] != $_GET['lang']  && !empty($_GET['lang'])) {
    if ($_GET['lang'] == "en") $_SESSION['lang'] = "en";
    else if ($_GET['lang'] == "fr") {
        $_SESSION['lang'] = "fr";
    }
}
//Session Variable to store the page language
if (!isset($_SESSION["token"]) || $_SESSION['token'] !== '') {
    $_SESSION['token'] = bin2hex(openssl_random_pseudo_bytes(32));
}
$token = $_SESSION['token'];


require_once "languages/" . $_SESSION['lang'] . ".php";

?>
<!DOCTYPE html>
<html lang="en">

</html>

<head>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="main.js"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="style.css" media="screen" />

</head>

<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light " style="background-color: #14baf1;">
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNavAltMarkup">

            <span class="navbar-text" style="padding-right: 20px;">
                <?php
                if (isset($_SESSION['verified'])) {

                    echo $lang['welcome'] . " " . $_SESSION['name'] . ' ';
                }

                ?>
            </span>
            <div class="navbar-nav">
                <a class="nav-item nav-link" data-toggle="modal" data-target="#LoginModal" href="#" onclick="logout()"><?php echo $lang['logout'] ?></a>
                <a class="nav-item nav-link" data-toggle="modal" data-target="#uploadModal" href="#"><?php echo $lang['add'] ?></a>

            </div>
        </div>
    </nav>
    <!-- upload Modal -->
    <div id="uploadModal" class="modal fade" role="dialog">
        <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <h3><?php echo $lang['uploadTitle'] ?></h3>
                </div>
                <div class="modal-body">
                    <form action="" method="post" enctype="multipart/form-data">
                        <?php echo $lang['uploadText'] ?>
                        <input class="form-control" type="file" name="myfile"><br>
                        <?php
                        if (isset($_SESSION['verified'])) {

                            echo '<input type="hidden" id="ownerId" name="ownerId" value="' . $_SESSION['id'] . '">';
                        }

                        ?>
                        <input type="hidden" id=token name="token" value="<?php echo $token; ?>">
                        <button class="btn btn-primary" type="submit" name="upload"><?php echo $lang['upload'] ?></button>
                    </form>
                </div>
            </div>

        </div>
    </div>

    <div class="container">
        <!-- Table for list of documents -->
        <div class="content">
            <h1><?php echo $lang['tbltitle'] ?></h1>
        </div>
        <table class="table table-striped">
            <thead class="thead-dark">
                <tr>
                    <th scope="col">ID</th>
                    <th scope="col"><?php echo $lang['filename'] ?></th>
                    <th scope="col"><?php echo $lang['size'] ?></th>
                    <th scope="col"><?php echo $lang['action'] ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($files as $file) : ?>
                    <tr>
                        <td><?php echo $file['ID']; ?></td>
                        <td><?php echo $file['Filename']; ?></td>
                        <td><?php echo $file['size'] / 1000 . 'KB'; ?></td>
                        <td>
                            <form action="" method="post" enctype="multipart/form-data">
                                <input type="hidden" id=token name="token" value="<?php echo $token; ?>">
                                <input type="hidden" id="owner" name="owner" value="<?php echo $file['owner']; ?>">
                                <button name="download" type="submit" value="<?php echo $file['ID']; ?>"><?php echo $lang['download'] ?></button>
                                <?php if ($file['owner'] == $_SESSION['id']) {
                                    echo "<button name=\"delete\" type=\"submit\" value=\" " . $file['ID'] . " \">" . $lang['delete'] . "</button>";
                                } ?>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>

            </tbody>
        </table>
    </div>
    <!-- Multilang && Footer -->
    <div class="footer ">
        <a href="doclist.php?lang=en" style="color: white;"><?php echo $lang['l_en'] ?></a>
        | <a href="doclist.php?lang=fr" style="color: white;"><?php echo $lang['l_fr'] ?></a>
    </div>
</body>

</html>