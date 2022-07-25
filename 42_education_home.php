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

//retrieve user status: - to be completed with SQL
include 'include_retrieve_user_status.php';

//include menu:
include '42_education_include_menu.php';
$signupfor = 'education';
include ('signupmodal.html'); 
?>


<!-- Main AREA -->

<!-- LEADING IMAGE -->
<div class="row">
	<div class="col-md-12" valign="top">
		<img src="assets/images/course_title_s2.jpg" class="img-fluid"  alt="...">
	</div>
</div>

<div class="container">
<div class="container">
	<br>



<div class="row">
	<div class="col-md-6" valign="top">
		<p class="font-lato fs-22"><strong>Will a robot take my job? How is artificial intelligence likely to change my job in the next ten years? Where are AI technologies being used right now and where will they come next? </strong></p>
		<p class="font-lato fs-15"><strong>The 42 Online Academy provides multiple courses in the field of Artificial Intelligence, from a general introduction to AI to specialised AI courses. Each of our courses can be taken independently.</strong></p>

		<p class="font-lato fs-15">The online certificate program "Introduction to Artificial Intelligence" is free and will take approximately 60 hours (6 weeks) to complete. It will shed light on various aspects of AI, including definitions, neural networks, machine learning and societal implications.</p>

		<p class="font-lato fs-15">Other available courses are "Ethics & Artificial Intelligence", a course discussing the different ethical implications of AI, and "Artificial Intelligence in Finance", a course for people working in finance. Each of them will take around 10 hours (1 week) to complete.</p> 

		

			
		
	</div>

	<div class="col-md-6" valign="top">
		<div class="card card-default" id="COMPILATIONS">
			<div class="card-heading card-heading-transparent">
					<h5><span><i class="glyphicon glyphicon-education"></i> Course 'Introduction to Artificial Intelligence'</span></h5>
			</div>			
			<div class="card-block">
				<div class="row border-bottom">
					<div class="col-md-5" valign="top">
						<p class="font-lato fs-13">
						Correct answers:<br>
						Answers under review:<br>
						Exercises completed:<br>
						Current chapter:</p>
					</div>
					<div class="col-md-5" valign="top">
						<p class="font-lato fs-13">
						<strong><?php echo $correct_answers;?></strong><br>
						<strong><?php echo $under_review;?></strong></br>
						<strong><?php echo $exercises_completed_block_1;?></strong><br>
						<strong><?php echo 'CH.'.$progress_chapter.'-'.$progress_subchapter;?></strong></p>
					</div>
				</div>

				<div class="row">
					<div class="col-md-5"><br>
						<?php
						#if (($progress_chapter==1) && ($progress_subchapter==1)){echo '<a href="42_education_1_1.php"><button type="button" class="btn btn-primary btn-lg">&nbsp;&nbsp;&nbsp;GET STARTED!&nbsp;&nbsp;&nbsp;</button></a></h1>';}

						if (($progress_chapter==1) && ($progress_subchapter==1)){echo '<a href="#"><button type="button" class="btn btn-primary btn-lg">&nbsp;&nbsp;&nbsp;GET STARTED!&nbsp;&nbsp;&nbsp;</button></a></h1><p class="fs-11">Note: This course is currently being updated - will be back soon!</p>';}


						else {
						echo '<a class="btn btn-blue" href="42_education_'.strval($progress_chapter).'_'.strval($progress_subchapter).'.php" role="button">Continue with Chapter '.$progress_chapter.'-'.$progress_subchapter.'</a>';}
						?>
					</div>
					<div class="col-md-5"><br>
						<p class="font-lato fs-13"><strong>Grading criteria:</strong> (i) minimum 90% of exercises completed; and (ii) minimum 50% of correct answers.</p>
					</div>
				</div>



				
			</div>
		</div>

		<div class="card card-default" id="COMPILATIONS">
			<div class="card-heading card-heading-transparent">
					<h5><span><i class="glyphicon glyphicon-education"></i> Course 'Ethics & Artificial Intelligence' (COMING SOON)</span></h5>
			</div>		
		</div>
		<div class="card card-default" id="COMPILATIONS">
			<div class="card-heading card-heading-transparent">
					<h5><span><i class="glyphicon glyphicon-education"></i> Course 'Artificial Intelligence in Finance' (SOMING SOON)</span></h5>
			</div>		
		</div>


	</div>
</div>

