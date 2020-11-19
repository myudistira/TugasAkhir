<?php

include 'koneksi.php';

try {
    $conn2 = new PDO('mysql:host='.$host.';dbname='.$database, $username, $password);
    // set the PDO error mode to exception
    $conn2->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // sql to delete a record
    $sql = "TRUNCATE TABLE test_sinyal_agg";

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
     $sqlquery = $conn1->prepare("INSERT INTO test_sinyal_agg (id_csv, Date)
		SELECT id_csv, date 
		FROM csv_test
		WHERE id_csv > 14");
	 $sqlquery->execute();

//header("Location: insertnorm.php");
header("Location: sinyal_nonagg.php");
exit;

?>

