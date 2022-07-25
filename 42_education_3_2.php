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
$questions_string = array("Your answer...");
$questions_options = array(""); // =1, =2, =3, etc.
$questions_correct = array(array("1854:159"));
$questions_correct_hint = array(
	"The answer is 1854:159. The prior odds are 206:159. The likelihood ratio is 9, so we get the posterior odds for rain given clouds to be 9 × 206:159 = 1854:159. So in the long run, on the days when we observe clouds in the morning, we can expect 1854 rainy days for every 159 rainless days, which is about the same as 12 rainy days for one rainless day. If we wanted to express this as a probability (even though this was not the question), we could use the formula x / (x+y) to get the value 1854 / (1854+159) which is about 0.92, or about 92% chance of rain when there are clouds in the morning. Better take an umbrella.");

$questions_string_2 = array("Your answer...");
//answering options:
$questions_options_2 = array(""); // =1, =2, =3, etc.
//correct answers:
$questions_correct_2 = array(array("40:95"));
//answers comments:
$questions_correct_hint_2 = array(
	"The prior odds describe the situation before getting the test result. Since five out of 100 women have breast cancer, there is on the average five women with breast cancer for every 95 women without breast cancer, and therefore, the prior odds are 5:95. The likelihood ratio is the probability of a positive result in case of cancer divided by the probability of a positive result in case of no cancer. With the above numbers, this is given by 80/100 divided by 10/100, which is 8. The Bayes rule now gives the posterior odds of breast cancer given the positive test result: posterior odds = 8 × 5:95 = 40:95, which is the correct answer. So despite the positive test result, the odds are actually against the person having breast cancer: among the women who are tested positive, there are on the average 40 women with breast cancer for every 95 women without breast cancer. Note: If we would like to express the chances of breast cancer given the positive test result as a probability (even though this is not what the exercise asked for), we would consider the 40 cases with cancer and the 95 cases without cancer together, and calculate what portion of the total 40 + 95 = 135 individuals have cancer. This gives the result 40 out of 135, or about 30%. This is much higher than the prevalence of breast cancer, 5 in 100, or 5%, but still the chances are that the person has no cancer. If you compare the solution to your intuitive answer, they tend to be quite different for most people. This demonstrates how poorly suited out intuition is for handling uncertain and conflicting information."
	);

