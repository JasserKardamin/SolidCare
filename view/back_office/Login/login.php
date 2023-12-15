<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="login.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200">
    <script src="login.js"></script>
</head>
<body>

<?php
include '../../../model/db_connect_front.php' ; 

if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $cin = $_POST['cin'];
        $pass = $_POST['password'];

        try {
            $query = $pdo->prepare('SELECT * FROM admin WHERE cin = :cin');
            $query->bindParam(':cin', $cin); 
            $query->execute();
        
            if ($query->rowCount() > 0) {
                $result = $query->fetch(PDO::FETCH_ASSOC);
                if ($pass == $result['password']) {
                    header('location:../Home/home.php');
                }
            }
        } catch (PDOException $e) {
            echo "Connection failed: " . $e->getMessage();
            }
    }
?>

    <div class="container">

        <div class="title">
            <h3>Admin Login</h3>
            <span class="material-symbols-outlined">shield_person</span>
        </div>

        <form class="offer-form" action="" method="POST">
            <div class="inputBox">
                <input  id ="cin" name ="cin" type="text">
                <span>CIN</span>
            </div>

            <div class="inputBox">
                <input id = "pass" name ="password" type="password" >
                <span>Password</span>
                <div class="showp">
                    <input type="checkbox" name ="chkbox" onclick = "show()" >
                    <p>Show password</p>
                </div>
            </div>
    
        <button class="btn" type="submit" name="btn1" onclick="verify()" >Log in</button>    
        <button class="btn" type="reset" name="btn2">Cancel</button>    
            
            <?php if($pass !=  $result['password'] && $query->rowCount() > 0): ?>
                <div class="err">
                    <span class="material-symbols-outlined">error</span>
                </div>
                <p>Password Incorrect *</p>

            <?php endif;?>

            <?php if($query->rowCount() == 0): ?>
                <div class="err">
                    <span class="material-symbols-outlined">error</span>
                </div>
                <p>User not found*</p>
            <?php endif;?>
        </form>
    </div>
   
</body>
</html>