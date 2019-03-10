<?php
#pajmcrud directory settings
$pajmroot = "/var/www/html/pajmcrud/";
$funcroot = $pajmroot."functions/";


// Connect to mysql DB	
// need to be include from a siteinfo config file
// Create connection
$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

function test_input($data) {
	$data = trim($data);
	$data = stripslashes($data);
	$data = htmlspecialchars($data);
	return $data;
}

?>
