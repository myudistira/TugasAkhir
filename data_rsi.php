<?php
set_time_limit(300);
include 'koneksi.php';

//truncate csv table
try {
    $conn3 = new PDO('mysql:host='.$host.';dbname='.$database, $username, $password);
    // set the PDO error mode to exception
    $conn3->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // sql to delete a record
    $sql3 = "TRUNCATE TABLE rsi";

    // use exec() because no results are returned
    $conn3->exec($sql3);
    echo "Record deleted successfully";
    }
catch(PDOException $e)
    {
    echo $sql3 . "<br>" . $e->getMessage();
    }

//RSI-Start

$sqla = $pdo->prepare("SELECT id_csv, date, close FROM csv_training
WHERE date !=0
AND close != 0
ORDER BY date");
$sqla->execute();

/*$sqla = $pdo->prepare("SELECT id_csv, date, close FROM csv_test
WHERE date !=0
AND close != 0
ORDER BY date");
$sqla->execute();*/

/*$sqla = $pdo->prepare("SELECT id_csv, date, close FROM csv
WHERE date BETWEEN NOW() - INTERVAL 420 DAY AND NOW()
AND close != 0
ORDER BY date");
$sqla->execute();*/

$conn3 = new PDO('mysql:host='.$host.';dbname='.$database, $username, $password);
$conn3->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$sql4 = $conn3->prepare("INSERT INTO rsi (id_csv,date,changes,gain,loss,avgGain,avgLoss,rs,rsi) VALUES (:id_csv,:date,:changes,:gain,:loss,:avgGain,:avgLoss,:rs,:rsi)");

//$data = $sqla->fetch();
$close = 0.0;
$avg_gain = '';
$avg_loss = '';
$rs = '';
$rsi = '';

for ($i=0; $i < 14; $i++) {
  $data = $sqla->fetch();
  $id = $data['id_csv'];
  $date = $data['date'];
  $oldclose = $close;
  $close = $data['close'];
  $changes = $close - $oldclose;
  if ($changes >= 0) {
    $gain = $changes;
  } else {
    $gain = 0;
  }
  if ($changes < 0) {
    $loss = abs($changes)  ;
  } else {
    $loss = 0;
  }

	  $sql4->bindParam(':id_csv', $id);
      $sql4->bindParam(':date', $date);
      $sql4->bindParam(':changes', $changes);
      $sql4->bindParam(':gain', $gain);
      $sql4->bindParam(':loss', $loss);
      $sql4->bindParam(':avgGain', $avg_gain);
      $sql4->bindParam(':avgLoss', $avg_loss);
      $sql4->bindParam(':rs', $rs);
      $sql4->bindParam(':rsi', $rsi);
      $sql4->execute();
}
$conn4 = new PDO('mysql:host='.$host.';dbname='.$database, $username, $password);
$conn4->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$sql5 = $conn4->prepare("SELECT * FROM rsi ORDER BY date");
$sql5->execute();

for ($i=0; $i <14 ; $i++) {
  $data2 = $sql5->fetch();
  $id = $data['id_csv'];
  $gain=$data2['gain'];
  $loss=$data2['loss'];
  $gain2[]=$gain;
  $loss2[]=$loss;
}
$data = $sqla->fetch();
$id = $data['id_csv'];
$date = $data['date'];
$close = $data['close'];
$changes = $close - $oldclose;
if ($changes >= 0) {
  $gain = $changes;
} else {
  $gain = 0;
}
if ($changes < 0) {
  $loss = abs($changes)  ;
} else {
  $loss = 0;
}
$avg_gain = array_sum($gain2)/14;
$avg_loss = array_sum($loss2)/14;
$rs = $avg_gain/$avg_loss;
if($rs == 0){
  $rsi = 100;
} else {
  //calc and normalize
  $rsi = 100 - (100 / ( 1 + $rs));
}
$sql4->bindParam(':id_csv', $id);
$sql4->bindParam(':date', $date);
$sql4->bindParam(':changes', $changes);
$sql4->bindParam(':gain', $gain);
$sql4->bindParam(':loss', $loss);
$sql4->bindParam(':avgGain', $avg_gain);
$sql4->bindParam(':avgLoss', $avg_loss);
$sql4->bindParam(':rs', $rs);
$sql4->bindParam(':rsi', $rsi);
$sql4->execute();


$data2 = $sql5->fetch();
foreach ($sqla as $data) {
  $data2 = $sql5->fetch();
  $id = $data['id_csv'];
  $oldclose = $close;
  $close = $data['close'];
  $changes = $close - $oldclose;
  if ($changes >= 0) {
    $gain = $changes;
  } else {
    $gain = 0;
  }
  if ($changes < 0) {
    $loss = abs($changes)  ;
  } else {
    $loss = 0;
  }
    $date = $data['date'];
    $avg_gain= 0.0714*$gain+(1-0.0714)*$avg_gain;
    $avg_loss= 0.0714*$loss+(1-0.0714)*$avg_loss;
    $rs = $avg_gain/$avg_loss;
    if($rs == 0){
      $rsi = 100;
    } else {
      //calc and normalize
      $rsi = 100 - (100 / ( 1 + $rs));
    }
	$sql4->bindParam(':id_csv', $id);
    $sql4->bindParam(':date', $date);
    $sql4->bindParam(':changes', $changes);
    $sql4->bindParam(':gain', $gain);
    $sql4->bindParam(':loss', $loss);
    $sql4->bindParam(':avgGain', $avg_gain);
    $sql4->bindParam(':avgLoss', $avg_loss);
    $sql4->bindParam(':rs', $rs);
    $sql4->bindParam(':rsi', $rsi);
    $sql4->execute();
}
//RSI-End
//header("location: stratchart.php?saham=".urlencode($_GET['saham']));
//header("location: daily.php");
header("Location: insert.php");
//header("Location: export.php");
//header("location: export.php?saham=".urlencode($_GET['saham']));
 ?>
