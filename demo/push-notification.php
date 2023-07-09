<?php 
include "header.php";
$noticeData = getNotifications();
?>

<form method="POST" action="./controllers/notification-controller.php">
    <div class="grid md:grid-cols-5 md:gap-6">
        <div class="relative z-0 w-full mb-6 group">
            <label for="priority" class="block mb-2 text-sm font-medium text-gray-900 light:text-white">Priority</label>
            <div class="flex items-center mb-4">
                <input id="country-option-1" type="radio" name="priority" value="Important" class="w-4 h-4 border-gray-300 focus:ring-2 focus:ring-red-300 light:focus:ring-red-600 light:focus:bg-red-600 light:bg-gray-700 light:border-gray-600 checked:bg-red-700" checked>
                <label for="country-option-1" class="block ml-2 text-sm font-medium text-gray-900 light:text-gray-300">
                Important
                </label>
            </div>
            <div class="flex items-center mb-4">
                <input id="country-option-2" type="radio" name="priority" value="Normal" class="w-4 h-4 border-gray-300 focus:ring-2 focus:ring-blue-300 light:focus:ring-blue-600 light:focus:bg-blue-600 light:bg-gray-700 light:border-gray-600">
                <label for="country-option-2" class="block ml-2 text-sm font-medium text-gray-900 light:text-gray-300">
                Normal
                </label>
            </div>
        </div>
        <div class="relative z-0 w-full mb-6 group col-span-2">
            <label for="title" class="block mb-2 text-sm font-medium text-gray-900 light:text-white">Heading</label>
            <input type="text" id="title" name="title" class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 light:bg-gray-700 light:border-gray-600 light:placeholder-gray-400 light:text-white light:focus:ring-blue-500 light:focus:border-blue-500" placeholder="Heading" required>
        </div>
        <div class="relative z-0 w-full mb-6 group col-span-2">
            <label for="content" class="block mb-2 text-sm font-medium text-gray-900 light:text-white">Message Content</label>
            <textarea id="content" name="content" rows="4" class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 light:bg-gray-700 light:border-gray-600 light:placeholder-gray-400 light:text-white light:focus:ring-blue-500 light:focus:border-blue-500" placeholder="Type content here ...."></textarea>
        </div>
    </div>
    <button type="submit" name="pathAction" value="Push-Notification" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center light:bg-blue-600 light:hover:bg-blue-700 light:focus:ring-blue-800">Send Notification</button>
</form>
<hr class="my-8">
<div class="relative overflow-x-auto shadow-md sm:rounded-lg">
    <table class="table-fixed text-sm text-left text-gray-500 light:text-gray-400" id="dataTable">
        <thead class="text-gray-700 bg-gray-50 light:bg-gray-700 light:text-gray-400">
            <tr>
                <th scope="col" class="px-6 py-3">
                    Priority
                </th>
                <th scope="col" class="px-6 py-3">
                    Title
                </th>
                <th scope="col" class="px-6 py-3">
                    Content
                </th>
                <th scope="col" class="px-6 py-3 text-right">
                    Date
                </th>
            </tr>
        </thead>
        <tbody>
            <?php
            foreach($noticeData as $value){ ?>
                <tr class="bg-white border-b light:bg-gray-800 light:border-gray-700 hover:bg-gray-50 light:hover:bg-gray-600">
                    <td class="px-6 py-4 font-medium text-gray-900 light:text-white">
                        <span class="inline-flex items-center justify-center w-4 h-4 ml-2 text-xs font-semibold  <?php echo $value['priority'] == 'Normal' ? 'bg-blue-600' : 'bg-red-700';?> rounded-full"></span>
                    </td>
                    <td class="px-6 py-4 font-medium text-gray-900 light:text-white">
                        <?php echo $value['title'];?>
                    </td>
                    <td class="px-6 py-4 font-medium text-gray-900 light:text-white">
                        <?php echo $value['content'];?>
                    </td>
                    <td class="px-6 py-4 font-medium text-gray-900 light:text-white">
                        <?php echo $value['date'];?>
                    </td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</div>

<?php include "footer.php";?>