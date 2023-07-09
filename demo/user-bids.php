<?php include "header.php";
$gameType = "Single Ank";
if(isset($_GET['gameType'])){
    $gameType = $_GET['gameType'];
}
$bidsData = getUserBids($gameType);
?>
<div class="relative overflow-x-auto shadow-md sm:rounded-lg">
    <ul class="flex flex-wrap items-center justify-center mb-6 text-gray-900 light:text-white pt-4">
        <li>
            <a href="user-bids.php?gameType=Single Ank" class="mr-4 hover:underline md:mr-6 <?php echo $gameType == 'Single Ank'? ' font-semibold w-10 h-10 p-2 rounded-full ring-2 ring-green-300 dark:ring-green-500 text-green-700' : '';?>">Single Ank</a>
        </li>
        <li>
            <a href="user-bids.php?gameType=Jodi" class="mr-4 hover:underline md:mr-6 <?php echo $gameType == 'Jodi'? ' font-semibold w-10 h-10 p-2 rounded-full ring-2 ring-green-300 dark:ring-green-500 text-green-700' : '';?>">Jodi</a>
        </li>
        <li>
            <a href="user-bids.php?gameType=Single Patti" class="mr-4 hover:underline md:mr-6 <?php echo $gameType == 'Single Patti'? ' font-semibold w-10 h-10 p-2 rounded-full ring-2 ring-green-300 dark:ring-green-500 text-green-700' : '';?>">Single Patti</a>
        </li>
        <li>
            <a href="user-bids.php?gameType=Double Patti" class="mr-4 hover:underline md:mr-6 <?php echo $gameType == 'Double Patti'? ' font-semibold w-10 h-10 p-2 rounded-full ring-2 ring-green-300 dark:ring-green-500 text-green-700' : '';?>">Double Patti</a>
        </li>
        <li>
            <a href="user-bids.php?gameType=Triple Patti" class="mr-4 hover:underline md:mr-6 <?php echo $gameType == 'Triple Patti'? ' font-semibold w-10 h-10 p-2 rounded-full ring-2 ring-green-300 dark:ring-green-500 text-green-700' : '';?>">Triple Patti</a>
        </li>
        <li>
            <a href="user-bids.php?gameType=Half Sangam" class="mr-4 hover:underline md:mr-6 <?php echo $gameType == 'Half Sangam'? ' font-semibold w-10 h-10 p-2 rounded-full ring-2 ring-green-300 dark:ring-green-500 text-green-700' : '';?>">Half Sangam</a>
        </li>
        <li>
            <a href="user-bids.php?gameType=Full Sangam" class="mr-4 hover:underline md:mr-6 <?php echo $gameType == 'Full Sangam'? ' font-semibold w-10 h-10 p-2 rounded-full ring-2 ring-green-300 dark:ring-green-500 text-green-700' : '';?>">Full Sangam</a>
        </li>
    </ul>
    <div class="pl-4 pb-4 bg-white light:bg-gray-900">
        <label for="table-search" class="sr-only">Search</label>
        <div class="relative mt-1">
            <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                <svg class="w-5 h-5 text-gray-500 light:text-gray-400" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd"></path></svg>
            </div>
            <input type="text" id="table-search" class="block p-2 pl-10 text-sm text-gray-900 border border-gray-300 rounded-lg w-80 bg-gray-50 focus:ring-blue-500 focus:border-blue-500 light:bg-gray-700 light:border-gray-600 light:placeholder-gray-400 light:text-white light:focus:ring-blue-500 light:focus:border-blue-500" placeholder="Search for records by order-id" onkeyup="searchTableFunction(0)">
        </div>
    </div>
    <table class="w-full text-sm text-left text-gray-500 light:text-gray-400" id="dataTable">
        <thead class="text-gray-700 bg-gray-50 light:bg-gray-700 light:text-gray-400">
            <tr>
                <th scope="col" class="px-6 py-3 text-left">
                    Market
                </th>
                <th scope="col" class="px-6 py-3">
                    User
                </th>

                <?php if($gameType == "Single Ank"){ ?>
                    <th scope="col" class="px-6 py-3">
                        Ank
                    </th>
                <?php } else if($gameType == "Jodi"){ ?>
                    <th scope="col" class="px-6 py-3">
                        Jodi
                    </th>
                <?php } else if($gameType == "Single Patti" || $gameType == "Double Patti" || $gameType == "Triple Patti"){ ?>
                    <th scope="col" class="px-6 py-3">
                        Panna
                    </th>
                <?php } else if($gameType == "Half Sangam"){ ?>
                    <th scope="col" class="px-6 py-3">
                        Sangam
                    </th>
                <?php } else if($gameType == "Full Sangam"){ ?>
                    <th scope="col" class="px-6 py-3">
                        Open Panna
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Close Panna
                    </th>
                <?php } ?>

                <?php if($gameType != "Jodi" && $gameType != "Full Sangam"){?>
                    <th scope="col" class="px-6 py-3">
                        Type
                    </th>
                <?php } ?>

                <th scope="col" class="px-6 py-3">
                    Points
                </th>
                <th scope="col" class="px-6 py-3">
                    Status
                </th>
                <th scope="col" class="px-6 py-3 text-right">
                    Date
                </th>
            </tr>
        </thead>
        <tbody>
            <?php
            foreach($bidsData as $value){ ?>
                <tr class="bg-white border-b light:bg-gray-800 light:border-gray-700 hover:bg-gray-50 light:hover:bg-gray-600">
                    <td class="px-6 py-4 font-medium text-gray-900 light:text-white">
                        <?php echo $value['title'];?>
                    </td>
                    <td class="px-6 py-4 font-medium text-gray-900 light:text-white">
                        <?php echo $value['fullname'].',<br>+91'.$value['phone'];?>
                    </td>

                    <?php if($gameType == "Single Ank"){ ?>
                        <td class="px-6 py-4 font-medium text-gray-900 light:text-white">
                            <?php echo $value['ank'];?>
                        </td>
                    <?php } else if($gameType == "Jodi"){ ?>
                        <td class="px-6 py-4 font-medium text-gray-900 light:text-white">
                            <?php echo $value['jodi'];?>
                        </td>
                    <?php } else if($gameType == "Single Patti" || $gameType == "Double Patti" || $gameType == "Triple Patti"){ ?>
                        <td class="px-6 py-4 font-medium text-gray-900 light:text-white">
                            <?php echo $value['panna'];?>
                        </td>
                    <?php } else if($gameType == "Half Sangam"){ ?>
                        <td class="px-6 py-4 font-medium text-gray-900 light:text-white">
                            <?php echo $value['type'] == "OACP" ? $value['ank'].'-'.$value['panna'] : $value['panna'].'-'.$value['ank'];?>
                        </td>
                    <?php } else if($gameType == "Full Sangam"){ ?>
                        <td class="px-6 py-4 font-medium text-gray-900 light:text-white">
                            <?php echo $value['openPanna'];?>
                        </td>
                        <td class="px-6 py-4 font-medium text-gray-900 light:text-white">
                            <?php echo $value['closePanna'];?>
                        </td>
                    <?php } ?>

                    <?php if($gameType != "Jodi" && $gameType != "Full Sangam"){?>
                        <td class="px-6 py-4 font-medium text-gray-900 light:text-white">
                            <?php echo $value['type'];?>
                        </td>
                    <?php } ?>




                    
                    <td class="px-6 py-4 font-medium text-gray-900 light:text-white">
                        ₹ <?php echo $value['points'];?>
                    </td>
                    <td class="px-6 py-4 font-medium text-gray-900 light:text-white ">
                        <?php echo $value['status'];?>
                    </td>
                    <td class="px-6 py-4 font-medium text-gray-900 light:text-white text-right">
                        <?php echo $value['playDate'];?>
                    </td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</div>

<?php include "footer.php";?>