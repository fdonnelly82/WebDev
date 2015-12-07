<?php include_once("config/config.php");?>

<?php if( !(isset( $_POST['register'] ) ) ) { ?>

<!DOCTYPE html>
<html>
<head>
	<title>Adventure Blog | Register Page</title>
	<link href="stylesheets/stylesheet-index.css" rel="stylesheet" type="text/css">
	<link href="stylesheets/stylesheet-register.css" rel="stylesheet" type="text/css">
	<link rel="shortcut icon" href="images/icon.ico" > 
	<meta name="viewport" content="height=device-height, width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no, target-densitydpi=device-dpi" />
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<script src='https://www.google.com/recaptcha/api.js'></script>
</head>
    <body>
	<div class="header">
		<img src="images/xplor.png"  class="xplor" alt=""/>
	</div>
	
		<div class="header-image"></div>
	
		<div class="container">
			<div class="content">
				<form method="post" action="">
				
							<label>First Name</label>
							<input type="text" id="firstname" maxlength="30" required name="firstname" class="text-straight" />
							
							<label>Surname</label>
							<input type="text" id="surname" maxlength="30" required name="surname" class="text-straight" />

							<label>Username</label>
							<input type="text" id="username" maxlength="30" required autofocus name="username" class="text-straight"/>

							<label>Password</label>
							<input type="password" id="password" maxlength="30" required name="password" class="text-straight" />

							<label>Confirm Password</label>
							<input type="password" id="conpassword" maxlength="30" required name="conpassword" class="text-straight"/>

							Tick if you wish to be an Author. Otherwise reader account.
							<br>
							<input type="hidden" name="privilege" value="0" />
							<input type="checkbox" name="privilege" value="1"> 
							
							<label>Email</label>
							<input type="email" id="email" maxlength="30" required name="email" class="text-straight" />
							<div class="button-padding">
								<div class="g-recaptcha" data-sitekey="6LeXng8TAAAAAM5QDu7wATG1HO4u4u7ea_euLtrg"></div>
							</div>
							
						

							
							<input type="submit" name="register" value="Register" class="button-round"/>

							<input type="button" name="cancel" value="Cancel" onclick="location.href='login.php'" class="button-round"/>
				</form>	
			</div>
		</div>
    </body>
</html>

<?php	

} else {
	//Captcha Code
	$recaptcha_secret = "6LeXng8TAAAAAOQDFolpkW2yPDKYoPRXwciYNpom";

    $response = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=".$recaptcha_secret."&response=".$_POST['g-recaptcha-response']);

    $response = json_decode($response, true);

    if($response["success"] === false){

    echo 'You failed the captcha, <br> Please Try Again </br> <a href=register.php> Click Here </a>'; // navigate to page where you're a robot

    } else { //Captcha Valid

	//Check the confirmation pass is the same as password
	$usr = new Users;
	$usr->storeFormValues( $_POST );
	if( $_POST['password'] == $_POST['conpassword'] ) {
	  //passwords do match//
	} else {
		echo 'Passwords do not match. <br> Please Try Again </br> <a href=login.php> Click Here </a>';
	exit;
	}
	
	//Check if the username is already taken
	$username = ( $_POST['username']);
	$con = new PDO( DB_DSN, DB_USERNAME, DB_PASSWORD );
	$sthandler = $con->prepare("SELECT username FROM users WHERE username = :username");
	$sthandler->execute(array(':username'=>$username));
	if ( $sthandler->rowCount() > 0 ) {
		echo ('Sorry, the username '.$_POST['username'].' is already in use.');
	}else{
		echo $usr->register();	
	}
	}

}

?>

			
			
		
			
		


                        	

                        	

                        	

                        	