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
$questions_string = array("Who is the user most similar to Travis?","What is the predicted purchase for Travis?
");
$questions_options = array(""); // =1, =2, =3, etc.
$questions_correct = array(array("Ville","ville","VILLE"),array("sunscreen","Sunsceen","SUNSCREEN"));
$questions_correct_hint = array(
	"When you calculate the similarities between Travis and all the other users, Ville and Travis will have the largest similarity with a similarity of 3.",
	"Since Ville's latest purchase was sunscreen, we will recommend it also to Travis.");

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
$answers = array($_POST['0'],$_POST['1']);
$answers_2 = array($_POST['2']);

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
	$sqlretrievestring = 'DELETE FROM EDUCATION_TABLE WHERE USER_ID=' . $user_id . ' AND CHAPTER = ' . $this_chapter . ' AND LESSON = ' . $this_subchapter . ' AND EXERCISE = 14' ;
	mysqli_query($connection, $sqlretrievestring);
	//loop through provided answers and save them:
	$question_num = 1;
	foreach($answers AS $answer) {
		$correct = -1;
		if (in_array($answer,$questions_correct[$question_num-1])) {$correct = 1;}
		$sql="INSERT INTO `42_schema`.`EDUCATION_TABLE` (`USER_ID`, `CHAPTER`, `LESSON`, `EXERCISE`, `QUESTION`, `ANSWER_TEXT`, `CORRECT` ) VALUES ($user_id, $this_chapter, $this_subchapter , 14, $question_num, '$answer' , $correct)";
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
	$sqlretrievestring = 'DELETE FROM EDUCATION_TABLE WHERE USER_ID=' . $user_id . ' AND CHAPTER = ' . $this_chapter . ' AND LESSON = ' . $this_subchapter . ' AND EXERCISE = 15' ;
	mysqli_query($connection, $sqlretrievestring);
	//loop through provided answers and save them:
	$question_num = 1;
	foreach($answers_2 AS $answer_2) {
		$correct = 0;
		$answer_2 = str_replace("'", "´", $answer_2); //remove '
		//if (in_array($answer_2,$questions_correct_2[$question_num-1])) {$correct = 1;}
		$sql="INSERT INTO `42_schema`.`EDUCATION_TABLE` (`USER_ID`, `CHAPTER`, `LESSON`, `EXERCISE`, `QUESTION`, `ANSWER_TEXT`, `CORRECT` ) VALUES ($user_id, $this_chapter, $this_subchapter , 15, $question_num, '$answer_2' , $correct)";
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
	$sqlretrievestring = 'SELECT * FROM EDUCATION_TABLE WHERE USER_ID=' . $user_id . ' AND CHAPTER = ' . $this_chapter . ' AND LESSON = ' . $this_subchapter . ' AND EXERCISE = 14' ;
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
	$sqlretrievestring_2 = 'SELECT * FROM EDUCATION_TABLE WHERE USER_ID=' . $user_id . ' AND CHAPTER = ' . $this_chapter . ' AND LESSON = ' . $this_subchapter . ' AND EXERCISE = 15' ;
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
		<div class="process-wizard-info text-center">&nbsp;</div>
	</div>
	<div class="col-md-1 process-wizard-step complete"> <!-- complete active disabled -->
		<div class="text-center process-wizard-stepnum">Chapter 4</div>
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

<h1><span>II. The nearest neighbor classifier</span></h1>
<h3>The nearest neighbor classifier is among the simplest possible classifiers. When given an item to classify, it finds the training data item that is most similar to the new item, and outputs its label. An example is given in the following diagram.</h3>

<img src="assets/images/img_4_2_1.svg" class="img-fluid"  alt="..."><br><br>

<p class="fs-18">In the above diagram, we show a collection of training data items, some of which belong to one class (green) and other to another class (blue). In addition, there are two test data items, the stars, which we are going to classify using the nearest neighbor method.</p>
<p class="fs-18">The two test items are both classified in the “green” class because their nearest neighbors are both green (see diagram (b) above).</p>
<p class="fs-18">The position of the points in the plot represents in some way the properties of the items. Since we draw the diagram on a flat two-dimensional surface – you can move in two independent directions: up-down or left-right – the items have two properties that we can use for comparison. Imagine for example representing patients at a clinic in terms of their age and blood-sugar level. But the above diagram should be taken just as a visual tool to illustrate the general idea, which is to relate the class values to similarity or proximity (nearness). The general idea is by no means restricted to two dimensions and the nearest neighbor classifier can easily be applied to items that are characterized by many more properties than two.</p>

<h3>What do we mean by nearest?</h3>

<p class="fs-18">An interesting question related to (among other things) the nearest neighbor classifier is the definition of distance or similarity between instances. In the illustration above, we tacitly assumed that the standard geometric distance, technically called the Euclidean distance, is used. This simply means that if the points are drawn on a piece of paper (or displayed on your screen), you can measure the distance between any two items by pulling a piece of thread straight from one to the other and measuring the length.</p>

<div class="card card-default">
	<div class="card-block">
		<p class="fs-14">Note</p>
		<h4><span>Defining ‘nearest’</span></h4>
		<p class="fs-18">Using the geometric distance to decide which is the nearest item may not always be reasonable or even possible: the type of the input may, for example, be text, where it is not clear how the items are drawn in a geometric representation and how distances should be measured. You should therefore choose the distance metric on a case-by-case basis.</p>
	</div>
</div>

<p class="fs-18">In the MNIST digit recognition case, one common way to measure image similarity is to count pixel-by-pixel matches. In other words, we compare the pixels in the top-left corner of each image to one another and if the more similar color (shade of gray) they are, the more similar the two images are. We also compare the pixels in the bottom-right corner of each image, and all pixels inbetween. This technique is quite sensitive to shifting or scaling the images: if we take an image of a '1' and shift it ever so slightly either left or right, the outcome is that the two images (before and after the shift) are very different because the black pixels are in different positions in the two images. Fortunately, the MNIST data has been preprocessed by centering the images so that this problem is alleviated.</p>

<img src="assets/images/img_4_2_2.svg" class="img-fluid"  alt="..."><br><br>

<h3>Using nearest neighbors to predict user behavior</h3>

<p class="fs-18">A typical example of an application of the nearest neighbor method is predicting user behavior in AI applications such as recommendation systems.</p>
<p class="fs-18">The idea is to use the very simple principle that users with similar past behavior tend to have similar future behavior. Imagine a music recommendation system that collects data about users’ listening behavior. Let’s say you have listened to 1980s disco music (just for the sake of argument). One day, the service provider gets their hands on a hard-to-find 1980 disco classic, and adds it into the music library. The system now needs to predict whether you will like it or not. One way of doing this is to use information about the genre, the artist, and other metadata, entered by the good people of the service provider. However, this information is relatively scarce and coarse and it will only be able to give rough predictions.</p>
<p class="fs-18">What current recommendation systems use instead of the manually entered metadata, is something called collaborative filtering. The collaborative aspect of it is that it uses other users’ data to predict your preferences. The word “filter” refers to the fact that you will be only recommended content that passes through a filter: content that you are likely to enjoy will pass, other content will not (these kind of filters may lead to the so called filter bubbles, which we mentioned in Chapter 1. We will return to them later).</p>
<p class="fs-18">Now let’s say that other users who have listened to 80s disco music enjoy the new release and keep listening to it again and again. The system will identify the similar past behavior that you and other 80s disco fanatics share, and since other users like you enjoy the new release, the system will predict that you will too. Hence it will show up at the top of your recommendation list. In an alternative reality, maybe the added song is not so great and other users with similar past behavior as yours don't really like it. In that case, the system wouldn't bother recommending it to you, or at least it wouldn't be at the top of the list of recommendations for you.</p>
<p class="fs-18">The following exercise will illustrate this idea.</p>

</div>
</div>
<!-- EXERCISE -->
<div class="callout alert alert-default">
	<div class="row">
		<div class="col-md-2" valign="top">
		</div>
		<div class="col-md-7 col-sm-8"><!-- left text -->
			<h1><span>Exercise 14: Customers who bought similar products</span></h1>
			<p class="fs-18">In this exercise, we will build a simple recommendation system for an online shopping application where the users' purchase history is recorded and used to predict which products the user is likely to buy next.</p><br>
			<p class="fs-18">We have data from six users. For each user, we have recorded their recent shopping history of four items and the item they bought after buying these four items:</p><br>
			<div class="table-responsive">
			<table class="table table-hover font-lato fs-12 table-light">
				<thead>
					<td><strong>User</strong></td>
					<td><strong>Shopping History</strong></td>
					<td><strong></td>
					<td><strong></td>
					<td><strong></td>
					<td><strong>Purchase</strong></td>
				</thead>
				<tbody>
					<tr><td>Sanni</td><td>boxing gloves</td><td>Moby Dick (novel)</td><td>headphones</td><td>sunglasses</td><td>coffee beans</td></tr>
					<tr><td>Jouni</td><td>t-shirt</td><td>coffee beans</td><td>coffee maker</td><td>coffee beans</td><td>coffee beans</td></tr>
					<tr><td>Janina</td><td>sunglasses</td><td>sneakers</td><td>t-shirt</td><td>sneakers</td><td>ragg wool socks</td></tr>
					<tr><td>Henrik</td><td>2001: A Space Odyssey (dvd)</td><td>headphones</td><td>t-shirt</td><td>boxing gloves</td><td>flip flops</td></tr>
					<tr><td>Ville</td><td>t-shirt</td><td>flip flops</td><td>sunglasses</td><td>Moby Dick (novel)</td><td>sunscreen</td></tr>
					<tr><td>Teemu</td><td>Moby Dick (novel)</td><td>coffee beans</td><td>2001: A Space Odyssey (dvd)</td><td>headphones</td><td>coffee beans</td></tr>
				</tbody>
			</table>
			<p class="fs-18">The most recent purchase is the one in the rightmost column, so for example, after buying a t-shirt, flip flops, sunglasses, and Moby Dick (novel), Ville bought sunscreen. Our hypothesis is that after buying similar items, other users are also likely to buy sunscreen.</p><br>
			<p class="fs-18">To apply the nearest neighbor method, we need to define what we mean by nearest. This can be done in many different ways, some of which work better than others. Let’s use the shopping history to define the similarity (“nearness”) by counting how many of the items have been purchased by both users.</p><br>
			<p class="fs-18">For example, users Ville and Henrik have both bought a t-shirt, so their similarity is 1. Note that flip flops doesn't count because we don't include the most recent purchase when calculating the similarity — it is reserved for another purpose.</p><br>
			<p class="fs-18">Our task is to predict the next purchase of customer Travis who has bought the following products:</p><br>
			<table class="table table-hover font-lato fs-12 table-light">
				<thead>
					<td><strong>User</strong></td>
					<td><strong>Shopping History</strong></td>
					<td><strong></td>
					<td><strong></td>
					<td><strong></td>
					<td><strong>Purchase</strong></td>
				</thead>
				<tbody>
					<tr><td>Travis</td><td>green tea</td><td>t-shirt</td><td>sunglasses</td><td>flip flops</td><td>?</td></tr>
				</tbody>
			</table>

			<p class="fs-18">You can think of Travis being our test data, and the above six users make our training data.</p><br>
			<p class="fs-18"><strong>Proceed as follows:</strong></p><br>
			<p class="fs-18">1. Calculate the similarity of Travis relative to the six users in the training data (done by adding together the number of similar purchases by the users).</p><br>
			<p class="fs-18">2. Having calculated the similarities, identify the user who is most similar to Travis by selecting the largest of the calculated similarities.</p><br>
			<p class="fs-18">3. Predict what Travis is likely purchase next by looking at the most recent purchase (the rightmost column in the table) of the most similar user from the previous step.</p><br>
			
</div>
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

<p class="fs-18">In the above example, we only had six users’ data and our prediction was probably very unreliable. However, online shopping sites often have millions of users, and the amount of data they produce is massive. In many cases, there are a horde of users whose past behavior is very similar to yours, and whose purchase history gives a pretty good indication of your interests.</p>

<p class="fs-18">These predictions can also be self-fulfilling prophecies in the sense that you are more likely to buy a product if it is recommended to you by the system, which makes it tricky to evaluate how well they actually work. The same kind of recommendation systems are also used to recommend music, movies, news, and social media content to users. In the context of news and social media, filters created by such systems can lead to filter bubbles.</p>


</div>
</div>
<!-- EXERCISE -->
<div class="callout alert alert-default">
	<div class="row">
		<div class="col-md-2" valign="top">
		</div>
		<div class="col-md-7 col-sm-8"><!-- left text -->
			<h1><span>Exercise 15: Filter bubbles</span></h1>
			<p class="fs-18">As discussed above, recommending news of social media content that a user is likely to click or like, may lead to filter bubbles where the users only see content that is in line with their own values and views.</p><br>
			<p class="fs-18">1. Do you think that filter bubbles are harmful? After all, they are created by recommending content that the user likes. What negative consequences, if any, may be associated with filter bubbles? Feel free to look for more information from other sources.</p><br>
			<p class="fs-18">2. Think of ways to avoid filter bubbles while still being able to recommend content to suit personal preferences. Come up with at least one suggestion. You can look for ideas from other sources, but we'd like to hear your own ideas too!</p><br>
			<p class="fs-18"><strong>Note</strong>: your answer should be at least a few sentences for each part.</p><br>
		</div>
		<div class="col-md-3" valign="top">
		</div>
	</div>
</div>

<div class="card card-default" id="exercise6">
	<div class="card-block">
		<p class="fs-14">Type in your answer below:</p>
		
	
<form class="m-0" method="post" action="#exercise6" autocomplete="off">
	<!-- QUESTIONS -->
	<?php 
		if ($answers_2[0]=='') echo '<textarea class="form-control rounded-0" rows = "8" name = "2" placeholder="Your answer..." required></textarea>'; 
		else {echo nl2br($answers_2[0]);};

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
		<h1>III. Regression&nbsp;&nbsp;&nbsp;
			<?php if ($answers[0]==''){echo '<a href=""><button type="button" class="btn btn-btn-secondary btn-lg" disabled>&nbsp;&nbsp;&nbsp;CONTINUE&nbsp;&nbsp;&nbsp;</button></a>';} 
							else {echo '<a href="42_education_4_3.php"><button type="button" class="btn btn-primary btn-lg">&nbsp;&nbsp;&nbsp;CONTINUE&nbsp;&nbsp;&nbsp;</button></a>';} ?>


			
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