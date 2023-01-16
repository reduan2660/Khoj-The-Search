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

// Event Data
$sql = "SELECT eventid, name, category FROM Event";

$result = $link->query($sql);

if ($result->num_rows > 0) {
    // output data of each row
    // while($row = $result->fetch_assoc()) {
    //   echo "id: " . $row["eventid"]. " - Name: " . $row["name"]. " " . "<br>";
    // }
  } else {
    echo "0 results";
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
        <section class="flex flex-col items-center">

        <!-- Loop -->
        
        <?php foreach($result as $key=>$event): ?>
                <div class="w-full md:w-2/4 flex flex-row justify-between items-center bg-gray-800 rounded-xl text-white my-4">
                <!-- Information -->
                <div class="flex flex-col items-start justify-between px-8 py-6">
                    <div class="font-bold text-2xl"><?php echo $event["name"] ?></div>
                    <div class="my-4 text-lg">Category: <span class="italic"> <?php echo $event["category"] ?> </span></div>
                    <div class="text-lg">2022/01/01 - 2022/05/03</div>

                </div>

                <!-- Details -->
                <div class="flex flex-col items-end">
                    <button class="bg-blue-600 text-white font-bold px-6 py-2 rounded-lg mr-12">Details</button>
                </div>
            </div>
            <?php endforeach; ?>
        

        </section>
    
        <!-- Floating Plus -->
        <section class="fixed bottom-12 right-12">
        <a href="addEvent.php"><button class="bg-blue-600 text-white font-bold px-6 py-2 text-2xl rounded-full"> + </button> </a>
        </section>
    </section>
</body>
</html>