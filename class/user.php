<?php
error_reporting(E_ERROR);
session_start();

 class Users {
 
	 public $username = null;
	 public $password = null;
	 public $email = null;
	 public $firstname = null;
	 public $surname = null;
	 public $privilege= null;
	 
	 public $promoteUsername = null;
	 public $activateUsername = null;
	 
	 public $title = null;
	 public $blogPost = null;
	 public $tags = null;
	 
	 public $titleToEdit = null;
	 
	 public $theComment = null;
	 public $postID = null;
	 
	 public $newComment = null;
	 
	 
	 public $salt = "Zo4rU5Z1YyKJAASY0PT6EUg7BBYdlEhPaNLuxAwU8lqu1ElzHv0Ri7EM6irpx5w";
	 
	 public function __construct( $data = array() ) {
		 if( isset( $data['username'] ) ) $this->username = stripslashes( strip_tags( $data['username'] ) );
		 if( isset( $data['password'] ) ) $this->password = stripslashes( strip_tags( $data['password'] ) );
		 if( isset( $data['email'] ) ) $this->email = stripslashes( strip_tags( $data['email'] ) );
		 if( isset( $data['firstname'] ) ) $this->firstname = stripslashes( strip_tags( $data['firstname'] ) );
		 if( isset( $data['surname'] ) ) $this->surname = stripslashes( strip_tags( $data['surname'] ) );
		 if( isset( $data['privilege'] ) ) $this->privilege  = stripslashes( strip_tags( $data['privilege'] ) );
		 if( isset( $data['promoteUsername'] ) ) $this->promoteUsername = stripslashes( strip_tags( $data['promoteUsername'] ) );
		 if( isset( $data['activateUsername'] ) ) $this->activateUsername = stripslashes( strip_tags( $data['activateUsername'] ) );
		 
		 if( isset( $data['title'] ) ) $this->title = stripslashes( strip_tags( $data['title'] ) );
		 if( isset( $data['blogPost'] ) ) $this->blogPost = stripslashes( strip_tags( $data['blogPost'] ) );
		 if( isset( $data['tags'] ) ) $this->tags = stripslashes( strip_tags( $data['tags'] ) );
		 
		 if( isset( $data['titleToEdit'] ) ) $this->titleToEdit = stripslashes( strip_tags( $data['titleToEdit'] ) );
		 
		 if( isset( $data['theComment'] ) ) $this->theComment = stripslashes( strip_tags( $data['theComment'] ) );
		 if( isset( $data['postID'] ) ) $this->postID = stripslashes( strip_tags( $data['postID'] ) );
		 
		 if( isset( $data['newComment'] ) ) $this->newComment = stripslashes( strip_tags( $data['newComment'] ) );
	 }
	 
	 public function storeFormValues( $params ) {
		//store the parameters!
		$this->__construct( $params ); 
	 }
	 
	 public function userLogin() {
		 $success = false;
		 try{
			$con = new PDO( DB_DSN, DB_USERNAME, DB_PASSWORD ); 
			$con->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
			$sql = "SELECT * FROM users WHERE username = :username AND password = :password LIMIT 1";
			
			$stmt = $con->prepare( $sql );
			$stmt->bindValue( "username", $this->username, PDO::PARAM_STR );
			$stmt->bindValue( "password", hash("sha256", $this->password . $this->salt), PDO::PARAM_STR );
			$stmt->execute();
			
			$valid = $stmt->fetchColumn();
			
			if( $valid ) {
				$success = true;
			}
			
			$con = null;
			return $success;
			
		 }catch (PDOException $e) {
			 echo $e->getMessage();
			 return $success;
		 }
	 }
	 
	 public function register() {
		$correct = false;
			try {
				$con = new PDO( DB_DSN, DB_USERNAME, DB_PASSWORD );
				$con->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
				$sql = "INSERT INTO users(username, password, email, firstname, surname, privilege) VALUES(:username, :password, :email, :firstname, :surname, :privilege)";
				
				$stmt = $con->prepare( $sql );
				$stmt->bindValue( "username", $this->username, PDO::PARAM_STR );
				$stmt->bindValue( "password", hash("sha256", $this->password . $this->salt), PDO::PARAM_STR );
				$stmt->bindValue( "email", $this->email, PDO::PARAM_STR );
				$stmt->bindValue( "firstname", $this->firstname, PDO::PARAM_STR );
				$stmt->bindValue( "surname", $this->surname, PDO::PARAM_STR );
				$stmt->bindValue( "privilege", $this->privilege, PDO::PARAM_STR );
				$stmt->execute();
				
				return header( 'Location: index.php' );
			}catch( PDOException $e ) {
				return $e->getMessage();
			}
	 }
	 
	 public function update() {
		$correct = false;
		$userID = $_SESSION['userID'];
			try {
				$con = new PDO( DB_DSN, DB_USERNAME, DB_PASSWORD );
				$con->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
				$sql = "UPDATE users SET username=:username, email=:email, firstname=:firstname, surname=:surname WHERE userID = '$userID'";
	
				$stmt = $con->prepare( $sql );
				$stmt->bindValue( "username", $this->username, PDO::PARAM_STR );
				$stmt->bindValue( "email", $this->email, PDO::PARAM_STR );
				$stmt->bindValue( "firstname", $this->firstname, PDO::PARAM_STR );
				$stmt->bindValue( "surname", $this->surname, PDO::PARAM_STR );
				$stmt->execute();
				
				return "Update Successful <br/> <a href='logout.php'>Click here to return</a>";
			}catch( PDOException $e ) {
				return $e->getMessage();
			}
	 }
	 
	  public function changePass() {
		$correct = false;
		$userID = $_SESSION['userID'];
			try {
				$con = new PDO( DB_DSN, DB_USERNAME, DB_PASSWORD );
				$con->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
				$sql = "UPDATE users SET password=:password WHERE userID= '$userID'";
	
				$stmt = $con->prepare( $sql );
				$stmt->bindValue( "password", hash("sha256", $this->password . $this->salt), PDO::PARAM_STR );
				$stmt->execute();
				
				return "Update Successful <br/> <a href='logout.php'>Click here to return</a>";
			}catch( PDOException $e ) {
				return $e->getMessage();
			}
	 }
	 
	  public function deactivate() {
		$correct = false;
		$userID = $_SESSION['userID'];
			try {
				$con = new PDO( DB_DSN, DB_USERNAME, DB_PASSWORD );
				$con->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
				$sql = "UPDATE users SET deactivated = 1 WHERE userID= '$userID'";
	
				$stmt = $con->prepare( $sql );
				$stmt->execute();
				
				return "Account Deactivated<br/> <a href='logout.php'>Click here</a> to return to home screen";
			}catch( PDOException $e ) {
				return $e->getMessage();
			}
	 }
	 
	 public function promote() {
		$correct = false;
			try {
				$con = new PDO( DB_DSN, DB_USERNAME, DB_PASSWORD );
				$con->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
				$sql = "UPDATE users SET privilege = 2 WHERE username= :promoteUsername";
	
				$stmt = $con->prepare( $sql );
				$stmt->bindValue( "promoteUsername", $this->promoteUsername, PDO::PARAM_STR );
				$stmt->execute();
				
				return "User Promoted";
			}catch( PDOException $e ) {
				return $e->getMessage();
			}
	 }
	 
	  public function ban() {
		$correct = false;
			try {
				$con = new PDO( DB_DSN, DB_USERNAME, DB_PASSWORD );
				$con->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
				$sql = "UPDATE users SET verified = NOT verified WHERE username= :activateUsername";
	
				$stmt = $con->prepare( $sql );
				$stmt->bindValue( "activateUsername", $this->activateUsername, PDO::PARAM_STR );
				$stmt->execute();
				
				return "User Banned/Unbanned";
			}catch( PDOException $e ) {
				return $e->getMessage();
			}
	 }
	 
	 public function createPost() {
		$correct = false;
		$posterUserID = $_SESSION['userID'];
			try {
				$con = new PDO( DB_DSN, DB_USERNAME, DB_PASSWORD );
				$con->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
				$sql = "INSERT INTO posts(userID, title, blogPost, tags) VALUES('$posterUserID', :title, :blogPost, :tags)";
				
				$stmt = $con->prepare( $sql );
				$stmt->bindValue( "title", $this->title, PDO::PARAM_STR );
				$stmt->bindValue( "blogPost", $this->blogPost, PDO::PARAM_STR );
				$stmt->bindValue( "tags", $this->tags, PDO::PARAM_STR );
				$stmt->execute();
				
				echo "Post Created <br/> <a href='admin-index.php'>View Post</a>";
			}catch( PDOException $e ) {
				return $e->getMessage();
			}
	 }
 
	 public function editPost() {
		$success = false;
		$titleToEdit = $_SESSION['titleToEdit'];
			try {
				$con = new PDO( DB_DSN, DB_USERNAME, DB_PASSWORD );
				$con->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
				$sql = "UPDATE posts SET title=:title, blogPost=:blogPost WHERE title = '$titleToEdit'";
	
				$stmt = $con->prepare( $sql );
				$stmt->bindValue( "title", $this->title, PDO::PARAM_STR );
				$stmt->bindValue( "blogPost", $this->blogPost, PDO::PARAM_STR );
				
				$valid = $stmt->execute();
				
				if( $valid ) {
					$success = true;
				}
				
				//echo "Blog updated Successfully<br/> <a href='admin-account.php'>Click here to return</a>";
				return $success;
			}catch( PDOException $e ) {
				return $e->getMessage();
			}
	 }
 
     public function addComment() {
		$correct = false;
		
		$commenterUsername = $_SESSION['username'];
		$commenterID = $_SESSION['userID'];
		
			try {
				$con = new PDO( DB_DSN, DB_USERNAME, DB_PASSWORD );
				$con->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
				$sql = "INSERT INTO comments (postID, commenterUsername, userID, _comment) VALUES ( :postID, '$commenterUsername','$commenterID', :theComment) ";
				
				$stmt = $con->prepare( $sql );
				$stmt->bindValue( "theComment", $this->theComment, PDO::PARAM_STR );
				$stmt->bindValue( "postID", $this->postID, PDO::PARAM_STR );
				
				$valid = $stmt->execute();
				
				if ($valid){
					echo'success';
					header( 'Location: admin-index.php' );
					$correct = true;
				}else{
					echo'failure';
					
					$correct = false;
				}
			
			return $correct;
			}catch( PDOException $e ) {
				return $e->getMessage();
			}
	 }
 
	 public function editComment() {
		$success = false;
		
		$commentToEdit = $_SESSION['currentCommentID'];
		
			try {
				$con = new PDO( DB_DSN, DB_USERNAME, DB_PASSWORD );
				$con->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
				$sql = "UPDATE comments SET _comment=:newComment WHERE commentID = '$commentToEdit' ";
	
				$stmt = $con->prepare( $sql );
				$stmt->bindValue( "newComment", $this->newComment, PDO::PARAM_STR );
				
				$valid = $stmt->execute();
				
				if( $valid ) {
					$success = true;
				}
				
				//echo "Blog updated Successfully<br/> <a href='admin-account.php'>Click here to return</a>";
				return $success;
			}catch( PDOException $e ) {
				return $e->getMessage();
			}
	 }

 }
 
?>