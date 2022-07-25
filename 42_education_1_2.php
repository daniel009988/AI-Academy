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
$this_chapter    = 1;
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

//QUESTIONAIRE BLOCK **************************************************************************************************************
$questions_string = array(
	"Where would you put AI?",
	"Where would you put machine learning?",
	"Where would you put computer science?",
	"Where would you put data science?",
	"Where would you put deep learning?"
	);
$questions_string_2 = array(
	"Autonomous car",
	"Steering a rocket into orbit",
	"Online ad optimization",
	"Customer service chatbot",
	"Summarizing gallup results"
	);
//answering options:
$questions_options = array("Section A", "Section B", "Section C", "Section D", "Section E"); // =1, =2, =3, etc.
$questions_options_2 = array("Statistics", "Robotics", "Machine learning"); // =1, =2, =3, etc.
//correct answers:
$questions_correct = array(array(2),array(3),array(1),array(5),array(4));
$questions_correct_2 = array(array(1,2,3),array(2),array(1,3),array(3),array(1));
//answers comments:
$questions_correct_hint = array(
	"AI is a part of computer science.",
	"Machine learning is usually considered to be a part of AI.",
	"Computer science is a relatively broad field that includes AI but also other subfields such as distributed computing, human-computer interaction, and software engineering.",
	"Data science needs computer science and AI. However, it also involves a lot of statistics, business, law, and other application domains, so it is usually not considered to be a part of computer science.",
	"Deep learning is a part of machine learning."
	);
$questions_correct_hint_2 = array(
	"Autonomous cars apply a wide range of techniques to function. These include statistics, robotics, and machine learning.",
	"In order to steer a rocket into orbit robotics are needed to fire the engines at the right times and with the right power.",
	"In order to optimize ads online, machine learning and statistics are needed to deliver the correct type of ads to the right audience, and to measure the effectiveness of the optimization.",
	"A customer service chatbot will need machine learning to process human produced language in such a way that it can act on it.",
	"Summarizing gallup results is a classical case of using statistics to produce insights."
	);

