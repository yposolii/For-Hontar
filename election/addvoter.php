<?php

session_start();

define('DBHOST', 'localhost');
define('DBUSER', 'root');
define('DBPASS', '');
define('DBNAME', 'election');
 //bd connection
$conn = new mysqli(DBHOST,DBUSER,DBPASS,DBNAME);
mysqli_set_charset($conn,"utf8_unicode_ci");
if(isset($_SESSION['error'])){
  $error = $_SESSION['error'];
}else{
$error= "";
}
if (isset($_POST['namevoter'])) {

$_SESSION['namevoter'] = $_POST['namevoter'];

$_SESSION['id_el'] = $_POST['id_el'];

$_SESSION['studentid'] = $_POST['studentid'];

$_SESSION['email'] = $_POST['email'];


if ( !$conn ) {//db connection checking
  die("Connection failed : " . mysqli_error());
}
//query
$namevoter = $_SESSION['namevoter'];
$id_el = $_SESSION['id_el'];
$studentid = $_SESSION['studentid'];
$email = $_SESSION['email'];
$query = "INSERT INTO voters (name, id_elect, email, student_id, status) VALUES ('$namevoter', '$id_el', '$email', '$studentid', 0)";
$res = mysqli_query($conn, $query);
if ($res) {
    unset($_SESSION['namevoter']);
    unset($_SESSION['id_el']);
    unset($_SESSION['studentid']);
    unset($_SESSION['email']);
    header("Location:addpersons.php");
}else{
    $error = "Sorry, there was an error.";
    $_SESSION['error'] = $error;
    header("Location:addvoter.php");
 }      
}

$name = $_SESSION['name'];
$query1 = "SELECT id_elect FROM els WHERE name = '$name'";
$res1 = mysqli_query($conn, $query1);

$ids = array();
    while($rows = mysqli_fetch_array($res1)) {

       // Записать значение столбца FirstName (который является теперь массивом $row)
      
        array_push($ids, $rows);

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
<?php foreach ($ids as $one){ ?>
<div class="task col-lg-6 offset-lg-3 " style = "margin-top:-10px;">
<form action="addvoter.php" method="post" enctype="multipart/form-data" >
  <div class="form-group" style="visibility:hidden">
    <label for="id_el">Id_El</label>
    <input type="name" class="form-control" name = "id_el" id="id_el" value = "<?=$one['id_elect']?>">
  </div>
  <div class="form-group">
    <label for="namecand">Name</label>
    <input type="name" class="form-control" name = "namevoter" id="namevoter" placeholder="Name">
  </div>
  <div class="form-group">
    <label for="namecand">Email</label>
    <input type="name" class="form-control" name = "email" id="email" placeholder="Email">
  </div>
  <div class="form-group">
    <label for="textarea">Student_id</label>
    <input type="name" class="form-control" name = "studentid" id="studentid" placeholder="Student ID">
  </div>
  <button type="submit" name = "submit" class="btn btn-primary" style="background-color:#e6eeff; color:black; border-color:#80aaff;">Submit</button>
  <p class = "errormas text-center" style = "color:#ff9999;"><br><br><?php echo $error?></p>
  <?php }?>
</form>
</div>
</body>
</html>