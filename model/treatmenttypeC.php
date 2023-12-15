<?php 
require_once 'db_connect_front.php'; 

class TreatmentType {
    private $db;

    public function __construct(PDO $pdo) {
        $this->db = $pdo;
    }

    // Function to add a new treatment type
    public function addTreatmentType($nom, $prix, $speciality) {
        $sql = "INSERT INTO treatmenttype (nom, prix, speciality)
                VALUES (:nom, :prix, :speciality)";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':nom', $nom);
        $stmt->bindParam(':prix', $prix);
        $stmt->bindParam(':speciality', $speciality);
        
        return $stmt->execute();
    }

    // Function to get treatment type by nom (primary key)
    public function getTreatmentTypeByNom($nom) {
        try {
            $stmt = $this->db->prepare("SELECT * FROM treatmenttype WHERE nom = ?");
            $stmt->execute([$nom]);
            $type = $stmt->fetch(PDO::FETCH_ASSOC);
            return $type; // Return treatment type details
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return null;
        }
    }

    // Function to delete a treatment type by nom (primary key)
    public function deleteTreatmentType($nom) {
        $sql = "DELETE FROM treatmenttype WHERE nom = :nom";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':nom', $nom);
        
        return $stmt->execute();
    }

    // Function to modify/update an existing treatment type
    public function modifyTreatmentType($nom, $prix, $speciality) {
        $sql = "UPDATE treatmenttype 
                SET prix = :prix, speciality = :speciality
                WHERE nom = :nom";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':nom', $nom);
        $stmt->bindParam(':prix', $prix);
        $stmt->bindParam(':speciality', $speciality);
        
        return $stmt->execute();
    }

    // Function to fetch all treatment types
    public function fetchTreatmentTypes() {
        $sql = "SELECT * FROM treatmenttype"; // Replace this with your SQL query
        $stmt = $this->db->query($sql);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>
