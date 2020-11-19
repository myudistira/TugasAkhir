<?php
set_time_limit(300);
include 'koneksi.php';

//truncate csv table
try {
    $conn = new PDO('mysql:host='.$host.';dbname='.$database, $username, $password);
    // set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // sql to delete a record
    $sql = "TRUNCATE TABLE momentum";

    // use exec() because no results are returned
    $conn->exec($sql);
    }
catch(PDOException $e)
    {
    echo $sql . "<br>" . $e->getMessage();
    }
  // Function to calculate standard deviation (uses sd_square)
function sd($array) {
    // square root of sum of squares devided by N-1
    return sqrt(array_sum(array_map("sd_square", $array, array_fill(0,count($array), (array_sum($array) / count($array)) ) ) ) / (count($array)) );
}


$sqlCount = $pdo->prepare("SELECT id_csv, date, close FROM csv_training
WHERE date !=0
AND close != 0
ORDER BY date");
$sqlCount->execute();
$dataCount = $sqlCount->fetchColumn();

$arrayData = array();
$sql = $pdo->prepare("SELECT id_csv, date, close FROM csv_training
WHERE date !=0
AND close != 0 
ORDER BY date");
$sql->execute();


/*$sqlCount = $pdo->prepare("SELECT id_csv, date, close FROM csv_test
WHERE date !=0
AND close != 0
ORDER BY date");
$sqlCount->execute();
$dataCount = $sqlCount->fetchColumn();

$arrayData = array();
$sql = $pdo->prepare("SELECT id_csv, date, close FROM csv_test
WHERE date !=0
AND close != 0 
ORDER BY date");
$sql->execute();*/



/*$sqlCount = $pdo->prepare("SELECT id_csv, date, close FROM csv
WHERE date BETWEEN NOW() - INTERVAL 420 DAY AND NOW()
AND close != 0
ORDER BY date");
$sqlCount->execute();
$dataCount = $sqlCount->fetchColumn();

$arrayData = array();
$sql = $pdo->prepare("SELECT id_csv, date, close FROM csv
WHERE date BETWEEN NOW() - INTERVAL 420 DAY AND NOW()
AND close != 0 
ORDER BY date");
$sql->execute();*/


for ($i = 0; $i < 261; $i++) { //Nilai i untuk data training=398, test=261, (atau sesuaikan jumlah data kalian) daily=$dataCount
  $data = $sql->fetch();
  $id = $data['id_csv'];
  array_push($arrayData, $data);
}

// prepare query insert
$conn = new PDO('mysql:host='.$host.';dbname='.$database, $username, $password);

// set the PDO error mode to exception
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$sql2 = $conn->prepare("INSERT INTO momentum (id_csv,date,close1,close10,momentum) VALUES (:id_csv,:date,:close1,:close10,:momentum)");

//$momentum= 0;
for ($i=14; $i < 261; $i++) { //Nilai i untuk data training=398, test=261, (atau sesuikan jumlah data kalian) daily=$dataCount
  $data = $arrayData[$i];
  $id = $data['id_csv'];
  $date = $data['date'];
  $close10 = $data['close'];

  $data1 = $arrayData[$i-14];
  $id = $data['id_csv'];
  $close1 = $data1['close'];
  $momentum = ($close10/$close1)*100; 

  //bind data
  $sql2->bindParam(':id_csv', $id);
  $sql2->bindParam(':date', $date);
  $sql2->bindParam(':close1', $close1);
  $sql2->bindParam(':close10', $close10);
  $sql2->bindParam(':momentum', $momentum);
  $sql2->execute();
}
/*for ($i=14; $i< $dataCount ; $i++) {
  $data = $sql->fetch();
  $date = $data['date'];
  $close14 = array($data['Close']);

  $close1 = $close14[$i-14];
  $momentum = ($close14[$i]/$close1)*100; 

  //bind data
  $sql2->bindParam(':date', $date);
  $sql2->bindParam(':close1', $close1);
  $sql2->bindParam(':close14', $close14);
  $sql2->bindParam(':momentum', $momentum);
  $sql2->execute();
}*/
header("location: data_rsi.php?saham=".urlencode($_GET['db_saham']));
?>
