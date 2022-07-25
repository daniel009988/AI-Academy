<?php
session_start();
if(!isset($_SESSION['userid'])) {
	//header('Location: '.'ai_analyst_login.php'); //not logged in
	}
//Abfrage der Nutzer ID vom Login
$user_id = $_SESSION['userid'];
$username = $_SESSION['username'];
$usertype = $_SESSION['usertype'];

// education login: analyst wird education:
if ($usertype == 1) {$usertype=8;}
if ($usertype == 2) {$usertype=8;}
if ($usertype == 3) {$usertype=8;}
if ($usertype == 6) {$usertype=8;}

//Set this chapter:
$this_chapter    = 7;
$this_subchapter = 1;

//retrieve user status: 
include 'include_retrieve_user_status.php';

//chapter not ready?
if ($this_chapter>$progress_chapter){
	header('Location: '.'42_education_chapter_not_ready.php');
}
//sub-chapter not ready?
if (($this_chapter==$progress_chapter) && ($this_subchapter>$progress_subchapter)){
	header('Location: '.'42_education_chapter_not_ready.php');
}

//QUESTIONAIRE BLOCK ***********************************************************************************************************************************
$questions_string = array(
	"Synapse (connection)",
	"Dendrite (input)",
	"Cell body",
	"Axon (output)"
	);
//answering options:
$questions_options = array("A", "B", "C", "D"); // =1, =2, =3, etc.
//correct answers:
$questions_correct = array(array(4),array(2),array(1),array(3));
//answers comments:
$questions_correct_hint = array(
	"",
	"",
	"",
	"");

//entered answers (form post): *************************************************************************************************************************
$answers = array($_POST['0'],$_POST['1'],$_POST['2'],$_POST['3']);

//where there answers? if yes, save to SQL: ************************************************************************************************************
if ($answers[0]<>''){
	$host    = "127.0.0.1"; $user    = "webuser"; $pass    = "Vpueokzq1"; $db_name = "42_schema";
	//create connection
	$connection = mysqli_connect($host, $user, $pass, $db_name);
	//test if connection failed
	if(mysqli_connect_errno()){
		die("connection failed: "
        	. mysqli_connect_error()
       		. " (" . mysqli_connect_errno()
     	    . ")");
	}
	//delete existing answers from SQL:
	$sqlretrievestring = 'DELETE FROM EDUCATION_TABLE WHERE USER_ID=' . $user_id . ' AND CHAPTER = ' . $this_chapter . ' AND LESSON = ' . $this_subchapter . ' AND EXERCISE = 20' ;
	mysqli_query($connection, $sqlretrievestring);
	//loop through provided answers and save them:
	$question_num = 1;
	foreach($answers AS $answer) {
		$correct = -1;
		if (in_array($answer,$questions_correct[$question_num-1])) {$correct = 1;}
		$sql="INSERT INTO `42_schema`.`EDUCATION_TABLE` (`USER_ID`, `CHAPTER`, `LESSON`, `EXERCISE`, `QUESTION`, `ANSWER`, `CORRECT` ) VALUES ($user_id, $this_chapter, $this_subchapter , 20, $question_num, $answer , $correct)";
		if ($connection->query($sql) === TRUE) {} else {echo "Error: " . $sql . "<br>" . $connection->error;}
		$question_num = $question_num + 1;
	}
	$connection->close();
}
//end 

//answers already in SQL? only if loggedin **************************************************************************************************************
if ($usertype<>'') {
	$host    = "127.0.0.1"; $user    = "webuser"; $pass    = "Vpueokzq1"; $db_name = "42_schema";
	//create connection
	$connection = mysqli_connect($host, $user, $pass, $db_name);
	//test if connection failed
	if(mysqli_connect_errno()){
		die("connection failed: "
        	. mysqli_connect_error()
       		. " (" . mysqli_connect_errno()
     	    . ")");
	}
	//retrieve answers:
	$sqlretrievestring = 'SELECT * FROM EDUCATION_TABLE WHERE USER_ID=' . $user_id . ' AND CHAPTER = ' . $this_chapter . ' AND LESSON = ' . $this_subchapter . ' AND EXERCISE = 20' ;
	$result = mysqli_query($connection, $sqlretrievestring);
	$all_property = array();  //declare an array for saving property
	while ($property = mysqli_fetch_field($result)) {
			array_push($all_property, $property->name);  //save those to array
			}
	//loop through all of them:
	$answers = array();
	while ($row = mysqli_fetch_array($result)) {
		array_push($answers, $row['ANSWER']);
		}
	$connection->close();
}
//end

