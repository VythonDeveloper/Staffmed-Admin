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
        $res = $conn->query("Select * from medicines order by RAND() LIMIT 10");
        $serverData = array();
        if($res->num_rows > 0){
            while($row = $res->fetch_assoc()){
                $row['discountedPrice'] = $row['price'] - ($row['price'] * $row['discount']/100);
                $serverData[count($serverData)] = $row;
            }
        }
        $processStatus["error"] = false;
        $processStatus["message"] = "Fetched Popular Products";
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