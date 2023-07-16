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

$mandatoryVal = isset($_POST['userId']);

if($mandatoryVal){
    $userId = getSafeValue($_POST['userId']);
    
    // Validation Part
    if($processStatus["error"] == false && isAuthorized()){
        
        $idRes = $conn->query("Select productId from cart where userId = '$userId'");
        $idsArray = array();
        if($idRes->num_rows > 0){
            while($idRow = $idRes->fetch_assoc()){
                $idsArray[count($idsArray)] = $idRow['productId'];
            }
        }
        $processStatus['idsArray'] = $idsArray;
        
        $res = $conn->query("Select med.* from medicines as med inner join cart as ct on ct.productId = med.id where ct.userId = '$userId'");
        $serverData = array();
        if($res->num_rows > 0){
            while($row = $res->fetch_assoc()){
                $row['discountedPrice'] = $row['price'] - ($row['price'] * $row['discount']/100);
                $serverData[count($serverData)] = $row;
            }
        }
        $processStatus['response'] = $serverData;
            
        $processStatus["error"] = false;
        $processStatus["message"] = "Fetched Cart";
    } else{
        // Error Part
        $processStatus["error"] = true;
        $processStatus["message"] = "Unauthorized User. Action Denied";
    }
} else{
    // Error Part
    $processStatus["error"] = true;
    $processStatus["message"] = "Improper Parameter Set";
}

mysqli_close($conn);
echo json_encode($processStatus);
?>