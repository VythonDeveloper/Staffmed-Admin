<?php
include "../dbcon.php";
function getSafeValue($value){
    global $conn;
    return strip_tags(
        mysqli_real_escape_string($conn, $value)
    );
}

$currentDateTime = date("Y-m-d H:i:s");

$processStatus["error"] = false;
$processStatus["message"] = "No Error";

if(isset($_POST['from']) && $_POST['from'] == "Update-Restaurant-Content"){
    $restaurantId = getSafeValue($_POST['restaurantId']);
    $oldCoverImage = getSafeValue($_POST['oldCoverImage']);
    $name = getSafeValue($_POST['name']);
    $executiveName = getSafeValue($_POST['executiveName']);
    $description = getSafeValue($_POST['description']);
    $email = getSafeValue($_POST['email']);
    $openTime = getSafeValue($_POST['openTime']);
    $closeTime = getSafeValue($_POST['closeTime']);
    $address = getSafeValue($_POST['address']);
    $isImageAttached = getSafeValue($_POST['isImageAttached']);

    if($isImageAttached == "Yes"){
        if ($_FILES['coverImage']['name'] !=""){
            $fname = $_FILES['coverImage']['name'];
            
            if (round($_FILES['coverImage']['size'] /1024 /1024, 2) > 3.00) {
                die("The file is too big. Max size is 3 mb");
            }
            if(!is_dir("../bt/img/restaurant/")) {
                mkdir("../bt/img/restaurant"); 
            }
            $rawBaseName = uniqid();
            $extension = pathinfo($fname, PATHINFO_EXTENSION ) != '' ? pathinfo($fname, PATHINFO_EXTENSION ) : 'jpg';
            $counter = 0;
            $fname = $rawBaseName . '.' . $extension;
            while(file_exists("../bt/img/restaurant/".$fname)) {
                $fname = $rawBaseName . $counter . '.' . $extension;
                $counter++;
            }
        }

        if(move_uploaded_file($_FILES['coverImage']['tmp_name'],"../bt/img/restaurant/".$fname)){
            $goodToGo = true;
            $fname = "http://bookmytable.org/bt/img/restaurant/".$fname;
        }

    } else{
        $goodToGo = true;
        $fname = $oldCoverImage;
    }
    
    if($goodToGo){
        $conn->query("Update restaurants set 
        	name = '$name',
        	executiveName = '$executiveName',
        	description = '$description',
        	email = '$email',
        	openTime = '$openTime',
        	closeTime = '$closeTime',
        	address = '$address',
            coverImage = '$fname'
            where id = '$restaurantId'
        	");
        if($conn->affected_rows>0){
            echo json_encode(array("error" => false, "message" => "Content updated"));
        }
        else{
            echo json_encode(array("error" => true, "message" => "Database Query Error."));
        }
    } 
    else{
        echo json_encode(array("error" => true, "message" => "Something went wrong"));
    }
}
?>