<!DOCTYPE HTML>
<!--
	Projection by TEMPLATED
	templated.co @templatedco
	Released for free under the Creative Commons Attribution 3.0 license (templated.co/license)
-->


<?php
/* Establishing Connection with Server by passing server_name, user_id and password as a parameter
$connection = @mysql_connect("127.0.0.1", "root", "");
// Selecting Database
$db = mysql_select_db("db_saham", $connection);
session_start();// Starting Session
// Storing Session
$user_check=$_SESSION['username'];
// SQL Query To Fetch Complete Information Of User
$ses_sql=mysql_query("select username from admin where username='$user_check'", $connection);
$row = mysql_fetch_assoc($ses_sql);
$login_session =$row['username'];
if(!isset($login_session)){
mysql_close($connection); // Closing Connection
header('Location: admin_login.php'); // Redirecting To Home Page
}*/
?>
<html>
	<head>
		<title>Invest Yuk</title>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1" />
		<link rel="stylesheet" href="css/main2.css" />
	</head>
	<body class="subpage">

		<!-- Header -->
			<header id="header">
				<div class="inner">
					<a href="index.html" class="logo"><strong>Invest Yuk</a>
					<nav id="nav">
						<a href="logout.php">Logout</a>
					</nav>
					<a href="#navPanel" class="navPanelToggle"><span class="fa fa-bars"></span></a>
				</div>
			</header>

		<!-- Three -->
			<section id="three" class="wrapper">
				<div class="col-md-6 col-sm-6 col-xs-12">
      <h3><center>User</center></h3>
      <form action="save.php" method="post">
    <table class="table table-hover vertical-align">
      <th>ID</th>
      <th>Username</th>
      <th>Email</th>
      <?php
      include "koneksi.php";
      $conn4 = new PDO('mysql:host='.$host.';dbname='.$database, $username, $password);
      $conn4->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      $sqlv = $conn4->prepare("SELECT * from user");
      $sqlv->execute();
      while( $row = $sqlv->fetch(PDO::FETCH_ASSOC) ) {
      ?>
      <tr>
          <td> <?php echo $row['id_user']; ?></td>
          <td><input type="text" name="username[<?php echo $row['id_user']; ?>]" id="name" value="<?php echo $row['username']; ?>" > </td>
          <td><input type="email" name="email[<?php echo $row['id_user']; ?>]" id="mail" value="<?php echo $row['email']; ?>"> </td>    
															<?php } ?>
		   </tr>
		    </table>
       
		</form>  
    </div>

		<header id="home" class="sections">
            <div class="container">
              <div class="row">
                <div class="homepage-style">
            </div>
            </div>
            </div>
					
				</div>
			</section>

		<!-- Scripts -->
			<script src="assets/js/jquery.min.js"></script>
			<script src="assets/js/skel.min.js"></script>
			<script src="assets/js/util.js"></script>
			<script src="assets/js/main.js"></script>

	</body>
</html>