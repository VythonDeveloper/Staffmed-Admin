<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST");
include "../dbcon.php";
$currentDateTime = date("Y-m-d H:i:s");

function getSafeValue($value) {
    global $conn;
    return strip_tags(mysqli_real_escape_string($conn, $value));
}
    
$processStatus["error"] = false;
$processStatus["message"] = "No Error";
        
$mandatoryVal = isset($_POST["fullname"]) && isset($_POST["phone"]) && isset($_POST["email"]) && isset($_POST["password"]);
if ($mandatoryVal) {
    $fullname = getSafeValue($_POST["fullname"]);
    $phone = getSafeValue($_POST["phone"]);
    $email = getSafeValue($_POST["email"]);
    $password = md5(getSafeValue($_POST["password"]));

    // Validation Part
    if ($processStatus["error"] == false && strlen($phone) != 10) {
        // Error Part
        $processStatus["error"] = true;
        $processStatus["message"] = "Sent Invalid Data. Please check.";
    }

    if ($processStatus["error"] == false) {
        // checking whether the phone number already exist or not
        $res = $conn->query("Select * from users where phone = '$phone'");
        if ($res->num_rows == 0) {
            $conn->query("Insert into users set
            fullname = '$fullname',
            phone = '$phone',
            email = '$email',
            password = '$password',
            status = 'Active',
            tokenId = '',
            date = '$currentDateTime'
            ");
            if ($conn->affected_rows > 0) {
                $processStatus["error"] = false;
                $processStatus["message"] = "Registered successfully.";
            } else {
                $processStatus["error"] = true;
                $processStatus["message"] = "Something went wrong.";
            }
        } else {
            $processStatus["error"] = true;
            $processStatus["message"] = "Given Phone number already exist. Please Login";
        }
    }
} else {
    // Error Part
    $processStatus["error"] = true;
    $processStatus["message"] = "Improper Parameter Set";
}
mysqli_close($conn);
echo json_encode($processStatus);
?>
