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
$this_chapter    = 3;
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
	"The weather forecast says it's going to rain with 90% probability tomorrow but the day turns out to be all sun and no rain.",
	"The weather forecast says it's going to rain with 0% probability tomorrow but the day turns out to be rainy.",
	"Suppose you monitor a weather forecaster for a long time. You only consider the days for which the forecast gives 80% chance of rain. You find that in the long run, on the average it rains on three out of every five days.",
	"In the United States presidential election 2016, a well-known political forecast blog, Five-Thirty-Eight, gave Clinton a 71.4% chance of winning (vs Trump's 28.6%). However, contrary to the prediction, Donald Trump was elected the 45th president of the United States.");
$questions_options = array("Right","Wrong","Cannot be concluded"); // =1, =2, =3, etc.
$questions_correct = array(array(3),array(2),array(2),array(3));
$questions_correct_hint = array(
	"We can't conclude that the weather forecast was wrong based on only the single event. The forecast said it's going to rain with 90% probability, which means it would not rain with 10% probability or in one out of 10 days. It is perfectly plausible that the day in question was the 1 in 10 event. Concluding that the probability 90% was correct would also be wrong because by the same argument, we could then conclude that 80% chance of rain was also correct, and both cannot be correct at the same time.",
	"The weather forecast was wrong because a 0% probability means that it should definitely not rain. But it did.",
	"The weather forecasts are wrong if they predict 80% chance of rain and it rains only 60% (three out of five) of the time in the long run. (Note that we'd really need to keep track of the accuracy for a long time to reach this conclusion but that's what 'in the long run' means.) In practice, weather forecasters actually tend to provide this kind of 'wrong' predictions just to be safe: people are often quite disappointed when the weather turns out to be worse than predicted but pleasantly surprised when it turns out better than predicted.",
	"Cannot be concluded to be wrong (or right). Sometimes unlikely things happen. Considering the previous item, it would actually have been wrong to predict, say, 90% or 100% chance for Trump if there simply isn't enough information available to anticipate the outcome. In other words, perhaps Trump's victory had a rare (or rareish) event with 28.6% probability. Such events are expected to happen in more than one out of four cases, after all.");

$questions_string_2 = array(
	"The odds for getting three of a kind in poker are about 1:46.",
	"The odds for rain in Helsinki are 206:159.",
	"The odds for rain in San Diego are 23:342.",
	"The odds for getting three of a kind in poker are about 1:46.",
	"The odds for rain in Helsinki are 206:159.",
	"The odds for rain in San Diego are 23:342."
	);
//answering options:
$questions_options_2 = array(""); // =1, =2, =3, etc.
//correct answers:
$questions_correct_2 = array(array("1/47"),array("206/365"),array("23/365"),array("2.1%"),array("56.4%"),array("6.3%"));
//answers comments:
$questions_correct_hint_2 = array(
	"There are 46 situations where you do not get three of a kind for one where you get it, so the probability is 1/(1+46) = 1/47.",
	"There are 206 rainy days for 159 dry days, so the probability is 206/(206+159) = 206/365.",
	"There are 23 rainy days for 342 dry days, so the probability is 23/(23+342) = 23/365.",
	"Previously we had the probability as 1/(1+ 46) = 1/47, which gives us roughly 0.0213, which rounds to 2.1%.",
	"Previously we had the probability as 206/(206 + 159) = 206/365, which gives us roughly 0.5644, which rounds to 56.4%.",
	"Previously we had the probability as 23/(23 + 342) = 23/365, which gives us roughly 0.0630, which rounds to 6.3%."
	);

