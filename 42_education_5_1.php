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
$this_chapter    = 5;
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
		<img src="assets/images/course_5_1.png" class="img-fluid"  alt="...">
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
	<div class="col-md-1 process-wizard-step active"> <!-- complete active disabled -->
		<div class="text-center process-wizard-stepnum">Chapter 5</div>
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

<h1><span>I. Neural network basics</span></h1>

<h3>Our next topic, deep learning and neural networks, tends to attract more interest than many of the other topics.</h3>

<p class="fs-18">One of the reasons for the interest is the hope to understand our own mind, which emerges from neural processing in our brain. Another reason is the advances in machine learning achieved within the recent years by combining massive data sets and deep learning techniques.</p>

<h3>What are neural networks?</h3>
<p class="fs-18">To better understand the whole, we will start by discussing the individual units that make it up. A neural network can mean either a “real” biological neural network such as the one in your brain, or an artificial neural network simulated in a computer.</p>

<div class="card card-default">
	<div class="card-block">
		<p class="fs-14">Key terminology</p>
		<h4><span>Deep learning</span></h4>
		<p class="fs-18">Deep learning refers to certain kinds of machine learning techniques where several “layers” of simple processing units are connected in a network so that the input to the system is passed through each one of them in turn. This architecture has been inspired by the processing of visual information in the brain coming through the eyes and captured by the retina. This depth allows the network to learn more complex structures without requiring unrealistically large amounts of data.</p>
		<h4><span>Neurons, cell bodies, and signals</span></h4>
		<p class="fs-18">A neural network, either biological and artificial, consists of a large number of simple units, neurons, that receive and transmit signals to each other. The neurons are very simple processors of information, consisting of a cell body and wires that connect the neurons to each other. Most of the time, they do nothing but sit still and watch for signals coming in through the wires.</p>
		<h4><span>Dendrites, axons, and synapses</span></h4>
		<p class="fs-18">In the biological lingo, we call the wires that provide the input to the neurons dendrites. Sometimes, depending on the incoming signals, the neuron may fire and send a signal out for the other neurons to receive. The wire that transmits the outgoing signal is called an axon. Each axon may be connected to one or more dendrites at intersections that are called synapses.</p>
	</div>
</div>

<p class="fs-18">Isolated from its fellow-neurons, a single neuron is quite unimpressive, and capable of only a very restricted set of behaviors. When connected to each other, however, the system resulting from their concerted action can become extremely complex. To find evidence for this, look no further than (to use legal jargon) "Exhibit A": your brain! The behavior of the system is determined by the ways in which the neurons are wired together. Each neuron reacts to the incoming signals in a specific way that can also adapt over time. This adaptation is known to be the key to functions such as memory and learning.</p>

</div>
</div>


<!-- EXERCISE -->
<div class="callout alert alert-default">
	<div class="row">
		<div class="col-md-2" valign="top">
		</div>
		<div class="col-md-7 col-sm-8"><!-- left text -->
			<h1><span>Exercise 20. Elements of a neural network</span></h1>
			<p class="fs-18">Label the different components of a neuron into the diagram below. Hint: The input of the neuron comes from the left and the output goes to the right.</p><br>
			<img src="assets/images/exercise20.svg" class="img-fluid"  alt="..."><br><br>
		
		</div>
		<div class="col-md-3" valign="top">
		</div>
	</div>
</div>

<div class="card card-default" id="exercise">
	<div class="card-block">
		<p class="fs-14">Answer the questions below</p>
		
	
