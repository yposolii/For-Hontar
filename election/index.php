<?php
session_start();

if(isset($_SESSION['errorel'])){
$error = $_SESSION['errorel'] ;
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
		Vote system for student organisations</h3>
    </div>
</div>
<div class = "col-lg-4 offset-lg-5">
<div class="container row " style = "margin-top:50px;">
        <form id="login-form" action="login.php" method="post" role="form" style="display: block;">
            <div class="form-group">
                <input type="text" name="email" id="email" tabindex="1" class="form-control" placeholder="EMAIL" value="">
            </div>
            <div class="form-group">
                <input type="password" name="studentid" id="studentid" tabindex="2" class="form-control" placeholder="STUDENT ID">
            </div>
            <div class="form-group">
            <div class="col-sm-6 offset-sm-3">
                <input type="submit" name="submit" id="submit" tabindex="4" class="form-control btn-login" value="Log In">
            </div>
                <p class = "errormas text-center" style = "color:#6699ff;"><br><br><?php echo $error?></p>
            </div>
        </form>
    </div>
</div>
</body>
</html>