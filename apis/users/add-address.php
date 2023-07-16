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

$mandatoryVal = isset($_POST["userId"]) && isset($_POST["pincode"]) && isset($_POST["address"]) && isset($_POST["recipient"]) && isset($_POST["phone"]) && isset($_POST["isDefault"]);

if($mandatoryVal){
    $userId = getSafeValue($_POST['userId']);
    $pincode = getSafeValue($_POST['pincode']);
    $address = getSafeValue($_POST['address']);
    $recipient = getSafeValue($_POST['recipient']);
    $phone = getSafeValue($_POST['phone']);
    $isDefault = getSafeValue($_POST['isDefault']);

    // Validation Part
    if($processStatus["error"] == false){
        if($isDefault == "true"){
            $conn->query("Update address set isDefault = 'false' where userId = '$userId'");
        }
        $conn->query("Insert into address set 
        userId = '$userId',
        pincode = '$pincode',
        address = '$address',
        recipient = '$recipient',
        phone = '$phone',
        isDefault = '$isDefault'
        ");
        if($conn->affected_rows > 0){
            $processStatus["error"] = false;
            $processStatus["message"] = "New address added to address book";
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