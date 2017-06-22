<?php

session_start();

define('DBHOST', 'localhost');
define('DBUSER', 'root');
define('DBPASS', '');
define('DBNAME', 'election');
 //bd connection
$conn = new mysqli(DBHOST,DBUSER,DBPASS,DBNAME);
mysqli_set_charset($conn,"utf8_unicode_ci");
$error= "";

if (isset($_POST['descand'])) {

$_SESSION['namecand'] = $_POST['namecand'];

$_SESSION['id_el'] = $_POST['id_el'];

$_SESSION['descand'] = $_POST['descand'];

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
        $_SESSION['error'] = $error;
        header("Location:addcandidate.php");
        $uploadOk = 0;
    }

// Check file size
if ($_FILES["fileToUpload"]["size"] > 500000) {
    $error = "Sorry, your file is too large.";
    $_SESSION['error'] = $error;
    header("Location:addcandidate.php");
    $uploadOk = 0;
}
// Allow certain file formats
if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
&& $imageFileType != "gif" ) {
    $error = "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
    $_SESSION['error'] = $error;
    header("Location:addcandidate.php");
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
    $_SESSION['error'] = $error;
    header("Location:addcandidate.php");
        }
    }  
if ( !$conn ) {//db connection checking
  die("Connection failed : " . mysqli_error());
}
//query
$namecand = $_SESSION['namecand'];
$id_el = $_SESSION['id_el'];
$descand = $_SESSION['descand'];
$tf = $_SESSION['target_file'];
$query = "INSERT INTO cands (name, id_el, description, pic_url) VALUES ('$namecand', '$id_el', '$descand', '$tf')";
$res = mysqli_query($conn, $query);

if ($res) {
    unset($_SESSION['namecand']);
    unset($_SESSION['id_el']);
    unset($_SESSION['descand']);
    unset($_SESSION['target_file']);
    header("Location:addpersons.php");
}else{
    $error = "Sorry, there was an error uploading your file.";
    $_SESSION['error'] = $error;
    header("Location:addcandidate.php");
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
<form action="addcandidate.php" method="post" enctype="multipart/form-data" >
  <div class="form-group" style="visibility:hidden">
    <label for="id_el">ID els</label>
    <input type="name" class="form-control" name = "id_el" id="id_el" value = "<?=$one['id_elect']?>">
  </div>
  <div class="form-group">
    <label for="namecand">Name</label>
    <input type="name" class="form-control" name = "namecand" id="namecand" placeholder="Name">
  </div>
  <div class="form-group">
    <label for="textarea">Description</label>
    <textarea class="form-control" name = "descand" id="descand" rows="3"></textarea>
  </div>
  <div class="form-group">
    <label for="inputfile">Logo input</label>
    <input type="file" class="form-control-file" name="fileToUpload" id="fileToUpload" aria-describedby="fileHelp">
    <small id="fileHelp" class="form-text text-muted">The selected picture must be a JPG / GIF / PNG format.</small>
  </div>
  <button type="submit" name = "submit" class="btn btn-primary" style="background-color:#e6eeff; color:black; border-color:#80aaff;">Submit</button>
  <p class = "errormas text-center" style = "color:#ff9999;"><br><br><?php echo $error?></p>
  <?php }?>
</form>
</div>
</body>
</html>