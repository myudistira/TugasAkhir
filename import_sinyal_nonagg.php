<!DOCTYPE HTML>
<!--
	Projection by TEMPLATED
	templated.co @templatedco
	Released for free under the Creative Commons Attribution 3.0 license (templated.co/license)
-->
<?php
 include "koneksi.php";
//include "session.php";

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
					<a class="logo"><strong>Invest Yuk</strong></a>
					<nav id="nav">
						<a style="font-weight: bold;">Selamat Datang</a>
						<!--a>?php echo $user_access; ?> user</a-->
						<a style="font-weight: bold;" href="logout.php">Logout</a>
					</nav>
					<a href="#navPanel" class="navPanelToggle"><span class="fa fa-bars"></span></a>
				</div>
			</header>
<?php require 'header.php' ?>
		<!-- Three -->
			<section id="three" class="wrapper">
				<div class="inner">
					<header class="align-center">
						<h2>Saham</h2>
					</header>
					<body>
						<center>
						<img src="images/btn_logo.png" width="300" height="200" alt="BNI" class="center"></img><br></br>
							<label class="col-md-4 control-label">Input Predicted Signal</label> 
							<form method="post" enctype='multipart/form-data'>
							<input type="file" name="product_file" /></p>
							<br />
							<input type="submit" name="upload" class="btn btn-info" value="Upload" />
							</form>
							<br />
		<br />

    </div>
    <div id="labelError"></div>
</form>
					</body>
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

		<!-- Footer -->
			<!--footer id="footer">
				<div class="inner">

					<h3>Get in touch</h3>

					<form action="#" method="post">

						<div class="field half first">
							<label for="name">Name</label>
							<input name="name" id="name" type="text" placeholder="Name">
						</div>
						<div class="field half">
							<label for="email">Email</label>
							<input name="email" id="email" type="email" placeholder="Email">
						</div>
						<div class="field">
							<label for="message">Message</label>
							<textarea name="message" id="message" rows="6" placeholder="Message"></textarea>
						</div>
						<ul class="actions">
							<li><input value="Send Message" class="button alt" type="submit"></li>
						</ul>
					</form>

					<div class="copyright">
						&copy; Untitled. Design: <a href="https://templated.co">TEMPLATED</a>. Images: <a href="https://unsplash.com">Unsplash</a>.
					</div>

				</div>
			</footer-->

		<!-- Scripts -->
			<script src="assets/js/jquery.min.js"></script>
			<script src="assets/js/skel.min.js"></script>
			<script src="assets/js/util.js"></script>
			<script src="assets/js/main.js"></script>

	</body>
</html>


<?php

$connect = mysqli_connect("127.0.0.1", "root", "", "db_saham");

if(isset($_POST["upload"]))
{
 if($_FILES['product_file']['name'])
 {
  $filename = explode(".", $_FILES['product_file']['name']);
  if(end($filename) == "csv")
  {
   $handle = fopen($_FILES['product_file']['tmp_name'], "r");
   while($data = fgetcsv($handle))
   {
	$id = mysqli_real_escape_string($connect, $data[0]);   
	$sinyal = mysqli_real_escape_string($connect, $data[1]);   
    
    $query = "
     UPDATE test_sinyal_agg_low 
     SET sinyal = '$sinyal'
	 WHERE id_sinyal = '$id'
    ";
    mysqli_query($connect, $query);
   }
   fclose($handle);
   header("location: import_sinyal_nonaggnorm.php");
  }
  else
  {
   $message = '<label class="text-danger">Please Select CSV File only</label>';
  }
 }
 else
 {
  $message = '<label class="text-danger">Please Select File</label>';
 }
}