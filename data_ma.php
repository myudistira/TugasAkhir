<?php
set_time_limit(300);
include 'koneksi.php';

//truncate csv table
try {
  $conn = new PDO('mysql:host='.$host.';dbname='.$database, $username, $password);
  // set the PDO error mode to exception
  $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

  // sql to delete a record
  $sql = "TRUNCATE TABLE ma";

  // use exec() because no results are returned
  $conn->exec($sql);
}
catch(PDOException $e)
{
  echo $sql . "<br>" . $e->getMessage();
}

$sql = $pdo->prepare("SELECT id_csv, date, close FROM csv_training
WHERE date != 0
AND close != 0 
ORDER BY date");
$sql->execute();

/*$sql = $pdo->prepare("SELECT id_csv, date, close FROM csv_test
WHERE date !=0
AND close != 0
ORDER BY date");
$sql->execute();*/

/*$sql = $pdo->prepare("SELECT id_csv, date, close FROM csv
WHERE date BETWEEN NOW() - INTERVAL 420 DAY AND NOW()
AND close != 0
ORDER BY date");
$sql->execute();*/

// prepare query insert
$conn = new PDO('mysql:host='.$host.';dbname='.$database, $username, $password);

// set the PDO error mode to exception
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$sql3 = $conn->prepare("INSERT INTO ma (id_csv,date,ma20,ma50) VALUES (:id_csv,:date,:ma20,:ma50)");

$ma20 = '';
$ma50 = '';


for ($i=0; $i < 14; $i++) {
  $data = $sql->fetch();
  $id = $data['id_csv'];
  $date = $data['date'];
  $close[] = $data['close'];
}

while ($data = $sql->fetch()) {
  array_shift($close); //keluarkan data lama
  $id = $data['id_csv'];
  $date = $data['date'];
  $close[20] = $data['close'];
  $ma20 = array_sum($close)/count($close);
  $close2[50] = $data['close'];
  $ma50 = array_sum($close2)/count($close2);
  
/*  while ($data = $sql->fetch()) {
  array_shift($close); //keluarkan data lama
  $close[14] = $data['Close'];
  $rerata = array_sum($close)/count($close);
  }
*/  

    //bind data
  $sql3->bindParam(':id_csv', $id);
  $sql3->bindParam(':date', $date);
  $sql3->bindParam(':ma20', $ma20);
  $sql3->bindParam(':ma50', $ma50);
  $sql3->execute();
}
header("location: data_momentum.php?saham=".urlencode($_GET['db_saham']));
?>