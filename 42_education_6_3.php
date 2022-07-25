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
$this_chapter    = 6;
$this_subchapter = 3;

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

//entered answers (form post): *************************************************************************************************************************
$answers = array($_POST['0']);

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
	$sqlretrievestring = 'DELETE FROM EDUCATION_TABLE WHERE USER_ID=' . $user_id . ' AND CHAPTER = ' . $this_chapter . ' AND LESSON = ' . $this_subchapter . ' AND EXERCISE = 25' ;
	mysqli_query($connection, $sqlretrievestring);
	//loop through provided answers and save them:
	$question_num = 1;
	foreach($answers AS $answer) {
		$correct = 0; // <--- needs human review
		$answer = str_replace("'", "´", $answer); //remove '
		$sql="INSERT INTO `42_schema`.`EDUCATION_TABLE` (`USER_ID`, `CHAPTER`, `LESSON`, `EXERCISE`, `QUESTION`, `ANSWER_TEXT`, `CORRECT` ) VALUES ($user_id, $this_chapter, $this_subchapter , 25, $question_num, '$answer' , $correct)";
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
	$sqlretrievestring = 'SELECT * FROM EDUCATION_TABLE WHERE USER_ID=' . $user_id . ' AND CHAPTER = ' . $this_chapter . ' AND LESSON = ' . $this_subchapter . ' AND EXERCISE = 25' ;
	$result = mysqli_query($connection, $sqlretrievestring);
	$all_property = array();  //declare an array for saving property
	while ($property = mysqli_fetch_field($result)) {
			array_push($all_property, $property->name);  //save those to array
			}
	//loop through all of them:
	$answers = array();
	while ($row = mysqli_fetch_array($result)) {
		array_push($answers, $row['ANSWER_TEXT']);
		}
	$connection->close();
}
//end

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
		<!--<img src="assets/images/course_6_1.png" class="img-fluid"  alt="...">-->
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
		<div class="process-wizard-info text-center">Lesson I</div>
	</div>
	<div class="col-md-1 process-wizard-step complete"> <!-- complete active disabled -->
		<div class="text-center process-wizard-stepnum">&nbsp;</div>
		<div class="progress"><div class="progress-bar"></div></div>
		<a href="#" class="process-wizard-dot"></a>
		<div class="process-wizard-info text-center">Lesson II</div>
	</div>
	<div class="col-md-1 process-wizard-step active"> <!-- complete active disabled -->
		<div class="text-center process-wizard-stepnum">&nbsp;</div>
		<div class="progress"><div class="progress-bar"></div></div>
		<a href="#" class="process-wizard-dot"></a>
		<div class="process-wizard-info text-center">Lesson III</div>
	</div>
	
	
</div>
<br>
<!-- /PROCESS BAR -->

<div class="row">
	<div class="col-md-2" valign="top">
	</div>
	<div class="col-md-7" valign="top">


<!-- TEXT ........................................................................................................ -->

<h1><span>III. Summary</span></h1>

<h3>The most important decisions that determine how well our society can adapt to the changes brought by AI aren’t technological. They are political.</h3>

<p class="fs-18">Everything that we have learned about AI suggests that the future is bright. We will get new and better services and increased productivity will lead to positive overall outcomes – but only on the condition that we carefully consider the societal implications and ensure that the power of AI is used for the common good.</p>

<h3>What we need to do to ensure a positive outcome</h3>
<p class="fs-18">Still, we have a lot of work to do.</p>
<li>We need to avoid algorithmic bias to be able to reduce discrimination instead of increasing it.</li><br>
<li>We also need to learn to be critical about what we see, as seeing is no longer the same as believing – and develop AI methods that help us detect fraud rather than just making it easier to fabricate more real-looking falsehoods.</li><br>
<li>We need to set up regulation to guarantee that people have the right to privacy, and that any violations of this right are strictly penalized.</li><br>

<p class="fs-18">We also need to find new ways to share the benefits to everyone, instead of creating an AI elite, those who can afford the latest AI technology and use it to access unprecedented economic inequality. This requires careful political judgment (note that by political judgment, we mean decisions about policy, which has little to do with who votes for whom in an election or the comings and goings of individual politicians and political parties).</p>

<div class="card card-default">
	<div class="card-block">
		<p class="fs-14">Note</p>
		<h4><span>The importance of policy</span></h4>
		<p class="fs-18">The most important decisions that determine how well our society can adapt to the evolution of work and to the changes brought by AI aren’t technological. They are political.</p>
		<p class="fs-18">The regulation of the use of AI must follow democratic principles, and everyone must have an equal say about what kind of a society we want to live in in the future. The only way to make this possible is to make knowledge about technology freely available to all. Obviously there will always be experts in any given topic, who know more about it than the rest of us, but we should at least have the possibility to critically evaluate what they are saying.</p>
	</div>
</div>

<p class="fs-18">What you have learned with us supports this goal by providing you the basic background about AI so that we can have a rational discussion about AI and its implications.</p>

<h3>Our role as individuals</h3>
<p class="fs-18">As you recall, we started this course by motivating the study of AI by discussing prominent AI applications that affect all our lives. We highlighted three examples: self-driving cars, recommendation systems, and image and video processing. During the course, we have also discussed a wide range of other applications that contribute to the current technological transition.</p>

