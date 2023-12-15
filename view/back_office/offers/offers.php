<?php
require_once '../../../model/db_connect_front.php';
require '../../../model/money_class.php' ; 

$money = new plans() ; 

$result = $money->select_plans(-1);  


// new nedd reforming : 
$q = $pdo->prepare('SELECT * FROM discounts') ; 
$q->execute() ; 
$result1 = $q->fetchAll(PDO::FETCH_ASSOC) ;   

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="offers.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200">
</head>
<body>
    <div class="grid-container">
        <header class="header">
            <span class="material-symbols-outlined" style="font-size: 37px;">search</span>
            <div class="mail">
               <a href="../mail/mailing.php"><span class="material-symbols-outlined" style="font-size: 37px;" >mail</span></a>
               <script src="offers.js"></script>
            </div>
        
        </header>
        <main class="main">
            <div class="col1">
                <div class = "metier">

                    <div class="table">
                        <table class="content-table">
                            <thead>
                                <tr>
                                    <th>name</th>
                                    <th>discount</th>
                                    <th>Duration</th>
                                    <th>action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach($result1 as $row) {?>
                                <tr>
                                    <td><?php echo $row['name']?></td>
                                    <td><?php echo $row['discount']?>%</td>
                                    <td><?php echo $row['ending']?></td>
                                    <td>
                                        <form class="offer-form" action="../../../controller/back_office/discount/delete_discount.php" method="POST">
                                            <input type="hidden" name="price" value="<?php echo $row['old_price'] ?>">  
                                            <input type="hidden" name="name" value="<?php echo $row['name'] ?>">  
                                            <input type="hidden" name="id" value="<?php echo $row['id'] ?>">
                                            <input type="hidden" name="ending" value="<?php echo $row['ending'] ?>">
                                            <button class="btn" type="submit" name="btn1"><span class="material-symbols-outlined">cancel</span></button>
                                        </form>
                                    </td>
                                <tr>
                                <?php }?>
                            </tbody>
                        </table>
                        
                    </div>

                    <div class="discount">
                        <h1>Set a Discount</h1>
                    <form class="offer-form" action="../../../controller/back_office/discount/discount.php" method="POST">

                            <div class="inputBox">
                                <input id= "name"  name ="name" type="text">
                                <span>Offer</span>
                            </div>

                            <div class="inputBox">
                                <input id= "offer-discount" name ="discount" type="test">
                                <span>Discount</span>
                            </div>

                            <div class="inputBox">
                                <input id= "discount-duration" name="duration" type="duration" >
                                <span>duration</span>
                            </div>

                            <button class="btn" type="submit" name="btn1" onclick = "verif()">Set</button>    
                            <button class="btn" type="reset" name="btn2" onclick = "verif()">cancle</button>    
                        
                        </form>
                    </div>
                </div>
                <div class="plans">
                        <h1 class="title">Plans</h1>
                        <table class="content-table">
                        <thead>
                            <tr>
                                <th>name</th>
                                <th>Price</th>
                                <th>Description</th>
                                <th>duration</th>
                                <th>action</th>

                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($result as $row) { ?>
                                <tr>
                                    <td><?php echo $row['name']; ?></td>
                                    <td><?php echo $row['price']; ?>$</td>
                                    <td><?php 
                                            if(strlen($row['description']) > 20 ) {
                                                echo substr($row['description'], 0,20).'...' ; 
                                                }   
                                            else {
                                                echo $row['description'];
                                            }
                                        ?>
                                    </td>
                                    <td><?php echo $row['duration'];?>days</td>
                                    <td>
                                        <form class ="offer-form1"  action="../../../controller/back_office/offers/delete_offrer.php" method ='post'>
                                            <input type="hidden" name="row_name" value="<?php echo $row['name']; ?>">
                                            <button class="btn" type="submit" name="btn1"><span class="material-symbols-outlined">delete</span></button>


                                        </form>    
                                    </td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
                <div class="metier">
                    
                </div>
            </div>

        <div class="col3">
                <h3>ADD / MODIFY OFFER<span class="material-symbols-outlined">add_business</span></h3>

                <form class="offer-form" action="../../../controller/back_office/offers/add_modify_offer.php" method="POST">

                    <div class="inputBox">
                        <input id= "name"  name ="name" type="text">
                        <span>Name</span>
                    </div>

                    <div class="inputBox">
                        <input id= "price" name ="price" type="test">
                        <span>Price</span>
                    </div>
            
            
                    <div class="inputBox">
                        <textarea id= "desc"  name="desc"  cols="30" rows="10"></textarea>
                        <span>Description</span>
                    </div>
                
                
                    <div class="inputBox">
                        <input id= "duration" name="duration" type="duration" >
                        <span>Duration</span>
                    </div>
                    
                <button class="btn" type="submit" name="btn1" onclick = "verif()">Add</button>    
                <button class="btn" type="submit" name="btn2" onclick = "verif()">Modify</button>    
                </form>
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

                <li class="active" >
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
                        <a href="../Login/login.php">
                        <span class="material-symbols-outlined">logout</span>Logout</a>                                                  
                        </li>
                </div>

            </ul>
    </section>
         
    </div>
</body>
</html>