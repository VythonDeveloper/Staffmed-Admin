<?php 
include "session.php";
include "header.php";
include "../constant.inc.php";
?>

<form method="POST" enctype="multipart/form-data" onsubmit="publishMedicine(); return false;">
    <section class="flex flex-col w-full h-full p-1 overflow-auto">
        <header class=" flex flex-col items-center justify-center text-base transition duration-500 ease-in-out transform bg-white border border-dashed rounded-lg text-blueGray-500 focus:border-blue-500 focus:outline-none focus:shadow-outline focus:ring-2 ring-offset-current ring-offset-2 ">
            <p class=" flex flex-wrap justify-center mb-3 text-base leading-7 text-blueGray-500 "></p>
            <img style="background-color: #eaebeb; width: 300px; height: 200px;" id="imagePreview">
            <input type="file" id="productImg" name="productImg" accept=".jpg, .png, .jpeg, .webp" onchange="previewImage(this);" style="display: none;">
            <button type="button" class=" w-auto px-2 py-1 my-2 mr-2 transition duration-500 ease-in-out transform border rounded-md text-blueGray-500 hover:text-blueGray-600 text-md focus:shadow-outline focus:outline-none focus:ring-2 ring-offset-current ring-offset-2 hover:bg-blueGray-100 " onclick="document.getElementById('productImg').click();"> Upload medicine image </button>
        </header>
    </section>
    <div class="grid md:grid-cols-2 md:gap-6">
        <div class="relative z-0 w-full mb-6 group">
            <label for="name" class="block mb-2 text-sm font-medium text-gray-900 light:text-white">Name</label>
            <input type="text" id="name" name="name" class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 light:bg-gray-700 light:border-gray-600 light:placeholder-gray-400 light:text-white light:focus:ring-blue-500 light:focus:border-blue-500" placeholder="Medicine Name" required>
        </div>
        <div class="relative z-0 w-full mb-6 group">
            <label for="company" class="block mb-2 text-sm font-medium text-gray-900 light:text-white">Company</label>
            <input type="text" id="company" name="company" class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 light:bg-gray-700 light:border-gray-600 light:placeholder-gray-400 light:text-white light:focus:ring-blue-500 light:focus:border-blue-500" placeholder="Product Company" required>
        </div>
    </div>
    <div class="grid md:grid-cols-2 md:gap-6">
        <div class="relative z-0 w-full mb-6 group">
            <label for="dose" class="block mb-2 text-sm font-medium text-gray-900 light:text-white">Dose(mg)</label>
            <input type="number" id="dose" name="dose" class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 light:bg-gray-700 light:border-gray-600 light:placeholder-gray-400 light:text-white light:focus:ring-blue-500 light:focus:border-blue-500" placeholder="Dose in mg" required>
        </div>
        <div class="relative z-0 w-full mb-6 group">
        <label for="availability" class="block mb-2 text-sm font-medium text-gray-900 light:text-white">Availability</label>
            <label class="relative inline-flex items-center mr-5 cursor-pointer">
                <input type="checkbox" value="Active" class="sr-only peer" id="availability" name="availability" checked onchange="changeToggleLabel();">
                <div class="w-11 h-6 bg-red-300 rounded-full peer light:bg-gray-700 peer-focus:ring-4 peer-focus:ring-green-300 light:peer-focus:ring-green-800 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-0.5 after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all light:border-gray-600 peer-checked:bg-green-600"></div>
                <span class="ml-3 text-sm font-medium text-gray-900 light:text-gray-300" id="availabilityLabel">In-Stock</span>
            </label>
        </div>
    </div>
    <div class="grid md:grid-cols-3 md:gap-6">
        <div class="relative z-0 w-full mb-6 group">
            <label for="price" class="block mb-2 text-sm font-medium text-gray-900 light:text-white">Price(₹)</label>
            <input type="number" id="price" name="price" class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 light:bg-gray-700 light:border-gray-600 light:placeholder-gray-400 light:text-white light:focus:ring-blue-500 light:focus:border-blue-500" onkeyup="calculateDiscountPrice();" required>
        </div>
        <div class="relative z-0 w-full mb-6 group">
            <label for="discount" class="block mb-2 text-sm font-medium text-gray-900 light:text-white">Discount(%)</label>
            <input type="number" max="100" id="discount" name="discount" class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 light:bg-gray-700 light:border-gray-600 light:placeholder-gray-400 light:text-white light:focus:ring-blue-500 light:focus:border-blue-500" onkeyup="calculateDiscountPrice();" required>
        </div>
        <div class="relative z-0 w-full mb-6 group">
            <label for="discountPrice" class="block mb-2 text-sm font-medium text-gray-900 light:text-white">Discounted Price(₹)</label>
            <input type="number" id="discountPrice" name="discountPrice" class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 light:bg-gray-700 light:border-gray-600 light:placeholder-gray-400 light:text-white light:focus:ring-blue-500 light:focus:border-blue-500" readonly>
        </div>
    </div>
    <button type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Publish Medicine</button>
</form>

<script>
    let productStock = "In-Stock";


    function _(el){
        return document.getElementById(el);
    }
    function changeToggleLabel(){
        if(_("availability").checked){
            _("availabilityLabel").innerHTML = "In-Stock";
            productStock = "In-Stock";
        } else{
            _("availabilityLabel").innerHTML = "Out-of-Stock";
            productStock = "Out-of-Stock";
        }
    }

    function previewImage(input) {
        if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function (e) {
            $('#imagePreview')
            .attr('src', e.target.result)
            .width(300)
            .height(200);
        };
        reader.readAsDataURL(input.files[0]);
        }
    }

    function calculateDiscountPrice() {
        let price = _("price").value;
        let discount = _("discount").value;
        _("discountPrice").value = price - (price * discount)/100;
    }

    function publishMedicine(){
        var imageFile =_('productImg'); 
        var fileLength = imageFile.files.length;
        var formdata = new FormData();
        if(fileLength > 0){
            fileName = imageFile.files[0].name;
            var fileSize = (imageFile.files[0].size / 1024 / 1024).toFixed(2); 
            var fileType = fileName.slice((fileName.lastIndexOf(".") - 1 >>> 0) + 2);
            var allowedImageExtList = ["jpeg", "jpg", "png", "webp"];
            
            if(fileSize <= 3.00 && allowedImageExtList.includes(fileType)){
                var imageRawFile = _("productImg").files[0];
                formdata.append("productImg", imageRawFile);
            }
            else{
              alert("Product Image must be within 3 mb.");
              return false;
            }
            formdata.append("name", _("name").value);
            formdata.append("company", _('company').value);
            formdata.append("dose", _('dose').value);
            formdata.append("availability", productStock);
            formdata.append("price", _('price').value);
            formdata.append("discount", _('discount').value);
            formdata.append("from",'Publish-Medicine');
            var ajax = new XMLHttpRequest();
            ajax.addEventListener("load", completeHandler, false);
            ajax.addEventListener("error", errorHandler, false);
            ajax.open("POST", "<?php echo Base_Url;?>"+"/medicine-assets/publish-medicine-controller.php");
            ajax.send(formdata);
        }
        else{
            alert("Product Image is required");
              return false;
        }
    }

    function completeHandler(event){
        var response = JSON.parse(event.target.responseText);
        // alert(response.message);
        if(response.error == false){
            alert(response.message);
        } else{
            alert(response.message);
        }
    }

    function errorHandler(event){
        alert("Status : Upload Failed");
    }
</script>
<?php include "footer.php";?>