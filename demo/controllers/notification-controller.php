<?php
include "../dbcon.php";
include "./push-notification-function.php";

function getSafeValue($value){
    global $conn;
    return strip_tags(
        mysqli_real_escape_string($conn, $value)
    );
}

$addedOn = date("Y-m-d H:i:s");

$processStatus["error"] = false;
$processStatus["message"] = "No Error";

// Push Notification
if(isset($_POST['pathAction']) && getSafeValue($_POST['pathAction']) == "Push-Notification"){
    $mandatoryVal = isset($_POST["title"]) && isset($_POST["content"]) && isset($_POST['priority']);

    if($mandatoryVal){
        $title = getSafeValue($_POST['title']);
        $content = getSafeValue($_POST['content']);
        $priority = getSafeValue($_POST['priority']);

        if($processStatus["error"] == false){
            $conn->query("Insert into notifications set
            title = '$title',
            content = '$content',
            priority = '$priority',
            date = '$addedOn'
            ");
            // Call Onesignal function
            pushNotification($title, $content);
            if($conn->affected_rows > 0){
                echo "<script>alert('Notification sent to everyone.');</script>";
            } else{
                echo "<script>alert('Something went wrong. Try again');</script>";
            }
        }     
    } else{
        // Error Part
        echo "<script>alert('All fields are required.');</script>";
    }
    mysqli_close($conn);
    header("Location:../push-notification.php");
}
// ! Push Notification

?>