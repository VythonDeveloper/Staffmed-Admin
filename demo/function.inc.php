<?php
include "../dbcon.php";

// Define Global Variables
define("Site_Name", "BMT Restaurant");
define("Site_Version", "1.6");
// define("Script_Password", "ad38b53ef326ef");

// Define Reusable functions
function getSafeValue($value){
	global $conn;
	return strip_tags(
		mysqli_real_escape_string($conn, $value)
	);
}

function getVendorData(){
	global $conn;
	$serverData = Array();
	$restaurantId = getSafeValue($_SESSION['id']);
	$res = $conn->query("Select res.*, ct.city from restaurants as res, cities as ct where ct.id = res.cityId and res.id = '$restaurantId'");
	if($res->num_rows > 0){
		$serverData = $res->fetch_assoc();
	}
	return $serverData;
}

function fetchRestaurantFeatures($restaurantId){
	global $conn;
	$serverData = array();
	$res = $conn->query("Select * from restaurant_features where id = '$restaurantId'");
	if ($res->num_rows > 0) {
		$serverData = $res->fetch_assoc();
	}
	return $serverData;
}

function getGalleryImages($restaurantId){
	global $conn;
	$serverData = Array();
	$res = $conn->query("Select * from restaurant_gallery where restaurantId = '$restaurantId' order by id desc");
	if($res->num_rows > 0){
		while($row = $res->fetch_assoc()){
			$serverData[count($serverData)] = $row;
		}
	}
	return $serverData;
}

function getSlots($restaurantId){
	global $conn;
	$serverData = Array();
	$res = $conn->query("Select * from restaurant_slots where restaurantId = '$restaurantId' order by id desc");
	if($res->num_rows > 0){
		while($row = $res->fetch_assoc()){
			$serverData[count($serverData)] = $row;
		}
	}
	return $serverData;
}

function getBookingOrders($restaurantId){
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

function getUserRatings($restaurantId){
	global $conn;
	$serverData = Array();
	$avgRateRes = $conn->query("Select round(avg(ambience), 1) as avgAmbience, round(avg(hygiene), 1) as avgHygiene, round(avg(pricing), 1) as avgPricing, round(avg(variety), 1) as avgVariety, round(avg(food), 1) as avgFood, round(avg(music), 1) as avgMusic, round(avg(service), 1) as avgService from ratings where restaurantId = '$restaurantId'");
	if($avgRateRes->num_rows > 0){
		$serverData = $avgRateRes->fetch_assoc();
	}
	$ratingComments = $conn->query("Select orderId, comment, round((ambience + hygiene + pricing + variety + food + music + service)/7, 1) as rating, date from ratings where restaurantId = '$restaurantId'");
	$commentsArray = Array();
	if($ratingComments->num_rows > 0){
		while($commentsRow = $ratingComments->fetch_assoc()){
			$commentsArray[count($commentsArray)] = $commentsRow;
		}
	}
	$serverData['comments'] = $commentsArray;
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