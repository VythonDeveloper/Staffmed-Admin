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

$mandatoryVal = isset($_POST['userId']);

if($mandatoryVal){
    $userId = getSafeValue($_POST['userId']);
    
    // Validation Part
    if($processStatus["error"] == false && isAuthorized()){
        
        $res = $conn->query("Select (Select sum(amount) from deposit where status = 'Success' and userId = '$userId') as totalDeposit, (Select sum(amount) from withdraw where status != 'Fail' and userId = '$userId') as totalWithdraw, (Select wallet from user where id = '$userId') as wallet, (Select minDeposit from signup_reward) as minDeposit, (Select minWithdraw from signup_reward) as minWithdraw");
        $row = $res->fetch_assoc();
        
        $deposit = $row['totalDeposit'];
        if($deposit == ''){
            $deposit = 0.0;
        }
        $withdraw = $row['totalWithdraw'];
        if($withdraw == ''){
            $withdraw = 0.0;
        }
        $wallet = $row['wallet'];
        if($wallet == ''){
            $wallet = 0.0;
        }
        $minDeposit = $row['minDeposit'];
        if($minDeposit == ''){
            $minDeposit = 0;
        }
        $minWithdraw = $row['minWithdraw'];
        if($minWithdraw == ''){
            $minWithdraw = 0;
        }
        
        $processStatus["error"] = false;
        $processStatus["message"] = "Fetched Money Stats";
        $processStatus["response"] = array("deposit"=> $deposit, "withdraw"=> $withdraw, "wallet"=> $wallet, "minDeposit"=> $minDeposit, "minWithdraw"=> $minWithdraw);
    } else{
        // Error Part
        $processStatus["error"] = true;
        $processStatus["message"] = "Unauthorized User. Action Denied";
    }
} else{
    // Error Part
    $processStatus["error"] = true;
    $processStatus["message"] = "Improper Paramter Set";
}

mysqli_close($conn);
echo json_encode($processStatus);
?>