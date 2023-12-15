<?php
require("../../../model/rdv.php");
require("../../../model/patient.php");
/*show more button*/
$id_rdv = $_POST["id_rdv"];
$infos = $_POST["infos"];
$date = $_POST["date"];
$cinn = $_POST["cinn"];
$cinp = $_POST["cinp"];

/*end show more button*/
/*filters*/

$update_rdv_flag = $_POST["update_rdv_flag"];
$flag = 0;
$typee = $_POST["typee"];
$gender = $_POST["gender"];
$searchValue = $_POST["searchValue"];
$new_rdv = new rdv();
$new_nurse = new patient();
$new_patient = new patient();
if ($searchValue != NULL) {
    $final_list = $new_rdv->search_by_first_and_last_name($searchValue);
    if (empty($final_list)) {
        $flag = 1;
        $final_list = $new_rdv->read_all_RDV();
    }
} else if ($typee == NULL) {
    $typee = "all";
}
if ($typee == "patient") {

    $final_list = $new_rdv->read_all_RDV_by_patient_gender($typee, $gender);
    if (empty($final_list)) {
        $flag = 1;
        $final_list = $new_rdv->read_all_RDV();
    }
} else if ($typee == "nurse") {
    $final_list = $new_rdv->read_all_RDV_by_nurse_gender($typee, $gender);
    if (empty($final_list)) {
        $flag = 1;
        $final_list = $new_rdv->read_all_RDV();
    }
} else if ($typee == "all") {
    $final_list = $new_rdv->read_all_RDV();
}
/*end filters*/
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Pannel</title>
    <link rel="stylesheet" href="ressources/MainAdminRdv.css">
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    <style>

    </style>
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

        <div class="rdv-body">
            <div class="colm1">
                <div class="filters">
                    <div class="form-container">
                        <form class="patient-filter" action="" method="post">
                            <h3>Patient Gender</h3>
                            <div class="gender-select">
                                <select class="gender" name="gender">
                                    <option value="female">Female</option>
                                    <option value="male">Male</option>

                                </select>
                                <input type="hidden" name="typee" value="patient">
                                <button class="btn" type="submit">Submit</button>
                            </div>
                        </form>
                        <form class="nurse-filter" action="" method="post">
                            <h3>Nurse Gender</h3>
                            <div class="gender-select">
                                <select class="gender" name="gender">
                                    <option value="female">Female</option>
                                    <option value="male">Male</option>

                                </select>
                                <input type="hidden" name="typee" value="nurse">
                                <button class="btn" type="submit">Submit</button>
                            </div>
                        </form>
                        <form class="display-all" action="" method="post">
                            <div class="gender-select">
                                <input type="hidden" name="typee" value="all">
                                <button class="btn" type="submit">Display All</button>
                            </div>
                        </form>
                    </div>
                    <form class="search" action="" method="post">
                        <div class="inputBox">
                            <input id="name" type="text" name="searchValue">
                            <span>search by first or last name </span>
                        </div>
                    </form>
                    <div class="NoUser">
                        <?php
                        if ($flag == 1) {
                            echo "
                            <h3> No users found ! </h3>
                        ";
                        }
                        ?>
                    </div>
                </div>
                <div class="ShowMoreSection">
                    <?php
                    if ($id_rdv != NULL) {
                        ?>
                        <table class="RdvTable2">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>INFOS</th>
                                    <th>DATE</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>
                                        <?php echo $id_rdv ?>
                                    </td>
                                    <td>
                                        <?php echo $infos ?>
                                    </td>
                                    <td>
                                        <?php echo $date ?>
                                    </td>
                            </tbody>
                        </table>
                        <table class="RdvTable2">
                            <thead>
                                <tr>
                                    <th>CIN nurse</th>
                                    <th>LAST NAME</th>
                                    <th>FIRST NAME</th>
                                    <th>EMAIL</th>
                                    <th>PHONE</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $final_list1 = $new_nurse->read_PTT($cinn);
                                foreach ($final_list1 as $nrs) {
                                    ?>
                                    <tr>
                                        <td>
                                            <?php echo $nrs['CIN']; ?>
                                        </td>
                                        <td>
                                            <?php echo $nrs['lastname']; ?>
                                        </td>
                                        <td>
                                            <?php echo $nrs['firstname']; ?>
                                        </td>
                                        <td>
                                            <?php echo $nrs['email']; ?>
                                        </td>
                                        <td>
                                            <?php echo $nrs['phone']; ?>
                                        </td>
                                    </tr>
                                    <?php
                                }
                                ?>
                            </tbody>
                        </table>

                        <table class="RdvTable2">
                            <thead>
                                <tr>
                                    <th>CIN patient</th>
                                    <th>LAST NAME</th>
                                    <th>FIRST NAME</th>
                                    <th>EMAIL</th>
                                    <th>PHONE</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $final_list1 = $new_nurse->read_PTT($cinp);
                                foreach ($final_list1 as $ptt) {
                                    ?>
                                    <tr>
                                        <td>
                                            <?php echo $ptt['CIN']; ?>
                                        </td>
                                        <td>
                                            <?php echo $ptt['lastname']; ?>
                                        </td>
                                        <td>
                                            <?php echo $ptt['firstname']; ?>
                                        </td>
                                        <td>
                                            <?php echo $ptt['email']; ?>
                                        </td>
                                        <td>
                                            <?php echo $ptt['phone']; ?>
                                        </td>
                                    </tr>
                                    <?php
                                }
                                ?>
                            </tbody>
                        </table>

                        <div class="buttons">
                            <form class="rdvform" action="../../../controller/back_office/rdv/HandelRdvUpdate.php" method="post">
                                <button type="submit" class="mbtn" style="width: 150px">
                                    <input type="hidden" name="id_rdv" value="<?php echo $id_rdv; ?>">
                                    <input type="hidden" name="CIN_patient" value="<?php echo $ptt['CIN']; ?>">
                                    <input type="hidden" name="CIN_nurse" value="<?php echo $nrs['CIN']; ?>">
                                    <span class="button_top">Update RDV</span>
                                </button>
                            </form>
                        </div>
                        <?php
                    }
                    ?>
                </div>
            </div>
            <div class="rdv-list">
                <div class="lablet">
                    <h3>RDV List</h3>
                </div>
                <table class="RdvTable">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>INFOS</th>
                            <th>DATE</th>
                            <th>NURSE</th>
                            <th>PATIENT</th>
                            <th></th>
                        </tr>
                    </thead>
                    <?php
                    foreach ($final_list as $rdv) {
                        ?>
                        <div class="container">
                            <tbody>
                                <tr>
                                    <td>
                                        <?= $rdv['id_rdv']; ?>
                                    </td>
                                    <td>
                                        <?= $rdv['infos']; ?>
                                    </td>
                                    <td>
                                        <?= $rdv['date']; ?>
                                    </td>
                                    <td>
                                        <?= $rdv['CIN_nurse']; ?>
                                    </td>
                                    <td>
                                        <?= $rdv['CIN_patient']; ?>
                                    </td>
                                    <td>
                                        <div class="buttons">
                                            <form class="rdvform" action="" method="post">
                                                <button type="submit" class="mbtn">
                                                    <input type="hidden" name="id_up"
                                                        value=" <?php echo $rdv['id_rdv']; ?> ">
                                                    <input type="hidden" name="id_rdv"
                                                        value=" <?php echo $rdv['id_rdv']; ?> ">
                                                    <input type="hidden" name="infos"
                                                        value=" <?php echo $rdv['infos']; ?> ">
                                                    <input type="hidden" name="date" value=" <?php echo $rdv['date']; ?> ">
                                                    <input type="hidden" name="cinn"
                                                        value=" <?php echo $rdv['CIN_nurse']; ?> ">
                                                    <input type="hidden" name="cinp"
                                                        value=" <?php echo $rdv['CIN_patient']; ?> ">
                                                    <span class="button_top">More</span>
                                                </button>
                                            </form>
                                            <form class="rdvform" action="../../../controller/back_office/rdv/deleting_rdv.php" method="post">
                                                <input type="hidden" name="id_del" value=" <?php echo $rdv['id_rdv']; ?> ">
                                                <button type="submit" class="mbtn">
                                                    <span class="button_top">Delete</span>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>

                        </div>
                        <?php

                    }
                    ?>
                </table>
            </div>
        </div>

        <section class="sidebar">

            <div class="logo">
                <a href="home.php"><span class="material-symbols-outlined">
                        admin_panel_settings
                    </span>Admin</a>
            </div>

            <ul class="nav-bar">

                <li>
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
                <li class="active">
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
                        <a href="../Login/login.php">
                            <span class="material-symbols-outlined">logout</span>Logout</a>
                    </li>
                </div>

            </ul>
        </section>

    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/apexcharts/3.44.0/apexcharts.min.js"></script>
    <script src="charts.js"></script>
</body>

</html>