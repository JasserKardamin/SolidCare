<?php
require("../../../model/rdv.php");
require("../../../model/patient.php");
require("../../../model/nurse.php");

$id_rdv = $_POST["id_rdv"];
$CIN_nurse = $_POST["CIN_nurse"];
$CIN_patient = $_POST["CIN_patient"];

//var_dump($id_rdv ,$CIN_nurse,$CIN_patient);

$new_rdv = new rdv();
$new_nurse = new nurse();
$new_patient = new patient();

$final_list = $new_rdv->read_RDV_by_id($id_rdv);
$final_list1 = $new_nurse->read_NRS_by_CIN($CIN_nurse);
$final_list2 = $new_patient->read_PTT($CIN_patient);

//var_dump($final_list,$final_list1,$final_list2);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Pannel</title>
    <link rel="stylesheet" href="../../../view/back_office/RDV/ressources/MainAdminRdv.css">
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
                <a href="../../../view/back_office/mail/mailing.php"><span class="material-symbols-outlined"
                        style="font-size: 37px;">mail</span>
                </a>
            </div>
        </header>
        <form class="update-form" action="HandelRdvUpdateAgain.php" method="post">
        <div class="update-rdv-body">
                <div class="update-zone">
                <div class="lablet" style="height: 50px;">
                    <h3>Update RDV</h3>
                </div>
                    <table class="UpdateTable">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>INFOS</th>
                                <th>DATE</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            foreach ($final_list as $rdv) {
                                ?>
                                <tr>
                                    <td>
                                        <input type="hidden" name="id_rdv" value=" <?php echo $rdv['id_rdv']; ?> ">
                                        <?php echo $rdv['id_rdv'] ?>
                                    </td>
                                    <td>
                                        <label class="search-label">
                                            <input type="hidden" name="old_infos_value"
                                                value=" <?php echo $rdv['infos']; ?> ">
                                            <input type="text" name="new_infos_value" class="input"
                                                placeholder="<?php echo $rdv['infos']; ?>">
                                        </label>
                                    </td>
                                    <td>
                                        <label class="search-label">
                                            <input type="hidden" name="old_date_value"
                                                value=" <?php echo $rdv['date']; ?> ">
                                            <input type="text" name="new_date_value" class="input"
                                                placeholder="<?php echo $rdv['date']; ?>">
                                        </label>
                                    </td>
                                    <?php
                            }
                            ?>
                        </tbody>
                    </table>
                    <table class="UpdateTable">
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
                            foreach ($final_list1 as $nrs) {
                                ?>
                                <tr>
                                    <td>
                                        <input type="hidden" name="cinn" value=" <?php echo $nrs['CIN']; ?> ">
                                        <?php echo $nrs['CIN']; ?>
                                    </td>
                                    <td>
                                        <label class="search-label">
                                            <input type="hidden" name="old_last_name_value_n"
                                                value=" <?php echo $nrs['lastname']; ?> ">
                                            <input type="text" name="new_last_name_value_n" class="input"
                                                placeholder="<?php echo $nrs['lastname']; ?>">
                                        </label>
                                    </td>
                                    <td>
                                        <label class="search-label">
                                            <input type="hidden" name="old_first_name_value_n"
                                                value=" <?php echo $nrs['firstname']; ?> ">
                                            <input type="text" name="new_first_name_value_n" class="input"
                                                placeholder="<?php echo $nrs['firstname']; ?>">
                                        </label>
                                    </td>
                                    <td>
                                        <label class="search-label">
                                            <input type="hidden" name="old_email_value_n"
                                                value=" <?php echo $nrs['email']; ?> ">
                                            <input type="text" name="new_email_value_n" class="input"
                                                placeholder="<?php echo $nrs['email']; ?>">
                                        </label>
                                    </td>
                                    <td>
                                        <label class="search-label">
                                            <input type="hidden" name="old_phone_value_n"
                                                value=" <?php echo $nrs['phone']; ?> ">
                                            <input type="text" name="new_phone_value_n" class="input"
                                            dzdz                placeholder="<?php echo $nrs['phone']; ?>">
                                        </label>
                                    </td>
                                </tr>
                                <?php
                            }
                            ?>
                        </tbody>
                    </table>

                    <table class="UpdateTable">
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
                            foreach ($final_list2 as $ptt) {
                                ?>
                                <tr>
                                    <td>
                                        <input type="hidden" name="cinp"
                                            value=" <?php echo $ptt['CIN']; ?> ">
                                        <?php echo $ptt['CIN']; ?>
                                    </td>
                                    <td>
                                        <label class="search-label">
                                            <input type="hidden" name="old_last_name_value_p"
                                                value=" <?php echo $ptt['lastname']; ?> ">
                                            <input type="text" name="new_last_name_value_p" class="input"
                                                placeholder="<?php echo $ptt['lastname']; ?>">
                                        </label>
                                    </td>
                                    <td>
                                        <label class="search-label">
                                            <input type="hidden" name="old_first_name_value_p"
                                                value=" <?php echo $ptt['firstname']; ?> ">
                                            <input type="text" name="new_first_name_value_p" class="input"
                                                placeholder="<?php echo $ptt['firstname']; ?>">
                                        </label>
                                    </td>
                                    <td>
                                        <label class="search-label">
                                            <input type="hidden" name="old_email_value_p"
                                                value=" <?php echo $ptt['email']; ?> ">
                                            <input type="text" name="new_email_value_p" class="input"
                                                placeholder="<?php echo $ptt['email']; ?>">
                                        </label>
                                    </td>
                                    <td>
                                        <label class="search-label">
                                            <input type="hidden" name="old_phone_value_p"
                                                value=" <?php echo $ptt['phone']; ?> ">
                                            <input type="text" name="new_phone_value_p" class="input"
                                                placeholder="<?php echo $ptt['phone']; ?>">
                                        </label>
                                    </td>
                                </tr>
                                <?php
                            }
                            ?>
                        </tbody>
                    </table>
                    <div class="buttons" style="margin-left: 40%; margin-top: 3%;">
                        <button type="submit" class="mbtn" style="width: 150px">
                            <span class="button_top">Confirm Update</span>
                        </button>
                    </div>
                </div>
            </form>
        </div>

        <section class="sidebar">

            <div class="logo">
                <a href="../../view/Home/home.php"><span class="material-symbols-outlined">
                        admin_panel_settings
                    </span>Admin</a>
            </div>

            <ul class="nav-bar">

                <li>
                    <a href="home.php../../view/Home/home.php">
                        <span class="material-symbols-outlined">home</span>
                        Home</a>
                </li>

                <li>
                    <a href="../../view/Users/users.php">
                        <span class="material-symbols-outlined">Person</span>
                        Users</a>
                </li>

                <li>
                    <a href="../../view/offers/offers.php">
                        <span class="material-symbols-outlined">sell</span>
                        Plans</a>
                </li>

                <li>
                    <a href="../../view/sales/sales.php">
                        <span class="material-symbols-outlined">attach_money</span>
                        sales</a>
                </li>
                <li class="active">
                    <a href="../../view/RDV/MainAdminRdv.php">
                        <span class="material-symbols-outlined">event_available</span>
                        Rdv</a>
                </li>

                <div class="logout">
                    <li>
                        <a href="../../view/Login/login.php">
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