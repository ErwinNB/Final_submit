<?php
session_start();

if (!isset($_SESSION['lang'])) {
    $_SESSION['lang'] = "en";
} elseif (isset($_GET['lang']) && $_SESSION['lang'] != $_GET['lang']  && !empty($_GET['lang'])) {
    if ($_GET['lang'] == "en") $_SESSION['lang'] = "en";
    else if ($_GET['lang'] == "fr") {
        $_SESSION['lang'] = "fr";
    } 
}
if (!isset($_SESSION["token"]) || $_SESSION['token'] !== '') {
    $_SESSION['token'] = bin2hex(openssl_random_pseudo_bytes(32));
}
$token = $_SESSION['token'];
 require_once "languages/".$_SESSION['lang'].".php";
?>
<!DOCTYPE html>
<html lang="en">

</html>

<head>
    <meta charset="UTF-8">
    <title><?php echo $lang['title']?></title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="main.js"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="style.css" media="screen" />

</head>

<body>


    <nav class="navbar navbar-expand-lg navbar-light " style="background-color: #14baf1;">
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
            <div class="navbar-nav">
                <a class="nav-item nav-link" data-toggle="modal" data-target="#LoginModal" href="#"><?php echo $lang['login']?></a>
                <a class="nav-item nav-link" data-toggle="modal" data-target="#RegisterModal" href="#"><?php echo $lang['register']?></a>
            </div>
        </div>
    </nav>
    <!-- Login Modal -->
    <div id="LoginModal" class="modal fade" role="dialog">
        <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <h3><?php echo $lang['title']?></h3>
                </div>
                <div class="modal-body">
                    <form name="logInForm" data-form="form-2" method="post">
                        <div class="form-group">
                            <label><?php echo $lang['email']?></label>
                            <input type="email" class="form-control" id="email" name="email" placeholder="<?php echo $lang['enterEmail']?>">
                        </div>
                        <div class="form-group">
                            <label ><?php echo $lang['password']?></label>
                            <input type="password" class="form-control" id="pass" name="pass" placeholder="<?php echo $lang['password']?>">
                        </div>
                        <input type="hidden" id=token  name="token" value="<?php echo $token; ?>" >
                        <button type="submit" class="btn btn-primary" onclick="login()"><?php echo $lang['login']?></button>
                    </form>
                </div>
            </div>

        </div>
    </div>
    <!-- Register Modal -->
    <div id="RegisterModal" class="modal fade" role="dialog">
        <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <h3><?php echo $lang['register']?></h3>
                </div>
                <div class="modal-body">
                    <form name="SignInForm" data-form="form-1" method="POST" >
                        <div class="form-group">
                            <label><?php echo $lang['name']?></label>
                            <input type="text" class="form-control" id="name" name="name" placeholder="<?php echo $lang['enterName']?>">
                        </div>
                        <div class="form-group">
                            <label><?php echo $lang['email']?></label>
                            <input type="email" class="form-control" id="emailreg" name="emailreg" placeholder="<?php echo $lang['enterEmail']?>">
                        </div>
                        <div class="form-group">
                            <label><?php echo $lang['password']?></label>
                            <input type="password" class="form-control" id="passreg" name="passreg" placeholder="<?php echo $lang['password']?>">
                        </div>
                        <div class="form-group">
                            <label><?php echo $lang['confpass']?></label>
                            <input type="password" class="form-control" id="confpassreg" name="confpassreg" placeholder="<?php echo $lang['password']?>" onkeyup="checkPass()">
                        </div>
                        <input type="hidden" id=token  name="token" value="<?php echo $token; ?>" >
                        <button type="submit" class="btn btn-primary" onclick="register()"><?php echo $lang['register']?></button>
                    </form>
                </div>
            </div>

        </div>
    </div>
    <div class="container">
        <div class="content">
            <h1><?php echo $lang['description1']?></h1>
            <h1><?php echo $lang['description2']?></h1><br>
            <h3><?php echo $lang['description3']?></h3><br>
            <h3><?php echo $lang['description4']?></h3>
            <h3><?php echo $lang['description5']?></h3>
        </div>
    </div>
    <!-- Multilang && Footer -->
    <div class="footer ">
        <a href="index.php?lang=en" style="color: white;"><?php echo $lang['l_en']?></a>
        | <a href="index.php?lang=fr"style="color: white;"><?php echo $lang['l_fr']?></a>
    </div>
</body>

</html>