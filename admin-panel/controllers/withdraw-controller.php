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

// Approve Withdraw
if(isset($_POST['pathAction']) && getSafeValue($_POST['pathAction']) == "Approve-Withdraw-Record"){
    $orderId = getSafeValue($_POST['orderId']);
    $conn->query("Update passbook set status = 'Success' where orderId = '$orderId'");
    if($conn->affected_rows > 0){
        echo "<script>alert('Withdraw Request Approved.');</script>";
    }
    header("Location:../manage-withdraws.php");
}
// ! Approve Withdraw

// Reject Withdraw
else if(isset($_POST['pathAction']) && getSafeValue($_POST['pathAction']) == "Reject-Withdraw-Record"){
    $orderId = getSafeValue($_POST['orderId']);
    $wiRes = $conn->query("Select userId, amount from passbook where status = 'Pending' and orderId = '$orderId'");
    if($wiRes->num_rows > 0){
        $wiRow = $wiRes->fetch_assoc();
        $refundAmount = $wiRow['amount'];
        $userId = $wiRow['userId'];
        $conn->query("Update user set wallet = wallet - $refundAmount where id = '$userId'");
        if($conn->affected_rows > 0){
            $conn->query("Update passbook set status = 'Failed' where orderId = '$orderId'");
            echo "<script>alert('Withdraw Request Rejected.');</script>";
        }
    }
    header("Location:../manage-withdraws.php");
}
// ! Reject Withdraw
?>