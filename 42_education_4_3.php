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
$this_chapter    = 4;
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
$questions_string = array("A","B","C");
$questions_options = array(""); // =1, =2, =3, etc.
$questions_correct = array(array("81"),array("73"),array("84"));
$questions_correct_hint = array(
	"A: 80 - 5 + 6 = 81",
	"B: 80 - 8 + 1 = 73",
	"C: 80 + 4 = 84");

$questions_string_2 = array("Your answer...");
//answering options:
$questions_options_2 = array("exactly 64 years","certainly between 60 and 70 years","certainly 70 years or less","probabily less than 90"); // =1, =2, =3, etc.
//correct answers:
$questions_correct_2 = array(array(4));
//answers comments:
$questions_correct_hint_2 = array(
	"The few data points that we have make it impossible say almost anything about the life expectancy only based on the data. Of course, one can know a great deal about life expectancy from other sources but the data in the above chart is insufficient to do so. The first choice is clearly stating too much. While the intervals in the second and the third choice are likely to be valid, the word 'certainly' makes them unjustified. There is a chance, greater than zero, that the value turns out to be, for example, greater than 70. Thus the only choice that we can be comfortable with is the fourth one."
	);

$questions_string_3 = array("Your answer...");
//answering options:
$questions_options_3 = array("Probably between 45 and 50 years","Probably between 50 and 90 years","Probably between 69 and 71 years","probabily between 15 and 150 years"); // =1, =2, =3, etc.
//correct answers:
$questions_correct_3 = array(array(2));
//answers comments:
$questions_correct_hint_3 = array(
	"The first choice would clearly be an odd estimate since the data strongly suggest that very few countries have life expectancy less than 50, and none of the data points with more than 12 years of education fall below 50. We can't be sure, of course, but life expectancy between 45 and 50 years would in this case be highly unexpected. The second choice is correct because it fits the general trend, and all data points with more than 12 years of education fall within this interval. The interval 69 to 71 years in the third choice could well include the actual value, but based on the above data, it would be too bold to claim to know the outcome with such high accuracy. The interval 15 to 150 years of the fourth choice would almost certainly include the actual value, but we think that it would be a poor summary of what we can learn from the data for the reason that it is too vague."
	);

$questions_string_4 = array("Your answer...");
//answering options:
$questions_options_4 = array("6-7 hours","7-8 hours","8-9 hours","10-11 hours"); // =1, =2, =3, etc.
//correct answers:
$questions_correct_4 = array(array(4));
//answers comments:
$questions_correct_hint_4 = array(
	"6-7 hours of studying gives you roughly a 30% chance of passing. To have an 80% chance of passing, you should study for around 10-11 hours."
	);



//entered answers (form post): *************************************************************************************************************************
$answers = array($_POST['0'],$_POST['1'],$_POST['2']);
$answers_2 = array($_POST['3']);
$answers_3 = array($_POST['4']);
$answers_4 = array($_POST['5']);

