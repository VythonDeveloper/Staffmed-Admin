<?php 
include "../constant.inc.php";
include "session.php";

$restaurantId = getSafeValue($_SESSION['id']);
$featuresData = fetchRestaurantFeatures($restaurantId);
if($featuresData != []){
    $featuresData = explode('#_#', $featuresData['feature']);
}

$featuresList = ['Pure Veg', 'Smoking area', 'Take away', 'Live Music', 'Kids allowed', 'Alcohol Served', 'Air Condition','Outdoor Seating', 'Valet Parking', 'Shisha/Hookah', 'Pet Freindly', 'Wheelchair Accessible', 'Live Sports Screening', 'Dance Floor', 'Karaoke', 'Home Delivery', 'Nightlife', 'Buffet', 'Bars & Pubs', 'Rooftops', 'Bar', 'Seafood', 'Sunday Brunches', 'Great Breakfast', 'Romantic', 'Microbrewery'];

if(isset($_POST['submit']) && $_POST['submit'] == "update-features"){
    $feature = trim(implode("#_#", $_POST['features']), " ");
    $res = $conn->query("Select * from restaurant_features where restaurantId = '$restaurantId'");
    if($res->num_rows > 0){
        $conn->query("Update restaurant_features set feature = '$feature' where restaurantId = '$restaurantId'");
    }else{
        $conn->query("Insert into restaurant_features set restaurantId = '$restaurantId', feature = '$feature'");
    }
    header("Refresh:0");
}

include "header.php";
?>

<form method="POST" action="" id="update-form">
    <div class="grid md:grid-cols-4 md:gap-6">
        <?php foreach($featuresList as $value){ ?>
            <div class="relative z-0 w-full mb-6 group">
                <input id="features<?php echo $value;?>" name="features[]" type="checkbox" value="<?php echo $value;?>" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 light:focus:ring-blue-600 light:ring-offset-gray-800 focus:ring-2 light:bg-gray-700 light:border-gray-600" <?php echo in_array($value, $featuresData) ? "checked": '';?>>
                <label for="features<?php echo $value;?>" class="ml-2 text-sm font-medium text-gray-900 light:text-gray-300"><?php echo $value;?></label>
            </div>
        <?php } ?>
    </div>

    <button type="submit" name="submit" value="update-features" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Update Features</button>
</form>

<?php include "footer.php";?>