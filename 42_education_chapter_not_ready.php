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


<div class="container">
<div class="container">
	<br>
	<br>


<div class="row">
	<div class="col-md-2" valign="top">
	</div>
	<div class="col-md-7" valign="top">
		
		<h1><span><i class="fa fa-warning"></i> Chapter not yet available for you</span></h1>
<h3>Chapters have to be completed consecutively.<br>You are currently at Chapter <?php echo $progress_chapter;?>, Lesson <?php echo $progress_subchapter;?>.</h3>

<p class="fs-18">Please complete all chapters and lessons in a sequence because you might miss important information and learnings from previous chapters.</p>

<br>

<?php echo '<a class="btn btn-blue" href="42_education_'.strval($progress_chapter).'_'.strval($progress_subchapter).'.php" role="button">Continue with Chapter '.$progress_chapter.'-'.$progress_subchapter.'</a>';?>

								


	</div>
</div>



</div>


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