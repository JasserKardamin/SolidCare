<?php
require_once '../../../model/db_connect_front.php';

try {

    $query = $pdo->prepare("SELECT id_dmd, CIN_nurse, CIN_patient, infos, date, status FROM DMDS");
    $query1 = $pdo->prepare("SELECT id, email, status FROM newsletter");

    $query1->execute();
    $query->execute();

    $result2 = $query1->fetchALL(PDO::FETCH_ASSOC);
    $result1 = $query->fetchALL(PDO::FETCH_ASSOC);



} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="BackDemand.css">
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200">
</head>

<body>
    <div class="grid-container">
        <header class="header">
            <span class="material-symbols-outlined" style="font-size: 37px;">search</span>
            <div class="mail">
                <a href="../mail/mailing.php"><span class="material-symbols-outlined"
                        style="font-size: 37px;">mail</span></a>
            </div>

        </header>
        <main class="main">
            <div class="col1">
                <div class="plans">
                    <h1 class="title">Demands</h1>
                    <table class="content-table" id="myTable">
                        <thead>
                            <tr>
                                <th>id_dmd</th>
                                <th>CIN_nurse</th>
                                <th>CIN_patient</th>
                                <th>infos</th>
                                <th>date</th>
                                <th>status</th>
                                <th>action</th>
                            </tr>
                        </thead>

                        <?php foreach ($result1 as $row) { ?>
                            <tr>
                                <td>
                                    <?php echo $row['id_dmd'] ?>
                                </td>
                                <td>
                                    <?php echo $row['CIN_nurse'] ?>
                                </td>
                                <td>
                                    <?php echo $row['CIN_patient'] ?>
                                </td>
                                <td>
                                    <?php echo $row['infos'] ?>
                                </td>
                                <td>
                                    <?php echo $row['date'] ?>
                                </td>
                                <td>
                                    <?php echo $row['status'] ?>
                                </td>
                                <td>
                                    <form class="offer-form1" action="../../../controller/back_office/dmd/DeleteDmd.php" method='post'>
                                        <button class="btn" type="submit" name="btn1">Delete</button>
                                        <input type="hidden" name="delete" value="<?php echo $row['id_dmd']; ?>">
                                    </form>
                                </td>
                            </tr>
                        <?php } ?>

                    </table>
                </div>
                <div class="metier">
                    <h1 class="title">NewsLettre</h1>
                    <table class="metier-table" id="TableNews">
                        <thead>
                            <tr>
                                <th>id_newslettre</th>
                                <th>email</th>
                                <th>status</th>
                                <th>action</th>
                            </tr>
                        </thead>

                        <?php foreach ($result2 as $row1) { ?>
                            <tr>
                                <td>
                                    <?php echo $row1['id'] ?>
                                </td>
                                <td>
                                    <?php echo $row1['email'] ?>
                                </td>
                                <td>
                                    <?php echo $row1['status'] ?>
                                </td>
                                <td>
                                    <form class="offer-form1" action="../../../controller/back_office/dmd/DeleteDmd.php" method='post'>
                                        <button class="btn" type="submit" name="btn1">Delete</button>
                                        <input type="hidden" name="delete" value="<?php echo $row1['id']; ?>">
                                    </form>
                                </td>
                            </tr>
                        <?php } ?>
                    </table>
                </div>
            </div>

            <div class="col3">
                <h3>Search Demands</h3>

                <form class="offer-form" action="../../controller/offers/add_offer.php" method="POST">

                    <div class="inputBox">
                        <input id="name" name="name" type="text" title="FilterByStatus" onkeyup="filter()"
                            placeholder="Search with status..">
                        <span>Search</span>
                    </div>
                    <h3>Search Newsletter</h3>
                    <div class="inputBox">
                        <input id="statusFilterInput" name="name" type="text" title="FilterByStatus"
                            onkeyup="filterStatus()" placeholder="Search with status..">
                        <span>Search</span>
                    </div>

                    <!-- <div class="inputBox">
                        <input id="price" name="price" type="test">
                        <span>Price</span>
                    </div>


                    <div class="inputBox">
                        <textarea id="desc" name="desc" cols="30" rows="10"></textarea>
                        <span>Description</span>
                    </div>

                    <div class="inputBox">
                        <input id="duration" name="duration" type="duration">
                        <span>Duration</span>
                    </div>

                    <button class="btn" type="submit" name="btn1" onclick="verif()">Add</button> -->
                    <!-- <button class="btn" type="submit" name="btn2" onclick="filter()">Modify</button> -->
                </form>
            </div>
        </main>

        <section class="sidebar">
            <div class="logo">
                <a href="../Home/home.php"><span class="material-symbols-outlined">
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
                    
                    <li class="active">
                    <a href="backDemand.php">
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
                    <div class= "logout">
                        <li>
                            <a href="../Login/login.php" onclick="removeFromHistory() ">
                            <span class="material-symbols-outlined">logout</span>Logout</a>                                            
                         </li>
                         
                    </div>

                </ul>
        </section>

    </div>
    <script src="Filter.js"></script>
    <script>
        function filterStatus() {
            var input, filter, table, tr, td, i, txtValue;
            input = document.getElementById("statusFilterInput");
            filter = input.value.trim().toUpperCase();
            table = document.getElementById("TableNews");
            tr = table.getElementsByTagName("tr");

            for (i = 0; i < tr.length; i++) {
                td = tr[i].getElementsByTagName("td")[2];
                if (td) {
                    txtValue = td.textContent || td.innerText;
                    var isExactMatch = txtValue.trim().toUpperCase() === filter;

                    tr[i].style.display = filter === "" || isExactMatch ? "" : "none";
                }
            }
        }


    </script>

</body>


</html>