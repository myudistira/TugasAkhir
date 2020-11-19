<!DOCTYPE HTML>
<!--
	Projection by TEMPLATED
	templated.co @templatedco
	Released for free under the Creative Commons Attribution 3.0 license (templated.co/license)
-->
<?php
require_once 'session.php';
//system('java -cp \Weka-3-8\weka.jar:\libsvm-3.23\java\libsvm.jar weka.classifiers.functions.LibSVM -T c:\Weka-3-8\data\TestBBNI.arff -l c:\Weka-3-8\model\libsvm.model -p 0 > c:\Weka-3-8\LibSVM.txt');
//system('java -cp c:\Weka-3-8\weka.jar weka.classifiers.trees.LMT -T c:\Weka-3-8\data\TestBBNI.arff -l c:\Weka-3-8\model\lmt.model -p 0 > c:\Weka-3-8\LMT.txt');

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
						<a style="font-weight: bold;">Selamat Datang, <?php echo $_SESSION['username']?> </a>
						
						<a style="font-weight: bold;" href="logout.php">Logout</a>
					</nav>
					<a href="#navPanel" class="navPanelToggle"><span class="fa fa-bars"></span></a>
				</div>
			</header>