<?php
 require("../../../model/display_nurse.php") ; 
 require '../../../model/sessions_start.php' ; 
 require '../../../model/db_connect_front.php' ;
    $gender = $_SESSION['gender'] ; 	
	$name = $_SESSION['name'] ; 	

	$cin = $_SESSION['cin'] ; 	

	$q = $pdo->prepare('SELECT * FROM user WHERE CIN = :c') ;
	$q->bindParam(':c',$cin) ;
	$q->execute() ; 
	$r = $q->fetch(PDO::FETCH_ASSOC) ;  

	if ($r['photo']) {
		$imageData = base64_encode($r['photo']);
		$src = 'data:image/jpeg;base64,' . $imageData;
	}
         

    ?>
<!doctype html>
<html class="no-js" lang="zxx">

<head>
    <!-- Meta Tags -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="keywords" content="Site keywords here">
    <meta name="description" content="">
    <meta name='copyright' content=''>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Title -->
    <title>Home page</title>

    <!-- Favicon -->
    <link rel="icon" href="img/favicon.png">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"
        integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!-- Google Fonts -->
    <link
        href="https://fonts.googleapis.com/css?family=Poppins:200i,300,300i,400,400i,500,500i,600,600i,700,700i,800,800i,900,900i&display=swap"
        rel="stylesheet">

        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <!-- Nice Select CSS -->
    <link rel="stylesheet" href="css/nice-select.css">
    <!-- Font Awesome CSS -->
    <link rel="stylesheet" href="css/font-awesome.min.css">
    <!-- icofont CSS -->
    <link rel="stylesheet" href="css/icofont.css">
    <!-- Slicknav -->
    <link rel="stylesheet" href="css/slicknav.min.css">
    <!-- Owl Carousel CSS -->
    <link rel="stylesheet" href="css/owl-carousel.css">
    <!-- Datepicker CSS -->
    <link rel="stylesheet" href="css/datepicker.css">
    <!-- Animate CSS -->
    <link rel="stylesheet" href="css/animate.min.css">
    <!-- Magnific Popup CSS -->
    <link rel="stylesheet" href="css/magnific-popup.css">

    <!-- Medipro CSS -->
    <link rel="stylesheet" href="css/normalize.css">
    <link rel="stylesheet" href="ShowNurse.css">
    <link rel="stylesheet" href="css/responsive.css">

</head>

