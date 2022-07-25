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



// finally include menu:
include '42_education_include_menu.php';
?>


<!-- Main AREA -->



<!-- LEADING IMAGE -->
<div class="row">
	<div class="col-md-12" valign="top">
		<!--<img src="assets/images/course_1_1.jpg" class="img-fluid"  alt="...">-->
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

<h1><span>III. Advanced neural network techniques</span></h1>
<h3>In the previous section, we have discussed the basic ideas behind most neural network methods: multilayer networks, non-linear activation functions, and learning rules such as the backpropagation algorithm.</h3>

<p class="fs-18">They power almost all modern neural network applications. However, there are some interesting and powerful variations of the theme that have lead to great advances in deep learning in many areas.</p>

<h3>Convolutional neural networks (CNNs)</h3>
<p class="fs-18">One area where deep learning has achieved spectacular success is image processing. The simple classifier that we studied in detail in the previous section is severely limited – as you noticed it wasn't even possible to classify all the smiley faces correctly. Adding more layers in the network and using backpropagation to learn the weights does in principle solve the problem, but another one emerges: the number of weights becomes extremely large and consequently, the amount of training data required to achieve satisfactory accuracy can become too large to be realistic.</p>
<p class="fs-18">Fortunately, a very elegant solution to the problem of too many weights exists: a special kind of neural network, or rather, a special kind of layer that can be included in a deep neural network. This special kind of layer is a so-called <strong>convolutional layer</strong>. Networks including convolutional layers are called <strong>convolutional neural networks</strong> (CNNs). Their key property is that they can detect image features such as bright or dark (or specific color) spots, edges in various orientations, patterns, and so on. These form the basis for detecting more abstract features such as a cat’s ears, a dog’s snout, a person’s eye, or the octagonal shape of a stop sign. It would normally be hard to train a neural network to detect such features based on the pixels of the input image, because the features can appear in different positions, different orientations, and in different sizes in the image: moving the object or the camera angle will change the pixel values dramatically even if the object itself looks just the same to us. In order to learn to detect a stop sign in all these different conditions would require vast of amounts of training data because the network would only detect the sign in conditions where it has appeared in the training data. So, for example, a stop sign in the top right corner of the image would be detected only if the training data included an image with the stop sign in the top right corner. CNNs can recognize the object anywhere in the image no matter where it has been observed in the training images.</p>

<div class="card card-default">
	<div class="card-block">
		<p class="fs-14">Note</p>
		<h4><span>Why we need CNNs</span></h4>
		<p class="fs-18">CNNs use a clever trick to reduce the amount of training data required to detect objects in different conditions. The trick basically amounts to using the same input weights for many neurons – so that all of these neurons are activated by the same pattern – but with different input pixels. We can for example have a set of neurons that are activated by a cat’s pointy ear. When the input is a photo of a cat, two neurons are activated, one for the left ear and another for the right. We can also let the neuron’s input pixels be taken from a smaller or a larger area, so that different neurons are activated by the ear appearing in different scales (sizes), so that we can detect a small cat's ears even if the training data only included images of big cats.</p>
	</div>
</div>
<p class="fs-18">The convolutional neurons are typically placed in the bottom layers of the network, which processes the raw input pixels. Basic neurons (like the perceptron neuron discussed above) are placed in the higher layers, which process the output of the bottom layers. The bottom layers can usually be trained using unsupervised learning, without a particular prediction task in mind. Their weights will be tuned to detect features that appear frequently in the input data. Thus, with photos of animals, typical features will be ears and snouts, whereas in images of buildings, the features are architectural components such as walls, roofs, windows, and so on. If a mix of various objects and scenes is used as the input data, then the features learned by the bottom layers will be more or less generic. This means that pre-trained convolutional layers can be reused in many different image processing tasks. This is extremely important since it is easy to get virtually unlimited amounts of unlabeled training data – images without labels – which can be used to train the bottom layers. The top layers are always trained by supervised machine learning techniques such as backpropagation.</p>

