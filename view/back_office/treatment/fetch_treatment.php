<?php
// Include your PDO connection and Treatment class here
require_once '../../../model/db_connect_front.php'; // Include your connection file
require_once '../../../model/treatement.php'; // Include your Treatment class file

// Check if the selected date is received via POST method
if (isset($_POST['date'])) {
    // Retrieve the selected date from the POST data
    $selectedDate = $_POST['date'];

    try {
        // Create a Treatment object using your PDO connection
        $treatment = new Treatment($pdo);

        if ($selectedDate === '') {
            // Fetch all treatments if no date is selected
            $stmt = $pdo->prepare("SELECT date_of_treatment, COUNT(*) AS treatmentCount 
                                FROM treatment 
                                GROUP BY date_of_treatment 
                                ORDER BY date_of_treatment");
            $stmt->execute();
        } else {
            // Fetch treatments for the selected date
            $stmt = $pdo->prepare("SELECT date_of_treatment, COUNT(*) AS treatmentCount 
                                FROM treatment 
                                WHERE date_of_treatment = :selectedDate 
                                GROUP BY date_of_treatment 
                                ORDER BY date_of_treatment");
            $stmt->bindParam(':selectedDate', $selectedDate);
            $stmt->execute();
        }

        // Fetch all treatments grouped by date and their respective counts
        $treatmentStats = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Prepare data arrays to hold dates and treatment counts
        $dates = array();
        $treatmentCounts = array();

        // Process fetched data to populate dates and treatmentCounts arrays
        foreach ($treatmentStats as $stat) {
            $dates[] = $stat['date_of_treatment'];
            $treatmentCounts[] = $stat['treatmentCount'];
        }

        // Create an associative array combining dates and treatment counts
        $data = array_combine($dates, $treatmentCounts);

        // Return the data as a JSON response to the AJAX request
        echo json_encode($data);
    } catch (PDOException $e) {
        // Handle exceptions if any
        echo "Error: " . $e->getMessage();
    }
}
?>
