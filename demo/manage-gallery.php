<?php 
include "../constant.inc.php";
include "session.php";
$restaurantId = $_SESSION['id'];
$galleryData = getGalleryImages($restaurantId);
include "header.php";
?>

    <form method="POST" enctype="multipart/form-data" onsubmit="uploadGalleryImage(); return false;" id="update-form">
        <div class="grid md:grid-cols-2 md:gap-6">
            <div class="relative z-0 w-full mb-6 group">
                <label for="galleryImagePreview" class="block mb-2 text-sm font-medium text-gray-900 light:text-white">Gallery Image</label>
                <img class="rounded-lg" src="./assets/images/upload.jpg" alt="image description" id="galleryImagePreview" style="height:250px; width:400px">
            </div>
            <div class="relative z-0 w-full mb-6 group">
                <label class="block mb-2 text-sm font-medium text-gray-900 light:text-white" for="galleryImage">Upload Gallery Image</label>
                <input class="block w-full mb-5 text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 light:text-gray-400 focus:outline-none light:bg-gray-700 light:border-gray-600 light:placeholder-gray-400" id="galleryImage" type="file" accept=".jpg, .png, .jpeg, .webp" onchange="previewImage(this);">

                <label for="caption" class="block mb-2 text-sm font-medium text-gray-900 light:text-white">Small caption</label>
                <textarea id="caption" name="caption" rows="2" class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 light:bg-gray-700 light:border-gray-600 light:placeholder-gray-400 light:text-white light:focus:ring-blue-500 light:focus:border-blue-500" placeholder="Type content here ...."></textarea>
                <button type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800 mt-3 float-right">Upload</button>
            </div>
            
        </div>
        
    </form>
    <hr>
    <div class="grid md:grid-cols-2 md:gap-6 mt-3">
        <?php $imgCounter = 0;
        foreach($galleryData as $value){ ?>
            <div class="relative z-0 w-full mb-6 group">
                <label for="galleryImagePreview" class="block mb-2 text-sm font-medium text-gray-900 light:text-white">Gallery Image <?php echo ++$imgCounter;?></label>
                <img class="rounded-lg" src="<?php echo $value['image'];?>" alt="image description" id="galleryImagePreview" style="height:250px; width:400px">
            </div>
        <?php } ?>
    </div>


<?php include "footer.php";?>
<script>
    function _(el){
        return document.getElementById(el);
    }

    function previewImage(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function (e) {
                $('#galleryImagePreview')
                .attr('src', e.target.result)
                .width(400)
                .height(250);
            };
            reader.readAsDataURL(input.files[0]);
        }
    }

    function uploadGalleryImage(){
        var imageFile =_('galleryImage'); 
        var fileLength = imageFile.files.length;
        var formdata = new FormData();
        if(fileLength > 0){
            fileName = imageFile.files[0].name;
            var fileSize = (imageFile.files[0].size / 1024 / 1024).toFixed(2); 
            var fileType = fileName.slice((fileName.lastIndexOf(".") - 1 >>> 0) + 2);
            var allowedImageExtList = ["jpeg", "jpg", "png", "webp"];
            
            if(fileSize <= 3.00 && allowedImageExtList.includes(fileType)){
                var imageRawFile = _("galleryImage").files[0];
                formdata.append("galleryImage", imageRawFile);
                formdata.append("caption", _('caption').value);
                formdata.append("restaurantId", "<?php echo $restaurantId;?>");
                formdata.append("from",'Upload-Gallery-Image');
                var ajax = new XMLHttpRequest();
                ajax.addEventListener("load", completeHandler, false);
                ajax.addEventListener("error", errorHandler, false);
                ajax.open("POST", "<?php echo Base_Url;?>"+"/restaurant-assets/upload-gallery-image-controller.php");
                ajax.send(formdata);
            }
            else{
              alert("Cover Image must be within 3 mb.");
              return false;
            }
        }
        else{
            alert("Gallery Image is required");
        }
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