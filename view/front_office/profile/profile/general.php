<?php
	require '../../../../model/sessions_start.php' ; 
	require '../../../../model/db_connect_front.php' ;  

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
		
		<!-- Google Fonts -->
		<link href="https://fonts.googleapis.com/css?family=Poppins:200i,300,300i,400,400i,500,500i,600,600i,700,700i,800,800i,900,900i&display=swap" rel="stylesheet">

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
        <link rel="stylesheet" href="style.css">
        <link rel="stylesheet" href="css/responsive.css">
		<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
		<script src="chatbot.js" defer></script>
    </head>
    <body>
		<!-- Header Area -->
		<header class="header" >
			<div class="header-inner">
				<div class="container">
					<div class="inner">
						<div class="row">
							<div class="col-lg-3 col-md-3 col-12">
								<!-- Start Logo -->
								<div class="logo">
									<?php if ($r['typee'] == "patient") {?>
										<a href="../../homepages/patient/patient.php"><img src="img/logo.png" alt="#"></a>
									<?php } else {?>
										<a href="../../homepages/nurse/nurse.php"><img src="img/logo.png" alt="#"></a>
										<?php } ?>
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
												<?php if ($r['typee'] == "patient") {?>
													<li><a href="../../homepages/patient/patient.php">Home</a></li>
													<li><a href="../../Demand/MainPatientDmd.php">Request List</a></li>
													<li><a href="../../plans/patient_price/plans.php">plans</a></li>
													<li><a  style="padding: 25px 0 25px 0 ;" href="../../rdv/MainPatientRdv.php">appointment list</a></li>
													<li><a href="../../treatment/Patient/treatmentP.php">Treatments</a></li>
													<li><a href="../../homepages/patient/Contact.php">Contact</a></li>
												<?php } else {?>
													<li><a href="../../homepages/nurse/nurse.php">Home</a></li>
													<li><a href="../../Demand/MainNurseDmd.php">request list</a></li>
													<li><a href="../../rdv/MainNurseRdv.php">appointment list</a></li>
													<li><a href="../../treatment/Nurse/treatmentI.php">Treatments</a></li>
													<li><a href="../../homepages/nurse/Contact.php">Contact Us</a></li>
													<?php } ?>
											
										</ul>
									</nav>
								</div>
							</div>
						</div>	
					</div>				
				</div>		
			</div>
		</header>

		<div class="profile_container">
			<div class="profile">
				<div class="navb">
					<div class="param">
						<h1>Profile</h1>
						<div class="activee">
							<span class="material-symbols-outlined">settings</span>
							<a href="general.php">General</a>
						</div>
						<div class="set">
							<span class="material-symbols-outlined">security</span>
							<a href="../privacy/privacy.php">Privacy</a>
						</div>
						<div class="logout">
							<span class="material-symbols-outlined">logout</span>
							<a href="../../user/login.html">Logout</a>
						</div>
					</div>
				</div>
				<div class="main">
					<?php if ($r['photo'] == NULL) {?>
						<div class="imagedeprof">	
							<img  src="pdp.png" alt="">
						</div>
					<?php } else {?>	
						<div class="imagedeprof">
							<img  src="<?php echo $src ?>" alt="loading...">
						</div>
					<?php }?>
	
					<form action="../../../../controller/front_office/modify_genearle.php" class="form4" method='post' enctype="multipart/form-data">
						<div class="imggg">
							<input name = "imagee" class="imageee" type="file">
						</div>
						<div class="underf">
							<div class="lwala">
								<div class="ttt">
									<span>First Name </span>
									<input name ="fname" type="text" placeholder="<?php echo htmlspecialchars($r['firstname']); ?>">
								</div>
								<div class="ttt">
									<span>Last Name</span>
									<input name ="lname"  type="text" placeholder="<?php echo htmlspecialchars($r['lastname']); ?>"">
								</div>
								<div class="ttt">
									<span>Phone</span>
									<input type="text" name ="phone"  placeholder="<?php echo htmlspecialchars($r['phone']); ?>">
								</div>
							</div>
							
							<div class="lorin">
								<div class="ttt">
									<span>Description</span>
									<textarea  id="" name="desc" cols="30" rows="3" placeholder="Enter descritpion"></textarea>
								</div>
								<div class="ttt">
									<span>Location</span>
									<input type="text" name ="loc" placeholder="<?php echo htmlspecialchars($r['location']); ?>">
								</div>
								<div class="ttt">
									<span>Date</span>
									<input type="date" name ="date" >
								</div>
							</div>
							<button>Modify</button>
							</div>
					</form>

				</div>
			</div>
		</div>

		<footer id="footer" class="footer ">
			<!-- Footer Top -->
			<div class="footer-top">
				<div class="container">
					<div class="row">
						<div class="col-lg-3 col-md-6 col-12">
							<div class="single-footer">
								<h2>About Us</h2>
								<p>where compassionate care meets excellence in healthcare. We are dedicated to providing a platform that celebrates the noble profession of nursing and serves as a valuable resource for both healthcare professionals and those seeking reliable health information.</p>
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
											<li><a href="#"><i class="fa fa-caret-right" aria-hidden="true"></i>Home</a></li>
											<li><a href="#"><i class="fa fa-caret-right" aria-hidden="true"></i>About Us</a></li>
											<li><a href="#"><i class="fa fa-caret-right" aria-hidden="true"></i>Services</a></li>
											<li><a href="#"><i class="fa fa-caret-right" aria-hidden="true"></i>Our Cases</a></li>
											<li><a href="#"><i class="fa fa-caret-right" aria-hidden="true"></i>Other Links</a></li>	
										</ul>
									</div>
									<div class="col-lg-6 col-md-6 col-12">
										<ul>
											<li><a href="#"><i class="fa fa-caret-right" aria-hidden="true"></i>Consuling</a></li>
											<li><a href="#"><i class="fa fa-caret-right" aria-hidden="true"></i>Finance</a></li>
											<li><a href="#"><i class="fa fa-caret-right" aria-hidden="true"></i>Testimonials</a></li>
											<li><a href="#"><i class="fa fa-caret-right" aria-hidden="true"></i>FAQ</a></li>
											<li><a href="#"><i class="fa fa-caret-right" aria-hidden="true"></i>Contact Us</a></li>	
										</ul>
									</div>
								</div>
							</div>
						</div>
						<div class="col-lg-3 col-md-6 col-12">
							<div class="single-footer">
								<h2>Open Hours</h2>
								<p>Lorem ipsum dolor sit ame consectetur adipisicing elit do eiusmod tempor incididunt.</p>
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
								<p>subscribe to our newsletter to get allour news in your inbox.. Lorem ipsum dolor sit amet, consectetur adipisicing elit,</p>
								<form action="mail/mail.php" method="get" target="_blank" class="newsletter-inner">
									<input name="email" placeholder="Email Address" class="common-input" onfocus="this.placeholder = ''"
										onblur="this.placeholder = 'Your email address'" required="" type="email">
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
								<p>© Copyright 2018  |  All Rights Reserved by <a href="https://www.wpthemesgrid.com" target="_blank">wpthemesgrid.com</a> </p>
							</div>
						</div>
					</div>
				</div>
			</div>
			<!--/ End Copyright -->
		</footer>



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
    </body>
</html>