<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST");

include "../dbcon.php";

$headers = getallheaders();

$processStatus["error"] = false;
$processStatus["message"] = "No Error";

$mandatoryVal = true;

if($mandatoryVal){
    // Validation Part
    if($processStatus["error"] == false){
        $res = $conn->query("Select * from banners order by RAND()");
        $serverData = array();
        if($res->num_rows > 0){
            while($row = $res->fetch_assoc()){
                $serverData[count($serverData)] = $row;
            }
        }
        $processStatus["error"] = false;
        $processStatus["message"] = "Fetched Banners";
        $processStatus['response'] = $serverData;
        
    }
} else{
    // Error Part
    $processStatus["error"] = true;
    $processStatus["message"] = "Improper Parameter Set";
}

mysqli_close($conn);
echo json_encode($processStatus);
?>