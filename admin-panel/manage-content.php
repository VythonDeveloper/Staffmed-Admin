<?php 
include "../constant.inc.php";
include "session.php";
$vendorData = getVendorData();
include "header.php";
?>

<form method="POST" enctype="multipart/form-data" onsubmit="updateRestaurant(); return false;" id="update-form">

    <div class="grid md:grid-cols-2 md:gap-6">
        <div class="relative z-0 w-full mb-6 group">
            <label for="coverImagePreview" class="block mb-2 text-sm font-medium text-gray-900 light:text-white">Cover Image</label>
            <img class="rounded-lg" src="<?php echo $vendorData['coverImage'];?>" alt="image description" id="coverImagePreview" style="height:250px; width:400px">
        </div>
        <div class="relative z-0 w-full mb-6 group">
            <label class="block mb-2 text-sm font-medium text-gray-900 light:text-white" for="coverImage">Update Cover Image</label>
            <input class="block w-full mb-5 text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 light:text-gray-400 focus:outline-none light:bg-gray-700 light:border-gray-600 light:placeholder-gray-400" id="coverImage" type="file" accept=".jpg, .png, .jpeg, .webp" onchange="previewImage(this);">

            <label for="description" class="block mb-2 text-sm font-medium text-gray-900 light:text-white">Small Description</label>
            <textarea id="description" name="description" rows="4" class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 light:bg-gray-700 light:border-gray-600 light:placeholder-gray-400 light:text-white light:focus:ring-blue-500 light:focus:border-blue-500" placeholder="Type content here ...."><?php echo $vendorData['description'];?></textarea>
        </div>
    </div>

    <div class="grid md:grid-cols-2 md:gap-6">
        <div class="relative z-0 w-full mb-6 group">
            <label for="name" class="block mb-2 text-sm font-medium text-gray-900 light:text-white">Name</label>
            <input type="text" id="name" name="name" class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 light:bg-gray-700 light:border-gray-600 light:placeholder-gray-400 light:text-white light:focus:ring-blue-500 light:focus:border-blue-500" placeholder="Restaurant Name" value="<?php echo $vendorData['name'];?>" required>
        </div>
        <div class="relative z-0 w-full mb-6 group">
            <label for="executiveName" class="block mb-2 text-sm font-medium text-gray-900 light:text-white">Executive Name</label>
            <input type="text" id="executiveName" name="executiveName" class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 light:bg-gray-700 light:border-gray-600 light:placeholder-gray-400 light:text-white light:focus:ring-blue-500 light:focus:border-blue-500" placeholder="Executive Name" value="<?php echo $vendorData['executiveName'];?>" required>
        </div>
        <!-- <div class="relative z-0 w-full mb-6 group">
            <label for="marketStatus" class="block mb-2 text-sm font-medium text-gray-900 light:text-white">Market Status</label>
            <label class="relative inline-flex items-center mr-5 cursor-pointer">
                <input type="checkbox" value="Active" class="sr-only peer" id="marketStatus" name="marketStatus" checked onchange="changeToggleLabel();">
                <div class="w-11 h-6 bg-red-300 rounded-full peer light:bg-gray-700 peer-focus:ring-4 peer-focus:ring-green-300 light:peer-focus:ring-green-800 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-0.5 after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all light:border-gray-600 peer-checked:bg-green-600"></div>
                <span class="ml-3 text-sm font-medium text-gray-900 light:text-gray-300" id="marketStatusLabel">Market is Active</span>
            </label>
        </div> -->
    </div>

    <div class="grid md:grid-cols-2 md:gap-6">
        <div class="relative z-0 w-full mb-6 group">
            <label for="emailAddress" class="block mb-2 text-sm font-medium text-gray-900 light:text-white">Email</label>
            <input type="email" id="emailAddress" name="emailAddress" class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 light:bg-gray-700 light:border-gray-600 light:placeholder-gray-400 light:text-white light:focus:ring-blue-500 light:focus:border-blue-500" value="<?php echo $vendorData['email'];?>" required>
        </div>
        <div class="relative z-0 w-full mb-6 group">
            <label for="tableCost" class="block mb-2 text-sm font-medium text-gray-900 light:text-white">Table Cost Approx.</label>
            <input type="text" id="tableCost" name="tableCost" class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 light:bg-gray-700 light:border-gray-600 light:placeholder-gray-400 light:text-white light:focus:ring-blue-500 light:focus:border-blue-500" value="<?php echo $vendorData['approxTableCost'];?>" required>
        </div>
    </div>

    <div class="grid md:grid-cols-2 md:gap-6">
        <div class="relative z-0 w-full mb-6 group">
            <label for="openTime" class="block mb-2 text-sm font-medium text-gray-900 light:text-white">Open Time</label>
            <input type="time" id="openTime" name="openTime" class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 light:bg-gray-700 light:border-gray-600 light:placeholder-gray-400 light:text-white light:focus:ring-blue-500 light:focus:border-blue-500" value="<?php echo $vendorData['openTime'];?>" required>
        </div>
        <div class="relative z-0 w-full mb-6 group">
            <label for="closeTime" class="block mb-2 text-sm font-medium text-gray-900 light:text-white">Close Time</label>
            <input type="time" id="closeTime" name="closeTime" class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 light:bg-gray-700 light:border-gray-600 light:placeholder-gray-400 light:text-white light:focus:ring-blue-500 light:focus:border-blue-500" value="<?php echo $vendorData['closeTime'];?>" required>
        </div>
    </div>

    <div class="grid md:grid-cols-2 md:gap-6">
        <div class="relative z-0 w-full mb-6 group">
            <label for="city" class="block mb-2 text-sm font-medium text-gray-900 light:text-white">City</label>
            <input type="text" id="city" class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 light:bg-gray-700 light:border-gray-600 light:placeholder-gray-400 light:text-white light:focus:ring-blue-500 light:focus:border-blue-500" placeholder="City" value="<?php echo $vendorData['city'];?>" required readonly>
        </div>
        <div class="relative z-0 w-full mb-6 group">
            <label for="address" class="block mb-2 text-sm font-medium text-gray-900 light:text-white">Complete Address</label>
            <textarea id="address" name="address" rows="4" class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 light:bg-gray-700 light:border-gray-600 light:placeholder-gray-400 light:text-white light:focus:ring-blue-500 light:focus:border-blue-500" placeholder="Complete Address ...."><?php echo $vendorData['address'];?></textarea>
        </div>

    </div>

    <button type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Update Information</button>
