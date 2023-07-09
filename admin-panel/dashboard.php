<?php 
include "../constant.inc.php";
include "session.php";
// $ordersGraphData = getOrdersGraphData($restaurantId);
include "header.php";

$graphMonthArray = Array('January', 'Fenruary', 'March', 'April', 'May', 'June');
$monthlyOrdersDataArray = Array(300, 245, 173, 400, 700, 143);
$monthlyEarningDataArray = Array(8000, 7566, 8713, 8255, 7841, 8556);
?> 

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
        const labelsBarChart = <?php echo json_encode($graphMonthArray);?>;
        const dataBarChart = {
            labels: labelsBarChart,
            datasets: [{
                label: "Orders Placed",
                backgroundColor: "hsl(217, 57%, 51%)",
                borderColor: "hsl(217, 57%, 51%)",
                // data: [0, 10, 5, 2, 20, 30, 45],
                data: <?php echo json_encode($monthlyOrdersDataArray);?>,
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
        const labels = <?php echo json_encode($graphMonthArray);?>;
        const data = {
            labels: labels,
            datasets: [{
                label: "Earning in ₹",
                backgroundColor: "hsl(217, 57%, 51%)",
                borderColor: "hsl(217, 57%, 51%)",
                data: <?php echo json_encode($monthlyEarningDataArray);?>,
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