<?php
include "../dbcon.php";
include "./push-notification-function.php";
include "./game-rate-constants.inc.php";

$addedOn = date("Y-m-d H:i:s");

function getSafeValue($value){
    global $conn;
    return strip_tags(
        mysqli_real_escape_string($conn, $value)
    );
}

function manageWinnersFunction($marketId, $marketName){
    global $conn;
    global $marketDate;
    global $addedOn;

    $bidResultRes = $conn->query("Select * from bid_results where marketId = '$marketId' and date = '$marketDate'");
    if($bidResultRes->num_rows > 0){
        $bidResultData = $bidResultRes->fetch_assoc();

// ------------------------SINGLE ANK BID RESULT -------------------------------------------------        
        
        echo "Single Ank Game"."<br>";
        $singleAnkRes = $conn->query("Select * from single_ank_bids where marketId = '$marketId' and marketDate = '$marketDate' and status = 'Pending'");
        if($singleAnkRes->num_rows > 0){
            
            while($singleAnkRow = $singleAnkRes->fetch_assoc()){

                echo "Userid: ".$singleAnkRow['userId']."<br>";
                echo "Ank: ".$singleAnkRow['ank']."<br>";
                echo "Type: ".$singleAnkRow['type']."<br>";
                echo "Points: ".$singleAnkRow['points']."<br>";

                if($singleAnkRow['type'] == "Open" && $bidResultData['jodiScore'][0] != 'X'){

                    if($singleAnkRow['ank'] == $bidResultData['jodiScore'][0]){

                        $prizeMoney = ($singleAnkRow['points'] * SARate);
                        echo "Reward: ".$prizeMoney;
                        echo "Open Wins"."<br>";
                        $recordId = $singleAnkRow['id'];
                        $playerId = $singleAnkRow['userId'];

                        // make status as win in single ank record
                        $conn->query("Update single_ank_bids set status = 'Won' where userId = '$playerId' and marketDate = '$marketDate' and marketId = '$marketId' and id = '$recordId'");

                        // credit reward amont in users wallet
                        $conn->query("Update user set wallet = wallet + $prizeMoney where id = '$playerId'");

                        // keep in passbook for track
                        $orderId = "WN-".substr(str_shuffle(str_repeat($x = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ', ceil(24 / strlen($x)))), 1, 24);
                        $conn->query("Insert into passbook set
                        orderId = '$orderId',
                        userId = '$playerId',
                        title = 'Reward from ".$marketName." Single Ank',
                        amount = '$prizeMoney',
                        bankDetails = '',
                        data = '',
                        status = 'Success',
                        date = '$addedOn',
                        txnType = 'Income'
                        ");

                    } else{
                        echo "Open Lost"."<br>";
                        $recordId = $singleAnkRow['id'];
                        $playerId = $singleAnkRow['userId'];
                        // make status as lost in single ank record
                        $conn->query("Update single_ank_bids set status = 'Lost' where userId = '$playerId' and marketDate = '$marketDate' and marketId = '$marketId' and id = '$recordId'");
                    }

                } else if($singleAnkRow['type'] == "Close" && $bidResultData['jodiScore'][1] != 'X'){
                    
                    if($singleAnkRow['ank'] == $bidResultData['jodiScore'][1]){
                        
                        $prizeMoney = ($singleAnkRow['points'] * SARate);
                        echo "Reward: ".$prizeMoney."<br>";
                        echo "Close Wins"."<br>";
                        $recordId = $singleAnkRow['id'];
                        $playerId = $singleAnkRow['userId'];

                        // make status as win in single ank record
                        $conn->query("Update single_ank_bids set status = 'Won' where userId = '$playerId' and marketDate = '$marketDate' and marketId = '$marketId' and id = '$recordId'");

                        // credit reward amont in users wallet
                        $conn->query("Update user set wallet = wallet + $prizeMoney where id = '$playerId'");

                        // keep in passbook for track
                        $orderId = "WN-".substr(str_shuffle(str_repeat($x = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ', ceil(24 / strlen($x)))), 1, 24);
                        $conn->query("Insert into passbook set
                        orderId = '$orderId',
                        userId = '$playerId',
                        title = 'Reward from ".$marketName." Single Ank',
                        amount = '$prizeMoney',
                        bankDetails = '',
                        data = '',
                        status = 'Success',
                        date = '$addedOn',
                        txnType = 'Income'
                        ");

                    } else{
                        echo "Open Lost"."<br>";
                        $recordId = $singleAnkRow['id'];
                        $playerId = $singleAnkRow['userId'];
                        // make status as lost in single ank record
                        $conn->query("Update single_ank_bids set status = 'Lost' where userId = '$playerId' and marketDate = '$marketDate' and marketId = '$marketId' and id = '$recordId'");
                    }

                } else{
                    echo "Result not declared for either of the type."."<br>";
                }
            }
        } else{
            echo "No one played the game or result declared"."<br>";
        }

// ------------------------JODI BID RESULT ----------------------------------------------------------

        echo "Jodi Game"."<br>";
        if($bidResultData['jodiScore'][0] != 'X' && $bidResultData['jodiScore'][1] != 'X'){

            $jodiRes = $conn->query("Select * from jodi_bids where marketId = '$marketId' and marketDate = '$marketDate' and status = 'Pending'");
            if($jodiRes->num_rows > 0){

                while($jodiRow = $jodiRes->fetch_assoc()){
                    echo "Userid: ".$jodiRow['userId']."<br>";
                    echo "Jodi: ".$jodiRow['jodi']."<br>";
                    echo "Points: ".$jodiRow['points']."<br>";

                    if($jodiRow['jodi'] == $bidResultData['jodiScore']){
                        $prizeMoney = ($jodiRow['points'] * JRate);

                        echo "Reward: ".$prizeMoney."<br>";
                        echo "Jodi Wins"."<br>";
                        $recordId = $jodiRow['id'];
                        $playerId = $jodiRow['userId'];

                        // make status as win in jodi record
                        $conn->query("Update jodi_bids set status = 'Won' where userId = '$playerId' and marketDate = '$marketDate' and marketId = '$marketId' and id = '$recordId'");

                        // credit reward amont in users wallet
                        $conn->query("Update user set wallet = wallet + $prizeMoney where id = '$playerId'");

                        // keep in passbook for track
                        $orderId = "WN-".substr(str_shuffle(str_repeat($x = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ', ceil(24 / strlen($x)))), 1, 24);
                        $conn->query("Insert into passbook set
                        orderId = '$orderId',
                        userId = '$playerId',
                        title = 'Reward from ".$marketName." Jodi',
                        amount = '$prizeMoney',
                        bankDetails = '',
                        data = '',
                        status = 'Success',
                        date = '$addedOn',
                        txnType = 'Income'
                        ");

                    } else{
                        echo "Jodi Lost"."<br>";
                        $recordId = $jodiRow['id'];
                        $playerId = $jodiRow['userId'];
                        // make status as lost in jodi record
                        $conn->query("Update jodi_bids set status = 'Lost' where userId = '$playerId' and marketDate = '$marketDate' and marketId = '$marketId' and id = '$recordId'");
                    }
                }

            } else{
                echo "No one played the game or result declared"."<br>";
            }
            
        } else{
            echo "Full Result not declared yet"."<br>";
        }

// ------------------------SINGLE PATTI BID RESULT --------------------------------------------------

        echo "Single Patti Game"."<br>";

        $singlePattiRes = $conn->query("Select * from single_patti_bids where marketId = '$marketId' and marketDate = '$marketDate' and status = 'Pending'");
        if($singlePattiRes->num_rows > 0){

            while($singlePattiRow = $singlePattiRes->fetch_assoc()){
                echo "Userid: ".$singlePattiRow['userId']."<br>";
                echo "Panna: ".$singlePattiRow['panna']."<br>";
                echo "Type: ".$singlePattiRow['type']."<br>";
                echo "Points: ".$singlePattiRow['points']."<br>";

                if($singlePattiRow['type'] == "Open" && $bidResultData['openScore'][0] != 'X' && $bidResultData['openScore'][1] != 'X' && $bidResultData['openScore'][2] != 'X'){

                    if($singlePattiRow['panna'] == $bidResultData['openScore']){

                        $prizeMoney = ($singlePattiRow['points'] * SPRate);
                        echo "Open Win"."<br>";
                        echo "Reward: ".$prizeMoney."<br>";
                        $playerId = $singlePattiRow['userId'];
                        $recordId = $singlePattiRow['id'];

                        // make status as win in single patti record
                        $conn->query("Update single_patti_bids set status = 'Won' where userId = '$playerId' and marketDate = '$marketDate' and marketId = '$marketId' and id = '$recordId'");

                        // credit reward amont in users wallet
                        $conn->query("Update user set wallet = wallet + $prizeMoney where id = '$playerId'");

                        // keep in passbook for track
                        $orderId = "WN-".substr(str_shuffle(str_repeat($x = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ', ceil(24 / strlen($x)))), 1, 24);
                        $conn->query("Insert into passbook set
                        orderId = '$orderId',
                        userId = '$playerId',
                        title = 'Reward from ".$marketName." Single Patti',
                        amount = '$prizeMoney',
                        bankDetails = '',
                        data = '',
                        status = 'Success',
                        date = '$addedOn',
                        txnType = 'Income'
                        ");

                    } else{
                        echo "Open Lost"."<br>";
                        $recordId = $singlePattiRow['id'];
                        $playerId = $singlePattiRow['userId'];
                        // make status as lost in single patti record
                        $conn->query("Update single_patti_bids set status = 'Lost' where userId = '$playerId' and marketDate = '$marketDate' and marketId = '$marketId' and id = '$recordId'");
                    }
                } else if($singlePattiRow['type'] == "Close" && $bidResultData['closeScore'][0] != 'X' && $bidResultData['closeScore'][1] != 'X' && $bidResultData['closeScore'][2] != 'X'){

                    if($singlePattiRow['panna'] == $bidResultData['closeScore']){

                        $prizeMoney = ($singlePattiRow['points'] * SPRate);
                        echo "Close Win"."<br>";
                        echo "Reward: ".$prizeMoney."<br>";
                        $playerId = $singlePattiRow['userId'];
                        $recordId = $singlePattiRow['id'];

                        // make status as win in single patti record
                        $conn->query("Update single_patti_bids set status = 'Won' where userId = '$playerId' and marketDate = '$marketDate' and marketId = '$marketId' and id = '$recordId'");

                        // credit reward amont in users wallet
                        $conn->query("Update user set wallet = wallet + $prizeMoney where id = '$playerId'");

                        // keep in passbook for track
                        $orderId = "WN-".substr(str_shuffle(str_repeat($x = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ', ceil(24 / strlen($x)))), 1, 24);
                        $conn->query("Insert into passbook set
                        orderId = '$orderId',
                        userId = '$playerId',
                        title = 'Reward from ".$marketName." Single Patti',
                        amount = '$prizeMoney',
                        bankDetails = '',
                        data = '',
                        status = 'Success',
                        date = '$addedOn',
                        txnType = 'Income'
                        ");

                    } else{
                        echo "Close Lost"."<br>";
                        $recordId = $singlePattiRow['id'];
                        $playerId = $singlePattiRow['userId'];
                        // make status as lost in single patti record
                        $conn->query("Update single_patti_bids set status = 'Lost' where userId = '$playerId' and marketDate = '$marketDate' and marketId = '$marketId' and id = '$recordId'");
                    }

                } else{
                    echo "Result not declared for either of the type."."<br>";
                }

            }

        } else{
            echo "No one played the game or result declared"."<br>";
        }

// ------------------------DOUBLE PATTI BID RESULT --------------------------------------------------
        
        echo "Double Patti Game"."<br>";

        $doublePattiRes = $conn->query("Select * from double_patti_bids where marketId = '$marketId' and marketDate = '$marketDate' and status = 'Pending'");
        if($doublePattiRes->num_rows > 0){

            while($doublePattiRow = $doublePattiRes->fetch_assoc()){
                echo "Userid: ".$doublePattiRow['userId']."<br>";
                echo "Panna: ".$doublePattiRow['panna']."<br>";
                echo "Type: ".$doublePattiRow['type']."<br>";
                echo "Points: ".$doublePattiRow['points']."<br>";

                if($doublePattiRow['type'] == "Open" && $bidResultData['openScore'][0] != 'X' && $bidResultData['openScore'][1] != 'X' && $bidResultData['openScore'][2] != 'X'){

                    if($doublePattiRow['panna'] == $bidResultData['openScore']){

                        $prizeMoney = ($doublePattiRow['points'] * DuPRate);
                        echo "Open Win"."<br>";
                        echo "Reward: ".$prizeMoney."<br>";
                        $playerId = $doublePattiRow['userId'];
                        $recordId = $doublePattiRow['id'];

                        // make status as win in double patti record
                        $conn->query("Update double_patti_bids set status = 'Won' where userId = '$playerId' and marketDate = '$marketDate' and marketId = '$marketId' and id = '$recordId'");

                        // credit reward amont in users wallet
                        $conn->query("Update user set wallet = wallet + $prizeMoney where id = '$playerId'");

                        // keep in passbook for track
                        $orderId = "WN-".substr(str_shuffle(str_repeat($x = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ', ceil(24 / strlen($x)))), 1, 24);
                        $conn->query("Insert into passbook set
                        orderId = '$orderId',
                        userId = '$playerId',
                        title = 'Reward from ".$marketName." Double Patti',
                        amount = '$prizeMoney',
                        bankDetails = '',
                        data = '',
                        status = 'Success',
                        date = '$addedOn',
                        txnType = 'Income'
                        ");

                    } else{
                        echo "Open Lost"."<br>";
                        $recordId = $doublePattiRow['id'];
                        $playerId = $doublePattiRow['userId'];
                        // make status as lost in double patti record
                        $conn->query("Update double_patti_bids set status = 'Lost' where userId = '$playerId' and marketDate = '$marketDate' and marketId = '$marketId' and id = '$recordId'");
                    }
                } else if($doublePattiRow['type'] == "Close" && $bidResultData['closeScore'][0] != 'X' && $bidResultData['closeScore'][1] != 'X' && $bidResultData['closeScore'][2] != 'X'){

                    if($doublePattiRow['panna'] == $bidResultData['closeScore']){

                        $prizeMoney = ($doublePattiRow['points'] * DuPRate);
                        echo "Close Win"."<br>";
                        echo "Reward: ".$prizeMoney."<br>";
                        $playerId = $doublePattiRow['userId'];
                        $recordId = $doublePattiRow['id'];

                        // make status as win in double patti record
                        $conn->query("Update double_patti_bids set status = 'Won' where userId = '$playerId' and marketDate = '$marketDate' and marketId = '$marketId' and id = '$recordId'");

                        // credit reward amont in users wallet
                        $conn->query("Update user set wallet = wallet + $prizeMoney where id = '$playerId'");

                        // keep in passbook for track
                        $orderId = "WN-".substr(str_shuffle(str_repeat($x = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ', ceil(24 / strlen($x)))), 1, 24);
                        $conn->query("Insert into passbook set
                        orderId = '$orderId',
                        userId = '$playerId',
                        title = 'Reward from ".$marketName." Double Patti',
                        amount = '$prizeMoney',
                        bankDetails = '',
                        data = '',
                        status = 'Success',
                        date = '$addedOn',
                        txnType = 'Income'
                        ");

                    } else{
                        echo "Close Lost"."<br>";
                        $recordId = $doublePattiRow['id'];
                        $playerId = $doublePattiRow['userId'];
                        // make status as lost in double patti record
                        $conn->query("Update double_patti_bids set status = 'Lost' where userId = '$playerId' and marketDate = '$marketDate' and marketId = '$marketId' and id = '$recordId'");
                    }

                } else{
                    echo "Result not declared for either of the type."."<br>";
                }

            }

        } else{
            echo "No one played the game or result declared"."<br>";
        }

// ------------------------TRIPLE PATTI BID RESULT --------------------------------------------------

        echo "Triple Patti Game"."<br>";

        $triplePattiRes = $conn->query("Select * from triple_patti_bids where marketId = '$marketId' and marketDate = '$marketDate' and status = 'Pending'");
        if($triplePattiRes->num_rows > 0){

            while($triplePattiRow = $triplePattiRes->fetch_assoc()){
                echo "Userid: ".$triplePattiRow['userId']."<br>";
                echo "Panna: ".$triplePattiRow['panna']."<br>";
                echo "Type: ".$triplePattiRow['type']."<br>";
                echo "Points: ".$triplePattiRow['points']."<br>";

                if($triplePattiRow['type'] == "Open" && $bidResultData['openScore'][0] != 'X' && $bidResultData['openScore'][1] != 'X' && $bidResultData['openScore'][2] != 'X'){

                    if($triplePattiRow['panna'] == $bidResultData['openScore']){

                        $prizeMoney = ($triplePattiRow['points'] * TrPRate);
                        echo "Open Win"."<br>";
                        echo "Reward: ".$prizeMoney."<br>";
                        $playerId = $triplePattiRow['userId'];
                        $recordId = $triplePattiRow['id'];

                        // make status as win in triple patti record
                        $conn->query("Update triple_patti_bids set status = 'Won' where userId = '$playerId' and marketDate = '$marketDate' and marketId = '$marketId' and id = '$recordId'");

                        // credit reward amont in users wallet
                        $conn->query("Update user set wallet = wallet + $prizeMoney where id = '$playerId'");

                        // keep in passbook for track
                        $orderId = "WN-".substr(str_shuffle(str_repeat($x = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ', ceil(24 / strlen($x)))), 1, 24);
                        $conn->query("Insert into passbook set
                        orderId = '$orderId',
                        userId = '$playerId',
                        title = 'Reward from ".$marketName." Triple Patti',
                        amount = '$prizeMoney',
                        bankDetails = '',
                        data = '',
                        status = 'Success',
                        date = '$addedOn',
                        txnType = 'Income'
                        ");

                    } else{
                        echo "Open Lost"."<br>";
                        $recordId = $triplePattiRow['id'];
                        $playerId = $triplePattiRow['userId'];
                        // make status as lost in triple patti record
                        $conn->query("Update triple_patti_bids set status = 'Lost' where userId = '$playerId' and marketDate = '$marketDate' and marketId = '$marketId' and id = '$recordId'");
                    }
                } else if($triplePattiRow['type'] == "Close" && $bidResultData['closeScore'][0] != 'X' && $bidResultData['closeScore'][1] != 'X' && $bidResultData['closeScore'][2] != 'X'){

                    if($triplePattiRow['panna'] == $bidResultData['closeScore']){

                        $prizeMoney = ($triplePattiRow['points'] * TrPRate);
                        echo "Close Win"."<br>";
                        echo "Reward: ".$prizeMoney."<br>";
                        $playerId = $triplePattiRow['userId'];
                        $recordId = $triplePattiRow['id'];

                        // make status as win in triple patti record
                        $conn->query("Update triple_patti_bids set status = 'Won' where userId = '$playerId' and marketDate = '$marketDate' and marketId = '$marketId' and id = '$recordId'");

                        // credit reward amont in users wallet
                        $conn->query("Update user set wallet = wallet + $prizeMoney where id = '$playerId'");

                        // keep in passbook for track
                        $orderId = "WN-".substr(str_shuffle(str_repeat($x = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ', ceil(24 / strlen($x)))), 1, 24);
                        $conn->query("Insert into passbook set
                        orderId = '$orderId',
                        userId = '$playerId',
                        title = 'Reward from ".$marketName." Triple Patti',
                        amount = '$prizeMoney',
                        bankDetails = '',
                        data = '',
                        status = 'Success',
                        date = '$addedOn',
                        txnType = 'Income'
                        ");

                    } else{
                        echo "Close Lost"."<br>";
                        $recordId = $triplePattiRow['id'];
                        $playerId = $triplePattiRow['userId'];
                        // make status as lost in triple patti record
                        $conn->query("Update triple_patti_bids set status = 'Lost' where userId = '$playerId' and marketDate = '$marketDate' and marketId = '$marketId' and id = '$recordId'");
                    }

                } else{
                    echo "Result not declared for either of the type."."<br>";
                }

            }

        } else{
            echo "No one played the game or result declared"."<br>";
        }

// ------------------------HALF SANGAM BID RESULT --------------------------------------------------

        echo "Half Sangam Game"."<br>";

        $halfSangamRes = $conn->query("Select * from half_sangam_bids where marketId = '$marketId' and marketDate = '$marketDate' and status = 'Pending'");
        if($halfSangamRes->num_rows > 0){

            while($halfSangamRow = $halfSangamRes->fetch_assoc()){
                echo "Userid: ".$halfSangamRow['userId']."<br>";
                echo "Ank: ".$halfSangamRow['ank']."<br>";
                echo "Panna: ".$halfSangamRow['panna']."<br>";
                echo "Type: ".$halfSangamRow['type']."<br>";
                echo "Points: ".$halfSangamRow['points']."<br>";

                if($halfSangamRow['type'] == "OACP" && $bidResultData['jodiScore'][0] != 'X' && $bidResultData['closeScore'][0] != 'X' && $bidResultData['closeScore'][1] != 'X' && $bidResultData['closeScore'][2] != 'X'){

                    if($halfSangamRow['ank'] == $bidResultData['jodiScore'][0] && $halfSangamRow['panna'] == $bidResultData['closeScore']){

                        $prizeMoney = ($halfSangamRow['points'] * HlSangRate);
                        echo "OACP Win"."<br>";
                        echo "Reward: ".$prizeMoney."<br>";
                        $playerId = $halfSangamRow['userId'];
                        $recordId = $halfSangamRow['id'];

                        // make status as win in half sangam record
                        $conn->query("Update half_sangam_bids set status = 'Won' where userId = '$playerId' and marketDate = '$marketDate' and marketId = '$marketId' and id = '$recordId'");

                        // credit reward amont in users wallet
                        $conn->query("Update user set wallet = wallet + $prizeMoney where id = '$playerId'");

                        // keep in passbook for track
                        $orderId = "WN-".substr(str_shuffle(str_repeat($x = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ', ceil(24 / strlen($x)))), 1, 24);
                        $conn->query("Insert into passbook set
                        orderId = '$orderId',
                        userId = '$playerId',
                        title = 'Reward from ".$marketName." Half Sangam',
                        amount = '$prizeMoney',
                        bankDetails = '',
                        data = '',
                        status = 'Success',
                        date = '$addedOn',
                        txnType = 'Income'
                        ");

                    } else{
                        echo "OACP Lost"."<br>";
                        $recordId = $halfSangamRow['id'];
                        $playerId = $halfSangamRow['userId'];
                        // make status as lost in half sangam record
                        $conn->query("Update half_sangam_bids set status = 'Lost' where userId = '$playerId' and marketDate = '$marketDate' and marketId = '$marketId' and id = '$recordId'");
                    }
                } else if($halfSangamRow['type'] == "CAOP" && $bidResultData['jodiScore'][1] != 'X' && $bidResultData['openScore'][0] != 'X' && $bidResultData['openScore'][1] != 'X' && $bidResultData['openScore'][2] != 'X'){

                    if($halfSangamRow['ank'] == $bidResultData['jodiScore'][0] && $halfSangamRow['panna'] == $bidResultData['openScore']){

                        $prizeMoney = ($halfSangamRow['points'] * HlSangRate);
                        echo "CAOP Win"."<br>";
                        echo "Reward: ".$prizeMoney."<br>";
                        $playerId = $halfSangamRow['userId'];
                        $recordId = $halfSangamRow['id'];

                        // make status as win in half sangam record
                        $conn->query("Update half_sangam_bids set status = 'Won' where userId = '$playerId' and marketDate = '$marketDate' and marketId = '$marketId' and id = '$recordId'");

                        // credit reward amont in users wallet
                        $conn->query("Update user set wallet = wallet + $prizeMoney where id = '$playerId'");

                        // keep in passbook for track
                        $orderId = "WN-".substr(str_shuffle(str_repeat($x = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ', ceil(24 / strlen($x)))), 1, 24);
                        $conn->query("Insert into passbook set
                        orderId = '$orderId',
                        userId = '$playerId',
                        title = 'Reward from ".$marketName." Half Sangam',
                        amount = '$prizeMoney',
                        bankDetails = '',
                        data = '',
                        status = 'Success',
                        date = '$addedOn',
                        txnType = 'Income'
                        ");

                    } else{
                        echo "CAOP Lost"."<br>";
                        $recordId = $halfSangamRow['id'];
                        $playerId = $halfSangamRow['userId'];
                        // make status as lost in half sangam record
                        $conn->query("Update half_sangam_bids set status = 'Lost' where userId = '$playerId' and marketDate = '$marketDate' and marketId = '$marketId' and id = '$recordId'");
                    }

                } else{
                    echo "Result not declared for either of the type."."<br>";
                }

            }

        } else{
            echo "No one played the game or result declared"."<br>";
        }

// ------------------------FULL SANGAM BID RESULT --------------------------------------------------

        echo "Full Sangam Game"."<br>";

        $fullSangamRes = $conn->query("Select * from full_sangam_bids where marketId = '$marketId' and marketDate = '$marketDate' and status = 'Pending'");
        if($fullSangamRes->num_rows > 0){

            while($fullSangamRow = $fullSangamRes->fetch_assoc()){
                echo "Userid: ".$fullSangamRow['userId']."<br>";
                echo "Open Panna: ".$fullSangamRow['openPanna']."<br>";
                echo "Close Panna: ".$fullSangamRow['closePanna']."<br>";
                echo "Points: ".$fullSangamRow['points']."<br>";

                if($bidResultData['openScore'][0] != 'X' && $bidResultData['openScore'][1] != 'X' && $bidResultData['openScore'][2] != 'X' && $bidResultData['closeScore'][0] != 'X' && $bidResultData['closeScore'][1] != 'X' && $bidResultData['closeScore'][2] != 'X'){

                    if($fullSangamRow['openPanna'] == $bidResultData['openScore'] && $fullSangamRow['closePanna'] == $bidResultData['closeScore']){

                        $prizeMoney = ($fullSangamRow['points'] * FullSangRate);
                        echo "Full Sangam Win"."<br>";
                        echo "Reward: ".$prizeMoney."<br>";
                        $playerId = $fullSangamRow['userId'];
                        $recordId = $fullSangamRow['id'];

                        // make status as win in half sangam record
                        $conn->query("Update full_sangam_bids set status = 'Won' where userId = '$playerId' and marketDate = '$marketDate' and marketId = '$marketId' and id = '$recordId'");

                        // credit reward amont in users wallet
                        $conn->query("Update user set wallet = wallet + $prizeMoney where id = '$playerId'");

                        // keep in passbook for track
                        $orderId = "WN-".substr(str_shuffle(str_repeat($x = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ', ceil(24 / strlen($x)))), 1, 24);
                        $conn->query("Insert into passbook set
                        orderId = '$orderId',
                        userId = '$playerId',
                        title = 'Reward from ".$marketName." Full Sangam',
                        amount = '$prizeMoney',
                        bankDetails = '',
                        data = '',
                        status = 'Success',
                        date = '$addedOn',
                        txnType = 'Income'
                        ");

                    } else{
                        echo "Full Sangam Lost"."<br>";
                        $recordId = $fullSangamRow['id'];
                        $playerId = $fullSangamRow['userId'];
                        // make status as lost in half sangam record
                        $conn->query("Update full_sangam_bids set status = 'Lost' where userId = '$playerId' and marketDate = '$marketDate' and marketId = '$marketId' and id = '$recordId'");
                    }
                } else{
                    echo "Result not declared for either of the type."."<br>";
                }

            }

        } else{
            echo "No one played the game or result declared"."<br>";
        }
// -------------------------------------------------------------------------------------------------
    } else{
        echo "Invalid Market"."<br>";
    }
}

$processStatus["error"] = false;
$processStatus["message"] = "No Error";

// Add/Update Bid result
if(isset($_POST['pathAction']) && getSafeValue($_POST['pathAction']) == "Post-Bid-Result"){
    $marketDate = date('Y-m-d', strtotime(getSafeValue($_POST['marketDate'])));
    $marketIdsArray = $_POST['marketIds'];
    $marketsArray = $_POST['markets'];
    $openScoresArray = $_POST['openScores'];
    $jodiScoresArray = $_POST['jodiScores'];
    $closeScoresArray = $_POST['closeScores'];

    for ($index=0; $index < count($marketIdsArray); $index++) {
        
        $checkRes = $conn->query("Select id from bid_results where marketId = '".$marketIdsArray[$index]."' and date = '$marketDate'");
        if($checkRes->num_rows > 0){
            
            $updateMarketId = $checkRes->fetch_assoc()['id'];
            $conn->query("Update bid_results set
            openScore = '".$openScoresArray[$index]."',
            jodiScore = '".$jodiScoresArray[$index]."',
            closeScore = '".$closeScoresArray[$index]."'
            where marketId = '".$marketIdsArray[$index]."' and date = '$marketDate' and id = '$updateMarketId'
            ");
            if($conn->affected_rows > 0){
                echo "Update"."<br>";
                if($openScoresArray[$index] != '' || $closeScoresArray[$index] != ''){
                    $title = $marketsArray[$index];
                    $content = ($openScoresArray[$index] == '' ? 'XXX' : $openScoresArray[$index]).'-'.$jodiScoresArray[$index].'-'.($closeScoresArray[$index] == '' ? 'XXX' : $closeScoresArray[$index]);
                    // echo $title.' '.$marketDate.', '.$content;
                    $currentDate = date('Y-m-d', strtotime($addedOn));
                    echo $currentDate."<br>";
                    manageWinnersFunction($marketIdsArray[$index], $marketsArray[$index]);
                    if($currentDate == $marketDate){
                        // pushNotification($title.' | '.$marketDate, $content);
                    }
                }
            }
        } else{
            echo "Insert"."<br>";
            $conn->query("Insert into bid_results set
            openScore = '".$openScoresArray[$index]."',
            jodiScore = '".$jodiScoresArray[$index]."',
            closeScore = '".$closeScoresArray[$index]."',
            marketId = '".$marketIdsArray[$index]."',
            date = '$marketDate'
            ");
            if($conn->affected_rows > 0){

                if($openScoresArray[$index] != '' || $closeScoresArray[$index] != ''){
                    $title = $marketsArray[$index];
                    $content = ($openScoresArray[$index] == '' ? 'XXX' : $openScoresArray[$index]).'-'.$jodiScoresArray[$index].'-'.($closeScoresArray[$index] == '' ? 'XXX' : $closeScoresArray[$index]);
                    // echo $title.' '.$marketDate.', '.$content;
                    $currentDate = date('Y-m-d', strtotime($addedOn));
                    echo $currentDate."<br>";
                    manageWinnersFunction($marketIdsArray[$index], $marketsArray[$index]);
                    if($currentDate == $marketDate){
                        // pushNotification($title.' | '.$marketDate, $content);
                    }
                }
            }
        }      
    }
    header("Location:../bid-result.php");
}
// ! Add/Update Bid Result
?>