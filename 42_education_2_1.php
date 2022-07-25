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
$questions_string = array("Number of transitions");
$questions_options = array("4","5","6","7","8","9","10","11","12");
$questions_correct = array(array(4));
$questions_correct_hint = array("The correct answer is 7. There are two shortest paths that lead from the start NNNN to the goal FFFF. One of them is NNNN -> FNFN -> NNFN -> FFFN -> NFNN -> FFNF -> NFNF -> FFFF, and the other NNNN -> FNFN -> NNFN -> FNFF -> NNNF -> FFNF -> NFNF -> FFFF. Intuitively, the strategy is to move the chicken on the other side first, and then go back get either the fox or the feed, and take it to the far side too. The robot then takes the chicken back to the near side to save it from being eaten or from eating the feed, and takes the other remaining object (fox or feed) from the near side to the far side. Finally, the robot goes to fetch the chicken and takes it to the far side to reach the goal.");

$questions_string_2 = array(
	"What state should be in box 1?",
	"What state should be in box 2?",
	"What state should be in box 3?",
	"What state should be in box 4?",
	"What state should be in box 5?",
	"What state should be in box 6?");
//answering options:
$questions_options_2 = array("A", "B", "C", "D", "E", "F"); // =1, =2, =3, etc.
//correct answers:
$questions_correct_2 = array(array(5),array(2,6),array(2,6),array(4),array(1,3),array(1));
//answers comments:
$questions_correct_hint_2 = array(
	"State E is the only option that is reachable from the left box on the second row.",
	"Since box 1 contains state E, there are two possibilities for box 2: states B and F. Choosing state F in box 2 would lead to a dead-end at box 5, so the correct option must be state B. Also note that box 2 has two transitions to other states, which implies that it must be a state where the two discs are on top of each other.",
	"Since box 1 contains state E, there are two possibilities for box 3: states B and F. Choosing state B would lead to a dead end in box 5, so the correct choice must be state F.",
	"State D is the only option that is reachable from the right box on the second row.",
	". Since box 4 contains state D, there are two possibilities for box 5: states A and C. Choosing state A would lead to a dead end in box 3, so the correct choice must be state C.",
	"The final state is State A"
	);

