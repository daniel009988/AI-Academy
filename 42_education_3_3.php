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

//QUESTIONAIRE BLOCK ***********************************************************************************************************************************
$questions_string = array("Your answer...");
$questions_options = array(""); // =1, =2, =3, etc.
$questions_correct = array(array("5.1"));
$questions_correct_hint = array(
	"The correct answer is 5.1. As you may have noticed, the structure of this exercise is identical to that of the previous exercise about medical diagnosis. We have the class label spam or ham, and one piece of evidence that we can use to update our prior odds to obtain the posterior odds. We decided above that the prior odds are 1:1. The likelihood ratio is obtained by dividing the probability of the word 'million' in spam divided by the probability of the word 'million' in ham. This we already calculated above, and it can be found in the table of likelihood ratios: the value is 5.1. Now multiply the prior odds by the likelihood ratio to get 1:1 × 5.1 = 5.1. This is the posterior odds. Again, the posterior odds means that for messages that include the word 'million', there are on the average 5.1 spam messages for every ham message. Or to use whole numbers, there are 51 spam messages for every 10 ham messages. The probability value is therefore 51 / (51+10) = 51/61, or approximately 83.6 %.");

$questions_string_2 = array("Your answer...");
//answering options:
$questions_options_2 = array(""); // =1, =2, =3, etc.
//correct answers:
$questions_correct_2 = array(array("65.1168"));
//answers comments:
$questions_correct_hint_2 = array(
	"The answer is 65.1168. We start in the same way as the previous exercise. Multiplying the prior odds by the likelihood ratio 5.1 (for the word 'million') gives posterior odds 5.1. Next we'll simply keep multiplying the odds by the likelihood ratios for the rest of the message. The likelihood ratios can be found in the table above: 0.8 ('dollars'), 53.2 ('adclick'), and 0.3 ('conference'). The product of all these numbers equals 1:1 × 5.1 × 0.8 × 53.2 × 0.3 = 65.1168. This means that for messages that include all these four words, there are on the average about 65 spam messages for each ham message, or about 651 spam messages for every 10 ham messages. If we wanted to get the probability value (which was not asked), it is about 651 / (651+10) = 651 / 661 or approximately 98.5 %. This message would probably end up in your junk mail folder."
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
	$sqlretrievestring = 'DELETE FROM EDUCATION_TABLE WHERE USER_ID=' . $user_id . ' AND CHAPTER = ' . $this_chapter . ' AND LESSON = ' . $this_subchapter . ' AND EXERCISE = 12' ;
	mysqli_query($connection, $sqlretrievestring);
	//loop through provided answers and save them:
	$question_num = 1;
	foreach($answers AS $answer) {
		$correct = -1;
		if (in_array($answer,$questions_correct[$question_num-1])) {$correct = 1;}
		$sql="INSERT INTO `42_schema`.`EDUCATION_TABLE` (`USER_ID`, `CHAPTER`, `LESSON`, `EXERCISE`, `QUESTION`, `ANSWER_TEXT`, `CORRECT` ) VALUES ($user_id, $this_chapter, $this_subchapter , 12, $question_num, '$answer' , $correct)";
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
	$sqlretrievestring = 'DELETE FROM EDUCATION_TABLE WHERE USER_ID=' . $user_id . ' AND CHAPTER = ' . $this_chapter . ' AND LESSON = ' . $this_subchapter . ' AND EXERCISE = 13' ;
	mysqli_query($connection, $sqlretrievestring);
	//loop through provided answers and save them:
	$question_num = 1;
	foreach($answers_2 AS $answer_2) {
		$correct = -1;
		if (in_array($answer_2,$questions_correct_2[$question_num-1])) {$correct = 1;}
		$sql="INSERT INTO `42_schema`.`EDUCATION_TABLE` (`USER_ID`, `CHAPTER`, `LESSON`, `EXERCISE`, `QUESTION`, `ANSWER_TEXT`, `CORRECT` ) VALUES ($user_id, $this_chapter, $this_subchapter , 13, $question_num, '$answer_2' , $correct)";
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
	$sqlretrievestring = 'SELECT * FROM EDUCATION_TABLE WHERE USER_ID=' . $user_id . ' AND CHAPTER = ' . $this_chapter . ' AND LESSON = ' . $this_subchapter . ' AND EXERCISE = 12' ;
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
	$sqlretrievestring_2 = 'SELECT * FROM EDUCATION_TABLE WHERE USER_ID=' . $user_id . ' AND CHAPTER = ' . $this_chapter . ' AND LESSON = ' . $this_subchapter . ' AND EXERCISE = 13' ;
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

<h1><span>III. Naive Bayes classification</span></h1>
<h3>One of the most useful applications of the Bayes rule is the so-called naive Bayes classifier.</h3>

<p class="fs-18">The Bayes classifier is a machine learning technique that can be used to classify objects such as text documents into two or more classes. The classifier is trained by analyzing a set of training data, for which the correct classes are given.</p>
<p class="fs-18">The naive Bayes classifier can be used to determine the probabilities of the classes given a number of different observations. The assumption in the model is that the feature variables are conditionally independent given the class (we will not discuss the meaning of conditional independence in this course. For our purposes, it is enough to be able to exploit conditional independence in building the classifier).</p>

<h3>Real world application: spam filters</h3>

<p class="fs-18">We will use a spam email filter as a running example for illustrating the idea of the naive Bayes classifier. Thus, the class variable indicates whether a message is spam (or “junk email”) or whether it is a legitimate message (also called “ham”). The words in the message correspond to the feature variables, so that the number of feature variables in the model is determined by the length of the message.</p>

<div class="card card-default">
	<div class="card-block">
		<p class="fs-14">Note</p>
		<h4><span>Why we call it “naive”</span></h4>
		<p class="fs-18">Using spam filters as an example, the idea is to think of the words as being produced by choosing one word after the other so that the choice of the word depends only on whether the message is spam or ham. This is a crude simplification of the process because it means that there is no dependency between adjacent words, and the order of the words has no significance. This is in fact why the method is called naive.</p>
	</div>
</div>

<p class="fs-18">The above idea is usually depicted using the following illustration where the class of the message (spam or ham) is the only factor that has an effect on the words.</p>

<img src="assets/images/img_3_3_1.svg" class="img-fluid"  alt="..."><br><br>

<p class="fs-18">Despite it’s naivete, the naive Bayes method tends to work very well in practice. This is a good example of what the common saying in statistics, “all models are wrong, but some are useful” means (the aphorism is generally attributed to statistician <a href="https://en.wikipedia.org/wiki/George_E._P._Box">George E.P. Box)</a>.</p>

<h3>Estimating parameters</h3>

<p class="fs-18">To get started, we need to specify the prior odds for spam (against ham). For simplicity assume this to be 1:1 which means that on the average half of the incoming messages are spam (in reality, the amount of spam is probably much higher).</p>
<p class="fs-18">To get our likelihood ratios, we need two different probabilities for any word occurring: one in spam messages and another one in ham messages.</p>
<p class="fs-18">The word distributions for the two classes are best estimated from actual training data that contains some spam messages as well as legitimate messages. The simplest way is to count how many times each word, abacus, acacia, ..., zurg, appears in the data and divide the number by the total word count.</p>
<p class="fs-18">To illustrate the idea, let’s assume that we have at our disposal some spam and some ham. You can easily obtain such data by saving a batch of your emails in two files.</p>
<p class="fs-18">Assume that we have calculated the number of occurrences of the following words (along with all other words) in the two classes of messages:</p>

<div class="table-responsive">
	<table class="table table-hover font-lato fs-12 table-light">
		<thead>
			<td><strong>word</strong></td>
			<td><strong>spam</strong></td>
			<td><strong>ham</strong></td>
		</thead>
		<tbody>
			<tr><td>million</td><td>156</td><td>98</td></tr>
			<tr><td>dollars</td><td>29</td><td>119</td></tr>
			<tr><td>adclick</td><td>51</td><td>0</td></tr>
			<tr><td>conferences</td><td>0</td><td>12</td></tr>
			<tr><td><strong>total</strong></td><td>95791</td><td>306438</td></tr>
			
		</tbody>
	</table>
</div>

<p class="fs-18">We can now estimate that the probability that a word in a spam message is million, for example, is about 156 out of 95791, which is roughly the same as 1 in 614. Likewise, we get the estimate that 98 out of 306438 words, which is about the same as 1 in 3127, in a ham message are million. Both of these probability estimates are small, less than 1 in 500, but more importantly, the former is higher than the latter: 1 in 614 is higher than 1 in 3127. This means that the likelihood ratio, which is the first ratio divided by the second ratio, is more than one. To be more precise, the ratio is (1/614) / (1/3127) = 3127/614 = 5.1 (rounded to one decimal digit).</p>
<p class="fs-18">Recall that if you have any trouble at all with following the math in this section, you should refresh the arithmetic with fractions using the pointers we gave earlier (see the part about Odds in section Odds and Probability).</p>

<div class="card card-default">
	<div class="card-block">
		<p class="fs-14">Note</p>
		<h4><span>Zero means trouble</span></h4>
		<p class="fs-18">One problem with estimating the probabilities directly from the counts is that zero counts lead to zero estimates. This can be quite harmful for the performance of the classifier – it easily leads to situations where the posterior odds are 0/0, which is nonsense. The simplest solution is to use a small lower bound for all probability estimates. The value 1/100000, for instance, does the job.</p>
	</div>
</div>

<p class="fs-18">Using the above logic, we can determine the likelihood ratio for all possible words without having to use zero, giving us the following likelihood ratios:</p>

<div class="table-responsive">
	<table class="table table-hover font-lato fs-12 table-light">
		<thead>
			<td><strong>word</strong></td>
			<td><strong>likelihood ratio</strong></td>
		</thead>
		<tbody>
			<tr><td>million</td><td>5.1</td></tr>
			<tr><td>dollars</td><td>0.8</td></tr>
			<tr><td>adclick</td><td>53.2</td></tr>
			<tr><td>conferences</td><td>0.3</td></tr>
		</tbody>
	</table>
</div>

<p class="fs-18">We are now ready to apply the method to classify new messages.</p>

<h3>Example: is it spam or ham?</h3>

<p class="fs-18">Once we have the prior odds and the likelihood ratios calculated, we are ready to apply the Bayes rule, which we already practiced in the medical diagnosis case as our example. The reasoning goes just like it did before: we update the odds of spam by multiplying it by the likelihood ratio. To remind ourselves of the procedure, let's try a message with a single word to begin with. For the prior odds, as agreed above, you should use odds 1:1.</p>


</div>
</div>


<!-- EXERCISE -->
<div class="callout alert alert-default">
	<div class="row">
		<div class="col-md-2" valign="top">
		</div>
		<div class="col-md-7 col-sm-8"><!-- left text -->
			<h1><span>Exercise 12: One word spam filter</span></h1>
			<p class="fs-18">Let's start with a message that only has one word in it: “million”.</p><br>
			<p class="fs-18"><strong>Your task</strong>: Calculate the <strong>posterior odds</strong> for spam given this word using the table above. Keep in mind that the odds is <strong>not</strong> the same as the probability, which we would usually express as a percentage.</p><br>
			<p class="fs-18"><strong>Give your answer in the form of a single decimal number x.x using the dot '.' as the decimal separator.</strong></p><br>
			<p class="fs-18">(Remember that odds can be represented as xx:yy or simply as a single decimal number, say z.z (where z.z = xx/yy). You may wish to revisit the discussion on this just before Exercise 9 in Section 3.1 (Odds and Probability).)</p><br><br>
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

<p class="fs-18">To handle the rest of the words in a message, we can use exactly the same procedure. The posterior odds after one word, which you calculated in the previous exercise, will become the prior odds for the next word, and so on.</p>

</div>
</div>

<!-- EXERCISE -->
<div class="callout alert alert-default">
	<div class="row">
		<div class="col-md-2" valign="top">
		</div>
		<div class="col-md-7 col-sm-8"><!-- left text -->
			<h1><span>Exercise 13: Full spam filter</span></h1>
			<p class="fs-18">Now use the naive Bayes method to calculate the posterior odds for spam given the message “million dollars adclick conferences”.</p><br>
			<p class="fs-18">You should again start with the prior odds 1:1, and then multiply the odds repeatedly by the likelihood ratios for each of the four words. Notice that the likelihood ratios are tabulated above for your reference (these are the numbers 5.1, 0.8, and so on).</p><br>
			<p class="fs-18"><strong>Your task</strong>: Express the result as posterior odds without any rounding of the result. You may take a look at the solution of the previous exercise for help.</p><br>

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

<div class="row">
	<div class="col-md-2" valign="top">
	</div>
	<div class="col-md-7" valign="top">

<p class="fs-18">Hooray! You have now mastered a powerful technique used every day in a wide range of real-world AI applications, the naive Bayes classifier. Even if you had to skip some of the technicalities, you should try to make sure you understood the basic principles of applying probabilities to update beliefs. As we discussed in the beginning of this Chapter, the main advantage of probabilistic reasoning is the ability to handle uncertain and conflicting evidence. Using examples in medical diagnosis and spam filtering, we demonstrated how this works is practice.</p>

</div>
</div>



<!-- UP NEXT -->
<div class="card card-default">
	<div class="card-block">
		<h3>After completing Chapter 3 you should be able to:</h3>
		<blockquote>Express probabilities in terms of natural frequencies</blockquote>
		<blockquote>Apply the Bayes rule to infer risks in simple scenarios</blockquote>
		<blockquote>Explain the base-rate fallacy and avoid it by applying Bayesian reasoning</blockquote>
		
		<h3>Next:</h3>
		<h1>Chapter 4: Machine Learning&nbsp;&nbsp;&nbsp;
			<?php if ($answers[0]==''){echo '<a href=""><button type="button" class="btn btn-btn-secondary btn-lg" disabled>&nbsp;&nbsp;&nbsp;CONTINUE&nbsp;&nbsp;&nbsp;</button></a>';} 
							else {echo '<a href="42_education_4_1.php"><button type="button" class="btn btn-primary btn-lg">&nbsp;&nbsp;&nbsp;CONTINUE&nbsp;&nbsp;&nbsp;</button></a>';} ?>


			
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