<?php
require_once '../../../model/db_connect_front.php';
require '../../../model/money_class.php' ; 

try {
   
    $query = $pdo->prepare('SELECT * FROM sbscriptions');
    $query->execute();
    
    $query1 = $pdo->prepare('SELECT CIN FROM user') ; 
    $query1->execute() ; 
 
    $query2 = $pdo->prepare('SELECT name FROM plans') ; 
    $query2->execute() ; 
     
    //7awem f tableau
    $result0= $query->fetchAll(PDO::FETCH_ASSOC);
    $result1=$query1->fetchAll(PDO::FETCH_ASSOC);
    $result2=$query2->fetchAll(PDO::FETCH_ASSOC);
    
   

} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}


// refresh 


try {
    // Retrieve plans
    $money = new subs() ; 
    
    $plan1 = $pdo->query('SELECT name FROM plans ORDER BY name LIMIT 1')->fetchColumn();
    $plan2 = $pdo->query('SELECT name FROM plans ORDER BY name LIMIT 1 OFFSET 1')->fetchColumn();
    $plan3 = $pdo->query('SELECT name FROM plans LIMIT 1 OFFSET 2')->fetchColumn();

    // Get information for each plan

    $rst1 = $money->count_subs($plan1) ; 

    $rst2 = $money->count_subs($plan2) ; 

    $rst3 = $money->count_subs($plan3) ; 

    setcookie('plan1_name', $rst1['name'],0, '/');
    setcookie('plan1_subscription_count', $rst1['subscription_count'],0, '/');

    setcookie('plan2_name', $rst2['name'],0, '/');
    setcookie('plan2_subscription_count', $rst2['subscription_count'],0, '/');

    setcookie('plan3_name', $rst3['name'],0, '/');
    setcookie('plan3_subscription_count', $rst3['subscription_count'],0, '/');

    
} catch (PDOException $e) {
    echo 'Error: ' . $e->getMessage();
}

// dsiplay infos : 

try {   

    $id = $_POST['row_name'];
    $q1 = $pdo->prepare('SELECT * FROM  sbscriptions WHERE id_subscription = :id '); 
    $q1->bindParam(':id',$id);  
    $q1->execute(); 
    $r1 = $q1->fetchAll(PDO::FETCH_ASSOC);


}catch(PDOException $e){
    echo "error ".$e->getMessage() ;  
}

setcookie("idd",$_POST['searchValue'],0,'./') ; 

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="sales.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200">
</head>
<body>
    <div class="grid-container">
        <header class="header">
            <span class="material-symbols-outlined" style="font-size: 37px;">search</span>
            <div class="mail">
               <a href="../mail/mailing.php"><span class="material-symbols-outlined" style="font-size: 37px;" >mail</span></a>
            </div>
        
        </header>
        <main class="main">

            <div  class="col3">
                    <div class="inputBox">
                            <input id = "searchValue" name ="query" type="text">
                        <h2>Sales</h2>
                        <span class="material-symbols-outlined">data_loss_prevention</span>
                        <button  id = "btnsrch" class="seachbtn"  onclick="search()">Search</button>
                    </div>
                    <div class="card">
                        <input id="ch" type="checkbox">
                         <div class="content">
                            <div class="user">
                                <div class="a5iran">
                                    <p  class  = "name-client" >Name : </p>
                                    <p id = "name"></p>
                                </div>
                                <div class="a5iran">
                                    <p  class  = "name-client" >Surname : </p>
                                    <p id = "surname"></p>
                                </div>
                                <div class="a5iran">
                                    <p  class  = "name-client" >Email : </p>   
                                    <p id ="email"></p>  
                                </div>
                                <div class="a5iran">
                                    <p  class  = "name-client" >Phone : </p>   
                                    <p id ="phone"></p>  
                                </div>
                            </div>

                            <div class="offer">
                                <div class="a5iran">
                                    <p  class  = "name-client">price :  </p>
                                    <p id = "price"></p>
                                    <p id="pp" >$</p>
                                </div>
                                <div class="a5iran">
                                    <p  class  = "name-client">duration :  </p>
                                    <p id = "dur"></p>
                                    <p id = "days">days</p>
                                </div>
                            </div>

                            <label for="ch">Show Less <span class="material-symbols-outlined">keyboard_double_arrow_up</span></label>
                        </div>
                        <label for="ch">Show More<span class="material-symbols-outlined">keyboard_double_arrow_down</span></label>

                        <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
                        <script src="search.js"></script>
                    </div>
            </div>
          
            <div class="col1" >
                <div class="plans" id = "scroll" >
                        <h1 class="title">Sales</h1>
                        <table id = "myTable" class="content-table">
                        <thead>
                            <tr>
                                <th>id</th>
                                <th>customer</th>
                                <th>plan</th>
                                <th>Delete</th>
                                <th>Modify</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($result0 as $row) { ?>
                                <tr>
                                    <td id = "id" ><?php echo $row['id_subscription']; ?></td>
                                    <td><?php echo $row['cin_user']; ?></td>
                                    <td><?php echo $row['offre_name'];?></td>
                                    <td>
                                        <form action="../../../controller/back_office/sales/delete/delete_sales.php" method ='post'>
                                            <input type="hidden" name="row_name" value="<?php echo $row['id_subscription']; ?>">
                                            <button class="btn" type="submit" name="btn1">Delete</button>
                                        </form>    
                                    </td>
                                    <td>
                                        <form action="../../../controller/back_office/sales/modify/modify_sale.php" method ='post'>
                                            <input type="hidden" name="id" value="<?php echo $row['id_subscription'];?>">
                                            <input type="hidden" name="cin" value="<?php echo $row['cin_user'] ?>">
                                            
                                            <select id="names" name="names-s">
                                                <?php foreach ($result2 as $row1) {?>
                                                    <option value="<?php echo $row1['name']?>"><?php echo $row1['name']?></option>
                                                <?php }?>
                                            </select>
                                            <button class="btn" type="submit" name="btn1">Modify</button>
                                        </form>
                                    </td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>

                <div class="metier">
                    <div id="sales-chart"></div>
                </div>
            </div>
    </main> 

    <section class="sidebar">
            <div class="logo">
                <a href="../Home/home.php" ><span class="material-symbols-outlined">
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

                <li class = "active" >
                    <a href="sales.php">
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
                        <a href="../Login/login.php">
                        <span class="material-symbols-outlined">logout</span>Logout</a>                                                  
                        </li>
                </div>

            </ul>
    </section>
    </div>

   
    <script src="https://cdnjs.cloudflare.com/ajax/libs/apexcharts/3.44.0/apexcharts.min.js" ></script>
    <script src="sales.js"></script>

</body>
</html>