<div class="row">
	<div class="col-md-12" valign="top">
		<div class="card card-default">
			<div class="card-heading card-heading-transparent bg-secondary">
				<h4 class="text-white text-center"><i class="glyphicon glyphicon-education"></i> Course "Introduction to Artificial Intelligence" <button type="button" class="btn btn-secondary btn-sm" disabled>FREE</button></h4>
			</div>
		</div>
		<p class="font-lato fs-15">The online certificate program "Introduction to Artificial Intelligence" is free and will take you approximately 60 hours (6 weeks) to complete. It will shed light on various aspects of AI, including definitions, neural networks, machine learning and societal implications. No programming, but some basic math is required. Some exercises also require you to draw with a pen and paper to find the answer to the question. You will receive a certificate after successfuly completing the course.</p>
	</div>
</div>

<div class="row">
	
	<!-- TAB ........................................................................................................ -->
	<div class="col-md-6" valign="top">
		<div class="card card-default" id="COMPILATIONS">
			<div class="card-heading card-heading-transparent">
				<h5><span><i class="et-lightbulb"></i> Chapter 1 - What is AI?</span></h5>
			</div>			
			<div align="center"><img src="assets/images/course_1_1.jpg" class="img-fluid"  alt="..."></div>
			<div class="card-block">
						
				<div class="row">
					<div class="table-responsive">
						<table class="table table-hover font-lato fs-12 table-light">
							<thead>
								<td><strong>Lesson</strong></td>
								<td><strong>Exercises</strong></td>
								<td></td>
							</thead>
							<tbody>
								<tr>
									<td>I. How should we define AI?</td>
									<td>1</td>
									<td align="right">
										<?php 
											if ($progress_chapter*10+$progress_subchapter > 11) {echo 'completed <i class="fa fa-check text-green"></i>';}

											#if ($progress_chapter*10+$progress_subchapter == 11) {echo '<a href="42_education_1_1.php"><button type="button" class="btn btn-primary btn-sm">Complete</button></a>';}
											if ($progress_chapter*10+$progress_subchapter == 11) {echo '<a href="42_education_1_1.php"><button type="button" class="btn btn-secondary btn-sm" disabled>Complete</button></a>';} 
											if ($progress_chapter*10+$progress_subchapter < 11) {echo '<a href="42_education_1_1.php"><button type="button" class="btn btn-secondary btn-sm" disabled>Complete</button></a>';}

										?>
									</td>
								</tr>
								<tr>
									<td>II. Related fields</td>
									<td>2</td>
									<td align="right">
										<?php 
											if ($progress_chapter*10+$progress_subchapter > 12) {echo 'completed <i class="fa fa-check text-green"></i>';}
											if ($progress_chapter*10+$progress_subchapter == 12) {echo '<a href="42_education_1_2.php"><button type="button" class="btn btn-primary btn-sm">Complete</button></a>';} 
											if ($progress_chapter*10+$progress_subchapter < 12) {echo '<a href="42_education_1_2.php"><button type="button" class="btn btn-secondary btn-sm" disabled>Complete</button></a>';}
										?>
									</td>
								</tr>
								<tr>
									<td>III. Philosophy of AI</td>
									<td>1</td>
									<td align="right">
										<?php 
											if ($progress_chapter*10+$progress_subchapter > 13) {echo 'completed <i class="fa fa-check text-green"></i>';}
											if ($progress_chapter*10+$progress_subchapter == 13) {echo '<a href="42_education_1_3.php"><button type="button" class="btn btn-primary btn-sm">Complete</button></a>';} 
											if ($progress_chapter*10+$progress_subchapter < 13) {echo '<a href="42_education_1_3.php"><button type="button" class="btn btn-secondary btn-sm" disabled>Complete</button></a>';}
										?>
									</td>
								</tr>
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- END TAB -->

	<!-- TAB ........................................................................................................ -->
	<div class="col-md-6" valign="top">
		<div class="card card-default" id="COMPILATIONS">
			<div class="card-heading card-heading-transparent">
					<h5><span><i class="et-lightbulb"></i> Chapter 2 - AI problem solving</span></h5>
			</div>			
			<div align="center"><img src="assets/images/course_2_1.png" class="img-fluid" alt="..."></div>
			<div class="card-block">
				
				<div class="row">
					<div class="table-responsive">
						<table class="table table-hover font-lato fs-12 table-light">
							<thead>
								<td><strong>Lesson</strong></td>
								<td><strong>Exercises</strong></td>
								<td></td>
							</thead>
							<tbody>
								<tr>
									<td>I. Search and problem solving</td>
									<td>2</td>
									<td align="right"><?php 
											if ($progress_chapter*10+$progress_subchapter > 21) {echo 'completed <i class="fa fa-check text-green"></i>';}
											if ($progress_chapter*10+$progress_subchapter == 21) {echo '<a href="42_education_2_1.php"><button type="button" class="btn btn-primary btn-sm">Complete</button></a>';} 
											if ($progress_chapter*10+$progress_subchapter < 21) {echo '<a href="42_education_2_1.php"><button type="button" class="btn btn-secondary btn-sm" disabled>Complete</button></a>';}
										?></td>
								</tr>
								<tr>
									<td>II. Solving problems with AI</td>
									<td>---</td>
									<td align="right"><?php 
											if ($progress_chapter*10+$progress_subchapter > 22) {echo 'completed <i class="fa fa-check text-green"></i>';}
											if ($progress_chapter*10+$progress_subchapter == 22) {echo '<a href="42_education_2_2.php"><button type="button" class="btn btn-primary btn-sm">Complete</button></a>';} 
											if ($progress_chapter*10+$progress_subchapter < 22) {echo '<a href="42_education_2_2.php"><button type="button" class="btn btn-secondary btn-sm" disabled>Complete</button></a>';}
										?></td>
								</tr>
								<tr>
									<td>III. Search and games</td>
									<td>1</td>
									<td align="right"><?php 
											if ($progress_chapter*10+$progress_subchapter > 23) {echo 'completed <i class="fa fa-check text-green"></i>';}
											if ($progress_chapter*10+$progress_subchapter == 23) {echo '<a href="42_education_2_3.php"><button type="button" class="btn btn-primary btn-sm">Complete</button></a>';} 
											if ($progress_chapter*10+$progress_subchapter < 23) {echo '<a href="42_education_2_3.php"><button type="button" class="btn btn-secondary btn-sm" disabled>Complete</button></a>';}
										?></td>
								</tr>
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- END TAB -->

	<!-- TAB ........................................................................................................ -->
	<div class="col-md-6" valign="top">
		<div class="card card-default" id="COMPILATIONS">
			<div class="card-heading card-heading-transparent">
					<h5><span><i class="et-lightbulb"></i> Chapter 3 - Real world AI</span></h5>
			</div>	
			<div align="center"><img src="assets/images/course_3_1.png" class="img-fluid" alt="..."></div>		
			<div class="card-block">
				
				<div class="row">
					<div class="table-responsive">
						<table class="table table-hover font-lato fs-12 table-light">
							<thead>
								<td><strong>Lesson</strong></td>
								<td><strong>Exercises</strong></td>
								<td></td>
							</thead>
							<tbody>
								<tr>
									<td>I. Odds and probability</td>
									<td>2</td>
									<td align="right"><?php 
											if ($progress_chapter*10+$progress_subchapter > 31) {echo 'completed <i class="fa fa-check text-green"></i>';}
											if ($progress_chapter*10+$progress_subchapter == 31) {echo '<a href="42_education_3_1.php"><button type="button" class="btn btn-primary btn-sm">Complete</button></a>';} 
											if ($progress_chapter*10+$progress_subchapter < 31) {echo '<a href="42_education_3_1.php"><button type="button" class="btn btn-secondary btn-sm" disabled>Complete</button></a>';}
										?></td>
								</tr>
								<tr>
									<td>II. The Bayes rule</td>
									<td>2</td>
									<td align="right"><?php 
											if ($progress_chapter*10+$progress_subchapter > 32) {echo 'completed <i class="fa fa-check text-green"></i>';}
											if ($progress_chapter*10+$progress_subchapter == 32) {echo '<a href="42_education_3_2.php"><button type="button" class="btn btn-primary btn-sm">Complete</button></a>';} 
											if ($progress_chapter*10+$progress_subchapter < 32) {echo '<a href="42_education_3_2.php"><button type="button" class="btn btn-secondary btn-sm" disabled>Complete</button></a>';}
										?></td>
								</tr>
								<tr>
									<td>III. Naive Bayes classification</td>
									<td>2</td>
									<td align="right"><?php 
											if ($progress_chapter*10+$progress_subchapter > 33) {echo 'completed <i class="fa fa-check text-green"></i>';}
											if ($progress_chapter*10+$progress_subchapter == 33) {echo '<a href="42_education_3_3.php"><button type="button" class="btn btn-primary btn-sm">Complete</button></a>';} 
											if ($progress_chapter*10+$progress_subchapter < 33) {echo '<a href="42_education_3_3.php"><button type="button" class="btn btn-secondary btn-sm" disabled>Complete</button></a>';}
										?></td>
								</tr>
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- END TAB -->

	<!-- TAB ........................................................................................................ -->
	<div class="col-md-6" valign="top">
		<div class="card card-default" id="COMPILATIONS">
			<div class="card-heading card-heading-transparent">
					<h5><span><i class="et-lightbulb"></i> Chapter 4 - Machine Learning</span></h5>
			</div>			
			<div align="center"><img src="assets/images/course_4_1.png" class="img-fluid" alt="..."></div>
			<div class="card-block">
				
				<div class="row">
					<div class="table-responsive">
						<table class="table table-hover font-lato fs-12 table-light">
							<thead>
								<td><strong>Lesson</strong></td>
								<td><strong>Exercises</strong></td>
								<td></td>
							</thead>
							<tbody>
								<tr>
									<td>I. The types of machine learning</td>
									<td>---</td>
									<td align="right"><?php 
											if ($progress_chapter*10+$progress_subchapter > 41) {echo 'completed <i class="fa fa-check text-green"></i>';}
											if ($progress_chapter*10+$progress_subchapter == 41) {echo '<a href="42_education_4_1.php"><button type="button" class="btn btn-primary btn-sm">Complete</button></a>';} 
											if ($progress_chapter*10+$progress_subchapter < 41) {echo '<a href="42_education_4_1.php"><button type="button" class="btn btn-secondary btn-sm" disabled>Complete</button></a>';}
										?></td>
								</tr>
								<tr>
									<td>II. The nearest neighbour classifier</td>
									<td>2</td>
									<td align="right"><?php 
											if ($progress_chapter*10+$progress_subchapter > 42) {echo 'completed <i class="fa fa-check text-green"></i>';}
											if ($progress_chapter*10+$progress_subchapter == 42) {echo '<a href="42_education_4_2.php"><button type="button" class="btn btn-primary btn-sm">Complete</button></a>';} 
											if ($progress_chapter*10+$progress_subchapter < 42) {echo '<a href="42_education_4_2.php"><button type="button" class="btn btn-secondary btn-sm" disabled>Complete</button></a>';}
										?></td>
								</tr>
								<tr>
									<td>III. Regression</td>
									<td>4</td>
									<td align="right"><?php 
											if ($progress_chapter*10+$progress_subchapter > 43) {echo 'completed <i class="fa fa-check text-green"></i>';}
											if ($progress_chapter*10+$progress_subchapter == 43) {echo '<a href="42_education_4_3.php"><button type="button" class="btn btn-primary btn-sm">Complete</button></a>';} 
											if ($progress_chapter*10+$progress_subchapter < 43) {echo '<a href="42_education_4_3.php"><button type="button" class="btn btn-secondary btn-sm" disabled>Complete</button></a>';}
										?></td>
								</tr>
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- END TAB -->

	<!-- TAB ........................................................................................................ -->
	<div class="col-md-6" valign="top">
		<div class="card card-default" id="COMPILATIONS">
			<div class="card-heading card-heading-transparent">
					<h5><span><i class="et-lightbulb"></i> Chapter 5 - Neural Networks</span></h5>
			</div>			
			<div align="center"><img src="assets/images/course_5_1.png" class="img-fluid" alt="..."></div>
			<div class="card-block">
				
				<div class="row">
					<div class="table-responsive">
						<table class="table table-hover font-lato fs-12 table-light">
							<thead>
								<td><strong>Lesson</strong></td>
								<td><strong>Exercises</strong></td>
								<td></td>
							</thead>
							<tbody>
								<tr>
									<td>I. Neural network basics</td>
									<td>1</td>
									<td align="right"><?php 
											if ($progress_chapter*10+$progress_subchapter > 51) {echo 'completed <i class="fa fa-check text-green"></i>';}
											if ($progress_chapter*10+$progress_subchapter == 51) {echo '<a href="42_education_5_1.php"><button type="button" class="btn btn-primary btn-sm">Complete</button></a>';} 
											if ($progress_chapter*10+$progress_subchapter < 51) {echo '<a href="42_education_5_1.php"><button type="button" class="btn btn-secondary btn-sm" disabled>Complete</button></a>';}
										?></td>
								</tr>
								<tr>
									<td>II. How neural networks are built</td>
									<td>2</td>
									<td align="right"><?php 
											if ($progress_chapter*10+$progress_subchapter > 52) {echo 'completed <i class="fa fa-check text-green"></i>';}
											if ($progress_chapter*10+$progress_subchapter == 52) {echo '<a href="42_education_5_2.php"><button type="button" class="btn btn-primary btn-sm">Complete</button></a>';} 
											if ($progress_chapter*10+$progress_subchapter < 52) {echo '<a href="42_education_5_2.php"><button type="button" class="btn btn-secondary btn-sm" disabled>Complete</button></a>';}
										?></td>
								</tr>
								<tr>
									<td>III. Advanced neural network techniques</td>
									<td>---</td>
									<td align="right"><?php 
											if ($progress_chapter*10+$progress_subchapter > 53) {echo 'completed <i class="fa fa-check text-green"></i>';}
											if ($progress_chapter*10+$progress_subchapter == 53) {echo '<a href="42_education_5_3.php"><button type="button" class="btn btn-primary btn-sm">Complete</button></a>';} 
											if ($progress_chapter*10+$progress_subchapter < 53) {echo '<a href="42_education_5_3.php"><button type="button" class="btn btn-secondary btn-sm" disabled>Complete</button></a>';}
										?></td>
								</tr>
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- END TAB -->

	<!-- TAB ........................................................................................................ -->
	<div class="col-md-6" valign="top">
		<div class="card card-default" id="COMPILATIONS">
			<div class="card-heading card-heading-transparent">
					<h5><span><i class="et-lightbulb"></i> Chapter 6 - Implications</span></h5>
			</div>			
			<div align="center"><img src="assets/images/course_6_1.png" class="img-fluid" alt="..."></div>
			<div class="card-block">
				
				<div class="row">
					<div class="table-responsive">
						<table class="table table-hover font-lato fs-12 table-light">
							<thead>
								<td><strong>Lesson</strong></td>
								<td><strong>Exercises</strong></td>
								<td></td>
							</thead>
							<tbody>
								<tr>
									<td>I. About predicting the future</td>
									<td>1</td>
									<td align="right"><?php 
											if ($progress_chapter*10+$progress_subchapter > 61) {echo 'completed <i class="fa fa-check text-green"></i>';}
											if ($progress_chapter*10+$progress_subchapter == 61) {echo '<a href="42_education_6_1.php"><button type="button" class="btn btn-primary btn-sm">Complete</button></a>';} 
											if ($progress_chapter*10+$progress_subchapter < 61) {echo '<a href="42_education_6_1.php"><button type="button" class="btn btn-secondary btn-sm" disabled>Complete</button></a>';}
										?></td>
								</tr>
								<tr>
									<td>II. The societal implications of AI</td>
									<td>1</td>
									<td align="right"><?php 
											if ($progress_chapter*10+$progress_subchapter > 62) {echo 'completed <i class="fa fa-check text-green"></i>';}
											if ($progress_chapter*10+$progress_subchapter == 62) {echo '<a href="42_education_6_2.php"><button type="button" class="btn btn-primary btn-sm">Complete</button></a>';} 
											if ($progress_chapter*10+$progress_subchapter < 62) {echo '<a href="42_education_6_2.php"><button type="button" class="btn btn-secondary btn-sm" disabled>Complete</button></a>';}
										?></td>
								</tr>
								<tr>
									<td>III. Summary</td>
									<td>1</td>
									<td align="right"><?php 
											if ($progress_chapter*10+$progress_subchapter > 63) {echo 'completed <i class="fa fa-check text-green"></i>';}
											if ($progress_chapter*10+$progress_subchapter == 63) {echo '<a href="42_education_6_3.php"><button type="button" class="btn btn-primary btn-sm">Complete</button></a>';} 
											if ($progress_chapter*10+$progress_subchapter < 63) {echo '<a href="42_education_6_3.php"><button type="button" class="btn btn-secondary btn-sm" disabled>Complete</button></a>';}
										?></td>
								</tr>
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- END TAB -->

