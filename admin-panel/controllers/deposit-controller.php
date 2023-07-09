<?php
include "../dbcon.php";
function getSafeValue($value){
    global $conn;
    return strip_tags(
        mysqli_real_escape_string($conn, $value)
    );
}

$addedOn = date("Y-m-d H:i:s");

$processStatus["error"] = false;
$processStatus["message"] = "No Error";

// Manage App APK
if(isset($_POST['pathAction']) && getSafeValue($_POST['pathAction']) == "Deposit-Wallet-Amount"){
    $mandatoryVal = isset($_POST["beneficiaryId"]) && isset($_POST["depositAmount"]);

    if($mandatoryVal){
        $beneficiaryId = getSafeValue($_POST['beneficiaryId']);
        $depositAmount = getSafeValue($_POST['depositAmount']);

        if($processStatus["error"] == false){
            $conn->query("Update user set wallet = wallet + $depositAmount 
            where id = '$beneficiaryId' and wallet + $depositAmount >= 0");

            if($conn->affected_rows > 0){
                $orderId = "DP-".substr(str_shuffle(str_repeat($x = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ', ceil(24 / strlen($x)))), 1, 24);
                $conn->query("Insert into passbook set
                orderId = '$orderId',
                userId = '$beneficiaryId',
                title = 'Deposited to wallet',
                amount = '$depositAmount',
                bankDetails = '',
                data = '',
                status = 'Success',
                date = '$addedOn',
                txnType = 'Deposit'
                ");
                if($conn->affected_rows > 0){
                    echo "<script>alert('Deposit Amount adjusted');</script>";
                }  else{
                    echo "<script>alert('Something went wrong. Try again');</script>";
                }
            } else{
                echo "<script>alert('No such user. Please check');</script>";
            }
        }     
    } else{
        // Error Part
        echo "<script>alert('All fields are required.');</script>";
    }
    mysqli_close($conn);
    header("Location:../manage-users.php");
}
// ! Create satta market

?>