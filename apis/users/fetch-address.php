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
    if($processStatus["error"] == false){
        $res = $conn->query("Select * from address where userId = '$userId'");
        $serverData = array();
        if($res->num_rows > 0){
            while($row = $res->fetch_assoc()){
                $serverData[count($serverData)] = $row;
            }
        }
        $processStatus["error"] = false;
        $processStatus["message"] = "Fetched Addresses";
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