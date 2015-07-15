<?php
	
$userName = $_GET["username"];
$limit = $_POST["limit"];
$offset= $_POST["offset"];

include('./config/db.php');

$db = new Database();

$db->connect();

$where = "WHERE c.userName='collegboi'";

if($userName == null) {
	$where = null;
}

//get car details from db 
$db->selectQuery("car","SELECT c.id, c.carReg, p.carPhoto  FROM car AS c JOIN carPhoto AS p ON c.id = p.carID $where GROUP BY c.id");

$result = $db->getResult();
 

/*
$db->clearResult();

//get carImages from db
$db->selectWithOutKey("carPhoto","carPhoto");

$result1 = $db->getResult();

$result["carPhoto"] = $result1;

$db->clearResult();

$result2 = $db->getResult();
*/


//join all together
$jsonArray["Car"] = $result;


//echo JSON Objects	
echo json_encode($jsonArray);	

/*SELECT c.id, c.carReg, p.carPhoto 
FROM car AS c
JOIN carPhoto AS p ON c.id = p.carID
GROUP BY c.id*/


?>