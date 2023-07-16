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
        $res = $conn->query("Select * from orders where userId = '$userId' order by id desc");
        $serverData = array();
        if($res->num_rows > 0){
            while($row = $res->fetch_assoc()){
                $opRes = $conn->query("Select * from medicines med inner join ordered_products op on op.productId = med.id where op.orderId = '".$row['id']."'
                ");
                $opArray = array();
                if($opRes->num_rows > 0){
                    while($opRow = $opRes->fetch_assoc()){
                        $opArray[count($opArray)] = $opRow;
                    }
                }
                
                $row["orderedProducts"] = $opArray;
                $serverData[count($serverData)] = $row;
            }
        }
        $processStatus["error"] = false;
        $processStatus["message"] = "Fetched Order History";
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