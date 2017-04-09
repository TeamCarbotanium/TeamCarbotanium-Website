 <?php
	$username ="failtas1_browser";
	$password = "@Popcheese10";
	$host = "failtastic.org";
	$table = "failtas1_users";
	$conn = new mysqli("$host", "$username", "$password", "$table");
	 
	 if ( !$conn ) {
	  die("Connection failed : " . mysql_error());
	 }
 ?>