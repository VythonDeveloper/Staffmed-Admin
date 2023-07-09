<?php 
include "header.php"; 
$userData = getAppUsers();
?>
          
<div class="relative overflow-x-auto shadow-md sm:rounded-lg">
    <div class="p-4 bg-white light:bg-gray-900">
        <label for="table-search" class="sr-only">Search</label>
        <div class="relative mt-1">
            <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                <svg class="w-5 h-5 text-gray-500 light:text-gray-400" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd"></path></svg>
            </div>
            <input type="text" id="table-search" class="block p-2 pl-10 text-sm text-gray-900 border border-gray-300 rounded-lg w-80 bg-gray-50 focus:ring-blue-500 focus:border-blue-500 light:bg-gray-700 light:border-gray-600 light:placeholder-gray-400 light:text-white light:focus:ring-blue-500 light:focus:border-blue-500" placeholder="Search for users by name" onkeyup="searchTableFunction(1)">
        </div>
    </div>
    <table class="w-full text-sm text-left text-gray-500 light:text-gray-400" id="dataTable">
        <thead class="text-gray-700 bg-gray-50 light:bg-gray-700 light:text-gray-400">
            <tr>
                <th scope="col" class="px-6 py-3">
                    #
                </th>
                <th scope="col" class="px-6 py-3">
                    Fullname
                </th>
                <th scope="col" class="px-6 py-3">
                    Phone | Email
                </th>
                <th scope="col" class="px-6 py-3">
                    Wallet
                </th>
                <th scope="col" class="px-6 py-3">
                    Bank Details
                </th>
                <th scope="col" class="px-6 py-3 text-right">
                    Action
                </th>
            </tr>
        </thead>
        <tbody>
            <?php
            foreach($userData as $value){ ?>
                <tr class="bg-white border-b light:bg-gray-800 light:border-gray-700 hover:bg-gray-50 light:hover:bg-gray-600">
                    <th class="px-6 py-4">
                        <?php echo $value['id'];?>
                    </th>
                    <td class="px-6 py-4 font-medium text-gray-900 light:text-white">
                        <?php echo $value['fullname'];?>
                    </td>
                    <td class="px-6 py-4 font-medium text-gray-900 light:text-white">
                        +91 <?php echo $value['phone'].'<br>'.$value['email'];?>
                    </td>
                    <td class="px-6 py-4 font-medium text-gray-900 light:text-white">
                        ₹ <?php echo $value['wallet'];?>
                    </td>
                    <td class="px-6 py-4 font-medium text-gray-900 light:text-white">
                        <?php 
                            if($value['bankDetails'] != null){
                                $bankDetails = "Bank Name: ".$value['bankDetails']['bankName']."<br>A/c No.: ".$value['bankDetails']['accNo']."<br>IFSC Code: ".$value['bankDetails']['ifscCode']."<br>Holder: ".$value['bankDetails']['acHolderName'];
                            } else{
                                $bankDetails = '-';
                            }
                            echo $bankDetails;
                        ?>
                    </td>
                    <td class="px-6 py-4 text-right">
                        <a href="javascript:void(0);" onclick="setDepositModal('<?php echo $value['id'];?>', '<?php echo $value['fullname'];?>', '<?php echo $value['phone'];?>', '<?php echo $value['email'];?>')" class="font-medium text-blue-600 dark:text-blue-500 hover:underline">Edit</a>
                    </td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</div>


<!-- Modal toggle -->
<button data-modal-target="deposit-modal" data-modal-toggle="deposit-modal" class="block text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center light:bg-blue-600 light:hover:bg-blue-700 light:focus:ring-blue-800 hidden" type="button" id="openDepositModalButton">
  Toggle modal
</button>

<!-- Main modal -->
<div id="deposit-modal" tabindex="-1" aria-hidden="true" class="fixed top-0 left-0 right-0 z-50 hidden w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-modal md:h-full">
    <div class="relative w-full h-full max-w-md md:h-auto">
        <!-- Modal content -->
        <div class="relative bg-white rounded-lg shadow light:bg-gray-700">
            <button type="button" class="absolute top-3 right-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center light:hover:bg-gray-800 light:hover:text-white" data-modal-hide="deposit-modal">
                <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                <span class="sr-only">Close modal</span>
            </button>
            <div class="px-6 py-6 lg:px-8">
                <h3 class="mb-4 text-xl font-medium text-gray-900 light:text-white">Add Money to Wallet</h3>
                <form class="space-y-6" action="./controllers/deposit-controller.php" method="POST">
                    <input type="hidden" id="beneficiaryId" name="beneficiaryId" value="0">
                    <div>
                        <label class="block text-sm font-medium text-gray-900 light:text-white">Fullname</label>
                        <p id="beneficiaryName">-</p>
                    </div>
                    <div class="grid md:grid-cols-2 md:gap-6">
                        <div class="relative z-0 w-full group">
                            <label class="block text-sm font-medium text-gray-900 light:text-white">Phone</label>
                            <p id="beneficiaryPhone">-</p>
                        </div>
                        <div class="relative z-0 w-full group">
                            <label class="block text-sm font-medium text-gray-900 light:text-white">Email</label>
                            <p id="beneficiaryEmail">-</p>
                        </div>
                    </div>
                    <div>
                        <label for="depositAmount" class="block mb-2 text-sm font-medium text-gray-900 light:text-white">Amount to deposit</label>
                        <input type="number" name="depositAmount" id="depositAmount" placeholder="0.0" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 light:bg-gray-600 light:border-gray-500 light:placeholder-gray-400 light:text-white" required>
                    </div>
                    <button type="submit" name="pathAction" value="Deposit-Wallet-Amount" class="w-full text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center light:bg-blue-600 light:hover:bg-blue-700 light:focus:ring-blue-800">Verify & Deposit</button>
                </form>
            </div>
        </div>
    </div>
</div> 

<script>
    function _(el){
        return document.getElementById(el);
    }

    function setDepositModal(id, fullname, phone, email){
        _("beneficiaryId").value = id;
        _("beneficiaryName").innerHTML = fullname;
        _("beneficiaryPhone").innerHTML = phone;
        _("beneficiaryEmail").innerHTML = email;
        _("openDepositModalButton").click();
    }
</script>
<?php include "footer.php";?>