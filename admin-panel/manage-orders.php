<?php 
include "../constant.inc.php";
include "session.php";
if(isset($_POST['isPaid'])){
    $isPaid = $_POST['isPaid'];
    $orderId = $_POST['orderId'];
    $conn->query("Update orders set isPaid = '$isPaid' where id = '$orderId'");
}
if(isset($_POST['orderStatus'])){
    $orderStatus = $_POST['orderStatus'];
    $orderId = $_POST['orderId'];
    $conn->query("Update orders set status = '$orderStatus' where id = '$orderId'");
}
$pageNo = 0;
$searchKey = '';
if(isset($_GET['pageNo'])){
    $pageNo = $_GET['pageNo'];
}
if(isset($_GET['searchKey'])){
    $searchKey = $_GET['searchKey'];
}
$ordersData = getOrdersList($pageNo, $searchKey);
include "header.php";
?>

<div class="relative overflow-x-auto shadow-md sm:rounded-lg">
    <div class="p-4 bg-white light:bg-gray-900">
        <label for="table-search" class="sr-only">Search</label>
        <div class="relative mt-1">
            <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                <svg class="w-5 h-5 text-gray-500 light:text-gray-400" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd"></path></svg>
            </div>
            <form method="GET">
                <input type="text" id="searchKey" name="searchKey" class="block p-2 pl-10 text-sm text-gray-900 border border-gray-300 rounded-lg w-80 bg-gray-50 focus:ring-blue-500 focus:border-blue-500 light:bg-gray-700 light:border-gray-600 light:placeholder-gray-400 light:text-white light:focus:ring-blue-500 light:focus:border-blue-500" placeholder="Search reference id">
            </form>
        </div>
    </div>
    <table class="w-full text-sm text-left text-gray-500 light:text-gray-400" id="dataTable">
        <thead class="text-gray-700 bg-gray-50 light:bg-gray-700 light:text-gray-400">
            <tr>
                <th scope="col" class="px-6 py-3">
                    Order-Id
                </th>
                <th scope="col" class="px-6 py-3">
                    Ref-Id
                </th>
                <th scope="col" class="px-6 py-3">
                    Orderer
                </th>
                <th scope="col" class="px-6 py-3">
                    Total Amount
                </th>
                <th scope="col" class="px-6 py-3">
                    Payment Status
                </th>
                <th scope="col" class="px-6 py-3">
                    Order Status
                </th>
                <th scope="col" class="px-6 py-3">
                    Delivery-by
                </th>
                <th scope="col" class="px-6 py-3 text-right">
                    Action
                </th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($ordersData as $value){ ?>
                <form method="POST" onsubmit="return confirm('Are you sure to make following changes?');">
                    <input type="hidden" value="<?php echo $value['id'];?>" name="orderId">
                    <tr class="bg-white border-b light:bg-gray-800 light:border-gray-700 hover:bg-gray-50 light:hover:bg-gray-600">
                        <th class="px-6 py-4">
                            <?php echo $value['id'];?>
                        </th>
                        <td class="px-6 py-4 font-medium text-gray-900 light:text-white">
                            <?php echo $value['refId'];?>
                        </td>
                        <td class="px-6 py-4 font-medium text-gray-900 light:text-white">
                            <?php echo $value['fullname'].', '.$value['phone'];?>
                        </td>
                        <td class="px-6 py-4 font-medium text-gray-900 light:text-white">
                            ₹<?php echo $value['amount'];?>
                        </td>
                        <td class="px-6 py-4 font-medium text-gray-900 light:text-white">
                            <select name="isPaid" onChange="this.form.submit()">
                                <option value="Pending" <?php echo $value['isPaid'] == 'Pending' ? 'selected' : '';?>>Pending</option>
                                <option value="Approved" <?php echo $value['isPaid'] == 'Approved' ? 'selected' : '';?>>Approved</option>
                            </select>
                        </td>
                        <td class="px-6 py-4 font-medium text-gray-900 light:text-white">
                            <select name="orderStatus" onChange="this.form.submit()">
                                <option value="Pending" <?php echo $value['status'] == 'Pending' ? 'selected' : '';?>>Pending</option>
                                <option value="Rejected" <?php echo $value['status'] == 'Rejected' ? 'selected' : '';?>>Rejected</option>
                                <option value="Dispatched" <?php echo $value['status'] == 'Dispatched' ? 'selected' : '';?>>Dispatched</option>
                                <option value="Shipped" <?php echo $value['status'] == 'Shipped' ? 'selected' : '';?>>Shipped</option>
                                <option value="Out for Delivery" <?php echo $value['status'] == 'Out for Delivery' ? 'selected' : '';?>>Out for Delivery</option>
                                <option value="Delivered" <?php echo $value['status'] == 'Delivered' ? 'selected' : '';?>>Delivered</option>
                            </select>
                        </td>
                        <td class="px-6 py-4 font-medium text-gray-900 light:text-white">
                            <?php echo $value['dateRange'].' '.$value['timeSlot'];?>
                        </td>
                        <td class="px-3 py-4 text-right">
                            <div class="inline-flex rounded-md shadow-sm" role="group">
                                <a href="order-details.php?orderId=<?php echo $value['id'];?>" target="_blank" class="cursor-pointer px-3 py-2 text-xs font-medium text-center inline-flex items-center text-white bg-blue-700 rounded-lg hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                                    <svg xmlns="http://www.w3.org/2000/svg" height="15" fill="currentColor" class="feather feather-edit mr-1" viewBox="0 0 16 16"> <path d="M14.5 3a.5.5 0 0 1 .5.5v9a.5.5 0 0 1-.5.5h-13a.5.5 0 0 1-.5-.5v-9a.5.5 0 0 1 .5-.5h13zm-13-1A1.5 1.5 0 0 0 0 3.5v9A1.5 1.5 0 0 0 1.5 14h13a1.5 1.5 0 0 0 1.5-1.5v-9A1.5 1.5 0 0 0 14.5 2h-13z"/> <path d="M7 5.5a.5.5 0 0 1 .5-.5h5a.5.5 0 0 1 0 1h-5a.5.5 0 0 1-.5-.5zm-1.496-.854a.5.5 0 0 1 0 .708l-1.5 1.5a.5.5 0 0 1-.708 0l-.5-.5a.5.5 0 1 1 .708-.708l.146.147 1.146-1.147a.5.5 0 0 1 .708 0zM7 9.5a.5.5 0 0 1 .5-.5h5a.5.5 0 0 1 0 1h-5a.5.5 0 0 1-.5-.5zm-1.496-.854a.5.5 0 0 1 0 .708l-1.5 1.5a.5.5 0 0 1-.708 0l-.5-.5a.5.5 0 0 1 .708-.708l.146.147 1.146-1.147a.5.5 0 0 1 .708 0z"/></svg>
                                    Details
                                </a>
                            </div>
                        </td>
                    </tr>
                </form>
            <?php }?>
        </tbody>
    </table>