</form>


<?php include "footer.php";?>
<script>
    function _(el){
        return document.getElementById(el);
    }

    function previewImage(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function (e) {
                $('#coverImagePreview')
                .attr('src', e.target.result)
                .width(400)
                .height(250);
            };
            reader.readAsDataURL(input.files[0]);
        }
    }

    // function changeToggleLabel(){
    //     if(_("marketStatus").checked){
    //         _("marketStatusLabel").innerHTML = "Market is Active";
    //     } else{
    //         _("marketStatusLabel").innerHTML = "Market is Inactive";
    //     }
    // }


    function updateRestaurant(){
        // alert('jdjdj');
        var imageFile =_('coverImage'); 
        var fileLength = imageFile.files.length;
        var formdata = new FormData();
        if(fileLength > 0){
            fileName = imageFile.files[0].name;
            var fileSize = (imageFile.files[0].size / 1024 / 1024).toFixed(2); 
            var fileType = fileName.slice((fileName.lastIndexOf(".") - 1 >>> 0) + 2);
            var allowedImageExtList = ["jpeg", "jpg", "png", "webp"];
            
            if(fileSize <= 3.00 && allowedImageExtList.includes(fileType)){
                var imageRawFile = _("coverImage").files[0];
                formdata.append("coverImage", imageRawFile);
                formdata.append("isImageAttached", "Yes");
            }
            else{
              alert("Cover Image must be within 3 mb.");
              return false;
            }
        }
        else{
            formdata.append("isImageAttached", "No");
        }
        formdata.append("restaurantId", "<?php echo $vendorData['id'];?>");
        formdata.append("oldCoverImage", "<?php echo $vendorData['coverImage'];?>");
        formdata.append("name", _("name").value);
        formdata.append("executiveName", _('executiveName').value);
        formdata.append("description", _('description').value);
        formdata.append("emailAddress", _('emailAddress').value);
        formdata.append("tableCost", _('tableCost').value);
        formdata.append("openTime", _('openTime').value);
        formdata.append("closeTime", _('closeTime').value);
        formdata.append("address", _('address').value);
        formdata.append("from",'Update-Restaurant');
        var ajax = new XMLHttpRequest();
        ajax.addEventListener("load", completeHandler, false);
        ajax.addEventListener("error", errorHandler, false);
        
        ajax.open("POST", "<?php echo Base_Url;?>"+"/restaurant-assets/update-restaurant-controller.php");
        ajax.send(formdata);
    }

    function completeHandler(event){
        var response = JSON.parse(event.target.responseText);
        alert(response.message);
        if(response.error == false){
            // alert(response.message);
        } else{
            // alert(response.message);
        }
    }

    function errorHandler(event){
        alert("Status : Upload Failed");
    }
</script>