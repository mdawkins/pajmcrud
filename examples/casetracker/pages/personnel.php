<?php
//phpinfo(32);
// define variables and set to empty values

// Specific table for page
$table = "personnel";

// Enum list for Function column
$lists["workfunction"] = array(
			[ "key" => "attorney", "title" => "Attorney"],
			[ "key" => "paralegal", "title" => "Paralegal", "checked" => "no"],
			[ "key" => "legalassist", "title" => "Legal Assistant"],
			[ "key" => "secretary", "title" => "Secretary"],
		);

// Columns list
$colslist = array(
	array( "column" => "name", "title" => "Name", "required" => "yes", "input_type" => "text", "extra_check" => "no" ),
	array( "column" => "email", "title" => "E-mail", "required" => "yes", "input_type" => "text", "extra_check" => "yes" ),
	array( "column" => "phone", "title" => "Tel Number", "required" => "no", "input_type" => "text", "extra_check" => "yes" ),
	array( "column" => "workfunction", "title" => "Work Function", "required" => "yes", "input_type" => "select", "extra_check" => "no", "filterbox" => "checkbox" ),
);

$showidcolumn="no";

?>
