<?php
include "koneksi.php";
//include "session.php";

/*// SQL Query untuk mengambil akses ke strategi gab14
$ses_sql=mysqli_query($koneksi_db,"select GAB14 from block where GAB14='open'");
$row = mysqli_fetch_assoc($ses_sql);
$strat_access =$row['GAB14'];

if($user_access == 'free' && $strat_access == ''){
	header('Location: premium_alert.php');
}else if(!isset($login_session)){
	mysqli_close($koneksi_db); // Closing Connection
	header('Location: premium_alert.php'); // Redirecting To Home Page
}*/
?>
<?php


try {
    $conn2 = new PDO('mysql:host='.$host.';dbname='.$database, $username, $password);
    // set the PDO error mode to exception
    $conn2->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // sql to delete a record
    $sql = "TRUNCATE TABLE test_transaksi_agg";

    // use exec() because no results are returned
    $conn2->exec($sql);
    }
catch(PDOException $e)
    {
    echo $sql . "<br>" . $e->getMessage();
    }

// ambil data series stock
     $conn1 = new PDO('mysql:host='.$host.';dbname='.$database, $username, $password);
     // set the PDO error mode to exception
     $conn1->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
     $sqlsignal = $conn1->prepare("SELECT test_sinyal_agg.id_sinyal, test_sinyal_agg.id_csv,
	  test_sinyal_agg.Date,
	  test_sinyal_agg.sinyal,
	  csv_test.open,
	  csv_test.high,
	  csv_test.low,
	  csv_test.close
	  FROM test_sinyal_agg
	  INNER JOIN csv_test
	  ON test_sinyal_agg.Date = csv_test.date
	  ORDER BY test_sinyal_agg.Date");
     $sqlsignal->execute();
		
	// Menentukan sinyal buy or sell
    $conn5 = new PDO('mysql:host='.$host.';dbname='.$database, $username, $password);
    $conn5->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sqlt = $conn5->prepare("INSERT INTO test_transaksi_agg (id_sinyal,Tanggal,Sinyal,Uang) VALUES (:id_sinyal,:Tanggal,:Sinyal,:Uang)");
        $data1 = $sqlsignal->fetch();
		$sinyalnow = '';
        $wait = "no";
        $uang = 100000;
		$buynsellat = 0;
    $sinyalstart = 0;
		
        while ($data = $sqlsignal->fetch()) {
		  $id_csv = $data['id_csv'];
		  $id_sinyal = $data['id_sinyal'];
		  $sinyal = $data['sinyal'];
          $date = $data['Date'];
          $close = $data['close'];
		  $open = $data['open'];
          $high = $data['high'];
          $low = $data['low'];
          $ohlc = $open || $high || $low || $close;
		  //$sinyal = preg_replace('/[ \t]+/', ' ', preg_replace('/\s*$^\s*/m', "\n", $sinyal));
		  $sinyal = preg_match("/^[a-zA-Z]+/", $sinyal, $match);
		  $sinyal = count($match) ? $match[0] : $sinyal;
		  //die(var_dump($data));
		  

	 if($sinyalstart == 0){
   if($sinyal !== "Buy"){
    $sinyalstart = 0;
    continue 1;
   } 
   else {
    $sinyalstart = 1;
    $sinyalnow = $sinyal;
    $tanggalsinyal = $date;
                $uang = $uang/$close;
    $buynsellat = $close;
    $sqlt->bindParam(':id_sinyal', $id_sinyal);
                $sqlt->bindParam(':Tanggal', $tanggalsinyal);
                $sqlt->bindParam(':Sinyal', $sinyalnow);
                $sqlt->bindParam(':Uang', $uang);
                $sqlt->execute();
   }
  }
  elseif ($sinyalstart == 1) {
   if($sinyal !== $sinyalnow && ($sinyal == "Buy" || $sinyal == "Sell")) {
    $sinyalnow = $sinyal;
    $tanggalsinyal = $date;
                $uang = $sinyal == 'Buy' ? $uang/$close : $uang*$close;
    $buynsellat = $close;
    $sqlt->bindParam(':id_sinyal', $id_sinyal);
                $sqlt->bindParam(':Tanggal', $tanggalsinyal);
                $sqlt->bindParam(':Sinyal', $sinyalnow);
                $sqlt->bindParam(':Uang', $uang);
                $sqlt->execute();
    
   }
   else{
    continue 1;
   }
  
 
  }  
		  
		}
		
		
		/*
		  if ($sinyal = "Buy" && $wait = "no" && $sinyalnow == $sinyal) {
				//$sinyalnow = "Buy";
                $tanggalsinyal = $date;
                $uang = $uang/$close;
				$buynsellat = $close;
                //$wait = "no";
				$sqlt->bindParam(':id_csv', $id_csv);
                $sqlt->bindParam(':Tanggal', $tanggalsinyal);
                $sqlt->bindParam(':Sinyal', $sinyalnow);
                $sqlt->bindParam(':Uang', $uang);
                $sqlt->execute();
              }
			  
              else if ($sinyal = 'Sell' && $wait = "no" ) {
				$sinyalnow = "Sell";
                $tanggalsinyal = $date;
                $uang = $uang/$close;
				$buynsellat = $close;
                $wait = "no";
				$sqlt->bindParam(':id_csv', $id_csv);
                $sqlt->bindParam(':Tanggal', $tanggalsinyal);
                $sqlt->bindParam(':Sinyal', $sinyalnow);
                $sqlt->bindParam(':Uang', $uang);
                $sqlt->execute();
              }
			  
              else {
				  $wait = "wait";
			  }
			  */
      ?>


     <html>
<head>
  <title>Invest Yuk</title>
  <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link rel="stylesheet" href="css/main2.css" />
</head>
<body class="subpage">

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
<?php require 'header.php' ?>
      <section id="three" class="wrapper">
        <div class="inner">
          <header class="align-center">
            <h2>Saham</h2>
          </header>
          <body>
            <center>
            <img src="images/btn_logo.png" width="300" height="200" alt="BTN" class="center"></img><br></br>
           <button onclick="location.href = 'test_transaksi_agg_norm.php';" id="myButton" class="float-left submit-button" >Model Data B</button>
           <button onclick="location.href = 'test_transaksi_nonagg.php';" id="myButton" class="float-left submit-button" >Model Data C</button>
	         <button onclick="location.href = 'test_transaksi_nonagg_norm.php';" id="myButton" class="float-left submit-button" >Model Data D</button>
          </br>
          </center>
          <br/>

</div>

<div class="row">
      <div class="col-md-6 col-sm-6 col-xs-12">
	  <h3>Transaksi Saham BBTN Menggunakan Model Data A</h3>
      <h3>Last Transaction</h3>
        <table class="table table-hover vertical-align">
        <tbody>
          <tr>
            <td>Signal</td>
            <td><?php
                if ($sinyalnow == "Buy") {
                echo "Buy";
                }
                elseif ($sinyalnow == "Sell") {
                echo "Sell";
                }
                else {
                echo "Belum ada Transaksi";
                } ?>
          </td>
          </tr>
          <tr>
            <td>Tanggal</td>
            <td><?php
                if ($sinyalnow == "Buy") {
                echo $tanggalsinyal;
                }
                elseif ($sinyalnow == "Sell") {
                echo $tanggalsinyal;
                }
                else {
                echo "-";
                } ?>
          </td>
          </tr>
          <tr>
            <td>Modal Rp 100,000 <?php
            if ($sinyalnow == "Buy") {
              echo "Menjadi Saham";
            }
            elseif ($sinyalnow == "Sell") {
              echo "Menjadi";
            }
            else {
              echo "-";
            }
            ?>
            </td>
              <td><?php
                  if ($sinyalnow == "Buy") {
					echo number_format($uang, 2).". Saham dibeli pada harga Rp.".$buynsellat;
                  }
                  elseif ($sinyalnow == "Sell") {
					echo "Rp.".number_format($uang, 2)." dijual pada harga Rp.".$buynsellat;
                  }
                  else {
                  echo "-";
                  } ?>
            </td>
          </tr>
          <tr>
            <td>Performa </td>
           <td><?php
            if ($sinyalnow == "Buy") {
              echo round((($uang*$close)-100000)/100000*100, 2)."%";
            }
            elseif ($sinyalnow == "Sell") {
              echo round(($uang-100000)/100000*100, 2)." %";
            }
            else {
              echo "-";
            }
            ?>
            
            </td>
          </tr>
          <?php
      $conn4 = new PDO('mysql:host='.$host.';dbname='.$database, $username, $password);
      $conn4->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      $sqlz = $conn4->prepare("SELECT Count(*) from test_transaksi_agg");
      $sqlz->execute();
      $dataCount = $sqlz->fetchColumn();
     {
      ?>
          <tr>
            <td>1 Tahun </td>
            <td><?php echo $dataCount; ?> transaksi</td>
          </tr>
             <?php } ?>
           <tr>
            <td>Info</td>
            <td>Strategi ini mengunakan 5 indikator dengan pengambilan keputusan sinyal dengan algoritma Naive Bayes</td></tr><td></td>
          </tr>
        </tbody>
      </table>
    </div>
    <div class="col-md-6 col-sm-6 col-xs-12">
      <h3>Transaction History</h3>
    <table class="table table-hover vertical-align">
      <th>Tanggal</th>
      <th>Signal</th>
      <th>Uang/Saham</th>
      <?php
      $conn4 = new PDO('mysql:host='.$host.';dbname='.$database, $username, $password);
      $conn4->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      $sqlv = $conn4->prepare("SELECT * from test_transaksi_agg");
      $sqlv->execute();
      while( $row = $sqlv->fetch(PDO::FETCH_ASSOC) ) {
      ?>
      <tr>
          <td><?php echo $row['Tanggal']; ?></td>
          <td><?php echo $row['Sinyal']; ?></td>
          <td><?php echo $row['Uang']; ?></td>
      </tr>
      <?php } ?>
      </table>
    </div>
  </div>
  