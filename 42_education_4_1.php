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


//include menu:
include '42_education_include_menu.php';
$signupfor = 'education';
include ('signupmodal.html'); 

?>



<!-- Main AREA -->

<!-- LEADING IMAGE -->
<div class="row">
	<div class="col-md-12" valign="top">
		<img src="assets/images/course_4_1.png" class="img-fluid"  alt="...">
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
		<div class="text-center process-wizard-stepnum">Chapter 2</div>
		<div class="progress"><div class="progress-bar"></div></div>
		<a href="#" class="process-wizard-dot"></a>
		<div class="process-wizard-info text-center">&nbsp;</div>
	</div>
	<div class="col-md-1 process-wizard-step active"> <!-- complete active disabled -->
		<div class="text-center process-wizard-stepnum">Chapter 4</div>
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

<h1><span>I. The types of machine learning</span></h1>
<h3>Handwritten digits are a classic case that is often used when discussing why we use machine learning, and we will make no exception.</h3>


<p class="fs-18">Below you can see examples of handwritten images from the very commonly used MNIST dataset.</p>
<img src="assets/images/img_4_1_1.svg" class="img-fluid"  alt="..."><br><br>
<p class="fs-18">The correct label (what digit the writer was supposed to write) is shown above each image. Note that some of the "correct” class labels are questionable: see for example the second image from left: is that really a 7, or actually a 4?</p>

<div class="card card-default">
	<div class="card-block">
		<p class="fs-14">Note</p>
		<h4><span>MNIST – What's that?</span></h4>
		<p class="fs-18">Every machine learning student knows about the MNIST dataset. Fewer know what the acronym stands for. In fact, we had to look it up to be able to tell you that the M stands for Modified, and NIST stands for National Institute of Standards and Technology. Now you probably know something that an average machine learning expert doesn’t!</p>
	</div>
</div>

<p class="fs-18">In the most common machine learning problems, exactly one class value is correct at a time. This is also true in the MNIST case, although as we said, the correct answer may often be hard to tell. In this kind of problem, it is not possible that an instance belongs to multiple classes (or none at all) at the same time. What we would like to achieve is an AI method that can be given an image like the ones above, and automatically spits out the correct label (a number between 0 and 9).</p>

<div class="card card-default">
	<div class="card-block">
		<p class="fs-14">Note</p>
		<h4><span>How not to solve the problem</span></h4>
		<p class="fs-18">An automatic digit recognizer could in principle be built manually by writing down rules such as:</p>
		<li>if the black pixels are mostly in the form of a single loop then the label is 0</li>
		<li>if the black pixels form two intersecting loops then the label is 8</li>
		<li>if the black pixels are mostly in a straight vertical line in the middle of the figure then the label is 1</li><br>
		<p class="fs-18">and so on...</p>
		<p class="fs-18">This was how AI methods were mostly developed in the 1980s (so called “expert systems”). However, even for such a simple task as digit recognition, the task of writing such rules is very laborious. In fact, the above example rules wouldn’t be specific enough to be implemented by programming – we’d have to define precisely what we mean by “mostly”, “loop”, “line”, “middle”, and so on.</p>
		<p class="fs-18">And even if we did all this work, the result would likely be a bad AI method because as you can see, the handwritten digits are often a bit so-and-so, and every rule would need a dozen exceptions.</p>
	</div>
</div>

<h3>Three types of machine learning</h3>

<p class="fs-18">The roots of machine learning are in statistics, which can also be thought of as the art of <strong>extracting knowledge from data</strong>. Especially methods such as linear regression and Bayesian statistics, which are both already more than two centuries old (!), are even today at the heart of machine learning. For more examples and a brief history, see the <a href="https://en.wikipedia.org/wiki/Timeline_of_machine_learning">timeline of machine learning (Wikipedia)</a>.</p>
<p class="fs-18">The area of machine learning is often divided in subareas according to the kinds of problems being attacked. A rough categorization is as follows:</p>
<p class="fs-18"><strong>Supervised learning:</strong> We are given an input, for example a photograph with a traffic sign, and the task is to predict the correct output or label, for example which traffic sign is in the picture (speed limit, stop sign, etc.). In the simplest cases, the answers are in the form of yes/no (we call these binary classification problems).</p>
<p class="fs-18"><strong>Unsupervised learning:</strong> There are no labels or correct outputs. The task is to discover the structure of the data: for example, grouping similar items to form “clusters”, or reducing the data to a small number of important “dimensions”. Data visualization can also be considered unsupervised learning.</p>
<p class="fs-18"><strong>Reinforcement learning:</strong> Commonly used in situations where an AI agent like a self-driving car must operate in an environment and where feedback about good or bad choices is available with some delay. Also used in games where the outcome may be decided only at the end of the game.</p>
<p class="fs-18">The categories are somewhat overlapping and fuzzy, so a particular method can sometimes be hard to place in one category. For example, as the name suggests, so-called <strong>semisupervised</strong> learning is partly supervised and partly unsupervised.</p>

