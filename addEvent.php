<?php
// Include config file
require_once "config.php";

// Initialize the session
session_start();
 
// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit;
}

$title = $description = $category = $registration = $location = $qualification =  "";
$title_err = "";

if($_SERVER["REQUEST_METHOD"] == "POST"){

    
    
    // Validate name
    if(empty(trim($_POST["title"]))){
        $title_err = "Please enter a title.";
    }
    
    // Check input errors before inserting in database
    if(empty($title_err)){
        
        // Prepare an insert statement
        // $sql = "INSERT INTO users (name, phone, password, otp) VALUES (?, ?, ?, ?)";
        $sql = "INSERT INTO Event (name, description, category, registration, location, qualification, onsite) VALUES (?, ?, ?, ?, ?, ?, ?);";
        
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "sssssss", $param_title, $param_desc, $param_cat, $param_reg, $param_loc, $param_qual, $param_onsite);
            
            // Set parameters
            $param_title = $_POST["title"];
            $param_desc = $_POST["description"];
            $param_cat = $_POST["category"];
            $param_reg = $_POST["registration"];
            $param_loc = $_POST["location"];
            $param_qual = $_POST["qualification"];
            if(isset($_POST["onsite"])) $param_onsite = "Yes";
            else
                $param_onsite = "No";
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Redirect to login page
                // header("location: addEventSocial.php");
                header("location: index.php");
            } else{
                echo "$stmt->error";
            }

            // Close statement
            mysqli_stmt_close($stmt);
        }
    }
    
    // Close connection
    mysqli_close($link);
}
?>


<!DOCTYPE html>
<html lang="en">
<?php include 'header.php';?>
<body>
    <section class="min-h-screen min-w-screen bg-gray-50 dark:bg-gray-900">
    <?php include 'bodyHeader.php';?>

    <!-- Form Section -->
    <section class="flex flex-col items-center">
    <div class="w-full md:w-2/4 flex flex-col items-start text-white my-4">
        <div class="text-xl font-bold mt-4">Add an event</div>


        <form class="shadow-md w-full bg-gray-800 rounded px-8 pt-6 pb-8 mt-4" method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        
        <!-- Title -->
        <div class="mb-4">
            <label class="block  text-sm font-bold mb-2" for="title">
                Title
            </label>
            <input value="<?php echo $title; ?>" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" name="title" id="title" type="text" placeholder="Title">
        </div>

        <!-- Description -->
        <div class="mt-8">
            <label class="block  text-sm font-bold mb-2" for="description">
                Description
            </label>
            <input value="<?php echo $description; ?>" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" name="description" id="description" type="textarea" placeholder="Description">
        </div>

        <!-- Category -->
        <div class="mt-8">
            <label class="block  text-sm font-bold mb-2" for="category">
                Category
            </label>
            <input value="<?php echo $category; ?>" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" name="category" id="category" type="text" placeholder="Category">
        </div>

        <!-- Registration -->
        <div class="mt-8">
            <label class="block  text-sm font-bold mb-2" for="registration">
                Registration
            </label>
            <input value="<?php echo $registration; ?>" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" name="registration" id="registration" type="text" placeholder="Registration">
        </div>

        <!-- Location -->
        <div class="mt-8">
            <label class="block  text-sm font-bold mb-2" for="location">
                Location
            </label>
            <input value="<?php echo $location; ?>" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" name="location" id="location" type="text" placeholder="Location">
        </div>

        <!-- Qualification -->
        <div class="mt-8">
            <label class="block  text-sm font-bold mb-2" for="qualification">
                Qualification
            </label>
            <input value="<?php echo $qualification; ?>" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" name="qualification" id="qualification" type="text" placeholder="Qualification">
        </div>

        <!-- Onsite -->

        <div class="mt-8 ml-4">
            <div class="md:w-1/3"></div>
            <label class="md:w-2/3 block text-gray-500 font-bold">
            <input name="onsite" value="1" class="mr-2 leading-tight" type="checkbox">
            <span class="text-sm text-white">
                Onsite
            </span>
            </label>
        </div>

        <div class="mt-8 flex flex-row items-center justify-center">
            <button class="bg-blue-600 text-white font-bold px-6 py-2 rounded-lg mr-12">Add Event Social -></button>
        </div>


        </form>
    </div>

    </section>

    </section>
</body>
</html>