//entered answers (form post): *************************************************************************************************************************
$answers = array($_POST['0'],$_POST['1'],$_POST['2'],$_POST['3'],$_POST['4']);
$answers_2 = array($_POST['5'],$_POST['6'],$_POST['7'],$_POST['8'],$_POST['9']);

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
	$sqlretrievestring = 'DELETE FROM EDUCATION_TABLE WHERE USER_ID=' . $user_id . ' AND CHAPTER = ' . $this_chapter . ' AND LESSON = ' . $this_subchapter . ' AND EXERCISE = 2' ;
	mysqli_query($connection, $sqlretrievestring);
	//loop through provided answers and save them:
	$question_num = 1;
	foreach($answers AS $answer) {
		$correct = -1;
		if (in_array($answer,$questions_correct[$question_num-1])) {$correct = 1;}
		$sql="INSERT INTO `42_schema`.`EDUCATION_TABLE` (`USER_ID`, `CHAPTER`, `LESSON`, `EXERCISE`, `QUESTION`, `ANSWER`, `CORRECT` ) VALUES ($user_id, $this_chapter, $this_subchapter , 2, $question_num, $answer , $correct)";
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
	$sqlretrievestring = 'DELETE FROM EDUCATION_TABLE WHERE USER_ID=' . $user_id . ' AND CHAPTER = ' . $this_chapter . ' AND LESSON = ' . $this_subchapter . ' AND EXERCISE = 3' ;
	mysqli_query($connection, $sqlretrievestring);
	//loop through provided answers and save them:
	$question_num = 1;
	foreach($answers_2 AS $answer_2) {
		$correct = -1;
		if (in_array($answer_2,$questions_correct_2[$question_num-1])) {$correct = 1;}
		$sql="INSERT INTO `42_schema`.`EDUCATION_TABLE` (`USER_ID`, `CHAPTER`, `LESSON`, `EXERCISE`, `QUESTION`, `ANSWER`, `CORRECT` ) VALUES ($user_id, $this_chapter, $this_subchapter , 3, $question_num, $answer_2 , $correct)";
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
	$sqlretrievestring = 'SELECT * FROM EDUCATION_TABLE WHERE USER_ID=' . $user_id . ' AND CHAPTER = ' . $this_chapter . ' AND LESSON = ' . $this_subchapter . ' AND EXERCISE = 2' ;
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
	$sqlretrievestring_2 = 'SELECT * FROM EDUCATION_TABLE WHERE USER_ID=' . $user_id . ' AND CHAPTER = ' . $this_chapter . ' AND LESSON = ' . $this_subchapter . ' AND EXERCISE = 3' ;
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

// END OF QUESTIONAIRE-BLOCK **************************************************************************************************************

// finally include menu:
include '42_education_include_menu.php';
?>


<!-- Main AREA -->



<!-- LEADING IMAGE -->
<div class="row">
	<div class="col-md-12" valign="top">
		<!--<img src="assets/images/course_1_1.jpg" class="img-fluid"  alt="..."> -->
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

<h1><span>II. Related fields</span></h1>
<h3>In addition to AI, there are several other closely related topics that are good to know at least by name. These include machine learning, data science, and deep learning.</h3>

<p class="fs-18"><strong>Machine learning</strong> can be said to be a subfield of AI, which itself is a subfield of <strong>computer science</strong> (such categories are often somewhat imprecise and some parts of machine learning could be equally well or better belong to statistics). Machine learning enables AI solutions that are adaptive. A concise definition can be given as follows:</p>

<div class="card card-default">
	<div class="card-block">
		<p class="fs-14">Key terminology</p>
		<h4><span>Machine learning</span></h4>
		<p class="fs-18">Systems that improve their performance in a given task with more and more experience or data.</p>
	</div>
</div>

<p class="fs-18"><strong>Deep learning</strong> is a subfield of machine learning, which itself is a subfield of AI, which itself is a subfield of computer science. We will meet deep learning in some more detail in Chapter 5, but for now let us just note that the “depth” of deep learning refers to the complexity of a mathematical model, and that the increased computing power of modern computers has allowed researchers to increase this complexity to reach levels that appear not only quantitatively but also qualitatively different from before. As you notice, science often involves a number of progressively more special subfields, subfields of subfields, and so on. This enables researchers to zoom into a particular topic so that it is possible to catch up with the ever increasing amount of knowledge accrued over the years, and produce new knowledge on the topic — or sometimes, correct earlier knowledge to be more accurate.</p>
<p class="fs-18"><strong>Data science</strong> is a recent umbrella term (term that covers several subdisciplines) that includes machine learning and statistics, certain aspects of computer science including algorithms, data storage, and web application development. Data science is also a practical discipline that requires understanding of the domain in which it is applied in, for example, business or science: its purpose (what "added value" means), basic assumptions, and constraints. Data science solutions often involve at least a pinch of AI (but usually not as much as one would expect from the headlines).</p>
<p class="fs-18"><strong>Robotics</strong> means building and programming robots so that they can operate in complex, real-world scenarios. In a way, robotics is the ultimate challenge of AI since it requires a combination of virtually all areas of AI. For example:</p>
<li class="fs-18">Computer vision and speech recognition for sensing the environment</li>
<br><li class="fs-18">Natural language processing, information retrieval, and reasoning under uncertainty for processing instructions and predicting consequences of potential actions</li>
<br><li class="fs-18">Cognitive modeling and affective computing (systems that respond to expressions of human feelings or that mimic feelings) for interacting and working together with humans</li>
<br><p class="fs-18">Many of the robotics-related AI problems are best approached by machine learning, which makes machine learning a central branch of AI for robotics.</p>

<div class="card card-default">
	<div class="card-block">
		<p class="fs-14">Note</p>
		<h4><span>What is a robot?</span></h4>
		<p class="fs-18">In brief, a robot is a machine comprising sensors (which sense the environment) and actuators (which act on the environment) that can be programmed to perform sequences of actions. People used to science-fictional depictions of robots will usually think of humanoid machines walking with an awkward gait and speaking in a metallic monotone. Most real-world robots currently in use look very different as they are designed according to the application. Most applications would not benefit from the robot having human shape, just like we don't have humanoid robots to do our dishwashing but machines in which we place the dishes to be washed by jets of water.</p>
		<p class="fs-18">It may not be obvious at first sight, but any kind of vehicles that have at least some level of autonomy and include sensors and actuators are also counted as robotics. On the other hand, software-based solutions such as a customer service chatbot, even if they are sometimes called `software robots´, aren´t counted as (real) robotics.</p>
		
	</div>
</div>




<p class="fs-18"></p>
<p class="fs-18"></p>
<p class="fs-18"></p>
<p class="fs-18"></p>


</div>
<div class="col-md-3" valign="top">
</div>


	
</div>

<!-- EXERCISE -->
<div class="callout alert alert-default">
	<div class="row">
		<div class="col-md-2" valign="top">
		</div>
		<div class="col-md-7 col-sm-8"><!-- left text -->
			<h1><span>Exercise 2: Taxonomy of AI</span></h1>
			<p class="fs-18">A taxonomy is a scheme for classifying many things that may be special cases of one another. We have explained the relationships between a number of disciplines or fields and pointed out, for example, that machine learning is usually considered to be a subfield of AI.</p><br>
			<p class="fs-18">A convenient way to visualize a taxonomy is an Euler diagram. An Euler diagram (closely related to the more familiar Venn diagrams) consists of shapes that corresponds on concepts, which are organized so that overlap between the shapes corresponds to overlap between the concepts (see for example Wikipedia: <a href="https://en.wikipedia.org/wiki/Euler_diagram" target="_">Euler Diagram</a>).</p><br>
			<p class="fs-18">Notice that a taxonomy does not need to be strictly hierarchical. A discipline can be a subfield of more than one more general topic: for example, machine learning can also be thought to be a subfield of statistics. In this case, the subfield concept would be placed in the overlap between the more general topics.</p><br>
			<p class="fs-18"><strong>Your task: Construct a taxonomy in the Euler diagram example given below showing the relationships between the following things: AI, machine learning, computer science, data science, and deep learning.</strong></p>
			<img src="assets/images/exercise2.svg" class="img-fluid"  alt="...">
			

		</div>
		<div class="col-md-3" valign="top">
		</div>
	</div>
</div>

<div class="card card-default" id="exercise2">
	<div class="card-block">
		<p class="fs-14">Answer the questions below</p>
		
	
<form class="m-0" method="post" action="#exercise2" autocomplete="off">
	<!-- QUESTIONS -->
	<?php
		$elem = 0; 
		foreach($questions_string AS $question) {
			echo '<div class="row border-bottom">
					<div class="col-md-7" valign="top"><p class="fs-18">' . $question . '</p></div>';
			
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
			<h1><span>Exercise 3: Examples of tasks</span></h1>
			<p class="fs-18">Consider the following example tasks. Try to determine which AI-related fields are involved in them. <strong>Select all that apply</strong>. (Hint: machine learning involves almost always some kind of statistics).</p><br>
			<p class="fs-18"><strong>Note</strong>: This exercise is meant to inspire you to think about the different aspects of AI and their role in various applications. As there are no clear-cut answers to many of these questions, <strong>this exercise will not be included in the grading</strong>. Nevertheless, we suggest that you do your best and try to answer as well as you can, but don't worry if our answers will differ from yours.</p>
			

		</div>
		<div class="col-md-3" valign="top">
		</div>
	</div>
</div>

<div class="card card-default" id="exercise3">
	<div class="card-block">
		<p class="fs-14">Answer the questions below</p>
		
	
<form class="m-0" method="post" action="#exercise3" autocomplete="off">
	<!-- QUESTIONS -->
	<?php
		// old form params:
		$elem = 0;
		foreach($questions_options AS $option) {
			echo '<input type="hidden" name="'.$elem.'" value="'.$answers[$elem].'" >';
			$elem = $elem + 1;
		}

		//now the new stuff:
		$elem = 0; 
		foreach($questions_string_2 AS $question) {
			echo '<div class="row border-bottom">
					<div class="col-md-6" valign="top"><p class="fs-18">' . $question . '</p></div>';
			
			$ans = 1;
			foreach($questions_options_2 AS $option) {
				echo '<div class="col-md-2" valign="top" align="center">';
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
				 else {$elem_2 = $elem+5; echo '<input type="radio" name="'.$elem_2.'" value="'.$ans.'" required> '.$option;}
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


<!-- /EXERCISE -->

<div class="card card-default">
	<div class="card-block">
		<h3>Next:</h3>
		<h1>III. Philosophy of AI&nbsp;&nbsp;&nbsp;
			<?php if (($answers[0]=='') OR ($answers_2[0]=='')){echo '<a href=""><button type="button" class="btn btn-btn-secondary btn-lg" disabled>&nbsp;&nbsp;&nbsp;CONTINUE&nbsp;&nbsp;&nbsp;</button></a>';} 
							else {echo '<a href="42_education_1_3.php"><button type="button" class="btn btn-primary btn-lg">&nbsp;&nbsp;&nbsp;CONTINUE&nbsp;&nbsp;&nbsp;</button></a>';} ?>
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