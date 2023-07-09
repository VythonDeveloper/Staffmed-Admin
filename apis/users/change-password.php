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
    $res = $conn->query("Select * from user where tokenId = '$tokenId' and tokenId != ''");
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

$mandatoryVal = isset($_POST["userId"]) && isset($_POST["currentPassword"]) && isset($_POST["newPassword"]);

if($mandatoryVal){
    $userId = getSafeValue($_POST['userId']);
    $currentPassword = md5(getSafeValue($_POST['currentPassword']));
    $newPassword = md5(getSafeValue($_POST['newPassword']));

    // Validation Part
    if($processStatus["error"] == false){
        
        $res = $conn->query("Select * from user where id = '$userId' and tokenId = '$tokenId'");
        if($res->num_rows > 0){
            $row = $res->fetch_assoc();
            if($currentPassword == $row['password']){
                $conn->query("Update user set password = '$newPassword' where id = '$userId' and tokenId = '$tokenId'");
                if($conn->affected_rows > 0){
                    $processStatus["error"] = false;
                    $processStatus["message"] = "Password Changed. Please login for security purpose.";
                } else{
                    $processStatus["error"] = true;
                    $processStatus["message"] = "Something went wrong";
                }
            } else{
                // Error Part
                $processStatus["error"] = true;
                $processStatus["message"] = "Invalid Current Password";
            }
        } else{
            // Error Part
            $processStatus["error"] = true;
            $processStatus["message"] = "No such account.";
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