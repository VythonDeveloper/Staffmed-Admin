<?php 
include "../constant.inc.php";
include "session.php";
$restaurantId = getSafeValue($_SESSION['id']);
$ordersData = getBookingOrders($restaurantId);
include "header.php";
?>

<div class="grid md:grid-cols-1 md:gap-6 mt-3">     
    <table class="w-full text-sm text-left text-gray-500 light:text-gray-400" id="dataTable">
        <thead class="text-gray-700 bg-gray-50 light:bg-gray-700 light:text-gray-400">
            <tr>
                <th scope="col" class="px-6 py-3">
                    Order-Id
                </th>
                <th scope="col" class="px-6 py-3">
                    Customer
                </th>
                <th scope="col" class="px-6 py-3">
                    Booked Slot
                </th>
                <th scope="col" class="px-6 py-3">
                    Tables Required
                </th>
                <th scope="col" class="px-6 py-3">
                    Payment Mode
                </th>
                <th scope="col" class="px-6 py-3">
                    Amount
                </th>
                <th scope="col" class="px-6 py-3">
                    Status
                </th>
                <th scope="col" class="px-6 py-3 text-right">
                    Action
                </th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($ordersData as $value){ ?>
                <form method="POST" action="./controllers/manage-slots-controller.php">
                    <tr class="bg-white border-b light:bg-gray-800 light:border-gray-700 hover:bg-gray-50 light:hover:bg-gray-600">
                        <th class="px-6 py-4">
                            <?php echo $value['orderId'];?>
                            <input type="hidden" name="orderId" value="<?php echo $value['orderId'];?>">
                            <input type="hidden" name="restaurantId" value="<?php echo $value['restaurantId'];?>">
                        </th>
                        <td class="px-6 py-4 font-medium text-gray-900 light:text-white">
                            <?php echo $value['customerId'];?>
                        </td>
                        <td class="px-6 py-4 font-medium text-gray-900 light:text-white">
                            <?php echo $value['openSlot'].' - '.$value['closeSlot'];?>
                        </td>
                        <td class="px-6 py-4 font-medium text-gray-900 light:text-white">
                            <?php echo $value['tablesRequired'];?>
                        </td>
                        <td class="px-6 py-4 font-medium text-gray-900 light:text-white">
                            <?php echo $value['paymentMode'];?>
                        </td>
                        <td class="px-6 py-4 font-medium text-gray-900 light:text-white">
                            ₹<?php echo $value['amount'];?>
                        </td>
                        <td class="px-6 py-4 font-medium text-gray-900 light:text-white">
                            <?php echo $value['status'];?>
                        </td>
                        <td class="px-6 py-4 text-right">
                            <div class="inline-flex rounded-md shadow-sm" role="group">
                                <button type="submit" name="pathAction" value="Update-Slot" class="font-medium text-purple-600 dark:text-purple-500 hover:underline">Redeemed</button>
                                <!-- <button type="submit" name="pathAction" value="Delete-Slot" class="font-medium text-red-600 dark:text-red-500 hover:underline mr-3" onclick="return confirm('Are you sure to delete the slot?');">Delete</button> -->
                            </div>
                        </td>
                    </tr>
                </form>    
            <?php }?>
        </tbody>
    </table>
</div>
<?php include "footer.php";?>