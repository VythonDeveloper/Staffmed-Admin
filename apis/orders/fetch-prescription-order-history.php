<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST");

include "../dbcon.php";

$headers = getallheaders();
$tokenId = '';
if(isset($headers['Tokenid'])){
    $tokenId = $headers['Tokenid'];
}

function isAuthorized(): bool {
    global $tokenId;
    global $conn;
    $res = $conn->query("Select * from users where tokenId = '$tokenId' and tokenId != ''");
    if($res->num_rows > 0){
        return true;
    }else{
        return false;
    }
}

function getSafeValue($value){
	global $conn;
	return strip_tags(mysqli_real_escape_string($conn,$value));
}

$processStatus["error"] = false;
$processStatus["message"] = "No Error";

$mandatoryVal = isset($_POST['userId']);

if($mandatoryVal){
    $userId = getSafeValue($_POST['userId']);
    
    // Validation Part
    if($processStatus["error"] == false && isAuthorized()){
        $res = $conn->query("Select * from prescription_orders where userId = '$userId' order by id desc");
        $serverData = array();
        if($res->num_rows > 0){
            while($row = $res->fetch_assoc()){
                
                // Prescriptions
                
                $presRes = $conn->query("Select * from prescriptions where presId = '".$row['id']."'
                ");
                $presArray = array();
                if($presRes->num_rows > 0){
                    while($presRow = $presRes->fetch_assoc()){
                        $presArray[count($presArray)] = $presRow;
                    }
                }
                $row["prescriptions"] = $presArray;
                
                // Medicines
                
                $medRes = $conn->query("Select * from prescription_products where presId = '".$row['id']."'
                ");
                $medArray = array();
                if($medRes->num_rows > 0){
                    while($medRow = $medRes->fetch_assoc()){
                        $medArray[count($medArray)] = $medRow;
                    }
                }
                $row["medicines"] = $medArray;
                
                // Merge and Submit
                $serverData[count($serverData)] = $row;
                
            }
        }
        $processStatus["error"] = false;
        $processStatus["message"] = "Fetched Prescription Order History";
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