//entered answers (form post): *************************************************************************************************************************
$answers = array($_POST['0'],$_POST['1'],$_POST['2'],$_POST['3']);
$answers_2 = array($_POST['4'],$_POST['5'],$_POST['6'],$_POST['7'],$_POST['8'],$_POST['9']);

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
	$sqlretrievestring = 'DELETE FROM EDUCATION_TABLE WHERE USER_ID=' . $user_id . ' AND CHAPTER = ' . $this_chapter . ' AND LESSON = ' . $this_subchapter . ' AND EXERCISE = 8' ;
	mysqli_query($connection, $sqlretrievestring);
	//loop through provided answers and save them:
	$question_num = 1;
	foreach($answers AS $answer) {
		$correct = -1;
		if (in_array($answer,$questions_correct[$question_num-1])) {$correct = 1;}
		$sql="INSERT INTO `42_schema`.`EDUCATION_TABLE` (`USER_ID`, `CHAPTER`, `LESSON`, `EXERCISE`, `QUESTION`, `ANSWER`, `CORRECT` ) VALUES ($user_id, $this_chapter, $this_subchapter , 8, $question_num, $answer , $correct)";
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
	$sqlretrievestring = 'DELETE FROM EDUCATION_TABLE WHERE USER_ID=' . $user_id . ' AND CHAPTER = ' . $this_chapter . ' AND LESSON = ' . $this_subchapter . ' AND EXERCISE = 9' ;
	mysqli_query($connection, $sqlretrievestring);
	//loop through provided answers and save them:
	$question_num = 1;
	foreach($answers_2 AS $answer_2) {
		$correct = -1;
		if (in_array($answer_2,$questions_correct_2[$question_num-1])) {$correct = 1;}
		$sql="INSERT INTO `42_schema`.`EDUCATION_TABLE` (`USER_ID`, `CHAPTER`, `LESSON`, `EXERCISE`, `QUESTION`, `ANSWER_TEXT`, `CORRECT` ) VALUES ($user_id, $this_chapter, $this_subchapter , 9, $question_num, '$answer_2' , $correct)";
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
	$sqlretrievestring = 'SELECT * FROM EDUCATION_TABLE WHERE USER_ID=' . $user_id . ' AND CHAPTER = ' . $this_chapter . ' AND LESSON = ' . $this_subchapter . ' AND EXERCISE = 8' ;
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
	$sqlretrievestring_2 = 'SELECT * FROM EDUCATION_TABLE WHERE USER_ID=' . $user_id . ' AND CHAPTER = ' . $this_chapter . ' AND LESSON = ' . $this_subchapter . ' AND EXERCISE = 9' ;
	$result_2 = mysqli_query($connection, $sqlretrievestring_2);
	$all_property_2 = array();  //declare an array for saving property
	while ($property_2 = mysqli_fetch_field($result_2)) {
			array_push($all_property_2, $property_2->name);  //save those to array
			}
	//loop through all of them:
	$answers_2 = array();
	while ($row_2 = mysqli_fetch_array($result_2)) {
		array_push($answers_2, $row_2['ANSWER_TEXT']);
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
		<img src="assets/images/course_3_1.png" class="img-fluid"  alt="...">
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
	<div class="col-md-1 process-wizard-step active"> <!-- complete active disabled -->
		<div class="text-center process-wizard-stepnum">Chapter 3</div>
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

<h1><span>I. Odds and probability</span></h1>
<h3>In the previous section, we discussed search and it’s application where there is perfect information – such as in games like chess. However, in the real world things are rarely so clear cut.</h3>


<p class="fs-18">Instead of perfect information, there is a host of unknown possibilities, ranging from missing information to deliberate deception.</p>
<p class="fs-18">Take a self-driving car for example — you can set the goal to get from A to B in an efficient and safe manner that follows all laws. But what happens if the traffic gets worse than expected, maybe because of an accident ahead? Sudden bad weather? Random events like a ball bouncing in the street, or a piece of trash flying straight into the car’s camera?</p>
<p class="fs-18">A self-driving car needs to use a variety of sensors, including sonar-like ones and cameras, to detect where it is and what is around it. These sensors are never perfect as the data from the sensors always includes some errors and inaccuracies called “noise”. It is very common then that one sensor indicates that the road ahead turns left, but another sensor indicates the opposite direction. This needs to be resolved without always stopping the car in case of even a slightest amount of noise.</p>

<h3>Probability</h3>
<p class="fs-18">One of the reasons why modern AI methods actually work in real-world problems – as opposed to most of the earlier “good old-fashioned" methods in the 1960-1980s – is their ability to deal with uncertainty.</p>

<div class="card card-default">
	<div class="card-block">
		<p class="fs-14">Note</p>
		<h4><span>The history of dealing with uncertainty</span></h4>
		<p class="fs-18">The history of AI has seen various competing paradigms for handling uncertain and imprecise information. For example, you may have heard of fuzzy logic. Fuzzy logic was for a while a contender for the best approach to handle uncertain and imprecise information and used in many customer-applications such as washing machines where the machine could detect the dirtiness (a matter of degrees, not only dirty or clean) and adjust the program accordingly.</p>
		<p class="fs-18">However, probability has turned out to be the best approach for reasoning under uncertainty, and almost all current AI applications are based, to at least some degree, on probabilities.</p>
	</div>
</div>

<img src="assets/images/img_3_1.svg" class="img-fluid"  alt="..."><br><br>

<h3>Why probability matters</h3>

<p class="fs-18">We are perhaps most familiar with applications of probability in games: what are the chances of getting three of a kind in poker (about 1 in 46), what are the chances of winning in the lottery (very small), and so on. However, far more importantly, probability can also be used to quantify and compare risks in everyday life: what are the chances of crashing your car if you exceed the speed limit, what are the chances that the interest rates on your mortgage will go up by five percentage points within the next five years, or what are the chances that AI will automate particular tasks such as detecting fractured bones in X-ray images or waiting tables in a restaurant.</p>

<div class="card card-default">
	<div class="card-block">
		<p class="fs-14">Note</p>
		<h4><span>The key lesson about probability</span></h4>
		<p class="fs-18">The most important lesson about probability that we’d like you to take away is not probability calculus. Instead, it is the ability to think of uncertainty as a thing that can be quantified at least in principle. This means that we can talk about uncertainty as if it were a number: numbers can be compared (“is this thing more probable than that thing”), and they can often be measured.</p>
		<p class="fs-18">Granted, measuring probabilities is hard: we usually need many observations about a phenomenon to draw conclusions. However, by systematically collecting data, we can critically evaluate probabilistic statements, and our numbers can sometimes be found to be right or wrong. In other words, the key lesson is that uncertainty is not beyond the scope of rational thinking and discussion, and probability provides a systematic way of doing just that.</p>
	</div>
</div>

<p class="fs-18">The fact that uncertainty can be quantified is of paramount importance, for example, in decision concerning vaccination or other public policies. Before entering the market, any vaccine is clinically tested, so that its benefits and risks have been quantified. The risks are never known to the minutest detail, but their magnitude is usually known to sufficient degree that it can be argued whether the benefits outweigh the risks.</p>

<div class="card card-default">
	<div class="card-block">
		<p class="fs-14">Note</p>
		<h4><span>Why quantifying uncertainty matters</span></h4>
		<p class="fs-18">If we think of uncertainty as something that can’t be quantified or measured, the uncertainty aspect may become an obstacle for rational discussion. We may for example argue that since we don’t know exactly whether a vaccine may cause a harmful side-effect, it is too dangerous to use. However, this may lead us to ignore a life-threatening disease that the vaccine will eradicate. In most cases, the benefits and risks are known to sufficient precision to clearly see that one is more significant than the other.</p>
	</div>
</div>

<p class="fs-18">The above lesson is useful in many everyday scenarios and professionally: for example, medical doctors, judges in a court of law, or investors have to process uncertain information and make rational decisions based on them. Since this is an AI course, we will discuss how probability can be used to automate uncertain reasoning. The examples we will use include medical diagnosis (although it is usually not a task that we’d wish to fully automate), and identifying fraudulent email messages (“spam”).</p>

</div>

<!-- EXERCISE -->
<div class="callout alert alert-default">
	<div class="row">
		<div class="col-md-2" valign="top">
		</div>
		<div class="col-md-7 col-sm-8"><!-- left text -->
			<h1><span>Exercise 8: Probabilistic forecasts</span></h1>
			<p class="fs-18">For this exercise, remember the key points from the above discussion: probability can be quantified (expressed as a number) and it can be right or wrong. But also keep in mind, that it is usually not possible to draw conclusions about whether a particular number was right or wrong based on a single observation.</p><br>
			<p class="fs-18">Consider the following four probabilistic forecasts and outcomes. What can we conclude based on the outcome about the correctness of the forecasts? Can we conclude that the probability given by the forecast was indeed <strong>the</strong> correct probability (choose "right"), that the forecast was wrong (choose "wrong"), or can we conclude neither way (choose "cannot be concluded")?</p><br><br>
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
					<div class="col-md-6" valign="top"><p class="fs-18">' . $question . '</p></div>';
			
			$ans = 1;
			foreach($questions_options AS $option) {
				echo '<div class="col-md-2" valign="top" align="center">';
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

<h3>Odds</h3>

<p class="fs-18">Probably the easiest way to represent uncertainty is through odds. They make it particularly easy to update beliefs when more information becomes available (we will return to this in the next section).</p>
<p class="fs-18">Before we proceed any further, we should make sure you are comfortable with doing basic manipulations on ratios (or fractions). As you probably recall, fractions are numbers like 3/4 or 21/365. We will need to multiply and divide such things, so it's good to refresh these operations if you feel unsure about them. A compact presentation for those who just need a quick reminder is <a href="https://en.wikibooks.org/wiki/Arithmetic/Multiplying_Fractions">Wikibooks: Multiplying Fractions</a>. Another fun animated presentation of the basic operations is <a href="https://www.mathsisfun.com/algebra/rational-numbers-operations.html">Math is Fun</a>: Using Rational Numbers. Feel free to consult your favorite source if necessary.</p>
<p class="fs-18">By odds, we mean for example 3:1 (three to one), which means that we expect that for every three cases of an outcome, for example winning a bet, there is one case of the opposite outcome, not winning the bet. The other way to express the same would be to say that the chances of winning are 3/4 (three in four). These are called natural frequencies since they involve only whole numbers. With whole numbers, it is easy to imagine, for example, four people out of whom, three have brown eyes. Or four days out of which it rains on three (if you’re in Helsinki).</p>

<div class="card card-default">
	<div class="card-block">
		<p class="fs-14">Note</p>
		<h4><span>Why we use odds and not percentages</span></h4>
		<p class="fs-18">Three out of four is of course the same as 75% (mathematicians prefer to use fractions like 0.75 instead of percentages). It has been found that people get confused and make mistakes more easily when dealing with fractions and percentages than with natural frequencies or odds. This is why we use natural frequencies and odds whenever convenient.</p>
	</div>
</div>

<p class="fs-18">An important thing to notice is that while expressed as two numbers, 3 and 1 for example, the odds can actually be thought of as a single fraction or a ratio, for example 3/1 (three divided by one) which is equal to 3. Thus, the odds 3:1 is the same as the odds 6:2 or 30:10 since these ratios are also equal to 3. Likewise, the odds 1:5 can be thought of as 1/5 (one divided by five) which equals 0.2. Again, this is the same as the odds 2:10 or 10:50 because that's what you get by dividing 2 by 10 or 10 by 50. But be very careful! The odds 1:5 (one win for every five losses), even if it can be expressed as the decimal number 0.2, is different from 20% probability (or probability 0.2 using the mathematicians' notation). The odds 1:5 mean that you'd have to play the game six times to get one win on the average. The probability 20% means that you'd have to play five times to get one win on the average.</p>
<p class="fs-18">For odds that are greater than one, such as 5:1, it is easy to remember that we are not dealing with probabilities because no probability can be greater than 1 (or greater than 100%), but for odds that are less than one such as 1:5, the danger of confusion lurks around the corner.</p>
<p class="fs-18">So make sure you always know when we are talking about odds and when we are talking about probabilities.</p>
<p class="fs-18">The following exercise will help you practice dealing with correspondence between odds and probabilities. Don't worry if you make some mistakes at this stage: the main goal is to learn the skills that you will need in the next sections.</p>

</div>
</div>

<!-- EXERCISE -->
<div class="callout alert alert-default">
	<div class="row">
		<div class="col-md-2" valign="top">
		</div>
		<div class="col-md-7 col-sm-8"><!-- left text -->
			<h1><span>Exercise 9: Odds</span></h1>
			<p class="fs-18">As we already mentioned above, the odds 3:1 – for example three rainy days for each rainless day – corresponds to probability 0.75 (or in percentages 75%).</p><br>
			<p class="fs-18">In general, if the odds in favor of an event are x:y, the probability of the event is given by x / (x+y). Try that with the odds 3:1 if you like. You should get the answer 0.75.</p><br>
			<p class="fs-18">As we also pointed out, the odds 6:2 corresponds to exactly the same probability as the odds 3:1 because when we let x=6 and y=2, and write them in the formula x / (x+y), we get 6/(6+2), which comes out as 6/8 = 3/4 = 0.75.</p><br>
			<p class="fs-18"><strong>Your task:</strong></p><br>
			<p class="fs-18"><strong>For the first three items 1–3</strong>, convert from odds to probabilities expressed as natural frequencies; for example from 1:1 to 1/2. Give your answer as a fraction, for example 2/3.</p><br>
			<p class="fs-18"><strong>For the last three items 4–6</strong>, convert the odds into probabilities expressed as percentages (e.g. 4.2%). Give your answer in percentages using a <strong>single</strong> decimal, for example 12.2%.</p><br>
			<p class="fs-18">Hint: the calculations are to be calculated with a simple calculator and the formulas can be found above.</p><br>
			

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
		//now the new stuff:
		$elem = 0; 
		foreach($questions_string_2 AS $question) {
			echo '<div class="row border-bottom">
					<div class="col-md-8" valign="top"><p class="fs-18">' . $question . '</p></div>';
			
			$ans = 1;
			foreach($questions_options_2 AS $option) {
				echo '<div class="col-md-1" valign="top" align="center">';
				// answer was provided:
				 if ($answers_2[$elem]<>'') {
				 	echo '<button type="button" class="btn btn-outline disabled">'.$answers_2[$elem].'</button>';

				 }
				 // no answer was provided, show radio:
				 else {$elem_2 = $elem+4; echo '<input type="text" name="'.$elem_2.'" value="" required> '.$option;}
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
		<h1>II. The Bayes Rule&nbsp;&nbsp;&nbsp;
			<?php if ($answers[0]==''){echo '<a href=""><button type="button" class="btn btn-btn-secondary btn-lg" disabled>&nbsp;&nbsp;&nbsp;CONTINUE&nbsp;&nbsp;&nbsp;</button></a>';} 
							else {echo '<a href="42_education_3_2.php"><button type="button" class="btn btn-primary btn-lg">&nbsp;&nbsp;&nbsp;CONTINUE&nbsp;&nbsp;&nbsp;</button></a>';} ?>


			
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