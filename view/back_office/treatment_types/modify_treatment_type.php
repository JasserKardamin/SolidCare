<!DOCTYPE html>
<html>

<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="../treatment/users.css">

    <title>Modifier un Traitement</title>
    <style>
        .center-form {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .form-box {
            padding: 20px;
            background-color: black;
            color: white;
            border-radius: 8px;
            width: 400px;
        }
    </style>
</head>

<body>
    <h1>Modifier un Traitement</h1>

    <?php
    require '../../../model/treatmenttypeC.php'; // Adjust the path accordingly
    require '../../../model/db_connect_front.php';

    if (isset($_GET['nom']) && !empty($_GET['nom'])) {
        $treatmentTypenom = $_GET['nom'];
        $treatmentType = new TreatmentType($pdo); // Assuming $pdo is your database connection

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            // Handle form submission for treatment type modification
            $nom = $_POST['nom'];
            $prix = $_POST['prix'];
            $speciality = $_POST['speciality'];

            $result = $treatmentType->modifyTreatmentType($nom, $prix, $speciality);
            if ($result) {
                echo "Traitement modifié avec succès.";
                header("Location: Treatmenttype.php");
            } else {
                echo "Échec de la modification du traitement.";
            }
        }

        // Display a form pre-filled with treatment type details for modification
        $treatmentTypeDetails = $treatmentType->getTreatmentTypeByNom($treatmentTypenom);
        if ($treatmentTypeDetails) {
    ?>
            <div class="center-form">
                <div class="form-box">
                    <form action="" method="post">
                        <input class="form-control" type="hidden" name="id" value="<?php echo $treatmentTypeDetails['nom']; ?>">
                        <label for="nom">Nom :</label>
                        <input class="form-control" type="text" name="nom" id="nom" value="<?php echo $treatmentTypeDetails['nom']; ?>"><br>

                        <label for="prix">Prix (DT):</label>
                        <div class="input-group">
                            <input class="form-control" type="number" step="0.01" name="prix" id="prix">
                            <span class="input-group-text">DT</span>
                        </div><br>


                        <label for="speciality">Speciality :</label>
                        <input class="form-control" type="text" name="speciality" id="speciality" value="<?php echo $treatmentTypeDetails['speciality']; ?>"><br>

                        <!-- Modify this section to fetch CIN data for patients and nurses -->

                        <button class="btn btn-primary" type="submit">Modifier</button>
                    </form>
                </div>
            </div>
    <?php
        } else {
            echo "Traitement non trouvé.";
        }
    } else {
        echo "ID du traitement non spécifié.";
    }
    ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</body>

</html>