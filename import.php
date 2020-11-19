<?php
set_time_limit(300);
/*
-- Source Code from My Notes Code (www.mynotescode.com)
--
-- Follow Us on Social Media
-- Facebook : http://facebook.com/mynotescode
-- Twitter  : http://twitter.com/mynotescode
-- Google+  : http://plus.google.com/118319575543333993544
--
-- Terimakasih telah mengunjungi blog kami.
-- Jangan lupa untuk Like dan Share catatan-catatan yang ada di blog kami.
*/

//Load file koneksi.php
include "koneksi.php";
include "strategi.php";
//truncate csv table
try {
    $conn1 = new PDO('mysql:host='.$host.';dbname='.$database, $username, $password);
    // set the PDO error mode to exception
    $conn1->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // sql to delete a record
    $sql1 = "TRUNCATE TABLE csv";

    // use exec() because no results are returned
    $conn1->exec($sql1);
    echo "Record deleted successfully";
    }
catch(PDOException $e)
    {
    echo $sql1 . "<br>" . $e->getMessage();
    }

$nama_file_baru = 'data_daily.csv';

// Cek apakah terdapat file data.xlsx pada folder tmp
if(is_file('tmp/'.$nama_file_baru)) // Jika file tersebut ada
  unlink('tmp/'.$nama_file_baru); // Hapus file tersebut

//Upload data from google finance to temp/

$local_file = "tmp/data_daily.csv";//This is the file where we save the information
//$remote_file = "https://finance.google.com/finance/historical?output=csv&q=BBNI%3A".$_GET['db_saham']; //Here is the file we are downloading
//$remote_file = "https://finance.yahoo.com/v7/finance/download/BBNI.JK?period1=1555257920&period2=1557849920&interval=1d&events=history&crumb=sbW8rawJoP8".$_GET['db_saham'];
//$remote_file = "https://www.alphavantage.co/query?function=TIME_SERIES_DAILY&symbol=BMRI.JK&apikey=FTAAJXJOEXWZ3DDA&datatype=csv".$_GET['saham'];
//$remote_file = "https://www.alphavantage.co/query?function=TIME_SERIES_DAILY&symbol=".$_GET['saham']."&apikey=FTAAJXJOEXWZ3DDA&datatype=csv";
//$remote_file = "https://www.google.com/finance/historical?output=csv&q=BBNI".$_GET['db_saham'];
//$remote_file = "https://finance.yahoo.com/v7/finance/download/BBNI.JK?period1=1464714000&period2=1514653200&interval=1d&events=history&crumb=sbW8rawJoP8".$_GET['db_saham'];

$ch = curl_init();
$fp = fopen ($local_file, 'w+');
$ch = curl_init($remote_file);
curl_setopt($ch, CURLOPT_TIMEOUT, 50);
curl_setopt($ch, CURLOPT_FILE, $fp);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
// Execute
curl_exec($ch);
// Check if any error occured
if(!curl_errno($ch))
{
 curl_close($ch);
 fclose($fp);
try {
    $conn = new PDO('mysql:host='.$host.';dbname='.$database, $username, $password, array(PDO::MYSQL_ATTR_LOCAL_INFILE => true));
    // set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sql = "LOAD DATA LOCAL INFILE '".$local_file."'
		INTO TABLE db_saham.csv
		FIELDS TERMINATED BY ','
		LINES TERMINATED BY '\n'
		IGNORE 1 LINES
		(date, open, high, low, close, volume)";
		//SET Date = STR_TO_DATE(@date, '%d-%M-%y')";
    // use exec() because no results are returned
    $conn->exec($sql);
    echo "New record created successfully";
    }
catch(PDOException $e)
    {
    echo $sql . "<br>" . $e->getMessage();
	}}
	// querry hapus isi table

	
/*if(isset($_POST['submit'])){
// As output of $_POST['Color'] is an array we have to use foreach Loop to display individual value
foreach ($_POST['Color'] as $select)
{
echo "You have selected :" .$select; // Displaying Selected Value
}
*/

//if( $_GET['myform']=='BBAND' ){
	header("location: data_bband.php?saham=".urlencode($_GET['saham']));
//}

?>