<?php
set_time_limit(300);
include 'koneksi.php';

//truncate csv table
try {
    $conn2 = new PDO('mysql:host='.$host.';dbname='.$database, $username, $password);
    // set the PDO error mode to exception
    $conn2->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // sql to delete a record
    $sql = "TRUNCATE TABLE bband";

    // use exec() because no results are returned
    $conn2->exec($sql);
    echo "Record deleted successfully";
    }
catch(PDOException $e)
    {
    echo $sql . "<br>" . $e->getMessage();
    }

//BollingerBands-Start
// Function to calculate square of value - mean
function sd_square($x, $mean) { return pow($x - $mean,2); }

// Function to calculate standard deviation (uses sd_square)
function sd($array) {
    // square root of sum of squares devided by N-1
    return sqrt(array_sum(array_map("sd_square", $array, array_fill(0,count($array), (array_sum($array) / count($array)) ) ) ) / (count($array)) );
}
$nol = '';


$sql = $pdo->prepare("SELECT id_csv, date, close FROM csv_training
WHERE date !=0
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
$sql1 = $conn->prepare("INSERT INTO bband (id_csv,date,midBand,sdp,uBand,lBand,bbRange) VALUES (:id_csv,:date,:midBand,:sdp,:uBand,:lBand,:bbRange)");

for ($i=0; $i < 14; $i++) {
  $data = $sql->fetch();
  $id = $data['id_csv'];
  $tanggal = $data['date'];
  $close[] = $data['close'];
}
/*$midBand = array_sum($close)/count($close);
$sdp = sd($close);
$uBand = $midBand+$sdp*2; //Upper Band
$lBand = $midBand-$sdp*2; //Lower Band
$bbrange = $uBand-$lBand;
$tanggal = $data['Date'];

//bind data
$sql1->bindParam(':tanggal', $tanggal);
$sql1->bindParam(':midBand', $midBand);
$sql1->bindParam(':sdp', $sdp);
$sql1->bindParam(':uBand', $uBand);
$sql1->bindParam(':lBand', $lBand);
$sql1->bindParam(':bbRange', $bbrange);
$sql1->execute();*/

while ($data = $sql->fetch()) {
  array_shift($close); //keluarkan data lama
  $id = $data['id_csv'];
  $tanggal = $data['date'];
  $close[14] = $data['close'];
  $midBand = array_sum($close)/count($close);
  $sdp = sd($close);
  $uBand = $midBand+$sdp*2; //Upper Band
  $lBand = $midBand-$sdp*2; //Lower Band
  $bbrange = $uBand-$lBand;
  
  //bind data
  $sql1->bindParam(':id_csv', $id);
  $sql1->bindParam(':date', $tanggal);
  $sql1->bindParam(':midBand', $midBand);
  $sql1->bindParam(':sdp', $sdp);
  $sql1->bindParam(':uBand', $uBand);
  $sql1->bindParam(':lBand', $lBand);
  $sql1->bindParam(':bbRange', $bbrange);
  $sql1->execute();
}
//BollingerBands-End
//header("location: momentum.php?saham=".urlencode($_GET['saham']));
//header("location: rsi.php?saham=".urlencode($_GET['saham']));
//header("location: macd_data.php?saham=".urlencode($_GET['db_saham']));
header("location: data_macd.php?saham=".urlencode($_GET['db_saham']));
?>