echo '>answers: '.$answers.'<br>';
echo '>answers_2: '.$answers_2.'<br>';
echo '>answers_3: '.$answers_3.'<br>';
echo '>answers_4: '.$answers_4.'<br>';

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
	$sqlretrievestring = 'DELETE FROM EDUCATION_TABLE WHERE USER_ID=' . $user_id . ' AND CHAPTER = ' . $this_chapter . ' AND LESSON = ' . $this_subchapter . ' AND EXERCISE = 16' ;
	mysqli_query($connection, $sqlretrievestring);
	//loop through provided answers and save them:
	$question_num = 1;
	foreach($answers AS $answer) {
		$correct = -1;
		if (in_array($answer,$questions_correct[$question_num-1])) {$correct = 1;}
		$sql="INSERT INTO `42_schema`.`EDUCATION_TABLE` (`USER_ID`, `CHAPTER`, `LESSON`, `EXERCISE`, `QUESTION`, `ANSWER`, `CORRECT` ) VALUES ($user_id, $this_chapter, $this_subchapter , 16, $question_num, '$answer' , $correct)";
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
	$sqlretrievestring = 'DELETE FROM EDUCATION_TABLE WHERE USER_ID=' . $user_id . ' AND CHAPTER = ' . $this_chapter . ' AND LESSON = ' . $this_subchapter . ' AND EXERCISE = 17' ;
	mysqli_query($connection, $sqlretrievestring);
	//loop through provided answers and save them:
	$question_num = 1;
	foreach($answers_2 AS $answer_2) {
		$correct = -1;
		if (in_array($answer_2,$questions_correct_2[$question_num-1])) {$correct = 1;}
		$sql="INSERT INTO `42_schema`.`EDUCATION_TABLE` (`USER_ID`, `CHAPTER`, `LESSON`, `EXERCISE`, `QUESTION`, `ANSWER`, `CORRECT` ) VALUES ($user_id, $this_chapter, $this_subchapter , 17, $question_num, '$answer_2' , $correct)";
		if ($connection->query($sql) === TRUE) {} else {echo "Error: " . $sql . "<br>" . $connection->error;}
		$question_num = $question_num + 1;
	}
	$connection->close();
}
if ($answers_3[0]<>''){
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
	$sqlretrievestring = 'DELETE FROM EDUCATION_TABLE WHERE USER_ID=' . $user_id . ' AND CHAPTER = ' . $this_chapter . ' AND LESSON = ' . $this_subchapter . ' AND EXERCISE = 18' ;
	mysqli_query($connection, $sqlretrievestring);
	//loop through provided answers and save them:
	$question_num = 1;
	foreach($answers_3 AS $answer_3) {
		$correct = -1;
		if (in_array($answer_3,$questions_correct_3[$question_num-1])) {$correct = 1;}
		$sql="INSERT INTO `42_schema`.`EDUCATION_TABLE` (`USER_ID`, `CHAPTER`, `LESSON`, `EXERCISE`, `QUESTION`, `ANSWER`, `CORRECT` ) VALUES ($user_id, $this_chapter, $this_subchapter , 18, $question_num, '$answer_3' , $correct)";
		if ($connection->query($sql) === TRUE) {} else {echo "Error: " . $sql . "<br>" . $connection->error;}
		$question_num = $question_num + 1;
	}
	$connection->close();
}
if ($answers_4[0]<>''){
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
	$sqlretrievestring = 'DELETE FROM EDUCATION_TABLE WHERE USER_ID=' . $user_id . ' AND CHAPTER = ' . $this_chapter . ' AND LESSON = ' . $this_subchapter . ' AND EXERCISE = 19' ;
	mysqli_query($connection, $sqlretrievestring);
	//loop through provided answers and save them:
	$question_num = 1;
	foreach($answers_4 AS $answer_4) {
		$correct = -1;
		if (in_array($answer_4,$questions_correct_4[$question_num-1])) {$correct = 1;}
		$sql="INSERT INTO `42_schema`.`EDUCATION_TABLE` (`USER_ID`, `CHAPTER`, `LESSON`, `EXERCISE`, `QUESTION`, `ANSWER`, `CORRECT` ) VALUES ($user_id, $this_chapter, $this_subchapter , 19, $question_num, '$answer_4' , $correct)";
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
	$sqlretrievestring = 'SELECT * FROM EDUCATION_TABLE WHERE USER_ID=' . $user_id . ' AND CHAPTER = ' . $this_chapter . ' AND LESSON = ' . $this_subchapter . ' AND EXERCISE = 16' ;
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
	$sqlretrievestring_2 = 'SELECT * FROM EDUCATION_TABLE WHERE USER_ID=' . $user_id . ' AND CHAPTER = ' . $this_chapter . ' AND LESSON = ' . $this_subchapter . ' AND EXERCISE = 17' ;
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
	$sqlretrievestring_3 = 'SELECT * FROM EDUCATION_TABLE WHERE USER_ID=' . $user_id . ' AND CHAPTER = ' . $this_chapter . ' AND LESSON = ' . $this_subchapter . ' AND EXERCISE = 18' ;
	$result_3 = mysqli_query($connection, $sqlretrievestring_3);
	$all_property_3 = array();  //declare an array for saving property
	while ($property_3 = mysqli_fetch_field($result_3)) {
			array_push($all_property_3, $property_3->name);  //save those to array
			}
	//loop through all of them:
	$answers_3 = array();
	while ($row_3 = mysqli_fetch_array($result_3)) {
		array_push($answers_3, $row_3['ANSWER']);
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
	$sqlretrievestring_4 = 'SELECT * FROM EDUCATION_TABLE WHERE USER_ID=' . $user_id . ' AND CHAPTER = ' . $this_chapter . ' AND LESSON = ' . $this_subchapter . ' AND EXERCISE = 19' ;
	$result_4 = mysqli_query($connection, $sqlretrievestring_4);
	$all_property_4 = array();  //declare an array for saving property
	while ($property_4 = mysqli_fetch_field($result_4)) {
			array_push($all_property_4, $property_4->name);  //save those to array
			}
	//loop through all of them:
	$answers_4 = array();
	while ($row_4 = mysqli_fetch_array($result_4)) {
		array_push($answers_4, $row_4['ANSWER']);
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
		<div class="process-wizard-info text-center">&nbsp;</div>
	</div>
	<div class="col-md-1 process-wizard-step complete"> <!-- complete active disabled -->
		<div class="text-center process-wizard-stepnum">Chapter 4</div>
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

<h1><span>III. Regression</span></h1>
<h3>Our main learning objective in this section is another nice example of supervised learning methods, and almost as simple as the nearest neighbor classifier too: linear regression. We'll introduce its close cousin, logistic regression as well.</h3>

<div class="card card-default">
	<div class="card-block">
		<p class="fs-14">Note</p>
		<h4><span>The difference between classification and regression</span></h4>
		<p class="fs-18">There is a small but important difference in the kind of predictions that we should produce in different scenarios. While for example the nearest neighbor classifier chooses a class label for any item out of a given set of alternatives (like spam/ham, or 0,1,2,...,9), linear regression produces a numerical prediction that is not constrained to be an integer (a whole number as opposed to something like 3.14). So linear regression is better suited in situations where the output variable can be any number like the price of a product, the distance to an obstacle, the box-office revenue of the next Star Wars movie, and so on.</p>
	</div>
</div>

<p class="fs-18">The basic idea in linear regression is to add up the effects of each of the feature variables to produce the predicted value. The technical term for the adding up process is linear combination. The idea is very straightforward, and it can be illustrated by your shopping bill.</p>

<div class="card card-default">
	<div class="card-block">
		<p class="fs-14">Note</p>
		<h4><span>Thinking of linear regression as a shopping bill</span></h4>
		<p class="fs-18">Suppose you go to the grocery store and buy 2.5kg potatoes, 1.0kg carrots, and two bottles of milk. If the price of potatoes is 2€ per kg, the price of carrots is 4€ per kg, and a bottle of milk costs 3€, then the bill, calculated by the cashier, totals 2.5 × 2€ + 1.0 × 4€ + 2 × 3€ = 15€. In linear regression, the amount of potatoes, carrots, and milk are the inputs in the data. The output is the cost of your shopping, which clearly depends on both the price and how much of each product you buy.</p>
	</div>
</div>

<p class="fs-18">The word linear means that the increase in the output when one input feature is increased by some fixed amount is always the same. In other words, whenever you add, say, two kilos of carrots into your shopping basket, the bill goes up 8€. When you add another two kilos, the bill goes up another 8€, and if you add half as much, 1kg, the bill goes up exactly half as much, 4€.</p>

<div class="card card-default">
	<div class="card-block">
		<p class="fs-14">Key terminology</p>
		<h4><span>Coefficients or weights</span></h4>
		<p class="fs-18">In linear regression terminology, the prices of the different products would be called coefficients or weights (this may appear confusing since we measured the amount of potatoes and carrots by weight, but not let yourself be tricked by this). One of the main advantages of linear regression is its easy interpretability: the learned weights may in fact be more interesting than the predictions of the outputs.</p>
		<p class="fs-18">For example, when we use linear regression to predict the life expectancy, the weight of smoking (cigarettes per day) is about minus half a year, meaning that smoking one cigarette more per day takes you on the average half a year closer to termination. Likewise, the weight of vegetable consumption (handful of vegetables per day) has weight plus one year, so eating a handful of greens gives every day gives you on the average one more year.</p>

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
			<h1><span>Exercise 16: Linear regression</span></h1>
			<p class="fs-18">Suppose that an extensive study is carried out, and it is found that in a particular country, the life expectancy (the average number of years that people live) among non-smoking women who don't eat any vegetables is 80 years. Suppose further that on the average, men live 5 years less. Also take the numbers mentioned above: every cigarette per day reduces the life expectancy by half a year, and a handful of veggies per day increases it by one year.</p><br>
			<p class="fs-18">Calculate the life expectancies for the following example cases:</p><br>
			<p class="fs-18">For example, the first case is a male (subtract 5 years), smokes 8 cigarettes per day (subtract 8 × 0.5 = 4 years), and eats two handfuls of veggies per day (add 2 × 1 = 2 years), so the predicted life expectancy is 80 - 5 - 4 + 2 = 73 years.</p><br>
			<table class="table table-hover font-lato fs-12 table-light">
				<thead>
					<td><strong>Gender</strong></td>
					<td><strong>Smoking (cigarettes per day)</strong></td>
					<td><strong>Vegetables (handfuls per day)</td>
					<td><strong>Life expectancy (years)</td>
				</thead>
				<tbody>
					<tr><td>male</td><td>8</td><td>2</td><td>73</td></tr>
					<tr><td>male</td><td>0</td><td>6</td><td>A</td></tr>
					<tr><td>female</td><td>16</td><td>1</td><td>B</td></tr>
					<tr><td>female</td><td>0</td><td>4</td><td>C</td></tr>
					
				</tbody>
			</table>
			<p class="fs-18"><strong>Your task:</strong> Enter the correct value as an integer (whole number) for the missing sections A, B, and C above.</p><br>
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

<p class="fs-18">In the above exercise, the life expectancy of non-smoking, veggie-hating women, 80 years, was the starting point for the calculation. The technical term for the starting point is the <strong>intercept</strong>. We will return to this below when we discuss how to learn linear regression models from data.</p>

<h3>Learning linear regression</h3>

<p class="fs-18">Above, we discussed how predictions are obtained from linear regression when both the weights and the input features are known. So we are given the inputs and the weight, and we can produce the predicted output.</p>
<p class="fs-18">When we are given the inputs and the outputs for a number of items, we can find the weights such that the predicted output matches the actual output as well as possible. This is the task solved by machine learning.</p>
<p class="fs-18"></p>


<div class="card card-default">
	<div class="card-block">
		<p class="fs-14">Note</p>
		<h4><span>Example</span></h4>
		<p class="fs-18">Continuing the shopping analogy, suppose we were given the contents of a number of shopping baskets and the total bill for each of them, and we were asked to figure out the price of each of the products (potatoes, carrots, and so on). From one basket, say 1kg of sirloin steak, 2kg of carrots, and a bottle of Chianti, even if we knew that the total bill is 35€, we couldn't determine the prices because there are many sets of prices that will yield the same total bill. With many baskets, however, we will usually be able to solve the problem.</p>
	</div>
</div>

<p class="fs-18">But the problem is made harder by the fact that in the real world, the actual output isn’t always fully determined by the input, because of various factors that introduce uncertainty or “noise” into the process. You can think of shopping at a bazaar where the prices for any given product may vary from time to time, or a restaurant where the final damage includes a variable amount of tip. In such situations, we can estimate the prices but only with some limited accuracy.</p>
<p class="fs-18">Finding the weights that optimize the match between the predicted and the actual outputs in the training data is a classical statistical problem dating back to the 1800s, and it can be easily solved even for massive data sets.</p>
<p class="fs-18">We will not go into the details of the actual weight-finding algorithms, such as the classical least squares technique, simple as they are. However, you can get a feel of finding trends in data in the following exercises.</p>

<h3>Visualizing linear regression</h3>
<p class="fs-18">A good way to get a feel for what linear regression can tell us is to draw a chart containing our data and our regression results. As a simple toy example our data set has one variable, the number of cups of coffee an employee drinks per day, and the number on lines of code written per day by that employee as the output. This is not a real data set as obviously there are other factors having an effect on the productivity of an employee other than coffee that interact in complex ways. The increase in productivity by increasing the amount of coffee will also hold only to a certain point after which the jitters distract too much.</p>

<img src="assets/images/img_4_3_1.png" class="img-fluid"  alt="..."><br><br>

<p class="fs-18">When we present our data in the chart above as points where one point represents one employee, we can see that there is obviously a trend that drinking more coffee results in more lines of code being written (recall that this is completely made-up data). From this data set we can learn the coefficient, or the weight, related to coffee consumption, and by eye we can already say that it seems to be somewhere close to five, since for each cup of coffee consumed the number of lines programmed seems to go up roughly by five. For example, employees who drink around two cups of coffee per day seem to produce around 20 lines of code per day, and similarly at four cups of coffee, the amount of lines produced is around 30.</p>
<p class="fs-18">It can also be noted that employees who do not drink coffee at all also produce code, and is shown by the graph to be about ten lines. This number is the intercept term that we mentioned earlier. The intercept is another parameter in the model just like the weights are, that can be learned from the data. Just as in the life expectancy example it can be thought of as the starting point of our calculations before we have added in the effects of the input variable, or variables if we have more than one, be it coffee cups in this example, or cigarettes and vegetables in the previous one.</p>
<p class="fs-18">The line in the chart represents our predicted outcome, where we have estimated the intercept and the coefficient by using an actual linear regression technique called least squares. This line can be used to predict the number of lines produced when the input is the number of cups of coffee. Note that we can obtain a prediction even if we allow only partial cups (like half, 1/4 cups, and so on).</p>



</div>
</div>
<!-- EXERCISE -->
<div class="callout alert alert-default">
	<div class="row">
		<div class="col-md-2" valign="top">
		</div>
		<div class="col-md-7 col-sm-8"><!-- left text -->
			<h1><span>Exercise 17: Life expectancy and education (part 1 of 2)</span></h1>
			<p class="fs-18">Let's study the link between the total number of years spent in school (including everything between preschool and university) and life expectancy. Here is data from three different countries displayed in a figure represented by dots:</p><br>
			<img src="assets/images/img_4_3_2.png" class="img-fluid"  alt="..."><br><br>
			<p class="fs-18">We have one country where the average number of years in school is 10 and life expectancy is 57 years, another country where the average number of years in school is 13 and life expectancy is 53 years, and a third country where the average number of years in school is 20 and life expectancy is 80 years.</p><br>
			<p class="fs-18">You can drag the end points of the solid line to position the line in such a way that it follows the trend of the data points. Note that you will not be able to get the line fit perfectly with the data points, and this is fine: some of the data points will lie above the line, and some below it. The most important part is that the line describes the overall trend.</p><br>
			<p class="fs-18">After you have positioned the line you can use it to predict the life expectancy.</p><br>
			<p class="fs-18">Given the data, what can you tell about the life expectancy of people who have 15 years of education? Important: Notice that even if you can obtain a specific prediction, down to a fraction of a year, by adjusting the line, you may not necessarily be able to give a confident prediction. Take the limited amount of data into account when giving your answer.</p><br>
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
					<div class="col-md-4" valign="top"><p class="fs-18">' . $question . '</p></div>';
			
			$ans = 1;
			foreach($questions_options_2 AS $option) {
				echo '<div class="col-md-2 valign="top" align="center">';
				// answer was provided:
				 if ($answers_2[$elem]<>'') {
				 	$pot_cor = 0; if (in_array($ans, $questions_correct_2[$elem])) {$pot_cor = 1;}
				 	$cor = 0; if (in_array($answers_2[$elem], $questions_correct_2[$elem])) {$cor = 1;}
				 	if (($pot_cor==0) & ($answers_2[$elem]==$ans)) {echo '<button type="button" class="btn btn-outline-danger disabled fs-10">'.$option.'</button>';}
				 	if (($pot_cor==0) & ($answers_2[$elem]<>$ans)) {echo '<button type="button" class="btn disabled fs-10">'.$option.'</button>';}
				 	if (($pot_cor==1) & ($cor==1)) {echo '<button type="button" class="btn btn-outline-success disabled fs-10">'.$option.'</button>';}
				 	if (($pot_cor==1) & ($cor==0)) {echo '<button type="button" class="btn btn-outline-success disabled fs-10">'.$option.'</button>';}

				 }
				 // no answer was provided, show radio:
				 else {$elem_2 = $elem+3; echo '<input type="radio" name="'.$elem_2.'" value="'.$ans.'" required> '.$option;}
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

<!-- EXERCISE -->
<div class="callout alert alert-default">
	<div class="row">
		<div class="col-md-2" valign="top">
		</div>
		<div class="col-md-7 col-sm-8"><!-- left text -->
			<h1><span>Exercise 18: Life expectancy and education (part 2 of 2)</span></h1>
			<p class="fs-18">In the previous exercise, we only had data from three countries. The full data set consists of data from 14 different countries, presented here in a graph:</p><br>
			<img src="assets/images/img_4_3_3.png" class="img-fluid"  alt="..."><br><br>
			<p class="fs-18">Based on this data, would your prediction about the life expectancy of people with 15 years of education change? If so, why?</p><br>
			<p class="fs-18">Which of the following options would best match your estimate of the life expectancy for people with 15 years of education? Choose the most specific option that you think is justified by fitting the straight line model to the above data.</p><br>
		</div>
		<div class="col-md-3" valign="top">
		</div>
	</div>
</div>

<div class="card card-default" id="exercise7">
	<div class="card-block">
		<p class="fs-14">Answer the questions below</p>
		
	
<form class="m-0" method="post" action="#exercise7" autocomplete="off">
	<!-- QUESTIONS -->
	<?php
		//now the new stuff:
		$elem = 0; 
		foreach($questions_string_3 AS $question) {
			echo '<div class="row border-bottom">
					<div class="col-md-4" valign="top"><p class="fs-18">' . $question . '</p></div>';
			
			$ans = 1;
			foreach($questions_options_3 AS $option) {
				echo '<div class="col-md-2 valign="top" align="center">';
				// answer was provided:
				 if ($answers_3[$elem]<>'') {
				 	$pot_cor = 0; if (in_array($ans, $questions_correct_3[$elem])) {$pot_cor = 1;}
				 	$cor = 0; if (in_array($answers_3[$elem], $questions_correct_3[$elem])) {$cor = 1;}
				 	if (($pot_cor==0) & ($answers_3[$elem]==$ans)) {echo '<button type="button" class="btn btn-outline-danger disabled fs-10">'.$option.'</button>';}
				 	if (($pot_cor==0) & ($answers_3[$elem]<>$ans)) {echo '<button type="button" class="btn disabled fs-10">'.$option.'</button>';}
				 	if (($pot_cor==1) & ($cor==1)) {echo '<button type="button" class="btn btn-outline-success disabled fs-10">'.$option.'</button>';}
				 	if (($pot_cor==1) & ($cor==0)) {echo '<button type="button" class="btn btn-outline-success disabled fs-10">'.$option.'</button>';}

				 }
				 // no answer was provided, show radio:
				 else {$elem_3 = $elem+4; echo '<input type="radio" name="'.$elem_3.'" value="'.$ans.'" required> '.$option;}
				 echo '</div>';
				 $ans = $ans + 1;
			}
			
			
			if (($answers_3[$elem]<>'') & (in_array($answers_3[$elem], $questions_correct_3[$elem]))) {echo '<div class="alert alert-success mb-30 col-md-12"><strong>Well done!</strong>&nbsp;&nbsp;'.$questions_correct_hint_3[$elem].'</div>';} 
			if (($answers_3[$elem]<>'') & (in_array($answers_3[$elem], $questions_correct_3[$elem])==false)) {echo '<div class="alert alert-danger mb-30 col-md-12"><strong>Oh snap!</strong>&nbsp;&nbsp;'.$questions_correct_hint_3[$elem].'</div>';} 

			echo '</div>';
			$elem = $elem + 1;
		}
	?>
	
	


	<div class="col-md-12 text-center">
		<?php 
		//only logged in users can submit:
			if (($usertype==8) or ($usertype==9)){
				if ($answers_3[0]==''){echo '<button class="btn btn-primary">SUBMIT</button>';} 
				else {echo '<strong>'.$count_correct_3 . ' correct answers (out of '.$count_total_3.')</strong>';} 
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

<p class="fs-18">It should be pointed out that studies like those used in the above exercises cannot identify causal relationships. In other words, from this data alone, it is impossible to say whether studying actually increases life expectancy through a better-informed and healthier life-style or other mechanisms, or whether the apparent association between life expectancy and education is due to underlying factors that affects both. It is likely that, for example, in countries where people tend to be highly educated, nutrition, healthcare, and safety are also better, which increases life expectancy. With this kind of simple analysis, we can only identify associations, which can nevertheless be useful for prediction.</p>

<h3>Machine learning applications of linear regression</h3>

<p class="fs-18">Linear regression is truly the workhorse of many AI and data science applications. It has its limits but they are often compensated by its simplicity, interpretability and efficiency. Linear regression has been successfully used in the following problems to give a few examples:</p>

<li>prediction of click rates in online advertising</li>
<li>prediction of retail demand for products</li>
<li>prediction of box-office revenue of Hollywood movies</li>
<li>prediction of software cost</li>
<li>prediction of insurance cost</li>
<li>prediction of crime rates</li>
<li>prediction of real estate prices</li><br>

<h3>Could we use regression to predict labels?</h3>

<p class="fs-18">As we discussed above, linear regression and the nearest neighbor method produce different kinds of predictions. Linear regression outputs numerical outputs while the nearest neighbor method produces labels from a fixed set of alternatives (“classes”).</p>
<p class="fs-18">Where linear regression excels compared to nearest neighbors is interpretability. What do we mean by this? You could say that in a way, the nearest neighbor method and any single prediction that it produces are easy to interpret: it’s just the nearest training data element! This is true, but when it comes to the interpretability of the learned model, there is a clear difference. Interpreting the trained model in nearest neighbors in a similar fashion as the weights in linear regression is impossible: the learned model is basically the whole data, and it is usually way too big and complex to provide us with much insight. So what if we’d like to have a method that produces the same kind of outputs as the nearest neighbor, labels, but is interpretable like linear regression?</p>

<h3>Logistic regression to the rescue</h3>

<p class="fs-18">Well there is good news for you: we can turn the linear regression method’s outputs into predictions about labels. The technique for doing this is called logistic regression. We will not go into the technicalities, suffice to say that in the simplest case, we take the output from linear regression, which is a number, and predict one label A if the label is more than zero, and another label B if the label is less than or equal to zero. Actually, instead of just predicting one class or another, logistic regression can also give us a measure of uncertainty of the prediction. So if we are predicting whether a customer will buy a new smartphone this year, we can get a prediction that customer A will buy a phone with probability 90%, but for another, less predictable customer, we can get a prediction that they will not buy a phone with 55% probability (or in other words, that they will buy one with 45% probability).</p>
<p class="fs-18">It is also possible to use the same trick to obtain predictions over more than two possible labels, so instead of always predicting either yes or no (buy a new phone or not, fake news or real news, and so forth), we can use logistic regression to identify, for example, handwritten digits, in which case there are ten possible labels.</p>

<h3>An example of logistic regression</h3>

<p class="fs-18">Let’s suppose that we collect data of students taking an introductory course in cookery. In addition to the basic information such as the student ID, name, and so on, we also ask the students to report how many hours they studied for the exam (however you study for a cookery exam, probably cooking?) – and hope that they are more or less honest in their reports. After the exam, we will know whether each student passed the course or not. Some data points are presented below:</p>

<table class="table table-hover font-lato fs-12 table-light">
				<thead>
					<td><strong>Student ID</strong></td>
					<td><strong>Hours studied</strong></td>
					<td><strong>Pass/fail</td>
				</thead>
				<tbody>
					<tr><td>24</td><td>15</td><td>Pass</td></tr>
					<tr><td>41</td><td>9.5</td><td>Pass</td></tr>
					<tr><td>58</td><td>2</td><td>Fail</td></tr>
					<tr><td>101</td><td>5</td><td>Fail</td></tr>
					<tr><td>103</td><td>6.5</td><td>Fail</td></tr>
					<tr><td>215</td><td>6</td><td>Pass</td></tr>
					
					
				</tbody>
			</table>

<p class="fs-18">Based on the table, what kind of conclusion could you draw between the hours studied and passing the exam? We could think that if we have data from hundreds of students, maybe we could see the amount needed to study in order to pass the course. We can present this data in a chart as you can see below.</p>




</div>
</div>


<!-- EXERCISE -->
<div class="callout alert alert-default">
	<div class="row">
		<div class="col-md-2" valign="top">
		</div>
		<div class="col-md-7 col-sm-8"><!-- left text -->
			<h1><span>Exercise 19: Logistic regression</span></h1>
			<img src="assets/images/img_4_3_4.png" class="img-fluid"  alt="..."><br><br>
			<p class="fs-18">Each dot on the figure corresponds to one student. On the bottom of the figure we have the scale for how many hours the student studied for the exam, and the students who passed the exam are shown as dots at the top of the chart, and the ones who failed are shown at the bottom. We´ll use the scale on the left to indicate the predicted probability of passing, which we´ll get from the logistic regression model as we explain just below. Based on this figure, you can see roughly that students who spent longer studying had better chances of passing the course. Especially the extreme cases are intuitive: with less than an hour’s work, it is very hard to pass the course, but with a lot of work, most will be successful. But what about those that spend time studying somewhere inbetween the extremes? If you study for 6 hours, what are your chances of passing?</p><br>
			<p class="fs-18">We can quantify the probability of passing using logistic regression. The curve in the figure can be interpreted as the probability of passing: for example, after studying for five hours, the probability of passing is a little over 20%. We will not go into the details on how to obtain the curve, but it will be similar to how we learn the weights in linear regression.</p><br>
			<p class="fs-18">If you wanted to have an 80% chance of passing a university exam, based on the above figure, how many hours should you approximately study for?</p><br>
		</div>
		<div class="col-md-3" valign="top">
		</div>
	</div>
</div>

<div class="card card-default" id="exercise8">
	<div class="card-block">
		<p class="fs-14">Answer the questions below</p>
		
	
<form class="m-0" method="post" action="#exercise8" autocomplete="off">
	<!-- QUESTIONS -->
	<?php
		//now the new stuff:
		$elem = 0; 
		foreach($questions_string_4 AS $question) {
			echo '<div class="row border-bottom">
					<div class="col-md-4" valign="top"><p class="fs-18">' . $question . '</p></div>';
			
			$ans = 1;
			foreach($questions_options_4 AS $option) {
				echo '<div class="col-md-2 valign="top" align="center">';
				// answer was provided:
				 if ($answers_4[$elem]<>'') {
				 	$pot_cor = 0; if (in_array($ans, $questions_correct_4[$elem])) {$pot_cor = 1;}
				 	$cor = 0; if (in_array($answers_4[$elem], $questions_correct_3[$elem])) {$cor = 1;}
				 	if (($pot_cor==0) & ($answers_4[$elem]==$ans)) {echo '<button type="button" class="btn btn-outline-danger disabled fs-10">'.$option.'</button>';}
				 	if (($pot_cor==0) & ($answers_4[$elem]<>$ans)) {echo '<button type="button" class="btn disabled fs-10">'.$option.'</button>';}
				 	if (($pot_cor==1) & ($cor==1)) {echo '<button type="button" class="btn btn-outline-success disabled fs-10">'.$option.'</button>';}
				 	if (($pot_cor==1) & ($cor==0)) {echo '<button type="button" class="btn btn-outline-success disabled fs-10">'.$option.'</button>';}

				 }
				 // no answer was provided, show radio:
				 else {$elem_4 = $elem+5; echo '<input type="radio" name="'.$elem_4.'" value="'.$ans.'" required> '.$option;}
				 echo '</div>';
				 $ans = $ans + 1;
			}
			
			
			if (($answers_4[$elem]<>'') & (in_array($answers_4[$elem], $questions_correct_4[$elem]))) {echo '<div class="alert alert-success mb-30 col-md-12"><strong>Well done!</strong>&nbsp;&nbsp;'.$questions_correct_hint_4[$elem].'</div>';} 
			if (($answers_4[$elem]<>'') & (in_array($answers_4[$elem], $questions_correct_4[$elem])==false)) {echo '<div class="alert alert-danger mb-30 col-md-12"><strong>Oh snap!</strong>&nbsp;&nbsp;'.$questions_correct_hint_4[$elem].'</div>';} 

			echo '</div>';
			$elem = $elem + 1;
		}
	?>
	
	


	<div class="col-md-12 text-center">
		<?php 
		//only logged in users can submit:
			if (($usertype==8) or ($usertype==9)){
				if ($answers_4[0]==''){echo '<button class="btn btn-primary">SUBMIT</button>';} 
				else {echo '<strong>'.$count_correct_4 . ' correct answers (out of '.$count_total_4.')</strong>';} 
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

<p class="fs-18">Logistic regression is also used in a great variety of real-world AI applications such as predicting financial risks, in medical studies, and so on. However, like linear regression, it is also constrained by the linearity property and we need many other methods in our toolbox. We will return to the linearity issue later when we discuss neural networks.</p>

<h3>The limits of machine learning</h3>

<p class="fs-18">To summarize, machine learning is a very powerful tool for building AI applications. In addition to the nearest neighbor method, linear regression, and logistic regression, there are literally hundreds, if not thousands, of different machine learning techniques, but they all boil down to the same thing: trying to extract patterns and dependencies from data and using them either to gain understanding of a phenomenon or to predict future outcomes.</p>
<p class="fs-18">Machine learning can be a very hard problem and we can’t usually achieve a perfect method that would always produce the correct label. However, in most cases, a good but not perfect prediction is still better than none. Sometimes we may be able to produce better predictions by ourselves but we may still prefer to use machine learning because the machine will make its predictions faster and it will also keep churning out predictions without getting tired. Good examples are recommendation systems that need to predict what music, what videos, or what ads are more likely to be of interest to you.</p>
<p class="fs-18">The factors that affect how good a result we can achieve include:</p>

<li>The hardness of the task: in handwritten digit recognition, if the digits are written very sloppily, even a human can’t always guess correctly what the writer intended</li><br>
<li>The machine learning method: some methods are far better for a particular task than others</li><br>
<li>The amount of training data: from only a few examples, it is impossible to obtain a good classifier</li><br>
<li>The quality of the data</li><br>

<div class="card card-default">
	<div class="card-block">
		<p class="fs-14">Note</p>
		<h4><span>Data quality matters</span></h4>
		<p class="fs-18">In the beginning of this chapter, we emphasized the importance of having enough data and the risks of overfitting. Another equally important factor is the <strong>quality</strong> of the data. In order to build a model that generalizes well to data outside of the training data, the training data needs to contain enough information that is relevant to the problem at hand. For example, if you create an image classifier that tells you what the image given to the algorithm is about, and you have trained it only on pictures of dogs and cats, it will assign everything it sees as either a dog or a cat. This would make sense if the algorithm is used in an environment where it will only see cats and dogs, but not if it is expected to see boats, cars, and flowers as well. We'll return to potential problems caused by ”biased” data.</p>
	</div>
</div>

<p class="fs-18">It is also important to emphasize that different machine learning methods are suitable for different tasks. Thus, there is no single best method for all problems (“one algorithm to rule them all...”). Fortunately, one can try out a large number of different methods and see which one of them works best in the problem at hand.</p>
<p class="fs-18">This leads us to a point that is very important but often overlooked in practice: what it means to work better. In the digit recognition task, a good method would of course produce the correct label most of the time. We can measure this by the classification error: the fraction of cases where our classifier outputs the wrong class. In predicting apartment prices, the quality measure is typically something like the difference between the predicted price and the final price for which the apartment is sold. In many real-life applications, it is also worse to err in one direction than in another: setting the price too high may delay the process by months, but setting the price too low will mean less money for the seller. And to take yet another example, failing to detect a pedestrian in front of a car is a far worse error than falsely detecting one when there is none.</p>
<p class="fs-18">As mentioned above, we can’t usually achieve zero error, but perhaps we will be happy with error less than 1 in 100 (or 1%). This too depends on the application: you wouldn’t be happy to have only 99% safe cars on the streets, but being able to predict whether you’ll like a new song with that accuracy may be more than enough for a pleasant listening experience. Keeping the actual goal in mind at all times helps us make sure that we create actual added value.</p>

</div>
</div>



<!-- UP NEXT -->
<div class="card card-default">
	<div class="card-block">
		<h3>After completing Chapter 4 you should be able to:</h3>
		<blockquote>Explain why machine learning techniques are used</blockquote>
		<blockquote>Distinguish between unsupervised and supervised machine learning scenarios</blockquote>
		<blockquote>Explain the principles of three supervised classification methods: the nearest neighbor method, linear regression, and logistic regression</blockquote>
		
		<h3>Next:</h3>
		<h1>Chapter 5: Neural Networks&nbsp;&nbsp;&nbsp;
			<?php if ($answers[0]==''){echo '<a href=""><button type="button" class="btn btn-btn-secondary btn-lg" disabled>&nbsp;&nbsp;&nbsp;CONTINUE&nbsp;&nbsp;&nbsp;</button></a>';} 
							else {echo '<a href="42_education_5_1.php"><button type="button" class="btn btn-primary btn-lg">&nbsp;&nbsp;&nbsp;CONTINUE&nbsp;&nbsp;&nbsp;</button></a>';} ?>


			
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