<!DOCTYPE HTML>
<!--
	Projection by TEMPLATED
	templated.co @templatedco
	Released for free under the Creative Commons Attribution 3.0 license (templated.co/license)
-->
<?php
session_start(); // Starting Session
$error=''; // Variable To Store Error Message
if (isset($_POST['submit'])) {
if (empty($_POST['username']) || empty($_POST['password'])) {
$error = "Username or Password is invalid";
}
else
{
// Define $username and $password
$username=$_POST['username'];
$password=$_POST['password'];
// Establishing Connection with Server by passing server_name, user_id and password as a parameter
$connection = @mysqli_connect("127.0.0.1", "root", "");
// To protect MySQL injection for Security purpose
$username = stripslashes($username);
$password = stripslashes($password);
$username = mysqli_real_escape_string($connection,$username);
$password = mysqli_real_escape_string($connection,$password);
// Selecting Database
$db = mysqli_select_db($connection, "db_saham");
// SQL query to fetch information of registerd users and finds user match.
$query = mysqli_query($connection, "select * from admin where password='$password' AND username='$username'");
$rows = mysqli_num_rows($query);
if ($rows == 1) {
$_SESSION['username']=$username; // Initializing Session
header("location: admin_page.php"); // Redirecting To Other Page
} else {
$error = "Username or Password is invalid";
}
mysqli_close($connection); // Closing Connection
}
}
?>
<html>
	<head>
		<title>Admin Login</title>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1" />
		<link rel="stylesheet" href="css/main2.css" />
	</head>
	<body class="subpage">

		<!-- Header -->
			<header id="header">
				<div class="inner">
					<a href="index.html" class="logo"><strong>Invest</strong> Yuk</a>
					<nav id="nav">
						<a href="index.html">Home</a>
						<a href="user.php">Login</a>
					</nav>
					<a href="#navPanel" class="navPanelToggle"><span class="fa fa-bars"></span></a>
				</div>
			</header>

		<!-- Three -->
			<section id="three" class="wrapper">
				<div class="inner">
					<header class="align-center">
						<h2>Selamat Datang</h2>
						<form method="post" action="#">			
				<table border=0 align="center" cellpadding=5 cellspacing=0>
<tr>
<td colspan=3><center><font size=5>ADMIN</font></center></td>
</tr>
<tr>
<td>Username</td>
<td>:</td>
<td><input type="text" name="username" id="name" required="required"  placeholder="username"/></td>
</tr>
<tr>
<td>Password</td>
<td>:</td>
<td><input type="password" name="password" id="pass" required="required"  placeholder="Keep it secret"></td>
</tr>
<tr>
<td colspan=3><input type="submit" name="submit" value="LOGIN"></td>
</tr>
</table>
</form>

</header>
					
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

	</body>
</html>