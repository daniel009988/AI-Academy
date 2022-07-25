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
$this_chapter    = 2;
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
$questions_string = array("Choose the value of the game");
$questions_options = array("1","-1","0"); // =1, =2, =3, etc.
$questions_correct = array(array(2));
$questions_correct_hint = array("The value is –1. The values on the second level are 0, 0, and –1. The values on the third level are –1, 0, –1, 0, –1, –1, which are the same as the values on the bottom level. As you can see, Max has all the reason to be serious since by playing in the bottom-right corner, Min can guarantee a win. The inevitable victory of Min can also be seen from the value of the game –1.");

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
	$sqlretrievestring = 'DELETE FROM EDUCATION_TABLE WHERE USER_ID=' . $user_id . ' AND CHAPTER = ' . $this_chapter . ' AND LESSON = ' . $this_subchapter . ' AND EXERCISE = 7' ;
	mysqli_query($connection, $sqlretrievestring);
	//loop through provided answers and save them:
	$question_num = 1;
	foreach($answers AS $answer) {
		$correct = -1;
		if (in_array($answer,$questions_correct[$question_num-1])) {$correct = 1;}
		$sql="INSERT INTO `42_schema`.`EDUCATION_TABLE` (`USER_ID`, `CHAPTER`, `LESSON`, `EXERCISE`, `QUESTION`, `ANSWER`, `CORRECT` ) VALUES ($user_id, $this_chapter, $this_subchapter , 7, $question_num, $answer , $correct)";
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
	$sqlretrievestring = 'SELECT * FROM EDUCATION_TABLE WHERE USER_ID=' . $user_id . ' AND CHAPTER = ' . $this_chapter . ' AND LESSON = ' . $this_subchapter . ' AND EXERCISE = 7' ;
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
//end

//count correct answers: ********************************************************************************************************************************
$count_correct = 0;
$count_total = 0;
foreach($answers AS $answer) {
	if (in_array($answer,$questions_correct[$count_total])) {$count_correct = $count_correct + 1;}
  	$count_total = $count_total + 1;
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
		<div class="text-center process-wizard-stepnum">Chapter 2</div>
		<div class="progress"><div class="progress-bar"></div></div>
		<a href="#" class="process-wizard-dot"></a>
		<div class="process-wizard-info text-center">&nbsp;</div>
	</div>
	<div class="col-md-1 process-wizard-step disabled"> <!-- complete active disabled -->
		<div class="text-center process-wizard-stepnum">Chapter 3</div>
		<div class="progress"><div class="progress-bar"></div></div>
		<a href="#" class="process-wizard-dot"></a>
		<div class="process-wizard-info text-center">&nbsp;</div>
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

<h1><span>III. Search and games</span></h1>
<h3>In this section, we will study a classic AI problem: games. The simplest scenario, which we will focus on for the sake of clarity, are two-player, perfect-information games such as tic-tac-toe and chess.</h3>
<h3>Example: playing tic tac toe</h3>

<p class="fs-18">Maxine and Minnie are true game enthusiasts. They just love games. Especially two-person, perfect information games such as tic-tac-toe or chess. One day they were playing tic-tac-toe. Maxine, or Max as her friends call her, was playing with X. Minnie, or Min as her friends call her, had the Os. Min had just played her turn and the board looked as follows:</p>

<img src="assets/images/img_2_3_1.svg" class="img-fluid"  alt="..."><br><br>

<p class="fs-18">Max was looking at the board and contemplating her next move, as it was her turn, when she suddenly buried her face in her hands in despair, looking quite like Garry Kasparov playing Deep Blue in 1997.</p>
<p class="fs-18">Yes, Min was close to getting three Os on the top row, but Max could easily put a stop to that plan. So why was Max so pessimistic?</p>

<h3>Game trees</h3>

<p class="fs-18">To solve games using AI, we will introduce the concept of a game tree. The different states of the game are represented by nodes in the game tree, very similar to the above planning problems. The idea is just slightly different. In the game tree, the nodes are arranged in levels that correspond to each player's turns in the game so that the “root” node of the tree (usually depicted at the top of the diagram) is the beginning position in the game. In tic-tac-toe, this would be the empty grid with no Xs or Os played yet. Under root, on the second level, there are the possible states that can result from the first player’s moves, be it X or O. We call these nodes the “children” of the root node.</p>
<p class="fs-18">Each node on the second level, would further have as its children nodes the states that can be reached from it by the opposing player's moves. This is continued, level by level, until reaching states where the game is over. In tic-tac-toe, this means that either one of the players get a line of three and wins, or the board is full and the game ends in a tie.</p>

<h3>Minimizing and maximizing value</h3>
<p class="fs-18">In order to be able to create game AI that attempts to win the game, we attach a numerical value to each possible end result. To the board positions where X has a line of three so that Max wins, we attach the value +1, and likewise, to the positions where Min wins with three Os in a row we attach the value -1. For the positions where the board is full and neither player wins, we use the neutral value 0 (it doesn’t really matter what the values are as long as they in this order so that Max tries to maximize the value, and Min tries to minimize it).</p>
<h4>A sample game tree</h4>
<p class="fs-18">Consider, for example, the following game tree which begins not at the root but in the middle of the game (because otherwise, the tree would be way too big to display). Note that this is different from the game shown in the illustration in the beginning of this section. We have numbered the nodes with numbers 1, 2, ..., 14.</p>
<p class="fs-18">The tree is composed of alternating layers where it is either Min's turn to place an O or Max's turn to place an X at any of the vacant slots on the board. The player whose turn it is to play next is shown at the left.</p>
<img src="assets/images/img_2_3_2.svg" class="img-fluid"  alt="..."><br><br>
<p class="fs-18">The game continues at the board position shown in the root node, numbered as (1) at the top, with Min’s turn to place O at any of the three vacant cells. Nodes (2)–(4) show the board positions resulting from each of the three choices respectively. In the next step, each node has two possible choices for Max to play X each, and so the tree branches again.</p>
<p class="fs-18">When starting from the above starting position, the game always ends in a row of three: in nodes (7) and (9), the winner is Max who plays with X, and in nodes (11)–(14) the winner is Min who plays with O.</p>
<p class="fs-18">Note that since the players’ turns alternate, the levels can be labeled as Min levels and Max levels, which indicates whose turn it is.</p>

<h3>Being strategic</h3>

<p class="fs-18">Consider nodes (5)–(10) on the second level from the bottom. In nodes (7) and (9), the game is over, and Max wins with three X’s in a row. The value of these positions is +1. In the remaining nodes, (5), (6), (8), and (10), the game is also practically over, since Min only needs to place her O in the only remaining cell to win. In other words, we know how the game will end at each node on the second level from the bottom. We can therefore decide that the value of nodes (5), (6), (8), and (10) is also –1.</p>
<img src="assets/images/img_2_3_3.svg" class="img-fluid"  alt="..."><br><br>
<p class="fs-18">Here comes the interesting part. Let’s consider the values of the nodes one level higher towards the root: nodes (2)–(4). Since we observed that both of the children of (2), i.e., nodes (5) and (6), lead to Min’s victory, we can without hesitation attach the value -1 to node (2) as well. However, for node (3), the left child (7) leads to Max’s victory, +1, but the right child (8) leads to Min winning, -1. What is the value of node (3)? Think about this for a while, keeping in mind who makes the choice at node (3).</p>
<p class="fs-18">Since it is Max’s turn to play, she will of course choose the left child, node (7). Thus, every time we reach the board position in node (3), Max can ensure victory, and we can attach the value +1 to node (3).</p>
<p class="fs-18">The same holds for node (4): again, since Max can choose where to put her X, she can always ensure victory, and we attach the value +1 to node (4).</p>
<img src="assets/images/img_2_3_4.svg" class="img-fluid"  alt="..."><br><br>

<h3>Determining who wins</h3>
<p class="fs-18">The most important lesson in this section is to apply the above kind of reasoning repeatedly to determine the result of the game in advance from any board position.</p>
<p class="fs-18">So far, we have decided that the value of node (2) is –1, which means that if we end up in such a board position, Min can ensure winning, and that the reverse holds for nodes (3) and (4): their value is +1, which means that Max can be sure to win if she only plays her own turn wisely.</p>
<p class="fs-18">Finally, we can deduce that since Min is an experienced player, she can reach the same conclusion, and thus she only has one real option: play the O in the middle of the board.</p>
<p class="fs-18">In the diagram below, we have included the value of each node as well as the optimal game play starting at Min's turn in the root node.</p>
<img src="assets/images/img_2_3_5.svg" class="img-fluid"  alt="..."><br><br>

<h3>The value of the root node = who wins</h3>

<p class="fs-18">The value of the root node, which is said to be the value of the game, tells us who wins (and how much, if the outcome is not just plain win or lose): Max wins if the value of the game is +1, Min if the value is –1, and if the value is 0, then the game will end in a draw. In other games, the value may also take other values (such as the monetary value of the chips in front of you in poker for example).</p>
<p class="fs-18">This all is based on the assumption that both players choose what is best for them and that what is best for one is the worst for the other (so called "zero-sum game").</p>

<div class="card card-default">
	<div class="card-block">
		<p class="fs-14">Note</p>
		<h4><span>Finding the optimal moves</span></h4>
		<p class="fs-18">Having determined the values of all the nodes in the game tree, the optimal moves can be deduced: at any Min node (where it is Min’s turn), the optimal choice is given by the child node whose value is minimal, and conversely, at any Max node (where it is Max’s turn), the optimal choice is given by the child node whose value is maximal. Sometimes there are many equally good choices that are, well, equally good, and the outcome will be the same no matter which one of them is picked.</p>
	</div>
</div>

<h3>The Minimax algorithm</h3>

<p class="fs-18">We can exploit the above concept of the value of the game to obtain an algorithm called the Minimax algorithm. It guarantees optimal game play in, theoretically speaking, any deterministic, two-person, perfect-information zero-sum game. Given a state of the game, the algorithm simply computes the values of the children of the given state and chooses the one that has the maximum value if it is Max’s turn, and the one that has the minimum value if it is Min’s turn.</p>
<p class="fs-18">The algorithm can be implemented using a few lines of code. However, we will be satisfied with having grasped the main idea. If you are interested in taking a look at the actual algorithm (alert: programming required) feel check out, for example, <a href="https://en.wikipedia.org/wiki/Minimax">Wikipedia: Minimax.</a></p>

<h3>Sounds good, can I go home now?</h3>
<p class="fs-18">As stated above, the Minimax algorithm can be used to implement optimal game play in any deterministic, two-player, perfect-information zero-sum game. Such games include tic-tac-toe, connect four, chess, Go, etc. Rock-paper-scissors is not in this class of games since it involves information hidden from the other player; nor are Monopoly or backgammon which are not deterministic. So as far as this topic is concerned, is that all folks, can we go home now? The answer is that in theory, yes, but in practice, no.</p>

<div class="card card-default">
	<div class="card-block">
		<p class="fs-14">Note</p>
		<h4><span>The problem of massive game trees</span></h4>
		<p class="fs-18">In many games, the game tree is simply way too big to traverse in full. For example, in chess the average branching factor, i.e., the average number of children (available moves) per node is about 35. That means that to explore all the possible scenarios up to only two moves ahead, we need to visit approximately 35 x 35 = 1225 nodes – probably not your favorite pencil-and-paper homework exercise. A look-ahead of three moves requires visiting 42875 nodes; four moves 1500625; and ten moves 2758547353515625 (that’s about 2.7 quadrillion) nodes. In Go, the average branching factor is estimated to be about 250. Go means no-go for Minimax.</p>
	</div>
</div>

<h3>More tricks: Managing massive game trees</h3>

<p class="fs-18">A few more tricks are needed to manage massive game trees. Many of them were crucial elements in IBM’s Deep Blue computer defeating the chess world champion, Garry Kasparov, in 1997.</p>
<p class="fs-18">If we can afford to explore only a small part of the game tree, we need a way to stop the minimax recursion before reaching an end-node, i.e., a node where the game is over and the winner is known. This is achieved by using a so called <strong>heuristic evaluation function</strong> that takes as input a board position, including the information about which player’s turn is next, and returns a score that should be an estimate of the likely outcome of the game continuing from the given board position.</p>

<div class="card card-default">
	<div class="card-block">
		<p class="fs-14">Note</p>
		<h4><span>Good heuristics</span></h4>
		<p class="fs-18">Good heuristics for chess, for example, typically count the amount of material (pieces) weighted by their type: the queen is usually considered worth about two times as much as a rook, three times a knight or a bishop, and nine times as much as a pawn. The king is of course worth more than all other things combined since losing it amounts to losing the game. Further, occupying the strategically important positions near the middle of the board is considered an advantage and the heuristic assign higher value to such positions.</p>
	</div>
</div>
<p class="fs-18">The minimax algorithm presented above requires minimal changes to obtain a <strong>depth-limited</strong> version where the heuristic is returned at all nodes at a given depth limit: the depth simply refers to the number of steps that the game tree is expanded before applying a heuristic evaluation function.</p>

<div class="card card-default">
	<div class="card-block">
		<p class="fs-14">Note</p>
		<h4><span>The limitations of plain search</span></h4>
		<p class="fs-18">It may look like we have a method to solve any problem by specifying the states and transitions between them, and finding a path from the current state to our goal. Alas, things get more complicated when we want to apply AI in real world problems. Basically, the number of states in even a moderately complex real-world scenario grows out of hand, and we can’t find a solution by exhaustive search (“brute force”) or even by using clever heuristics.</p>
		<p class="fs-18">Moreover, the transitions which take us from one state to the next when we choose an action are not deterministic. This means that whatever we choose to do will not always completely determine the outcome because there are factors that are beyond our control, and that are often unknown to us.</p>
		<p class="fs-18">The algorithms we have discussed above can be adapted to handle some randomness, for example randomness in choosing cards from a shuffled deck or throwing dice. This means that we will need to introduce the concept of uncertainty and probability. Only thus we can begin to approach real-world AI instead of simple puzzles and games. This is the topic of Chapter 3.</p>
	</div>
</div>


</div>

<!-- EXERCISE -->
<div class="callout alert alert-default">
	<div class="row">
		<div class="col-md-2" valign="top">
		</div>
		<div class="col-md-7 col-sm-8"><!-- left text -->
			<h1><span>Exercise 7: Why so pessimistic, Max?</span></h1>
			<p class="fs-18">Let's return to the tic-tac-toe game described in the beginning of this section. To narrow down the space of possible end-games to consider, we can observe that Max must clearly place an X on the top row to avoid imminent defeat:</p>
			<img src="assets/images/exercise7.svg" class="img-fluid"  alt="..."><br>
			<p class="fs-18">Now it's Min's turn to play an O. Evaluate the value of this state of the game as well as the other states in the game tree where the above position is the root, using the Minimax algorithm.</p><br>
			<p class="fs-18"><strong>Your task:</strong><br></p>
			<p class="fs-18">Look at the game tree starting from the below board position. Using a pencil and paper, fill in the values of the bottom-level nodes where the game is over. Note that this time some of the games end in a draw, which means that the values of the nodes is 0 (instead of –1 or 1).</p><br>
			<p class="fs-18">Next continue filling the values of the nodes in the next level up. Since there is no branching at that level, the values on the second lowest level are the same as at the bottom level.</p><br>
			<p class="fs-18">On the second highest level, fill in the values by choosing for each node the maximum of the values of the child nodes – as you notice, this is a MAX level. Finally, fill in the root node's value by choosing the minimum of the root node's child nodes' values. This is the value of the game.</p><br>
			<p class="fs-18"><strong>Enter the value of the game as your answer.</strong><br></p>
			<img src="assets/images/exercise7_2.svg" class="img-fluid"  alt="..."><br><br>
			

		</div>
		<div class="col-md-3" valign="top">
		</div>
	</div>
</div>

<div class="card card-default" id="exercise">
	<div class="card-block">
		<p class="fs-14">Answer the questions below</p>
		
	
<form class="m-0" method="post" action="#exercise" autocomplete="off">
	<!-- QUESTIONS -->
	<?php
		$elem = 0; 
		foreach($questions_string AS $question) {
			echo '<div class="row border-bottom">
					<div class="col-md-6" valign="top"><p class="fs-18">' . $question . '</p></div>';
			
			$ans = 1;
			foreach($questions_options AS $option) {
				echo '<div class="col-md-2" valign="top">';
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



</div>
</div>
<!-- UP NEXT -->
<div class="card card-default">
	<div class="card-block">
		<h3>After completing Chapter 2 you should be able to:</h3>
		<blockquote>Formulate a real-world problem as a search problem</blockquote>
		<blockquote>Formulate a simple game (such as tic-tac-toe) as a game tree</blockquote>
		<blockquote>Use the minimax principle to find optimal moves in a limited-size game tree</blockquote>
		<h3>Next:</h3>
		<h1>Chapter 3: Real World AI&nbsp;&nbsp;&nbsp;
			<?php if ($answers[0]==''){echo '<a href=""><button type="button" class="btn btn-btn-secondary btn-lg" disabled>&nbsp;&nbsp;&nbsp;CONTINUE&nbsp;&nbsp;&nbsp;</button></a>';} 
							else {echo '<a href="42_education_3_1.php"><button type="button" class="btn btn-primary btn-lg">&nbsp;&nbsp;&nbsp;CONTINUE&nbsp;&nbsp;&nbsp;</button></a>';} ?>

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