<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST");

$processStatus["error"] = false;
$processStatus["message"] = "No Error";

$mandatoryVal = isset($_FILES['prescriptionsImgs']) && !empty($_FILES['prescriptionsImgs']['name'][0]);

if ($mandatoryVal) {
    $prescriptionsImgs = $_FILES["prescriptionsImgs"];
    $totalImages = count($prescriptionsImgs["name"]);

    for ($i = 0; $i < $totalImages; $i++) {
        $communityImageName = $prescriptionsImgs["name"][$i];

        // Validation Part

        // Exit if no file uploaded
        if ($processStatus["error"] == false && empty($communityImageName)) {
            $processStatus["error"] = true;
            $processStatus["message"] = "One or more images are missing";
            break;
        }

        // Exit if image file is zero bytes
        if ($processStatus["error"] == false && filesize($prescriptionsImgs["tmp_name"][$i]) <= 0) {
            $processStatus["error"] = true;
            $processStatus["message"] = "Uploaded file has no contents";
            break;
        }

        // Exit if the file is not a valid image
        if ($processStatus["error"] == false) {
            $image_type = getimagesize($prescriptionsImgs["tmp_name"][$i])[2];
            if (!$image_type) {
                $processStatus["error"] = true;
                $processStatus["message"] = "One or more files are not images";
                break;
            }
        }

        // Exit if the file size is greater than 3 mb
        if ($processStatus["error"] == false && round($prescriptionsImgs['size'][$i] / 1024 / 1024, 2) > 3.00) {
            $processStatus["error"] = true;
            $processStatus["message"] = "Upload images less than 3 mb";
            break;
        }
    }

    if ($processStatus["error"] == false) {
        if (!is_dir("./prescriptions/")) {
            mkdir("./prescriptions");
        }

        $uploadedImages = [];

        for ($i = 0; $i < $totalImages; $i++) {
            $communityImageName = $prescriptionsImgs["name"][$i];
            $rawBaseName = uniqid();
            $extension = pathinfo($communityImageName, PATHINFO_EXTENSION) != '' ? pathinfo($communityImageName, PATHINFO_EXTENSION) : 'jpg';
            $counter = 0;
            $communityImageName = $rawBaseName . '.' . $extension;
            while (file_exists("./prescriptions/" . $communityImageName)) {
                $communityImageName = $rawBaseName . $counter . '.' . $extension;
                $counter++;
            }

            if (move_uploaded_file($prescriptionsImgs['tmp_name'][$i], "./prescriptions/" . $communityImageName)) {
                $protocol = ((!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off') || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
                $CurDirURL = $protocol . $_SERVER['HTTP_HOST'];
                $communityImageUrl = "https://indiatvonline.in/staffmed/medicine-assets/prescriptions/" . $communityImageName;
                $uploadedImages[] = $communityImageUrl;
            } else {
                $processStatus["error"] = true;
                $processStatus["message"] = "Error while uploading images.";
                break;
            }
        }

        if (!$processStatus["error"]) {
            $processStatus["message"] = "Images Uploaded";
            $processStatus["imageLinks"] = $uploadedImages;
        }
    }
} else {
    // Error Part
    $processStatus["error"] = true;
    $processStatus["message"] = "Improper Parameter Set";
}

echo json_encode($processStatus);
?>
