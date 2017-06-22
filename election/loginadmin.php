<?php
session_start();
$error = ' ';

if(isset($_POST["submit"])){//works only after submiting form

 define('DBHOST', 'localhost');
 define('DBUSER', 'root');
 define('DBPASS', '');
 define('DBNAME', 'election');
 //bd connection
$conn = new mysqli(DBHOST,DBUSER,DBPASS,DBNAME);

if ( !$conn ) {
  die("Connection failed : " . mysqli_error());
}

$email = $_POST['email'];
$pass = $_POST['password'];

$password = hash('sha256', $pass); 
// password hashing using SHA256 
//safety first)
//query
$res=mysqli_query($conn,"SELECT * FROM admins WHERE email='$email'");
$row=mysqli_fetch_array($res);
$count = mysqli_num_rows($res); // if uname/pass correct it returns must be 1 row

if( $count != 0 && $row['password']==$password ) {
    //$_SESSION['isadmin'] = 1; 
    $_SESSION['islog'] = $row['id_admin'];
    header("Location:2ndsteplogin.php");
    //header("Location:adminpanel.php");
    $_SESSION['error'] = "Done";
   } else {
    header("Location:loginadmin.php");
    $_SESSION['error'] = "Incorrect Credentials, Try again...";
   }
 }

if(isset($_SESSION['error'])){
$error = $_SESSION['error'] ;
}else{
	$error = ' ';
}
?>
<!DOCTYPE html>
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
        <form id="login-form" action="loginadmin.php" method="post" role="form" style="display: block;">
            <div class="form-group">
                <input type="text" name="email" id="email" tabindex="1" class="form-control" placeholder="EMAIL" value="">
            </div>
            <div class="form-group">
                <input type="password" name="password" id="password" tabindex="2" class="form-control" placeholder="PASSWORD">
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