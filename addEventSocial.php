<?php
// Initialize the session
session_start();
 
// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit;
}

?>

<!DOCTYPE html>
<html lang="en">
<?php include 'header.php';?>
<body>
    <section class="min-h-screen min-w-screen bg-gray-900">
    <?php include 'bodyHeader.php';?>

    </section>
</body>
</html>