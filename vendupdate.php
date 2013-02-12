<?php

//Code by rafa@parlevelsystems.com

echo 'processing...<br>';
if (isset($_GET['seqid']) && isset($_GET['ser']) && isset($_GET['opdata']) && isset($_GET['optype'])){
    echo "receiving...<br>";
	$seqid = $_GET['seqid'];
	$ser = $_GET['ser'];
	$optype = intval($_GET['optype']);
	$opdata = $_GET['opdata'];
	$transtime = 'NA';
	$uptime = 0.0;
	$ver = 'NA';
	$fsfree = 0.0;
	
	//Assigns value to optional variables if they are provided
	if(isset($_GET['transtime'])){
		$transtime = date('Y-m-d H:i:s', strtotime($_GET['transtime']));
		}
	if(isset($_GET['uptime'])){
		$uptime = floatval($_GET['uptime']);
		}
	if(isset($_GET['ver'])){
		$ver = $_GET['ver'];
		}
	if(isset($_GET['fsfree'])){
		$fsfree = floatval($_GET['fsfree']);
		}
	
    //verifies if the data transmited is valid
	$query = "select item from vendingBinary where vendingBinary.binary = '".$opdata."'";
	error_log($query, 3, 'queries.log');
	$link = mysql_connect('localhost', 'pls', 'pls9999');
    mysql_select_db('pls_test');
	$result = mysql_query($query);
	$row = mysql_fetch_row($result);
    $item = $row[0];
	
	if(!$item){	
	   //$dataMessage = '<br><strong>*******Data information is invalid, no selection was processed*********</strong><br>';
	    $dataMessage = '<strong>Selection Information: Unknown Data</strong>';
	}else{
		$dataMessage = '<strong>Selection Information: </strong>'.$item;
	}
	//inserts information from the ParLevelBox into de Database
        $query = "insert into vendingParameters (seqid, ser, optype, opdata, transtime, uptime, ver, fsfree) values (".$seqid.", '".$ser."', ".$optype.",'".$opdata."', '".$transtime."', ".$uptime.", ".$ver.", ".$fsfree.")";
		error_log($query, 3, 'queries.log');
    	mysql_query($query);
		mysql_close($link);		
		$serverDate = date('Y-m-d H:i:s');
	//}
	
	//Displays results and feedback
	//echo 'Success!!<br>';
	echo '<strong>Sequencial ID:</strong> '.$seqid.'<br>';
	echo '<strong>PLB Serial Number:</strong> '.$ser.'<br>';
	echo '<strong>Data Type:</strong> '.$optype.'<br>';
	echo '<strong>Data Transfered:</strong> '.$opdata.'<br>';
	echo '<strong>Server DateTime:</strong> '.$serverDate.'<br>';
	echo '<strong>Upload DateTime:</strong> '.$uptime.' secs.<br>';
	echo '<strong>Transmition DateTime:</strong> '.$transtime.'<br>';
	echo '<strong>Memory free in PLB:</strong> '.$fsfree.'<br>';
	echo '<strong>Script Version:</strong> '.$ver.'<br>';
	echo $dataMessage;
  }else{
	echo 'Not enough parameters for operation<br>';
	echo 'Try the following "http://www.plsvms.com/vendupdate.php?seqid=value&ser=value&optype=value&opdata=value"<br>';  
  }
?>
