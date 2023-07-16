<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST");

include "../dbcon.php";

$currentDateTime = date('Y-m-d H:i:s');

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

$mandatoryVal = isset($_POST["userId"]) && isset($_POST["productId"]);

if($mandatoryVal){
    $userId = getSafeValue($_POST['userId']);
    $productId = getSafeValue($_POST['productId']);

    // Validation Part
    if($processStatus["error"] == false && isAuthorized()){
        $conn->query("Delete from cart where userId = '$userId' and productId = '$productId'");
        if($conn->affected_rows > 0){
            $processStatus["error"] = false;
            $processStatus["message"] = "Product removed from cart";
        } else{
            $processStatus["error"] = true;
            $processStatus["message"] = "Try after sometime";
        }
    } else{
        // Error Part
        $processStatus["error"] = true;
        $processStatus["message"] = "Unauthorized User. Action Denied";
    }
} else{
    // Error Part
    $processStatus["error"] = true;
    $processStatus["message"] = "PID, UID is mandatory.";
}
mysqli_close($conn);
echo json_encode($processStatus);
?>