<div class="card card-default">
	<div class="card-block">
		<p class="fs-14">Note</p>
		<h4><span>Hidden agenda</span></h4>
		<p class="fs-18">We also had a hidden agenda. We wanted to give you an opportunity to experience the thrill of learning, and the joy of heureka moments when something that may have been complicated and mysterious, becomes simple and if not self-evident, at least comprehensible. These are moments when our curiosity is satisfied. But such satisfaction is temporary. Soon after we have found the answer to one question, we will ask the next. What then? And then?</p>
		<p class="fs-18">If we have been successful, we have whetted your appetite for learning. We hope you will continue your learning by finding other courses and further information about AI, as well as other topics of your interest. To help you with your exploration, we have collected some pointers to AI material that we have found useful and interesting.</p>
	</div>
</div>

<p class="fs-18">Now you are in a position where you can find out about what is going on in AI, and what is being done to ensure its proper use. You should do so, and whenever you feel like there are risks we should discuss, or opportunities we should go after, don't wait that someone else reacts</p>

</div>
</div>


<!-- EXERCISE -->
<div class="callout alert alert-default">
	<div class="row">
		<div class="col-md-2" valign="top">
		</div>
		<div class="col-md-7 col-sm-8"><!-- left text -->
			<h1><span>Exercise 25: AI in your life</span></h1>
			<p class="fs-18">How do you see AI affecting you in the future, both at work and in everyday life? Include both the positive and possible negative implications.</p>
		</div>
		<div class="col-md-3" valign="top">
		</div>
	</div>
</div>

<div class="card card-default" id="exercise">
	<div class="card-block">
		<p class="fs-14">Answer the questions below</p>
		
	
<form class="m-0" method="post" action="#exercise" autocomplete="off">
	
	<?php 
		if ($answers[0]=='') echo '<textarea class="form-control rounded-0" rows = "8" name = "0" placeholder="Your answer..." required></textarea>'; 
		else {echo nl2br($answers[0]);};

	?>
	

	<div class="col-md-12 text-center">
		<?php 
		//only logged in users can submit:
			if (($usertype==8) or ($usertype==9)){
				if ($answers[0]==''){echo '<button class="btn btn-primary">SUBMIT</button>';} 
				else {echo '<strong>SUBMITTED</strong>';} 
			}
			else {echo '<p class="text-red"><strong>You need to be logged in to submit your answers.</strong></p>';
			echo 'Answers can only be submitted if you have a registered account with us. <br>Please sign up to create an account or log in with your details:';
				echo '<div class="container"><br>';
								echo '<table width="100%" border="0">';
								echo '<td width="45%" align="right"><button type="button" class="btn btn-green" data-toggle="modal" data-target=".signup-plan-free"><strong>SIGN UP</strong></button></td>';
								echo '<td width="10%"></td>';
								echo '<td width="45%" align="left"><a class="btn btn-blue" href="ai_education_login.php" role="button">LOG IN</a></td>';
								echo '</table>';
								echo '</div>';
			}
		//end 
		?>
	</div>
	<br><p class="fs-14"><strong>Note:</strong> You will only be able to submit the answer once, after which the correct answers will be revealed, so take your time and re-read the material above if you feel like it. That said, don't worry if you get some of them wrong – some of them are debatable in any case because these kinds of things are rarely perfectly clear cut. We are quite sure that if you just focus and do your best, you will have no problems achieving a successful overall result in the end. Making mistakes is one of the best opportunities to learn.</p>
</form>

</div>
</div>
<!-- /EXERCISE -->

<div class="card card-default">
	<div class="card-block">
		<h2>Congratulations!</h2>

		<h3>After completing Chapter 6 you should be able to:</h3>
		<blockquote>Understand the difficulty in predicting the future and be able to better evaluate the claims made about AI</blockquote>
		<blockquote>Identify some of the major societal implications of AI including algorithmic bias, AI-generated content, privacy, and work</blockquote>
</div>
</div>

<div class="card card-default">
	<div class="card-block">

		<h3>How to obtain your certificate:</h3>
		
		<div class="card-block">
				<div class="row border-bottom">
					<div class="col-md-5" valign="top">
						<p class="font-lato fs-13">Correct answers:<br>
						Answers under review:<br>
						Exercises completed:</p>
					</div>
					<div class="col-md-5" valign="top">
						<p class="font-lato fs-13">
						<strong><?php echo $correct_answers;?></strong><br>
						<strong><?php echo $under_review;?></strong></br>
						<strong><?php echo $exercises_completed_block_1.' of Block 1<br>';?></strong><br>
					</div>
					
				</div>
				<br>
				<p class="font-lato fs-13"><strong>Grading criteria to obtain our certificate:</strong><br>
				(i) minimum 90% of exercises completed; and <br>(ii) minimum 50% of correct answers.<br>
				</p>
		</div>
		<p class="fs-18">Some of your answers might be still pending on review. As soon as all your answers have been reviewed (and you have successfully completed the lessons according to our grading criteria), we will mail you the certificate "Artificial Intelligence Introduction". We won't be long!</p>

</div>
</div>

<div class="card card-default">
	<div class="card-block">

		<h3>Want to continue your studies?</h3>
		<h1>Course "Ethics of AI"&nbsp;&nbsp;&nbsp;<p class="fs-14 text-gray"><strong>COMING SOON</strong></p>
			<?php //echo '<a href="42_education_7_1.php"><button type="button" class="btn btn-primary btn-lg">&nbsp;&nbsp;&nbsp;CONTINUE&nbsp;&nbsp;&nbsp;</button></a>'; ?>

		</h1>
	</div>
</div>

<!-- /wrapper -->
<br><br>
<p class="font-lato fs-15">Licensed under Creative Commons BY-NC-SA 4.0. Elements of AI (C) 2018 by Reaktor and the University of Helsinki www.elementsofai.com</p>

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