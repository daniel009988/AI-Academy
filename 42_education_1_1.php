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
	"Spreadsheet that calculates sums and other pre-defined functions on given data",
	"Predicting the stock market by fitting a curve to past data about stock prices",
	"A GPS navigation system for finding the fastest route",
	"A music recommendation system such as Spotify that suggests music based on the user's listening behavior",
	"Big data storage solutions that can store huge amounts of data (such as images or video) and stream them to many users at the same time",
	"Photo editing features such as brightness and contrast in applications such as Photoshop",
	"Style transfer filters in applications such as Prisma that take a photo and transform it into different art styles (impressionist, cubist, ...)"
	);
//answering options:
$questions_options = array("Yes", "No", "Kind of"); // =1, =2, =3, etc.
//correct answers:
$questions_correct = array(array(2),array(1,2,3),array(1,2,3),array(1),array(2),array(2,3),array(1));
//answers comments:
$questions_correct_hint = array(
	"The outcome is determined by the user-specified formula, no AI needed",
	"Fitting a simple curve is not really AI, but there are so many different curves to choose from, even if there's a lot of data to constrain them, that one needs machine learning/AI to get useful results.",
	"The signal processing and geometry used to determine the coordinates isn't AI, but providing good suggestions for navigation (shortest/fastest routes) is AI, especially if variables such as traffic conditions are taken into account.",
	"The system learns from the users' (not only your) listening behavior",
	"Storing and retrieving specific items from a data collection is neither adaptive or autonomous",
	"Adjustments such as color balance, contrast, and so on, are neither adaptive nor autonomous, but the developers of the application may use some AI to automatically tune the filters.",
	"Such methods typically learn image statistics (read: what small patches of the image in a certain style look like up close) and transform the input photo so that its statistics match the style, so the system is adaptive"
	);

