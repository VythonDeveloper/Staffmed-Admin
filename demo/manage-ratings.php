<?php 
include "../constant.inc.php";
include "session.php";
$restaurantId = getSafeValue($_SESSION['id']);
$ratingsData = getUserRatings($restaurantId);
include "header.php";
?>

<div class="grid grid-cols-2 gap-4 mb-4">
    <div class="">
        <div class="mb-1 text-base font-medium light:text-white">Ambience (⭐ <?php echo $ratingsData['avgAmbience'];?>)</div>
        <div class="w-full bg-gray-200 rounded-full h-2.5 mb-4 light:bg-gray-700">
            <div class="bg-gray-600 h-2.5 rounded-full light:bg-gray-300" style="width: <?php echo (($ratingsData['avgAmbience']/5)*100);?>%"></div>
        </div>
    </div>
    <div class="">
        <div class="mb-1 text-base font-medium text-blue-700 dark:text-blue-500">Hygiene (⭐ <?php echo $ratingsData['avgHygiene'];?>)</div>
        <div class="w-full bg-gray-200 rounded-full h-2.5 mb-4 dark:bg-gray-700">
            <div class="bg-blue-600 h-2.5 rounded-full" style="width: <?php echo (($ratingsData['avgHygiene']/5)*100);?>%"></div>
        </div>
    </div>
    <div class="">
        <div class="mb-1 text-base font-medium text-red-700 dark:text-red-500">Pricing (⭐ <?php echo $ratingsData['avgPricing'];?>)</div>
        <div class="w-full bg-gray-200 rounded-full h-2.5 mb-4 dark:bg-gray-700">
            <div class="bg-red-600 h-2.5 rounded-full dark:bg-red-500" style="width: <?php echo (($ratingsData['avgPricing']/5)*100);?>%"></div>
        </div>
    </div>
    <div class="">
        <div class="mb-1 text-base font-medium text-green-700 dark:text-green-500">Variety (⭐ <?php echo $ratingsData['avgVariety'];?>)</div>
        <div class="w-full bg-gray-200 rounded-full h-2.5 mb-4 dark:bg-gray-700">
            <div class="bg-green-600 h-2.5 rounded-full dark:bg-green-500" style="width: <?php echo (($ratingsData['avgVariety']/5)*100);?>%"></div>
        </div>
    </div>
    <div class="">
        <div class="mb-1 text-base font-medium text-yellow-700 dark:text-yellow-500">Food (⭐ <?php echo $ratingsData['avgFood'];?>)</div>
        <div class="w-full bg-gray-200 rounded-full h-2.5 mb-4 dark:bg-gray-700">
            <div class="bg-yellow-400 h-2.5 rounded-full" style="width: <?php echo (($ratingsData['avgFood']/5)*100);?>%"></div>
        </div>
    </div>
    <div class="">
        <div class="mb-1 text-base font-medium text-indigo-700 dark:text-indigo-500">Music (⭐ <?php echo $ratingsData['avgMusic'];?>)</div>
        <div class="w-full bg-gray-200 rounded-full h-2.5 mb-4 dark:bg-gray-700">
            <div class="bg-indigo-600 h-2.5 rounded-full dark:bg-indigo-500" style="width: <?php echo (($ratingsData['avgMusic']/5)*100);?>%"></div>
        </div>
    </div>
    <div class="">
        <div class="mb-1 text-base font-medium text-purple-700 dark:text-purple-500">Service (⭐ <?php echo $ratingsData['avgService'];?>)</div>
        <div class="w-full bg-gray-200 rounded-full h-2.5 dark:bg-gray-700">
            <div class="bg-purple-600 h-2.5 rounded-full dark:bg-purple-500" style="width: <?php echo (($ratingsData['avgService']/5)*100);?>%"></div>
        </div>
    </div>
</div>
<hr>
<div class="grid md:grid-cols-1 md:gap-6 mt-3">     
    <table class="w-full text-sm text-left text-gray-500 light:text-gray-400" id="dataTable">
        <thead class="text-gray-700 bg-gray-50 light:bg-gray-700 light:text-gray-400">
            <tr>
                <th scope="col" class="px-6 py-3">
                    Order-Id
                </th>
                <th scope="col" class="px-6 py-3">
                    Comment
                </th>
                <th scope="col" class="px-6 py-3">
                    Rating
                </th>
                <th scope="col" class="px-6 py-3 text-right">
                    Date
                </th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($ratingsData['comments'] as $value){ ?>
                <form method="POST" action="./controllers/manage-slots-controller.php">
                    <tr class="bg-white border-b light:bg-gray-800 light:border-gray-700 hover:bg-gray-50 light:hover:bg-gray-600">
                        <th class="px-6 py-4">
                            <?php echo $value['orderId'];?>
                        </th>
                        <td class="px-6 py-4 font-medium text-gray-900 light:text-white">
                            <?php echo $value['comment'];?>
                        </td>
                        <td class="px-6 py-4 font-medium text-gray-900 light:text-white">
                            ⭐ <?php echo $value['rating'];?>
                        </td>
                        <td class="px-6 py-4 text-right">
                            <?php echo $value['date'];?>
                            </div>
                        </td>
                    </tr>
                </form>    
            <?php }?>
        </tbody>
    </table>
</div>
<?php include "footer.php";?>