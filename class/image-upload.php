<input type="file" name="imageUpload" id="imageUpload">

<?php
if (isset($_POST['submit'])) {

    //Processes the images uploaded by user

    $target_dir = "uploads/";
    $target_file = $target_dir . basename($_FILES["imageUpload"]["name"]);
    $uploadOk = 1;
    $imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);

    if (move_uploaded_file($_FILES["imageUpload"]["tmp_name"], $target_file)) {
        echo "The file ". basename( $_FILES["imageUpload"]["name"]). " has been uploaded.";
    } else {
        echo "Sorry, there was an error uploading your file.";
    }

    $image=basename( $_FILES["imageUpload"]["name"],".jpg"); //stores filename in a vairable

    //stores the image data in the database

    $query = "INSERT INTO items VALUES ('$imageID', '$image', '$postID')";
    mysql_query($query);

    require('author_index.php');
    echo "Image has been uploaded, you will be return to your account page in 3 seconds....";
    header ( "Refresh:3; url=author-index.php", true, 303);
}

?>
