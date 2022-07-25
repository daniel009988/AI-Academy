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
	$sqlretrievestring = 'DELETE FROM EDUCATION_TABLE WHERE USER_ID=' . $user_id . ' AND CHAPTER = ' . $this_chapter . ' AND LESSON = ' . $this_subchapter . ' AND EXERCISE = 24' ;
	mysqli_query($connection, $sqlretrievestring);
	//loop through provided answers and save them:
	$question_num = 1;
	foreach($answers AS $answer) {
		$correct = 0; // <--- needs human review
		$answer = str_replace("'", "´", $answer); //remove '
		$sql="INSERT INTO `42_schema`.`EDUCATION_TABLE` (`USER_ID`, `CHAPTER`, `LESSON`, `EXERCISE`, `QUESTION`, `ANSWER_TEXT`, `CORRECT` ) VALUES ($user_id, $this_chapter, $this_subchapter , 24, $question_num, '$answer' , $correct)";
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
	$sqlretrievestring = 'SELECT * FROM EDUCATION_TABLE WHERE USER_ID=' . $user_id . ' AND CHAPTER = ' . $this_chapter . ' AND LESSON = ' . $this_subchapter . ' AND EXERCISE = 24' ;
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
		<!--<img src="assets/images/course_6_1.png" class="img-fluid"  alt="...">-->
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
	<div class="col-md-1 process-wizard-step complete"> <!-- complete active disabled -->
		<div class="text-center process-wizard-stepnum">Chapter 6</div>
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
	
	
</div>
<br>
<!-- /PROCESS BAR -->

<div class="row">
	<div class="col-md-2" valign="top">
	</div>
	<div class="col-md-7" valign="top">


<!-- TEXT ........................................................................................................ -->

<h1><span>II. The societal implications of AI</span></h1>

<h3>In the very beginning of this course, we briefly discussed the importance of AI in today’s and tomorrow’s society but at that time, we could do so only to a limited extent because we hadn’t introduced enough of the technical concepts and methods to ground the discussion on concrete terms.</h3>

<p class="fs-18">Now that we have a better understanding of the basic concepts of AI, we are in a much better position to take part in rational discussion about the implications of already the current AI.</p>

<h3>Implication 1: Algorithmic bias</h3>
<p class="fs-18">AI, and in particular, machine learning, is being used to make important decisions in many sectors. This brings up the concept of algorithmic bias. What it means is the embedding of a tendency to discriminate according ethnicity, gender, or other factors when making decisions about job applications, bank loans, and so on.</p>

<div class="card card-default">
	<div class="card-block">
		<p class="fs-14">Note</p>
		<h4><span>Once again, it’s all about the data</span></h4>
		<p class="fs-18">The main reason for algorithmic bias is human bias in the data. For example, when a job application filtering tool is trained on decisions made by humans, the machine learning algorithm may learn to discriminate against women or individuals with a certain ethnic background. Notice that this may happen even if ethnicity or gender are excluded from the data since the algorithm will be able to exploit the information in the applicant’s name or address.</p>
	</div>
</div>

<p class="fs-18">Algorithmic bias isn't a hypothetical threat conceived by academic researchers. It's a real phenomenon that is already affecting people today.</p>

<h3>Online advertising</h3>
<p class="fs-18">It has been noticed that online advertisers like Google tend to display ads of lower-pay jobs to women users compared to men. Likewise, doing a search with a name that sounds African American may produce an ad for a tool for accessing criminal records, which is less likely to happen otherwise.</p>

<h3>Social networks</h3>
<p class="fs-18">Since social networks are basing their content recommendations essentially on other users’ clicks, they can easily lead to magnifying existing biases even if they are very minor to start with. For example, it was observed that when searching for professionals with female first names, LinkedIn would ask the user whether they actually meant a similar male name: searching for Andrea would result in the system asking “did you mean Andrew”? If people occasionally click Andrew’s profile, perhaps just out of curiosity, the system will boost Andrew even more in subsequent searched.</p>
<p class="fs-18">There are numerous other examples we could mention, and you have probably seen news stories about them. The main difficulty in the use of AI and machine learning instead of rule-based systems is their lack of transparency. Partially this is a consequence of the algorithms and the data being trade secrets that the companies are unlikely to open up for public scrutiny. And even if they did this, it may often be hard to identify the part of the algorithm or the elements of the data that lead to discriminating decisions.</p>

<div class="card card-default">
	<div class="card-block">
		<p class="fs-14">Note</p>
		<h4><span>Transparency through regulation?</span></h4>
		<p class="fs-18">A major step towards transparency is the European General Data Protection Regulation (GDPR). It requires that all companies that either reside within the European Union or that have European customers must:</p>	
		<li>Upon request, reveal what data they have collected about any individual (right of access)</li><br>
		<li>Delete any such data that is not required to keep with other obligations when requested to do so (right to be forgotten)</li><br>
		<li>Provide an explanation of the data processing carried out on the customer’s data (right to explanation)</li><br>
	</div>
</div>

<p class="fs-18">The last point means, in other words, that companies such as Facebook and Google, at least when providing services to European users, must explain their algorithmic decision making processes. It is, however, still unclear what exactly counts as an explanation. Does for example a decision reached by using the nearest neighbor classifier (Chapter 4) count as an explainable decision, or would the coefficients of a logistic regression classifier be better? How about deep neural networks that easily involve millions of parameters trained using terabytes of data? The discussion about the technical implementation about the explainability of decisions based on machine learning is currently intensive. In any case, the GDPR has potential to improve the transparency of AI technologies.</p>

<h3>Implication 2: Seeing is believing — or is it?</h3>
<p class="fs-18">We are used to believing what we see. When we see a leader on the TV stating that their country will engage in a trade-war with another country, or when a well-known company spokesperson announces an important business decision, we tend to trust them better than just reading about the statement second-hand from the news written by someone else.</p>
<p class="fs-18">Similarly, when we see photo evidence from a crime scene or from a demonstration of a new tech gadget, we put more weight on the evidence than on written report explaining how things look.</p>
<p class="fs-18">Of course, we are aware of the possibility of fabricating fake evidence. People can be put in places they never visited, with people they never met, by photoshopping. It is also possible to change the way things look by simply adjusting lighting or pulling one’s stomach in in cheap before–after shots advertising the latest diet pill.</p>

<div class="card card-default">
	<div class="card-block">
		<p class="fs-14">Note</p>
		<h4><span>AI is taking the possibilities of fabricating evidence to a whole new level:</span></h4>
		<p class="fs-18"><a href="https://www.youtube.com/watch?v=ohmajJTcpNk">Face2Face</a> is a system capable of identifying the facial expressions of a person and putting them on another person’s face in a Youtube video.</p>
		<p class="fs-18"><a href="https://lyrebird.ai/">Lyrebird</a> is a tool for automatic imitation of a person’s voice from a few minutes of sample recording. While the generated audio still has a notable robotic tone, it makes a pretty good impression.</p>	
	</div>
</div>

<h3>Implication 3: Changing notions of privacy</h3>

<p class="fs-18">It has been long known that technology companies collect a lot of information about their users. Earlier it was mainly grocery stores and other retailers that collected buying data by giving their customers loyalty cards that enable the store to associate purchases to individual customers.</p>

<div class="card card-default">
	<div class="card-block">
		<p class="fs-14">Note</p>
		<h4><span>Unprecedented data accuracy</span></h4>
		<p class="fs-18">The accuracy of the data that tech companies such as Facebook, Google, Amazon and many others is way beyond the purchase data collected by conventional stores: in principle, it is possible to record every click, every page scroll, and the time you spend viewing any content. Websites can even access your browsing history, so that unless you use the incognito mode (or the like) after browsing for flights to Barcelona on one site, you will likely get advertisements for hotels in Barcelona.</p>	
	</div>
</div>

<p class="fs-18">However, as such the above kind of data logging is not yet AI. The use of AI leads new kinds of threats to our privacy, which may be harder to avoid even if you are careful about revealing your identity.</p>

<h3>Using data analysis to identify individuals</h3>
<p class="fs-18">A good example of a hard-to-avoid issue is <strong>de-anonymization</strong>, breaking the anonymity of data that we may have thought to be safe. The basic problem is that when we report the results of an analysis, the results may be so specific that they make it possible to learn something about individual users whose data is included in the analysis. A classic example is asking for the average salary of people born in the given year and having a specific zip code. In many cases, this could be a very small group of people, often only one person, so you’d be potentially giving data about a single person’s salary.</p>
<p class="fs-18">An interesting example of a <a href="https://www.wired.com/2007/12/why-anonymous-data-sometimes-isnt/">more subtle issue</a> was pointed out by researchers at the University of Texas at Austin. They studied a public dataset made available by Netflix containing 10 million movie ratings by some 500,000 anonymous users, and showed that many of the Netflix users can actually be linked to user accounts on the Internet Movie Database because they had rated several movies on both applications. Thus the researchers were able to de-anonymize the Netflix data. While you may not think it's big deal whether someone else knows how you rated the latest Star Wars movie, some movies may reveal aspects of our lives (such as politics or sexuality) which we should be entitled to keep private.</p>

<h3>Other methods of identification</h3>
<p class="fs-18">A similar approach could in principle used to match user accounts in almost any service that collects detailed data about user behaviors. Another example is typing patterns. Researchers at the University of Helsinki have demonstrated that users can be identified based on their typing patterns: the short intervals between specific keystrokes when typing text. This can mean that if someone has access to data on your typing pattern (maybe you have used their website and registered by entering your name), they can identify you the next time you use their service even if you’d refuse to identify yourself explicitly. They can also sell this information to whoever wants to buy it.</p>
<p class="fs-18">While many of the above examples have come as at least in part as surprises – otherwise they could have been avoided – there is a lot of ongoing research trying to address them. In particular, an area called differential privacy aims to develop machine learning algorithms that can guarantee that the results are sufficiently coarse to prevent reverse engineering specific data points that went into them.</p>

<h3>Implication 4: Changing work</h3>
<p class="fs-18">When an early human learned to use a sharp rock to crack open bones of dead animals to access a new source of nutrition, time and energy was released for other purposes such as fighting, finding a mate, and making more inventions. The invention of the steam engine in the 1700s tapped into an easily portable form of machine power that greatly improved the efficiency of factories as well as ships and trains. Automation has always been a path to efficiency: getting more with less. Especially since the mid 20th century, technological development has lead to a period of unprecedented progress in automation. AI is a continuation of this progress.</p>
<p class="fs-18">Each step towards better automation changes the working life. With a sharp rock, there was less need for hunting and gathering food; with the steam engine, there was less need for horses and horsemen; with the computer, there is less need for typists, manual accounting, and many other data processing (and apparently more need for watching cat videos). With AI and robotics, there is even less need for many kinds of dull, repetitive work.</p>

<div class="card card-default">
	<div class="card-block">
		<p class="fs-14">Note</p>
		<h4><span>A history of finding new things to do</span></h4>
		<p class="fs-18">In the past, every time one kind of work has been automated, people have found new kinds to replace it. The new kinds of work are less repetitive and routine, and more variable and creative. The issue with the current rate of advance of AI and other technologies is that during the career of an individual, the change in the working life might be greater than ever before. It is conceivable that some jobs such as driving a truck or a taxi, may disappear within a few years’ time span. Such an abrupt change could lead to mass unemployment as people don’t have time to train themselves for other kinds of work.</p>
		<p class="fs-18">The most important preventive action to avoid huge societal issues such as this is to help young people obtain a wide-ranging education. This that provides a basis for pursuing many different jobs and which isn’t in high risk of becoming obsolete in the near future.</p>
		<p class="fs-18">It is equally important to support life-long learning and learning at work, because there are going to be few of us who will do the same job throughout their entire career. Cutting the hours per week would help offer work for more people, but the laws of economics tend to push people to work more rather than less unless public policy regulating the amount of work is introduced.</p>	
	</div>
</div>

<p class="fs-18">Because we can’t predict the future of AI, predicting the rate and extent of this development is extremely hard. There have been some estimates about the extent of job automation, ranging up to <a href="https://www.oxfordmartin.ox.ac.uk/news/14-09-18-Jobs">47% of US jobs being at risk</a> reported by researchers at the University of Oxford. The exact numbers such as these – 47%, not 45% or 49% –, the complicated-sounding study designs used to get them, and the top universities that report them tend to make the estimates sounds very reliable and precise (recall the point about estimating life expectancy using a linear model based on a limited amount of data). The illusion of accuracy to one percentage is a fallacy. The above number, for example, is based on looking at a large number of job descriptions – perhaps licking the tip of your finger and putting it up to feel the wind – and using subjective grounds to decide which tasks are likely to be automated. It is understandable that people don't take the trouble to read a 79 page report that includes statements such as "the task model assumes for tractability an aggregate, constant-returns to-scale, Cobb-Douglas production function." However, if you don't, then you should remain somewhat sceptical about the conclusions too. The real value in this kind of analysis is that it suggests which kinds of jobs are more likely to be at risk, not in the actual numbers such as 47%. The tragedy is that the headlines reporting that "nearly half of US jobs at risk of computerization" are remembered and the rest is not.</p>
<p class="fs-18">So what are then the tasks that are more likely to be automated. There are some clear signs concerning this that we can already observe:</p>
<p class="fs-18">Autonomous robotics solutions such as self-driving vehicles, including cars, drones and boats or <a href="https://www.reaktor.com/work/autonomousferry/">ferries</a>, are just at the verge of a major commercial applications. The safety of autonomous cars is hard to estimate, but the statistics suggests that it is probably not yet quite at the required level (the level of an average human driver). However, the progress has been incredibly fast and it is accelerating due to the increasing amount of available data.</p>
<p class="fs-18">Customer-service applications such as helpdesks can be automated in a very cost-effective fashion. Currently the quality of service is not always to be cheered, the bottle-necks being language processing (the system not being able to recognize spoken language or to parse the grammar) and the logic and reasoning required to provide the actual service. However, working applications in constrained domains (such as <a href="https://www.youtube.com/watch?v=BRUvbiWLwFI">making restaurant or haircut reservations</a>) sprout up constantly.</p>
<p class="fs-18">For one thing, it is hard to tell how soon we’ll have safe and reliable self-driving cars and other solutions that can replace human work. In addition to this, we mustn’t forget that a truck or taxi driver doesn’t only turn a wheel: they are also responsible for making sure the vehicle operates correctly, they handle the goods and negotiate with customers, they guarantee the safety of their cargo and passengers, and take care of a multitude of other tasks that may be much harder to automate than the actual driving.</p>
<p class="fs-18">As with earlier technological advances, there will also be new work that is created because of AI. It is likely that in the future, a larger fraction of the workforce will focus on research and development, and tasks that require creativity and human-to-human interaction. If you'd like to read more on this topic, see for example Abhinav Suri's nice essay on <a href="https://towardsdatascience.com/artificial-intelligence-and-the-rise-of-economic-inequality-b9d81be58bec">Artificial Intelligence and the Rise of Economic Inequality</a>.</p>



</div>
</div>


<!-- EXERCISE -->
<div class="callout alert alert-default">
	<div class="row">
		<div class="col-md-2" valign="top">
		</div>
		<div class="col-md-7 col-sm-8"><!-- left text -->
			<h1><span>Exercise 24: Implications of AI</span></h1>
			<p class="fs-18">What kind of articles are being written about AI - and do you think they are realistic? Do an online search about AI related to one of your interests. <strong>Choose one of the articles and analyze it.</strong></p>
			<p class="fs-18">1. Mention the <strong>title of the article</strong> along with its author and where it was published (as a URL if applicable) in your answer.</p>
			<p class="fs-18">2. Explain the central idea in the article <strong>in your own words</strong> using about a paragraph of text (multiple sentences.)</p>
			<p class="fs-18">3. Based on your understanding, how accurate are the AI-related statements in the article? <strong>Explain your answer</strong>. Are the implications (if any) realistic? <strong>Explain why or why not.</strong>	</p>
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
		<h1>III. Summary&nbsp;&nbsp;&nbsp;
			<?php if ($answers[0]==''){echo '<a href=""><button type="button" class="btn btn-btn-secondary btn-lg" disabled>&nbsp;&nbsp;&nbsp;CONTINUE&nbsp;&nbsp;&nbsp;</button></a>';} 
							else {echo '<a href="42_education_6_3.php"><button type="button" class="btn btn-primary btn-lg">&nbsp;&nbsp;&nbsp;CONTINUE&nbsp;&nbsp;&nbsp;</button></a>';} ?>


			
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