//entered answers (form post): *************************************************************************************************************************
$answers = array($_POST['0']);
$answers_2 = array($_POST['1']);

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
	$sqlretrievestring = 'DELETE FROM EDUCATION_TABLE WHERE USER_ID=' . $user_id . ' AND CHAPTER = ' . $this_chapter . ' AND LESSON = ' . $this_subchapter . ' AND EXERCISE = 10' ;
	mysqli_query($connection, $sqlretrievestring);
	//loop through provided answers and save them:
	$question_num = 1;
	foreach($answers AS $answer) {
		$correct = -1;
		if (in_array($answer,$questions_correct[$question_num-1])) {$correct = 1;}
		$sql="INSERT INTO `42_schema`.`EDUCATION_TABLE` (`USER_ID`, `CHAPTER`, `LESSON`, `EXERCISE`, `QUESTION`, `ANSWER_TEXT`, `CORRECT` ) VALUES ($user_id, $this_chapter, $this_subchapter , 10, $question_num, '$answer' , $correct)";
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
	$sqlretrievestring = 'DELETE FROM EDUCATION_TABLE WHERE USER_ID=' . $user_id . ' AND CHAPTER = ' . $this_chapter . ' AND LESSON = ' . $this_subchapter . ' AND EXERCISE = 11' ;
	mysqli_query($connection, $sqlretrievestring);
	//loop through provided answers and save them:
	$question_num = 1;
	foreach($answers_2 AS $answer_2) {
		$correct = -1;
		if (in_array($answer_2,$questions_correct_2[$question_num-1])) {$correct = 1;}
		$sql="INSERT INTO `42_schema`.`EDUCATION_TABLE` (`USER_ID`, `CHAPTER`, `LESSON`, `EXERCISE`, `QUESTION`, `ANSWER_TEXT`, `CORRECT` ) VALUES ($user_id, $this_chapter, $this_subchapter , 11, $question_num, '$answer_2' , $correct)";
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
	$sqlretrievestring = 'SELECT * FROM EDUCATION_TABLE WHERE USER_ID=' . $user_id . ' AND CHAPTER = ' . $this_chapter . ' AND LESSON = ' . $this_subchapter . ' AND EXERCISE = 10' ;
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
	$sqlretrievestring_2 = 'SELECT * FROM EDUCATION_TABLE WHERE USER_ID=' . $user_id . ' AND CHAPTER = ' . $this_chapter . ' AND LESSON = ' . $this_subchapter . ' AND EXERCISE = 11' ;
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

<h1><span>II. The Bayes rule</span></h1>
<h3>We will not go too far into the details of probability calculus and all the ways in which it can be used in various AI applications, but we will discuss one very important formula.</h3>

<p class="fs-18">We will do this because this particular formula is both simple and elegant as well as incredibly powerful. It can be used to weigh conflicting pieces of evidence in medicine, in a court of law, and in many (if not all) scientific disciplines. The formula is called the <strong>Bayes rule (or the Bayes formula).</strong></p>
<p class="fs-18">We will start by demonstrating the power of the Bayes rule by means of a simple medical diagnosis problem where it highlights how poorly our intuition is suited for combining conflicting evidence. We will then show how the Bayes rule can be used to build AI methods that can cope with conflicting and noisy observations.</p>

<div class="card card-default">
	<div class="card-block">
		<p class="fs-14">Key terminology</p>
		<h4><span>Prior and posterior odds</span></h4>
		<p class="fs-18">The Bayes rule can be expressed in many forms. The simplest one is in terms of odds. The idea is to take the odds for something happening (against it not happening), which we´ll write as prior odds. The word prior refers to our assessment of the odds before obtaining some new information that may be relevant. The purpose of the formula is to update the prior odds when new information becomes available, to obtain the posterior odds, or the odds after obtaining the information (the dictionary meaning of posterior is “something that comes after, later.)”</p>
	</div>
</div>

<h3>How odds change</h3>

<p class="fs-18">In order to weigh the new information, and decide how the odds change when it becomes available, we need to consider how likely we would be to encounter this information in alternative situations. Let’s take as an example, the odds that it will rain later today. Imagine getting up in the morning in Finland. The chances of rain are 206 in 365 (including rain, snow, and hail. Brrr). The number of days without rain is therefore 159. This converts to prior odds of 206:159 for rain, so the cards are stacked against you already before you open your eyes.</p>
<p class="fs-18">However, after opening your eyes and taking a look outside, you notice it’s cloudy. Suppose the chances of having a cloudy morning on a rainy day are 9 out of 10 – that means that only one out of 10 rainy days start out with blue skies. But sometimes there are also clouds without rain: the chances of having clouds on a rainless day are 1 in 10. Now how much higher are the chances of clouds on a rainy day compared to a rainless day? Think about this carefully as it will be important to be able to comprehend the question and obtain the answer in what follows.</p>
<p class="fs-18">The answer is that the chances of clouds are <strong>nine times</strong> higher on a rainy day than on a rainless day: on a rainy day the chances are 9 out of 10, whereas on a rainless day the chances of clouds are 1 out of 10, and that makes nine times higher.</p>

<div class="card card-default">
	<div class="card-block">
		<p class="fs-14">Key terminology</p>
		<h4><span>Likelihood ratio</span></h4>
		<p class="fs-18">The above ratio (nine times higher chance of clouds on a rainy day than on a rainless day) is called the likelihood ratio. More generally, the likelihood ratio is the probability of the observation in case the event of interest (in the above, rain), divided by the probability of the observation in case of no event (in the above, no rain). Please read the previous sentence a few times. It may look a little intimidating, but it´s not impossible to digest if you just focus carefully. We will walk you through the steps in detail, just don´t lose your nerve. We´re almost there.</p>
	</div>
</div>

<p class="fs-18">So we concluded that on a cloudy morning, we have: <strong>likelihood ratio = (9/10) / (1/10) = 9</strong></p>
<p class="fs-18">The mighty Bayes rule for converting prior odds into posterior odds is – ta-daa! – as follows: <strong>posterior odds = likelihood ratio × prior odds</strong></p>
<p class="fs-18">Now you are probably thinking: Hold on, that’s the formula? It’s a frigging multiplication! That is the formula – we said it’s simple, didn’t we? You wouldn’t imagine that a simple multiplication can be used for all kinds of incredibly useful applications, but it can. We’ll study a couple examples which will demonstrate this.</p>

<div class="card card-default">
	<div class="card-block">
		<p class="fs-14">Note</p>
		<h4><span>Many forms of Bayes</span></h4>
		<p class="fs-18">In case you have any trouble with the following exercises, you may need to read the above material a few times and give it some time, and if that doesn´t do it, you can look for more material online. Just a word of advice: there are many different forms in which the Bayes rule can be written, and the odds form that we use isn´t the most common one. Here are a couple links that you may find useful.</p>
		<li><a href="https://www.youtube.com/watch?v=tRE6mKAIkno">Maths Doctor: Bayes' Theorem and medical testing</a></li>
		<li><a href="https://betterexplained.com/articles/understanding-bayes-theorem-with-ratios/">Better Explained: Understanding Bayes Theorem With Ratios</a></li>

	</div>
</div>


</div>
</div>


<!-- EXERCISE -->
<div class="callout alert alert-default">
	<div class="row">
		<div class="col-md-2" valign="top">
		</div>
		<div class="col-md-7 col-sm-8"><!-- left text -->
			<h1><span>Exercise 10: Bayes rule (part 1 of 2)</span></h1>
			<p class="fs-18">Apply the Bayes rule to calculate the <strong>posterior odds for rain</strong> having observed clouds in the morning in Helsinki.</p><br>
			<p class="fs-18">As we calculated above, the prior odds for rain is <strong>206:159</strong> and the likelihood ratio for observing clouds is <strong>9</strong></p><br>
			<p class="fs-18">Give your result in the form of odds, xx:yy, where xx and yy are numbers. (Note that xx and yy does <strong>not</strong> mean that the numbers should have two digits each.) Remember that when multiplying odds, you should only multiply the numerator (the xx part). For example, if you multiple the odds 5:3 by 5, the result is 25:3. Give the answer without simplifying the expression even if both sides have a common factor.</p><br><br>
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
					<div class="col-md-8" valign="top"><p class="fs-18">' . $question . '</p></div>';
			
			$ans = 1;
			foreach($questions_options AS $option) {
				echo '<div class="col-md-1" valign="top" align="center">';
				// answer was provided:
				 if ($answers[$elem]<>'') {
				 	echo '<button type="button" class="btn btn-outline disabled">'.$answers[$elem].'</button>';

				 }
				 // no answer was provided, show radio:
				 else {$elem = $elem; echo '<input type="text" name="'.$elem.'" value="" required> '.$option;}
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

<h3>The Bayes rule in practice: breast cancer screening</h3>

<p class="fs-18">Our first realistic application is a classical example of using the Bayes rule, namely medical diagnosis. This example also illustrates a common bias in dealing with uncertain information called the base-rate fallacy.</p>

<img src="assets/images/img_3_2_1.svg" class="img-fluid"  alt="..."><br><br>
<img src="assets/images/img_3_2_2.svg" class="img-fluid"  alt="..."><br><br>


<p class="fs-18">Consider mammographic screening for breast cancer. Using made up percentages for the sake of simplifying the numbers, let’s assume that 5 in 100 women have breast cancer. Suppose that if a person has breast cancer, then the mammograph test will find it 80 times out of 100. When the test comes out suggesting that breast cancer is present, we say that the result is positive, although of course there is nothing positive about this for the person being tested (a technical way of saying this is that the sensitivity of the test is 80%).</p>
<p class="fs-18">The test may also fail in the other direction, namely to indicate breast cancer when none exists. This is called a false positive finding. Suppose that if the person being tested actually doesn’t have breast cancer, the chances that the test nevertheless comes out positive are 10 in 100.</p>
<p class="fs-18">Based on the above probabilities, you are able to calculate the likelihood ratio. You'll find use for it in the next exercise. If you forgot how the likelihood ratio is calculated, you may wish to check the terminology box earlier in this section and revisit the rain example.</p>

</div>
</div>

<!-- EXERCISE -->
<div class="callout alert alert-default">
	<div class="row">
		<div class="col-md-2" valign="top">
		</div>
		<div class="col-md-7 col-sm-8"><!-- left text -->
			<h1><span>Exercise 11: Bayes rule (part 2 of 2)</span></h1>
			<p class="fs-18">Consider the above breast cancer scenario. An average woman takes the mammograph test and gets a positive test result suggesting breast cancer. What do you think are the odds that she has breast cancer given the observation that the test is positive?</p><br>
			<p class="fs-18">First, use your intuition without applying the Bayes rule, and write down on a piece of paper (not in the answer box below) what you think the chances of having breast cancer are after a positive test result. The intuitive answer will not be a part of your answer. It will be just for your own information.</p><br>
			<p class="fs-18">Next, <strong>calculate the posterior odds for her having breast cancer using the Bayes rule</strong>. This will be your answer.</p><br>
			<p class="fs-18">Hints:</p><br>
			<li>Start by calculating the prior odds.</li><br>
			<li>Determine the probability of the observation in case of the event (cancer).</li><br>
			<li>Determine the probability of the observation in case of no event (no cancer).</li><br>
			<li>Obtain the likelihood ratio as the ratio of the above two probabilities.</li><br>
			<li>Finally, multiply the prior odds by the likelihood ratio.</li><br>
			<p class="fs-18"><strong>Enter the posterior odds as your solution below.</strong> Give the answer in the form xx:yy where xx and yy are numbers, without simplifying the expression even if both sides have a common factor.</p><br>

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
				 else {$elem_2 = $elem+1; echo '<input type="text" name="'.$elem_2.'" value="" required> '.$option;}
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
		<h1>III. Naive Bayes Classification&nbsp;&nbsp;&nbsp;
			<?php if ($answers[0]==''){echo '<a href=""><button type="button" class="btn btn-btn-secondary btn-lg" disabled>&nbsp;&nbsp;&nbsp;CONTINUE&nbsp;&nbsp;&nbsp;</button></a>';} 
							else {echo '<a href="42_education_3_3.php"><button type="button" class="btn btn-primary btn-lg">&nbsp;&nbsp;&nbsp;CONTINUE&nbsp;&nbsp;&nbsp;</button></a>';} ?>


			
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