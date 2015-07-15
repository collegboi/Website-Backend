<?php
	
$carMake = $_POST["carMake"];
$carModel = $_POST["carModel"];
$carYear = $_POST["carYear"];
$carVin = $_POST["carVin"];
$carStolen = $_POST["carStolen"];
$carColor = $_POST["carColor"];
$carReg = $_POST["carReg"];
$cardesc = $_POST["carDesc"];
$carUSERID = $_POST["carUSERID"];
$carUSERNAME = $_POST["carUSERNAME"];

$projectName = $carUSERNAME;

$valid_formats = array("jpg", "png", "gif", "zip", "bmp");
$max_file_size = 1024*100; //100 kb9
$count = 0;

$fileUploaded = "";

$json = array();

date_default_timezone_set('Europe/London');

$nowDate = date('d/m/Y G:i:s');

$projectName = "collegboi";

if (!is_dir($filename)) {

    mkdir("/var/www/html/Uploads/" . $projectName, 0777);
    
    $target_dir = "/var/www/html/Uploads/" . $projectName . "/";
   
} else {
    $target_dir = "/var/www/html/Uploads/" . $projectName . "/";

}


$target_file = $target_dir . basename($_FILES["file"]["name"]);

$num_files = count($_FILES['file']['tmp_name']);

echo($num_files);

// Loop $_FILES to exeicute all files
	foreach ($_FILES['files']['name'] as $f => $name) {     
	    if ($_FILES['files']['error'][$f] == 4) {
	        continue; // Skip file if any error found
	    }	       
	    if ($_FILES['files']['error'][$f] == 0) {	           
	        if ($_FILES['files']['size'][$f] > $max_file_size) {
	            $message[] = "$name is too large!.";
	            continue; // Skip large files
	        }
			elseif( ! in_array(pathinfo($name, PATHINFO_EXTENSION), $valid_formats) ){
				$message[] = "$name is not a valid format";
				continue; // Skip invalid file formats
			}
	        else{ // No error found! Move uploaded files 
	            if(move_uploaded_file($_FILES["files"]["tmp_name"][$f], $target_dir.$name))
	            $count++; // Number of successfully uploaded file
	            $message[] = "$name uplaoded Successfully";
	        }
	    }
	}
    	
		
	include('./config/db.php');

		$db = new Database();

		$db->connect();
		$table = "car";					
		
		$db->insert($table, array('carMake'=>$carMake,
								'carModel'=>$carModel, 
								'carReg'=>$carReg, 
								'carYear'=>$carYear, 
								'carVin'=>$carVin,
								'carStolen'=>$carStolen, 
								'carColor'=>$carColor, 
								'description'=>$cardesc, 
								'userID'=>$carUSERID,
								'userName'=>$carUSERNAME));
								
		$messeage = array("message"=>"Added");

		
		

$jsonArray['Result'][] = $message;

echo json_encode($jsonArray);


?>