//entered answers (form post): *************************************************************************************************************************
$answers = array($_POST['0']);
$answers_2 = array($_POST['1'],$_POST['2'],$_POST['3'],$_POST['4'],$_POST['5'],$_POST['6']);

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
if ($answers_2[0]<>''){
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
	$sqlretrievestring = 'DELETE FROM EDUCATION_TABLE WHERE USER_ID=' . $user_id . ' AND CHAPTER = ' . $this_chapter . ' AND LESSON = ' . $this_subchapter . ' AND EXERCISE = 6' ;
	mysqli_query($connection, $sqlretrievestring);
	//loop through provided answers and save them:
	$question_num = 1;
	foreach($answers_2 AS $answer_2) {
		$correct = -1;
		if (in_array($answer_2,$questions_correct_2[$question_num-1])) {$correct = 1;}
		$sql="INSERT INTO `42_schema`.`EDUCATION_TABLE` (`USER_ID`, `CHAPTER`, `LESSON`, `EXERCISE`, `QUESTION`, `ANSWER`, `CORRECT` ) VALUES ($user_id, $this_chapter, $this_subchapter , 6, $question_num, $answer_2 , $correct)";
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
	$sqlretrievestring_2 = 'SELECT * FROM EDUCATION_TABLE WHERE USER_ID=' . $user_id . ' AND CHAPTER = ' . $this_chapter . ' AND LESSON = ' . $this_subchapter . ' AND EXERCISE = 6' ;
	$result_2 = mysqli_query($connection, $sqlretrievestring_2);
	$all_property_2 = array();  //declare an array for saving property
	while ($property_2 = mysqli_fetch_field($result_2)) {
			array_push($all_property_2, $property_2->name);  //save those to array
			}
	//loop through all of them:
	$answers_2 = array();
	while ($row_2 = mysqli_fetch_array($result_2)) {
		array_push($answers_2, $row_2['ANSWER']);
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
$count_correct_2 = 0;
$count_total_2 = 0;
foreach($answers_2 AS $answer_2) {
	if (in_array($answer_2,$questions_correct_2[$count_total_2])) {$count_correct_2 = $count_correct_2 + 1;}
  	$count_total_2 = $count_total_2 + 1;
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
		<img src="assets/images/course_2_1.jpg" class="img-fluid"  alt="...">
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
	<div class="col-md-1 process-wizard-step active"> <!-- complete active disabled -->
		<div class="text-center process-wizard-stepnum">Chapter 2</div>
		<div class="progress"><div class="progress-bar"></div></div>
		<a href="#" class="process-wizard-dot"></a>
		<div class="process-wizard-info text-center">Lesson I</div>
	</div>
	<div class="col-md-1 process-wizard-step disabled"> <!-- complete active disabled -->
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

<h1><span>I. Search and problem solving</span></h1>
<h3>Many problems can be phrased as search problems. This requires that we start by formulating the alternative choices and their consequences.</h3>
<h3>Search in practice: getting from A to B</h3>

<p class="fs-18">Imagine you’re in a foreign city, at some address (say a hotel) and want to use public transport to get to another address (a nice restaurant, perhaps). What do you do? If you are like many people, you pull out your smartphone, type in the destination and start following the instructions.</p>

<p class="fs-18">This question belongs to the class of search and planning problems. Similar problems need to be solved by self-driving cars, and (perhaps less obviously) AI for playing games. In the game of chess, for example, the difficulty is not so much in getting a piece from A to B as keeping your pieces safe from the opponent.</p>

<img src="assets/images/img_2_1_1.svg" class="img-fluid"  alt="...">

<p class="fs-18">Often there are many different ways to solve the problem, some of which may be more preferable in terms of time, effort, cost or other criteria. Different search techniques may lead to different solutions, and developing advanced search algorithms is an established research area.</p>

<img src="assets/images/img_2_1_2.svg" class="img-fluid"  alt="...">

<p class="fs-18">We will not focus on the actual search algorithms. Instead, we emphasize the first stage of the problem solving process: defining the choices and their consequences, which is often far from trivial and can require careful thinking. We also need to define what our goal is, or in other words, when we can consider the problem solved. After this has been done, we can look for a sequence of actions that leads from the initial state to the goal.</p>

<p class="fs-18">In this chapter, we will discuss two kinds of problems:</p>

<li class="fs-18">Search and planning in static environments with only one “agent”</li>
<li class="fs-18">Games with two-players (“agents”) competing against each other</li><br>

<p class="fs-18">These categories don’t cover all possible real-world scenarios, but they are generic enough to demonstrate the main concepts and techniques.</p>
<p class="fs-18">Before we address complex search tasks like navigation or playing chess, let us start from a much simplified model in order to build up our understanding of how we can solve problems by AI.</p>

<h3>Toy problem: chicken crossing</h3>

<p class="fs-18">We’ll start from a simple puzzle to illustrate the ideas. A robot on a rowboat needs to move three pieces of cargo across a river: a fox, a chicken, and a sack of chicken-feed. The fox will eat the chicken if it has the chance, and the chicken will eat the chicken-feed if it has the chance, and neither is a desirable outcome. The robot is capable of keeping the animals from doing harm when it is near them, but only the robot can operate the rowboat and only two of the pieces of cargo can fit on the rowboat together with the robot. How can the robot move all of its cargo to the opposite bank of the river?</p>

<div class="card card-default">
	<div class="card-block">
		<p class="fs-14">Note</p>
		<h4><span>The easy version of the rowboat puzzle</span></h4>
		<p class="fs-18">If you have heard this riddle before, you might know that it can be solved even with less space on the boat. That will be an exercise for you after we solve this easier version together.</p>
	</div>
</div>

<p class="fs-18">We will model the puzzle by noting that five movable things have been identified: the robot, the rowboat, the fox, the chicken, and the chicken-feed. In principle, each of the five can be on either side of the river, but since only the robot can operate the rowboat, the two will always be on the same side. Thus there are four things with two possible positions for each, which makes for sixteen combinations, which we will call states:</p>

<h4>States of the chicken crossing puzzle</h4>

<div class="table-responsive">
	<table class="table table-hover font-lato fs-12 table-light">
		<thead>
			<td><strong>State</strong></td>
			<td><strong>Robot</strong></td>
			<td><strong>Fox</strong></td>
			<td><strong>Chicken</strong></td>
			<td><strong>Chicken-feed</strong></td>
		</thead>
		<tbody>
			<tr><td>NNNN</td><td>Near side</td><td>Near side</td><td>Near side</td><td>Near side</td></tr>
			<tr><td>NNNF</td><td>Near side</td><td>Near side</td><td>Near side</td><td>Far side</td></tr>
			<tr><td>NNFN</td><td>Near side</td><td>Near side</td><td>Far side</td><td>Near side</td></tr>
			<tr><td>NNFF</td><td>Near side</td><td>Near side</td><td>Far side</td><td>Far side</td></tr>
			<tr><td>NFNN</td><td>Near side</td><td>Far side</td><td>Near side</td><td>Near side</td></tr>
			<tr><td>NFNF</td><td>Near side</td><td>Far side</td><td>Near side</td><td>Far side</td></tr>
			<tr><td>NFFN</td><td>Near side</td><td>Far side</td><td>Far side</td><td>Near side</td></tr>
			<tr><td>NFFF</td><td>Near side</td><td>Far side</td><td>Far side</td><td>Far side</td></tr>
			<tr><td>FNNN</td><td>Far side</td><td>Near side</td><td>Near side</td><td>Near side</td></tr>
			<tr><td>FNNF</td><td>Far side</td><td>Near side</td><td>Near side</td><td>Far side</td></tr>
			<tr><td>FNFN</td><td>Far side</td><td>Near side</td><td>Far side</td><td>Near side</td></tr>
			<tr><td>FNFF</td><td>Far side</td><td>Near side</td><td>Far side</td><td>Far side</td></tr>
			<tr><td>FFNN</td><td>Far side</td><td>Far side</td><td>Near side</td><td>Near side</td></tr>
			<tr><td>FFNF</td><td>Far side</td><td>Far side</td><td>Near side</td><td>Far side</td></tr>
			<tr><td>FFFN</td><td>Far side</td><td>Far side</td><td>Far side</td><td>Near side</td></tr>
			<tr><td>FFFF</td><td>Far side</td><td>Far side</td><td>Far side</td><td>Far side</td></tr>
		</tbody>
	</table>
</div>

<p class="fs-18">We have given short names to the states, because otherwise it would be cumbersome to talk about them. Now we can say that the starting state is NNNN and the goal state is FFFF, instead of something like “in the starting state, the robot is on the near side, the fox is on the near side, the chicken is on the near side, and also the chicken-feed is on the near side, and in the goal state the robot is on the far side”, and so on.</p>
<p class="fs-18">Some of these states are forbidden by the puzzle conditions. For example, in state NFFN (meaning that the robot is on the near side with the chicken-feed but the fox and the chicken are on the far side), the fox will eat the chicken, which we cannot have. Thus we can rule out states NFFN, NFFF, FNNF, FNNN, NNFF, and FFNN (you can check each one if you doubt our reasoning). We are left with the following ten states:</p>

<div class="table-responsive">
	<table class="table table-hover font-lato fs-12 table-light">
		<thead>
			<td><strong>State</strong></td>
			<td><strong>Robot</strong></td>
			<td><strong>Fox</strong></td>
			<td><strong>Chicken</strong></td>
			<td><strong>Chicken-feed</strong></td>
		</thead>
		<tbody>
			<tr><td>NNNN</td><td>Near side</td><td>Near side</td><td>Near side</td><td>Near side</td></tr>
			<tr><td>NNNF</td><td>Near side</td><td>Near side</td><td>Near side</td><td>Far side</td></tr>
			<tr><td>NNFN</td><td>Near side</td><td>Near side</td><td>Far side</td><td>Near side</td></tr>
			<tr><td>NFNN</td><td>Near side</td><td>Far side</td><td>Near side</td><td>Near side</td></tr>
			<tr><td>NFNF</td><td>Near side</td><td>Far side</td><td>Near side</td><td>Far side</td></tr>
			<tr><td>FNFN</td><td>Far side</td><td>Near side</td><td>Far side</td><td>Near side</td></tr>
			<tr><td>FNFF</td><td>Far side</td><td>Near side</td><td>Far side</td><td>Far side</td></tr>
			<tr><td>FFNF</td><td>Far side</td><td>Far side</td><td>Near side</td><td>Far side</td></tr>
			<tr><td>FFFN</td><td>Far side</td><td>Far side</td><td>Far side</td><td>Near side</td></tr>
			<tr><td>FFFF</td><td>Far side</td><td>Far side</td><td>Far side</td><td>Far side</td></tr>
		</tbody>
	</table>
</div>

<p class="fs-18">Next we will figure out which state transitions are possible, meaning simply that as the robot rows the boat with some of the items as cargo, what the resulting state is in each case. It’s best to draw a diagram of the transitions, and since in any transition the first letter alternates between N and F, it is convenient to draw the states starting with N (so the robot is on the near side) in one row and the states starting with F in another row:</p>
<img src="assets/images/img_2_1_3.svg" class="img-fluid"  alt="..."><br><br>
<p class="fs-18">Now let's draw the transitions. We could draw arrows that have a direction so that they point from one node to another, but in this puzzle the transitions are symmetric: if the robot can row from state NNNN to state FNFF, it can equally well row the other way from FNFF to NNNN. Thus it is simpler to draw the transitions simply with lines that don't have a direction. Starting from NNNN, we can go to FNFN, FNFF, FFNF, and FFFN:</p>
<img src="assets/images/img_2_1_4.svg" class="img-fluid"  alt="..."><br><br>
<p class="fs-18">Then we fill in the rest:</p>
<img src="assets/images/img_2_1_5.svg" class="img-fluid"  alt="..."><br><br>
<p class="fs-18">We have now done quite a bit of work on the puzzle without seeming any closer to the solution, and there is little doubt that you could have solved the whole puzzle already by using your “natural intelligence”. But for more complex problems, where the number of possible solutions grows in the thousands and in the millions, our systematic or mechanical approach will shine since the hard part will be suitable for a simple computer to do. Now that we have formulated the alternative states and transitions between them, the rest becomes a mechanical task: find a path from the initial state NNNN to the final state FFFF.</p>
<p class="fs-18">One such path is colored in the following picture. The path proceeds from NNNN to FFFN (the robot takes the fox and the chicken to the other side), thence to NFNN (the robot takes the chicken back on the starting side) and finally to FFFF (the robot can now move the chicken and the chicken-feed to the other side).</p>
<img src="assets/images/img_2_1_6.svg" class="img-fluid"  alt="..."><br><br>

<h3>State space, transitions, and costs</h3>
<p class="fs-18">To formalize a planning problem, we use concepts such as the state space, transitions, and costs.</p>
<div class="card card-default">
	<div class="card-block">
		<p class="fs-14">Key terminology</p>
		<h4><span>The state space</span></h4>
		<p class="fs-18">means the set of possible situations. In the chicken-crossing puzzle, the state space consisted of ten allowed states NNNN through to FFFF (but not for example NFFF, which the puzzle rules don´t allow). If the task is to navigate from place A to place B, the state space could be the set of locations defined by their (x,y) coordinates that can be reached from the starting point A. Or we could use a constrained set of locations, for example, different street addresses so that the number of possible states is limited.</p>
		<h4><span>Transitions</span></h4>
		<p class="fs-18">are possible moves between one state and another, such as NNNN to FNFN. It is important to note that we only count direct transitions that can be accomplished with a single action as transitions. A sequence of multiple transitions, for example, from A to C, from C to D, and from D to B (the goal), is a path rather than a transition.</p>
		<h4><span>Costs</span></h4>
		<p class="fs-18">refer to the fact that, oftentimes the different transitions aren´t all alike. They can differ in ways that make some transitions more preferable or cheaper (in a not necessarily monetary sense of the word) and others more costly. We can express this by associating with each transition a certain cost. If the goal is to minimize the total distance traveled, then a natural cost is the geographical distance between states. On the other hand, the goal could actually be to minimize the time instead of the distance, in which case the natural cost would obviously be the time. If all the transitions are equal, then we can ignore the costs.</p>
	</div>
</div>


</div>

<!-- EXERCISE -->
<div class="callout alert alert-default">
	<div class="row">
		<div class="col-md-2" valign="top">
		</div>
		<div class="col-md-7 col-sm-8"><!-- left text -->
			<h1><span>Exercise 5: A smaller rowboat</span></h1>
			<p class="fs-18">In the traditional version of this puzzle the robot can only fit one thing on the boat with it. The state space is still the same, but fewer transitions are possible.</p><br>
			<p class="fs-18"><strong>Using the diagram with the possible states below as a starting point, draw the possible transitions in it</strong> (it is MUCH easier to do this with a pencil and paper than without).</p><br>
			<p class="fs-18">Having drawn the state transition diagram, <strong>find the shortest path from NNNN to FFFF, and calculate the number of transitions on it.</strong></p><br>
			<p class="fs-18">Having drawn the state transition diagram, <strong>find the shortest path from NNNN to FFFF, and calculate the number of transitions on it.</strong></p><br>
			<p class="fs-18">Please choose your answer as the <strong>number of transitions in the shortest path</strong>.<br><br>Hint: Do not count the number of states, but the number of transitions. For example, the number of transitions in the path NNNN→FFNF→NFNF→FFFF is 3 instead of 4.</p><br><br>
			<img src="assets/images/exercise5.svg" class="img-fluid"  alt="..."><br><br>
			

		</div>
		<div class="col-md-3" valign="top">
		</div>
	</div>
</div>

<div class="card card-default" id="exercise5">
	<div class="card-block">
		<p class="fs-14">Answer the questions below</p>
		
<form class="m-0" method="post" action="#exercise5" autocomplete="off">
	<!-- QUESTIONS -->
	<?php
		$elem = 0; 
		foreach($questions_string AS $question) {
			echo '<div class="row border-bottom">
					<div class="col-md-3" valign="top"><p class="fs-18">' . $question . '</p></div>';
			
			$ans = 1;
			foreach($questions_options AS $option) {
				echo '<div class="col-md-1" valign="top" align="center">';
				// answer was provided:
				 if ($answers[$elem]<>'') {
				 	$pot_cor = 0; if (in_array($ans, $questions_correct[$elem])) {$pot_cor = 1;}
				 	$cor = 0; if (in_array($answers[$elem], $questions_correct[$elem])) {$cor = 1;}
				 	if (($pot_cor==0) & ($answers[$elem]==$ans)) {echo '<button type="button" class="btn btn-outline-danger disabled">'.$option.'</button>';}
				 	if (($pot_cor==0) & ($answers[$elem]<>$ans)) {echo '<button type="button" class="btn disabled">'.$option.'</button>';}
				 	if (($pot_cor==1) & ($cor==1)) {echo '<button type="button" class="btn btn-outline-success disabled">'.$option.'</button>';}
				 	if (($pot_cor==1) & ($cor==0)) {echo '<button type="button" class="btn btn-outline-success disabled">'.$option.'</button>';}

				 }
				 // no answer was provided, show radio:
				 else {echo '<input type="radio" name="'.$elem.'" value="'.$ans.'" required> '.$option;}
				 echo '</div>';
				 $ans = $ans + 1;
			}
			
			
			if (($answers[$elem]<>'') & (in_array($answers[$elem], $questions_correct[$elem]))) {echo '<div class="alert alert-success mb-30 col-md-12"><strong>Well done!</strong>&nbsp;&nbsp;'.$questions_correct_hint[$elem].'</div>';} 
			if (($answers[$elem]<>'') & (in_array($answers[$elem], $questions_correct[$elem])==false)) {echo '<div class="alert alert-danger mb-30 col-md-12"><strong>Oh snap!</strong>&nbsp;&nbsp;'.$questions_correct_hint[$elem].'</div>';} 

			echo '</div>';
			$elem = $elem + 1;
		}
	?>
	

	


	<div class="col-md-12 text-center">
		<?php 
		//only logged in users can submit:
			if (($usertype==8) or ($usertype==9)){
				if ($answers[0]==''){echo '<button class="btn btn-primary">SUBMIT</button>';} 
				else {echo '<strong>'.$count_correct . ' correct answers (out of '.$count_total.')</strong>';} 
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

<!-- EXERCISE -->
<div class="callout alert alert-default">
	<div class="row">
		<div class="col-md-2" valign="top">
		</div>
		<div class="col-md-7 col-sm-8"><!-- left text -->
			<h1><span>Exercise 6: The Towers of Hanoi</span></h1>
			<p class="fs-18">Let's do another puzzle: the well-known <a href="https://www.britannica.com/topic/Tower-of-Hanoi">Towers of Hanoi</a>. In our version, the puzzle involves three pegs, and two discs: one large, and one small (actually, there can be any number of discs but for the exercise, two is enough to demonstrate the principle).</p><br>
			<p class="fs-18">In the initial state, both discs are stacked in the first (leftmost) peg. The goal is to move the discs to the third peg. You can move one disc at a time, from any peg to another, as long as there is no other disc on top of it. It is not allowed to put a larger disc on top of a smaller disc.</p><br>
			<p class="fs-18">This picture shows the initial state and the goal state. There are also seven other states so that the total number of possible states is nine: three ways to place the large disc and for each of them, three ways to place the small disc.</p><br>
			<img src="assets/images/exercise6.svg" class="img-fluid"  alt="..."><br><br>
			<p class="fs-18"><strong>Your task:</strong> Draw the state diagram. The diagram should include all the nine possible states in the game, connected by lines that show the possible transitions. The picture below shows the overall structure of the state diagram and the positions of the first three states. It shows that from the starting state (at the top corner), you can move to two other states by moving the small disc. Complete the state diagram by placing the remaining states in the correct places. Note that the transitions are again symmetric and you can also move sideways (left or right) or up in the diagram.</p><br>
			<p class="fs-18">After solving the task using pen and paper, enter your solution by choosing which state belongs to which node in the diagram. (Hint: Each state belongs to exactly one node).</p><br>
			<img src="assets/images/exercise6_2.svg" class="img-fluid"  alt="..."><br><br>
			<p class="fs-18"><strong>Choose for each node (1–6) in the above diagram the correct state A—F from below.</strong></p><br>
			<img src="assets/images/exercise6_3.svg" class="img-fluid"  alt="..."><br><br>
			

		</div>
		<div class="col-md-3" valign="top">
		</div>
	</div>
</div>

<div class="card card-default" id="exercise6">
	<div class="card-block">
		<p class="fs-14">Answer the questions below</p>
		
	
<form class="m-0" method="post" action="#exercise6" autocomplete="off">
	<!-- QUESTIONS -->
	<?php
		// old form params:
		$elem = 0;
		foreach($answers AS $answer) {
			echo '<input type="hidden" name="'.$elem.'" value="'.$answer[$elem].'" >';
			$elem = $elem + 1;
		}

		//now the new stuff:
		$elem = 0; 
		foreach($questions_string_2 AS $question) {
			echo '<div class="row border-bottom">
					<div class="col-md-5" valign="top"><p class="fs-18">' . $question . '</p></div>';
			
			$ans = 1;
			foreach($questions_options_2 AS $option) {
				echo '<div class="col-md-1" valign="top" align="center">';
				// answer was provided:
				 if ($answers_2[$elem]<>'') {
				 	$pot_cor = 0; if (in_array($ans, $questions_correct_2[$elem])) {$pot_cor = 1;}
				 	$cor = 0; if (in_array($answers_2[$elem], $questions_correct_2[$elem])) {$cor = 1;}
				 	if (($pot_cor==0) & ($answers_2[$elem]==$ans)) {echo '<button type="button" class="btn btn-outline-danger disabled">'.$option.'</button>';}
				 	if (($pot_cor==0) & ($answers_2[$elem]<>$ans)) {echo '<button type="button" class="btn disabled">'.$option.'</button>';}
				 	if (($pot_cor==1) & ($cor==1)) {echo '<button type="button" class="btn btn-outline-success disabled">'.$option.'</button>';}
				 	if (($pot_cor==1) & ($cor==0)) {echo '<button type="button" class="btn btn-outline-success disabled">'.$option.'</button>';}

				 }
				 // no answer was provided, show radio:
				 else {$elem_2 = $elem+1; echo '<input type="radio" name="'.$elem_2.'" value="'.$ans.'" required> '.$option;}
				 echo '</div>';
				 $ans = $ans + 1;
			}
			
			
			if (($answers_2[$elem]<>'') & (in_array($answers_2[$elem], $questions_correct_2[$elem]))) {echo '<div class="alert alert-success mb-30 col-md-12"><strong>Well done!</strong>&nbsp;&nbsp;'.$questions_correct_hint_2[$elem].'</div>';} 
			if (($answers_2[$elem]<>'') & (in_array($answers_2[$elem], $questions_correct_2[$elem])==false)) {echo '<div class="alert alert-danger mb-30 col-md-12"><strong>Oh snap!</strong>&nbsp;&nbsp;'.$questions_correct_hint_2[$elem].'</div>';} 

			echo '</div>';
			$elem = $elem + 1;
		}
	?>
	
	


	<div class="col-md-12 text-center">
		<?php 
		//only logged in users can submit:
			if (($usertype==8) or ($usertype==9)){
				if ($answers_2[0]==''){echo '<button class="btn btn-primary">SUBMIT</button>';} 
				else {echo '<strong>'.$count_correct_2 . ' correct answers (out of '.$count_total_2.')</strong>';} 
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
</div>


<!-- /EXERCISE -->

<!-- UP NEXT -->
<div class="card card-default">
	<div class="card-block">
		<h3>Next:</h3>
		<h1>II. Solving Problems with AI&nbsp;&nbsp;&nbsp;
			<?php if ($answers[0]==''){echo '<a href=""><button type="button" class="btn btn-btn-secondary btn-lg" disabled>&nbsp;&nbsp;&nbsp;CONTINUE&nbsp;&nbsp;&nbsp;</button></a>';} 
							else {echo '<a href="42_education_2_2.php"><button type="button" class="btn btn-primary btn-lg">&nbsp;&nbsp;&nbsp;CONTINUE&nbsp;&nbsp;&nbsp;</button></a>';} ?>


			
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