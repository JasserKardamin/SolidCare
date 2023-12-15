<?php 
require 'db_connect_front.php'; 

class Treatment {
    private $db;

    public function __construct(PDO $pdo) {
        $this->db = $pdo;
    }

    // Function to add a new treatment record
    public function addTreatment($dateOfTreatment, $typeOfTreatment, $cinPatient, $cinNurse) {
        $sql = "INSERT INTO treatment (date_of_treatment, type_of_treatment, CIN_Patient, CIN_NURSE)
                VALUES (:dateOfTreatment, :typeOfTreatment, :cinPatient, :cinNurse)";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':dateOfTreatment', $dateOfTreatment);
        $stmt->bindParam(':typeOfTreatment', $typeOfTreatment);
        $stmt->bindParam(':cinPatient', $cinPatient);
        $stmt->bindParam(':cinNurse', $cinNurse);
        
        return $stmt->execute();
    }
    public function getTreatmentById($treatmentId) {
        try {
            $stmt = $this->db->prepare("SELECT * FROM treatment WHERE id_treatment = ?");
            $stmt->execute([$treatmentId]);
            $treatment = $stmt->fetch(PDO::FETCH_ASSOC);
            return $treatment; // Return treatment details
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return null;
        }
    }
    // Function to delete a treatment record by its ID
    public function deleteTreatment($idTreatment) {
        $sql = "DELETE FROM treatment WHERE id_treatment = :idTreatment";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':idTreatment', $idTreatment);
        
        return $stmt->execute();
    }

    // Function to modify/update an existing treatment record
    public function modifyTreatment($idTreatment, $dateOfTreatment, $typeOfTreatment, $cinPatient, $cinNurse) {
        $sql = "UPDATE treatment 
                SET date_of_treatment = :dateOfTreatment, type_of_treatment = :typeOfTreatment,
                    CIN_Patient = :cinPatient, CIN_NURSE = :cinNurse
                WHERE id_treatment = :idTreatment";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':idTreatment', $idTreatment);
        $stmt->bindParam(':dateOfTreatment', $dateOfTreatment);
        $stmt->bindParam(':typeOfTreatment', $typeOfTreatment);
        $stmt->bindParam(':cinPatient', $cinPatient);
        $stmt->bindParam(':cinNurse', $cinNurse);
        
        return $stmt->execute();
    }
    // Inside your Treatment class
public function fetchTreatments() {
    $sql = "SELECT * FROM treatment"; // Replace this with your SQL query
    $stmt = $this->db->query($sql);

    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
// Inside your Treatment class
public function countTreatmentsByDate($selectedDate) {
    $sql = "SELECT COUNT(*) as totalTreatments FROM treatment WHERE DATE(date_of_treatment) = :selectedDate";

    $stmt = $this->db->prepare($sql);
    $stmt->bindParam(':selectedDate', $selectedDate);
    $stmt->execute();

    return $stmt->fetch(PDO::FETCH_ASSOC)['totalTreatments'];
}

}


$treatment = new Treatment($pdo);
?>