<div class="card card-default">
	<div class="card-block">
		<p class="fs-14">Note</p>
		<h4><span>Classification</span></h4>
		<p class="fs-18">When it comes to machine learning, we will focus primarily on supervised learning, and in particular, classification tasks. In classification, we observe in input, such as a photograph of a traffic sign, and try to infer its “class”, such as the type of sign (speed limit 80 km/h, pedestrian crossing, stop sign, etc.). Other examples of classification tasks include: identification of fake Twitter accounts (input includes the list of followers, and the rate at which they have started following the account, and the class is either fake or real account) and handwritten digit recognition (input is an image, class is 0,...,9).</p>
	</div>
</div>

<h3>Humans teaching machines: supervised learning</h3>

<p class="fs-18">Instead of manually writing down exact rules to do the classification, the point in supervised machine learning is to take a number of examples, label each one by the correct label, and use them to “train” an AI method to automatically recognize the correct label for the training examples as well as (at least hopefully) any other images. This of course requires that the correct labels are provided, which is why we talk about supervised learning. The user who provides the correct labels is a supervisor who guides the learning algorithm towards correct answers so that eventually, the algorithm can independently produce them.</p>
<p class="fs-18">In addition to learning how to predict the correct label in a classification problem, supervised learning can also be used in situations where the predicted outcome is a number. Examples include predicting the number of people who will click a Google ad based on the ad content and data about the user’s prior online behavior, predicting the number of traffic accidents based on road conditions and speed limit, or predicting the selling price of real estate based on its location, size, and condition. These problems are called regression. You probably recognize the term linear regression, which is a classical, still very popular technique for regression.</p>

<div class="card card-default">
	<div class="card-block">
		<p class="fs-14">Note</p>
		<h4><span>Example</span></h4>
		<p class="fs-18">Suppose we have a data set consisting of apartment sales data. For each purchase, we would obviously have the price that was paid, together with the size of the apartment in square meters (or square feet, if you like), and the number of bedrooms, the year of construction, the condition (on a scale from “disaster“ to “spick and span”). We could then use machine learning to train a regression model that predicts the selling price based on these features. See <a ref="http://kannattaakokauppa.fi/#/en/">a real-life example here</a></p>
	</div>
</div>
<img src="assets/images/img_4_1_2.svg" class="img-fluid"  alt="..."><br><br>

<h3>Caveat: careful with that machine learning algorithm</h3>

<p class="fs-18">There are a couple potential mistakes that we'd like to make you aware of. They are related to the fact that unless you are careful with the way you apply machine learning methods, you could become too confident about the accuracy of your predictions, and be heavily disappointed when the accuracy turns out to be worse than expected.</p>
<p class="fs-18">The first thing to keep in mind in order to avoid big mistakes, is to split your data set into two parts: the <strong>training data</strong> and the <strong>test data</strong>. We first train the algorithm using only the training data. This gives us a model or a rule that predicts the output based on the input variables.</p>
<p class="fs-18">To assess how well we can actually predict the outputs, we can't count on the training data. While a model may be a very good predictor in the training data, it is no proof that it can <strong>generalize</strong> to any other data. This is where the test data comes in handy: we can apply the trained model to predict the outputs for the test data and compare the predictions to the actual outputs (for example, future apartment sale prices).</p>

