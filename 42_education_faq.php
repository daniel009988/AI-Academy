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
	<h1><span>Frequently Asked Questions</span></h1>

	<div class="heading-title heading-border">
	<h4><span>Do I need an account to complete the course?</span></h4>
	<p class="fs-18">Yes, you need to create an account with AI-42 to answer questions. There's no credit card required to create an account. Your data is stored securely in our datacenter facilities.</p>
	</div>

	<div class="heading-title heading-border">
	<h4><span>Are the courses dependent on each other?</span></h4>
	<p class="fs-18">No, you can take each of our courses independently. For example, if you are just interested in studying AI and finance, just take the specific course.</p>
	</div>

	<div class="heading-title heading-border">
	<h4><span>How much does the courses cost?</span></h4>
	<p class="fs-18">The online course "Introduction to Artificial Intelligence" is offered <strong>free</strong>. We believe that it is important to educate as many people possible about the greatest innovation wave we have ever seen. This course sheds light on various aspects of AI, including definitions, neural networks, machine learning and societal implications. You will receive the certificate "Introduction to Artificial Intelligence" for successful completion for free. Our goal is to educate at least 1% of our population, let's make this happen together and tell your friends about it! </p><br>
	<p class="fs-18">The online course "Ethics & Artificial Intelligence" provides insights into the ethical aspects of AI and is offered for a fee of 1,900.00. This includes the issuance of the Certificate "Ethics & Artificial Intelligence"</p><br>
	<p class="fs-18">The online course "Artificial Intelligence in Finance" covers the AI company ecosystem, explains the different use cases of AI in the financial vertical and educates on how to identify AI investment opportunities. It is offered for a fee of 1,900.00. This includes the issuance of the Certificate "Artificial Intelligence & Finance"</p>

	</div>

	<div class="heading-title heading-border">
	<h4><span>How can I delete my course account?</span></h4>
	<p class="fs-18">If you want to delete your account, please send an email to office (at) 42.cx from your email address you have been using during sign up to our course and state "account deletion request".</p>
	</div>

	<div class="heading-title heading-border">
	<h4><span>I want to share my AI-42 Online Certificate Program stories on social media. Which tags and handles should I use?</span></h4>
	<p class="fs-18">Please use the following tags: #AI42 #OnlineEducation #OnlineCertificateProgram.</p>
	</div>

	<div class="heading-title heading-border">
	<h4><span>Will the courses be available in other languages?</span></h4>
	<p class="fs-18">The courses are currently only available in English. Other languages are possible, please let us know what language you would like to see our Online Certificate Program in!</p>
	</div>

	<div class="heading-title heading-border">
	<h4><span>Who created the online courses?</span></h4>
	<p class="fs-18">The copyright noctices for the different courses are as followed:</p>
	<p class="fs-18">"Ethics & Artificial Intelligence" (C)2019 by AI-42 Market Intelligence Ltd.</p>
	<p class="fs-18">"Artificial Intelligence in Finance" (C)2019 by AI-42 Market Intelligence Ltd.</p>
	<p class="fs-18">"Introduction to Artificial Intelligence" Elements of AI (C) 2018 by Reaktor and the University of Helsinki www.elementsofai.com</p>
	</div>

	<div class="heading-title heading-border">
	<h4><span>I received my certificate but it has the wrong name on it! What do I do?</span></h4>
	<p class="fs-18">Please contact office (at) 42.cx in case there is an error in your certificate.</p>
	</div>

	<div class="heading-title heading-border">
	<h4><span>I have passed a course, when do I get the certificate?</span></h4>
	<p class="fs-18">You will receive your certificate by mail to the address you have provided us once you have completed the course and passed our grading criteria. Please note that your free text answers are being reviewed manually, it takes time. Certificates will only be sent after all pending answers have been reviewed. You can see the status of your pending answers in the home section or in the main menu in your user details.</p><br>
	<p class="fs-18"><strong>The grading criteria are as follows:</strong><br>
	(i) minimum 90% of exercises completed; and (ii) minimum 50% of correctness<br>
	Please note that correctness is calculated as the average correctness over all the completed exercises (so each exercise has the same weight). The text answers are counted as 100% correct assuming they are confirmed valid.</p>
	</div>

	<div class="heading-title heading-border">
	<h4><span>Are there video lectures or other things tied to a place or time?</span></h4>
	<p class="fs-18">No, all the material is on the site and it consists of text and links to other sites. You can do the course from any place and at any time you want.</p>
	</div>

	<div class="heading-title heading-border">
	<h4><span>How are the courses graded?</span></h4>
	<p class="fs-18">There is no grade, but the amount of exercises you complete is tracked. For getting the certificate, you need to complete at least 90% of the exercises and get 50% of the exercises right.</p>
	</div>

	<div class="heading-title heading-border">
	<h4><span>How long will the courses take?</span></h4>
	<p class="fs-18">This depends on the course. The estimated time to complete a course is listed on the course description. An estimation is that it takes around 10 hours (1 week) per chapter. Some exercises require a lot of thinking, drawing on paper and going back to the theory part so they can take up to 45 minutes. You will also find lots of links in the course and looking at these as well will add to the time needed. Of course, you can do the course at your own pace.</p>
	</div>

	<div class="heading-title heading-border">
	<h4><span>How can I make the most out of the courses?</span></h4><br><br>
	<strong>Be prepared to dig deep.</strong><br>
	<p class="fs-18">Completing the courses will require some work. Expect to study and review all sections carefully to truly understand the content.</p>
	<br><strong>Get in a study group.</strong><br>
	<p class="fs-18">Your chances of completing the courses are significantly better if you study with friends, colleagues or the AI-42 community. Also, we strongly encourage participating in online discussions and asking if there’s something you don’t understand – it benefits the community as a whole.</p>
	<br><strong>Complete the exercises to the best of your ability.</strong><br>
	<p class="fs-18">In order to get your certificate you need to get 50% of the exercises correct.</p>
	<br><strong>Become a student again.</strong><br>
	<p class="fs-18">Devoting a couple of slots in your calendar each week will help you stay on track with the exercises. Having a dedicated place for studying – work desk, dining table, whatever works for you – helps get you into study mode.</p>
	<br><strong>Give us feedback!</strong><br>
	<p class="fs-18">Our AI-42 Online Certificate Program is a living course. We will keep updating the material and generally making the course better based on feedback.</p>
	</div>

	<div class="heading-title heading-border">
	<h4><span>Is there any programming or math in any of the courses?</span></h4>
	<p class="fs-18">No programming, but some math is required. It won’t be advanced math and the courses are designed so that no pre-existing knowledge beyond basic math is expected. Even though all information needed to complete the exercises is available in the course, some exercises and parts might feel a bit tricky if you haven’t done any math recently. Some exercises also require you to draw with a pen and paper to find the answer to the question.</p>
	</div>

</p>
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