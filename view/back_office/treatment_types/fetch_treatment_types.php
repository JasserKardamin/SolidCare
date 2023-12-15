<?php
// Include your PDO connection and necessary classes here
require_once '../../../model/db_connect_front.php';
require_once '../../../model/treatement.php';
require_once '../../../model/treatmenttypeC.php';

if (isset($_POST['prix'])) {
    // Retrieve the selected price
    $selectedprice = $_POST['prix'];
    
    try {
        if ($selectedprice === '') {
            // Fetch all treatment type names and their corresponding treatment counts
            $stmt = $pdo->prepare("SELECT treatmenttype.nom, COUNT(id_treatment) AS treatmentCount 
                                    FROM treatmenttype 
                                    LEFT JOIN treatment ON treatmenttype.nom = treatment.type_of_treatment
                                    GROUP BY treatmenttype.nom");
            $stmt->execute();
        } else {
            // Fetch treatment type names and treatment counts based on the selected price
            $stmt = $pdo->prepare("SELECT treatmenttype.nom, COUNT(id_treatment) AS treatmentCount 
                                    FROM treatmenttype 
                                    LEFT JOIN treatment ON treatmenttype.nom = treatment.type_of_treatment
                                    WHERE treatmenttype.prix = :selectedprice
                                    GROUP BY treatmenttype.nom");
            $stmt->bindParam(':selectedprice', $selectedprice);
            $stmt->execute();
        }

        $treatmentStats = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Prepare data arrays to hold names and treatment counts
        $name = array();
        $treatmentCounts = array();

        // Process fetched data to populate names and treatmentCounts arrays
        foreach ($treatmentStats as $stat) {
            $name[] = $stat['nom'];
            $treatmentCounts[] = $stat['treatmentCount'];
        }

        // Create an associative array combining names and treatment counts
        $data = array_combine($name, $treatmentCounts);

        // Return the data as a JSON response to the AJAX request
        echo json_encode($data);
    } catch (PDOException $e) {
        // Handle exceptions if any
        echo "Error: " . $e->getMessage();
    }
}
?>
