<?php 
$script_filename =  explode('/',$_SERVER['SCRIPT_FILENAME']);
$curr_path = $script_filename[count($script_filename)-1];
$pageName = $marketOpen = '';

if($curr_path == 'dashboard' || $curr_path == 'dashboard.php'){
    $pageName = 'Dashboard';
}
elseif($curr_path == 'add-medicine' || $curr_path == 'add-medicine.php'){
    $pageName = 'Add Medicine';
}
elseif($curr_path == 'manage-medicines' || $curr_path == 'manage-medicines.php'){
    $pageName = 'Manage Medicines';
}
elseif($curr_path == 'manage-orders' || $curr_path == 'manage-orders.php'){
    $pageName = 'Manage Orders';
}
elseif($curr_path == 'prescription-orders' || $curr_path == 'prescription-orders.php'){
    $pageName = 'Prescription Orders';
}
elseif($curr_path == 'manage-transactions' || $curr_path == 'manage-transactions.php'){
    $pageName = 'Manage Transactions';
}
elseif($curr_path == 'manage-customers' || $curr_path == 'manage-customers.php'){
    $pageName = 'Manage Customers';
}
elseif($curr_path == 'settings' || $curr_path == 'settings.php'){
    $pageName = "Settings";
}
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta http-equiv="x-ua-compatible" content="ie=edge" />
        <title><?php echo Site_Name;?> | Admin</title>
        <link rel="icon" href="./assets/images/favicon.ico" type="image/x-icon" />
        <link href="https://cdnjs.cloudflare.com/ajax/libs/flowbite/1.6.3/flowbite.min.css" rel="stylesheet" />
        <script src="https://cdn.tailwindcss.com"></script>
        <style type="text/css">
            .maxline2 {
                overflow: hidden; 
                border: none; 
                text-overflow: ellipsis; 
                display: -webkit-box; 
                -webkit-line-clamp: 2; 
                line-clamp: 2; 
                -webkit-box-orient: vertical;
            }
            .maxline1 {
                overflow: hidden; 
                border: none; 
                text-overflow: ellipsis; 
                display: -webkit-box; 
                -webkit-line-clamp: 1; 
                line-clamp: 1; 
                -webkit-box-orient: vertical;
            }
            @media print {
                /* Hide the print and download buttons when printing */
                .no-print {
                    display: none;
                }
            }
        </style>
    </head>
    <body>
        <nav class="fixed top-0 z-50 w-full bg-white border-b border-gray-200 dark:bg-gray-800 dark:border-gray-700">
            <div class="px-3 py-3 lg:px-5 lg:pl-3">
                <div class="flex items-center justify-between">
                    <div class="flex items-center justify-start">
                        <button data-drawer-target="logo-sidebar" data-drawer-toggle="logo-sidebar" aria-controls="logo-sidebar" type="button" class="inline-flex items-center p-2 text-sm text-gray-500 rounded-lg md:hidden hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-200 dark:text-gray-400 dark:hover:bg-gray-700 dark:focus:ring-gray-600">
                            <span class="sr-only">Open sidebar</span>
                            <svg class="w-6 h-6" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                <path clip-rule="evenodd" fill-rule="evenodd" d="M2 4.75A.75.75 0 012.75 4h14.5a.75.75 0 010 1.5H2.75A.75.75 0 012 4.75zm0 10.5a.75.75 0 01.75-.75h7.5a.75.75 0 010 1.5h-7.5a.75.75 0 01-.75-.75zM2 10a.75.75 0 01.75-.75h14.5a.75.75 0 010 1.5H2.75A.75.75 0 012 10z"></path>
                            </svg>
                        </button>
                        <a href="dashboard.php" class="flex ml-2 md:mr-24">
                            <img src="./assets/images/favicon.png" class="h-8 mr-3" alt="FlowBite Logo" />
                            <span class="self-center text-xl font-semibold sm:text-2xl dark:text-white"><?php echo Site_Name;?></span>
                        </a>
                    </div>
                    <div class="flex items-center">
                        <div class="flex items-center ml-3">
                            <div>
                                <button type="button" class="flex text-sm bg-gray-800 rounded-full focus:ring-4 focus:ring-gray-300 dark:focus:ring-gray-600" aria-expanded="false" data-dropdown-toggle="dropdown-user">
                                    <span class="sr-only">Open user menu</span>
                                    <img class="w-8 h-8 rounded-full" src="https://datarundown.com/wp-content/uploads/2022/03/Datarundown-Admin-Avatar-Circle-1.png" alt="user photo">
                                </button>
                            </div>
                            <div class="z-50 hidden my-4 text-base list-none bg-white divide-y divide-gray-100 rounded shadow dark:bg-gray-700 dark:divide-gray-600" id="dropdown-user">
                                <div class="px-4 py-3" role="none">
                                    <p class="text-sm text-gray-900 dark:text-white" role="none"> <?php echo ($_SESSION['name'] ?? '');?> </p>
                                    <p class="text-sm font-medium text-gray-900 truncate dark:text-gray-300" role="none"> <?php echo ($_SESSION['adminFullname'] ?? '').' | '.($_SESSION['adminUsername'] ?? '');?> </p>
                                </div>
                                <ul class="py-1" role="none">
                                    <li>
                                        <a href="change-password.php" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-gray-600 dark:hover:text-white" role="menuitem">Change Password</a>
                                    </li>
                                    <li>
                                        <a href="logout.php" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-gray-600 dark:hover:text-white" role="menuitem">Sign out</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </nav>
        <aside id="logo-sidebar" class="fixed top-0 left-0 z-40 w-64 h-screen pt-20 transition-transform -translate-x-full bg-white border-r border-gray-200 sm:translate-x-0 dark:bg-gray-800 dark:border-gray-700" aria-label="Sidebar">
            <div class="h-full px-3 pb-4 overflow-y-auto bg-white dark:bg-gray-800">
                <ul class="space-y-2">
                    <li>
                        <a href="dashboard.php" class="flex items-center p-2 text-base font-normal text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 <?php echo $pageName == 'Dashboard' ? 'bg-gray-700' : '';?>">
                            <svg aria-hidden="true" class="w-6 h-6 text-gray-500 transition duration-75 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                <path d="M2 10a8 8 0 018-8v8h8a8 8 0 11-16 0z"></path>
                                <path d="M12 2.252A8.014 8.014 0 0117.748 8H12V2.252z"></path>
                            </svg>
                            <span class="ml-3">Dashboard</span>
                        </a>
                    </li>
                    <hr>
                    <li>
                        <a href="add-medicine.php" class="flex items-center p-2 text-base font-normal text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 <?php echo $pageName == 'Add Medicine' ? 'bg-gray-700' : '';?>">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-6 h-6 text-gray-300">
                            <path d="M12 2C6.486 2 2 6.486 2 12s4.486 10 10 10s10-4.486 10-10S17.514 2 12 2zm0 18c-4.411 0-8-3.589-8-8s3.589-8 8-8s8 3.589 8 8s-3.589 8-8 8zM13 7h-2v4H7v2h4v4h2v-4h4v-2h-4V7z"/></svg>
                            <span class="flex-1 ml-3 whitespace-nowrap">Add Medicine</span>
                        </a>
                    </li>
                    <li>
                        <a href="manage-medicines.php" class="flex items-center p-2 text-base font-normal text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 <?php echo $pageName == 'Manage Medicines' ? 'bg-gray-700' : '';?>">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-6 h-6 text-gray-300">
                            <path d="M19 2H5C3.895 2 3 2.895 3 4v16c0 1.105.895 2 2 2h14c1.105 0 2-.895 2-2V4c0-1.105-.895-2-2-2zm0 2v2H5V4h14zM5 20V8h14v12H5zm4-9h6v2H9v-2zm0-3h6v2H9V8z"/></svg>
                            <span class="flex-1 ml-3 whitespace-nowrap">Manage Medicines</span>
                        </a>
                    </li>
                    <li>
                        <a href="manage-orders.php" class="flex items-center p-2 text-base font-normal text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 <?php echo $pageName == 'Manage Orders' ? 'bg-gray-700' : '';?>">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-6 h-6 text-gray-300">
                            <path d="M4 4v2H2v14h20V6h-2V4H4zm14 14H6v-2h12v2zm0-4H6v-2h12v2zm0-4H6V8h12v2zm0-4H6V4h12v2z"/></svg>
                            <span class="flex-1 ml-3 whitespace-nowrap">Manage Orders</span>
                        </a>
                    </li>
                    <li>
                        <a href="prescription-orders.php" class="flex items-center p-2 text-base font-normal text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 <?php echo $pageName == 'Prescription Orders' ? 'bg-gray-700' : '';?>">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-6 h-6 text-gray-300">
                            <path d="M17.354 2.646a.5.5 0 0 0-.707 0L7 12.293 3.854 9.146a.5.5 0 0 0-.708 0l-2 2a.5.5 0 0 0 0 .707l5 5a.498.498 0 0 0 .708 0l10-10a.5.5 0 0 0 0-.707l-2-2zM7 13.707L17.293 4H20v2.707l-10 10L7 13.707zM21 7v14H3V1h10V0H2v22h20V7h-1z"/>
                            </svg>
                            <span class="flex-1 ml-3 whitespace-nowrap">Prescription Orders</span>
                        </a>
                    </li>
                    <li>
                        <a href="manage-customers.php" class="flex items-center p-2 text-base font-normal text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 <?php echo $pageName == 'Manage Customers' ? 'bg-gray-700' : '';?>">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-6 h-6 text-gray-300">
                            <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"></path></svg>
                            <span class="flex-1 ml-3 whitespace-nowrap">Manage Customers</span>
                        </a>
                    </li>
                </ul>
            </div>
        </aside>

        <div class="p-4 sm:ml-64">
            <div class="p-4 light:border-gray-700 mt-14">
                <nav class="flex mb-4" aria-label="Breadcrumb">
                <ol class="inline-flex items-center space-x-1 md:space-x-3">
                    <li class="inline-flex items-center">
                    <a href="dashboard.php" class="inline-flex items-center text-sm font-medium text-gray-700 hover:text-gray-900 light:text-gray-400 light:hover:text-white">
                        <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z"></path></svg>
                        Dashboard
                    </a>
                    </li>
                    <li aria-current="page">
                    <div class="flex items-center">
                        <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path></svg>
                        <span class="ml-1 text-sm font-medium text-gray-500 md:ml-2 light:text-gray-400"><?php echo $pageName;?></span>
                    </div>
                    </li>
                </ol>
                </nav>
                <h2 class="mb-4 text-3xl font-extrabold leading-none tracking-tight text-gray-900 md:text-4xl light:text-white"><?php echo $pageName;?></h2>

               