<form class="m-0" method="post" action="#exercise" autocomplete="off">
	<!-- QUESTIONS -->
	<?php
		$elem = 0; 
		foreach($questions_string AS $question) {
			echo '<div class="row border-bottom">
					<div class="col-md-4" valign="top"><p class="fs-18">' . $question . '</p></div>';
			
			$ans = 1;
			foreach($questions_options AS $option) {
				echo '<div class="col-md-2" valign="top">';
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

<div class="row">
	<div class="col-md-2" valign="top">
	</div>
	<div class="col-md-7" valign="top">

	<h3>Why develop artificial neural networks?</h3>

	<p class="fs-18">The purpose of building artificial models of the brain can be neuroscience, the study of the brain and the nervous system in general. It is tempting to think that by mapping the human brain in enough detail, we can discover the secrets of human and animal cognition and consciousness.</p>

	<img src="assets/images/img_5_1_1.svg" class="img-fluid"  alt="..."><br><br>

	<div class="card card-default">
	<div class="card-block">
		<p class="fs-14">Note</p>
		<h4><span>Modeling the brain</span></h4>
		<p class="fs-18">The <a href="https://braininitiative.nih.gov/">BRAIN Initiative</a> led by American neuroscience researchers is pushing forward technologies for imaging, modeling, and simulating the brain at a finer and larger scale than before. Some brain research projects are very ambitious in terms of objectives. The <a href="https://www.youtube.com/watch?v=JqMpGrM5ECo">Human Brain Project</a> promised about 5 years ago that “the mysteries of the mind can be solved – soon”. After years of work, the Human Brain Project was facing questions about when the <a href="https://www.scientificamerican.com/article/why-the-human-brain-project-went-wrong-and-how-to-fix-it/">billion euros invested by the European Union</a> will deliver what was promised, even though, to be fair, some less ambitious milestones have been achieved.</p>
	</div>
	</div>

	<p class="fs-18">However, even while we seem to be almost as far from understanding the mind and consciousness, there are clear milestones that have been achieved in neuroscience. By better understanding of the structure and function of the brain, we are already reaping some concrete rewards. We can, for instance, identify abnormal functioning and try to help the brain avoid them and reinstate normal operation. This can lead to life-changing new medical treatments for people suffering from neurological disorders: epilepsy, Alzheimer’s disease, problems caused by developmental disorders or damage caused by injuries, and so on.</p>

	<div class="card card-default">
	<div class="card-block">
		<p class="fs-14">Note</p>
		<h4><span>Looking to the future: brain computer interfaces</span></h4>
		<p class="fs-18">One research direction in neuroscience is brain-computer interfaces that allow interacting with a computer by simply thinking. The current interfaces are very limited and they can be used, for example, to <a href="https://www.youtube.com/watch?v=Ecvv-EvOj8M">reconstruct on a very rough level what a person is seeing</a>, or to <a href="https://www.youtube.com/watch?v=7t84lGE5TXA">control robotic arms or drones by thought</a>. Perhaps some day we can actually implement a thought reading machine that allows precise instructions but currently they belong to science fiction. It is also conceivable that we could feed information into the brain by stimulating it by small electronic pulses. Such stimulation is currently used for therapeutic purposes. Feeding detailed information such as specific words, ideas, memories, or emotions is at least currently science fiction rather than reality, but obviously we know neither the limits of such technology, nor how hard it is to reach them.</p>
	</div>
	</div>

	<p class="fs-18">We’ve drifted a little astray from the topic of the course. In fact, another main reason for building artificial neural networks has little to do with understanding biological systems. It is to use biological systems as an inspiration to build better AI and machine learning techniques. The idea is very natural: the brain is an amazingly complex information processing system capable of a wide range of intelligent behaviors (plus occasionally some not-so-intelligent ones), and therefore, it makes sense to look for inspiration in it when we try to create artificially intelligent systems.</p>
	<p class="fs-18">Neural networks have been a major trend in AI since the 1960s. We’ll return to the waves of popularity in the history of AI in the final part. Currently neural networks are again at the very top of the list as deep learning is used to achieve significant improvements in many areas such as natural language and image processing, which have traditionally been sore points of AI.</p>

	<h3>What is so special about neural networks?</h3>

	<p class="fs-18">The case for neural networks in general as an approach to AI is based on a similar argument as that for logic-based approaches. In the latter case, it was thought that in order to achieve human-level intelligence, we need to simulate higher-level thought processes, and in particular, manipulation of symbols representing certain concrete or abstract concepts using logical rules.</p>
	<p class="fs-18">The argument for neural networks is that by simulating the lower-level, “subsymbolic” data processing on the level of neurons and neural networks, intelligence will emerge. This all sounds very reasonable but keep in mind that in order to build flying machines, we don’t build airplanes that flap their wings, or that are made of bones, muscle, and feather. Likewise, in artificial neural networks, the internal mechanism of the neurons is usually ignored and the artificial neurons are often much simpler than their natural counterparts. The electro-chemical signaling mechanisms between natural neurons are also mostly ignored in artificial models when the goal is to build AI systems rather than to simulate biological systems.</p>
	<p class="fs-18">Compared to how computers traditionally work, neural networks have certain special features:</p>

	<h3>Neural network key feature 1</h3>

	<p class="fs-18">For one, in a traditional computer, information is processed in a central processor (aptly named the central processing unit, or CPU for short) which can only focus on doing one thing at a time. The CPU can retrieve data to be processed from the computer’s memory, and store the result in the memory. Thus, data storage and processing are handled by two separate components of the computer: the memory and the CPU. In neural networks, the system consists of a large number of neurons, each of which can process information on its own so that instead of having a CPU process each piece of information one after the other, the neurons process vast amounts of information simultaneously.</p>

	<h3>Neural network key feature 2</h3>

	<p class="fs-18">The second difference is that data storage (memory) and processing isn’t separated like in traditional computers. The neurons both store and process information so that there is no need to retrieve data from the memory for processing. The data can be stored short term in the neurons themselves (they either fire or not at any given time) or for longer term storage, in the connections between the neurons – their so called weights, which we will discuss below.</p>
	<p class="fs-18">Because of these two differences, neural networks and traditional computers are suited for somewhat different tasks. Even though it is entirely possible to simulate neural networks in traditional computers, which was the way they were used for a long time, their maximum capacity is achieved only when we use special hardware (computer devices) that can process many pieces of information at the same time. This is called <strong>parallel processing</strong>. Incidentally, graphics processors (or graphics processing units, GPUs) have this capability and they have become a cost-effective solution for running massive deep learning methods.</p>
	

</div>
</div>

<div class="card card-default">
	<div class="card-block">
		<h3>Next:</h3>
		<h1>II. How neural networks are built&nbsp;&nbsp;&nbsp;
			<?php if ($answers[0]==''){echo '<a href=""><button type="button" class="btn btn-btn-secondary btn-lg" disabled>&nbsp;&nbsp;&nbsp;CONTINUE&nbsp;&nbsp;&nbsp;</button></a>';} 
							else {echo '<a href="42_education_5_2.php"><button type="button" class="btn btn-primary btn-lg">&nbsp;&nbsp;&nbsp;CONTINUE&nbsp;&nbsp;&nbsp;</button></a>';} ?>


			
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