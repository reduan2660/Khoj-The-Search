<?php

$logged_in = true;
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    $logged_in = false;
}

?>


<header class="backdrop-blur-md shadow-md sticky top-0 min-w-screen h-20 bg-gray-800 flex flex-row justify-between items-center px-4 md:px-20">
    <div class="hidden md:block">
    <!-- For UI Purpose | WILL BE HIDDEN -->
    <button class=" cursor-default opacity-0 bg-blue-600 text-white font-bold px-6 py-2 rounded-lg"><?php
            if ($logged_in) {
                if (empty(trim($_SESSION["name"])))
                    echo "Profile";
                else echo $_SESSION["name"];
            }
            else
                echo "Log in";?></button>
    </div>
    
    <div class="text-white font-bold text-xl"><a href="index.php">KhojTheSearch</a></div>
    <div>
        <a href="<?php 
            if ($logged_in) echo "profile.php";
        else
            echo "login.php"; 
        ?>">
        <button class="bg-blue-600 text-white font-bold px-6 py-2 rounded-lg">
            <?php
            if ($logged_in) {
                if (empty(trim($_SESSION["name"])))
                    echo "Profile";
                else echo $_SESSION["name"];
            }
            else
                echo "Log in";?>
            </button>
        </a>
    </div>
</header>