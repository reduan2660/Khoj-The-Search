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

    // Profile Data
    $sql = "SELECT id, name, phone, mail, institution, address, profession FROM users where id = {$_SESSION["id"]}";
    $result = $link->query($sql);
    $row = $result->fetch_assoc();

    $name = $row["name"];
    $phone = $row["phone"];
    $mail = $row["mail"];
    $institution = $row["institution"];
    $profession =  $row["profession"];
    $address = $row["address"];

    // Update Profile
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $sql = "UPDATE Users SET name = ?, mail = ?, institution = ?, address = ?, profession = ? WHERE id = ?;";

        if ($stmt = mysqli_prepare($link, $sql)) {

            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "sssssi", $param_name, $param_mail, $param_institution, $param_address, $param_profession, $param_id);
            if(isset($_POST["name"])) $param_name = $_POST["name"];
            else $param_name = "";

            if(isset($_POST["mail"])) $param_mail = $_POST["mail"];
            else $param_mail = "";

            if(isset($_POST["institution"])) $param_institution = $_POST["institution"];
            else $param_institution = "";

            if(isset($_POST["address"])) $param_address = $_POST["address"];
            else $param_address = "";

            if(isset($_POST["profession"])) $param_profession = $_POST["profession"];
            else $param_profession = "";

            $param_id = $_SESSION["id"];

            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){

                // Profile Data
                $sql = "SELECT id, name, phone, mail, institution, address, profession FROM Users where id = {$_SESSION["id"]}";
                $result = $link->query($sql);
                $row = $result->fetch_assoc();

                $name = $row["name"];
                $phone = $row["phone"];
                $mail = $row["mail"];
                $institution = $row["institution"];
                $profession =  $row["profession"];
                $address = $row["address"];

                $_SESSION["name"] = $name;
            } else{
                echo "$stmt->error";
            }
        }
    }

    // Close connection
    mysqli_close($link);
?>

<!DOCTYPE html>
<html lang="en">
<?php include 'header.php';?>
<body>
    <section class="min-h-screen min-w-screen bg-gray-900">
        <?php include 'bodyHeader.php';?>
        <!-- Form Section -->
        <section class="flex flex-col items-center">
            <div class="w-full lg:w-2/4 flex flex-col items-start text-white my-4">
                <div class="ml-4 lg:ml-0 text-xl font-bold mt-4">Profile</div>

                <form class="shadow-md w-full bg-gray-800 rounded px-8 pt-6 pb-8 mt-4" method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">

                    <!-- Name -->
                    <div class="mb-4">
                        <label class="block  text-sm font-bold mb-2" for="name">
                            Name
                        </label>
                        <input value="<?php echo $name; ?>" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" name="name" id="title" type="text" placeholder="Name">
                    </div>

                    <!-- Phone -->
                    <div class="mb-4">
                        <label class="block  text-sm font-bold mb-2" for="phone">
                            Phone
                        </label>
                        <input disabled value="<?php echo $phone; ?>" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" name="phone" id="title" type="text" placeholder="Phone">
                    </div>

                    <!-- Mail -->
                    <div class="mb-4">
                        <label class="block  text-sm font-bold mb-2" for="mail">
                            Mail
                        </label>
                        <input value="<?php echo $mail; ?>" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" name="mail" id="title" type="text" placeholder="Mail">
                    </div>

                    <!-- Address -->
                    <div class="mb-4">
                        <label class="block  text-sm font-bold mb-2" for="address">
                            Address
                        </label>
                        <input value="<?php echo $address; ?>" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" name="address" id="title" type="text" placeholder="Address">
                    </div>

                    <!-- Profession -->
                    <div class="mb-4">
                        <label class="block  text-sm font-bold mb-2" for="profession">
                            Profession
                        </label>
                        <input value="<?php echo $profession; ?>" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" name="profession" id="title" type="text" placeholder="Profession">
                    </div>

                    <!-- Institution -->
                    <div class="mb-4">
                        <label class="block  text-sm font-bold mb-2" for="institution">
                            Institution
                        </label>
                        <input value="<?php echo $institution; ?>" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" name="institution" id="title" type="text" placeholder="Institution">
                    </div>

                    <!-- Submit -->
                    <div class="mt-8 flex flex-row items-center justify-center">
                        <button class="bg-blue-600 text-white font-bold px-6 py-2 rounded-lg mr-12">Update</button>
                    </div>

                </form>

                <!-- Reset Passworf | Logout -->
                <div class="shadow-md w-full bg-gray-800 rounded px-8 pt-6 pb-8 mt-4">

                    <div class="mt-8 flex flex-row items-center justify-center">
                        <a href="reset-password.php"><button class="bg-blue-600 text-white font-bold px-6 py-2 rounded-lg mr-12">Reset Password</button></a>
                    </div>

                    <div class="mt-8 flex flex-row items-center justify-center">
                        <a href="logout.php"><button class="bg-red-600 text-white font-bold px-6 py-2 rounded-lg mr-12">Log out</button></a>
                    </div>

                </div>
            </div>
        </section>

    </section>
</body>
</html>