</div>
<div class="row">
	<div class="col-md-6" valign="top">
		<div class="card card-default">
			<div class="card-heading card-heading-transparent bg-secondary">
				<h4 class="text-white text-center"><i class="glyphicon glyphicon-education"></i> Course "Ethics & Artificial Intelligence" <button type="button" class="btn btn-secondary btn-sm" disabled>COMING SOON</button></h4>
			</div>
		</div>
		<p class="font-lato fs-15">The online certificate program "Ethics & Artificial Intelligence" discusses Artificial Intelligence from an ethical point of view, which is becoming more and more important as AI evolves rapidly. Who can be held accountable if AI makes a wrong decision? Topics like robot rights, threat to human dignity and transparency, accountability and open source of AI technology are being adressed. You can take this course stand-alone without having to pass any of our other courses. No programmig skills are required. You will receive a certificate after successfuly completing the course.</p>
	</div>
	<div class="col-md-6" valign="top">
		<div class="card card-default">
			<div class="card-heading card-heading-transparent bg-secondary">
				<h4 class="text-white text-center"><i class="glyphicon glyphicon-education"></i> Course "Artificial Intelligence in Finance" <button type="button" class="btn btn-secondary btn-sm" disabled>COMING SOON</button></h4>
			</div>
		</div>
		<p class="font-lato fs-15">The online certificate program "Artificial Intelligence in Finance" first explains the AI company ecosystem from a financial investor perspective. It then discusses the different applications of AI in finance, from AI based trading to investing in AI. It also sheds light on how to identify AI investment opportunities. You can take this course stand-alone without having to pass any of our other courses. No programmig skills are required, but a gereral understanding of finance is helpful. You will receive a certificate after successfuly completing the course.</p>
	</div>
