<?php
set_time_limit(300);
include 'koneksi.php';

//truncate csv table
try 
{
  $conn = new PDO('mysql:host='.$host.';dbname='.$database, $username, $password);
  // set the PDO error mode to exception
  $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

  // sql to delete a record
  $sql = "TRUNCATE TABLE macd";

  // use exec() because no results are returned
  $conn->exec($sql);
}
catch(PDOException $e)
{
  echo $sql . "<br>" . $e->getMessage();
}

$sql = $pdo->prepare("SELECT id_csv, open, date, close FROM csv_training
WHERE date !=0
AND close != 0
ORDER BY date");
$sql->execute();

/*$sql = $pdo->prepare("SELECT id_csv, open, date, close FROM csv_test
WHERE date !=0
AND close != 0
ORDER BY date");
$sql->execute();*/

/*$sql = $pdo->prepare("SELECT id_csv, open, date, close FROM csv
WHERE date BETWEEN NOW() - INTERVAL 420 DAY AND NOW()
AND close != 0
ORDER BY date");
$sql->execute();*/

// prepare query insert
$conn = new PDO('mysql:host='.$host.';dbname='.$database, $username, $password);

// set the PDO error mode to exception
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$sql2 = $conn->prepare("INSERT INTO macd (id_csv,date,sma9,ema12,ema26,macdline,signaline,histogram,trend,histogramup,histogramdown) VALUES (:id_csv,:date,:sma9,:ema12,:ema26,:macdline,:signaline,:histogram,:trend,:histogramup,:histogramdown)");

$sma9 = '';
$ema12 = '';
$ema26 = '';
$macdline = '';
$signaline = '';
$histogram = '';
$histogramup = '';
$histogramdown = '';
$trend = '';

for ($i=0; $i < 9; $i++)
{
  $data = $sql->fetch();
  $id = $data['id_csv'];
  $date = $data['date'];
  $close = $data['close'];
  $sma9array[] = $close;
  $ema12array[] = $close; 
  $ema26array[] = $close;
}

for ($ii=0; $ii < 3 ; $ii++) 
{ 
  $data = $sql->fetch();
  $id = $data['id_csv'];
  $date = $data['date'];
  $sma9 = array_sum($sma9array)/count($sma9array);

  //bind data
  $sql2->bindParam(':id_csv', $id);
  $sql2->bindParam(':date', $date);
  $sql2->bindParam(':sma9', $sma9);
  $sql2->bindParam(':ema12', $ema12);
  $sql2->bindParam(':ema26', $ema26);
  $sql2->bindParam(':macdline', $macdline);
  $sql2->bindParam(':signaline', $signaline);
  $sql2->bindParam(':histogram', $histogram);
  $sql2->bindParam(':histogramup', $histogramup);
  $sql2->bindParam(':histogramdown', $histogramdown);
  $sql2->bindParam(':trend', $trend);
  $sql2->execute();

  array_shift($sma9array);
  $sma9array[] = $data['close'];
  $ema12array[] = $data['close'];
  $ema26array[] = $data['close'];
}

$data = $sql->fetch();
$id = $data['id_csv'];
$date = $data['date'];
$sma9 = array_sum($sma9array)/count($sma9array);
$ema12 = array_sum($ema12array)/count($ema12array);

//bind data
$sql2->bindParam(':id_csv', $id);
$sql2->bindParam(':date', $date);
$sql2->bindParam(':sma9', $sma9);
$sql2->bindParam(':ema12', $ema12);
$sql2->bindParam(':ema26', $ema26);
$sql2->bindParam(':macdline', $macdline);
$sql2->bindParam(':signaline', $signaline);
$sql2->bindParam(':histogram', $histogram);
$sql2->bindParam(':histogramup', $histogramup);
$sql2->bindParam(':histogramdown', $histogramdown);
$sql2->bindParam(':trend', $trend);
$sql2->execute();

array_shift($sma9array);
$sma9array[] = $data['close'];
$ema12array[] = $data['close'];
$ema26array[] = $data['close'];

 
for ($iii=0; $iii < 13; $iii++) 
{ 
  $data = $sql->fetch();
  $id = $data['id_csv'];
  $date = $data['date'];
  $open = $data['open'];
  $sma9 = array_sum($sma9array)/count($sma9array);
  $ema12 = (2/(12+1)*($open-$ema12))+$ema12;

  //bind data
  $sql2->bindParam(':id_csv', $id);
  $sql2->bindParam(':date', $date);
  $sql2->bindParam(':sma9', $sma9);
  $sql2->bindParam(':ema12', $ema12);
  $sql2->bindParam(':ema26', $ema26);
  $sql2->bindParam(':macdline', $macdline);
  $sql2->bindParam(':signaline', $signaline);
  $sql2->bindParam(':histogram', $histogram);
  $sql2->bindParam(':histogramup', $histogramup);
  $sql2->bindParam(':histogramdown', $histogramdown);
  $sql2->bindParam(':trend', $trend);
  $sql2->execute();

  array_shift($sma9array);
  $sma9array[] = $data['close'];
  $ema26array[] = $data['close'];
}

$data = $sql->fetch();
$id = $data['id_csv'];
$date = $data['date'];
$open = $data['open'];
$sma9 = array_sum($sma9array)/count($sma9array);
$ema12 = (2/(12+1)*($open-$ema12))+$ema12;
$ema26 = array_sum($ema26array)/count($ema26array);
$macdline = $ema12-$ema26;
$signalinearray[] = $macdline;

//bind data
$sql2->bindParam(':id_csv', $id);
$sql2->bindParam(':date', $date);
$sql2->bindParam(':sma9', $sma9);
$sql2->bindParam(':ema12', $ema12);
$sql2->bindParam(':ema26', $ema26);
$sql2->bindParam(':macdline', $macdline);
$sql2->bindParam(':signaline', $signaline);
$sql2->bindParam(':histogram', $histogram);
$sql2->bindParam(':histogramup', $histogramup);
$sql2->bindParam(':histogramdown', $histogramdown);
$sql2->bindParam(':trend', $trend);
$sql2->execute();

array_shift($sma9array);
$sma9array[] = $data['close'];

for ($iiii=0 ; $iiii < 8 ; $iiii++ ) 
{ 
  $data = $sql->fetch();
  $id = $data['id_csv'];
  $date = $data['date'];
  $open = $data['open'];
  $sma9 = array_sum($sma9array)/count($sma9array);
  $ema12 = (2/(12+1)*($open-$ema12))+$ema12;
  $ema26 = (2/(26+1)*($open-$ema26))+$ema26;
  $macdline = $ema12-$ema26;
  $signalinearray[] = $macdline;

  //bind data
  $sql2->bindParam(':id_csv', $id);
  $sql2->bindParam(':date', $date);
  $sql2->bindParam(':sma9', $sma9);
  $sql2->bindParam(':ema12', $ema12);
  $sql2->bindParam(':ema26', $ema26);
  $sql2->bindParam(':macdline', $macdline);
  $sql2->bindParam(':signaline', $signaline);
  $sql2->bindParam(':histogram', $histogram);
  $sql2->bindParam(':histogramup', $histogramup);
  $sql2->bindParam(':histogramdown', $histogramdown);
  $sql2->bindParam(':trend', $trend);
  $sql2->execute();

  array_shift($sma9array);
  $sma9array[] = $data['close'];

}

while ($data = $sql->fetch())
{
  $id = $data['id_csv'];
  $date = $data['date'];
  $open = $data['open'];
  $histogramold = $histogram;
  $sma9 = array_sum($sma9array)/count($sma9array);
  $ema12 = (2/(12+1)*($open-$ema12))+$ema12;
  $ema26 = (2/(26+1)*($open-$ema26))+$ema26;
  $macdline = $ema12-$ema26;
  $signaline = array_sum($signalinearray)/count($signalinearray);
  $histogram = $macdline-$signaline;

  //memasukkan trend ke database
  if ($histogram>$histogramold) 
  {
    $trend = "Up";
  }
  elseif ($histogram==$histogramold)
  {
    $trend = "MACD Cross";
  }
  //else if($histogram<$histogramold)
  else
  {
    $trend = "Down";
  }
  
  if($histogram>0){
	$histogramup = $histogram;
	$histogramdown = 0;
  }else{
	$histogramup = 0;
	$histogramdown = $histogram;
  }


  //bind data
  $sql2->bindParam(':id_csv', $id);
  $sql2->bindParam(':date', $date);
  $sql2->bindParam(':sma9', $sma9);
  $sql2->bindParam(':ema12', $ema12);
  $sql2->bindParam(':ema26', $ema26);
  $sql2->bindParam(':macdline', $macdline);
  $sql2->bindParam(':signaline', $signaline);
  $sql2->bindParam(':histogram', $histogram);
  $sql2->bindParam(':histogramup', $histogramup);
  $sql2->bindParam(':histogramdown', $histogramdown);
  $sql2->bindParam(':trend', $trend);
  $sql2->execute();

  array_shift($sma9array);
  $sma9array[] = $data['close'];
  array_shift($signalinearray);
  $signalinearray[] = $macdline;
}

//header("location: rsi.php?saham=".urlencode($_GET['saham']));
header("location: data_ma.php?saham=".urlencode($_GET['db_saham']));