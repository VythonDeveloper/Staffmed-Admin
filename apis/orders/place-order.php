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

$mandatoryVal = isset($_POST['userId']) && isset($_POST['amount']) && isset($_POST['productArray']) && isset($_POST['quantityArray']) && isset($_POST['orderTimeSlot']) && isset($_POST['orderDateRange']) && isset($_POST['shippingAddress']);

if($mandatoryVal){
    $userId = getSafeValue($_POST['userId']);
    $amount = getSafeValue($_POST['amount']);
    $productArray = json_decode($_POST['productArray'], true);
    $quantityArray = json_decode($_POST['quantityArray'], true);
    $orderTimeSlot = getSafeValue($_POST['orderTimeSlot']);
    $orderDateRange = getSafeValue($_POST['orderDateRange']);
    $shippingAddress = getSafeValue($_POST['shippingAddress']);
    $referenceId = "NPOD".substr(str_shuffle(str_repeat($x = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ', ceil(6 / strlen($x)))), 1, 6);
    
    // Validation Part
    if($processStatus["error"] == false && isAuthorized() && count($productArray) == count($quantityArray)){
        $conn->query("Insert into orders set
        refId = '$referenceId',
        userId = '$userId',
        amount = '$amount',
        timeSlot = '$orderTimeSlot',
        dateRange = '$orderDateRange',
        shippingAddress = '$shippingAddress',
        isPaid = 'Pending',
        status = 'Pending',
        date = '$currentDateTime'
        ");

        if($conn->affected_rows > 0){
            $orderId = $conn->insert_id;
            $processStatus["referenceId"] = $referenceId;
            
            $sql = '';
            for($index = 0; $index < count($productArray); $index++){
                $sql .= "Insert into ordered_products set
                orderId = '$orderId',
                productId = '".$productArray[$index]['id']."',
                salePrice = '".$productArray[$index]['discountedPrice']."',
                quantity = '".$quantityArray[$productArray[$index]['id']]."'
                ;";
            }
            $sql .= "Delete from cart where userId = '$userId';";
            if ($conn->multi_query($sql) === TRUE) {
                $processStatus["error"] = false;
                $processStatus["message"] = "Order Placed. Please pay amount to confirm the order";
            } else {
                $processStatus["error"] = true;
                $processStatus["message"] = "Try again after sometime";
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