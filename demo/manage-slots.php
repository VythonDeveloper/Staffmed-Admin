<?php 
include "../constant.inc.php";
include "session.php";
$restaurantId = getSafeValue($_SESSION['id']);
$slotsData = getSlots($restaurantId);
include "header.php";
?>

<div class="grid md:grid-cols-1 md:gap-6 mt-3">     
    <table class="w-full text-sm text-left text-gray-500 light:text-gray-400" id="dataTable">
        <thead class="text-gray-700 bg-gray-50 light:bg-gray-700 light:text-gray-400">
            <tr>
                <th scope="col" class="px-6 py-3">
                    #
                </th>
                <th scope="col" class="px-6 py-3">
                    Slot Open Time
                </th>
                <th scope="col" class="px-6 py-3">
                    Slot Close Time
                </th>
                <th scope="col" class="px-6 py-3">
                    Available Table
                </th>
                <th scope="col" class="px-6 py-3">
                    Cost/Table
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
            <form method="POST" action="./controllers/manage-slots-controller.php">
                <tr class="bg-white border-b light:bg-gray-800 light:border-gray-700 hover:bg-gray-50 light:hover:bg-gray-600">
                    <th class="px-6 py-4">
                        -
                        <input type="hidden" name="restaurantId" value="<?php echo $restaurantId;?>">
                    </th>
                    <td class="px-6 py-4 font-medium text-gray-900 light:text-white">
                        <input type="time" name="slotOpenTime" class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 light:bg-gray-700 light:border-gray-600 light:placeholder-gray-400 light:text-white light:focus:ring-blue-500 light:focus:border-blue-500" required>
                    </td>
                    <td class="px-6 py-4 font-medium text-gray-900 light:text-white">
                        <input type="time" name="slotCloseTime" class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 light:bg-gray-700 light:border-gray-600 light:placeholder-gray-400 light:text-white light:focus:ring-blue-500 light:focus:border-blue-500" required>
                    </td>
                    <td class="px-6 py-4 font-medium text-gray-900 light:text-white">
                        <input type="number" name="tableCount" class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 light:bg-gray-700 light:border-gray-600 light:placeholder-gray-400 light:text-white light:focus:ring-blue-500 light:focus:border-blue-500" placeholder="Table count like 30" required>
                    </td>
                    <td class="px-6 py-4 font-medium text-gray-900 light:text-white">
                        <input type="number" name="unitCost" class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 light:bg-gray-700 light:border-gray-600 light:placeholder-gray-400 light:text-white light:focus:ring-blue-500 light:focus:border-blue-500" placeholder="Cost per Table like 3000" required>
                    </td>
                    <td class="px-6 py-4 font-medium text-gray-900 light:text-white">
                        <label class="relative inline-flex items-center mb-5 cursor-pointer">
                            <input type="checkbox" value="Active" name="slotStatus" class="sr-only peer">
                            <div class="w-9 h-5 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 dark:peer-focus:ring-blue-800 rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-4 after:w-4 after:transition-all dark:border-gray-600 peer-checked:bg-blue-600"></div>
                        </label>
                    </td>
                    <td class="px-6 py-4 text-right">
                        <div class="inline-flex rounded-md shadow-sm" role="group">
                            <button type="submit" name="pathAction" value="Add-New-Slot" class="font-medium text-blue-600 dark:text-blue-500 hover:underline">Add</button>
                        </div>
                    </td>
                </tr>
            </form>
            <?php foreach($slotsData as $value){ ?>
                <form method="POST" action="./controllers/manage-slots-controller.php">
                    <tr class="bg-white border-b light:bg-gray-800 light:border-gray-700 hover:bg-gray-50 light:hover:bg-gray-600">
                        <th class="px-6 py-4">
                            <?php echo $value['id'];?>
                            <input type="hidden" name="slotId" value="<?php echo $value['id'];?>">
                            <input type="hidden" name="restaurantId" value="<?php echo $restaurantId;?>">
                        </th>
                        <td class="px-6 py-4 font-medium text-gray-900 light:text-white">
                            <input type="time" name="slotOpenTime" class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 light:bg-gray-700 light:border-gray-600 light:placeholder-gray-400 light:text-white light:focus:ring-blue-500 light:focus:border-blue-500" value="<?php echo $value['openSlot'];?>" required>
                        </td>
                        <td class="px-6 py-4 font-medium text-gray-900 light:text-white">
                            <input type="time" name="slotCloseTime" class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 light:bg-gray-700 light:border-gray-600 light:placeholder-gray-400 light:text-white light:focus:ring-blue-500 light:focus:border-blue-500" value="<?php echo $value['closeSlot'];?>" required>
                        </td>
                        <td class="px-6 py-4 font-medium text-gray-900 light:text-white">
                            <input type="number" name="tableCount" class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 light:bg-gray-700 light:border-gray-600 light:placeholder-gray-400 light:text-white light:focus:ring-blue-500 light:focus:border-blue-500" placeholder="Table count like 30" value="<?php echo $value['tables'];?>" required>
                        </td>
                        <td class="px-6 py-4 font-medium text-gray-900 light:text-white">
                            <input type="number" name="unitCost" class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 light:bg-gray-700 light:border-gray-600 light:placeholder-gray-400 light:text-white light:focus:ring-blue-500 light:focus:border-blue-500" placeholder="Table count like 30" value="<?php echo $value['unitCost'];?>" required>
                        </td>
                        <td class="px-6 py-4 font-medium text-gray-900 light:text-white">
                            <label class="relative inline-flex items-center mb-5 cursor-pointer">
                                <input type="checkbox" value="Active" name="slotStatus" class="sr-only peer" <?php echo $value['status'] == 'Active' ? 'checked' : '';?>>
                                <div class="w-9 h-5 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 dark:peer-focus:ring-blue-800 rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-4 after:w-4 after:transition-all dark:border-gray-600 peer-checked:bg-blue-600"></div>
                            </label>
                        </td>
                        <td class="px-6 py-4 text-right">
                            <div class="inline-flex rounded-md shadow-sm" role="group">
                                <button type="submit" name="pathAction" value="Update-Slot" class="font-medium text-purple-600 dark:text-purple-500 hover:underline">Update</button>
                                <!-- <button type="submit" name="pathAction" value="Delete-Slot" class="font-medium text-red-600 dark:text-red-500 hover:underline" onclick="return confirm('Are you sure to delete the slot?');">Delete</button> -->
                            </div>
                        </td>
                    </tr>
                </form>    
            <?php }?>
        </tbody>
    </table>
</div>
<?php include "footer.php";?>