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

$mandatoryVal = isset($_POST['searchKey']);

if($mandatoryVal){
    $searchKey = getSafeValue($_POST['searchKey']);
    
    // Validation Part
    if($processStatus["error"] == false && isAuthorized()){
        $res = $conn->query("Select * from medicines 
        WHERE (soundex('$searchKey') = soundex(name)) OR (name LIKE CONCAT('%', '$searchKey', '%')) or (soundex('$searchKey') = soundex(company)) OR (company LIKE CONCAT('%', '$searchKey', '%'))");
        
        $serverData = array();
        if($res->num_rows > 0){
            while($row = $res->fetch_assoc()){
                $row['discountedPrice'] = $row['price'] - ($row['price'] * $row['discount']/100);
                $serverData[count($serverData)] = $row;
            }
        }
        $processStatus["error"] = false;
        $processStatus["message"] = "Fetched Searched Products";
        $processStatus['response'] = $serverData;
        
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