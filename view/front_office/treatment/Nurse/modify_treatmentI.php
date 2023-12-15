<!-- modifytreatment.php -->
<?php require '../../../../model/sessions_start.php';  
?>
<!DOCTYPE html>
<html>

<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">

    <style>
        .center-form {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        

        .form-box {
            padding: 20px;
            background-color:#1a76d1;
            color: white;
            border-radius: 8px;
            width: 400px;
        }
    </style>
    <title>Modifier un Traitement</title>
</head>

<body>
 

    <?php
require '../../../../model/treatement.php'; // Include your Treatment class file
require '../../../../model/db_connect_front.php'; // Include your connection file
    // Retrieve the treatment ID from the URL parameter

    if ( isset($_GET['id']) && !empty($_GET['id'])) {
        $treatmentId = $_GET['id'];
        $treatment = new Treatment($pdo); // Assuming $pdo is your database connection

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            // Handle form submission for treatment modification
            $date = $_POST['date'];
            $type = $_POST['type'];
            $cinPatient = $_POST['cin_patient'];
            $cinNurse = $_POST['cin_nurse'];

            $result = $treatment->modifyTreatment($treatmentId, $date, $type, $cinPatient, $cinNurse);
            if ($result) {
                echo "Traitement modifié avec succès.";
                header("Location: treatmentI.php");
            } else {
                echo "Échec de la modification du traitement.";
            }
        }

        // Display a form pre-filled with treatment details for modification
        $treatmentDetails = $treatment->getTreatmentById($treatmentId);
        if ($treatmentDetails) {
    ?>  <div class="center-form">
        <div class="form-box">
            <form action="" method="post">
                <input type="hidden" name="id" value="<?php echo $treatmentDetails['id_treatment']; ?>">
                <label for="date">Date du Traitement :</label>
                <input class="form-control" type="date" name="date" id="date" value="<?php echo $treatmentDetails['date_of_treatment']; ?>"><br>
                <script>
    // Get the date input element
    const dateInput = document.getElementById('date');

    // Add an event listener to the date input
    dateInput.addEventListener('input', function() {
        const selectedDate = new Date(this.value);
        const today = new Date();

        // Set hours to 0 to compare dates without time
        selectedDate.setHours(0, 0, 0, 0);
        today.setHours(0, 0, 0, 0);

        // Prevent selecting dates in the past
        if (selectedDate < today) {
            alert('Please select a date equal to or after today');
            this.value = today.toISOString().split('T')[0];
        }
    });
</script>
                <label for="type">Type de Traitement :</label>
                <select class="form-control" name="type" id="type">
                    <?php
require '../../../../model/db_connect_front.php'; // Include your connection file
// Fetch treatment types from your database and display them as options in the select dropdown
                    $sql = "SELECT nom FROM treatmenttype"; // Modify the SQL query as per your table structure
                    $stmt = $pdo->query($sql);

                    // Loop through the fetched treatment types and create options for the select dropdown
                    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                        echo "<option value='{$row['nom']}'>{$row['nom']}</option>";
                    }
                    ?>
                </select><br>

                <label for="cin_patient">CIN du Patient :</label>
                <select class="form-control" name="cin_patient" id="cin_patient">
            <?php
            // Fetch CIN data for patients from your Users table
            $sqlPatient = "SELECT CIN FROM user WHERE typee = 'patient'";
            $stmtPatient = $pdo->query($sqlPatient);

            // Populate the select dropdown with CIN options for patients
            while ($rowPatient = $stmtPatient->fetch(PDO::FETCH_ASSOC)) {
                echo "<option value='{$rowPatient['CIN']}'";
                if ($treatmentDetails['CIN_Patient'] == $rowPatient['CIN']) {
                    echo " selected";
                }
                echo ">{$rowPatient['CIN']}</option>";
            }
            ?>
        </select><br>

                <label for="cin_nurse">CIN de l'Infirmière :</label>
                <select class="form-control" name="cin_nurse" id="cin_nurse">
                        <?php
                        require '../../../../model/db_connect_front.php'; // Include your connection file
                        
                        // Include your connection file
                        if (isset($_SESSION['cin'])) {
                            $cinNurse = $_SESSION['cin'] ?? ''; 
                            echo "<option value='{$cinNurse}' selected>{$cinNurse}</option>";

                        } else {
                            // Handle the case where the cookie doesn't exist or is not set
                            // Redirect or display an error message, etc.
                            exit('Error: Cin Session not set!');
                        }
                        ?>
                </select><br>
                <script>
    // Add event listener for changes in the cin_nurse field
    document.getElementById('cin_nurse').addEventListener('click', function() {
        // Alert users when attempting to change the nurse's CIN
        alert('You cannot change the Nurse CIN manually. It is automatically set.');
        // Reset the cin_nurse field to the default selected value (using first option)
        this.value = this.options[0].value;
    });
</script>
                <button class="btn btn-primary" type="submit" >Modify</button>
            </form>
    <?php
        } else {
            echo "Traitement non trouvé.";
        }
    } else {
        echo "ID du traitement non spécifié.";
    }
    ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    </div>
    </div>
</body>

</html>