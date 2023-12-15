<?php

    require_once '../../../model/db_connect_front.php';
    require '../../../model/User_class.php' ; 
    try {
        $client = new user() ;
      
        $count_p = count($client->select_patient(-1)) ;
        $count_i = count($client->select_nurse(-1)) ; 
        header('home.php');
    } catch (PDOException $e) {
        echo "Connection failed: " . $e->getMessage();
    }

    setcookie("p_number",$count_p,0,'/') ; 
    setcookie("n_number",$count_i,0,'/') ;
   
    
?>


<!DOCTYPE html>
<html lang="en">
    
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Pannel</title>
    <link rel="stylesheet" href="home.css">
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
                <h2 style="color: #ffffff; font-size: 30px; margin: 20px 10px ;">DASHBOARD</h2>
            </div>

            <div class="col2">
                <h3 style="color: #ffffff;">PATIENTS <span class="material-symbols-outlined">group</span></h3>
                <h3 style="color: #ffffff; font-weight:bolder;" ><?php echo $count_p?></h3>
            </div>

            <div class="col3">
                <h3 style="color: #ffffff;">NURSES<span class="material-symbols-outlined">ecg_heart</span></h3>
                <h3 style="color: #ffffff; font-weight:bolder;" ><?php echo $count_i?></h3>
            </div>

            <div class="col4">
                <h3 style="color: #ffffff;">INCOME <span class="material-symbols-outlined">payments</span></h3>
                <h3 style="color: #ffffff; font-weight:bolder;" >20.765$</h3>
            </div>

            <div class="col5">
                <h3 style="color: #ffffff;">FEES <span class="material-symbols-outlined">sell</span></h3>
                <h3 style="color: #ffffff; font-weight:bolder;" >12.987$</h3>
            </div>
            
            <div class="col6">
                    <h2 class="chart-title">Average of CLients</h2>
                   
                        <div id="bar-chart"></div> 
                
            </div>

            <div class="col7">
                    <h2 class="chart-title">Income</h2>
                    <div id="area-chart"></div>
            </div>
            
        </main> 

        <section class="sidebar">
             
                <div class="logo">
                    <a href="home.php" ><span class="material-symbols-outlined">
                        admin_panel_settings
                        </span>Admin</a>
                </div>
                
                <ul class="nav-bar">
                    
                    <li class="active">
                        <a href="home.php">
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
                    <div class= "logout">
                        <li>
                            <a href="../Login/login.php" onclick="removeFromHistory() ">
                            <span class="material-symbols-outlined">logout</span>Logout</a>                                            
                         </li>
                         
                    </div>

                </ul>
        </section>
         
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/apexcharts/3.44.0/apexcharts.min.js" ></script>
    <script src="charts.js"></script>
</body>
</html>