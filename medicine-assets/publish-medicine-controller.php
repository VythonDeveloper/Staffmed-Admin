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

if(isset($_POST['from']) && $_POST['from'] == "Publish-Medicine"){
    $name = getSafeValue($_POST['name']);
    $company = getSafeValue($_POST['company']);
    $dose = getSafeValue($_POST['dose']);
    $availability = getSafeValue($_POST['availability']);
    $price = getSafeValue($_POST['price']);
    $discount = getSafeValue($_POST['discount']);

    if ($_FILES['productImg']['name'] !=""){
        $fname = $_FILES['productImg']['name'];
        
        if (round($_FILES['productImg']['size'] /1024 /1024, 2) > 3.00) {
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

    if(move_uploaded_file($_FILES['productImg']['tmp_name'],"./assets/".$fname)){
        $fname = Base_Url."/medicine-assets/assets/".$fname;

        $conn->query("Insert into medicines set 
        name = '$name',
        company = '$company',
        dose = '$dose',
        availability = '$availability',
        price = '$price',
        discount = '$discount',
        image = '$fname',
        date = '$currentDateTime'
        ");

        if($conn->affected_rows>0){
            echo json_encode(array("error" => false, "message" => "Medicine Published. Check Listings"));
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