<?php
session_start();
include "./function.inc.php";
$errorMsg = '';
if(isset($_POST['signin'])){
    $number = getSafeValue($_POST['number']);
    $password = md5(getSafeValue($_POST['password']));
    $res = $conn->query("Select res.*, ct.city from restaurants as res, cities as ct where ct.id = res.cityId and res.number = '$number' and res.password = '$password'");
    if($res->num_rows > 0){
        $row = $res->fetch_assoc();
        $_SESSION['number'] = $row['number'];
        $_SESSION['email'] = $row['email'];
        $_SESSION['password'] = $row['password'];
        $_SESSION['name'] = $row['name'];
        $_SESSION['executiveName'] = $row['executiveName'];
        $_SESSION['city'] = $row['city'];
        $_SESSION['address'] = $row['address'];
        $_SESSION['coverImage'] = $row['coverImage'];
        $_SESSION['id'] = $row['id'];
        header("location:dashboard.php");
    } else{
        $errorMsg = "Wrong Credentials. Try again";
    }
} else if(isset($_SESSION['number']) && $_SESSION['number']!='' && isset($_SESSION['password']) && $_SESSION['password']!=''){
    $number = getSafeValue($_SESSION['number']);
    $md_password = getSafeValue($_SESSION['password']);

    $res = mysqli_query($conn, "Select res.*, ct.city from restaurants as res, cities as ct where ct.id = res.cityId and res.number = '$number' and res.password = '$md_password'");
    if(mysqli_num_rows($res) > 0){
        $row = $res->fetch_assoc();
        $_SESSION['number'] = $row['number'];
        $_SESSION['email'] = $row['email'];
        $_SESSION['password'] = $row['password'];
        $_SESSION['name'] = $row['name'];
        $_SESSION['executiveName'] = $row['executiveName'];
        $_SESSION['city'] = $row['city'];
        $_SESSION['address'] = $row['address'];
        $_SESSION['coverImage'] = $row['coverImage'];
        $_SESSION['id'] = $row['id'];
        header("location:dashboard.php");
    } else{
        $errorMsg = "Session Expired. Login again.";
    }
}
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta http-equiv="x-ua-compatible" content="ie=edge" />
        <title><?php echo Site_Name;?> | Admin | Login</title>
        <link rel="icon" href="img/mdb-favicon.ico" type="image/x-icon" />
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet" />
        <link rel="stylesheet" href="./assets/css/index.min.css" />
        <link rel="stylesheet" href="https://unpkg.com/flowbite@1.4.6/dist/flowbite.min.css" />
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/2.2.17/tailwind.min.css" />
    </head>
    <body>
        <section>
            <div class="px-4 py-12 mx-auto max-w-7xl sm:px-6 md:px-12 lg:px-24 lg:py-24">
                <div class="justify-center mx-auto text-left align-bottom transition-all transform bg-white rounded-lg sm:align-middle sm:max-w-2xl sm:w-full">
                    <div class="grid flex-wrap items-center justify-center grid-cols-1 mx-auto shadow-xl lg:grid-cols-2 rounded-xl">
                        <div class="w-full px-6 py-3">
                            <div>
                                <div class="mt-3 text-left sm:mt-5">
                                    <div class="inline-flex items-center w-full">
                                        <h3 class="text-lg font-bold text-neutral-600 l eading-6 lg:text-5xl">Sign in</h3>
                                    </div>
                                    <div class="mt-4 text-base text-gray-500">
                                        <p>Sign in to manage "<?php echo Site_Name;?>"</p>
                                    </div>
                                </div>
                            </div>
                            <div class="mt-6 space-y-2">
                                <form method="POST">
                                    <div>
                                        <label for="number" class="sr-only">Number</label>
                                        <input
                                            type="number"
                                            name="number"
                                            id="number"
                                            class="block w-full px-5 py-3 text-base text-neutral-600 placeholder-gray-300 transition duration-500 ease-in-out transform border border-transparent rounded-lg bg-gray-50 focus:outline-none focus:border-transparent focus:ring-2 focus:ring-white focus:ring-offset-2 focus:ring-offset-gray-300"
                                            placeholder="Number" required
                                            />
                                    </div>
                                    <br>
                                    <div>
                                        <label for="password" class="sr-only">Password</label>
                                        <input
                                            type="password"
                                            name="password"
                                            id="password"
                                            class="block w-full px-5 py-3 text-base text-neutral-600 placeholder-gray-300 transition duration-500 ease-in-out transform border border-transparent rounded-lg bg-gray-50 focus:outline-none focus:border-transparent focus:ring-2 focus:ring-white focus:ring-offset-2 focus:ring-offset-gray-300"
                                            placeholder="Password" required
                                            />
                                    </div>
                                    <br>
                                    <div class="text-base text-red-500">
                                        <p><?php echo $errorMsg;?></p>
                                    </div>
                                    
                                    <div class="flex flex-col mt-4 lg:space-y-2">
                                        <button
                                            type="submit"
                                            id="signin"
                                            name="signin"
                                            class="flex items-center justify-center w-full px-10 py-4 text-base font-medium text-center text-white transition duration-500 ease-in-out transform bg-blue-600 rounded-xl hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500"
                                            >
                                        Sign in
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <div class="order-first hidden h-full bg-fill w-full lg:block">
                            <img class="object-cover h-full w-full bg-cover rounded-l-lg" src="./assets/images/restaurants-login-bg.jpg" alt="" />
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </body>
</html>
<script src="https://unpkg.com/flowbite@1.4.6/dist/flowbite.js"></script>