</div>


<div class="row">

	<!-- TAB ........................................................................................................ -->
	<div class="col-md-6" valign="top">
		<div class="card card-default" id="COMPILATIONS">
			<div class="card-heading card-heading-transparent">
					<h5><span><i class="et-lightbulb"></i> Ethics of AI</span></h5>
			</div>			
			<div align="center"><img src="assets/images/course_7_1.png" class="img-fluid" alt="..."></div>
			<div class="card-block">
				
				<div class="row">
					<div class="table-responsive">
						<table class="table table-hover font-lato fs-12 table-light">
							<thead>
								<td><strong>Lesson</strong></td>
								<td><strong>Exercises</strong></td>
								<td></td>
							</thead>
							<tbody>
								<tr>
									<td>I. Robot rights</td>
									<td>0/1</td>
									<td align="right"><a href="42_education_7_1.php"><button type="button" class="btn btn-secondary btn-sm" disabled>COMING SOON</button></a></td>
								</tr>
								<tr>
									<td>II. Threat to human dignity</td>
									<td>0/1</td>
									<td align="right"><a href="42_education_7_2.php"><button type="button" class="btn btn-secondary btn-sm" disabled>COMING SOON</button></a></td>
								</tr>
								<tr>
									<td>III. Transparency, accountability, and open source</td>
									<td>0/1</td>
									<td align="right"><a href="42_education_7_3.php"><button type="button" class="btn btn-secondary btn-sm" disabled>COMING SOON</button></a></td>
								</tr>
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- END TAB -->

	<!-- TAB ........................................................................................................ -->
	<div class="col-md-6" valign="top">
		<div class="card card-default" id="COMPILATIONS">
			<div class="card-heading card-heading-transparent">
					<h5><span><i class="et-lightbulb"></i> AI & Finance</span></h5>
			</div>			
			<div align="center"><img src="assets/images/course_8_1.png" class="img-fluid" alt="..."></div>
			<div class="card-block">
				
				<div class="row">
					<div class="table-responsive">
						<table class="table table-hover font-lato fs-12 table-light">
							<thead>
								<td><strong>Lesson</strong></td>
								<td><strong>Exercises</strong></td>
								<td></td>
							</thead>
							<tbody>
								<tr>
									<td>I. The AI company ecosystem</td>
									<td>0/1</td>
									<td align="right"><a href="42_education_8_1.php"><button type="button" class="btn btn-secondary btn-sm" disabled>COMING SOON</button></a></td>
								</tr>
								<tr>
									<td>II. Trading AI & AI financial advisory services</td>
									<td>0/1</td>
									<td align="right"><a href="42_education_8_2.php"><button type="button" class="btn btn-secondary btn-sm" disabled>COMING SOON</button></a></td>
								</tr>
								<tr>
									<td>III. Identifying AI investment opportunities</td>
									<td>0/1</td>
									<td align="right"><a href="42_education_8_3.php"><button type="button" class="btn btn-secondary btn-sm" disabled>COMING SOON</button></a></td>
								</tr>
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- END TAB -->
	

	
</div>
<!-- /wrapper -->
<br><br>

<p class="font-lato fs-15">(C)2019 by 42.CX</p>

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