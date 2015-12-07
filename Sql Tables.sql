
/*http://tagging.pui.ch/post/37027746608/tagsystems-performance-tests*/

CREATE TABLE IF NOT EXISTS `users` (
  `userID` 		int(6) 				NOT NULL AUTO_INCREMENT COMMENT 'User ID',
  `username` 	varchar(32) 		NOT NULL 		COMMENT 'Username',
  `password` 	varbinary(250) 	NOT NULL 		COMMENT 'Password',
  `email` 		varchar(50) 		NOT NULL 		COMMENT 'Email Address',
  `firstname` 	varchar(20) 		NOT NULL 		COMMENT 'Firstname',
  `surname` 	varchar(20) 		NOT NULL 		COMMENT 'Surname',
  `privilege` 	tinyint(3) 			DEFAULT 0 	COMMENT '0 For reader, 1 for Author, 2 for Admin',
  `verified` 	bit 					DEFAULT 0 	COMMENT '0 For non verified, 1 for verified account, 2 for pending admin privilege',
  PRIMARY KEY (`userID`,`username`)
);

CREATE TABLE IF NOT EXISTS `posts` (
  `postID` 		int(6) 				NOT NULL AUTO_INCREMENT COMMENT 'Blog Post ID',
  `userID` 		int(6) 				NOT NULL 		COMMENT 'User ID',
  `title` 			varchar(50) 		NOT NULL 		COMMENT 'Blog Post Title',
  `blogPost` 	text 					NOT NULL 		COMMENT 'Blog Post',
  `blogTime` 	timestamp default CURRENT_TIMESTAMP COMMENT 'Time of post creation',
  `tags`			varchar(100)		NULL				COMMENT 'Tags seperated by comma for post',
  `rating`		int(11)				DEFAULT 0		COMMENT 'Rating',
  PRIMARY KEY (`postID`),
  FOREIGN KEY (`userID`) REFERENCES users(`userID`)
);

/*
idea for image table: make imageID and postID composite key to link multiple images to one post
 */

CREATE TABLE IF NOT EXISTS `images` (
  `imageID` 		int(6)  				NOT NULL AUTO_INCREMENT		COMMENT 'ID of the image',
  `image` 			longblob					NOT NULL 		COMMENT 'The image being stored',
  `postID` 			int(6) 				NOT NULL 		COMMENT 'Blog Post ID if post image is in',
  PRIMARY KEY (`imageID`),
  FOREIGN KEY(`postID`) REFERENCES posts(`postID`)
);

CREATE TABLE IF NOT EXISTS `comments` (
  `postID` 						int(6) 					NOT NULL 		COMMENT 'Post ID where the comment is on',
  `commentID` 				int(6) 					NOT NULL AUTO_INCREMENT COMMENT 'Unique Comment ID',
  `userID` 						int(6) 					NOT NULL 	 COMMENT 'User ID (to get username)',
  `commenterUsername` 	varchar(32) 			NOT NULL 		COMMENT 'Username of Commenter',
  `_comment` 				text						NOT NULL 		COMMENT 'User Comment',
  PRIMARY KEY (`commentID`),
  FOREIGN KEY (`postID`) REFERENCES posts(`postID`)
);