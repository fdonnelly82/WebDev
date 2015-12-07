<?php
session_start();
?>

<div align="center">
<h1>TEST PAGE<h1></div>
<b>UserID is: </b><?php echo $_SESSION['userID'];?>
<br>
<b>Username is: </b> <?php echo $_SESSION['username'];?>
<br>
<b>Password is: </b><?php echo $_SESSION['password'];?>
<br>
<b>Firstname is: </b><?php echo $_SESSION['firstname'];?>
<br>
<b>Surname is: </b><?php echo $_SESSION['surname'];?>
<br>
<b>Email is: </b><?php echo $_SESSION['email'];?>
<br>
<b>Privilege: </b><?php echo $_SESSION['privilege'];?>
<br>
<b>Deactivated: </b><?php echo $_SESSION['deactivated'];?>
<br>
<b>Banned: </b><?php echo $_SESSION['banned'];?>
<br>
<b>Title To Edit: </b><?php echo  $_SESSION['titleToEdit'];?>
<br>
<b>Post Title (to edit): </b><?php echo $_SESSION['postTitle'] ;?>
<br>
<b>Post (to edit): </b><?php echo $_SESSION['postBlog'] ;?>
<br>
<b>Verified: </b><?php echo $_SESSION['verified'] ;?>
<br>
<b>Logged in: </b><?php echo $_SESSION['loggedIn'] ;?>		       
				
				
<br>

<ul>
	<li><a href='logout.php'>logout.php </a></li>
	<li><a href='index.php'>index.php </a></li>
	<li><a href='login.php'>login.php </a></li>
	<li><a href='user-index.php'>user-index.php </a></li>
	<li><a href='register.php'>register.php </a></li>
	<li><a href='test.php'>test.php </a></li>
	<li><a href='update-password.php'>update-password.php </a></li>
	<li><a href='user-account.php'>user-account.php </a></li>
	<li><a href='deactivate.php'>deactivate.php </a></li>
	<li><a href='admin-account.php'>admin-account.php </a></li>
	<li><a href='admin-index.php'>admin-index.php </a></li>
</ul>