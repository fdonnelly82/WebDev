<?php include_once("config/config.php");
?>
<?php
	error_reporting(E_ERROR);
?>

<?php
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
?>

	
<!DOCTYPE html>
<html>
<head>
	<title>Adventure Blog | Admin</title>
	<link href="stylesheets/stylesheet-index.css" rel="stylesheet" type="text/css">
	
	<link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css"> <!--for ajax-->
	<link rel="shortcut icon" href="images/icon.ico" > 
	
	<meta name="viewport" content="height=device-height, width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no, target-densitydpi=device-dpi" />
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	
	<script src="//code.jquery.com/jquery-1.10.2.js"></script>
    <script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
	<script src="js/scroll.js" type="text/javascript"></script>
	

	<script type="text/javascript">
		$(document).ready(function()
		{
			$('#titleToEdit').autocomplete(
			{
				source: "searchTitle.php",
				minLength: 1
			});
						$('#activateUsername').autocomplete(
			{
				source: "searchUsername.php",
				minLength: 1
			});
			
						$('#promoteUsername').autocomplete(
			{
				source: "searchUsername.php",
				minLength: 1
			});
			
		});
	</script>
	
</head>
    <body>
	<!-- Header with logo and login -->
		<div class="header">
			
				<a href="admin-index.php"><img src="images/xplor.png"  class="xplor" alt=""/></a>
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
		
		<div class="container">
			<div class="content">
				<br>
				<br>
				<br>
					<form method="post" action="">
						<h5>Enter Username to Promote to Admin</h5>
						<div class="ui-widget">
							<input type="text" class="text-straight" id="promoteUsername" maxlength="30" required name="promoteUsername"/>
						</div>
						<br>
						<input type="submit"  class="button-register-round" name="promote" value="Promote" />
					</form>
						
					<form method="post" action="">
						<h5>Verify User Accounts</h5>
						
						<div class="ui-widget">
							<input type="text" id="activateUsername" class="text-straight" maxlength="30" required name="activateUsername"/>
						</div>
						
						<br>
						<input type="submit"  class="button-register-round-wide" name="activate" value="Activate/Deactivate" />
					</form>			
		
					<form method="post" action="">
						<h5>Create new post</h5>
					Title
						<input type="text"  class="text-straight" id="title" maxlength="30" required name="title"/>
						<br>
					Post
						<br>
						<textarea input class="text-straight-post" type="text" id="blogPost" required name="blogPost"> </textarea>
						<br><br>
					Tags (seperate by comma)
						<br>
						<input type="text"  class="text-straight" id="tags" maxlength="30" required name="tags"/>
						<br>
						Upload images here!
						<input type="submit" name="submitPost" class="button-register-round" value="Post Blog" />
						<br>
					</form>	

					<form method="post" action="">
						<h5>Edit Post</h5>
						Enter post title to edit
							<br>
							<div class="ui-widget">
								<input type="text" id="titleToEdit"  class="text-straight" maxlength="30" required name="titleToEdit"/>
							</div>
							<br>
							<input type="submit" name="edit"  class="button-register-round value="Edit Post" />
					</form>
					
			</div>
		</div>
		
    </body>
</html>

<?php 

	if( !(isset( $_POST['edit'] ) ) ) {
		} else {//if  edit post button was clicked
		
		$titleToEdit=$_POST['titleToEdit'];
		$_SESSION['titleToEdit'] = $_POST['titleToEdit'];
		
		$con = new PDO( DB_DSN, DB_USERNAME, DB_PASSWORD );
			$sthandler = $con->prepare("SELECT title, blogPost FROM posts WHERE title = :titleToEdit");
			$sthandler->execute(array(':titleToEdit'=>$titleToEdit));
			$row = $sthandler->fetch();
			
				$_SESSION['postTitle'] = $row['title'];
				$_SESSION['postBlog'] = $row['blogPost'];
			
			if( $row ) {
				header( 'Location: admin-EditPost.php');
			} else {
				echo 'Post title Does NOT Exist';//header( 'Location: admin-EditPost.php');
			}
				
		}
	
	if( !(isset( $_POST['delete'] ) ) ) {
		} else {//if  delete button was clicked
		
		$deleteTitle = $_POST['deleteTitle'];
		
		$con = new PDO( DB_DSN, DB_USERNAME, DB_PASSWORD );
			$sthandler = $con->prepare("DELETE FROM posts WHERE title = :deleteTitle");
			$sthandler->execute(array(':deleteTitle'=>$deleteTitle));
			$valid = $sthandler->fetch();
			
			if($valid) {
				header( 'Location: blogRemoved.php');
			} else {
				echo 'Post Removed';//header( 'Location: admin-EditPost.php');
			}
			
		
				
		}
		
	if( !(isset( $_POST['submitPost'] ) ) ) {
	} else {//if  post blog user button was clicked
		$usr = new Users;
		$usr->storeFormValues($_POST);

			echo $usr->createPost($_POST);
			
		}

	if( !(isset( $_POST['promote'] ) ) ) {
	} else {//if  promote user button was clicked
		$usr = new Users;
		$usr->storeFormValues($_POST);
		
	//Check if the promoteUsername exists
		$promoteUsername = ( $_POST['promoteUsername']);
		$con = new PDO( DB_DSN, DB_USERNAME, DB_PASSWORD );
		$sthandler = $con->prepare("SELECT username FROM users WHERE username = :promoteUsername");
		$sthandler->execute(array(':promoteUsername'=>$promoteUsername));
		if ( $sthandler->rowCount() > 0 ) {
			echo $usr->promote($_POST);
		}else{
			echo 'user doesnt exist';//user doesnt exist
		}
	}

	if( !(isset( $_POST['activate'] ) ) ) {
	} else {//if  ban user name button was clicked
		$usr = new Users;
		$usr->storeFormValues($_POST);
		
	//Check if the promoteUsername exists
		$activateUsername = ( $_POST['activateUsername']);
		$con = new PDO( DB_DSN, DB_USERNAME, DB_PASSWORD );
		$sthandler = $con->prepare("SELECT username FROM users WHERE username = :activateUsername");
		$sthandler->execute(array(':activateUsername'=>$activateUsername));
		if ( $sthandler->rowCount() > 0 ) {
			echo $usr->ban($_POST);
		}else{
			 echo 'user doesnt exist';
		}
	}

?>


