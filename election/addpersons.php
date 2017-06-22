<?php

session_start();

define('DBHOST', 'localhost');
define('DBUSER', 'root');
define('DBPASS', '');
define('DBNAME', 'election');
 //bd connection
$conn = new mysqli(DBHOST,DBUSER,DBPASS,DBNAME);
mysqli_set_charset($conn,"utf8_unicode_ci");
$error = ' Problem with connection to db';

if(isset($_GET['del'])){
  mysqli_query($conn, "DELETE FROM cands WHERE id_cand ='".$_GET['del']."'");
  $edit = $_GET['edit'];
  header('Location:addpersons.php?edit='.$edit.'');
  die();

}

if(isset($_GET['delv'])){
  mysqli_query($conn, "DELETE FROM voters WHERE id_voter ='".$_GET['delv']."'");
  $edit = $_GET['edit'];
  header('Location:addpersons.php?edit='.$edit.'');
  die();

}

if (isset($_POST['description'])) {

$_SESSION['name'] = $_POST['name'];

$_SESSION['organisation'] = $_POST['organisation'];

$_SESSION['enddate'] = $_POST['enddate'];

$_SESSION['description'] = $_POST['description'];

$_SESSION['pic'] = $_FILES["fileToUpload"];

$target_dir = "uploads/";
$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);

$_SESSION['target_file'] = $target_file;//for posting directory of file to db

$uploadOk = 1;



$imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
// Check if image file is a actual image or fake image
$check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
    if($check !== false) {
        $uploadOk = 1;
    } else {
        $error = "File is not an image.";
        $_SESSION['errorel'] = $error;
        header("Location:newelection.php");
        $uploadOk = 0;
    }

// Check file size
if ($_FILES["fileToUpload"]["size"] > 500000) {
    $error = "Sorry, your file is too large.";
    $_SESSION['errorel'] = $error;
    header("Location:newelection.php");
    $uploadOk = 0;
}
// Allow certain file formats
if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
&& $imageFileType != "gif" ) {
    $error = "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
    $_SESSION['errorel'] = $error;
    header("Location:newelection.php");
    $uploadOk = 0;
}

// Check if $uploadOk is set to 0 by an error
if ($uploadOk == 0) {

// if everything is ok, try to upload file

} else {
    if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
    $error = '1';
    }else{
    $error = "Sorry, there was an error uploading your file.";
    $_SESSION['errorel'] = $error;
    header("Location:newelection.php");
        }
    }  
if ( !$conn ) {//db connection checking
  die("Connection failed : " . mysqli_error());
}
//query
$name = $_SESSION['name'];
$organisation = $_SESSION['organisation'];
$description = $_SESSION['description'];
$tf = $_SESSION['target_file'];
$enddate = $_SESSION['enddate'];
$query = "INSERT INTO els (name, organisation, description, pic_url, status, finishdate) VALUES ('$name', '$organisation', '$description', '$tf', 0, '$enddate')";
$res = mysqli_query($conn, $query);

if ($res) {
    unset($_SESSION['organisation']);
    unset($_SESSION['description']);
    unset($_SESSION['target_file']);
    unset($_SESSION['enddate']);
}else{
    $error = "Sorry, there was an error uploading your file.";
    $_SESSION['errorel'] = $error;
    header("Location:newelection.php");
 }      
}
if(isset($_GET['edit'])){
  $query = "SELECT pic_url, name, description, id_cand, id_el  FROM cands WHERE id_el = '".$_GET['edit']."'";
  $res = mysqli_query($conn, $query);
}else{
$name = $_SESSION['name'];
$query = "SELECT  pic_url, name, description, id_cand, id_el FROM cands WHERE id_el IN (SELECT id_elect FROM els WHERE name = '$name')";
$res = mysqli_query($conn, $query);
}
$candidates = array();
    while($rows = mysqli_fetch_array($res)) {

       // Записать значение столбца FirstName (который является теперь массивом $row)
      
        array_push($candidates, $rows);

      }
if(isset($_GET['edit'])){  
    $query1 = "SELECT email, name, student_id, id_voter, id_elect FROM voters WHERE id_elect = '".$_GET['edit']."'";
  $res1 = mysqli_query($conn, $query1);
}else{
$query1 = "SELECT email, name, student_id, id_voter, id_elect FROM voters WHERE id_elect IN (SELECT id_elect FROM els WHERE name = '$name')";
$res1 = mysqli_query($conn, $query1);
}
$voters = array();
    while($rows1 = mysqli_fetch_array($res1)) {

       // Записать значение столбца FirstName (который является теперь массивом $row)
      
        array_push($voters, $rows1);

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
<h1 class = "col-lg-2 offset-lg-5"> Candidates </h1>
<?php foreach ($candidates as $one){ ?>
<div class="card" style="width: 20rem;">
  <img class="card-img-top" src="<?=$one['pic_url']?>" alt="Card image cap" style = "width:300px; height:260px;">
  <div class="card-block">
    <h4 class="card-title"><?=$one['name']?></h4>
    <p class="card-text">Description:<?=$one['description']?></p>
  </div>
  <div class="card-block">
    <a href="addpersons.php?edit=<?=$one['id_el']?>&del=<?=$one['id_cand']?>" class="card-link">Delete</a>
  </div>
</div>
<?php }?>
<a href="addcandidate.php" class="card-link">Add new candidate</a>

<table class="table">
  <thead>
    <tr>
      <th>Delete</th>
      <th>Email</th>
      <th>Name</th>
      <th>Student ID</th>
    </tr>
  </thead>
  <tbody>
    <?php foreach ($voters as $one){ ?>
    <tr>
      <th scope="row"><a href = "addpersons.php?edit=<?=$one['id_elect']?>&delv=<?=$one['id_voter']?>">Delete</a></th>
      <td><?=$one['name']?></td>
      <td><?=$one['email']?></td>
      <td><?=$one['student_id']?></td>
    </tr>
    <?php }?>
    <a href="addvoter.php" class="card-link">Add voter</a>
  </tbody>
</table>
<a href="adminpanel.php" class="btn btn-primary btn-lg active" role="button" aria-pressed="true">Finish</a>
</body>
</html>