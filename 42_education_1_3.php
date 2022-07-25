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
	$sqlretrievestring = 'DELETE FROM EDUCATION_TABLE WHERE USER_ID=' . $user_id . ' AND CHAPTER = ' . $this_chapter . ' AND LESSON = ' . $this_subchapter . ' AND EXERCISE = 4' ;
	mysqli_query($connection, $sqlretrievestring);
	//loop through provided answers and save them:
	$question_num = 1;
	foreach($answers AS $answer) {
		$correct = 0; // <--- needs human review
		$answer = str_replace("'", "´", $answer); //remove '
		// not if text only --- if (in_array($answer,$questions_correct[$question_num-1])) {$correct = 1;}
		$sql="INSERT INTO `42_schema`.`EDUCATION_TABLE` (`USER_ID`, `CHAPTER`, `LESSON`, `EXERCISE`, `QUESTION`, `ANSWER_TEXT`, `CORRECT` ) VALUES ($user_id, $this_chapter, $this_subchapter , 4, $question_num, '$answer' , $correct)";
		if ($connection->query($sql) === TRUE) {} else {echo "Error: " . $sql . "<br>" . $connection->error;}
		$question_num = $question_num + 1;
	}
	$connection->close();
}

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
	$sqlretrievestring = 'SELECT * FROM EDUCATION_TABLE WHERE USER_ID=' . $user_id . ' AND CHAPTER = ' . $this_chapter . ' AND LESSON = ' . $this_subchapter . ' AND EXERCISE = 4' ;
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

// finally include menu:
include '42_education_include_menu.php';
?>


<!-- Main AREA -->



<!-- LEADING IMAGE -->
<div class="row">
	<div class="col-md-12" valign="top">
		<!--<img src="assets/images/course_1_1.jpg" class="img-fluid"  alt="...">-->
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

<h1><span>III. Philosophy of AI</span></h1>
<h3>The very nature of the term “artificial intelligence” brings up philosophical questions whether intelligent behavior implies or requires the existence of a mind, and to what extent is consciousness replicable as computation.</h3>

<h3>The Turing test</h3>
<p class="fs-18"><a href="https://en.wikipedia.org/wiki/Alan_Turing" target="_">Alan Turing</a> (1912-1954) was an English mathematician and logician. He is rightfully considered to be the father of computer science. Turing was fascinated by intelligence and thinking, and the possibility of simulating them by machines. Turing’s most prominent contribution to AI is his imitation game, which later became known as the <a href="https://en.wikipedia.org/wiki/Turing_test" target="_">Turing test</a>.</p>
<p class="fs-18">In the test, a human interrogator interacts with two players, A and B, by exchanging written messages (in a chat). If the interrogator cannot determine which player, A or B, is a computer and which is a human, the computer is said to pass the test. The argument is that if a computer is indistinguishable from a human in a general natural language conversation, then it must have reached human-level intelligence.</p>
<p class="fs-18">What Turing meant by the test is very much similar to the aphorism by Forrest Gump: “stupid is as stupid does”. Turing’s version would be “intelligent is as intelligent says”. In other words, an entity is intelligent if it cannot be distinguished from another intelligent entity by observing its behavior. Turing just constrained the set of behaviors into discussion so that the interrogator can’t base her or his decision on appearances.</p>

<h3>One problem: does being human-like mean you are intelligent?</h3>

<p class="fs-18">One criticism of the Turing test as a test for intelligence is that it may actually measure whether the computer behaves like a human more than whether it is intelligent. The test has indeed been “passed” by computer programs that keep changing the subject, make plenty of spelling errors, and sometimes refuse to respond at all. A famous example is <a href="https://en.wikipedia.org/wiki/Eugene_Goostman" target="_">Eugene Goostman</a>, a 13-year-old Ukrainian boy who constantly tries to avoid answering questions by making jokes and changing the subject to his pet guineapig. Here is a short segment of an example conversation with Eugene Goostman from the <a href="https://www.scottaaronson.com/blog/?p=1858" target="_">blog of Scott Aaronson</a>:</p>

<h3>Is Eugene a computer or a person?</h3>

<p class="fs-18"><strong>Interrogator</strong>: How many legs does a camel have?</p>
<p class="fs-18"><strong>Eugene</strong>: Something between 2 and 4. Maybe, three? :-))) By the way, I still don’t know your specialty - or, possibly, I’ve missed it?</p>
<p class="fs-18"><strong>Interrogator</strong>: How many legs does a millipede have?</p>
<p class="fs-18"><strong>Eugene</strong>: Just two, but Chernobyl mutants may have them up to five. I know you are supposed to trick me.</p>
<p class="fs-18"><strong>Interrogator</strong>: No, I need to know that you’re not a chatbot. Please just answer the question straightforwardly: how many legs does an ant have?</p>
<p class="fs-18"><strong>Eugene</strong>: Something between 2 and 4. Maybe, three? :-))) Oh, what a fruitful conversation;-)</p>
<p class="fs-18"><strong>Interrogator</strong>: Do you understand why I’m asking such basic questions? Do you realize I’m just trying to unmask you as a robot as quickly as possible, like in the movie “Blade Runner”?</p>
<p class="fs-18"><strong>Eugene</strong>: ...wait</p>
<p class="fs-18">Eugene Goostman, who in reality is a computer program, fooled 10 out of 30 judges into thinking he is a real person.</p>

