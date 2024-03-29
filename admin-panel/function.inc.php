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

function getCustomerList($pageNo, $searchKey){
	global $conn;
	$dataLimit = 10;
	$offsetData = $pageNo * $dataLimit;
	$serverData = Array();
	if(empty($searchKey)){
		$sqlQuery = "Select * from users order by id desc limit $dataLimit offset $offsetData;";
	} else{
		$sqlQuery = "Select * from users where (soundex('$searchKey') = soundex(fullname)) OR (fullname LIKE CONCAT('%', '$searchKey', '%')) or (phone LIKE CONCAT('%', '$searchKey', '%')) order by id desc limit $dataLimit offset $offsetData;";
	}
	$res = $conn->query($sqlQuery);
	if($res->num_rows > 0){
		while($row = $res->fetch_assoc()){
			$serverData[count($serverData)] = $row;
		}
	}
	return $serverData;
}

function getPrescriptionOrdersList($pageNo, $searchKey){
	global $conn;
	$dataLimit = 10;
	$offsetData = $pageNo * $dataLimit;
	$serverData = Array();
	if(empty($searchKey)){
		$sqlQuery = "Select us.fullname, us.phone, pod.* from prescription_orders pod inner join users us on pod.userId = us.id order by pod.id desc limit $dataLimit offset $offsetData;";
	} else{
		$sqlQuery = "Select * from prescription_orders pod inner join users us on pod.userId = us.id where (soundex('$searchKey') = soundex(pod.refId)) or (pod.refId LIKE CONCAT('%', '$searchKey', '%')) or (soundex('$searchKey') = soundex(pod.shippingAddress)) or (pod.shippingAddress LIKE CONCAT('%', '$searchKey', '%')) order by pod.id desc limit $dataLimit offset $offsetData;";
	}
	$res = $conn->query($sqlQuery);
	if($res->num_rows > 0){
		while($row = $res->fetch_assoc()){
			$serverData[count($serverData)] = $row;
		}
	}
	return $serverData;
}

function getPrescriptionOrderMedicines($presOdId, $searchKey){
	global $conn;
	$serverData = Array();
	if(empty($searchKey)){
		$sqlQuery = "Select * from prescription_products where presId = '$presOdId' order by id desc";
	} else{
		$sqlQuery = "Select * from prescription_products where presId = '$presOdId' and (soundex('$searchKey') = soundex(name)) or (name LIKE CONCAT('%', '$searchKey', '%')) or (soundex('$searchKey') = soundex(company)) or (company LIKE CONCAT('%', '$searchKey', '%')) order by id desc;";
	}
	$res = $conn->query($sqlQuery);
	if($res->num_rows > 0){
		while($row = $res->fetch_assoc()){
			$serverData[count($serverData)] = $row;
		}
	}
	return $serverData;
}

function getPrescriptionDetails($presOdId){
	global $conn;
	$serverData = Array();
	$res = $conn->query("Select us.fullname, us.phone, prod.* from prescription_orders prod inner join users us on prod.userId = us.id where prod.id = '$presOdId'");
	if($res->num_rows > 0){
		$odRow = $res->fetch_assoc();

		// Prescription
		$presRes = $conn->query("Select * from prescriptions where presId = '".$odRow['id']."'");
		$presArray = Array();
		if($presRes->num_rows > 0){
			while($presRow = $presRes->fetch_assoc()){
				$presArray[count($presArray)] = $presRow;
			}
		}
		$odRow['prescriptions'] = $presArray;

		// Medicines
		$medRes = $conn->query("Select * from prescription_products where presId = '".$odRow['id']."'");
		$medArray = Array();
		if($medRes->num_rows > 0){
			while($medRow = $medRes->fetch_assoc()){
				$medArray[count($medArray)] = $medRow;
			}
		}
		$odRow['medicines'] = $medArray;

		// Final and Submit
		$serverData = $odRow;
	}
	return $serverData;
}

function getMonthlyOrdersStats(){
	global $conn;
	$serverData = Array();
	$res = $conn->query("Select month, sum(ordersPlaced) as ordersPlaced from (
		Select monthname(date) as month, month(date) as monthInt, count(*) as ordersPlaced from orders as tb1 group by monthname(date)
		union all 
		Select monthname(date) as month, month(date) as monthInt, count(*) as ordersPlaced from prescription_orders as tb2 group by monthname(date)
	) as tb3 
	group by month order by monthInt desc limit 6");
	if($res->num_rows > 0){
		while($row = $res->fetch_assoc()){
			$serverData[count($serverData)] = $row;
		}
	}
	return $serverData;
}

function getMonthlyEarningStats(){
	global $conn;
	$serverData = Array();
	$res = $conn->query("Select month, sum(earning) as totalEarning from (
		Select monthname(date) as month, month(date) as monthInt, sum(amount) as earning from orders as tb1 where isPaid = 'Approved' group by monthname(date)
		union ALL
		Select monthname(date) as month, month(date) as monthInt, sum(amount) as earning from prescription_orders as tb2 where isPaid = 'Approved' group by monthname(date)
	) as tb3 group by month order by monthInt desc limit 7");
	if($res->num_rows > 0){
		while($row = $res->fetch_assoc()){
			$serverData[count($serverData)] = $row;
		}
	}
	return $serverData;
}

?>