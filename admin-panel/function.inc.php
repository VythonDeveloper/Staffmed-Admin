<?php
include "../dbcon.php";

// Define Global Variables
define("Site_Name", "Staffmed");
define("Site_Version", "1.1");
// define("Script_Password", "ad38b53ef326ef");

// Define Reusable functions
function getSafeValue($value){
	global $conn;
	return strip_tags(
		mysqli_real_escape_string($conn, $value)
	);
}

function getMedicineList($pageNo, $searchKey){
	global $conn;
	$dataLimit = 10;
	$offsetData = $pageNo * $dataLimit;
	$serverData = Array();
	if(empty($searchKey)){
		$sqlQuery = "Select * from medicines order by id desc limit $dataLimit offset $offsetData;";
	} else{
		$sqlQuery = "Select * from medicines where (soundex('$searchKey') = soundex(name)) OR (name LIKE CONCAT('%', '$searchKey', '%')) or (soundex('$searchKey') = soundex(company)) or (company LIKE CONCAT('%', '$searchKey', '%')) order by id desc limit $dataLimit offset $offsetData;";
	}
	$res = $conn->query($sqlQuery);
	if($res->num_rows > 0){
		while($row = $res->fetch_assoc()){
			$serverData[count($serverData)] = $row;
		}
	}
	return $serverData;
}

function getMedicineDetails($medId){
	global $conn;
	$serverData = Array();
	$res = $conn->query("Select * from medicines where id = '$medId'");
	if($res->num_rows > 0){
		$serverData = $res->fetch_assoc();
	}
	return $serverData;
}

function getOrdersList($pageNo, $searchKey){
	global $conn;
	$dataLimit = 10;
	$offsetData = $pageNo * $dataLimit;
	$serverData = Array();
	if(empty($searchKey)){
		$sqlQuery = "Select us.fullname, us.phone, od.* from orders od inner join users us on od.userId = us.id order by od.id desc limit $dataLimit offset $offsetData;";
	} else{
		$sqlQuery = "Select * from orders od inner join users us on od.userId = us.id where (soundex('$searchKey') = soundex(od.refId)) or (od.refId LIKE CONCAT('%', '$searchKey', '%')) or (soundex('$searchKey') = soundex(od.shippingAddress)) or (od.shippingAddress LIKE CONCAT('%', '$searchKey', '%')) order by od.id desc limit $dataLimit offset $offsetData;";
	}
	$res = $conn->query($sqlQuery);
	if($res->num_rows > 0){
		while($row = $res->fetch_assoc()){
			$serverData[count($serverData)] = $row;
		}
	}
	return $serverData;
}

function getOrderDetails($orderId){
	global $conn;
	$serverData = Array();
	$res = $conn->query("Select us.fullname, us.phone, od.* from orders od inner join users us on od.userId = us.id where od.id = '$orderId'");
	if($res->num_rows > 0){
		$odRow = $res->fetch_assoc();

		$opRes = $conn->query("Select * from ordered_products op inner join medicines med on op.productId = med.id where orderId = '".$odRow['id']."'");
		$opArray = Array();
		if($opRes->num_rows > 0){
			while($opRow = $opRes->fetch_assoc()){
				$opArray[count($opArray)] = $opRow;
			}
		}
		$odRow['orderedProducts'] = $opArray;
		$serverData = $odRow;
	}
	return $serverData;
}

function getOrdersGraphData($restaurantId){
	global $conn;
	$serverData = Array();
	$res = $conn->query("Select * from booking_orders where restaurantId = '$restaurantId' order by id desc");
	if($res->num_rows > 0){
		while($row = $res->fetch_assoc()){
			$serverData[count($serverData)] = $row;
		}
	}
	return $serverData;
}

?>