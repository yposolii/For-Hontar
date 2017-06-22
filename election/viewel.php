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

if(isset($_GET['more'])){
  $query = "SELECT pic_url, name, description, id_cand, id_el, votes  FROM cands WHERE id_el = '".$_GET['more']."'";
  $res = mysqli_query($conn, $query);
}else{
header('Location:main.php');
}
$candidates = array();
    while($rows = mysqli_fetch_array($res)) {

       // Записать значение столбца FirstName (который является теперь массивом $row)
      
        array_push($candidates, $rows);

      } 
    $query1 = "SELECT email, name, student_id, id_voter, id_elect FROM voters WHERE id_elect = '".$_GET['more']."'";
  $res1 = mysqli_query($conn, $query1);
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
        <a class="nav-link" href="#">Elections<span class="sr-only">(current)</span></a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="#">New Election</a>
      </li>
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="http://example.com" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          Administrator
        </a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
          <a class="dropdown-item" href="#">Manage Administrators</a>
          <a class="dropdown-item" href="#">New Administrator</a>
        </div>
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
        <a class="nav-link" href="#">Elections<span class="sr-only">(current)</span></a>
      </li>
      <li class="nav-item ">
        <a class="nav-link" href="#">Archive</a>
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
    <p class="card-text">Votes:<?=$one['votes']?></p>
  </div>
</div>
<?php }?>
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
      <td><?=$one['name']?></td>
      <td><?=$one['email']?></td>
      <td><?=$one['student_id']?></td>
    </tr>
    <?php }?>
  </tbody>
</table>
<a href="index.php" class="btn btn-primary btn-lg active" role="button" aria-pressed="true">Finish</a>
</body>
</html>