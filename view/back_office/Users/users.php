<?php

require '../../../model/db_connect_front.php';

/*
(pdp)
<?php
if ($row['profile_picture']) {
    $imageData = base64_encode($row['profile_picture']);
    $src = 'data:image/jpeg;base64,' . $imageData;
    echo '<div class="profile-picture-circle"><img src="' . $src . '" alt="Profile Picture" style="width: 70px; height: 70px;"></div>';
} else {
    echo 'No profile picture uploaded';
}
?>
*/
 
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Search by CIN
   
        try {
            $query = $pdo->prepare('SELECT * FROM user WHERE CIN = :cin');
            $query->bindParam(':cin', $search_cin);
            $query->execute();
            $results1 = $query->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            echo "Connection failed: " . $e->getMessage();
        }
    } if (isset($_POST["btn1"])) { // Ban
        $cin = $_POST['cin'];
     
        try {
            $query = $pdo->prepare('UPDATE user SET status = 0 WHERE CIN = :cin');
            $query->bindParam(':cin', $cin);
            $query->execute();
            
        } catch (PDOException $e) {
            echo "Connection failed: " . $e->getMessage();
        }
    } elseif (isset($_POST["btn3"])) { // Delete
        $cin = $_POST['cin'];
        try {
            $query = $pdo->prepare('DELETE FROM user WHERE CIN = :cin');
            $query->bindParam(':cin', $cin);
            $query->execute();
          
        } catch (PDOException $e) {
            echo "Connection failed: " . $e->getMessage();
        }
    } elseif (isset($_POST["btn2"])) { //unban
        $cin = $_POST['cin'];
        try {
            $query = $pdo->prepare('UPDATE user SET status = 1 WHERE CIN = :cin');
            $query->bindParam(':cin', $cin);
            $query->execute();
            
        } catch (PDOException $e) {
            echo "Connection failed: " . $e->getMessage();
        }
    }
try {
    $query = $pdo->prepare('SELECT * FROM user');
    $query->execute();
    $results1 = $query->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
    <link rel="stylesheet" href="users.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
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
                <div class="table_cc">
                <table class="content-table" id= "mytable">
                    <thead>
                        <tr>
                            <th>Cin</th>
                            <th>First Name</th>
                            <th>Last Name</th>
                            <th>email</th>
                            <th>phone</th>
                            <th>date of birth</th>
                            <th>location</th>
                            <th>Gender</th>
                            <th>typee</th>
                            <th>status</th>
                            <th>Ban</th>
                            <th>Unban</th>
                            <th>Delete</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($results1 as $row) { ?>
                            <tr>
                                <td><?php echo $row['CIN']; ?></td>
                                <td><?php echo $row['firstname']; ?></td>
                                <td><?php echo $row['lastname']; ?></td>
                                <td>
                                    <?php 
                                        if(strlen($row['email']) > 9 ) {
                                                echo substr($row['email'], 0,7).'...' ; 
                                                }   
                                            else {
                                                echo $row['email'];
                                            }
                                        ?>
                                </td>
                                <td><?php echo $row['phone']; ?></td>
                                <td><?php echo $row['date_of_birth']; ?></td>
                                <td><?php echo $row['location']; ?></td>
                                <td><?php echo $row['gender']; ?></td>
                                <td><?php echo $row['typee']; ?></td>
                                <td><?php echo $row['status']; ?></td>
                                <form action="" method="POST">
                                    <input type="hidden" name="cin" value="<?php echo $row['CIN']; ?>">
                                    <td><button name="btn1"><span class="material-symbols-outlined">block</span></button></td>
                                    <td><button name="btn2"><span class="material-symbols-outlined">check_circle</span></button></td>
                                    <td><button name="btn3"><span class="material-symbols-outlined">delete</span></button></td>
                                </form>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
                </div>
            </div>
            <div class="col2">
                    <div class="tit">
                        <p>search for</p>
                        <h1>Users</h1>
                    </div> 
                    <div class="s">
                        <script src="search.js"></script>    
                        <input onkeyup="filterByCIN()" id="cinInput"  name="seach" type="text" placeholder = "Search by CIN" >     
                        <span class="material-symbols-outlined">fingerprint</span>
                    </div>
                </div>
          

        </main>

        <section class="sidebar">
            <div class="logo">
                <a href="../Home/home.php"><span class="material-symbols-outlined">
                        admin_panel_settings
                    </span>Admin</a>
            </div>

            <ul class="nav-bar">

                    <li>
                        <a href="../Home/home.php">
                        <span class="material-symbols-outlined">home</span>
                       Home</a>
                    </li>

                    <li class="active">
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
                    <li>
                        <a href="../treatment/treatment.php">
                        <span class="material-symbols-outlined">medical_services</span>
                        treatments</a>
                    </li>
                    <li>
                        <a href="../treatment_types/Treatmenttype.php">
                        <span class="material-symbols-outlined">local_hospital</span>
                        treatments types</a>
                    </li>
                <div class="logout">
                    <li>
                        <a href="../Login//login.php">
                            <span class="material-symbols-outlined">logout</span>Logout</a>
                    </li>
                </div>

            </ul>
        </section>

    </div>
