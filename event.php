<?php
// Include config file
require_once "config.php";

// Initialize the session
session_start();

// Check if the user is logged in, if not then redirect him to login page
// if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
//     header("location: login.php");
//     exit;
// }

$eventId = "-1";
if(isset($_GET['id'])) $eventId = $_GET['id'];

// Event Data
$sql = "SELECT eventid, name, description, category FROM Event where eventid={$eventId}";
$result = $link->query($sql);

if ($result->num_rows == 0) {
    header("location: index.php");
    exit;
}

// Close connection
mysqli_close($link);
?>

<!DOCTYPE html>
<html lang="en">
<?php include 'header.php';?>
<body>
    <section class="min-h-screen min-w-screen bg-gray-50 dark:bg-gray-900">
        
        <?php include 'bodyHeader.php';?>

        <!-- Content -->
        <section class="flex flex-col items-center text-white">
            <?php foreach($result as $key=>$event): ?>
                <div class="w-full py-4 px-4 md:w-2/4 flex flex-row justify-between items-center rounded-xl text-white my-4">
                    <!-- Name & Subscribe -->
                    <div class="text-3xl font-bold"><?php echo $event["name"] ?></div>
                    <div><button class="bg-blue-600 text-white font-bold px-6 py-2 rounded-lg mr-6">Subscribe</button></div>
                </div>
                
                <!-- Description -->
                <div class="w-full text-lg py-4 px-4 mt-4 md:w-2/4 flex flex-col items-start">

                    <div class="font-bold mb-3">Description</div>
                    <div><?php echo $event["description"] ?></div>
                </div>

                <!-- Category -->
                <div class="w-full text-lg py-4 px-4 mt-4 md:w-2/4 flex flex-col items-start">

                    <div><span class="font-bold">Category:</span> <span class="italic"><?php echo $event["category"] ?></span></div>
                    <div></div>
                </div>
            
            <?php endforeach; ?>
        </section>

    </section>
</body>
</html>