//entered answers (form post): *************************************************************************************************************************
$answers = array($_POST['0'],$_POST['1'],$_POST['2'],$_POST['3'],$_POST['4'],$_POST['5'],$_POST['6']);

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
	$sqlretrievestring = 'DELETE FROM EDUCATION_TABLE WHERE USER_ID=' . $user_id . ' AND CHAPTER = ' . $this_chapter . ' AND LESSON = ' . $this_subchapter . ' AND EXERCISE = 1' ;
	mysqli_query($connection, $sqlretrievestring);
	//loop through provided answers and save them:
	$question_num = 1;
	foreach($answers AS $answer) {
		$correct = -1;
		if (in_array($answer,$questions_correct[$question_num-1])) {$correct = 1;}
		$sql="INSERT INTO `42_schema`.`EDUCATION_TABLE` (`USER_ID`, `CHAPTER`, `LESSON`, `EXERCISE`, `QUESTION`, `ANSWER`, `CORRECT` ) VALUES ($user_id, $this_chapter, $this_subchapter , 1, $question_num, $answer , $correct)";
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
	$sqlretrievestring = 'SELECT * FROM EDUCATION_TABLE WHERE USER_ID=' . $user_id . ' AND CHAPTER = ' . $this_chapter . ' AND LESSON = ' . $this_subchapter . ' AND EXERCISE = 1' ;
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
		<img src="assets/images/course_1_1.jpg" class="img-fluid"  alt="...">
	</div>
</div>

<!-- CONTENT -->
<div class="container">
<div class="container">
<br>

<!-- PROCESS BAR -->
<div class="row process-wizard process-wizard-info">
	<div class="col-md-1"></div>
	<div class="col-md-1 process-wizard-step active"> <!-- complete active disabled -->
		<div class="text-center process-wizard-stepnum">Chapter 1</div>
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

<h1><span>I. How should we define AI?</span></h1>
<h3>In our very first section, we'll become familiar with the concept of AI by looking into its definition and some examples.</h3>

<p class="fs-18">As you have probably noticed, AI is currently a "hot topic": media coverage and public discussion about AI is almost impossible to avoid. However, you may also have noticed that AI means different things to different people. For some, AI is about artificial life-forms that can surpass human intelligence, and for others, almost any data processing technology can be called AI.</p>

<p class="fs-18">To set the scene, so to speak, we'll discuss what AI is, how it can be defined, and what other fields or technologies are closely related. Before we do so, however, we'll highlight three applications of AI that illustrate different aspects of AI. We'll return to each of them throughout the course to deepen our understanding.</p>

<h3>Application 1. Self-driving cars</h3>

<p class="fs-18">Self-driving cars require a combination of AI techniques of many kinds: search and planning to find the most convenient route from A to B, computer vision to identify obstacles, and decision making under uncertainty to cope with the complex and dynamic environment. Each of these must work with almost flawless precision in order to avoid accidents.</p>

<p class="fs-18">The same technologies are also used in other autonomous systems such as delivery robots, flying drones, and autonomous ships.</p>

<div class="heading-title heading-border">
	<h4><span>Implications</span></h4>
	<p class="fs-18">Road safety should eventually improve as the reliability of the systems surpasses human level. The efficiency of logistics chains when moving goods should improve. Humans move into a supervisory role, keeping an eye on what’s going on while machines take care of the driving. Since transportation is such a crucial element in our daily life, it is likely that there are also some implications that we haven't even thought about yet.</p>
</div>

<h3>Application 2. Content recommendation</h3>

<p class="fs-18">A lot of the information that we encounter in the course of a typical day is personalized. Examples include Facebook, Twitter, Instagram, and other social media content; online advertisements; music recommendations on Spotify; movie recommendations on Netflix, HBO, and other streaming services. Many online publishers such as newspapers’ and broadcasting companies’ websites as well as search engines such as Google also personalize the content they offer.</p>
<p class="fs-18">While the frontpage of the printed version of the New York Times or China Daily is the same for all readers, the frontpage of the online version is different for each user. The algorithms that determine the content that you see are based on AI.</p>

<div class="heading-title heading-border">
	<h4><span>Implications</span></h4>
	<p class="fs-18">While many companies don’t want to reveal the details of their algorithms, being aware of the basic principles helps you understand the potential implications: these involve so called filter bubbles, echo-chambers, troll factories, fake news, and new forms of propaganda.</p>
</div>

<h3>Application 3. Image and video processing</h3>

<p class="fs-18">Face recognition is already a commodity used in many customer, business, and government applications such as organizing your photos according to people, automatic tagging on social media, and passport control. Similar techniques can be used to recognize other cars and obstacles around an autonomous car, or to estimate <a href="https://valohai.com/showcase/marais-elephant/" target="_">wildlife populations</a>, just to name a few examples.</p>
<p class="fs-18">AI can also be used to generate or alter visual content. Examples already in use today include style transfer, by which you can adapt your personal photos to look like they were painted by Vincent van Gogh, and computer generated characters in motion pictures such as Avatar, the Lord of the Rings, and popular Pixar animations where the animated characters replicate gestures made by real human actors.</p>

<div class="heading-title heading-border">
	<h4><span>Implications</span></h4>
	<p class="fs-18">When such techniques advance and become more widely available, it will be easy to create natural looking fake videos of events that are impossible to distinguish from real footage. This challenges the notion that “seeing is believing”.</p>
</div>

<h3>What is, and what isn't AI? Not an easy question!</h3>

<p class="fs-18">The popularity of AI in the media is in part due to the fact that people have started using the term when they refer to things that used to be called by other names. You can see almost anything from statistics and business analytics to manually encoded if-then rules called AI. Why is this so? Why is the public perception of AI so nebulous? Let’s look at a few reasons.</p>

<div class="heading-title heading-border">
	<h4><span>Reason 1: no officially agreed definition</span></h4>
	<p class="fs-18">Even AI researchers have no exact definition of AI. The field is rather being constantly redefined when some topics are classified as non-AI, and new topics emerge. </p>
</div>
<p class="fs-18">There´s an old (geeky) joke that AI is defined as “cool things that computers can't do.” The irony is that under this definition, AI can never make any progress: as soon as we find a way to do something cool with a computer, it stops being an AI problem. However, there is an element of truth in this definition. Fifty years ago, for instance, automatic methods for search and planning were considered to belong to the domain of AI. Nowadays such methods are taught to every computer science student. Similarly, certain methods for processing uncertain information are becoming so well understood that they are likely to be moved from AI to statistics or probability very soon.</p>

<div class="heading-title heading-border">
	<h4><span>Reason 2: the legacy of science fiction</span></h4>
	<p class="fs-18">The confusion about the meaning of AI is made worse by the visions of AI present in various literary and cinematic works of science fiction. Science fiction stories often feature friendly humanoid servants that provide overly-detailed factoids or witty dialogue, but can sometimes follow the steps of Pinocchio and start to wonder if they can become human. Another class of humanoid beings in sci-fi espouse sinister motives and turn against their masters in the vein of old tales of sorcerers' apprentices, going back to the <a href="https://en.wikipedia.org/wiki/Golem" target="_">Golem of Prague</a> and beyond. </p>
</div>
<p class="fs-18">Often the robothood of such creatures is only a thin veneer on top of a very humanlike agent, which is understandable as most fiction – even science fiction – needs to be relatable by human readers who would otherwise be alienated by intelligence that is too different and strange. Most science fiction is thus best read as metaphor for the current human condition, and robots could be seen as stand-ins for repressed sections of society, or perhaps our search for the meaning of life.</p>

<div class="heading-title heading-border">
	<h4><span>Reason 3: what seems easy is actually hard…</span></h4>
	<p class="fs-18">Another source of difficulty in understanding AI is that it is hard to know which tasks are easy and which ones are hard. Look around and pick up an object in your hand, then think about what you did: you used your eyes to scan your surroundings, figured out where are some suitable objects for picking up, chose one of them and planned a trajectory for your hand to reach that one, then moved your hand by contracting various muscles in sequence and managed to squeeze the object with just the right amount of force to keep it between your fingers. </p>
</div>
<p class="fs-18">It can be hard to appreciate how complicated all this is, but sometimes it becomes visible when something goes wrong: the object you pick is much heavier or lighter than you expected, or someone else opens a door just as you are reaching for the handle, and then you can find yourself seriously out of balance. Usually these kinds of tasks feel effortless, but that feeling belies millions of years of evolution and several years of childhood practice. </p>
<p class="fs-18">While easy for you, grasping objects by a robot is extremely hard, and it is an area of active study. Recent examples include <a href="https://spectrum.ieee.org/automaton/robotics/artificial-intelligence/google-large-scale-robotic-grasping-project" target="_">Google's robotic grasping project</a>, and a <a href="https://www.telegraph.co.uk/science/2018/03/03/meet-robot-lending-cyber-hand-cornwalls-cauliflower-harvest/" target="_">cauliflower picking robot</a>.</p>

<div class="heading-title heading-border">
	<h4><span>…and what seems hard is actually easy</span></h4>
	<p class="fs-18">By contrast, the tasks of playing chess and solving mathematical exercises can seem to be very difficult, requiring years of practice to master and involving our “higher faculties” and concentrated conscious thought. No wonder that some initial AI research concentrated on these kinds of tasks, and it may have seemed at the time that they encapsulate the essence of intelligence. </p>
</div>
<p class="fs-18">It has since turned out that playing chess is very well suited to computers, which can follow fairly simple rules and compute many alternative move sequences at a rate of billions of computations a second. Computers beat the reigning human world champion in chess in the famous <a href="https://en.wikipedia.org/wiki/Deep_Blue_versus_Garry_Kasparov" target="_">Deep Blue vs Kasparov matches</a> in 1997. Could you have imagined that the harder problem turned out to be grabbing the pieces and moving them on the board without knocking it over! We will study the techniques that are used in playing games like chess or tic-tac-toe in Chapter 2. </p>
<p class="fs-18">Similarly, while in-depth mastery of mathematics requires (what seems like) human intuition and ingenuity, many (but not all) exercises of a typical high-school or college course can be solved by applying a calculator and simple set of rules.</p>

<h3>So what would be a more useful definition?</h3>

<p class="fs-18">An attempt at a definition more useful than the “what computers can't do yet” joke would be to list properties that are characteristic to AI, in this case autonomy and adaptivity.</p>

<div class="card card-default">
	<div class="card-block">
		<p class="fs-14">Key terminology</p>
		<h4><span>Autonomy</span></h4>
		<p class="fs-18">The ability to perform tasks in complex environments without constant guidance by a user.</p>
		<h4><span>Adaptivity</span></h4>
		<p class="fs-18">The ability to improve performance by learning from experience.</p>
	</div>
</div>

<h3>Words can be misleading</h3>

<p class="fs-18">When defining and talking about AI we have to be cautious as many of the words that we use can be quite misleading. Common examples are learning, understanding, and intelligence.</p>
<p class="fs-18">You may well say, for example, that a system is intelligent, perhaps because it delivers accurate navigation instructions or detects signs of melanoma in photographs of skin lesions. When we hear something like this, the word "intelligent" easily suggests that the system is capable of performing any task an intelligent person is able to perform: going to the grocery store and cooking dinner, washing and folding laundry, and so on.</p>
<p class="fs-18">Likewise, when we say that a computer vision system understands images because it is able to segment an image into distinct objects such as other cars, pedestrians, buildings, the road, and so on, the word "understand" easily suggest that the system also understands that even if a person is wearing a t-shirt that has a photo of a road printed on it, it is not okay to drive on that road (and over the person).</p>
<p class="fs-18">In both of the above cases, we'd be wrong.</p>

<div class="card card-default">
	<div class="card-block">
		<p class="fs-14">Note</p>
		<h4><span>Watch out for ‘suitcase words’</span></h4>
		<p class="fs-18"><a href="https://en.wikipedia.org/wiki/Marvin_Minsky" target="_">Marvin Minsky</a>, a cognitive scientist and one of the greatest pioneers in AI, coined the term suitcase word for terms that carry a whole bunch of different meanings that come along even if we intend only one of them. Using such terms increases the risk of misinterpretations such as the ones above.</p>
		
	</div>
</div>

<p class="fs-18">It is important to realize that intelligence is not a single dimension like temperature. You can compare today's temperature to yesterday's, or the temperature in Helsinki to that in Rome, and tell which one is higher and which is lower. We even have a tendency to think that it is possible to rank people with respect to their intelligence – that's what the intelligence quotient (IQ) is supposed to do. However, in the context of AI, it is obvious that different AI systems cannot be compared on a single axis or dimension in terms of their intelligence. Is a chess-playing algorithm more intelligent than a spam filter, or is a music recommendation system more intelligent than a self-driving car? These questions make no sense. This is because artificial intelligence is narrow (we'll return to the meaning of narrow AI at the end of this chapter): being able to solve one problem tells us nothing about the ability to solve another, different problem.</p>

