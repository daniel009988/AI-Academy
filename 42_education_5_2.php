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
	"What is the intercept term in the expression? 
<br>a) 543.0 
<br>b) 10.0 
<br>c) -3 
<br>d) 5.4?",
	"What are the inputs? 
<br>a) 8, 5, 22, -5, 2, -3 
<br>b) 5.4, 8, -10.2, 5, -0.1, 22, 101.4, -5, 0.0, 2, 12.0, -3 
<br>c) 5.4, -10.2, -0.1, 101.4, 0.0, 12.0 
<br>d) 43.2, -51.0, -2.2, -507.0, 0.0, -36.0",
	"Which of the inputs needs to be changed the least to increase the output by a certain amount? 
<br>a) first 
<br>b) second 
<br>c) third 
<br>d) fourth",
	"What happens when the fifth input is incremented by one? 
<br>a) nothing 
<br>b) the output increases by one 
<br>c) the output increases by two 
<br>d) something else"
	);
$questions_string_2 = array(
	"Which of the activations described above gives<br>...the largest output for an input of 5?",
	"...the smallest output for an input of -5?",
	"...the largest output for an input of -2.5?",
	);
//answering options:
$questions_options = array("A", "B", "C", "D"); // =1, =2, =3, etc.
$questions_options_2 = array("Sigmoid", "Identity", "Step"); // =1, =2, =3, etc.
//correct answers:
$questions_correct = array(array(2),array(1),array(4),array(1));
$questions_correct_2 = array(array(2),array(2),array(1));
//answers comments:
$questions_correct_hint = array(
	"The intercept is the number in the equation that is not multiplied by any variable.",
	"Compare the equation in the exercise to the one above in the definition: we defined the linear combination to be intercept + weights x inputs, so the inputs are the second numbers in the multiplication.",
	"The fourth weight is the largest one. To increase the output by some predetermined amount, the fourth input would have to be increased the least.",
	"The weight for the fifth input is 0.0, which means that no matter what value the fifth input has, its effect on the linear combination is always zero."
	);
$questions_correct_hint_2 = array(
	"The identity function will give an output of 5 for an input of 5. The sigmoid will output something very close to 1, and the step function will output exactly 1.",
	"The identity function will give an output of -5 for an input of -5. The sigmoid will output something very close to 0, and the step function will output exactly 0.",
	"For an input of -2.5, the identity function will output -2.5, and the step function will output 0. The sigmoid function will output something that is larger than 0 but smaller than 0.1."
	);

