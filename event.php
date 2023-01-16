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
    $sql = "SELECT eventid, name, description, category, registration FROM Event where eventid={$eventId}";
    $result = $link->query($sql);
    if ($result->num_rows == 0) {
        header("location: index.php");
        exit;
    }

    $sql = "SELECT * FROM Timeline where eventid={$eventId}";
    $timelineResult = $link->query($sql);

    // Add Timeline
    $tname = $tdetails = $tdateofstart = $tdateofend = "";
    if($_SERVER["REQUEST_METHOD"] == "POST"){
        $sql = "INSERT INTO Timeline (eventid, name, details, dateOfStart, dateOfEnd) VALUES (?, ?, ?, STR_TO_DATE(?, '%Y-%m-%d'), STR_TO_DATE(?, '%Y-%m-%d'));";

        if ($stmt = mysqli_prepare($link, $sql)) {
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "issss", $param_eventid ,$param_name, $param_details, $param_dos, $param_doe);
            $param_eventid = (int) $eventId;
            $param_name = $_POST["tname"];
            $param_details = $_POST["tdetails"];
            $param_dos = $_POST["tdateofstart"];
            $param_doe = $_POST["tdateofend"];

            echo $sql;

            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                
                header("location: event.php?id={$eventId}");
            } else{
                echo $stmt->error;
                header("location: event.php?id={$eventId}");
            }
        }
    }


    // DELETE TIMELINE
    if(isset($_GET["deleteTimeLine"])){
        $sql = "DELETE FROM Timeline WHERE timelineid=?;";

        if ($stmt = mysqli_prepare($link, $sql)) {
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "i", $param_timelineid);
            $param_timelineid =(int) $_GET["deleteTimeLine"];

            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                header("location: event.php?id={$eventId}");
            } else{
                echo $stmt->error;
                header("location: event.php?id={$eventId}");
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

                <!-- Registration -->
                <?php if(!empty(trim($event["registration"]))): ?>
                    <div class="w-full text-lg py-4 px-4 mt-4 md:w-2/4 flex flex-col items-start">

                        <div><span class="font-bold">Registration:</span> <span class="italic"><?php echo $event["registration"] ?></span></div>
                        <div></div>
                    </div>
                <?php endif; ?>

                <div class="w-full text-lg py-4 px-4 mt-4 md:w-2/4 flex flex-row items-center justify-between">
                    <div><span class="font-bold">Timeline</span></div>
                    <button type="button" id="openModalBtn" class="bg-blue-600 text-white font-bold px-4 py-1 rounded-lg mr-6">Add Timeline</button>
                </div>

                <!-- Table -->
                    <div class="w-full  md:w-2/4 relative overflow-x-auto rounded my-4">
                        <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                <tr>
                                    <th scope="col" class="px-6 py-3">
                                        Name
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        Details
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        Date of Start
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        Date of End
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        Action
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php foreach($timelineResult as $key=>$row): ?>
                                <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                                    <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                       <?php echo $row["name"]; ?>
                                    </th>
                                    <td class="px-6 py-4">
                                    <?php echo $row["details"]; ?>
                                    </td>
                                    <td class="px-6 py-4">
                                    <?php echo $row["dateOfStart"]; ?>
                                    </td>
                                    <td class="px-6 py-4">
                                        <?php echo $row["dateOfEnd"]; ?>
                                    </td>
                                    <td class="px-6 py-4">
                                     <a href="<?php echo htmlspecialchars("event.php?id={$eventId}&deleteTimeLine={$row["timelineid"]}"); ?>"><button type="submit" id="openModalBtn" class="bg-red-300 text-white font-bold px-4 py-1 rounded-lg mr-6">Delete</button></a>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>

            <?php endforeach; ?>
        </section>
    
    
    </section>
    
    <!-- Add Timeline Modal -->
    <div id="openTimelineModal" class="hidden absolute inset-0 flex items-center justify-center bg-gray-700 bg-opacity-50 backdrop-blur rounded-lg text-white">
        <div class="w-full md:w-1/4 p-6 bg-gray-700 rounded-lg shadow-lg">
            <div class="flex items-center justify-between">
                <h3 class="text-2xl">New Timeline</h3>
                <div><button id="closeModalBtn" class="bg-blue-600 text-white font-bold px-3 py-1 rounded-full ">X</button></div>

            </div>
            <div class="mt-4">

            <form method="POST" action="<?php echo htmlspecialchars("event.php?id={$eventId}"); ?>" class="w-full rounded px-8 pt-6 pb-8 mt-4">
            <!-- <form class="w-full rounded px-8 pt-6 pb-8 mt-4"> -->
        
                <!-- Name -->
                <div class="mb-4">
                    <label class="block  text-sm font-bold mb-2" for="tname">
                        Name
                    </label>
                    <input required value="<?php echo $tname; ?>" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" name="tname" id="tname" type="text" placeholder="Name">
                </div>

                <!-- Details -->
                <div class="mb-4">
                    <label class="block  text-sm font-bold mb-2" for="tdetails">
                        Details
                    </label>
                    <input value="<?php echo $tdetails; ?>" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" name="tdetails" id="tdetails" type="text" placeholder="Details">
                </div>


                <!-- Date of Start -->
                <div class="mb-4">
                    <label class="block  text-sm font-bold mb-2" for="tdateofstart">
                        Date of Start
                    </label>
                    <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" name="tdateofstart" id="tdateofstart" type="date" placeholder="Date of Start">
                </div>


                <!-- Date of end -->
                <div class="mb-4">
                    <label class="block  text-sm font-bold mb-2" for="tdateofend">
                        Date of end
                    </label>
                    <input value="<?php echo $tdateofend; ?>" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" name="tdateofend" id="tdateofend" type="date" placeholder="Date of end">
                </div>

                <div class="mt-6 flex items-center justify-center px-4" >
                    <button id="addTimeLineBtn" type="submit" class="bg-blue-600 text-white font-bold px-4 py-1 text-xl rounded-lg">Add</button>
                </div>

            </form>
            </div>
        </div>
    </div>



    <script>
        const openModalBtn = document.getElementById("openModalBtn");
        const openTimelineModal = document.getElementById("openTimelineModal");
        openModalBtn.addEventListener("click", () => {
            openTimelineModal.classList.toggle("hidden");
        })

        const closeModalBtn =  document.getElementById("closeModalBtn");
        closeModalBtn.addEventListener("click", () => {
            openTimelineModal.classList.toggle("hidden");
        })


        // Add Timeline
        const addTimeLineBtn = document.getElementById("addTimeLineBtn");
        addTimeLineBtn.addEventListener("click", () => {
            console.log("Hello")
        })
        
    </script>
</body>
</html>
