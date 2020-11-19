<?php

include 'koneksi.php';

try {
    $conn2 = new PDO('mysql:host='.$host.';dbname='.$database, $username, $password);
    // set the PDO error mode to exception
    $conn2->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // sql to delete a record
    $sql = "TRUNCATE TABLE export_test";

    // use exec() because no results are returned
    $conn2->exec($sql);
    }
catch(PDOException $e)
    {
    echo $sql . "<br>" . $e->getMessage();
    }
	 $conn1 = new PDO('mysql:host='.$host.';dbname='.$database, $username, $password);
     // set the PDO error mode to exception
     $conn1->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
     $sqlquery = $conn1->prepare("INSERT INTO export_test (Close, midBand, uBand, lBand, Macdline, ma20, ma50, momentum, rsi) 
		SELECT csv_test.Close,
		bband.midBand,
		bband.uBand,
		bband.lBand,
		macd.macdline,
		ma.ma20,
		ma.ma50,
		momentum.momentum,
		rsi.rsi
		FROM csv_test
		INNER JOIN bband ON bband.date = csv_test.date
		INNER JOIN macd ON macd.date = csv_test.date
		INNER JOIN ma ON ma.date = csv_test.date
		INNER JOIN momentum ON momentum.date = csv_test.date
		INNER JOIN rsi ON rsi.date = csv_test.date
		ORDER BY csv_test.date");
	 $sqlquery->execute();

//header("Location: insertnorm.php");
header("Location: strategi2.php");
exit;

?>

