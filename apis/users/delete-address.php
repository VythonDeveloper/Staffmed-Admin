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

$mandatoryVal = isset($_POST["userId"]) && isset($_POST["addressId"]);

if($mandatoryVal){
    $userId = getSafeValue($_POST['userId']);
    $addressId = getSafeValue($_POST['addressId']);

    // Validation Part
    if($processStatus["error"] == false){
        $conn->query("Delete from address where userId = '$userId' and id = '$addressId'");
        if($conn->affected_rows > 0){
            $processStatus["error"] = false;
            $processStatus["message"] = "Selected address deleted from address book";
        } else{
            $processStatus["error"] = true;
            $processStatus["message"] = "Something went wrong";
        }
    } else{
        // Error Part
        $processStatus["error"] = true;
        $processStatus["message"] = "Sent Invalid Data. Please check.";
    }
} else{
    // Error Part
    $processStatus["error"] = true;
    $processStatus["message"] = "Improper Parameter Set";
}
mysqli_close($conn);
echo json_encode($processStatus);
?>