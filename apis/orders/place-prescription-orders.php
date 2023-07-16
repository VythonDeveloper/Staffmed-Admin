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

$mandatoryVal = isset($_POST['userId']) && isset($_POST['prescriptionArray'])  && isset($_POST['orderTimeSlot']) && isset($_POST['orderDateRange']) && isset($_POST['shippingAddress']);

if($mandatoryVal){
    $userId = getSafeValue($_POST['userId']);
    $prescriptionArray = json_decode($_POST['prescriptionArray'], true);
    $orderTimeSlot = getSafeValue($_POST['orderTimeSlot']);
    $orderDateRange = getSafeValue($_POST['orderDateRange']);
    $shippingAddress = getSafeValue($_POST['shippingAddress']);
    $referenceId = "PROD".substr(str_shuffle(str_repeat($x = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ', ceil(6 / strlen($x)))), 1, 6);
    
    // Validation Part
    if($processStatus["error"] == false && isAuthorized()){
        $conn->query("Insert into prescription_orders set
        refId = '$referenceId',
        userId = '$userId',
        amount = '0.0',
        timeSlot = '$orderTimeSlot',
        dateRange = '$orderDateRange',
        shippingAddress = '$shippingAddress',
        isPaid = 'Pending',
        status = 'Pending',
        date = '$currentDateTime'
        ");

        if($conn->affected_rows > 0){
            $presOrderId = $conn->insert_id;
            $processStatus["referenceId"] = $referenceId;
            
            $sql = '';
            for($index = 0; $index < count($prescriptionArray); $index++){
                $sql .= "Insert into prescriptions set
                presId = '$presOrderId',
                image = '".$prescriptionArray[$index]."'
                ;";
            }
            
            if ($conn->multi_query($sql) === TRUE) {
                $processStatus["error"] = false;
                $processStatus["message"] = "Order Placed. Please expect a call from our Pharmacy Team";
            } else {
                $processStatus["error"] = true;
                $processStatus["message"] = "Try again after sometime";
                $processStatus["sql"] = $sql;
            }
        } else{
            $processStatus["error"] = true;
            $processStatus["message"] = "Try again after sometime";
        }
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