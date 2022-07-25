<!DOCTYPE html>
<html lang="en">
<head>
	<!-- favicons -->
	<link rel="icon" href="favicon-32.png" sizes="32x32">
	<link rel="icon" href="favicon-57.png" sizes="57x57">
	<link rel="icon" href="favicon-76.png" sizes="76x76">
	<link rel="icon" href="favicon-96.png" sizes="96x96">
	<link rel="icon" href="favicon-128.png" sizes="128x128">
	<link rel="icon" href="favicon-192.png" sizes="192x192">
	<link rel="icon" href="favicon-228.png" sizes="228x228">
	<!-- Android -->
	<link rel="shortcut icon" sizes="196x196" href="favicon-196.png">
	<!-- iOS -->
	<link rel="apple-touch-icon" href="favicon-120.png" sizes="120x120">
	<link rel="apple-touch-icon" href="favicon-152.png" sizes="152x152">
	<link rel="apple-touch-icon" href="favicon-180.png" sizes="180x180">
	
	<!-- including ECharts file -->
    <script src="echarts.min.js"></script>

	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.0.3/jquery.js"></script>
	<link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css" />

	<!-- PSMW -->
	<link rel="stylesheet" type="text/css" href="/psmw/css/style.css" />
	<script src="/psmw/js/app.min.js"></script>

	<meta charset="utf-8" />
		<title>42 Online Academy</title>
		<meta name="description" content="" />
		<meta name="Author" content="42.CX Center of Excellence Daniel Mattes" />
		<meta name="viewport" content="width=device-width, maximum-scale=1, initial-scale=1, user-scalable=0" />
	
	<link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600%7CRaleway:300,400,500,600,700%7CLato:300,400,400italic,600,700" rel="stylesheet" type="text/css" />
	
	<!-- CORE CSS -->
	<link href="assets/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
	
	<!-- THEME CSS -->
	<link href="assets/css/essentials.css" rel="stylesheet" type="text/css" />
	<link href="assets/css/layout.css" rel="stylesheet" type="text/css" />
	
	<!-- PAGE LEVEL SCRIPTS -->
	<link href="assets/css/header-1.css" rel="stylesheet" type="text/css" />
	<link href="assets/css/color_scheme/darkblue.css" rel="stylesheet" type="text/css" id="color_scheme" />

	<!-- REDquerybuilder -->
	<script src="RedQueryBuilder/RedQueryBuilder.nocache.js" type="text/javascript">//</script>
    <link rel="stylesheet" href="RedQueryBuilder/gwt/dark/dark.css" type="text/css" />
    <script src="RedQueryBuilder/RedQueryBuilderFactory.nocache.js" type="text/javascript">//</script>
    <script src="search-query.js" type="text/javascript">//</script>

	<!-- REVOLUTION SLIDER -->
	<link href="assets/plugins/slider.revolution/css/extralayers.css" rel="stylesheet" type="text/css" />
	<link href="assets/plugins/slider.revolution/css/settings.css" rel="stylesheet" type="text/css" />

	<!-- Global site tag (gtag.js) - Google Analytics -->
	<script async src="https://www.googletagmanager.com/gtag/js?id=UA-137257063-1"></script>
	<script>
	  window.dataLayer = window.dataLayer || [];
	  function gtag(){dataLayer.push(arguments);}
	  gtag('js', new Date());

	  gtag('config', 'UA-137257063-1');
	</script>

	<style>
	.sidebar {
    color: #fff;
    width: 240px;
    height: 100%;
    position: fixed;
    background: #2a3542;
    left:0px;
    transition:0.3s all ease-in-out;
}

.sidebar.close {
    left: -240px;
    transition:0.3s all ease-in-out;
}
	</style>

</head>



