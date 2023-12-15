<?php
require_once("../../../model/rdv.php");
require_once("../../../model/patient.php");
require_once("../../../model/calendar.php");
require '../../../model/sessions_start.php';
require '../../../model/db_connect_front.php' ; 

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
	<link rel="icon" href="homepages/public/img/favicon.png">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"
		integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA=="
		crossorigin="anonymous" referrerpolicy="no-referrer" />
	<!-- Google Fonts -->
	<link
		href="https://fonts.googleapis.com/css?family=Poppins:200i,300,300i,400,400i,500,500i,600,600i,700,700i,800,800i,900,900i&display=swap"
		rel="stylesheet">
	<!-- Bootstrap CSS -->
	<link rel="stylesheet" href="homepages/public/css/bootstrap.min.css">
	<!-- Nice Select CSS -->
	<link rel="stylesheet" href="homepages/public/css/nice-select.css">
	<!-- Font Awesome CSS -->
	<link rel="stylesheet" href="homepages/public/css/font-awesome.min.css">
	<!-- icofont CSS -->
	<link rel="stylesheet" href="homepages/public/css/icofont.css">
	<!-- Slicknav -->
	<link rel="stylesheet" href="homepages/public/css/slicknav.min.css">
	<!-- Owl Carousel CSS -->
	<link rel="stylesheet" href="homepages/public/css/owl-carousel.css">
	<!-- Datepicker CSS -->
	<link rel="stylesheet" href="homepages/public/css/datepicker.css">
	<!-- Animate CSS -->
	<link rel="stylesheet" href="homepages/public/css/animate.min.css">
	<!-- Magnific Popup CSS -->
	<link rel="stylesheet" href="homepages/public/css/magnific-popup.css">

	<!-- Medipro CSS -->
	<link rel="stylesheet" href="homepages/public/css/normalize.css">
	<link rel="stylesheet" href="homepages/public/style.css">
	<link rel="stylesheet" href="homepages/public/css/responsive.css">


	<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />

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
								<a href="../homepages/nurse/nurse.php"><img src="homepages/public/img/logo.png" alt="#"></a>
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
										<li><a href="../homepages/nurse/nurse.php">Home</a></li>
										<li><a href="../Demand/MainNurseDmd.php">request list</a></li>
										<li class="active" ><a href="../../rdv/MainNurseRdv.php">appointment list</a></li>
										<li><a href="../treatment/Nurse/treatmentI.php">Treatments</a></li>
										<li><a href="../homepages/nurse/Contact.php">Contact Us</a></li>
									</ul>
								</nav>
							</div>
							<!--/ End Main Menu -->
						</div>
						<div class="col-lg-2 col-12">
							<div class="get-quote">
									<a href="../profile/profile/general.php" class = "space" >
                                        <?php if ($r['photo'] == NULL) {?>
												<img  src="Profile-PNG-File.png" alt="">
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

	<!--rdvs -->
	<div class="RDVS">

		<?php
		$cinn = $_SESSION['cin'] ;
		//*************************************/
		$day = isset($_GET['day']) ? intval($_GET['day']) : date('j');
		$month = isset($_GET['month']) ? intval($_GET['month']) : date('n');
		$year = isset($_GET['year']) ? intval($_GET['year']) : date('Y');
		$new_rdv = new rdv();
		$new_patient = new patient();
		$rdvArray = array();
		$dateString = $_POST['selectedDate'];
		$searchValue = $_POST['searchValue'];
		$final_list = $new_rdv->read_RDV_nurse($cinn);
		foreach ($final_list as $rdv) {
			$rdvArray[] = $rdv['date'];
		}
	    $flag = 0 ; 
		if ($searchValue != NULL) {
			$final_list = $new_rdv->search_by_first_and_last_name_of_patient($searchValue,$cinn);
			if ($final_list == NULL) {
			$flag = 1 ; 
			}
		}

		if ($dateString != NULL) {

			$final_list = $new_rdv->read_all_RDV_by_date($dateString);
		}


		$calendar = new Calendar($day, $month, $year);
		echo "<div class='full_calendar'>";
		echo "<div class='CheckAndSearch'>";
		echo "<h1 class='check'>Check Your<br><span style='font-size: 80px;color:#04445c;'>Appointments</span></h1>";

		echo '
		<form class="search" action="' . htmlspecialchars($_SERVER["PHP_SELF"]) . '" method="post">
			<input placeholder="     &#128269  Search by First or Last Name" class="input-style" type="text" name="searchValue">
		</form>
	';
	    if($flag == 1){
			echo '
			<h3 style="font-size: 15px;">No users found!</h3>
			';
		}

		echo "</div>";
		$calendar->generateCalendar($rdvArray);
		echo '</div>';

		?>

		<div class="box">
			<table class="RdvTable">
				<thead>
					<tr>
						<th>PATIENT</th>
						<th>INFOS</th>
						<th>DATE</th>
						<th></th>
					</tr>
				</thead>
				<tbody>
					<?php
					foreach ($final_list as $rdv) {
						?>

						<tr>
							<td>
								<?php
								$cinp = $rdv['CIN_patient'];
								$final_list1 = $new_patient->read_PTT($cinp);
								foreach ($final_list1 as $ptt) {
									?>
									<table class="under_RdvTabl">
										<thead>
											<tr>
												<th>LAST NAME</th>
												<th>FIRST NAME</th>
												<th>LOCATION</th>
												<th>GENDER</th>

											</tr>
										</thead>
										<tbody>
											<tr>
												<td>
													<?php echo $ptt['lastname']; ?>
												</td>
												<td>
													<?php echo $ptt['firstname']; ?>
												</td>
												<td>
													<?php echo $ptt['location']; ?>
												</td>
												<td>
													<?php echo $ptt['gender']; ?>
												</td>
											</tr>
										</tbody>
									</table>
									<?php
								}
								?>
							</td>
							<td>
								<?= $rdv['infos']; ?>
							</td>
							<td>
								<?= $rdv['date']; ?>
							</td>
							<td style='padding: 0px;'>
								<form action="" method="post">
									<button class="contact_button">
										<p class="text">Contact</p>
									</button>
								</form>
							</td>
						</tr>
			</div>
			<?php
					}
					?>
		</tbody>
		</table>
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
										<li><a href="#"><i class="fa fa-caret-right" aria-hidden="true"></i>About Us</a>
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
										<li><a href="#"><i class="fa fa-caret-right" aria-hidden="true"></i>FAQ</a></li>
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
</body>

</html>