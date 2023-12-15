<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    <!-- Add this line before your custom JavaScript code -->
    <link rel="stylesheet" href="users.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>





    <title>Document</title>
</head>

<body>
    <div class="grid-container">
    <header class="header">
            <span class="material-symbols-outlined" style="font-size: 37px;">search</span>

            <div class="mail">
               <a href="../mail/mailing.php"><span class="material-symbols-outlined" style="font-size: 37px;">mail</span></a>
            </div>
        
        </header>
        <main class="main">
            <div class="col1">
                <div class="title">
                    <h1>Treatment Records</h1>
                </div>
                <table class="content-table ">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Date of Treatment</th>
                            <th>Type of Treatment</th>
                            <th> Patient</th>
                            <th> Nurse</th>
                            <th colspan="2">Action</th>
                        </tr>

                    </thead>
                    <tbody>

                        <?php

                        // Include your PDO connection and Treatment class here
                        require '../../../model/db_connect_front.php'; // Include your connection file
                        require '../../../model/treatement.php'; // Include your Treatment class file

                        // Create a Treatment object using your PDO connection
                        $treatment = new Treatment($pdo);
                        // Handling Delete Action
                        if (isset($_POST['deleteTreatment'])) {
                            $id = $_POST['id']; // Get treatment ID from the form
                            // Call the deleteTreatment method from the Treatment class
                            $treatment->deleteTreatment($id); // Perform treatment deletion
                            // Redirect to the same page or display a success message
                            header("Location: treatment.php");
                            exit();
                        }

                        // Handling Modify Action
                        if (isset($_GET['modifyTreatment'])) {
                            $id = $_GET['id']; // Get treatment ID from the form
                            // Redirect to the modification page with the treatment ID
                            header("Location: modify_treatment.php?id=" . $id);
                            exit();
                        }
                        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['filterDate'])) {
                            $filterDate = $_POST['filterDate'];

                            // Fetch treatment records filtered by date from the database
                            $stmt = $pdo->prepare("SELECT * FROM treatment WHERE date_of_treatment = ?");
                            $stmt->execute([$filterDate]);
                            $treatmentRecords = $stmt->fetchAll(PDO::FETCH_ASSOC);
                        } else if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['showAll'])) {
                            // Fetch all treatment type records from the database
                            $treatmentRecords = $treatment->fetchTreatments();
                        } else {
                            // Fetch treatment type records with any applied filters (if any)
                            $treatmentRecords = $treatment->fetchTreatments();
                        }
                        // Fetch treatment records from the database using the fetchTreatments method


                        // Loop through the records and display them in the table
                        foreach ($treatmentRecords as $record) {
                            echo "<tr>";
                            echo "<td>{$record['id_treatment']}</td>";
                            echo "<td>{$record['date_of_treatment']}</td>";
                            echo "<td>{$record['type_of_treatment']}</td>";
                            echo "<td class='text-wrap'>";
                            $cinPatient = $record['CIN_Patient'];

                            // Fetch patient name based on CIN from the database
                            $stmtPatient = $pdo->prepare("SELECT lastname FROM user WHERE CIN = ?");
                            $stmtPatient->execute([$cinPatient]);
                            $patientName = $stmtPatient->fetchColumn();

                            echo $patientName; // Display the patient's name
                            echo "</td>";
                            echo "<td class='text-wrap'>";
                            $cinNurse = $record['CIN_NURSE'];

                            // Fetch patient name based on CIN from the database
                            $stmtNurse = $pdo->prepare("SELECT lastname FROM user WHERE CIN = ?");
                            $stmtNurse->execute([$cinNurse]);
                            $NurseName = $stmtNurse->fetchColumn();

                            echo $NurseName; // Display the patient's name
                            echo "</td>";
                            echo "<td>";
                            echo "<form method='post'>";
                            echo "<input type='hidden' name='id' value='{$record['id_treatment']}'>";
                            echo "<button type='submit' name='deleteTreatment' class='btn btn-danger btn-sm'>Delete</button>";
                            echo "</form>";
                            echo "</td>";
                            echo "<td>";
                            echo "<form method='get' action='modify_treatment.php'>";
                            echo "<input type='hidden' name='id' value='{$record['id_treatment']}'>";
                            echo "<button type='submit' name='modifyTreatment' class='btn btn-info btn-sm'>Modify</button>";
                            echo "</form>";
                            echo "</td>";
                            echo "</tr>";
                        }
                        ?>
                    </tbody>
                </table>
                <a href="add_treatment.php" class="btna">Add Treatment</a>
            </div>
            <div class="col3">
                <div class="filter-container">
                    <form method="post" class="form-inline">
                        <label for="filterDate" class="form-label">Filter by Date:</label>
                        <input type="date" name="filterDate" id="filterDate" class="form-control" required>
                        <button type="submit" class="btn btn-primary">Filter</button>
                    </form>
                </div>
                <div class="show-all-container">
                    <form method="post" class="form-inline">
                        <input type="hidden" name="showAll" value="true">
                        <button type="submit" class="btn btn-secondary">Show All Treatments</button>
                    </form>
                </div>
            </div>

            <div class="col2">
                <div id="treatmentChart" width="800" height="365"></div>
            </div>
            <script src="https://cdnjs.cloudflare.com/ajax/libs/apexcharts/3.44.0/apexcharts.min.js"></script>
            <script>
    $(document).ready(function() {
        function filterTableByDate(filterDate) {
            $('.content-table tbody tr').each(function() {
                var rowDate = $(this).find('td:eq(1)').text(); // Assuming date is in the second column (index 1)
                if (filterDate !== '' && rowDate.trim() !== filterDate.trim()) {
                    $(this).hide();
                } else {
                    $(this).show();
                }
            });
        }

        $('#filterDate').on('input', function() {
            var selectedDate = $(this).val();
            filterTableByDate(selectedDate);
        });

        $('form').on('submit', function(event) {
            event.preventDefault();
            var selectedDate = $('#filterDate').val();
            filterTableByDate(selectedDate);
        });

        // Handling delete action separately
        $('.content-table').on('click', '.btn-danger', function(event) {
            event.preventDefault();
            var id = $(this).closest('tr').find('input[name="id"]').val();

            // AJAX request to delete treatment record
            $.ajax({
                type: 'POST',
                url: 'delete_treatment.php', // Replace with your delete script URL
                data: { id: id },
                success: function(response) {
                    // If deletion is successful, remove the table row
                    $(event.target).closest('tr').remove();
                    console.log('Record with ID ' + id + ' deleted successfully');
                },
                error: function(xhr, status, error) {
                    console.error('Error deleting record:', error);
                }
            });
        });

        // Handling modify action separately
        $('.content-table').on('click', '.btn-info', function(event) {
            event.preventDefault();
            var id = $(this).closest('tr').find('input[name="id"]').val();

            // Redirect or perform modification action here
            // Example: Redirect to modify_treatment.php with the ID parameter
            window.location.href = 'modify_treatment.php?id=' + id;
        });
    });

