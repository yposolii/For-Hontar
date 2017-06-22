<?php
 session_start();


 if(isset($_SESSION['errorm'])){
  $error = $_SESSION['errorm'];
 }else{
 $error = '';}

 define('DBHOST', 'localhost');
 define('DBUSER', 'root');
 define('DBPASS', '');
 define('DBNAME', 'election');
 
$conn = new mysqli(DBHOST,DBUSER,DBPASS,DBNAME);


 if ( !$conn ) {
  die("Connection failed : " . mysql_error());
 }
 
 if ( !$conn ) {
  die("Database Connection failed : " . mysql_error());
 }
if(isset($_POST['nameadm'])){
$pass = $_POST['passadm'];
$cpass = $_POST['cpassadm'];
$name = $_POST['nameadm'];
$email = $_POST['emailadm'];
if($pass != $cpass){
  $_SESSION['errorm'] = 'Wrong password confirmation';
  header("Location: registeradmin.php");
}
require_once 'googleLib/GoogleAuthenticator.php';
$ga = new GoogleAuthenticator();
$secret = $ga->createSecret();

// password encrypt using SHA256();
  $password = hash('sha256', $pass);

$query = "INSERT INTO admins (name, email, password, google_auth) VALUES ('$name', '$email', '$password', '$secret')";
$res = mysqli_query($conn, $query);
if($res){
  $_SESSION['errorm'] = 'Done';
   header("Location: registeradmin.php");
}
else{
  echo $secret;
  echo $name;
  echo $email;
  echo $password;
}
}
?>
<html>
<head>
    <!-- Basic Page Needs
    ================================================== -->
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>NaUKMA Eelection</title>
    <meta name="description" content="Sistem Pencalonan MPP ILP Ledang">
    <meta name="keywords" content="">
    <meta name="author" content="">
    <!-- Bootstrap -->
    <link rel="stylesheet" type="text/css"  href="css/bootstrap.css">
    <!-- CSS -->
    <link rel="stylesheet" type="text/css"  href="css/index.css">
    <script src="js/jquery.js"></script>
    <script src="js/tether.js"></script>
    <script src="js/bootstrap.js"></script>
</head>
<body>
  <nav class="navbar navbar-toggleable-md navbar-light bg-faded" style = "background-color: #e3f2fd;    ">
  <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <?php if(isset($_SESSION['isadmin'])){ ?>
  <a class="navbar-brand" href="#">Admin Panel</a>
  <div class="collapse navbar-collapse" id="navbarSupportedContent">
    <ul class="navbar-nav mr-auto">
      <li class="nav-item active">
        <a class="nav-link" href="adminpanel.php">Elections<span class="sr-only">(current)</span></a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="newelection.php">New Election</a>
      </li>
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          Administrator
        </a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
          <a class="dropdown-item" href="adminsview.php">Manage Administrators</a>
          <a class="dropdown-item" href="registeradmin.php">New Administrator</a>
        </div>
      </li>
      <li class="nav-item ">
        <a class="nav-link" href="archive.php">Archive</a>
      </li>
    </ul>
    <form class="form-inline my-2 my-lg-0">
      <a href="logout.php" class="btn btn-secondary my-2 my-sm-0" role="button" >Logout</a>
    </form>
  </div>
  <?php }elseif (isset($_SESSION['isvoter'])) {
    header('Location:main.php');?>
    <a class="navbar-brand" href="#">Vote KMA</a>
  <div class="collapse navbar-collapse" id="navbarSupportedContent">
    <ul class="navbar-nav mr-auto">
      <li class="nav-item active">
        <a class="nav-link" href="main.php">Elections<span class="sr-only">(current)</span></a>
      </li>
      <li class="nav-item ">
        <a class="nav-link" href="archive.php">Archive</a>
      </li>
    </ul>
    <form class="form-inline my-2 my-lg-0">
      <a href="logout.php" class="btn btn-secondary my-2 my-sm-0" role="button" >Logout</a>
    </form>
  </div>
  <?php }else{header('Location:index.php');} ?>
</nav>
<div class="task col-lg-6 offset-lg-3 " style = "margin-top:50px;">
<form action="registeradmin.php" method="post" enctype="multipart/form-data" >
  <div class="form-group">
    <label for="nameadm">Name</label>
    <input type="name" class="form-control" name = "nameadm" id="nameadm" placeholder="Name">
  </div>
  <div class="form-group">
    <label for="emailadm">Email</label>
    <input type="email" class="form-control" name = "emailadm" id="emailadm" placeholder="Email">
  </div>
  <div class="form-group">
    <label for="passadm">Password</label>
    <input type="password" class="form-control" name = "passadm" id="passadm" placeholder="Password">
  </div>
  <div class="form-group">
    <label for="cpassadm">Confirm Password</label>
    <input type="password" class="form-control" name = "cpassadm" id="cpassadm" placeholder="Password">
  </div>
  <button type="submit" name = "submit" class="btn btn-primary" style="background-color:#e6eeff; color:black; border-color:#80aaff;">Submit</button>
  <p class = "errormas text-center" style = "color:#ff9999;"><br><br><?php echo $error?></p>

</form>
</div>
</body>
</html>