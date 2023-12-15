<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

    <link rel="stylesheet" href="../treatment/users.css">

    <title>Treatment Type Records</title>
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
                    <h1>Treatment Type Records</h1>
                </div>
                <table class="content-table">
                    <thead>
                        <tr>
                            <th>Nom</th>
                            <th>Prix</th>
                            <th>Speciality</th>
                            <th colspan="2">Action</th>
                        </tr>
                    </thead>
                    <tbody>

                        <?php
                        // Include your PDO connection and TreatmentType class here
                        require '../../../model/db_connect_front.php'; // Include your connection file
                        require '../../../model/treatmenttypeC.php'; // Include your TreatmentType class file

                        $treatmentType = new TreatmentType($pdo);

                        // Handling Delete Action
                        if (isset($_POST['deleteTreatmentType'])) {
                            $nom = $_POST['nom']; // Get treatment type nom from the form
                            $treatmentType->deleteTreatmentType($nom); // Perform treatment type deletion
                            header("Location: Treatmenttype.php");
                            exit();
                        }

                        // Handling Modify Action
                        if (isset($_GET['modifyTreatmentType'])) {
                            $nom = $_GET['nom']; // Get treatment type nom from the form
                            header("Location: modify_treatment_type.php?nom=" . $nom);
                            exit();
                        }

                        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['filterPrice'])) {
                            $filterPrice = $_POST['filterPrice'];
                            
                            // Fetch treatment type records filtered by price from the database
                            $stmt = $pdo->prepare("SELECT * FROM treatmenttype WHERE prix = ?");
                            $stmt->execute([$filterPrice]);
                            $treatmentTypeRecords = $stmt->fetchAll(PDO::FETCH_ASSOC);
                        } 
                        else if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['showAll'])) {
                            // Fetch all treatment type records from the database
                            $treatmentTypeRecords = $treatmentType->fetchTreatmentTypes();
                        } else {
                            // Fetch treatment type records with any applied filters (if any)
                            $treatmentTypeRecords = $treatmentType->fetchTreatmentTypes();
                        }

                        foreach ($treatmentTypeRecords as $record) {
                            echo "<tr>";
                            echo "<td>{$record['nom']}</td>";
                            echo "<td>{$record['prix']} DT</td>";
                            echo "<td>{$record['speciality']}</td>";
                            echo "<td>";
                            echo "<form method='post'>";
                            echo "<input type='hidden' name='nom' value='{$record['nom']}'>";
                            echo "<button type='submit' name='deleteTreatmentType' class='btn btn-danger btn-sm'>Delete</button>";
                            echo "</form>";
                            echo "</td>";
                            echo "<td>";
                            echo "<form method='get' action='modify_treatment_type.php'>";
                            echo "<input type='hidden' name='nom' value='{$record['nom']}'>";
                            echo "<button type='submit' name='modifyTreatmentType' class='btn btn-info btn-sm'>Modify</button>";
                            echo "</form>";
                            echo "</td>";
                            echo "</tr>";
                        }
                        ?>
                    </tbody>
                </table>
                <a href="add_treatment_type.php" class="btna">Add Treatment Type</a>
            </div>
            <div class="col3">
            <div class="filter-container">
    <form method="post" class="form-inline">
        <label for="filterPrice" class="form-label">Filter by Price:</label>
        <input type="number" name="filterPrice" id="filterPrice" class="form-control" placeholder="Enter Price" >
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
    function filterTableByPrice(filterPrice) {
        $('.content-table tbody tr').each(function() {
            var rowPrice = parseFloat($(this).find('td:eq(1)').text()); // Assuming price is in the second column (index 1)
            if (isNaN(rowPrice) || (filterPrice !== '' && rowPrice !== parseFloat(filterPrice))) {
                $(this).hide();
            } else {
                $(this).show();
            }
        });
    }

    $('#filterPrice').on('input', function() {
        var selectedPrice = $(this).val();
        filterTableByPrice(selectedPrice);
    });

    $('form').on('submit', function(event) {
        event.preventDefault();
        filterTableByPrice('');
    });

    // Handling delete action separately for treatment types
    $('.content-table').on('click', '.btn-danger', function(event) {
        event.preventDefault();
        var nom = $(this).closest('tr').find('input[name="nom"]').val();

        // AJAX request to delete treatment type record
        $.ajax({
            type: 'POST',
            url: 'delete_treatment_type.php', // Replace with your delete script URL
            data: { nom: nom },
            success: function(response) {
                // If deletion is successful, remove the table row
                $(event.target).closest('tr').remove();
                console.log('Record with Name ' + nom + ' deleted successfully');
            },
            error: function(xhr, status, error) {
                console.error('Error deleting record:', error);
            }
        });
    });

    // Handling modify action separately for treatment types
    $('.content-table').on('click', '.btn-info', function(event) {
        event.preventDefault();
        var nom = $(this).closest('tr').find('input[name="nom"]').val();

        // Redirect or perform modification action here
        // Example: Redirect to modify_treatment_type.php with the Name parameter
        window.location.href = 'modify_treatment_type.php?nom=' + nom;
    });
});

        </script>
<script src="treatmenttype.js"></script>
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
                 <li >
                     <a href="../treatment/treatment.php">
                     <span class="material-symbols-outlined">medical_services</span>
                     treatments</a>
                 </li>
                 <li class="active">
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
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</body>

</html>