<div class="card card-default">
	<div class="card-block">
		<p class="fs-14">Note</p>
		<h4><span>Too fit to be true! Overfitting alert</span></h4>
		<p class="fs-18">It is very important to keep in mind that the accuracy of a predictor learned by machine learning can be quite different in the training data and in separate test data. This is the so-called <strong>overfitting</strong> phenomenon, and a lot of machine learning research is focused on avoiding it one way or another. Intuitively, overfitting means trying to be too smart. When predicting the success of a new song by a known artist, you can look at the track record of the artist's earlier songs, and come up with a rule like “if the song is about love, and includes a catchy chorus, it will be top-20”. However, maybe there are two love songs with catchy choruses that didn't make the top-20, so you decide to continue the rule “...except if Sweden or yoga are mentioned” to improve your rule. This could make your rule fit the past data perfectly, but it could in fact make it <strong>work worse on future test data.</strong></p>
		<p class="fs-18">Machine learning methods are especially prone to overfitting because they can try a huge number of different “rules” until one that fits the training data perfectly is found. Especially methods that are very flexible and can adapt to almost any pattern in the data can overfit unless the amount of data is enormous. For example, compared to quite restricted linear models obtained by linear regression, neural networks can require massive amounts of data before they produce reliable prediction.</p>
	</div>
</div>

<p class="fs-18">Learning to avoid overfitting and choose a model that is not too restricted, nor too flexible, is one of the most essential skills of a data scientist.</p>

<h3>Learning without a teacher: unsupervised learning</h3>

<p class="fs-18">Above we discussed supervised learning where the correct answers are available, and the task of the machine learning algorithm is to find a model that predicts them based on the input data.</p>
<p class="fs-18">In unsupervised learning, the correct answers are not provided. This makes the situation quite different since we can't build the model by making it fit the correct answers on training data. It also makes the evaluation of performance more complicated since we can't check whether the learned model is doing well or not.</p>
<p class="fs-18">Typical unsupervised learning methods attempt to learn some kind of “structure” underlying the data. This can mean, for example, <strong>visualization</strong> where similar items are placed near each other and dissimilar items further away from each other. It can also mean <strong>clustering</strong> where we use the data to identify groups or “clusters” of items that are similar to each other but dissimilar from data in other clusters.</p>

<div class="card card-default">
	<div class="card-block">
		<p class="fs-14">Note</p>
		<h4><span>Example</span></h4>
		<p class="fs-18">As a concrete example, grocery store chains collect data about their customers' shopping behavior (that's why you have all those loyalty cards). To better understand their customers, the store can either visualize the data using a graph where each customer is represented by a dot and customers who tend to buy the same products are placed nearer each other than customers who buy different products. Or, the store could apply clustering to obtain a set of customer groups such as ‘low-budget health food enthusiasts’, ‘high-end fish lovers’, ‘soda and pizza 6 days a week’, and so on. Note that the machine learning method would only group the customers into clusters, but it wouldn't automatically generate the cluster labels (‘fish lovers’ and so on). This task would be left for the user.</p>
	</div>
</div>


<p class="fs-18">Yet another example of unsupervised learning can be termed <strong>generative modeling</strong>. This has become a prominent approach since the last few years as a deep learning technique called generative adversarial networks (GANs) has lead to great advances. Given some data, for example, photographs of people's faces, a generative model can generate more of the same: more real-looking but artificial images of people's faces.</p>
<p class="fs-18">We will return to GANs and the implications of being able to produce high-quality artificial image content a bit later in the course, but next we will take a closer look at supervised learning and discuss some specific methods in more detail.</p>

</div>
</div>

<?php //create dummy entry with exercise=7 because there isn't one. will be deleted at next chapter
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
$sql="INSERT INTO `42_schema`.`EDUCATION_TABLE` (`USER_ID`, `CHAPTER`, `LESSON`, `EXERCISE`, `QUESTION`, `ANSWER`, `CORRECT` ) VALUES ($user_id, $this_chapter, $this_subchapter , 14, 1, 1 , 1)";
//loop through provided answers and save them:
if ($connection->query($sql) === TRUE) {} else {echo "Error: " . $sql . "<br>" . $connection->error;}
$connection->close();
?>


<!-- UP NEXT -->
<div class="card card-default">
	<div class="card-block">
		<h3>Next:</h3>
		<h1>II.  The nearest neighbor classifier&nbsp;&nbsp;&nbsp;
			<?php echo '<a href="42_education_4_2.php"><button type="button" class="btn btn-primary btn-lg">&nbsp;&nbsp;&nbsp;CONTINUE&nbsp;&nbsp;&nbsp;</button></a>'; ?>


			
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