</div>

<div class="flex flex-col items-center mt-10">
    <!-- Help text -->
    <span class="text-sm text-gray-700 light:text-gray-400">
        Showing total <span class="font-semibold text-gray-900 light:text-white"><?php echo count($ordersData);?></span> records
    </span>
    <div class="inline-flex mt-2 xs:mt-0">
        <!-- Buttons -->
        <a href="manage-orders.php?pageNo=<?php echo $pageNo > 0 ? ($pageNo-1) : 0;?>" class="cursor-pointer flex items-center justify-center px-3 h-8 text-sm font-medium text-white bg-gray-800 rounded-l hover:bg-gray-900 light:bg-gray-800 light:border-gray-700 light:text-gray-400 light:hover:bg-gray-700 light:hover:text-white">
            <svg class="w-3.5 h-3.5 mr-2" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 10">
            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 5H1m0 0 4 4M1 5l4-4"/>
            </svg>
            Prev
        </a>
        <a href="manage-orders.php?pageNo=<?php echo ($pageNo+1);?>" class="cursor-pointer flex items-center justify-center px-3 h-8 text-sm font-medium text-white bg-gray-800 border-0 border-l border-gray-700 rounded-r hover:bg-gray-900 light:bg-gray-800 light:border-gray-700 light:text-gray-400 light:hover:bg-gray-700 light:hover:text-white">
            Next
            <svg class="w-3.5 h-3.5 ml-2" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 10">
            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 5h12m0 0L9 1m4 4L9 9"/>
        </svg>
        </a>
    </div>
</div>
<?php include "footer.php";?>