<?php error_reporting(1);
$user = 'roundthe4' ; 
$pass = '#zvxHPqp==io';
$term = $_GET["term"]; 
$json=array();
try {
	$dbh = new PDO('mysql:host=localhost;dbname=roundthe4', $user, $pass);
	//echo $term;
	$result = $dbh->query("SELECT * FROM gof_iata_airport_codes WHERE airport LIKE '".$term."' ORDER BY airport"); 
	foreach($result as $row) {
		$json[]=array( 
			'value'=> $row["airport"],
			'label'=>$row["airport"]." - ".$row["code"]
		);
	}
$dbh = null;
} catch (PDOException $e) {
	print "Error!: " . $e->getMessage() . "<br/>";  
	die();
}
echo json_encode($json);