<?php 
	include_once("config/config.php");
		
		//not pressed login button
		if($_SESSION["loggedIn"]){
			$con = new PDO( DB_DSN, DB_USERNAME, DB_PASSWORD );
			$sthandler = $con->prepare("SELECT privilege, verified FROM users WHERE username = :username ");
			
			$sthandler->execute(array(':username'=>$_SESSION['username']));
			$row = $sthandler->fetch();

				$_SESSION['verified'] = $row['verified'];
				$_SESSION['privilege'] = $row['privilege'];

		}
		
		//if ($_SESSION["loggedIn"]){
			//stay here at reader-index
		//} else {
			//header( 'Location: index.php' ); //if not logged in go here
		//}
		//if ($_SESSION["privilege"] == 1 ){ //if account type author
			//header( 'Location: author-index.php' );
		//}	else if ($_SESSION["privilege"] == 2 ){
			//header( 'Location: admin-index.php' ); //if account type admin
		//}
		
			if( !(isset( $_POST['login'] ) ) ) {
?>

<!DOCTYPE html>
<html>
<head>
	<title>Adventure Blog | Home</title>
	<link href="stylesheets/stylesheet-index.css" rel="stylesheet" type="text/css">
	<link rel="shortcut icon" href="images/icon.ico" > 
	<meta name="viewport" content="height=device-height, width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no, target-densitydpi=device-dpi" />
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<script src="js/scroll.js" type="text/javascript"></script>
</head>
    <body>
		<div class="header">
			
				<img src="images/xplor.png"  class="xplor" alt=""/>
				<?php if (!$_SESSION["loggedIn"]){ ?>
				<div class="login">
					<!--Form called 'post'-->
					<form method="post" action="">
						<!--Username--> 
						<input type="text" maxlength="30"  value="Username"  onclick="this.value='';" autofocus name="username" class="text-round" required />
						<!--Password-->
						<input type="password" maxlength="30" value="Password" onclick="this.value='';" name="password" class="text-round" required/>
						<!--Login button-->			
						<input type="submit" name="login" value="Sign In" class="button-register-round"/>
						<!--Register Button-->
						<input type="button" name="register"  value="Sign Up" onclick="location.href='register.php'" class="button-register-round"/>
					</form>
				</div>
				<?php } else { ?>
				<div class="login">
					<!--Form called 'post'-->
					<form method="post" action="">
						<?php if ($_SESSION["verified"] == 0){ ?>						
							Please await verification</a>
						<?php ; } else { // verified == 1
							if ($_SESSION["privilege"] == 0){ ?>						
							Welcome <a href="reader-account.php"><?php echo $_SESSION['firstname'];?></a>
						<?php ; } else if ( $_SESSION["privilege"] == 1){ ?>						
							Welcome <a href="author-account.php"><?php echo $_SESSION['firstname'];?></a>
						<?php ; } else if ( $_SESSION["privilege"] == 2){ ?>						
							Welcome <a href="admin-account.php"><?php echo $_SESSION['firstname'];?></a>
						<?php ; } 
						}?>
						
						<!--Logout Button-->
						<input type="button" name="logout"  value="Logout" onclick="location.href='logout.php'" class="button-round"/>
					</form>
					
				</div>
				<?php } ?>
		</div>
			
		<div class="header-image">
			<h1>Discussion Board.</h1>
			<h2>A community to share your adventures with no matter your current location.</h2>
			<h3>Use the search bar below to search by tag.</h3>
			
			<form method="post" action="">
			
				<div class="center-round">
					<input type="text" maxlength="30" value="Search..." onclick="this.value='';" autofocus name="searchText" class="search-round" required />
					<input type="image" src="images/search.png" id="search-image" name="search" width="20" height="20" />
				</div>
			</form>
			
		</div>
		<div class="colour-split"></div>
	<div class="container"> <div id="toContainer"></div>
		<div class="content">
			<br>
					<div class="content">
		<!-- If user is a reader display php script below. Allow them to comment -->
		<?php
			
			
				$con = new PDO(DB_DSN, DB_USERNAME, DB_PASSWORD );
				$sthandler = $con->prepare("SELECT * FROM posts, users WHERE posts.userID = users.userID ORDER BY blogTime DESC");
				$sthandler->execute();

				while ($row = $sthandler->fetch(PDO::FETCH_ASSOC)){
				
							$postID = $row['postID'];
							$title = $row['title'];
							$post = $row['blogPost'];
							$blogTime = $row['blogTime'];
							$author = $row['username'];
							
				?>
							<h4><?php echo $title;?></h4>
							<div class="date"><?php echo $blogTime;?></div>
							<div class="author">By <?php echo $author;?></div>
							<br>
							<?php echo $post;?><br>
							
							<?php 
							
								$con2 = new PDO(DB_DSN, DB_USERNAME, DB_PASSWORD );
								$sthandler2 = $con2->prepare("SELECT * FROM comments WHERE postID = '$postID' ");
								$sthandler2->execute();

									while ($row2 = $sthandler2->fetch(PDO::FETCH_ASSOC)){
												
												$commentPostID = $row2['postID'];
												$commentID = $row2['commentID'];
												$commenterUsername = $row2['commenterUsername'];
												$_comment = $row2['_comment'];
												$report = $row2['report'];
												
												?>
												
												<br>
												<div class="username"><?php echo $commenterUsername;?> </div>
												<div class="comment"><?php echo $_comment;?> </div>
													
								<?php } 		 if (!$_SESSION["loggedIn"] || $_SESSION['verified'] == 0){  ?>
													<div class="add-comment">
																<textarea input type="text" id="theComment" required>Invalid privilege or not logged in. Please contact an administrator or create an account</textarea>
													</div>
											
								<?php } else if ($_SESSION["loggedIn"] && $_SESSION["privilege"] == 0){ ?>
													<div class="add-comment">
														<form method="post" action="">
															<textarea input type="text" id="theComment" required name="theComment"> </textarea>
															<input type="hidden" name="postID" value="<?php echo $postID; ?>">  
															<br>
															<input type="submit" name="insertComment" class="button-comment-round" value="Add Comment" />
														</form>
													</div>
												<?php ; }?>
												
												<?php if ($_SESSION["loggedIn"] && $_SESSION["privilege"] == 1){ ?>
						
												<?php ; }?>
												
												<?php if ($_SESSION["loggedIn"] && $_SESSION["privilege"] == 2){ ?>

												<?php ; }?>
												<?php
				}
			?>
			
			</div>	
		</div>
    </body>
</html>
	<?php					
							
		} else {
		$usr = new Users;
		$usr->storeFormValues( $_POST );
		if( $usr->userLogin() ) { // if the user exists then
		
			$_SESSION["loggedIn"] = true;
			$_SESSION['username'] = $_POST['username'];
			$_SESSION['password'] = $_POST['password'];
			
			$rememberme=$_POST['rememberme'];
			$username = $_POST['username'];
			
			$con = new PDO( DB_DSN, DB_USERNAME, DB_PASSWORD );
			$sthandler = $con->prepare("SELECT userID, email, firstname, surname, privilege, verified FROM users WHERE username = :username");
			
			$sthandler->execute(array(':username'=>$username));
			$row = $sthandler->fetch();
			
				$_SESSION['userID'] = $row['userID'];
				$_SESSION['email'] = $row['email'];
				$_SESSION['firstname'] = $row['firstname'];
				$_SESSION['surname'] = $row['surname'];
				$_SESSION['privilege'] = $row['privilege'];
				$_SESSION['verified'] = $row['verified'];
				$_SESSION['privilege'] = $row['privilege'];
				
				
				$privilege = $_SESSION['privilege'];
				$verified = $_SESSION['verified'];
				
				//Code below not yet tested
				if (isset($_POST['rememberme'])) {
					// checkbox has been checked
					setcookie("username", $username, time()+7600);
				} // then execute user type validation
				unset($_POST['login']);
				header('Location: index.php');
					
		} else {
			// incorrect username or password or dont have an account
			echo 'incorrect username or password. you may not have an account';
		}
	}
	
	if(isset( $_POST['insertComment'] ) ) { 
											
		$newComment = $_POST['theComment'];
		$postID = $_POST['postID'];
												 
		//$postID is the postID to add the comment to
		$usr = new Users;
		$usr->storeFormValues($_POST);
		
		if($usr->addComment($_POST)){
				//successfully added comment

			} else {

				//failed to add comment
			}				
		unset($_POST['insertComment']);			
	}
	?>