<!DOCTYPE HTML>
<!--
	Projection by TEMPLATED
	templated.co @templatedco
	Released for free under the Creative Commons Attribution 3.0 license (templated.co/license)
-->
<?php
//system('notepad.exe c:\Weka-3-8\LMT.txt');
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

		<!-- Three -->
			<section id="three" class="wrapper">
				<div class="inner">
					<header class="align-center">
						<h2>Saham</h2>
					</header>
					<body>
						<center>
						<img src="images/btn_logo.png" width="300" height="200" alt="BNI" class="center"></img><br></br>
						<button onclick="location.href = 'export_test.php';" id="myButton" class="float-left submit-button" >Unduh Data Daily</button>
						<button onclick="location.href = 'sinyal_agg.php';" id="myButton" class="float-left submit-button">Next Page</button><br></br>
						<button onclick="location.href = 'test_transaksi_agg.php';" id="myButton" class="float-left submit-button">Lihat Hasil Data Test</button>
						</center>
						<br></br>
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



/*if(isset($_POST['submit'])){
    $submit = $_POST['submit'];
    switch ($submit) {
        case 'BBAND':
            header("location: bband_data.php?saham=".urlencode($_GET['db_saham']));
            break;
        case 'MOMENTUM':
            header("location: momentum.php?saham=".urlencode($_GET['db_saham']));
            break;
			
        default:
            # code...
            break;
    }
}
*/


/*if(isset($_POST['submit'])){
	$var = $_POST['myform']
	if($var == "MA"){
		//header("location: bband_data.php?saham=".urlencode($_GET['db_saham']));
		header("location: export ma.php")
	}
	else {
     echo "task option is required";
)
*/
//if(isset($_POST['submit'])){
	
//}

?>