<h3>Do neural networks dream of electric sheep? Generative adversarial networks (GANs)</h3>
<p class="fs-18">Having learned a neural network from data, it can be used for prediction. Since the top layers of the network have been trained in a supervised manner to perform a particular classification or prediction task, the top layers are really useful only for that task. A network trained to detect stop signs is useless for detecting handwritten digits or cats.</p>
<p class="fs-18">A fascinating result is obtained by taking the pre-trained bottom layers and studying what the features they have learned look like. This can be achieved by generating images that activate a certain set of neurons in the bottom layers. Looking at the generated images, we can see what the neural network “thinks” a particular feature looks like, or what an image with a select set of features in it would look like. Some even like to talk about the networks “dreaming” or “hallucinating” images (see Google’s <a href="https://en.wikipedia.org/wiki/DeepDream">DeepDream system</a>).</p>

<div class="card card-default">
	<div class="card-block">
		<p class="fs-14">Note</p>
		<h4><span>Be careful with metaphors</span></h4>
		<p class="fs-18">However, we’d like to once again emphasize the problem with metaphors such as dreaming when simple optimization of the input image is meant – remember the suitcase words discussed in Chapter 1. The neural network doesn’t really dream, and it doesn’t have a concept of a cat that it would understand in a similar sense as a human understands. It is simply trained to recognize objects and it can generate images that are similar to the input data that it is trained on.</p>
	</div>
</div>

<p class="fs-18">To actually generate real looking cats, human faces, or other objects (you’ll get whatever you used as the training data), <a href="https://en.wikipedia.org/wiki/Ian_Goodfellow">Ian Goodfellow</a> who currently works at Google Brain, proposed a clever combination of two neural networks. The idea is to let the two networks compete against each other. One of the networks is trained to generate images like the ones in the training data. The other network’s task is to separate images generated by the first network from real images from the training data – it is called the adversarial network, and the whole system is called generative adversarial network or a GAN.</p>
<p class="fs-18">The system trains the two models side by side. In the beginning of the training, the adversarial model has an easy task to tell apart the real images from the training data and the clumsy attempts by the generative model. However, as the generative network slowly gets better and better, the adversarial model has to improve as well, and the cycle continues until eventually the generated images are almost indistinguishable from real ones. The GAN tries to not only reproduce the images in the training data: that would be a way too simple strategy to beat the adversarial network. Rather, the system is trained so that it has to be able to generate new, real-looking images too.</p>
<img src="assets/images/img_5_3_1.png" class="img-fluid"  alt="..."><br><br>
<p class="fs-18">The above images were generated by a GAN developed by NVIDIA in a project led by <a href="https://users.aalto.fi/~lehtinj7/">Prof Jaakko Lehtinen</a> (see <a href="https://www.technologyreview.com/f/609290/meet-the-fake-celebrities-dreamed-up-by-ai/">this article</a> for more details).</p>
<p class="fs-18">Could you have recognized them as fakes?</p>

</div>
</div>

<?php //create dummy entry with exercise=23 because there isn't one. will be deleted at next chapter
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
$sqlretrievestring = 'DELETE FROM EDUCATION_TABLE WHERE USER_ID=' . $user_id . ' AND CHAPTER = ' . $this_chapter . ' AND LESSON = ' . $this_subchapter . ' AND EXERCISE = 23' ;
mysqli_query($connection, $sqlretrievestring);
$sql="INSERT INTO `42_schema`.`EDUCATION_TABLE` (`USER_ID`, `CHAPTER`, `LESSON`, `EXERCISE`, `QUESTION`, `ANSWER`, `CORRECT` ) VALUES ($user_id, $this_chapter, $this_subchapter , 23, 1, 1 , 1)";
//loop through provided answers and save them:
if ($connection->query($sql) === TRUE) {} else {echo "Error: " . $sql . "<br>" . $connection->error;}
$connection->close();
?>

<div class="card card-default">
	<div class="card-block">
		<h3>After completing Chapter 5 you should be able to:</h3>
		<blockquote>Explain what a neural network is and where they are being successfully used</blockquote>
		<blockquote>Understand the technical methods that underpin neural networks</blockquote>
		<h3>Next:</h3>
		<h1>Chapter 6: Implications&nbsp;&nbsp;&nbsp;
			<?php echo '<a href="42_education_6_1.php"><button type="button" class="btn btn-primary btn-lg">&nbsp;&nbsp;&nbsp;CONTINUE&nbsp;&nbsp;&nbsp;</button></a>'; ?>

		</h1>
	</div>
</div>












<!-- /EXERCISE -->

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