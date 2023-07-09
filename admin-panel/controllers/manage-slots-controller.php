<?php
include "../../dbcon.php";
function getSafeValue($value){
    global $conn;
    return strip_tags(
        mysqli_real_escape_string($conn, $value)
    );
}

$currentDateTime = date("Y-m-d H:i:s");

$processStatus["error"] = false;
$processStatus["message"] = "No Error";

// create new slot
if(isset($_POST['pathAction']) && getSafeValue($_POST['pathAction']) == "Add-New-Slot"){

    print_r($_POST);
    $restaurantId = getSafeValue($_POST['restaurantId']);
    $slotOpenTime = getSafeValue($_POST['slotOpenTime']);
    $slotCloseTime = getSafeValue($_POST['slotCloseTime']);
    $tableCount = getSafeValue($_POST['tableCount']);
    $unitCost = getSafeValue($_POST['unitCost']);
    $slotStatus = 'Inactive';
    if(isset($_POST['slotStatus'])){
        $slotStatus = getSafeValue($_POST['slotStatus']) == "Active" ? "Active" : "Inactive";
    }

    $conn->query("Insert into restaurant_slots set 
    restaurantId = '$restaurantId',
    openSlot = '$slotOpenTime',
    closeSlot = '$slotCloseTime',
    tables = '$tableCount',
    unitCost = '$unitCost',
    status = '$slotStatus',
    date = '$currentDateTime'
    ");

    if($conn->affected_rows > 0){
        echo "<script>alert('Hurray! New slot is live.');</script>";
    } else{
        echo "<script>alert('Something went wrong. Try again');</script>";
    }
    mysqli_close($conn);
    header("Location:../manage-slots.php");
}
// ! Create new slot

// update slot
else if(isset($_POST['pathAction']) && getSafeValue($_POST['pathAction']) == "Update-Slot"){
    print_r($_POST);
    $restaurantId = getSafeValue($_POST['restaurantId']);
    $slotId = getSafeValue($_POST['slotId']);
    $slotOpenTime = getSafeValue($_POST['slotOpenTime']);
    $slotCloseTime = getSafeValue($_POST['slotCloseTime']);
    $tableCount = getSafeValue($_POST['tableCount']);
    $unitCost = getSafeValue($_POST['unitCost']);
    $slotStatus = 'Inactive';
    if(isset($_POST['slotStatus'])){
        $slotStatus = getSafeValue($_POST['slotStatus']) == "Active" ? "Active" : "Inactive";
    }

    $conn->query("Update restaurant_slots set 
    openSlot = '$slotOpenTime',
    closeSlot = '$slotCloseTime',
    tables = '$tableCount',
    unitCost = '$unitCost',
    status = '$slotStatus',
    date = '$currentDateTime'
    where restaurantId = '$restaurantId' and id = '$slotId'
    ");

    if($conn->affected_rows > 0){
        echo "<script>alert('Great! Slot is updated.');</script>";
    } else{
        echo "<script>alert('Something went wrong. Try again');</script>";
    }
    mysqli_close($conn);
    header("Location:../manage-slots.php");
}
// ! update slot

// delete slot
// else if(isset($_POST['pathAction']) && getSafeValue($_POST['pathAction']) == "Delete-Slot"){
//     print_r($_POST);
//     $restaurantId = getSafeValue($_POST['restaurantId']);
//     $slotId = getSafeValue($_POST['slotId']);
//     $slotOpenTime = getSafeValue($_POST['slotOpenTime']);
//     $slotCloseTime = getSafeValue($_POST['slotCloseTime']);
//     $tableCount = getSafeValue($_POST['tableCount']);
//     $slotStatus = 'Inactive';
//     if(isset($_POST['slotStatus'])){
//         $slotStatus = getSafeValue($_POST['slotStatus']) == "Active" ? "Active" : "Inactive";
//     }

//     $conn->query("Delete from restaurant_slots where 
//     openSlot = '$slotOpenTime' and
//     closeSlot = '$slotCloseTime' and
//     tables = '$tableCount' and
//     status = '$slotStatus' and
//     restaurantId = '$restaurantId' and 
//     id = '$slotId'
//     ");

//     if($conn->affected_rows > 0){
//         echo "<script>alert('Success! Slot is deleted.');</script>";
//     } else{
//         echo "<script>alert('Something went wrong. Try again');</script>";
//     }
//     mysqli_close($conn);
//     header("Location:../manage-slots.php");
// }
// ! delete slot
?>