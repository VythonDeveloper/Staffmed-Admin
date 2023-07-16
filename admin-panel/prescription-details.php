<?php 
include "../constant.inc.php";
include "session.php";
$presOdId = 0;
if(isset($_GET['presOdId']) && $_GET['presOdId'] > 0){
    $presOdId = $_GET['presOdId'];
}else{
    header("Location:prescription-orders.php");
}
if(isset($_POST['add-med-to-prescription'])){
    if($_GET['presOdId'] == $_POST['presOdId']){
        $conn->query("Insert into prescription_products set 
        presId = '".$_POST['presOdId']."',
        name = '".$_POST['name']."',
        company = '".$_POST['company']."',
        dose = '".$_POST['dose']."',
        salePrice = '".$_POST['salePrice']."',
        quantity = '".$_POST['quantity']."'
        ");
        if($conn->affected_rows > 0){
            $totalAmount = $_POST['salePrice'] * $_POST['quantity'];
            $conn->query("Update prescription_orders set amount = amount + '$totalAmount' where id = '".$_POST['presOdId']."'");
        }
        header("Refresh:0");
    } else{
        header("Location:prescription-orders.php");
    }
}
if(isset($_POST['delete-med-from-prescription'])){
    if($_GET['presOdId'] == $_POST['presOdId']){
        $medPriceRes = $conn->query("Select salePrice, quantity from prescription_products where id = '".$_POST['ppMedId']."'");
        if($medPriceRes->num_rows > 0){
            $medData = $medPriceRes->fetch_assoc();
            $medPrice = $medData['salePrice'] * $medData['quantity'];
            $conn->multi_query("Delete from prescription_products where id = '".$_POST['ppMedId']."';
            Update prescription_orders set amount = amount - '$medPrice' where id = '".$_POST['presOdId']."'");
        }
        header("Refresh:0");
    } else{
        header("Location:prescription-orders.php");
    }
}
$presDetails = getPrescriptionDetails($presOdId);
include "header.php";
// print_r($presDetails);
?>

<div class="bg-white shadow-lg ring-1 ring-gray-200 rounded-lg p-6 my-10">
    <form method="POST">
        <input type="hidden" value="<?php echo $presDetails['id'];?>" name="presOdId"/>
        <div class="grid md:grid-cols-5 md:gap-3">
            <div class="relative z-0 w-full mb-2 group">
                <label for="name" class="block mb-2 text-sm font-medium text-gray-900 light:text-white">Name</label>
                <input type="text" id="name" name="name" class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 light:bg-gray-700 light:border-gray-600 light:placeholder-gray-400 light:text-white light:focus:ring-blue-500 light:focus:border-blue-500" placeholder="Medicine Name" required>
            </div>
            <div class="relative z-0 w-full mb-2 group">
                <label for="company" class="block mb-2 text-sm font-medium text-gray-900 light:text-white">Company</label>
                <input type="text" id="company" name="company" class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 light:bg-gray-700 light:border-gray-600 light:placeholder-gray-400 light:text-white light:focus:ring-blue-500 light:focus:border-blue-500" placeholder="Product Company" required>
            </div>
            <div class="relative z-0 w-full mb-2 group">
                <label for="dose" class="block mb-2 text-sm font-medium text-gray-900 light:text-white">Dose (mg)</label>
                <input type="number" id="dose" name="dose" class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 light:bg-gray-700 light:border-gray-600 light:placeholder-gray-400 light:text-white light:focus:ring-blue-500 light:focus:border-blue-500" placeholder="Product dose" required>
            </div>
            <div class="relative z-0 w-full mb-2 group">
                <label for="salePrice" class="block mb-2 text-sm font-medium text-gray-900 light:text-white">Sale Price</label>
                <input type="number" id="salePrice" name="salePrice" class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 light:bg-gray-700 light:border-gray-600 light:placeholder-gray-400 light:text-white light:focus:ring-blue-500 light:focus:border-blue-500" placeholder="0.0" onKeyup="calculateNetPayable();" required>
            </div>
            <div class="relative z-0 w-full mb-2 group">
                <label for="quantity" class="block mb-2 text-sm font-medium text-gray-900 light:text-white">Quantity</label>
                <input type="number" id="quantity" name="quantity" class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 light:bg-gray-700 light:border-gray-600 light:placeholder-gray-400 light:text-white light:focus:ring-blue-500 light:focus:border-blue-500" placeholder="0" onKeyup="calculateNetPayable();" required>
            </div>
        </div>
        <div class="grid md:grid-cols-2 md:gap-3">
            <div class="relative z-0 w-full mb-2 group">
                <label for="netPayable" class="block mb-2 text-sm font-medium text-gray-900 light:text-white">Net Payable</label>
                <input type="text" id="netPayable" name="netPayable" class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 light:bg-gray-700 light:border-gray-600 light:placeholder-gray-400 light:text-white light:focus:ring-blue-500 light:focus:border-blue-500" placeholder="Net Payable" required readonly value="<?php echo $presDetails['amount'];?>">
            </div>
            <div class="text-right my-5">
                <button type="submit" name="add-med-to-prescription" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center inline-flex items-center mr-2 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                    <svg class="mr-2" xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="16"/><line x1="8" y1="12" x2="16" y2="12"/></svg>
                    Add Medicine to Order
                </button>
            </div>
        </div>
    </form>
</div>

<div class="bg-white shadow-lg ring-1 ring-gray-200 rounded-lg p-6 my-10">
    <div class="grid md:grid-cols-5 md:gap-3">
        <?php $count = 1; foreach ($presDetails['prescriptions'] as $key => $value) { ?>
            <div class="flex items-center justify-center h-48 bg-gray-200 relative rounded">
                <img class="w-32 h-48 bg-cover bg-center" src="<?php echo $value['image'];?>"/>
                <span class="absolute top-1 left-1 bg-blue-500 text-white rounded p-1 text-sm"><?php echo $count++;?></span>
            </div>
        <?php } ?>
    </div>
</div>

<div class="bg-white shadow-lg ring-1 ring-gray-200 lg:rounded-lg p-10 my-10" id="print-area">
    <div class="text-right mb-10 no-print">
        <button type="button" id="download-invoice" onclick="downloadInvoice()" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center inline-flex items-center mr-2 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
            <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M3 17a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm3.293-7.707a1 1 0 011.414 0L9 10.586V3a1 1 0 112 0v7.586l1.293-1.293a1 1 0 111.414 1.414l-3 3a1 1 0 01-1.414 0l-3-3a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
            Download Invoice
        </button>
        <button type="button" id="print-invoice" onclick="printInvoice();" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center inline-flex items-center mr-2 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
        <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M5 4v3H4a2 2 0 00-2 2v3a2 2 0 002 2h1v2a2 2 0 002 2h6a2 2 0 002-2v-2h1a2 2 0 002-2V9a2 2 0 00-2-2h-1V4a2 2 0 00-2-2H7a2 2 0 00-2 2zm8 0H7v3h6V4zm0 8H7v4h6v-4z" clip-rule="evenodd"></path></svg>
            Print Invoice
        </button>
    </div>
    <div class="grid grid-cols-2 md:grid-cols-2 gap-4">
        <h1 class="text-3xl font-bold">Invoice #<?php echo $presDetails['refId'];?></h1>
        <div class="mb-3 text-right light:text-gray-400">
            <p class="text-xl font-bold">Staffmed</p>
            <p class="text-gray-500">Kolkata, Newtown</p>
            <p class="text-gray-500 mt-1"><?php echo $presDetails['date'];?></p>
        </div>
    </div>
    <div class="grid grid-cols-3 md:grid-cols-3 gap-4 my-10">
        <div class="mb-3 text-left light:text-gray-400">
            <p class="text-xl font-bold">Bill To</p>
            <p class="text-gray-500"><?php echo $presDetails['shippingAddress'];?></p>
        </div>
        <div></div>
        <div class="mb-3 text-left light:text-gray-400 text-right">
            <p class="text-sm">Delivery by</p>
            <p class="text-gray-500 font-bold"><?php echo $presDetails['dateRange'].' '.$presDetails['timeSlot'];?></p>
        </div>
    </div>

    <table class="w-full text-sm text-left text-gray-500 light:text-gray-400" id="dataTable">
        <thead class="text-gray-700 bg-gray-50 light:bg-gray-700 light:text-gray-400">
            <tr>
                <th scope="col" class="px-6 py-3">
                    Item
                </th>
                <th scope="col" class="px-6 py-3">
                    Price
                </th>
                <th scope="col" class="px-6 py-3">
                    Qty
                </th>
                <th scope="col" class="px-6 py-3">
                    Discount
                </th>
                <th scope="col" class="px-6 py-3 text-right">
                    Total
                </th>
                <th scope="col" class="px-6 py-3 text-right no-print">
                    Action
                </th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($presDetails['medicines'] as $value){ ?>
                <tr class="bg-white border-b light:bg-gray-800 light:border-gray-700 hover:bg-gray-50 light:hover:bg-gray-600">
                    <td class="px-6 py-4">
                        <p class="text-sm font-medium text-gray-900"><?php echo $value['name'];?></p>
                        <p class="text-sm text-gray-500"><?php echo $value['company'];?></p>
                    </td>
                    <td class="px-6 py-4">
                        ₹<?php echo $value['salePrice'];?>
                    </td>
                    <td class="px-6 py-4 font-medium text-gray-900 light:text-white">
                        <?php echo $value['quantity'];?>
                    </td>
                    <td class="px-6 py-4">
                        Applied
                    </td>
                    <td class="px-6 py-4 font-medium text-gray-900 light:text-white text-right">
                        ₹<?php echo $value['salePrice'] * $value['quantity'];?>
                    </td>
                    <td class="px-6 py-4 font-medium text-gray-900 light:text-white text-right no-print">
                        <form method="POST">
                            <input type="hidden" value="<?php echo $presDetails['id'];?>" name="presOdId"/>
                            <input type="hidden" value="<?php echo $value['id'];?>" name="ppMedId"/>
                            <button type="submit" name="delete-med-from-prescription" class="cursor-pointer px-3 py-2 text-xs font-medium text-center inline-flex items-center text-white bg-red-700 rounded-lg hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-800">
                                <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" fill="currentColor" class="bi bi-trash feather feather-edit" viewBox="0 0 16 16"> <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6z"/> <path fill-rule="evenodd" d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z"/> </svg>
                            </button>
                        </form>
                    </td>
                </tr>
            <?php }?>
        </tbody>    
    </table>
    <div class="grid grid-cols-4 md:grid-cols-4 gap-4 mt-5">
        <div></div>
        <div></div>
        <div class="mb-3 light:text-gray-400 text-right">
            <p class="text-sm">Subtotal</p>
        </div>
        <div class="mb-3 light:text-gray-400 text-right">
            <p class="text-sm">₹<?php echo $presDetails['amount'];?></p>
        </div>
    </div>
    <div class="grid grid-cols-4 md:grid-cols-4 gap-4">
        <div></div>
        <div></div>
        <div class="mb-3 light:text-gray-400 text-right">
            <p class="text-sm font-bold">Total</p>
        </div>
        <div class="mb-3 light:text-gray-400 text-right">
            <p class="text-sm font-bold">₹<?php echo $presDetails['amount'];?></p>
        </div>
    </div>
</div>
<script src= "https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.9.2/html2pdf.bundle.js"> </script>
<script>
    function calculateNetPayable(){
        let salePrice = document.getElementById("salePrice").value;
        let quantity = document.getElementById("quantity").value;
        let netPayable = "<?php echo $presDetails['amount'];?>";
        document.getElementById("netPayable").value = parseInt(netPayable) + (salePrice * quantity);
    }

    function printInvoice() {
        const originalContent = document.body.innerHTML;
        const printableContent = document.getElementById("print-area").cloneNode(true);
        // Remove the print and download buttons from the cloned content
        const noPrintElements = printableContent.getElementsByClassName('no-print');
        while (noPrintElements.length > 0) {
            noPrintElements[0].remove();
        }
        const printWindow = window.open('', '_blank');
        printWindow.document.open();
        printWindow.document.write(`
            <html>
            <head>
            <title>Staffmed | Invoice</title>
            <link href="https://cdnjs.cloudflare.com/ajax/libs/flowbite/1.6.3/flowbite.min.css" rel="stylesheet" />
            </head>
            <body>
            ${printableContent.innerHTML}
            </body>
            </html>
        `);
        printWindow.document.close();
        printWindow.addEventListener('load', () => {
            printWindow.print();
            printWindow.close();
            document.body.innerHTML = originalContent;
        });
    }

    function downloadInvoice() {
        var element = document.getElementById("print-area");
        var opt = {
        margin:       0,
        filename:     '<?php echo $presDetails['refId'];?>.pdf',
        image:        { type: 'jpeg', quality: 0.98 },
        html2canvas:  { scale: 2 },
        jsPDF:        { unit: 'in', format: 'a4', orientation: 'portrait' }
        };
        html2pdf().set(opt).from(element).save();
    }
</script>
<?php include "footer.php";?>