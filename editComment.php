<?php include_once("config/config.php");
?>

<?php

		if (!$_SESSION["loggedIn"]) header( 'Location: login.php' ); //if not logged in go here
?>

	
<!DOCTYPE html>
<html>
<head>

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

		<div class="container">

			<div class="postContainer">
			
				<div align ="center"><b>Edit Comment</b></div>
					<div class="border5">
				
						<form method="post" action="">
							<div class="text-padder3">
									<label>Edit Comment</label><br>
									<textarea rows="4" cols="50" input type="text" id="newComment" required name="newComment" > <?php echo $_SESSION['editComment'];?></textarea>
							</div>
								<div class="button-padder3">
									<input type="submit" name="edit" value="Edit" />
								</div>
							
								
						</form>	
				</div>
				
			</div>
			
    </body>
</html>

<?php 

	if( !(isset( $_POST['edit'] ) ) ) {
		} else {//if  edit post button was clicked
		$usr = new Users;
		$usr->storeFormValues($_POST);

			if( $usr->editComment() ) {
				header('Location: index.php');
			} else {
				header('Location: blogUpdateFailed.php');                                                                       
			}
	}

?>


