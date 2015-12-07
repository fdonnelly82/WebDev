<?php 
	include_once("config/config.php");
		
		if ($_SESSION["loggedIn"]){
			$con = new PDO( DB_DSN, DB_USERNAME, DB_PASSWORD );
			$sthandler = $con->prepare("SELECT privilege, verified FROM users WHERE username = :username ");
			
			$sthandler->execute(array(':username'=>$_SESSION['username']));
			$row = $sthandler->fetch();

				$_SESSION['verified'] = $row['verified'];
				$_SESSION['privilege'] = $row['privilege'];
				
			if ($_SESSION["privilege"] == 0 ){ //if account type reader
				header( 'Location: reader-index.php' );
			}	else if ($_SESSION["privilege"] == 1 ){
				header( 'Location: author-index.php' ); //if account type author
			}   else if ($_SESSION["privilege"] == 2 ){
				 //if account type admin stay here
			} else {
				header( 'Location: index.php' );
			}
		}
		
		if(!isset( $_POST['insertComment'] ) ) { 
?>

<!DOCTYPE html>
<html>
<head>
	<title>Adventure Blog | Home</title>
	<link href="stylesheets/stylesheet-index.css" rel="stylesheet" type="text/css">
	<link rel="shortcut icon" href="images/icon.ico" > 
	<meta name="viewport" content="height=device-height, width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no, target-densitydpi=device-dpi" />
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	
	<script src="js/readmore.js" type="text/javascript"></script>
	<script src="http://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
</head>
    <body>
		<div class="header">
			
				<img src="images/xplor.png"  class="xplor" alt=""/>
				<div class="login">
					<!--Form called 'post'-->
					<form method="post" action="">
						<?php if ($_SESSION["verified"] == 0){ ?>						
							Please await verification</a>
						<?php ; } else { ?> 				
							Welcome <a href="admin-account.php"><?php echo $_SESSION['firstname'];?></a>
						<?php ; } ?>
						<!--Logout Button-->
						<input type="button" name="logout"  value="Logout" onclick="location.href='logout.php'" class="button-round"/>
					</form>
					
				</div>
		</div>
			
		<div class="header-image">
			<h1>Discussion Board.</h1>
			<h2>A community to share your adventures with no matter your current location.</h2>
			<h3>Use the search bar below to search by tag.</h3>
			
			<!--search-->
			<form method="post" action="">
			
				<div class="center-round">
						<input name="search-tags" id="search-tags" class="search-round" maxlength="30" value="Search..." onclick="this.value='';" autofocus name="searchText"  required />
					    <input type="image" src="images/search.png" id="search-image" name="search" width="20" height="20" />
				</div>
				
			</form>
			
		</div>
		
	<div class="colour-split"></div>
	
	<div class="container"> 
	<div id="toContainer"></div>
	<div class="tags">
		Featured Tags	
			<br>
			________________________
	</div>	
	<div class="content">
			<br>
					<div class="content">

		<!-- If user is a reader display php script below. Allow them to comment -->
		<?php
				$con = new PDO(DB_DSN, DB_USERNAME, DB_PASSWORD );
				$sthandler = $con->prepare("SELECT * FROM posts, users WHERE posts.userID = users.userID ORDER BY blogTime DESC");
				$sthandler->execute();
				
				//Fetch all the blog post information
				while ($row = $sthandler->fetch(PDO::FETCH_ASSOC)){
				
					$postID = $row['postID'];
					$title = $row['title'];
					$post = $row['blogPost'];
					$blogTime = $row['blogTime'];
					$author = $row['username'];
					$rating = $row['rating'];
				?>
				
					<div class="rating-block">
						<div class="rating">
							<?php echo $rating;?>
							<form method="post" action="">
									<input type="hidden" name="ratingPostID" value="<?php echo $postID; ?>"> 
									<input type="image" src="images/up.png" name="addOne" value="+1">
									<br>
									<input type="image" src="images/down.png" name="subOne" value="-1">
							</form>
						</div>
					</div>
				<?php
							if(isset( $_POST['addOne'] ) ) { 		
							
												$theRatingPostID = $_POST['ratingPostID'];

								$sthandler = $con->prepare("UPDATE posts  SET rating=rating + 1 WHERE postID = '$theRatingPostID' ");
								$sthandler->execute();
								
								header( 'Location: admin-index.php' );
								
							}
							
							if(isset( $_POST['subOne'] ) ) { 
													$theRatingPostID = $_POST['ratingPostID'];

								$sthandler = $con->prepare("UPDATE posts  SET rating=rating - 1 WHERE postID = '$theRaringPostID' ");
								$sthandler->execute();
								
								header( 'Location: admin-index.php' );
							}
							

				?>
				
					<h4><?php echo $title;?></h4>
					<div class="date"><?php echo $blogTime;?></div>
					<div class="author">By <?php echo $author;?></div>
					<br>
			
					<article>
						<p>
							<?php echo $post;?>
						</p>
					

							<!-- Delete Post form -->
							<form method="post" action="">
								<div class='edit-data-admin'>
									<input type="hidden" name="deletePostID" value="<?php echo $postID; ?>">  
									<input type="image" src="images/deletePost.png" name="deletePost" value="Delete">
								</div>
							</form>
							
					<!-- Delete a comment -->
					<?php
					if(isset( $_POST['deletePost'] ) ) { 
						$thePostID = $_POST['deletePostID'];
												
						$con = new PDO( DB_DSN, DB_USERNAME, DB_PASSWORD );
						$sthandler = $con->prepare("DELETE FROM posts WHERE postID = '$thePostID' ");
						$sthandler->execute();
						
						header( 'Location: admin-index.php' );
					}
					?>
					<?php 
						$con2 = new PDO(DB_DSN, DB_USERNAME, DB_PASSWORD );
						$sthandler2 = $con2->prepare("SELECT * FROM comments WHERE postID = '$postID' ");
						$sthandler2->execute();
						
					//Fetch all user comments for the correct post
						while ($row2 = $sthandler2->fetch(PDO::FETCH_ASSOC)){	
							$commentPostID = $row2['postID'];
							$commentID = $row2['commentID'];
							$commenterUsername = $row2['commenterUsername'];
							$_comment = $row2['_comment'];
							$report = $row2['report'];		
							
					
							if(!isset( $_POST['deleteMe'] ) ) { 
if(!isset( $_POST['edit'] ) ) { 							
					?>
							<br>
							<div class="username"><?php echo $commenterUsername;?> </div>
							<div class="comment"><?php echo $_comment;?> </div>
							
					<!-- Edit comment form -->
							<form method="post" action="">
								<div class="edit-data">
									<input type="image" src="images/edit.png" name="edit" value="Edit">
									<input type="hidden" name="commentID" value="<?php echo $commentID; ?>">  
								</div>
							</form>
							
					<!--Edit the users comment, go to editComment.php -->
					<?php
					
							}else{
						$commentID = $_POST['commentID'];
						$_SESSION['currentCommentID'] = $commentID;
																	
						$con = new PDO( DB_DSN, DB_USERNAME, DB_PASSWORD );
						$sthandler = $con->prepare("SELECT _comment FROM comments WHERE commentID = :commentID");
						$sthandler->execute(array(':commentID'=>$commentID));
						$row = $sthandler->fetch();
																		
						$_SESSION['editComment'] = $row['_comment'];
																		
					
							header( 'Location: editComment.php');
						
						}
																
					
					?>
					<!-- Delete comment form -->
							<form method="post" action="">
								<div class='edit-data'>
									<input type="hidden" name="deleteCommentID" value="<?php echo $commentID; ?>">  
									<input type="image" src="images/delete.png" name="deleteMe" value="Delete">
								</div>
							</form>
					<!-- Delete a comment -->
					<?php
						}else{
						$theID2 = $_POST['deleteCommentID'];
												
						$con = new PDO( DB_DSN, DB_USERNAME, DB_PASSWORD );
						$sthandler = $con->prepare("DELETE FROM comments WHERE commentID = :deleteID");
						$sthandler->execute(array(':deleteID'=>$theID2));
						
						header( 'Location: admin-index.php' );
					}
					?>

		<?php			
				}?>
											<!-- Add a comment form -->
						<br>
						<br>
								<form method="post" action="">
									<textarea input type="text" id="theComment" required name="theComment"> </textarea>
									<input type="hidden" name="postID" value="<?php echo $postID; ?>">  
									<br>
									<input type="submit" name="insertComment" class="button-comment-round" value="Add Comment" />
								</form>
			</article>
			<div class="end-article"></div>
		<?php
		}
		?>

			</div>	
		</div>
	</div>
		<script src="js/readmore.js"></script>
		  <script>
			$('article').readmore({speed: 500});
		   </script>
		   
		   
    </body>
</html>
<!-- Edit a comment php -->
<?php

	}else{
											
		$newComment = $_POST['theComment'];
		$postID = $_POST['postID'];
												 
		//$postID is the postID to add the comment to
		$usr = new Users;
		$usr->storeFormValues($_POST);
								
		if($usr->addComment($_POST)){
			//successfully added comment
			header( 'Location: admin-index.php' );
			
		} else {
			//failed to add comment
			
		}
		unset($_POST['insertComment']);
	}

?>