</script>
            <script src="treatment_stats.js"></script>
        </main>
        
            <section class="sidebar">
             
             <div class="logo">
                 <a href="home.php" ><span class="material-symbols-outlined">
                     admin_panel_settings
                     </span>Admin</a>
             </div>
             
             <ul class="nav-bar">
                 
                 <li >
                     <a href="../Home/home.php">
                     <span class="material-symbols-outlined">home</span>
                    Home</a>
                 </li>

                 <li>
                     <a href="../Users/users.php">
                     <span class="material-symbols-outlined">Person</span>
                     Users</a>
                 </li>

                 <li>
                     <a href="../offers/offers.php">
                     <span class="material-symbols-outlined">sell</span>
                     Plans</a>
                 </li>

                 <li>
                     <a href="../sales/sales.php">
                     <span class="material-symbols-outlined">attach_money</span>
                    sales</a>
                 </li>
                 
                 <li>
                     <a href="../RDV/MainAdminRdv.php">
                     <span class="material-symbols-outlined">event_available</span>
                     Rdv</a>
                 </li>
                 
                 <li>
                 <a href="../Demande/backDemand.php">
                     <span class="material-symbols-outlined">note_add</span>
                     request</a>
                 </li>
                 <li class="active">
                     <a href="../treatment/treatment.php">
                     <span class="material-symbols-outlined">medical_services</span>
                     treatments</a>
                 </li>
                 <li>
                     <a href="../treatment_types/Treatmenttype.php">
                     <span class="material-symbols-outlined">local_hospital</span>
                     treatments types</a>
                 </li>
                 <div class= "logout">
                     <li>
                         <a href="../Login/login.php" onclick="removeFromHistory() ">
                         <span class="material-symbols-outlined">logout</span>Logout</a>                                            
                      </li>
                      
                 </div>

             </ul>
     </section>
    </div>
    <!-- Include Bootstrap JS -->
    <!-- Your Bootstrap JS includes -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</body>

</html><!-- Your HTML code -->