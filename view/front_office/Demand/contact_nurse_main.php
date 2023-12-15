<?php
require_once '../../../model/createdmd.php';
require '../../../model/sessions_start.php' ; 

// setcookie("cin", $cinValue, 0, "../");
// with session
$cinValue = $_POST['cin'];
$CIN_patient = $_SESSION['cin'];

$_SESSION['cin_nurse'] = $cinValue ; 
//-----------------
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="Demand.css">
    <title>Document</title>
</head>

<body>
    <script>
        function verify() {
            var input = document.getElementById('dateInput').value;
            var selectedDate = new Date(input);
            var currentDate = new Date();
            if (selectedDate < currentDate) {
                alert('Invalid date');
            }
        }
    </script>
    <div class="registration">
        <form class="form" action="../../../model/handle.php" method="post">
            <p class="title">Appointments</p>
            <p class="message">book an appointement</p>
            <label>
                <input required placeholder="" type="date" id="dateInput" class="input" name="dt">
                <span></span>
            </label>

            <label>
                <input required placeholder="" type="text" class="input" name="in">
                <span>infos</span>
            </label>

            <button class="submit" type="submit" onclick="verify()">register</button>
            <button class="submit" type="reset">Reset</button>
        </form>
    </div>
</body>

</html>