<?php
include_once("config.php");
?>
<script>
function showUser(str) {
    if (str == "") {
        document.getElementById("info").innerHTML = "";
        return;
    } else { 
        if (window.XMLHttpRequest) {
            // code for IE7+, Firefox, Chrome, Opera, Safari
            xmlhttp = new XMLHttpRequest();
        } else {
            // code for IE6, IE5
            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        }
        xmlhttp.onreadystatechange = function() {
            if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                document.getElementById("info").innerHTML = xmlhttp.responseText;
            }
        }
        xmlhttp.open("GET","getSubsection.php?q="+str,true);
        xmlhttp.send();
    }
}
</script>
</head>
<body>

<form>
	<select name="subsectionID" onchange="showUser(this.value)">
	  <option value=""> Select the subsection ID </option>
		<?php
		$con = new PDO(DB_DSN, DB_USERNAME, DB_PASSWORD );
		$sthandler = $con->prepare("SELECT * FROM subsections");
		$sthandler->execute();

		while ($row = $sthandler->fetch(PDO::FETCH_ASSOC)){
			echo $row['subsectionID'];
			echo "<option value='".$row['subsectionID']."'>".$row['subsectionID']."</option>";

		} 
		?>
		
	</select>
</form>

<br>
<div id="info"><b>Info will be listed here...</b></div>

</body>
</html>