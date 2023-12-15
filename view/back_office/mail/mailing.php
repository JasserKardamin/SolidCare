<?php
require_once '../../../model/db_connect_front.php';

try {

    $query = $pdo->prepare("SELECT ID, NAME, EMAIL, SUBJECT, MESSAGE, ID_STATUS FROM reclamation");
    $query1 = $pdo->prepare("SELECT * FROM statusreclamation");

    $query->execute();
    $query1->execute();
    $result1 = $query->fetchALL(PDO::FETCH_ASSOC);
    $result2 = $query1->fetchAll(PDO::FETCH_ASSOC);


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
    <link rel="stylesheet" href="mailing.css">
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    <script>
        function validateForm() {
            var email = document.getElementById('email').value;
            var subject = document.getElementById('sbj').value;
            var body = document.getElementById('body').value;
            var altBody = document.getElementById('alt').value;
            if (email.trim() === '') {
                alert('Email is required.');
                return false;
            }

            if (subject.trim() === '') {
                alert('Subject is required.');
                return false;
            }

            if (body.trim() === '') {
                alert('Body is required.');
                return false;
            }

            if (altBody.trim() === '') {
                alert('AltBody is required.');
                return false;
            }
            return true;

        }


    </script>
</head>

<body>
    <div class="grid-container">

        <header class="header">
            <span class="material-symbols-outlined" style="font-size: 37px;">search</span>

            <div class="mail">
                <a href="mailing.php"><span class="material-symbols-outlined" style="font-size: 37px;">mail</span></a>
            </div>

        </header>

        <main class="main">

            <div class="col3" id="col3">
                <button class="close-btn" id="close-mailer-btn">X</button>
                <div class="logo">
                    <h2>Admin Mailer</h2>
                    <span class="material-symbols-outlined">attach_email</span>
                </div>
                <form class="offer-form" action="../../controller/mailer/mailer.php" method="POST">

                    <div class="inputBox">
                        <input name="email" id="email" type="text" required>
                        <span>Email</span>
                    </div>

                    <div class="inputBox">
                        <input name="sbj" id="sbj" type="test" required>
                        <span>Subject</span>
                    </div>

                    <div class="inputBox">
                        <textarea name="body" id="body" cols="60" rows="10"></textarea>
                        <span>Body</span>
                    </div>

                    <div class="inputBox">
                        <input name="alt" id="alt" type="duration" required>
                        <span>AltBody</span>
                    </div>

                    <button class="btn" type="submit" name="btn1" onclick="submitForm()">Send</button>
                    <button class="btn" type="reset" name="btn2">Cancel</button>
                </form>

            </div>
            <div class="col1" id="col1">
                <div class="open-mailer"><button class="btn" id="open-mailer-btn">Open mailer</button></div>

                <table class="content-table">
                    <thead>
                        <tr>
                            <th>Id</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Subject</th>
                            <th>Message</th>
                            <th>status</th>
                            <th>Modify</th>
                            <th>Delete</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($result1 as $row) { ?>
                            <tr>
                                <td>
                                    <?php echo $row['ID'] ?>
                                </td>
                                <td>
                                    <?php echo $row['NAME'] ?>
                                </td>
                                <td>
                                    <?php echo $row['EMAIL'] ?>
                                </td>
                                <td>
                                    <?php echo $row['SUBJECT'] ?>
                                </td>
                                <td>
                                    <?php echo $row['MESSAGE'] ?>
                                </td>
                                <td>
                                    <?php foreach ($result2 as $row1) {
                                        if ($row1["idrec"] == $row['ID']) {
                                            echo $row1['status'];
                                        }
                                    } ?>
                                </td>
                                <td>
                                    <form class="action-form" action="../../../model/Modify_rec.php" method="post">
                                        <button class="btn" type="submit">Modify</button>
                                        <input type="hidden" name="modify" value="<?php echo $row['ID'] ?>">
                                    </form>
                                </td>
                                <td>
                                    <form class="action-form" action="../../../model/delete_rec.php" method="post">
                                        <button class="btn" type="submit">Delete</button>
                                        <input type="hidden" name="delete" value="<?php echo $row['ID'] ?>">
                                    </form>
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
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

    <script src="https://cdnjs.cloudflare.com/ajax/libs/apexcharts/3.44.0/apexcharts.min.js"
        integrity="sha512-9ktqS1nS/L6/PPv4S4FdD2+guYGmKF+5DzxRKYkS/fV5gR0tXoDaLqqQ6V93NlTj6ITsanjwVWZ3xe6YkObIQQ=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="Slide.js"></script>
</body>

</html>