//entered answers (form post): *************************************************************************************************************************
$answers = array($_POST['0'],$_POST['1'],$_POST['2'],$_POST['3']);
$answers_2 = array($_POST['4'],$_POST['5'],$_POST['6']);

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
	$sqlretrievestring = 'DELETE FROM EDUCATION_TABLE WHERE USER_ID=' . $user_id . ' AND CHAPTER = ' . $this_chapter . ' AND LESSON = ' . $this_subchapter . ' AND EXERCISE = 21' ;
	mysqli_query($connection, $sqlretrievestring);
	//loop through provided answers and save them:
	$question_num = 1;
	foreach($answers AS $answer) {
		$correct = -1;
		if (in_array($answer,$questions_correct[$question_num-1])) {$correct = 1;}
		$sql="INSERT INTO `42_schema`.`EDUCATION_TABLE` (`USER_ID`, `CHAPTER`, `LESSON`, `EXERCISE`, `QUESTION`, `ANSWER`, `CORRECT` ) VALUES ($user_id, $this_chapter, $this_subchapter , 21, $question_num, $answer , $correct)";
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
	$sqlretrievestring = 'DELETE FROM EDUCATION_TABLE WHERE USER_ID=' . $user_id . ' AND CHAPTER = ' . $this_chapter . ' AND LESSON = ' . $this_subchapter . ' AND EXERCISE = 22' ;
	mysqli_query($connection, $sqlretrievestring);
	//loop through provided answers and save them:
	$question_num = 1;
	foreach($answers_2 AS $answer_2) {
		$correct = -1;
		if (in_array($answer_2,$questions_correct_2[$question_num-1])) {$correct = 1;}
		$sql="INSERT INTO `42_schema`.`EDUCATION_TABLE` (`USER_ID`, `CHAPTER`, `LESSON`, `EXERCISE`, `QUESTION`, `ANSWER`, `CORRECT` ) VALUES ($user_id, $this_chapter, $this_subchapter , 22, $question_num, $answer_2 , $correct)";
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
	$sqlretrievestring = 'SELECT * FROM EDUCATION_TABLE WHERE USER_ID=' . $user_id . ' AND CHAPTER = ' . $this_chapter . ' AND LESSON = ' . $this_subchapter . ' AND EXERCISE = 21' ;
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
	$sqlretrievestring_2 = 'SELECT * FROM EDUCATION_TABLE WHERE USER_ID=' . $user_id . ' AND CHAPTER = ' . $this_chapter . ' AND LESSON = ' . $this_subchapter . ' AND EXERCISE = 22' ;
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

<h1><span>II. How neural networks are built</span></h1>
<h3>As we said earlier, neurons are very simple processing units. Having discussed linear and logistic regression in Chapter 4, the essential technical details of neural networks can be seen as slight variations of the same idea.</h3>

<div class="card card-default">
	<div class="card-block">
		<p class="fs-14">Note</p>
		<h4><span>Weights and inputs</span></h4>
		<p class="fs-18">The basic artificial neuron model involves a set of adaptive parameters, called weights like in linear and logistic regression. Just like in regression, these weights are used as multipliers on the inputs of the neuron, which are added up. The sum of the weights times the inputs is called the linear combination of the inputs. You can probably recall the shopping bill analogy: you multiply the amount of each item by its price per unit and add up to get the total.</p>
	</div>
</div>

<p class="fs-18">If we have a neuron with six inputs (analogous to the amounts of the six shopping items: potatoes, carrots, and so on), input1, input2, input3, input4, input5, and input6, we also need six weights. The weights are analogous to the prices of the items. We’ll call them weight1, weight2, weight3, weight4, weight5, and weight6. In addition, we’ll usually want to include an intercept term like we did in linear regression. This can be thought of as a fixed additional charge due to processing a credit card payment, for example.</p>
<p class="fs-18">We can then calculate the linear combination like this: linear combination = intercept + weight1 × input1 + ... + weight6 × input6 (where the ... is a shorthand notation meaning that the sum include all the terms from 1 to 6).</p>
<p class="fs-18">With some example numbers we could then get:</p>

<div class="card card-default">
	<div class="card-block">
		<p class="fs-18">10.0 + 5.4 × 8 + (-10.2) × 5 + (-0.1) × 22 + 101.4 × (-5) + 0.0 × 2 + 12.0 × (-3) = -543.0</p>
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
			<h1><span>Exercise 21: Weights and inputs</span></h1>
			<p class="fs-18">In this exercise, consider the following expression that has both weights and inputs: </p><br>
			<p class="fs-18">10.0 + 5.4 × 8 + (-10.2) × 5 + (-0.1) × 22 + 101.4 × (-5) + 0.0 × 2 + 12.0 × (-3) = -543.0</p><br>
			
			

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

<div class="row">
	<div class="col-md-2" valign="top">
	</div>
	<div class="col-md-7" valign="top">

	<p class="fs-18">The weights are almost always learned from data using the same ideas as in linear or logistic regression, as discussed previously. But before we discuss this in more detail, we’ll introduce another important stage that a neuron completes before it sends out an output signal.</p>

	<h3>Activations and outputs</h3>

	<p class="fs-18">Once the linear combination has been computed, the neuron does one more operation. It takes the linear combination and puts it through a so-called activation function. Typical examples of the activation function include:</p>

	<li>identity function: do nothing and just output the linear combination</li><br>
	<li>step function: if the value of the linear combination is greater than zero, send a pulse (ON), otherwise do nothing (OFF)</li><br>
	<li>sigmoid function: a “soft” version of the step function</li><br>

	<p class="fs-18">Note that with the first activation function, the identity function, the neuron is exactly the same as linear regression. This is why the identity function is rarely used in neural networks: it leads to nothing new and interesting.</p>

	<div class="card card-default">
	<div class="card-block">
		<p class="fs-14">Note</p>
		<h4><span>How neurons activate</span></h4>
		<p class="fs-18">Real, biological neurons communicate by sending out sharp, electrical pulses called “spikes”, so that at any given time, their outgoing signal is either on or off (1 or 0). The step function imitates this behavior. However, artificial neural networks tend to use the second kind of activation functions so that they output a continuous numerical activation level at all times. Thus, to use a somewhat awkward figure of speech, real neurons communicate by something similar to the Morse code, whereas artificial neurons communicate by adjusting the pitch of their voice as if yodeling.</p>
	</div>
	</div>

	<p class="fs-18">The output of the neuron, determined by the linear combination and the activation function, can be used to extract a prediction or a decision. For example, if the network is designed to identify a stop sign in front of a self-driving car, the input can be the pixels of an image captured by a camera attached in front of the car, and the output can be used to activate a stopping procedure that stops the car before the sign.</p>
	<p class="fs-18">Learning or adaptation in the network occurs when the weights are adjusted so as to make the network produce the correct outputs, just like in linear or logistic regression. Many neural networks are very large, and the largest contain hundreds of billions of weights. Optimizing them all can be a daunting task that requires massive amounts of computing power.</p>
	
</div>
</div>



<!-- EXERCISE -->
<div class="callout alert alert-default">
	<div class="row">
		<div class="col-md-2" valign="top">
		</div>
		<div class="col-md-7 col-sm-8"><!-- left text -->
			<h1><span>Exercise 22: Activations and outputs</span></h1>
			<p class="fs-18">Below are graphs for three different activation functions with different properties. First we have the sigmoid function, then the step function, and finally the identity function.</p><br>
			<img src="assets/images/img_5_2_1.png" class="img-fluid"  alt="..."><br><br>
			<img src="assets/images/img_5_2_2.png" class="img-fluid"  alt="..."><br><br>
			<img src="assets/images/img_5_2_3.png" class="img-fluid"  alt="..."><br><br>
			

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
				 else {$elem_2 = $elem+4; echo '<input type="radio" name="'.$elem_2.'" value="'.$ans.'" required> '.$option;}
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

<div class="row">
	<div class="col-md-2" valign="top">
	</div>
	<div class="col-md-7" valign="top">

	<h3>Perceptron: the mother of all ANNs</h3>

	<p class="fs-18">The perceptron is simply a fancy name for the simple neuron model with the step activation function we discussed above. It was among the very first formal models of neural computation and because of its fundamental role in the history of neural networks, it wouldn’t be unfair to call it the “mother of all artificial neural networks”.</p>
	<p class="fs-18">It can be used as a simple classifier in binary classification tasks. A method for learning the weights of the perceptron from data, called the Perceptron algorithm, was introduced by the psychologist Frank Rosenblatt in 1957. We will not study the Perceptron algorithm in detail. Suffice to say that it is just about as simple as the nearest neighbor classifier. The basic principle is to feed the network training data one example at a time. Each misclassification leads to an update in the weight.</p>

	<div class="card card-default">
	<div class="card-block">
		<p class="fs-14">Note</p>
		<h4><span>AI hyperbole</span></h4>
		<p class="fs-18">After its discovery, the Perceptron algorithm received a lot of attention, not least because of optimistic statements made by its inventor, Frank Rosenblatt. A classic example of AI hyperbole is a New York Times article published on July 8th, 1958: “The Navy revealed the embryo of an electronic computer today that it expects will be able to walk, talk, see, reproduce itself and be conscious of its existence.”</p>
		<p class="fs-18">Please note that neural network enthusiasts are not at all the only ones inclined towards optimism. The rise and fall of the logic-based expert systems approach to AI had all the same hallmark features of an AI-hype and people claimed that the final breakthrough is just a short while away. The outcome both in the early 1960s and late 1980s was a collapse in the research funding called an AI Winter.</p>
	</div>
	</div>

	<p class="fs-18">The history of the debate that eventually lead to almost complete abandoning of the neural network approach in the 1960s for more than two decades is extremely fascinating. The article <a href="https://journals.sagepub.com/doi/10.1177/030631296026003005">A Sociological Study of the Official History of the Perceptrons Controversy by Mikel Olazaran</a> (published in Social Studies of Science, 1996) reviews the events from a sociology of science point of view. Reading it today is quite thought provoking. Reading stories about celebrated AI heroes who had developed neural networks algorithms that would soon reach the level of human intelligence and become self-conscious can be compared to some statements made during the current hype. If you take a look at the above article, even if you wouldn't read all of it, it will provide an interesting background to today's news. Consider for example an <a href="https://www.technologyreview.com/s/608911/is-ai-riding-a-one-trick-pony/">article in the MIT Technology Review</a> published in September 2017, where Jordan Jacobs, co-founder of a multimillion dollar Vector institute for AI compares Geoffrey Hinton (a figure-head of the current deep learning boom) to Einstein because of his contributions to development of neural network algorithms in the 1980s and later. Also recall the Human Brain project mentioned in the previous section.</p>
	<p class="fs-18">According to Hinton, “the fact that it doesn’t work is just a temporary annoyance” (although according to the article, Hinton is laughing about the above statement, so it's hard to tell how serious he is about it). The Human Brain project claims to be <a href="https://www.humanbrainproject.eu/en/follow-hbp/news/the-quest-for-consciousness/">“close to a profound leap in our understanding of consciousness“</a>. Doesn't that sound familiar?</p>
	<p class="fs-18">No-one really knows the future with certainty, but knowing the track record of earlier announcements of imminent breakthroughs, some critical thinking is advised. We'll return to the future of AI in the final chapter, but for now, let's see how artificial neural networks are built.</p>

	<h3>Putting neurons together: networks</h3>

	<p class="fs-18">A single neuron would be way too simple to make decisions and prediction reliably in most real-life applications. To unleash the full potential of neural networks, we can use the output of one neuron as the input of other neurons, whose outputs can be the input to yet other neurons, and so on. The output of the whole network is obtained as the output of a certain subset of the neurons, which are called the output layer. We’ll return to this in a bit, after we discussed the way neural networks adapt to produce different behaviors by learning their parameters from data.</p>

	<div class="card card-default">
	<div class="card-block">
		<p class="fs-14">Key terminology</p>
		<h4><span>Layers</span></h4>
		<p class="fs-18">Often the network architecture is composed of layers. The input layer consists of neurons that get their inputs directly from the data. So for example, in an image recognition task, the input layer would use the pixel values of the input image as the inputs of the input layer. The network typically also has hidden layers that use the other neurons´ outputs as their input, and whose output is used as the input to other layers of neurons. Finally, the output layer produces the output of the whole network. All the neurons on a given layer get inputs from neurons on the previous layer and feed their output to the next.</p>
	</div>
	</div>


	<p class="fs-18">A classical example of a multilayer network is the so-called multilayer perceptron. As we discussed above, Rosenblatt’s Perceptron algorithm can be used to learn the weights of a perceptron. For multilayer perceptron, the corresponding learning problem is way harder and it took a long time before a working solution was discovered. But eventually, one was invented: the backpropagation algorithm lead to a revival of neural networks in the late 1980s. It is still at the heart of many of the most advanced deep learning solutions.</p>
	<p class="fs-18"></p>

	<div class="card card-default">
	<div class="card-block">
		<p class="fs-14">Note</p>
		<h4><span>Meanwhile in Helsinki...</span></h4>
		<p class="fs-18">The path(s) leading to the backpropagation algorithm are rather long and winding. An interesting part of the history is related to the computer science department of the University of Helsinki. About three years after the founding of the department in 1967, a <a href="http://people.idsia.ch/~juergen/linnainmaa1970thesis.pdf">Master’s thesis</a> was written by a student called Seppo Linnainmaa. The topic of the thesis was “Cumulative rounding error of algorithms as a Taylor approximation of individual rounding errors” (the thesis was written in Finnish, so this is a translation of the actual title “Algoritmin kumulatiivinen pyöristysvirhe yksittäisten pyöristysvirheiden Taylor-kehitelmänä”).</p>
		<p class="fs-18">The automatic differentiation method developed in the thesis was later applied by other researchers to quantify the sensitivity of the output of a multilayer neural network with respect to the individual weights, which is the key idea in backpropagation.</p>
	</div>
	</div>

	<h3>A simple neural network classifier</h3>

	<p class="fs-18">To give a relatively simple example of using a neural network classifier, we'll consider a task that is very similar to the MNIST digit recognition task, namely classifying images in two classes. We will first create a classifier to classify whether an image shows a cross (x) or a circle (o). Our images are represented here as pixels that are either colored or white, and the pixels are arranged in 5 × 5 grid. In this format our images of a cross and a circle (more like a diamond, to be honest) look like this:</p>

	<img src="assets/images/img_5_2_4.png" class="img-fluid"  alt="..."><br><br>
	<p class="fs-18">In order to build a neural network classifier, we need to formalize the problem in a way where we can solve it using the methods we have learned. Our first step is to represent the information in the pixels by numerical values that can be used as the input to a classifier. Let's use 1 if the square is colored, and 0 if it is white. Note that although the symbols in the above graphic are of different color (green and blue), our classifier will ignore the color information and use only the colored/white information. The 25 pixels in the image make the inputs of our classifier.</p>
	<p class="fs-18">To make sure that we know which pixel is which in the numerical representation, we can decide to list the pixels in the same order as you'd read text, so row by row from the top, and reading each row from left to right. The first row of the cross, for example, is represented as 1,0,0,0,1; the second row as 0,1,0,1,0, and so on. The full input for the cross input is then: 1,0,0,0,1,0,1,0,1,0,0,0,1,0,0,0,1,0,1,0,1,0,0,0,1.</p>
	<p class="fs-18">We'll use the basic neuron model where the first step is to compute a linear combination of the inputs. Thus need a weight for each of the input pixels, which means 25 weights in total.</p>
	<p class="fs-18">Finally, we use the step activation function. If the linear combination is negative, the neuron activation is zero, which we decide to use to signify a cross. If the linear combination is positive, the neuron activation is one, which we decide to signify a circle.</p>
	<p class="fs-18">Let's try what happens when all the weights take the same numerical value, 1. With this setup, our linear combination for the cross image will be 9 (9 colored pixels, so 9 × 1, and 16 white pixels, 16 × 0), and for the circle image it will be 8 (8 colored pixels, 8 × 1, and 17 white pixels, 17 × 0). In other words, the linear combination is positive for both images and they are thus classified as circles. Not a very good result given that there are only two images to classify.</p>
	<p class="fs-18">To improve the result, we need to adjust the weights in such a way that the linear combination will negative for a cross and positive for a circle. If we think about what differentiates images of crosses and circles, we can see that circles have no colored pixels in the center of the image, whereas crosses do. Likewise, the pixels at the corners of the image are colored in the cross, but white in the circle.</p>
	<p class="fs-18">We can now adjust the weights. There are an infinite number of weights that do the job. For example, assign weight -1 to the center pixel (the 13th pixel), and weight 1 to the pixels in the middle of each of the four sides of the image, letting all the other weights be 0. Now, for the cross input, the center pixel produce the value –1, while for all the other pixels either the pixel value of the weight is 0, so that –1 is also the total value. This leads to activation 0, and the cross is correctly classified.</p>
	<p class="fs-18">How about the circle then? Each of the pixels in the middle of the sides produces the value 1, which makes 4 × 1 = 4 in total. For all the other pixels either the pixel value or the weight is zero, so 4 is the total. Since 4 is a positive value, the activation is 1, and the circle is correctly recognized as well.</p>

	<h3>Happy or not?</h3>
	<p class="fs-18">We will now follow similar reasoning to build a classifier for smiley faces. You can assign weights to the input pixels in the image by clicking on them. Clicking once sets the weight to 1, and clicking again sets it to -1. The activation 1 indicates that the image is classified as a happy face, which can be correct or not, while activation –1 indicates that the image is classified as a sad face.</p>
	<p class="fs-18">Don't be discouraged by the fact that you will not be able to classify all the smiley faces correctly: it is in fact impossible with our simple classifier! This is one important learning objective: sometimes perfect classification just isn't possible because the classifier is too simple. In this case the simple neuron that uses a linear combination of the inputs is too simple for the task. Observe how you can build classifiers that work well in different cases: some classify most of the happy faces correctly while being worse for sad faces, or the other way around.</p>
	<p class="fs-18">Can you achieve 6/8 correct for both happy and sad faces?</p>
	<img src="assets/images/img_5_2_5.png" class="img-fluid"  alt="..."><br><br>
	<p class="fs-18">0/8 happy faces classified correctly</p>
	<img src="assets/images/img_5_2_6.png" class="img-fluid"  alt="..."><br><br>
	<p class="fs-18">0/8 sad faces classified correctly</p>
	<img src="assets/images/img_5_2_7.png" class="img-fluid"  alt="..."><br><br>
	

	

</div>
</div>



<div class="card card-default">
	<div class="card-block">
		<h3>Next:</h3>
		<h1>III. Advanced neural network techniques&nbsp;&nbsp;&nbsp;
			<?php if (($answers[0]=='') OR ($answers_2[0]=='')){echo '<a href=""><button type="button" class="btn btn-btn-secondary btn-lg" disabled>&nbsp;&nbsp;&nbsp;CONTINUE&nbsp;&nbsp;&nbsp;</button></a>';} 
							else {echo '<a href="42_education_5_3.php"><button type="button" class="btn btn-primary btn-lg">&nbsp;&nbsp;&nbsp;CONTINUE&nbsp;&nbsp;&nbsp;</button></a>';} ?>
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