<body>
    <!-- Header Area -->
    <header class="header">
        <div class="header-inner">
            <div class="container">
                <div class="inner">
                    <div class="row">
                        <div class="col-lg-3 col-md-3 col-12">
                            <!-- Start Logo -->
                            <div class="logo">
                                <a href="../homepages/patient/patient.php"><img src="img/logo.png" alt="#"></a>
                            </div>
                            <!-- End Logo -->
                            <!-- Mobile Nav -->
                            <div class="mobile-nav"></div>
                            <!-- End Mobile Nav -->
                        </div>
                        <div class="col-lg-7 col-md-9 col-12">
                            <!-- Main Menu -->
                            <div class="main-menu">
									<nav class="navigation">
										<ul class="nav menu">
											<li><a href="../homepages/patient/patient.php">Home</a></li>
											<li><a href="../rdv/MainPatientRdv.php">request list</a></li>
											<li><a href="../plans/patient_price/plans.php">plans</a></li>
											<li><a href="../rdv/MainPatientRdv.php">appointment list</a></li>
                                            <li><a style="padding: 25px 0 25px 0 ;" href="../treatment/Patient/treatmentP.php">Treatments</a></li>
											<li><a href="../homepages/patient/Contact.php">Contact</a></li>
										</ul>
									</nav>
								</div>
                            <!--/ End Main Menu -->
                        </div>
                        <div class="col-lg-2 col-12">
                            <div class="get-quote">
                                    <a href="../profile/profile/general.php" class = "space">
                                        <?php if ($r['photo'] == NULL) {?>
												<img  src="./pdp.png" alt="">
										<?php } else {?>	
												<img  src="<?php echo $src ?>" alt="loading...">
										<?php }?>
									</a>	
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--/ End Header Inner -->
    </header>
    <div class="RDVS">

        <div class="box">
            <div class="search">
                <div class="title">
                    <h1 class='check'>find a</h1>
                    <span class="findd">Nurse</span>
                </div>
                <div class="search_bars">

                    <div class="location">
                        <input type="text" class="form-control" id="name" placeholder="Search with location"
                            onkeyup="filterTable()"><br>
                            <span class="material-symbols-outlined">distance</span>
                    </div>

                    <div class="speciality">
                        <input type="text" class="form-control" id="speciality" placeholder="Search with speciality"
                            onkeyup="filterTable()">
                            <span class="material-symbols-outlined">stars</span>
                    </div>
                </div>
            </div>

            <?php
          
            $new_nurse = new nurse();
            $final_list = $new_nurse->read_NRS($pdo);
            ?>
            <div class="stable">
            <table class="RdvTable" id="myTable">
                <thead>
                    <tr>
                        <th>LAST NAME</th>
                        <th>FIRST NAME</th>
                        <th>PHONE</th>
                        <th>LOCATION</th>
                        <th>GENDER</th>
                        <th>SPECIALITY</th>
                        <th>ACTION</th>

                    </tr>
                </thead>
                <?php
                foreach ($final_list as $nrs) {
                    ?>
                    <div class="container">
                        <div class="box-container">
                            <div class="box">
                                <tbody>
                                    <tr>
                                        <td>
                                            <?= $nrs['lastname']; ?>
                                        </td>
                                        <td>
                                            <?= $nrs['firstname']; ?>
                                        </td>
                                        <td>
                                            <?= $nrs['phone']; ?>
                                        </td>
                                        <td>
                                            <?= $nrs['location']; ?>
                                        </td>
                                        <td>
                                            <?= $nrs['gender']; ?>
                                        </td>
                                        <td>
                                            <?= $nrs['domain_of_work']; ?>
                                        </td>
                                        <td style='padding: 0px;'>
                                            <form action="contact_nurse_main.php" method="post">
                                                <input type="hidden" name="cin" value="<?php echo $nrs['CIN']; ?>">
                                                <button class="contact_button">
                                                    <p class="text">Contact</p>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                </tbody>
                            </div>
                        </div>
                    </div>
                    <?php
                }
                ?>
                </table>
            </div>
        </div>
    </div>
    <!-- Footer Area -->
    <footer id="footer" class="footer ">
        <!-- Footer Top -->
        <div class="footer-top">
            <div class="container">
                <div class="row">
                    <div class="col-lg-3 col-md-6 col-12">
                        <div class="single-footer">
                            <h2>About Us</h2>
                            <p>Lorem ipsum dolor sit am consectetur adipisicing elit do eiusmod tempor incididunt ut
                                labore dolore magna.</p>
                            <!-- Social -->
                            <ul class="social">
                                <li><a href="#"><i class="icofont-facebook"></i></a></li>
                                <li><a href="#"><i class="icofont-google-plus"></i></a></li>
                                <li><a href="#"><i class="icofont-twitter"></i></a></li>
                                <li><a href="#"><i class="icofont-vimeo"></i></a></li>
                                <li><a href="#"><i class="icofont-pinterest"></i></a></li>
                            </ul>
                            <!-- End Social -->
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 col-12">
                        <div class="single-footer f-link">
                            <h2>Quick Links</h2>
                            <div class="row">
                                <div class="col-lg-6 col-md-6 col-12">
                                    <ul>
                                        <li><a href="#"><i class="fa fa-caret-right" aria-hidden="true"></i>Home</a>
                                        </li>
                                        <li><a href="#"><i class="fa fa-caret-right" aria-hidden="true"></i>About
                                                Us</a>
                                        </li>
                                        <li><a href="#"><i class="fa fa-caret-right" aria-hidden="true"></i>Services</a>
                                        </li>
                                        <li><a href="#"><i class="fa fa-caret-right" aria-hidden="true"></i>Our
                                                Cases</a></li>
                                        <li><a href="#"><i class="fa fa-caret-right" aria-hidden="true"></i>Other
                                                Links</a></li>
                                    </ul>
                                </div>
                                <div class="col-lg-6 col-md-6 col-12">
                                    <ul>
                                        <li><a href="#"><i class="fa fa-caret-right"
                                                    aria-hidden="true"></i>Consuling</a></li>
                                        <li><a href="#"><i class="fa fa-caret-right" aria-hidden="true"></i>Finance</a>
                                        </li>
                                        <li><a href="#"><i class="fa fa-caret-right"
                                                    aria-hidden="true"></i>Testimonials</a></li>
                                        <li><a href="#"><i class="fa fa-caret-right" aria-hidden="true"></i>FAQ</a>
                                        </li>
                                        <li><a href="#"><i class="fa fa-caret-right" aria-hidden="true"></i>Contact
                                                Us</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 col-12">
                        <div class="single-footer">
                            <h2>Open Hours</h2>
                            <p>Lorem ipsum dolor sit ame consectetur adipisicing elit do eiusmod tempor incididunt.
                            </p>
                            <ul class="time-sidual">
                                <li class="day">Monday - Fridayp <span>8.00-20.00</span></li>
                                <li class="day">Saturday <span>9.00-18.30</span></li>
                                <li class="day">Monday - Thusday <span>9.00-15.00</span></li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 col-12">
                        <div class="single-footer">
                            <h2>Newsletter</h2>
                            <p>subscribe to our newsletter to get allour news in your inbox.. Lorem ipsum dolor sit
                                amet, consectetur adipisicing elit,</p>
                            <form action="mail/mail.php" method="get" target="_blank" class="newsletter-inner">
                                <input name="email" placeholder="Email Address" class="common-input"
                                    onfocus="this.placeholder = ''" onblur="this.placeholder = 'Your email address'"
                                    required="" type="email">
                                <button class="button"><i class="icofont icofont-paper-plane"></i></button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--/ End Footer Top -->
        <!-- Copyright -->
        <div class="copyright">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-12">
                        <div class="copyright-content">
                            <p>© Copyright 2018 | All Rights Reserved by <a href="https://www.wpthemesgrid.com"
                                    target="_blank">wpthemesgrid.com</a> </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--/ End Copyright -->
    </footer>
    <!--/ End Footer Area -->

    <!-- jquery Min JS -->
    <script src="js/jquery.min.js"></script>
    <!-- jquery Migrate JS -->
    <script src="js/jquery-migrate-3.0.0.js"></script>
    <!-- jquery Ui JS -->
    <script src="js/jquery-ui.min.js"></script>
    <!-- Easing JS -->
    <script src="js/easing.js"></script>
    <!-- Color JS -->
    <script src="js/colors.js"></script>
    <!-- Popper JS -->
    <script src="js/popper.min.js"></script>
    <!-- Bootstrap Datepicker JS -->
    <script src="js/bootstrap-datepicker.js"></script>
    <!-- Jquery Nav JS -->
    <script src="js/jquery.nav.js"></script>
    <!-- Slicknav JS -->
    <script src="js/slicknav.min.js"></script>
    <!-- ScrollUp JS -->
    <script src="js/jquery.scrollUp.min.js"></script>
    <!-- Niceselect JS -->
    <script src="js/niceselect.js"></script>
    <!-- Tilt Jquery JS -->
    <script src="js/tilt.jquery.min.js"></script>
    <!-- Owl Carousel JS -->
    <script src="js/owl-carousel.js"></script>
    <!-- counterup JS -->
    <script src="js/jquery.counterup.min.js"></script>
    <!-- Steller JS -->
    <script src="js/steller.js"></script>
    <!-- Wow JS -->
    <script src="js/wow.min.js"></script>
    <!-- Magnific Popup JS -->
    <script src="js/jquery.magnific-popup.min.js"></script>
    <!-- Counter Up CDN JS -->
    <script src="http://cdnjs.cloudflare.com/ajax/libs/waypoints/2.0.3/waypoints.min.js"></script>
    <!-- Bootstrap JS -->
    <script src="js/bootstrap.min.js"></script>
    <!-- Main JS -->
    <script src="js/main.js"></script>
    <!-- <script src="../../Assets/js/Filter.js"></script> -->
    <script>
    function filterTable() {
    var nameInput, nameFilter, specialityInput, specialityFilter, table, tr, td, i, nameTxtValue, specialityTxtValue;
    
    nameInput = document.getElementById("name");
    nameFilter = nameInput.value.toUpperCase();
    
    specialityInput = document.getElementById("speciality");
    specialityFilter = specialityInput.value.toUpperCase();
    
    table = document.getElementById("myTable");
    tr = table.getElementsByTagName("tr");
    
    for (i = 0; i < tr.length; i++) {
        tdName = tr[i].getElementsByTagName("td")[3];
        tdSpeciality = tr[i].getElementsByTagName("td")[5];
        
        if (tdName && tdSpeciality) {
            nameTxtValue = tdName.textContent || tdName.innerText;
            specialityTxtValue = tdSpeciality.textContent || tdSpeciality.innerText;

            if (nameTxtValue.toUpperCase().indexOf(nameFilter) > -1 && specialityTxtValue.toUpperCase().indexOf(specialityFilter) > -1) {
                tr[i].style.display = "";
            } else {
                tr[i].style.display = "none";
            }
        }
    }
}

    </script>
</body>

</html>