<body class="smoothscroll enable-animation menu-vertical grain-grey">

	<div id="wrapper">

		<!-- SIDE MENU -->
			<div id="mainMenu" class="navbar-toggleable-md sidebar-vertical">
				<div class="sidebar-nav">
					<div class="navbar navbar-default" role="navigation">
						<!-- LOGO -->
						<div class="container">
						<a href="https://42.cx" class="logo float-left">
							<img src="assets/images/_smarty/42-top-small.png" class="img-fluid" alt="Responsive image" width="150">
						</a>
						</div>
						<!-- NAME -->
						<div class="container">
							<h5><span>42 Online Academy</span></h5>
						</div>
						
						<!-- NAVBAR -->

						<div class="navbar-header">
							<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".sidebar-navbar-collapse">
								<span class="sr-only">Toggle navigation</span>
								<span class="icon-bar"></span>
								<span class="icon-bar"></span>
								<span class="icon-bar"></span>
							</button>
						</div>

						<div class="navbar-collapse sidebar-navbar-collapse collapse" aria-expanded="false">

							<!-- MENU -->
							<ul class="nav navbar-nav">

								<li>
									<a href="42_education_home.php">
										<i class="et-desktop"></i> 
										Home
									</a>
								</li>

								<li>
									<a href="42_education_description.php">
										<i class="et-briefcase"></i> 
										COURSE DESCRIPTIONS
									</a>
								</li>

								<li>
									<a href="42_education_faq.php">
										<i class="et-lightbulb"></i> 
										FAQ
									</a>
								</li>

								<li>
									<a href="#">
										<i class="glyphicon glyphicon-education"></i> 
										INTRODUCTION TO AI
									</a>
								</li>

								
							
								<?php if (($usertype==8) OR ($usertype==9) OR ($usertype==1) OR ($usertype==2) OR ($usertype==3) OR ($usertype==6)) {
									echo '<li class="dropdown">
												<a class="dropdown-toggle" data-toggle="dropdown" href="">
												<i class="et-profile-male"></i> ';
												echo $username; 
												if ($usertype==8) { echo ' (Free)'; }
												if ($usertype==9) { echo ' (Premium)'; }
												echo '</a>
											<ul class="dropdown-menu">
												
												<li><br><p class="font-lato fs-13">
												&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Correct answers: '.$correct_answers.'<br>
												&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Answers under review: '.$under_review.'<br>
												&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Exercises completed: '.$exercises_completed.'<br>
												&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Current chapter: '.'CH.'.$progress_chapter.'-'.$progress_subchapter.'
												</li>
												<li><a href="ai_analyst_logout.php">Logout</a></li>
											</ul>
											
										</li>';
								} ?>
							
								



								
								
								<?php if ($progress_chapter>=10000000) {echo '
								<li class="dropdown">
									<a class="dropdown-toggle" data-toggle="dropdown" href="">
										<i class="et-pencil"></i> 
										Ch.1 - What is AI?
									</a>
									<ul class="dropdown-menu">
										<li><a href="42_education_1_1.php">I. How should we define AI?</a></li>
										<li><a href="42_education_1_2.php">II. Related fields</a></li>
										<li><a href="42_education_1_3.php">III. Philosophy of AI</a></li>
									</ul>
								</li>';} else {echo '<li><a class="text-gray" data-toggle="dropdown" href=""><i class="et-pencil"></i> Ch.1 - What is AI?</a></li>';}
								if ($progress_chapter>=2) {echo '
								<li class="dropdown">
									<a class="dropdown-toggle" data-toggle="dropdown" href="">
										<i class="et-pencil"></i> 
										Ch.2 - AI problem solving
									</a>
									<ul class="dropdown-menu">
										<li><a href="42_education_2_1.php">I. Search and problem solving</a></li>
										<li><a href="42_education_2_2.php">II. Solving problems with AI</a></li>
										<li><a href="42_education_2_3.php">III. Search and games</a></li>
									</ul>
								</li>';} else {echo '<li><a class="text-gray" data-toggle="dropdown" href=""><i class="et-pencil"></i> Ch.2 - AI problem solving</a></li>';}
								if ($progress_chapter>=3) {echo '
								<li class="dropdown">
									<a class="dropdown-toggle" data-toggle="dropdown" href="">
										<i class="et-pencil"></i> 
										Ch.3 - Real world AI
									</a>
									<ul class="dropdown-menu">
										<li><a href="42_education_3_1.php">I. Odds and probability</a></li>
										<li><a href="42_education_3_2.php">II. The Bayes rule</a></li>
										<li><a href="42_education_3_3.php">III. Naive Bayes classification</a></li>
									</ul>
								</li>';} else {echo '<li><a class="text-gray" data-toggle="dropdown" href=""><i class="et-pencil"></i> Ch.3 - Real world AI</a></li>';}
								if ($progress_chapter>=4) {echo '
								<li class="dropdown">
									<a class="dropdown-toggle" data-toggle="dropdown" href="">
										<i class="et-pencil"></i> 
										Ch.4 - Machine Learning
									</a>
									<ul class="dropdown-menu">
										<li><a href="42_education_4_1.php">I. The types of machine learning</a></li>
										<li><a href="42_education_4_2.php">II. The nearest neighbour classifier</a></li>
										<li><a href="42_education_4_3.php">III. Regression</a></li>
									</ul>
								</li>';} else {echo '<li><a class="text-gray" data-toggle="dropdown" href=""><i class="et-pencil"></i> Ch.4 - Machine Learning</a></li>';}
								if ($progress_chapter>=5) {echo '
								<li class="dropdown">
									<a class="dropdown-toggle" data-toggle="dropdown" href="">
										<i class="et-pencil"></i> 
										Ch.5 - Neural Networks
									</a>
									<ul class="dropdown-menu">
										<li><a href="42_education_5_1.php">I. Neural network basics</a></li>
										<li><a href="42_education_5_2.php">II. How neural networks are built</a></li>
										<li><a href="42_education_5_3.php">III. Advanced neural network techniques</a></li>
									</ul>
								</li>';} else {echo '<li><a class="text-gray" data-toggle="dropdown" href=""><i class="et-pencil"></i> Ch.5 - Neural Networks</a></li>';}
								if ($progress_chapter>=6) {echo '
								<li class="dropdown">
									<a class="dropdown-toggle" data-toggle="dropdown" href="">
										<i class="et-pencil"></i> 
										Ch.6 - Implications
									</a>
									<ul class="dropdown-menu">
										<li><a href="42_education_6_1.php">I. About predicting the future</a></li>
										<li><a href="42_education_6_2.php">II. The societal implications of AI</a></li>
										<li><a href="42_education_6_3.php">III. Summary</a></li>
									</ul>
								</li>';} else {echo '<li><a class="text-gray" data-toggle="dropdown" href=""><i class="et-pencil"></i> Ch.6 - Implications</a></li>';}
								
								?>

								<li>
									<a href="#">
										<i class="glyphicon glyphicon-education"></i> 
										Ethics & AI
									</a>
								</li>

								<li>
									<a href="#">
										<i class="glyphicon glyphicon-education"></i> 
										AI in Finance
									</a>
								</li>
								
								
								
											 
											
											
									
								
							</ul>
							<!-- /MENU -->

							<!-- SIGNUP and LOGIN in case: -->
							<?php if ($usertype=='') {
								echo '<div class="container"><br>';
								echo '<table width="100%" border="0">';
								#echo '<td width="50%" align="center"><button type="button" class="btn btn-green" data-toggle="modal" data-target=".signup-plan-free"><strong>SIGN UP</strong></button></td>';
								#echo '<td width="50%" align="center"><a class="btn btn-blue" href="ai_education_login.php" role="button">LOG IN</a></td>';
								echo '</table>';
								echo '</div>';
							} 
							?>
							

						</div><!--/.nav-collapse -->

					</div>

				</div>

<br>


				
				

				

			</div>
			<!-- /SIDE MENU -->




