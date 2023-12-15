<?php require '../../../../model/sessions_start.php';  
?>
<!DOCTYPE html>
<html>
<head>
    <title>Ajouter un Traitement</title>
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
</head>

<body >
<h1 class="text-center">Ajouter un Traitement</h1>
        <div class="center-form">
        <div class="form-box ">
    <br>
    <form action="add_treatmentI.php" method="post">
    <div class="mb-3">
        <label for="date">Date du Traitement :</label>
        <input class="form-control" type="date" name="date" id="date"><br>
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
    </div>
    <div class="mb-3">
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
    </div>
    <div class="mb-3">
        <label for="cin_patient">CIN du Patient :</label>
        <select class="form-control" name="cin_patient" id="cin_patient">
        
            <?php
           require '../../../../model/db_connect_front.php'; // Include your connection file
          // Include your connection file
            // Fetch CIN data for patients from your Users table
            $sqlPatient = "SELECT CIN FROM user WHERE typee = 'patient'";
            $stmtPatient = $pdo->query($sqlPatient);

            // Populate the select dropdown with CIN options for patients
            while ($rowPatient = $stmtPatient->fetch(PDO::FETCH_ASSOC)) {
                echo "<option value='{$rowPatient['CIN']}'>{$rowPatient['CIN']}</option>";
            }
            ?>
        </select><br>
        </div>
        <div class="mb-3">
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
        // Retrieve cin from cookies

        // Fetch and populate the select dropdown with the Nurse's cin
        
       
        
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
</div>
        <button class="btn btn-primary" type="submit" >Ajouter</button>
    </form>

    <?php
   require '../../../../model/db_connect_front.php'; // Include your connection file
   require '../../../../model/treatement.php'; 
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $date = $_POST['date'];
        $type = $_POST['type'];
        $cinPatient = $_POST['cin_patient'];
        $cinNurse = $_POST['cin_nurse'];
    
        $treatmentController = new Treatment($pdo); // Assuming your Treatment controller is named 'TreatmentC.php'
        $success = $treatmentController->addTreatment($date, $type, $cinPatient, $cinNurse);
    
        if ($success) {
            echo "Traitement ajouté avec succès.";
            $notificationPatient = [
                'cin_recipent' => $cinPatient,
                'message_content' => 'You have a new treatment scheduled.',
                'timestamp' => date('Y-m-d H:i:s'), // Current timestamp
                'status' => 'unread'
            ];
            
            $notificationNurse = [
                'cin_recipent' => $cinNurse,
                'message_content' => 'New treatment scheduled for a patient.',
                'timestamp' => date('Y-m-d H:i:s'), // Current timestamp
                'status' => 'unread'
            ];
            
            // Prepare the SQL statement for inserting notifications
            $sql = "INSERT INTO notification (cin_recipent, message_content, timestamp, status) VALUES (?, ?, ?, ?)";
            
            // Prepare the statement
            $stmt = $pdo->prepare($sql);
            
            // Bind parameters and execute the statement for the patient's notification
            $stmt->execute([$notificationPatient['cin_recipent'], $notificationPatient['message_content'], $notificationPatient['timestamp'], $notificationPatient['status']]);
            
            // Bind parameters and execute the statement for the nurse's notification
            $stmt->execute([$notificationNurse['cin_recipent'], $notificationNurse['message_content'], $notificationNurse['timestamp'], $notificationNurse['status']]);
        } else {
            echo "Échec de l'ajout du traitement.";
        }
    
        // Redirect to the treatment list page after adding the treatment
        header("Location: treatmentI.php");
        exit;
    }
    ?>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
        </div>
    </div>
</body>
</html>
