<?php
session_start();
$error = ' ';

if(isset($_POST["code"])){//works only after submiting form
$code=$_POST['code'];
$idadmin = $_SESSION['islog'];

 define('DBHOST', 'localhost');
define('DBUSER', 'root');
define('DBPASS', '');
define('DBNAME', 'election');
 //bd connection
$conn = new mysqli(DBHOST,DBUSER,DBPASS,DBNAME);

if ( !$conn ) {
  die("Connection failed : " . mysqli_error());
}
$res=mysqli_query($conn,"SELECT google_auth FROM admins WHERE id_admin ='$idadmin'");
$row=mysqli_fetch_array($res);
$gcode = $row['google_auth'];
require_once 'googleLib/GoogleAuthenticator.php';
$ga = new GoogleAuthenticator();
$checkResult = $ga->verifyCode($gcode, $code, 2);

if ($checkResult) 
{
//$_SESSION['user'] = $user;
$_SESSION['isadmin'] = '1';
header("Location:adminpanel.php");
}
}
if($_SESSION['islog']){ ?>
<html lang="en">
<head>
    <!-- Basic Page Needs
    ================================================== -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>NaUKMA Eelection</title>
    <meta name="description" content="Sistem Pencalonan MPP ILP Ledang">
    <meta name="keywords" content="">
    <meta name="author" content="">
    <!-- Bootstrap -->
    <link rel="stylesheet" type="text/css"  href="css/bootstrap.css">
    <!-- CSS -->
    <link rel="stylesheet" type="text/css"  href="css/index.css">
</head>
<body>
	<div class = "head1">
	<div id="header " class="text-center " style="font-family: 'Raleway', Arial, sans-serif; color:white;">
        <h1 style="font-size: 40px;font-weight: 800;text-transform: uppercase;">
		Vote KMA</h1>
        <h3 style="font-size: 28px;font-weight: 600;">
		Admin login form</h3>
    </div>
</div>
<div class="container task row col-md-4 offset-md-5 panel panel-login panel-body" style = "margin-top:50px;">
        <form id="login-form" action="2ndsteplogin.php" method="post" role="form" style="display: block;">
            <div class="form-group">
                <h3> Google auth code </h3>
            </div>
            <div class="form-group">
                <input type="int" name="code" id="code" tabindex="2" class="form-control" placeholder="GOOGLEAUTHCODE">
            </div>
            <div class="form-group">
            <div class="col-sm-6 offset-sm-3">
                <input type="submit" name="submit" id="submit" tabindex="4" class="form-control btn-login" value="Log In">
            </div>
                <p class = "errormas text-center" style = "color:#6699ff;"><br><br><?php echo $error?></p>
            </div>
        </form>
    </div>
</body>
</html>
<?php }else{
header('Location:index.php'); }?>