//count correct answers: ********************************************************************************************************************************
$count_correct = 0;
$count_total = 0;
foreach($answers AS $answer) {
	if (in_array($answer,$questions_correct[$count_total])) {$count_correct = $count_correct + 1;}
  	$count_total = $count_total + 1;
}
// END OF QUESTIONAIRE-BLOCK ****************************************************************************************************************************

//include menu:
include '42_education_include_menu.php';
$signupfor = 'education';
include ('signupmodal.html'); 

?>



<!-- Main AREA -->

<!-- LEADING IMAGE -->
<div class="row">
	<div class="col-md-12" valign="top">
		<img src="assets/images/course_7_1.png" class="img-fluid"  alt="...">
	</div>
</div>

<!-- CONTENT -->
<div class="container">
<div class="container">
<br>

<!-- PROCESS BAR -->
<div class="row process-wizard process-wizard-info">
	<div class="col-md-1"></div>
	<div class="col-md-1 process-wizard-step complete"> <!-- complete active disabled -->
		<div class="text-center process-wizard-stepnum">Chapter 1</div>
		<div class="progress"><div class="progress-bar"></div></div>
		<a href="#" class="process-wizard-dot"></a>
		<div class="process-wizard-info text-center">&nbsp;</div>
	</div>
	<div class="col-md-1 process-wizard-step complete"> <!-- complete active disabled -->
		<div class="text-center process-wizard-stepnum">Chapter 2</div>
		<div class="progress"><div class="progress-bar"></div></div>
		<a href="#" class="process-wizard-dot"></a>
		<div class="process-wizard-info text-center">&nbsp;</div>
	</div>
	<div class="col-md-1 process-wizard-step complete"> <!-- complete active disabled -->
		<div class="text-center process-wizard-stepnum">Chapter 3</div>
		<div class="progress"><div class="progress-bar"></div></div>
		<a href="#" class="process-wizard-dot"></a>
		<div class="process-wizard-info text-center">&nbsp;</div>
	</div>
	<div class="col-md-1 process-wizard-step complete"> <!-- complete active disabled -->
		<div class="text-center process-wizard-stepnum">Chapter 4</div>
		<div class="progress"><div class="progress-bar"></div></div>
		<a href="#" class="process-wizard-dot"></a>
		<div class="process-wizard-info text-center">&nbsp;</div>
	</div>
	<div class="col-md-1 process-wizard-step complete"> <!-- complete active disabled -->
		<div class="text-center process-wizard-stepnum">Chapter 5</div>
		<div class="progress"><div class="progress-bar"></div></div>
		<a href="#" class="process-wizard-dot"></a>
		<div class="process-wizard-info text-center">&nbsp;</div>
	</div>
	<div class="col-md-1 process-wizard-step complete"> <!-- complete active disabled -->
		<div class="text-center process-wizard-stepnum">Chapter 6</div>
		<div class="progress"><div class="progress-bar"></div></div>
		<a href="#" class="process-wizard-dot"></a>
		<div class="process-wizard-info text-center">&nbsp;</div>
	</div>
	<div class="col-md-1 process-wizard-step active"> <!-- complete active disabled -->
		<div class="text-center process-wizard-stepnum">Chapter 7</div>
		<div class="progress"><div class="progress-bar"></div></div>
		<a href="#" class="process-wizard-dot"></a>
		<div class="process-wizard-info text-center">&nbsp;</div>
	</div>
	<div class="col-md-1 process-wizard-step disabled"> <!-- complete active disabled -->
		<div class="text-center process-wizard-stepnum">Chapter 8</div>
		<div class="progress"><div class="progress-bar"></div></div>
		<a href="#" class="process-wizard-dot"></a>
		<div class="process-wizard-info text-center">&nbsp;</div>
	</div>
	
</div>
<br>
<!-- /PROCESS BAR -->

<div class="row">
	<div class="col-md-2" valign="top">
	</div>
	<div class="col-md-7" valign="top">


<!-- TEXT ........................................................................................................ -->

<h1><span>COMING SOON.</span></h1>


	</div>
</div>


<!-- /wrapper -->
<br><br>
<p class="font-lato fs-15">Chapter 7 and 8 have been created by 42.CX's expert advisory board with the focus on the need of people working in the finance world. Chapters 1 to 6 are based on selected parts of the popular Introduction to AI course at the University of Helsinki. The textual content of Chapters 1 to 6 are licensed under Creative Commons BY-NC-SA 4.0.</p>

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