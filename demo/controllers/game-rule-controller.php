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

// Update-Game-rule
if(isset($_POST['pathAction']) && getSafeValue($_POST['pathAction']) == "Update-Game-Rules"){
    $mandatoryVal = isset($_POST["gameRuleContent"]);

    if($mandatoryVal){
        $gameRuleContent = $_POST['gameRuleContent'];

        if($processStatus["error"] == false){
            $conn->query("Update game_rule set 
            ruleContent = '$gameRuleContent',
            date = '$addedOn'
            where id = '1'
            ");

            if($conn->affected_rows > 0){
                echo "Updated Game Rules";
            } else{
                echo "Something went wrong. Try again";
            }
        }     
    } else{
        // Error Part
        echo "All fields are required.";
    }
    mysqli_close($conn);
}
// ! Update-Game-rule
?>