<?php 
	require '../../../../model/sessions_start.php' ; 
	require '../../../../model/db_connect_front.php' ;  

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
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="icon" href="img/favicon.png">
		
		<!-- Google Fonts -->
		<link href="https://fonts.googleapis.com/css?family=Poppins:200i,300,300i,400,400i,500,500i,600,600i,700,700i,800,800i,900,900i&display=swap" rel="stylesheet">

		<!-- Bootstrap CSS -->
		<link rel="stylesheet" href="../../homepages/nurse/css/bootstrap.min.css">
		<!-- Nice Select CSS -->
		<link rel="stylesheet" href="../../homepages/nurse/css/nice-select.css">
		<!-- Font Awesome CSS -->
        <link rel="stylesheet" href="../../homepages/nurse/css/font-awesome.min.css">
		<!-- icofont CSS -->
        <link rel="stylesheet" href="../../homepages/nurse/css/icofont.css">
		<!-- Slicknav -->
		<link rel="stylesheet" href="../../homepages/nurse/css/slicknav.min.css">
		<!-- Owl Carousel CSS -->
        <link rel="stylesheet" href="../../homepages/nurse/css/owl-carousel.css">
		<!-- Datepicker CSS -->
		<link rel="stylesheet" href="../../homepages/nurse/css/datepicker.css">
		<!-- Animate CSS -->
        <link rel="stylesheet" href="../../homepages/nurse/css/animate.min.css">
		<!-- Magnific Popup CSS -->
        <link rel="stylesheet" href="../../homepages/nurse/css/magnific-popup.css">
		
		<!-- Medipro CSS -->
        <link rel="stylesheet" href="../../homepages/nurse/css/normalize.css">
        <link rel="stylesheet" href="../../homepages/nurse/style.css">
        <link rel="stylesheet" href="../../homepages/nurse/css/responsive.css">
		<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
		<script src="chatbot.js" defer></script>

   <style>
    .RdvTable th {
	background-color:#1a76d1;
	border: 0px;
	color: white;
}
.RdvTable td {
	border: 0px;
	border-bottom: 1px solid #009bd6;
}
.RdvTable tr:nth-child(even) {
	background-color: #e7eaee;
}
.notification-item {
    padding: 20px;
    background-color: #2196F3;
    color: white;
    opacity: 0.83;
    transition: opacity 0.6s;
    margin-bottom: 15px;
    /* Add more styles as needed */
}

   </style>
    <title>Treatments</title>
</head>

