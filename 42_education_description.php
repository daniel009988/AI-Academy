<?php
session_start();
if(!isset($_SESSION['userid'])) {
	//header('Location: '.'ai_analyst_login.php'); //not logged in
	}
 //Abfrage der Nutzer ID vom Login
$user_id = $_SESSION['userid'];
$username = $_SESSION['username'];
$usertype = $_SESSION['usertype'];

//retrieve user status: - to be completed with SQL
include 'include_retrieve_user_status.php';

//include menu:
include '42_education_include_menu.php';
$signupfor = 'education';
include ('signupmodal.html'); 
?>


<!-- Main AREA -->

<!-- LEADING IMAGE -->
<div class="row">
	<div class="col-md-12" valign="top">
		<img src="assets/images/course_title_s2.jpg" class="img-fluid"  alt="...">
	</div>
</div>

<div class="container">

	<div class="container">
		<br>
		<h4>Please choose one of the courses:</h4>
		<li><a href="#intro">Introduction to Artificial Intelligence</a></li>
		<li><a href="#ethics">Ethics & Artificial Intelligence</a></li>
		<li><a href="#finance">Artificial Intelligence in Finance</a></li>
	</div>

<div class="container" id="intro">
	<br>
	<h1><span>COURSE DESCRIPTION: INTRODUCTION TO ARTIFICIAL INTELLIGENCE</span></h1>

	<h3>SYLLABUS AND LEARNING OBJECTIVES</h3>

	<p>The material of the massive open online course "Introduction to Artificial Intelligence" (https://42.cx), offered by AI-42 Market Intelligence Ltd., consists of text and interactive elements. The material is divided in six chapters which are:</p>

	<li>1. What is AI?</li>
	<li>2. AI problem solving</li>
	<li>3. Real world AI</li>
	<li>4. Machine learning</li>
	<li>5. Neural networks</li>
	<li>6. Implications</li>
	
	<br>
	<p>After successfully completing the course the student will be able to:</p>
	<li>Identify autonomy and adaptivity as key concepts of AI</li>
	<li>Distinguish between realistic and unrealistic AI (science fiction vs. real life)</li>
	<li>Express the basic philosophical problems related to AI including the implications of the Turing test and Chinese room thought experiment</li>
	<li>Formulate a real-world problem as a search problem</li>
	<li>Formulate a simple game (such as tic-tac-toe) as a game tree</li>
	<li>Use the minimax principle to find optimal moves in a limited-size game tree</li>
	<li>Express probabilities in terms of natural frequencies</li>
	<li>Apply the Bayes rule to infer risks in simple scenarios</li>
	<li>Explain the base-rate fallacy and avoid it by applying Bayesian reasoning</li>
	<li>Explain why machine learning techniques are used</li>
	<li>Distinguish between unsupervised and supervised machine learning scenarios</li>
	<li>Explain the principles of three supervised classification methods: the nearest neighbor method, linear regression, and logistic regression</li>
	<li>Explain what a neural network is and where they are being successfully used</li>
	<li>Understand the technical methods that underpin neural networks</li>
	<li>Understand the difficulty in predicting the future and be able to better evaluate the claims made about AI</li>
	<li>Identify some of the major societal implications of AI including algorithmic bias, AI-generated content, privacy, and work</li>
	<br><br>
	<h3>ASSESSMENT</h3>
	<p>Assessment is based on exercises, including multiple choice quizzes, numerical exercises, and questions that require
	a written answer. The multiple choice and numerical exercises are automatically checked, and the exercises with
	written answers are reviewed by other students (peer grading) and in some cases by the instructors.
	Successful completion of the course requires at least 90% completed exercises and minimum 50% correctness. The
	course is graded as pass/fail (no numerical grades).</p>
	<h3>TIME REQUIREMENT AND STUDY CREDITS</h3>
	<p>The estimated time requirement is about 60 hours depending on the background of the student. 
	As a proof of completion, each student is given an electronic certificate.</p>





</div>

<div class="container" id="ethics">
	<br>
	<h1><span>COURSE DESCRIPTION: ETHICS & ARTIFICIAL INTELLIGENCE</span></h1>
	<p>We are working hard on completing the course material. This section will contain the syllabus and learning objectives of the course and will be updated as soon as it is available.</p>
</div>

<div class="container" id="finance">
	<br>
	<h1><span>COURSE DESCRIPTION: ARTIFICIAL INTELLIGENCE IN FINANCE</span></h1>
	<p>We are working hard on completing the course material. This section will contain the syllabus and learning objectives of the course and will be updated as soon as it is available.</p>
</div>



<!-- /wrapper -->
<br><br>

<p class="font-lato fs-15">(C)2019 by 42.CX</p>

<!-- SCROLL TO TOP -->
<a href="#" id="toTop"></a>
<!-- PRELOADER -->
<div id="preloader">
<div class="inner">
<span class="loader"></span>
</div>
</div><!-- /PRELOADER -->
<!-- JAVASCRIPT FILES -->
<script>var plugin_path = 'assets/plugins/';</script>
<script src="assets/js/scripts.js"></script>







</body>
</html>