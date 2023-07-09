<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST");

include "../dbcon.php";

function getSafeValue($value){
	global $conn;
	return strip_tags(mysqli_real_escape_string($conn,$value));
}

$processStatus["error"] = false;
$processStatus["message"] = "No Error";

$mandatoryVal = isset($_POST["phone"]) && isset($_POST["password"]);

if($mandatoryVal){
    $phone = getSafeValue($_POST['phone']);
    $password = md5(getSafeValue($_POST['password']));

    // Validation Part
    if($processStatus["error"] == false){
        $newToken = substr(str_shuffle(str_repeat($x = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ', ceil(16 / strlen($x)))), 1, 16);
        
        $conn->query("Update users set tokenId = '$newToken' where phone = '$phone' and password = '$password'");
        
        if($conn->affected_rows > 0){
            $res = $conn->query("Select * from users where tokenId = '$newToken' and phone = '$phone' and password = '$password'");
            if($res->num_rows > 0){
                $row = $res->fetch_assoc();
                $processStatus["error"] = false;
                $processStatus["message"] = "Login Successful";
                $processStatus["response"] = $row;
            } else{
                $processStatus["error"] = true;
                $processStatus["message"] = "Invalid Login Credentials";
            }
        } else{
            $processStatus["error"] = true;
            $processStatus["message"] = "Invalid Login Credentials";
        }
    } else{
        // Error Part
        $processStatus["error"] = true;
        $processStatus["message"] = "Sent Invalid Data. Please check.";
    }
} else{
    // Error Part
    $processStatus["error"] = true;
    $processStatus["message"] = "PHN, PWD, TKN is mandatory.";
}
mysqli_close($conn);
echo json_encode($processStatus);
?>