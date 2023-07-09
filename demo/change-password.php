<?php 
include "session.php";
include "header.php";
$errorMsg = '';
if(isset($_POST['pathAction']) && $_POST['pathAction'] == "Update-Password"){
    $currentPassword = md5($_POST['currentPassword']);
    $newPassword = md5($_POST['newPassword']);
    $confirmPassword = md5($_POST['confirmPassword']);
    $adminId = $_SESSION['adminId'];
    if($newPassword == $confirmPassword){
        $conn->query("Update admin set password = '$newPassword' where id = '$adminId' and password = '$currentPassword'");
        if($conn->affected_rows > 0){
            $errorMsg = "<div class=\"p-4 mb-4 text-sm text-green-700 bg-green-100 rounded-lg dark:bg-green-200 dark:text-green-800\" role=\"alert\"><span class=\"font-medium\">Success!</span> Password Changed</div>";
        } else{
            $errorMsg = "<div class=\"p-4 mb-4 text-sm text-red-700 bg-red-100 rounded-lg dark:bg-red-200 dark:text-red-800\" role=\"alert\"><span class=\"font-medium\">Ooops!</span> Invalid Current Password</div>";
        }
    } else{
        $errorMsg = "<div class=\"p-4 mb-4 text-sm text-yellow-700 bg-yellow-100 rounded-lg dark:bg-yellow-200 dark:text-yellow-800\" role=\"alert\"><span class=\"font-medium\">Warning!</span> New Password and Confirm Password must be same</div>";
    }
}
?>
<form method="POST" action="">
    <div class="grid md:grid-cols-3 md:gap-6 m-3">
        <div class="relative z-0 w-full mb-6 group">
            <label for="currentPassword" class="block mb-2 text-sm font-medium text-gray-900 light:text-white">Current Password</label>
            <input type="password" id="currentPassword" name="currentPassword" class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 light:bg-gray-700 light:border-gray-600 light:placeholder-gray-400 light:text-white light:focus:ring-blue-500 light:focus:border-blue-500" placeholder="*******" required>
        </div>
        <div class="relative z-0 w-full mb-6 group">
            <label for="newPassword" class="block mb-2 text-sm font-medium text-gray-900 light:text-white">New Password</label>
            <input type="password" id="newPassword" name="newPassword" class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 light:bg-gray-700 light:border-gray-600 light:placeholder-gray-400 light:text-white light:focus:ring-blue-500 light:focus:border-blue-500" placeholder="*******" required>
        </div>
        <div class="relative z-0 w-full mb-6 group">
            <label for="confirmPassword" class="block mb-2 text-sm font-medium text-gray-900 light:text-white">Confirm Password</label>
            <input type="password" id="confirmPassword" name="confirmPassword" class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 light:bg-gray-700 light:border-gray-600 light:placeholder-gray-400 light:text-white light:focus:ring-blue-500 light:focus:border-blue-500" placeholder="*******" required>
        </div>
    </div>
    <?php echo $errorMsg;?>
    <button type="submit" name="pathAction" value="Update-Password" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Change Password</button>
</form>

<?php include "footer.php";?>
