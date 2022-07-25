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
$this_chapter    = 2;
$this_subchapter = 2;

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
$questions_string = array("Number of transitions");
$questions_options = array("4","5","6","7","8","9","10","11","12");
$questions_correct = array(array(4));
$questions_correct_hint = array("The correct answer is 7. There are two shortest paths that lead from the start NNNN to the goal FFFF. One of them is NNNN -> FNFN -> NNFN -> FFFN -> NFNN -> FFNF -> NFNF -> FFFF, and the other NNNN -> FNFN -> NNFN -> FNFF -> NNNF -> FFNF -> NFNF -> FFFF. Intuitively, the strategy is to move the chicken on the other side first, and then go back get either the fox or the feed, and take it to the far side too. The robot then takes the chicken back to the near side to save it from being eaten or from eating the feed, and takes the other remaining object (fox or feed) from the near side to the far side. Finally, the robot goes to fetch the chicken and takes it to the far side to reach the goal.");

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
	$sqlretrievestring = 'DELETE FROM EDUCATION_TABLE WHERE USER_ID=' . $user_id . ' AND CHAPTER = ' . $this_chapter . ' AND LESSON = ' . $this_subchapter . ' AND EXERCISE = 5' ;
	mysqli_query($connection, $sqlretrievestring);
	//loop through provided answers and save them:
	$question_num = 1;
	foreach($answers AS $answer) {
		$correct = -1;
		if (in_array($answer,$questions_correct[$question_num-1])) {$correct = 1;}
		$sql="INSERT INTO `42_schema`.`EDUCATION_TABLE` (`USER_ID`, `CHAPTER`, `LESSON`, `EXERCISE`, `QUESTION`, `ANSWER`, `CORRECT` ) VALUES ($user_id, $this_chapter, $this_subchapter , 5, $question_num, $answer , $correct)";
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
	$sqlretrievestring = 'SELECT * FROM EDUCATION_TABLE WHERE USER_ID=' . $user_id . ' AND CHAPTER = ' . $this_chapter . ' AND LESSON = ' . $this_subchapter . ' AND EXERCISE = 5' ;
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
		<div class="process-wizard-info text-center">Lesson I</div>
	</div>
	<div class="col-md-1 process-wizard-step active"> <!-- complete active disabled -->
		<div class="text-center process-wizard-stepnum">&nbsp;</div>
		<div class="progress"><div class="progress-bar"></div></div>
		<a href="#" class="process-wizard-dot"></a>
		<div class="process-wizard-info text-center">Lesson II</div>
	</div>
	<div class="col-md-1 process-wizard-step disabled"> <!-- complete active disabled -->
		<div class="text-center process-wizard-stepnum">&nbsp;</div>
		<div class="progress"><div class="progress-bar"></div></div>
		<a href="#" class="process-wizard-dot"></a>
		<div class="process-wizard-info text-center">Lesson III</div>
	</div>
	<div class="col-md-1 process-wizard-step disabled"> <!-- complete active disabled -->
		<div class="text-center process-wizard-stepnum">Chapter 2</div>
		<div class="progress"><div class="progress-bar"></div></div>
		<a href="#" class="process-wizard-dot"></a>
		<div class="process-wizard-info text-center">&nbsp;</div>
	</div>
	<div class="col-md-1 process-wizard-step disabled"> <!-- complete active disabled -->
		<div class="text-center process-wizard-stepnum">Chapter 3</div>
		<div class="progress"><div class="progress-bar"></div></div>
		<a href="#" class="process-wizard-dot"></a>
		<div class="process-wizard-info text-center">&nbsp;</div>
	</div>
	<div class="col-md-1 process-wizard-step disabled"> <!-- complete active disabled -->
		<div class="text-center process-wizard-stepnum">Chapter 4</div>
		<div class="progress"><div class="progress-bar"></div></div>
		<a href="#" class="process-wizard-dot"></a>
		<div class="process-wizard-info text-center">&nbsp;</div>
	</div>
	<div class="col-md-1 process-wizard-step disabled"> <!-- complete active disabled -->
		<div class="text-center process-wizard-stepnum">Chapter 5</div>
		<div class="progress"><div class="progress-bar"></div></div>
		<a href="#" class="process-wizard-dot"></a>
		<div class="process-wizard-info text-center">&nbsp;</div>
	</div>
	<div class="col-md-1 process-wizard-step disabled"> <!-- complete active disabled -->
		<div class="text-center process-wizard-stepnum">Chapter 6</div>
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

<h1><span>II. Solving problems with AI</span></h1>
<h3>Interlude on the history of AI: starting from search</h3>

<p class="fs-18">AI is arguably as old as computer science. Long before we had computers, people thought of the possibility of automatic reasoning and intelligence. As we already mentioned in Chapter 1, one of the great thinkers who considered this question was Alan Turing. In addition to the Turing test, his contributions to AI, and more generally to computer science, include the insight that anything that can be computed (= calculated using either numbers or other symbols) can be automated.</p>

<div class="card card-default">
	<div class="card-block">
		<p class="fs-14">Note</p>
		<h4><span>Helping win WWII</span></h4>
		<p class="fs-18">Turing designed a very simple device that can compute anything that is computable. His device is known as the Turing machine. While it is a theoretical model that isn’t practically useful, it lead Turing to the invention of programmable computers: computers that can be used to carry out different tasks depending on what they were programmed to do.</p>
		<p class="fs-18">So instead of having to build a different device for each task, we use the same computer for many tasks. This is the idea of programming. Today this invention sounds trivial but in Turing’s days it was far from it. Some of the early programmable computers were used during World War II to crack German secret codes, a project where Turing was also personally involved.</p>
	</div>
</div>

<p class="fs-18">The term Artificial Intelligence is often attributed to John McCarthy (1927-2011) – who is often also referred to as the Father of AI – but in fact he denies coming up with the term. He was nevertheless influential in its adoption as the name for the emerging field. The term became established when it was chosen as the topic of a summer seminar, known as the <a href="https://en.wikipedia.org/wiki/Dartmouth_workshop">Dartmouth conference</a>, which was organized by McCarthy and held in 1956 at Dartmouth College in New Hampshire. In the proposal to organize the seminar, McCarthy continued with Turing's argument about automated computation. The proposal contains the following crucial statement:</p>

<div class="card card-default">
	<div class="card-block">
		<p class="fs-14">Note</p>
		<h4><span>John McCarthy’s key statement about AI</span></h4>
		<p class="fs-18">“The study is to proceed on the basis of the conjecture that every aspect of learning or any other feature of intelligence can in principle be so precisely described that a machine can be made to simulate it.”</p>
	</div>
</div>

<p class="fs-18">In other words, any element of intelligence can be broken down into small steps so that each of the steps is as such so simple and “mechanical” that it can be written down as a computer program. This statement was, and is still today, a conjecture, which means that we can’t really prove it to be true. Nevertheless, the idea is absolutely fundamental when it comes to the way we think about AI. For example, it shows that McCarthy wanted to bypass any arguments in the spirit of Searle's Chinese Room: intelligence is intelligence even if the system that implements it is just a computer that mechanically follows a program.</p>

<h3>Why search and games became central in AI research</h3>

<p class="fs-18">As computers developed to the level where it was feasible to experiment with practical AI algorithms in the 1950s, the most distinctive AI problems (besides cracking Nazi codes) were games. Games provided a convenient restricted domain that could be formalized easily. Board games such as checkers, chess, and recently quite prominently Go (an extremely complex strategy board game originating from China at least 2500 years ago), have inspired countless researchers, and continue to do so.</p>
<p class="fs-18">Closely related to games, search and planning techniques were an area where AI lead to great advances in the 1960s: algorithms with names such as the Minimax algorithm or Alpha-Beta Pruning, which were developed then are still the basis for game playing AI, although of course more advanced variants have been proposed over the years. In this chapter, we will study games and planning problems on a conceptual level.</p>


<?php //create dummy entry with exercise=7 because there isn't one. will be deleted at next chapter
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
$sqlretrievestring = 'DELETE FROM EDUCATION_TABLE WHERE USER_ID=' . $user_id . ' AND CHAPTER = ' . $this_chapter . ' AND LESSON = ' . $this_subchapter . ' AND EXERCISE = 7' ;
mysqli_query($connection, $sqlretrievestring);
$sql="INSERT INTO `42_schema`.`EDUCATION_TABLE` (`USER_ID`, `CHAPTER`, `LESSON`, `EXERCISE`, `QUESTION`, `ANSWER`, `CORRECT` ) VALUES ($user_id, $this_chapter, $this_subchapter , 7, 1, 1 , 1)";
//loop through provided answers and save them:
if ($connection->query($sql) === TRUE) {} else {echo "Error: " . $sql . "<br>" . $connection->error;}
$connection->close();
?>





</div>
</div>
<!-- UP NEXT -->
<div class="card card-default">
	<div class="card-block">
		<h3>Next:</h3>
		<h1>III. Search and Games&nbsp;&nbsp;&nbsp;
			<?php echo '<a href="42_education_2_3.php"><button type="button" class="btn btn-primary btn-lg">&nbsp;&nbsp;&nbsp;CONTINUE&nbsp;&nbsp;&nbsp;</button></a>'; ?>


			
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