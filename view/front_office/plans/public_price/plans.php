<?php

require '../../../../model/db_connect_front.php';

try {
	$query1 = $pdo->prepare('SELECT * FROM plans ORDER BY name  LIMIT 1 ');
    $query2 = $pdo->prepare('SELECT * FROM plans  ORDER BY name  LIMIT 1 OFFSET 1 ');
    $query3 = $pdo->prepare('SELECT * FROM plans  LIMIT 1 OFFSET 2') ;
  
    $query1->execute();
    $query2->execute();
    $query3->execute();

    $result1= $query1->fetch(PDO::FETCH_ASSOC);
    $result2= $query2->fetch(PDO::FETCH_ASSOC);
    $result3= $query3->fetch(PDO::FETCH_ASSOC);

	function get_discount($name)
	{
		require '../../../../model/db_connect_front.php';
		$q = $pdo->prepare('SELECT * FROM  discounts WHERE name = :n');
		$q->bindParam(':n', $name);
		$q->execute(); // Execute the query after binding the parameter
		return $q->fetch(PDO::FETCH_ASSOC);
	}
	$r1 = get_discount($result1['name']);
	$r2 = get_discount($result2['name']);
	$r3 = get_discount($result3['name']);
	
	if($r1['old_price'] != NULL) {
		$old_p1 = $r1['old_price'].'$' ; 
	}

	if($r2['old_price'] != NULL) {
		$old_p2 = $r2['old_price'].'$' ; 
	}

	if($r3['old_price'] != NULL) {
		$old_p3 = $r3['old_price'].'$' ; 
	}


} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
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
									<a href="../../homepages/public/index.php"><img src="img/logo.png" alt="loading..."></a>
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
											<li><a href="../../homepages/public/index.php">Home </a></li>
											<li class="active" ><a href="../../plans/patient_price/plans.php">plans</a></li>
											<li><a href="../../homepages/public/Contact.php">Contact Us</a></li>
										</ul>
									</nav>
								</div>
								<!--/ End Main Menu -->
							</div>
							<div class="col-lg-2 col-12">
								<div class="get-quote">
									<a href="../../user/login.html" class="btn">Sign in </a>
									<a href="../../user/signup.html" class="btn">Sign up</a>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</header>
		<!-- End Header Area -->
	

		<div class="tt">
			<h1>Available plans</h1>
		</div>
		<div class="pricing-cards" id = "pricing-cards" >
			<div class="card">
				<h1 class="name"><?php  echo $result2['name'] ?></h1>
				
				<p  class="visible_price"><?php echo $old_p2?></p>
	
				<h1 class="price"><?php  echo $result2['price'] ?>$</h1>
	
				<div class="discount2" data-ending="<?php echo $r2['ending'];?>"></div>
	
				<div class="desc-space">
					<p class="description"><?php  echo $result2['description'] ?></p>
				</div>
				<form action="../../user/signup.html" method = "post">
					<button class="cbtn" name = "btn2">Choose Plan</button>
				</form>
			</div>
			<div class="scard">
				<div class="best-seller">
					<h1 class="sname"><?php echo $result1['name']?></h1>
					<p class="adj">best seller</p>
				</div>
	
				<p class="s_visible_price"><?php echo $old_p1?></p>
	
				<h1 class="sprice"><?php echo $result1['price']?>$</h1>
	
				<div class="discount1" data-ending="<?php echo $r1['ending'];?>"></div>
	
				<div class="desc-special">
					<p class="sdescription"><?php echo $result1['description']?></p>
				</div>
				<form action="../../user/signup.html" method = "post">
					<button class="sbtn" name = "btn1">Choose Plan</button>
				</form>
			</div>
			<div class="card">
				<h1 class="name"><?php echo $result3['name']?></h1>
	
				<p class="visible_price"><?php echo $old_p3?></p>
	
				<h1 class="price"><?php echo $result3['price']?>$</h1>

				<div class="discount3" data-ending="<?php echo $r3['ending'];?>"></div>

				<div class="desc-space">
					<p class="description"><?php echo $result3['description']?></p>
				</div>
				<form action="../../user/signup.html" method = "post">
					<button class="cbtn" name = "btn3">Choose Plan</button>
				</form>
			</div>
		</div>
	
		<script>				
			//supper complexe algorithm :
			var paragraphs = document.querySelectorAll('p');
			
			function callPhpFunction() {
				var xhr = new XMLHttpRequest();
				xhr.open("GET", "../../../controller/delete_discount.php", true);
				xhr.onreadystatechange = function() {
					if (xhr.readyState == 4 && xhr.status == 200) {
						console.log('PHP function called successfully');
					}
				};
					xhr.send();
        	}
			
			function updateCountdown(element) {   
				var endTime = new Date(element.getAttribute('data-ending'));
				var now = Math.floor(Date.now() / 1000);
				var remainingTime = endTime.getTime() / 1000 - now;

				if (remainingTime >= 0) {
					var days = Math.floor(remainingTime / (24 * 60 * 60));
					var hours = Math.floor((remainingTime % (24 * 60 * 60)) / (60 * 60));
					var minutes = Math.floor((remainingTime % (60 * 60)) / 60);
					var seconds = remainingTime % 60;

					element.innerHTML =
						days + 'd ' + hours + 'h ' + minutes + 'm ' + seconds + 's';
				
					setTimeout(function () {
						updateCountdown(element);
					}, 1000); 
				} 
				else {
					callPhpFunction();
				}
			}

			var discountElements1 = document.querySelectorAll('.discount1');
			var discountElements2 = document.querySelectorAll('.discount2');
			var discountElements3 = document.querySelectorAll('.discount3');

			discountElements1.forEach(function (element) {
				updateCountdown(element);
			});

			discountElements2.forEach(function (element) {
				updateCountdown(element);
			});

			discountElements3.forEach(function (element) {
				updateCountdown(element);
			});

			//end  

		</script>

		<!-- Footer Area -->
		<footer id="footer" class="footer ">
			<div class="footer-top">
				<div class="container">
					<div class="row">
						<div class="col-lg-3 col-md-6 col-12">
							<div class="single-footer">
								<h2>About Us</h2>
								<p>Lorem ipsum dolor sit am consectetur adipisicing elit do eiusmod tempor incididunt ut labore dolore magna.</p>
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

