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

// Create satta market
if(isset($_POST['pathAction']) && getSafeValue($_POST['pathAction']) == "Create-Satta-Market"){
    $mandatoryVal = isset($_POST["title"]) && isset($_POST["openShiftStartTime"]) && isset($_POST["openShiftEndTime"]) && isset($_POST["openShiftResultTime"]) && isset($_POST["closeShiftStartTime"]) && isset($_POST["closeShiftStartTime"]) && isset($_POST["closeShiftEndTime"]) && isset($_POST["closeShiftResultTime"]);

    if(isset($_POST['marketStatus'])){
        $_POST['marketStatus'] = 'Active';
    } else {
        $_POST['marketStatus'] = 'Inactive';
    }
    if($mandatoryVal){
        $title = getSafeValue($_POST['title']);
        $marketStatus = getSafeValue($_POST['marketStatus']);
        $openShiftStartTime = getSafeValue($_POST['openShiftStartTime']);
        $openShiftEndTime = getSafeValue($_POST['openShiftEndTime']);
        $openShiftResultTime = getSafeValue($_POST['openShiftResultTime']);
        $closeShiftStartTime = getSafeValue($_POST['closeShiftStartTime']);
        $closeShiftEndTime = getSafeValue($_POST['closeShiftEndTime']);
        $closeShiftResultTime = getSafeValue($_POST['closeShiftResultTime']);

        if($processStatus["error"] == false){
            $conn->query("Insert into satta_markets set 
            title = '$title',
            status = '$marketStatus',
            openShiftStartTime = '$openShiftStartTime',
            openShiftEndTime = '$openShiftEndTime',
            openShiftResultTime = '$openShiftResultTime',
            closeShiftStartTime = '$closeShiftStartTime',
            closeShiftEndTime = '$closeShiftEndTime',
            closeShiftResultTime = '$closeShiftResultTime',
            date = '$addedOn'
            ");

            if($conn->affected_rows > 0){
                echo "<script>alert('New Satta Market is recorded.');</script>";
            } else{
                echo "<script>alert('Something went wrong. Try again');</script>";
            }
        }     
    } else{
        // Error Part
        echo "<script>alert('All fields are required.');</script>";
    }
    mysqli_close($conn);
    header("Location:../add-market.php");
}
// ! Create satta market


// Update satta market
if(isset($_POST['pathAction']) && getSafeValue($_POST['pathAction']) == "Update-Satta-Market"){
    $mandatoryVal = isset($_POST["marketId"]) && isset($_POST["title"]) && isset($_POST["openShiftStartTime"]) && isset($_POST["openShiftEndTime"]) && isset($_POST["openShiftResultTime"]) && isset($_POST["closeShiftStartTime"]) && isset($_POST["closeShiftStartTime"]) && isset($_POST["closeShiftEndTime"]) && isset($_POST["closeShiftResultTime"]);

    if(isset($_POST['marketStatus'])){
        $_POST['marketStatus'] = 'Active';
    } else {
        $_POST['marketStatus'] = 'Inactive';
    }
    if($mandatoryVal){
        $marketId = getSafeValue($_POST['marketId']);
        $title = getSafeValue($_POST['title']);
        $marketStatus = getSafeValue($_POST['marketStatus']);
        $openShiftStartTime = getSafeValue($_POST['openShiftStartTime']);
        $openShiftEndTime = getSafeValue($_POST['openShiftEndTime']);
        $openShiftResultTime = getSafeValue($_POST['openShiftResultTime']);
        $closeShiftStartTime = getSafeValue($_POST['closeShiftStartTime']);
        $closeShiftEndTime = getSafeValue($_POST['closeShiftEndTime']);
        $closeShiftResultTime = getSafeValue($_POST['closeShiftResultTime']);

        if($processStatus["error"] == false){
            $conn->query("Update satta_markets set 
            title = '$title',
            status = '$marketStatus',
            openShiftStartTime = '$openShiftStartTime',
            openShiftEndTime = '$openShiftEndTime',
            openShiftResultTime = '$openShiftResultTime',
            closeShiftStartTime = '$closeShiftStartTime',
            closeShiftEndTime = '$closeShiftEndTime',
            closeShiftResultTime = '$closeShiftResultTime'
            where id = '$marketId'
            ");

            if($conn->affected_rows > 0){
                echo "<script>alert('Satta Market is updated.');</script>";
            } else{
                echo "<script>alert('Something went wrong. Try again');</script>";
            }
        }     
    } else{
        // Error Part
        echo "<script>alert('All fields are required.');</script>";
    }
    mysqli_close($conn);
    header("Location:../market-list.php");
}
// ! Update satta market
?>