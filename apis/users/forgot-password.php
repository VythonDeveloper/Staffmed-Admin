<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST");

include "../dbcon.php";

$headers = getallheaders();

function getSafeValue($value){
	global $conn;
	return strip_tags(mysqli_real_escape_string($conn,$value));
}

function verifyOTP($mob, $otp): bool
{ 
    $curl = curl_init("https://tganand.xyz/Ex/?mo=$mob&type=2&otp=$otp"); 
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true); 
    curl_setopt($curl, CURLOPT_POST, false); 
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false); 
    $curl_response = curl_exec($curl); 
    curl_close($curl); 
    $response = json_decode($curl_response);
    if($response->message == "OTP Verified Success"){
        return true;
    } else{
        return false;
    }
}

$processStatus["error"] = false;
$processStatus["message"] = "No Error";

$mandatoryVal = isset($_POST["phoneNumber"]) && isset($_POST["otp"]) && isset($_POST["newPassword"]);

if($mandatoryVal){
    $phoneNumber = getSafeValue($_POST['phoneNumber']);
    $otp = getSafeValue($_POST['otp']);
    $newPassword = md5(getSafeValue($_POST['newPassword']));

    // Validation Part
    if($processStatus["error"] == false && verifyOTP($phoneNumber, $otp)){
        $conn->query("Update user set password = '$newPassword' where phone = '$phoneNumber'");
        if($conn->affected_rows > 0){
            $processStatus["error"] = false;
            $processStatus["message"] = "Password Changed. Please login with the new password";
        } else{
            // error part
            $processStatus["error"] = true;
            $processStatus["message"] = "No such account with Phone ".$phoneNumber;
        }
    } else{
        // Error Part
        $processStatus["error"] = true;
        $processStatus["message"] = "Invalid OTP. Try again";
    }
} else{
    // Error Part
    $processStatus["error"] = true;
    $processStatus["message"] = "Improper Parameter Set";
}
mysqli_close($conn);
echo json_encode($processStatus);
?>