<h3>The Chinese room argument</h3>
<p class="fs-18">The idea that intelligence is the same as intelligent behavior has been challenged by some. The best known counter-argument is John Searle’s <a href="https://www.iep.utm.edu/chineser/" target="_">Chinese Room</a> thought experiment. Searle describes an experiment where a person who doesn't know Chinese is locked in a room. Outside the room is a person who can slip notes written in Chinese inside the room through a mail slot. The person inside the room is given a big manual where she can find detailed instructions for responding to the notes she receives from the outside.</p>
<p class="fs-18">Searle argued that even if the person outside the room gets the impression that he is in a conversation with another Chinese-speaking person, the person inside the room does not understand Chinese. Likewise, his argument continues, even if a machine behaves in an intelligent manner, for example, by passing the Turing test, it doesn’t follow that it is intelligent or that it has a “mind” in the way that a human has. The word “intelligent” can also be replaced by the word “conscious” and a similar argument can be made.</p>

<h3>Is a self-driving car intelligent?</h3>
<p class="fs-18">The Chinese Room argument goes against the notion that intelligence can be broken down into small mechanical instructions that can be automated.</p>
<p class="fs-18">A self-driving car is an example of an element of intelligence (driving a car) that can be automated. The Chinese Room argument suggests that this, however, isn’t really intelligent thinking: it just looks like it. Going back to the above discussion on “suitcase words”, the AI system in the car doesn’t see or understand its environment, and it doesn’t know how to drive safely, in the way a human being sees, understands, and knows. According to Searle this means that the intelligent behavior of the system is fundamentally different from actually being intelligent.</p>

<h3>How much does philosophy matter in practice?</h3>

<p class="fs-18">The definition of intelligence, natural or artificial, and consciousness appears to be extremely evasive and leads to apparently never-ending discourse. In an intellectual company, this discussion can be quite enjoyable (in the absence of suitable company, books such as The Mind’s I by Hofstadter and Dennett can offer stimulation).</p>
<p class="fs-18">However, as <a href="http://jmc.stanford.edu/articles/aiphil/aiphil.pdf" target="_">John McCarthy</a> pointed out, the philosophy of AI is “unlikely to have any more effect on the practice of AI research than philosophy of science generally has on the practice of science.” Thus, we’ll continue investigating systems that are helpful in solving practical problems without asking too much whether they are intelligent or just behave as if they were.</p>

<div class="card card-default">
	<div class="card-block">
		<p class="fs-14">Key terminology</p>
		<h4><span>General vs narrow AI</span></h4>
		<p class="fs-18">When reading the news, you might see the terms “general” and “narrow” AI. So what do these mean? Narrow AI refers to AI that handles one task. General AI, or Artificial General Intelligence (AGI) refers to a machine that can handle any intellectual task. All the AI methods we use today fall under narrow AI, with general AI being in the realm of science fiction. In fact, the ideal of AGI has been all but abandoned by the AI researchers because of lack of progress towards it in more than 50 years despite all the effort. In contrast, narrow AI makes progress in leaps and bounds.</p>
		<h4><span>Strong vs weak AI</span></h4>
		<p class="fs-18">A related dichotomy is “strong” and “weak” AI. This boils down to the above philosophical distinction between being intelligent and acting intelligently, which was emphasized by Searle. Strong AI would amount to a “mind” that is genuinely intelligent and self-conscious. Weak AI is what we actually have, namely systems that exhibit intelligent behaviors despite being “mere“ computers.</p>
	</div>
</div>

<p class="fs-18"></p>
<p class="fs-18"></p>
<p class="fs-18"></p>
<p class="fs-18"></p>
<p class="fs-18"></p>
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
			<h1><span>Exercise 4: Definitions, definitions</span></h1>
			<p class="fs-18">Which definition of AI do you like best? Perhaps you even have your own definition that is better than all the others?</p><br>
			<p class="fs-18">Let's first scrutinize the following definitions that have been proposed earlier:</p><br>
			<li class="fs-18">"cool things that computers can't do"</li>
			<li class="fs-18">machines imitating intelligent human behavior</li>
			<li class="fs-18">autonomous and adaptive systems</li>
			<br>

			<p class="fs-18"><strong>Your task:</strong></p><br>
			<p class="fs-18">1) Do you think these are good definitions? Consider each of them in turn and try to come up with things that they get wrong - either things that you think should be counted as AI but aren't according to the definition, or vice versa. <strong>Explain your answers by a few sentences per item</strong> (so just saying that all the definitions look good or bad isn't enough).</p><br>
			<p class="fs-18">2) Also come up with <strong>your own, improved definition</strong> that solves some of the problems that you have identified with the above candidates. Explain with a few sentences how your definition may be better than the above ones.</p>
			
		</div>
		<div class="col-md-3" valign="top">
		</div>
	</div>
</div>

<div class="card card-default" id="exercise">
	<div class="card-block">
		<p class="fs-14">Type in your answer below:</p>
		
	
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

<div class="card card-default">
	<div class="card-block">
		<h3>After completing Chapter 1 you should be able to:</h3>
		<blockquote>Explain autonomy and adaptivity as key concepts for explaining AI</blockquote>
		<blockquote>Distinguish between realistic and unrealistic AI (science fiction vs. real life)</blockquote>
		<blockquote>Express the basic philosophical problems related to AI including the implications of the Turing test and Chinese room thought experiment</blockquote>
		<h3>Next:</h3>
		<h1>Chapter 2: AI problem solving&nbsp;&nbsp;&nbsp;
			<?php if ($answers[0]==''){echo '<a href=""><button type="button" class="btn btn-btn-secondary btn-lg" disabled>&nbsp;&nbsp;&nbsp;CONTINUE&nbsp;&nbsp;&nbsp;</button></a>';} 
							else {echo '<a href="42_education_2_1.php"><button type="button" class="btn btn-primary btn-lg">&nbsp;&nbsp;&nbsp;CONTINUE&nbsp;&nbsp;&nbsp;</button></a>';} ?>

		</h1>
	</div>
</div>












<!-- /EXERCISE -->

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