<!DOCTYPE html>
<html>

<head>
    <title>Ajouter un Traitement</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="../treatment/users.css">

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
    <h1>Ajouter un Traitement</h1>
    <div class="center-form">
        <div class="form-box">
            <form action="add_treatment_type.php" method="post">
                <label for="nom">Nom :</label>
                <input class="form-control" type="text" name="nom" id="nom"><br>

                <label for="prix">Prix (DT):</label>
                <div class="input-group">
                    <input class="form-control" type="number" step="0.01" name="prix" id="prix">
                    <span class="input-group-text">DT</span>
                </div><br>


                <label for="speciality">Speciality :</label>
                <input class="form-control" type="text" name="speciality" id="speciality"><br>

                <!-- Replace with PHP code to fetch CIN data for patients and nurses -->

                <button class="btn btn-primary" type="submit">Ajouter</button>
            </form>

            <?php
           require '../../../model/treatmenttypeC.php'; // Adjust the path accordingly
           require '../../../model/db_connect_front.php';
            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                $nom = $_POST['nom'];
                $prix = $_POST['prix'];
                $speciality = $_POST['speciality'];

                $treatmentTypeController = new TreatmentType($pdo); // Assuming your TreatmentType controller is named 'TreatmentTypeC.php'
                $success = $treatmentTypeController->addTreatmentType($nom, $prix, $speciality);

                if ($success) {
                    echo "Traitement ajouté avec succès.";
                } else {
                    echo "Échec de l'ajout du traitement.";
                }

                // Redirect to the treatment type list page after adding the treatment type
                header("Location: Treatmenttype.php");
                exit;
            }
            ?>
            <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
        </div>
    </div>
</body>

</html>