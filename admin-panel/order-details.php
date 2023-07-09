<?php 
include "../constant.inc.php";
include "session.php";
$orderId = 0;
if(isset($_GET['orderId']) && $_GET['orderId'] > 0){
    $orderId = $_GET['orderId'];
}else{
    header("Location:manage-orders.php");
}
$orderDetails = getOrderDetails($orderId);
include "header.php";
?>


<div class="text-right my-5">
    <button type="button" id="download-invoice" onclick="downloadInvoice()" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center inline-flex items-center mr-2 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
        <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M3 17a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm3.293-7.707a1 1 0 011.414 0L9 10.586V3a1 1 0 112 0v7.586l1.293-1.293a1 1 0 111.414 1.414l-3 3a1 1 0 01-1.414 0l-3-3a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
        Download Invoice
    </button>
    <button type="button" id="print-invoice" onclick="printInvoice();" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center inline-flex items-center mr-2 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
    <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M5 4v3H4a2 2 0 00-2 2v3a2 2 0 002 2h1v2a2 2 0 002 2h6a2 2 0 002-2v-2h1a2 2 0 002-2V9a2 2 0 00-2-2h-1V4a2 2 0 00-2-2H7a2 2 0 00-2 2zm8 0H7v3h6V4zm0 8H7v4h6v-4z" clip-rule="evenodd"></path></svg>
        Print Invoice
    </button>
</div>

<div class="relative overflow-x-auto shadow-lg lg:rounded-lg p-10" id="print-area">
    <div class="grid grid-cols-2 md:grid-cols-2 gap-4">
        <h1 class="text-3xl font-bold">Invoice #<?php echo $orderDetails['refId'];?></h1>
        <div class="mb-3 text-right light:text-gray-400">
            <p class="text-xl font-bold">Staffmed</p>
            <p class="text-gray-500">Kolkata, Newtown</p>
            <p class="text-gray-500 mt-1"><?php echo $orderDetails['date'];?></p>
        </div>
    </div>
    <div class="grid grid-cols-3 md:grid-cols-3 gap-4 my-10">
        <div class="mb-3 text-left light:text-gray-400">
            <p class="text-xl font-bold">Bill To</p>
            <p class="text-gray-500"><?php echo $orderDetails['shippingAddress'];?></p>
        </div>
        <div></div>
        <div class="mb-3 text-left light:text-gray-400 text-right">
            <p class="text-sm">Delivery by</p>
            <p class="text-gray-500 font-bold"><?php echo $orderDetails['dateRange'].' '.$orderDetails['timeSlot'];?></p>
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
            </tr>
        </thead>
        <tbody>
            <?php foreach($orderDetails['orderedProducts'] as $value){ ?>
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
            <p class="text-sm">₹<?php echo $orderDetails['amount'];?></p>
        </div>
    </div>
    <div class="grid grid-cols-4 md:grid-cols-4 gap-4">
        <div></div>
        <div></div>
        <div class="mb-3 light:text-gray-400 text-right">
            <p class="text-sm font-bold">Total</p>
        </div>
        <div class="mb-3 light:text-gray-400 text-right">
            <p class="text-sm font-bold">₹<?php echo $orderDetails['amount'];?></p>
        </div>
    </div>
</div>
<script src= "https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.9.2/html2pdf.bundle.js"> </script>
<script>
    function printInvoice() {
        const originalContent = document.body.innerHTML;
        const printableContent = document.getElementById("print-area").cloneNode(true);
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
        filename:     '<?php echo $orderDetails['refId'];?>.pdf',
        image:        { type: 'jpeg', quality: 0.98 },
        html2canvas:  { scale: 2 },
        jsPDF:        { unit: 'in', format: 'a4', orientation: 'portrait' }
        };
        html2pdf().set(opt).from(element).save();
    }
</script>
<?php include "footer.php";?>