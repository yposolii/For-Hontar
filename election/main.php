<?php
session_start();
unset($_SESSION['errorel']);
define('DBHOST', 'localhost');
 define('DBUSER', 'root');
 define('DBPASS', '');
 define('DBNAME', 'election');
 //bd connection
$conn = new mysqli(DBHOST,DBUSER,DBPASS,DBNAME);

if ( !$conn ) {
  die("Connection failed : " . mysqli_error());
}
$emailvoter = $_SESSION['emailvoter'];
$res=mysqli_query($conn,"SELECT * FROM els WHERE id_elect IN (SELECT id_elect FROM voters WHERE email = '$emailvoter' ) AND status < 1");

$els = array();
    while($rows = mysqli_fetch_array($res)) {

       // Записать значение столбца FirstName (который является теперь массивом $row)
      
        array_push($els, $rows);

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
  <?php }elseif (isset($_SESSION['isvoter'])) {?>
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
<div class="card-group">
<?php foreach ($els as $one){ ?>
<div class="card" style="width: 32px;">
  <img class="card-img-top" src="<?=$one['pic_url']?>" alt="Card image cap" style = "width:300px; height:260px;">
  <div class="card-block">
    <h4 class="card-title"><?=$one['name']?></h4>
    <p class="card-text">Organisation:<?=$one['organisation']?></p>
  </div>
  <ul class="list-group list-group-flush">
    <li class="list-group-item">Description:<?=$one['description']?></li>
  </ul>
  <ul class="list-group list-group-flush">
    <li class="list-group-item">End date:<?=$one['finishdate']?></li>
  </ul>
  <div class="card-block">
  	<?php 
  	$id_elec = $one['id_elect'];
  	$emailvoter = $_SESSION['emailvoter'];
  	$res=mysqli_query($conn,"SELECT * FROM voters WHERE id_elect = '$id_elec' AND email = '$emailvoter'");
	$vote = array();
    while($rows = mysqli_fetch_array($res)) {

       // Записать значение столбца FirstName (который является теперь массивом $row)
      
        array_push($vote, $rows);

      }
    foreach ($vote as $one1){
    	$ifvote = $one1['status'];
    }
    if($ifvote == 0){
     ?>
    <a href="vote.php?vote=<?=$one['id_elect']?>" class="card-link">Vote</a>
 	<?php } ?> 
  </div>
</div>
<?php }?>
</div>
</body>
</html>