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
	$sqlretrievestring = 'DELETE FROM EDUCATION_TABLE WHERE USER_ID=' . $user_id . ' AND CHAPTER = ' . $this_chapter . ' AND LESSON = ' . $this_subchapter . ' AND EXERCISE = 23' ;
	mysqli_query($connection, $sqlretrievestring);
	//loop through provided answers and save them:
	$question_num = 1;
	foreach($answers AS $answer) {
		$correct = 0; // <--- needs human review
		$answer = str_replace("'", "´", $answer); //remove '
		$sql="INSERT INTO `42_schema`.`EDUCATION_TABLE` (`USER_ID`, `CHAPTER`, `LESSON`, `EXERCISE`, `QUESTION`, `ANSWER_TEXT`, `CORRECT` ) VALUES ($user_id, $this_chapter, $this_subchapter , 23, $question_num, '$answer' , $correct)";
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
	$sqlretrievestring = 'SELECT * FROM EDUCATION_TABLE WHERE USER_ID=' . $user_id . ' AND CHAPTER = ' . $this_chapter . ' AND LESSON = ' . $this_subchapter . ' AND EXERCISE = 23' ;
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
		<img src="assets/images/course_6_1.png" class="img-fluid"  alt="...">
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
	<div class="col-md-1 process-wizard-step active"> <!-- complete active disabled -->
		<div class="text-center process-wizard-stepnum">Chapter 6</div>
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
	
	
</div>
<br>
<!-- /PROCESS BAR -->

<div class="row">
	<div class="col-md-2" valign="top">
	</div>
	<div class="col-md-7" valign="top">


<!-- TEXT ........................................................................................................ -->

<h1><span>I. About predicting the future</span></h1>

<h3>We will start by addressing what is known to be one of the hardest problems of all: predicting the future.</h3>

<p class="fs-18">You may be disappointed to hear this, but we don't have a crystal ball that would show us what the world will be like in the future and how AI will transform our lives.</p>
<p class="fs-18">As scientists, we are often asked to provide predictions, and our refusal to provide any is faced with a roll of the eyes (“boring academics”). But in fact, we claim that anyone who claims to know the future of AI and the implications it will have on our society, should be treated with suspicion.</p>
<h3>The reality distortion field</h3>
<p class="fs-18">Not everyone is quite as conservative about their forecasts, however. In the modern world where big headlines sell, and where you have to dissect news into 280 characters, reserved (boring?) messages are lost, and simple and dramatic messages are magnified. In the public perception of AI, this is clearly true.</p>

<div class="card card-default">
	<div class="card-block">
		<p class="fs-14">Note</p>
		<h4><span>From utopian visions to grim predictions</span></h4>
		<p class="fs-18">The media sphere is dominated by the extremes. We are beginning to see AI celebrities, standing for one big idea and making oracle-like forecasts about the future of AI. The media love their clear messages. Some promise us a <a href="https://www.youtube.com/watch?v=AIQ981NoZmk">utopian future with exponential growth</a> and trillion-dollar industries emerging out of nowhere, <a href="https://www.youtube.com/watch?v=-Y7PLaxXUrs">true AI that will solve all problems</a> we cannot solve by ourselves, and where <a href="https://www.youtube.com/watch?v=9Jxlx9SZEAk">humans don’t need to work</a> at all.</p>
		<p class="fs-18">It has also been claimed that <a href="https://www.youtube.com/watch?v=xPuAzc3Y_64">AI is a path to world domination</a>. Others make even more extraordinary statements according to which <a href="https://www.youtube.com/watch?v=JYlKrHzknBE">AI marks the end of humanity</a> (in about 20-30 years from now), <a href="https://www.youtube.com/watch?v=oYmKOgeoOz4">life itself will be transformed</a> in the “Age of AI“, and that <a href="https://www.youtube.com/watch?v=xs_HhZrCBdg&feature=youtu.be">AI is a threat to our existence</a>.</p>
	</div>
</div>

<p class="fs-18">While some forecasts will probably get at least something right, others will likely be useful only as demonstrations of how hard it is to predict, and many don’t make much sense. What we would like to achieve is for you to be able to look at these and other forecasts, and be able to critically evaluate them.</p>
<h3>On hedgehogs and foxes</h3>
<p class="fs-18">The political scientist <a href="https://en.wikipedia.org/wiki/Philip_E._Tetlock">Philip E. Tetlock</a>, author of Superforecasting: The Art and Science of Prediction, classifies people into two categories: those who have one big idea (“hedgehogs”), and those who have many small ideas (“foxes”). Tetlock has carried out an experiment between 1984 and 2003 to study factors that could help us identify which predictions are likely to be accurate and which are not. One of the significant findings was that foxes tend to be clearly better at prediction than hedgehogs, especially when it comes to long-term forecasting.</p>
<p class="fs-18">Probably the messages that can be expressed in 280 characters are more often big and simple hedgehog ideas. Our advice is to pay attention to carefully justified and balanced information sources, and to be suspicious about people who keep explaining everything using a single argument.</p>
<p class="fs-18">Predicting the future is hard but at least we can consider the past and present AI, and by understanding them, hopefully be better prepared for the future, whatever it turns out to be like.</p>

<h3>AI winters</h3>
<p class="fs-18">The history of AI, just like many other fields of science, has witnessed the coming and going of various different trends. In philosophy of science, the term used for a trend is paradigm. Typically, a particular paradigm is adopted by most of the research community and optimistic predictions about progress in the near-future are provided. For example, in the 1960s neural networks were widely believed to solve all AI problems by imitating the learning mechanisms in the nature, the human brain in particular. The next big thing was expert systems based on logic and human-coded rules, which was the dominant paradigm in the 1980s.</p>

<h3>The cycle of hype</h3>
<p class="fs-18">In the beginning of each wave, a number of early success stories tend to make everyone happy and optimistic. The success stories, even if they may be in restricted domains and in some ways incomplete, become the focus on public attention. Many researchers rush into AI – or at least calling their research AI – in order to access the increased research funding. Companies also initiate and expand their efforts in AI in the fear of missing out (FOMO).</p>
<p class="fs-18">So far, each time an all-encompassing, general solution to AI has been said to be within reach, progress has ended up running into insurmountable problems, which at the time were thought to be minor hiccups. In the case of neural networks in the 1960s, the hiccups were related to handling nonlinearities and to solving the machine learning problems associated with the increasing number of parameters required by neural network architectures. In the case of expert systems in the 1980s, the hiccups were associated with handling uncertainty and common sense. As the true nature of the remaining problems dawned after years of struggling and unsatisfied promises, pessimism about the paradigm accumulated and an AI winter followed: interest in the field faltered and research efforts were directed elsewhere.</p>

<h3>Modern AI</h3>

<p class="fs-18">Currently, roughly since the turn of the millennium, AI has been on the rise again. Modern AI methods tend to focus on breaking a problem into a number of smaller, isolated and well-defined problems and solving them one at a time. Modern AI is bypassing grand questions about meaning of intelligence, the mind, and consciousness, and focusing on building practically useful solutions in real-world problems. Good news for us all who can benefit from such solutions!</p>
<p class="fs-18">Another characteristic of modern AI methods, closely related to working in the complex and “messy” real world, is the ability to handle uncertainty, which we demonstrated by studying the uses of probability in AI in Chapter 3. Finally, the current upwards trend of AI has been greatly boosted by the come-back of neural networks and deep learning techniques capable of processing images and other real-world data better than anything we have seen before.</p>

<div class="card card-default">
	<div class="card-block">
		<p class="fs-14">Note</p>
		<h4><span>So are we in a hype cycle?</span></h4>
		<p class="fs-18">Whether the history will repeat itself, and the current boom will be once again followed by an AI winter, is a matter that only time can tell. Even if it does, and the progress towards better and better solutions slows down to a halt, the significance of AI in the society is going to stay. Thanks to the focus on useful solutions to real-world problems, modern AI research yields fruit already today, rather than trying to solve the big questions about general intelligence first – which was where the earlier attempts failed.</p>
	</div>
</div>

<h3>Prediction 1: AI will continue to be all around us</h3>

<p class="fs-18">As you recall, we started by motivating the study of AI by discussing prominent AI applications that affect all our lives. We highlighted three examples: self-driving vehicles, recommendation systems, and image and video processing. During the course, we have also discussed a wide range of other applications that contribute to the ongoing technological transition.</p>

<div class="card card-default">
	<div class="card-block">
		<p class="fs-14">Note</p>
		<h4><span>AI making a difference</span></h4>
		<p class="fs-18">As a consequence of focusing on practicality rather than the big problems, we live our life surrounded by AI (even if we may most of the time be happily unaware of it): the music we listen to, the products we buy online, the movies and series we watch, our routes of transportation, and even the news and information that we have available, are all influenced more and more by AI. What is more, basically any field of science, from medicine and astrophysics to medieval history, is also adopting AI methods in order to deepen our understanding of the universe and of ourselves.</p>
	</div>
</div>

<h3>Prediction 2: the Terminator isn't coming</h3>

<p class="fs-18">One of the most pervasive and persistent ideas related to the future of AI is the Terminator. In case you should have somehow missed the image of a brutal humanoid robot with a metal skeleton and glaring eyes...well, that’s what it is. The Terminator is a 1984 film by director James Cameron. In the movie, a global AI-powered defense system called Skynet becomes conscious of its existence and wipes most of the humankind out of existence with nukes and advanced killer robots.</p>

<div class="card card-default">
	<div class="card-block">
		<p class="fs-14">Note</p>
		<h4><span>Two doomsday scenarios</span></h4>
		<p class="fs-18">There are two alternative scenarios that are suggested to lead to the coming of the Terminator or other similarly terrifying forms of robot uprising. In the first, which is the story from the 1984 film, a powerful AI system just becomes conscious and decides that it just really, really dislikes humanity in general.</p>
		<p class="fs-18">In the second alternative scenario, the robot army is controlled by an intelligent but not conscious AI system that is in principle in human control. The system can be programmed, for example, to optimize the production of paper clips. Sounds innocent enough, doesn’t it?</p>
		<p class="fs-18">However, if the system possesses superior intelligence, it will soon reach the maximum level of paper clip production that the available resources, such as energy and raw materials, allow. After this, it may come to the conclusion that it needs to redirect more resources to paper clip production. In order to do so, it may need to prevent the use of the resources for other purposes even if they are essential for human civilization. The simplest way to achieve this is to kill all humans, after which a great deal more resources become available for the system’s main task, paper clip production.</p>
	</div>
</div>

<h3>Why these scenarios are unrealistic</h3>

<p class="fs-18">There are a number of reasons why both of the above scenarios are extremely unlikely and belong to science fiction rather than serious speculations of the future of AI.</p>

<h3>Reason 1:</h3>
<p class="fs-18">Firstly, the idea that a <strong>superintelligent</strong>, conscious AI that can outsmart humans emerges as an unintended result of developing AI methods is naive. As you have seen in the previous chapters, AI methods are nothing but automated reasoning, based on the combination of perfectly understandable principles and plenty of input data, both of which are provided by humans or systems deployed by humans. To imagine that the nearest neighbor classifier, linear regression, the AlphaGo game engine, or even a deep neural network could become conscious and start evolving into a superintelligent AI mind requires a (very) lively imagination.</p>
<p class="fs-18">Note that we are not claiming that building human-level intelligence would be categorically impossible. You only need to look as far as the mirror to see a proof of the possibility of a highly intelligent physical system. To repeat what we are saying: superintelligence will not emerge from developing narrow AI methods and applying them to solve real-world problems (recall the narrow vs general AI from the section on the philosophy of AI in Chapter 1).</p>
<h3>Reason 2:</h3>
<p class="fs-18">Secondly, one of the favorite ideas of those who believe in superintelligent AI is the so-called <strong>singularity</strong>: a system that optimizes and “rewires“ itself so that it can improve its own intelligence at an ever accelerating, exponential rate. Such superintelligence would leave humankind so far behind that we become like ants that can be exterminated without hesitation. The idea of exponential intelligence increase is unrealistic for the simple reason that even if a system could optimize its own workings, it would keep facing more and more difficult problems that would slow down its progress, quite like the progress of human scientists requires ever greater efforts and resources by the whole research community and indeed the whole society, which the superintelligent entity wouldn’t have access to. The human society still has the power to decide what we use technology, even AI technology, for. Much of this power is indeed given to us by technology, so that every time we make progress in AI technology, we become more powerful and better at controlling any potential risks due to it.</p>

<div class="card card-default">
	<div class="card-block">
		<p class="fs-14">Note</p>
		<h4><span>The value alignment problem</span></h4>
		<p class="fs-18">The paper clip example is known as the value alignment problem: specifying the objectives of the system so that they are aligned with our values is very hard. However, suppose that we create a superintelligent system that could defeat humans who tried to interfere with its work. It’s reasonable to assume that such a system would also be intelligent enough to realize that when we say “make me paper clips”, we don’t really mean to turn the Earth into a paper clip factory of a planetary scale.</p>
	</div>
</div>

<h3>Separating stories from reality</h3>

<p class="fs-18">All in all, the Terminator is a great story to make movies about but hardly a real problem worth panicking about. The Terminator is a gimmick, an easy way to get a lot of attention, a poster boy for journalists to increase click rates, a red herring to divert attention away from perhaps boring, but real, threats like nuclear weapons, lack of democracy, environmental catastrophes, and climate change. In fact, the real threat the Terminator poses is the diversion of attention from the actual problems, some of which involve AI, and many of which don’t. We’ll discuss the problems posed by AI in what follows, but the bottom line is: forget about the Terminator, there are much more important things to focus on.</p>




</div>
</div>


<!-- EXERCISE -->
<div class="callout alert alert-default">
	<div class="row">
		<div class="col-md-2" valign="top">
		</div>
		<div class="col-md-7 col-sm-8"><!-- left text -->
			<h1><span>Exercise 23: What is the perception of AI?</span></h1>
			<p class="fs-18">For this exercise, we want you to think about how AI is portrayed. Do an online <strong>image search</strong> for the term “AI” and see what kinds of pictures come up. If you are using Google search, you should choose "Images" in the top of the screen.</p><br>
			<p class="fs-18">What's the general impression you get about AI from the image search results? Is this an accurate representation of AI? Why or why not?</p>
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
		<h3>Next:</h3>
		<h1>II. The societal implications of AI&nbsp;&nbsp;&nbsp;
			<?php if ($answers[0]==''){echo '<a href=""><button type="button" class="btn btn-btn-secondary btn-lg" disabled>&nbsp;&nbsp;&nbsp;CONTINUE&nbsp;&nbsp;&nbsp;</button></a>';} 
							else {echo '<a href="42_education_6_2.php"><button type="button" class="btn btn-primary btn-lg">&nbsp;&nbsp;&nbsp;CONTINUE&nbsp;&nbsp;&nbsp;</button></a>';} ?>


			
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