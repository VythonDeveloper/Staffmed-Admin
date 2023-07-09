<?php 
include "../constant.inc.php";
include "session.php";
$restaurantId = getSafeValue($_SESSION['id']);
$ratingsData = getUserRatings($restaurantId);
$ordersGraphData = getOrdersGraphData($restaurantId);
include "header.php";

$ordersMonthArray = Array('January', 'Fenruary');
?> 





<div class="grid grid-cols-2 gap-4 mb-4 mt-4">
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

<!-- <div class="flex items-center justify-center h-48 mb-4 rounded bg-gray-50 dark:bg-gray-800">
    <p class="text-2xl text-gray-400 dark:text-gray-500">+</p>
</div> -->

<hr>

<div class="grid grid-cols-2 gap-4 mb-4 mt-4">
    <div class="overflow-hidden rounded-lg shadow-lg">
        <div class="bg-neutral-50 py-3 px-5 dark:bg-neutral-700 dark:text-neutral-200"> Monthly Orders Graph </div>
        <canvas class="p-0" id="chartBar"></canvas>
    </div>
    <!-- Required chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <!-- Chart bar -->
    <script>
        // const labelsBarChart = ["January", "February", "March", "April", "May", "June", ];
        const labelsBarChart = <?php echo json_encode($ordersMonthArray);?>;
        const dataBarChart = {
            labels: labelsBarChart,
            datasets: [{
                label: "Orders Placed",
                backgroundColor: "hsl(217, 57%, 51%)",
                borderColor: "hsl(217, 57%, 51%)",
                // data: [0, 10, 5, 2, 20, 30, 45],
                data: [0, 10],
            }, ],
        };
        const configBarChart = {
            type: "bar",
            data: dataBarChart,
            options: {},
        };
        var chartBar = new Chart(document.getElementById("chartBar"), configBarChart);
    </script>
<!-- </div>
<div class="grid grid-cols-1 gap-4 mb-4"> -->
    <div class="overflow-hidden rounded-lg shadow-lg">
        <div class="bg-neutral-50 py-3 px-5 dark:bg-neutral-700 dark:text-neutral-200"> Monthly Earning Graph </div>
        <canvas class="p-0" id="chartLine"></canvas>
    </div>
    <!-- Required chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <!-- Chart line -->
    <script>
        const labels = ["January", "February", "March", "April", "May", "June"];
        const data = {
            labels: labels,
            datasets: [{
                label: "Earning in ₹",
                backgroundColor: "hsl(217, 57%, 51%)",
                borderColor: "hsl(217, 57%, 51%)",
                data: [0, 10, 5, 2, 20, 30, 45],
            }, ],
        };
        const configLineChart = {
            type: "line",
            data,
            options: {},
        };
        var chartLine = new Chart(document.getElementById("chartLine"), configLineChart);
    </script>
</div> <?php include "footer.php";?>