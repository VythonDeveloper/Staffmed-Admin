<?php
include "../constant.inc.php";
include "../dbcon.php";

function getSafeValue($value){
	global $conn;
	return strip_tags(
		mysqli_real_escape_string($conn, $value)
	);
}

$currentDateTime= date('Y-m-d h:i:s');

if(isset($_POST['from']) && $_POST['from'] == "Upload-Gallery-Image"){
    $restaurantId = getSafeValue($_POST['restaurantId']);
    $caption = getSafeValue($_POST['caption']);

    if ($_FILES['galleryImage']['name'] !=""){
        $fname = $_FILES['galleryImage']['name'];
        
        if (round($_FILES['galleryImage']['size'] /1024 /1024, 2) > 3.00) {
            die("The file is too big. Max size is 3 mb");
        }
        if(!is_dir("./assets/")) {
            mkdir("./assets"); 
        }
        $rawBaseName = uniqid();
        $extension = pathinfo($fname, PATHINFO_EXTENSION ) != '' ? pathinfo($fname, PATHINFO_EXTENSION ) : 'jpg';
        $counter = 0;
        $fname = $rawBaseName . '.' . $extension;
        while(file_exists("./assets/".$fname)) {
            $fname = $rawBaseName . $counter . '.' . $extension;
            $counter++;
        }
    }
    if(move_uploaded_file($_FILES['galleryImage']['tmp_name'],"./assets/".$fname)){
        $fname = Base_Url."/restaurant-assets/assets/".$fname;
        
        $conn->query("Insert into restaurant_gallery set 
        restaurantId = '$restaurantId',
        image = '$fname',
        caption = '$caption'
        ");

        if($conn->affected_rows>0){
            echo json_encode(array("error" => false, "message" => "Uploaded new Gallery Image"));
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