<body>
<header class="header" >
			<div class="header-inner">
				<div class="container">
					<div class="inner">
						<div class="row">
							<div class="col-lg-3 col-md-3 col-12">
								<!-- Start Logo -->
								<div class="logo">
									<a href="../../homepages/nurse/nurse.php"><img src="../../homepages/patient/img/logo.png" alt="#"></a>
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
										<li ><a href="../../homepages/nurse/nurse.php">Home</a></li>
											<li><a href="../../Demand/MainNurseDmd.php">request list</a></li>
											<li><a href="../../rdv/MainNurseRdv.php">appointment list</a></li>
											<li class="active"><a href="#">Treatments</a></li>
											<li><a href="../../homepages/nurse/Contact.php">Contact Us</a></li>
										</ul>
									</nav>
								</div>
								<!--/ End Main Menu -->
							</div>
							<div class="col-lg-2 col-12">
								<div class="get-quote">
									
									<a href="../../profile/profile/general.php" class="space">
										<?php if ($r['photo'] == NULL) {?>
												<img  src="pdp.png" alt="">
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
        <div id="notifications-container">
         
        </div>
        <button style=" display: block;
  margin-left: auto;
  margin-right: 460px;" id="filterButton" class="btn btn-primary mt-3">
    Order by Date <span class="material-symbols-outlined">filter_alt</span>
</button>
    <div class="container mt-4">
        <h2>Treatment Records</h2>
        <table id="treatmentTable" class="table table-striped table-bordered table-hover RdvTable">
            <thead>
                <tr>
                   
                    <th>Date of Treatment</th>
                    <th>Type of Treatment</th>
                    <th> Patient</th>
                    <th> Nurse</th>
                    <th>Action</th>
                </tr>

            </thead>
            <tbody>

            <?php
// Include your PDO connection and Treatment class here
require '../../../../model/db_connect_front.php'; // Include your connection file
require '../../../../model/treatement.php'; // Include your Treatment class file

// Retrieve the value of cin from cookies
if (isset($_SESSION['cin'])) {
    $cin = $_SESSION['cin'];
} else {
    // Handle the case where the cookie doesn't exist or is not set
    // Redirect or display an error message, etc.
    exit('Error: Cin session not set!');
}

// Create a Treatment object using your PDO connection
$treatment = new Treatment($pdo);
// Handling Delete Action

// Handling Modify Action
if (isset($_GET['modifyTreatment'])) {
    $id = $_GET['id']; // Get treatment ID from the form
    // Redirect to the modification page with the treatment ID
    header("Location: modify_treatmentI.php?id=" . $id);
    exit();
}

// Fetch treatment records from the database using the fetchTreatments method
$stmt = $pdo->prepare("SELECT * FROM treatment WHERE CIN_Patient = :cin OR CIN_NURSE = :cin");
$stmt->execute([':cin' => $cin]);
$treatmentRecords = $stmt->fetchAll(PDO::FETCH_ASSOC);

// ... rest of your code to display treatment records in the table



                // Loop through the records and display them in the table
                foreach ($treatmentRecords as $record) {
                    echo "<tr>";
                    echo "<td>{$record['date_of_treatment']}</td>";
                    echo "<td>{$record['type_of_treatment']}</td>";
                    echo "<td class='text-wrap'>";
                    $cinPatient = $record['CIN_Patient'];

                    // Fetch patient name based on CIN from the database
                    $stmtPatient = $pdo->prepare("SELECT lastname FROM user WHERE CIN = ?");
                    $stmtPatient->execute([$cinPatient]);
                    $patientName = $stmtPatient->fetchColumn();

                    echo $patientName; // Display the patient's name
                    echo "</td>";
                    echo "<td class='text-wrap'>";
                    $cinNurse = $record['CIN_NURSE'];

                    // Fetch patient name based on CIN from the database
                    $stmtNurse = $pdo->prepare("SELECT lastname FROM user WHERE CIN = ?");
                    $stmtNurse->execute([$cinNurse]);
                    $NurseName = $stmtNurse->fetchColumn();

                    echo $NurseName; // Display the patient's name
                    echo "</td>";
                    echo "<td>";
                    echo "<form method='get' action='modify_treatmentI.php'>";
                    echo "<input type='hidden' name='id' value='{$record['id_treatment']}'>";
                    echo "<button type='submit' name='modifyTreatment' class='btn btn-info '>Modify</button>";
                    echo "</form>";
                    echo "</td>";
                    echo "</tr>";
                }
                ?>
            </tbody>
        </table>
        </table>
        <a href="add_treatmentI.php" class="btn btn-primary">Add Treatment</a>
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
		
		<!-- chat bot -->

		<button class="toggler">
			<span class="material-symbols-outlined">chat_bubble</span>
			<span class="material-symbols-outlined">close</span>
		</button> 
		<div class="chat_bot">
			<header>
			<h1 style=" color: #fff;">Chat Bot</h1>
			<span class="material-symbols-outlined">close</span>
			</header>
	 
			<ul class="chat_box">
				<li class="chat incoming">
					<span class="material-symbols-outlined">smart_toy</span>
					<p>hi there, How can I assist you today ?</p>
				</li>
			</ul>
			<div class="chat_input">
				<textarea name="" id="textareaaa" cols="10" rows="3" placeholder="Enter a message..." required></textarea>
				<span class="material-symbols-outlined">send</span>
			</div>
	   </div>
	   <!--/ End chatbot -->

		<!-- jquery Min JS -->
        <script src="../../homepages/nurse/js/jquery.min.js"></script>
		<!-- jquery Migrate JS -->
		<script src="../../homepages/nurse/js/jquery-migrate-3.0.0.js"></script>
		<!-- jquery Ui JS -->
		<script src="../../homepages/nurse/js/jquery-ui.min.js"></script>
		<!-- Easing JS -->
        <script src="../../homepages/nurse/js/easing.js"></script>
		<!-- Color JS -->
		<script src="../../homepages/nurse/js/colors.js"></script>
		<!-- Popper JS -->
		<script src="../../homepages/nurse/js/popper.min.js"></script>
		<!-- Bootstrap Datepicker JS -->
		<script src="../../homepages/nurse/js/bootstrap-datepicker.js"></script>
		<!-- Jquery Nav JS -->
        <script src="../../homepages/nurse/js/jquery.nav.js"></script>
		<!-- Slicknav JS -->
		<script src="../../homepages/nurse/js/slicknav.min.js"></script>
		<!-- ScrollUp JS -->
        <script src="../../homepages/nurse/js/jquery.scrollUp.min.js"></script>
		<!-- Niceselect JS -->
		<script src="../../homepages/nurse/js/niceselect.js"></script>
		<!-- Tilt Jquery JS -->
		<script src="../../homepages/nurse/js/tilt.jquery.min.js"></script>
		<!-- Owl Carousel JS -->
        <script src="../../homepages/nurse/js/owl-carousel.js"></script>
		<!-- counterup JS -->
		<script src="../../homepages/nurse/js/jquery.counterup.min.js"></script>
		<!-- Steller JS -->
		<script src="../../homepages/nurse/js/steller.js"></script>
		<!-- Wow JS -->
		<script src="../../homepages/nurse/js/wow.min.js"></script>
		<!-- Magnific Popup JS -->
		<script src="../../homepages/nurse/js/jquery.magnific-popup.min.js"></script>
		<!-- Counter Up CDN JS -->
		<script src="http://cdnjs.cloudflare.com/ajax/libs/waypoints/2.0.3/waypoints.min.js"></script>
		<!-- Bootstrap JS -->
		<script src="../../homepages/nurse/js/bootstrap.min.js"></script>
		<!-- Main JS -->
		<script src="../../homepages/nurse/js/main.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
            <script src="../notification/notification.js"></script>
            <script>
    $(document).ready(function() {
        // Event listener for the filter button
        $('#filterButton').on('click', function() {
            let orderByDate = $(this).data('order'); // Get the current order
            orderByDate = (orderByDate === 'ASC') ? 'DESC' : 'ASC'; // Toggle the order

            // Update the data-order attribute of the button
            $(this).data('order', orderByDate);

            // Fetch treatment data with the selected order
            fetchTreatmentData(orderByDate); // Send the order as a parameter
        });

        // Function to fetch treatment data
        function fetchTreatmentData(order) {
            // ... Your AJAX call to fetch treatment data
            $.ajax({
                url: 'fetch_order.php',
                method: 'GET',
                data: { order: order },
                success: function(response) {
                    // Process the fetched treatment data and display it in the table
                    // Update the table content with the sorted treatment records
                    $('#treatmentTable tbody').html(response);
                },
                error: function(xhr, status, error) {
                    // Handle error
                    console.error(error);
                }
            });
        }
    });
</script>
</body>

</html><!-- Your HTML code -->