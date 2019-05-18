<?php
// define variables list 
$showrownum = $tdstyle = $rowstyle = $html = $groupby = $addtables = $addwheres = $fields = $return = $showidcolumn = $concatfield = $multiple = $wheres = $selectnested = $selected = $txthtml = $cbhtml = $datastring = $coloderby = $multiple = $selected = $wherestring = "";

$concatfield = $multiple = $selected = $filterbox = $text = $checkbox = $action = [];


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
