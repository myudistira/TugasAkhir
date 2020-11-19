<!DOCTYPE HTML>
<!--
	Projection by TEMPLATED
	templated.co @templatedco
	Released for free under the Creative Commons Attribution 3.0 license (templated.co/license)
-->

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
					<a href="index.html" class="logo"><strong>Invest Yuk</strong></a>
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
<form action="" method="post">
<table border=0 align="center" cellpadding=5 cellspacing=0>
<tr>
	<td>Email</td><td>:</td> <td><input type="email" name="email" id="mail" required="required" placeholder="ex: mahesta123@gmail.com"/></td>
</tr>
<tr>
	<td>Username</td> <td>:</td><td><input type="text" name="username" id="name" required="required"  placeholder="username"/></td>
</tr>
<tr>
	<td>password</td><td>:</td><td><input type="password" name="password" id="pass" required="required"  placeholder="Keep it secret"/></td>
</tr>
<tr>
	<td colspan=3><input type="submit" value=" Submit " name="submit"/>
</table>
</form>
</div>
<!-- Right side div -->


</div>
<?php
if(isset($_POST["submit"])){
$hostname='127.0.0.1';
$username='root';
$password='';

try {
    $dbh = new PDO("mysql:host=$hostname;dbname=db_saham",$username,$password);

    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); // <== add this line
	
 
$sql = "INSERT INTO user (email, username, password)
VALUES ('".$_POST["email"]."','".$_POST["username"]."','".md5($_POST["password"])."')";

//for ($i=0; $i++) {
if ($dbh->query($sql)) {
     echo "<script type= 'text/javascript'>alert('pendaftaran berhasil');</script>";
     echo "<meta http-equiv='refresh' content='1 url=user.php'>";
} 
else{
     echo "<script type= 'text/javascript'>alert('Data not successfully Inserted.');</script>";
}

    $dbh = null;
    }
catch(PDOException $e)
    {
    echo $e->getMessage();
    }
}
//}
?>
</body>
</html>