<h3>Why you can say "a pinch of AI" but not "an AI"</h3>

<p class="fs-18">The classification into AI vs non-AI is not a clear yes–no dichotomy: while some methods are clearly AI and other are clearly not AI, there are also methods that involve a pinch of AI, like a pinch of salt. Thus it would sometimes be more appropriate to talk about the "AIness" (as in happiness or awesomeness) rather than arguing whether something is AI or not.</p>

<div class="card card-default">
	<div class="card-block">
		<p class="fs-14">Note</p>
		<h4><span>“AI” is not a countable noun</span></h4>
		<p class="fs-18">When discussing AI, we would like to discourage the use of AI as a countable noun: one AI, two AIs, and so on. AI is a scientific discipline, like mathematics or biology. This means that AI is a collection of concepts, problems, and methods for solving them.</p>
		<p class="fs-18">Because AI is a discipline, you shouldn't say “an AI“, just like we don't say “a biology“. This point should also be quite clear when you try saying something like “we need more artificial intelligences.“ That just sounds wrong, doesn't it? (It does to us).</p>
	</div>
</div>

<p class="fs-18">Despite our discouragement, the use of AI as a countable noun is common. Take for instance, the headline <a href="https://www.engadget.com/2018/02/07/deepheart-diabetes-cardiogram-ai/" target="_">Data from wearables helped teach an AI to spot signs of diabetes</a>, which is otherwise a pretty good headline since it emphasizes the importance of data and makes it clear that the system can only detect signs of diabetes rather than making diagnoses and treatment decisions. And you should definitely never ever say anything like <a href="https://futurism.com/google-artificial-intelligence-built-ai/" target="_">Google’s artificial intelligence built an AI that outperforms any made by humans</a>, which is one of the all-time most misleading AI headlines we've ever seen (note that the headline is not by Google Research).</p>

<p class="fs-18">The use of AI as a countable noun is of course not a big deal if what is being said otherwise makes sense, but if you'd like to talk like a pro, avoid saying "an AI", and instead say "an AI method".</p>

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
			<h1><span>Exercise 1: Is this AI or not?</span></h1>
			<p class="fs-18">Which of the following are AI and which are not. Choose yes, no, or “kind of” where kind of means that it both can be or can't be, depending on the viewpoint.</p>
			

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
					<div class="col-md-6" valign="top"><p class="fs-18">' . $question . '</p></div>';
			
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

<div class="card card-default">
	<div class="card-block">
		<h3>Next:</h3>
		<h1>II. Related fields&nbsp;&nbsp;&nbsp;
			<?php if ($answers[0]==''){echo '<a href=""><button type="button" class="btn btn-btn-secondary btn-lg" disabled>&nbsp;&nbsp;&nbsp;CONTINUE&nbsp;&nbsp;&nbsp;</button></a>';} 
							else {echo '<a href="42_education_1_2.php"><button type="button" class="btn btn-primary btn-lg">&nbsp;&nbsp;&nbsp;CONTINUE&nbsp;&nbsp;&nbsp;</button></a>';} ?>


			
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