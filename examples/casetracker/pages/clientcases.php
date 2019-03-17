<?php
//phpinfo(32);
// define variables and set to empty values

// Specific table for page
$table = "clientcases";

$showidcolumn = "no";
$showrownum = "yes";
$colorderby = "hearing::asc";

// Enum list for Function column
$selslist = array(
	array( "selcol" => "attorneyid", "selname" => "name", "selid" => "id", "seltable" => "personnel", "wherekey" => "workfunction", "whereval" => "'attorney'" )
);

$lists["casetype"] = array(
			[ "key" => "eoir42b", "title" => "EOIR-42B", "checked" => "no"],
			[ "key" => "i360", "title" => "I-360"],
			[ "key" => "i589", "title" => "I-589"],
			[ "key" => "aos", "title" => "AOS"],
			[ "key" => "uac", "title" => "UAC"],
			[ "key" => "sijs", "title" => "SIJS"],
			[ "key" => "withholding", "title" => "Withholding"],
		);

$lists["hearingtype"] = array(
			[ "key" => "master", "title" => "Master (Blue)"],
			[ "key" => "individual", "title" => "Individual (Red)"],
		);

$lists["locationtype"] = array(
			[ "key" => "aurora", "title" => "Aurora"],
			[ "key" => "denver", "title" => "Denver"],
		);

$lists["decisiontype"] = array(
			[ "key" => "denied", "title" => "Denied"],
			[ "key" => "granted", "title" => "Granted"],
			[ "key" => "pending", "title" => "Pending"],
			[ "key" => "closed", "title" => "Closed"],
		);

$lists["appealtype"] = array(
			[ "key" => "yes", "title" => "Yes"],
			[ "key" => "no", "title" => "No"],
		);

// Columns list
$colslist = array(
	array( "column" => "anumber", "title" => "A-Number", "required" => "yes", "input_type" => "text", "extra_check" => "no", "filterbox" => "text" ),
	array( "column" => "clientname", "title" => "Client Name", "required" => "yes", "input_type" => "text", "extra_check" => "no", "filterbox" => "text" ),
	array( "column" => "casetype", "title" => "Case Type", "required" => "yes", "input_type" => "select", "multiple" => "yes", "extra_check" => "no", "filterbox" => "checkbox" ),
	array( "column" => "oneyrdl", "title" => "1 Yr Deadline", "required" => "no", "input_type" => "date", "extra_check" => "no" ),
	array( "column" => "workperm", "title" => "Work Permit", "required" => "no", "input_type" => "date", "extra_check" => "no" ),
	array( "column" => "filed", "title" => "Filed Date", "required" => "no", "input_type" => "date", "extra_check" => "no" ),
	array( "column" => "approved", "title" => "Approved Date", "required" => "no", "input_type" => "date", "extra_check" => "no" ),
	array( "column" => "expiration", "title" => "Expiration Date", "required" => "no", "input_type" => "date", "extra_check" => "no" ),
	array( "column" => "supportdocs", "title" => "Supporting Docs Date", "required" => "no", "input_type" => "date", "extra_check" => "no" ),
	array( "column" => "hearingtype", "title" => "Hearing Type", "required" => "no", "input_type" => "select", "extra_check" => "no", "filterbox" => "checkbox" ),
	array( "column" => "hearing", "title" => "Hearing Date", "required" => "no", "input_type" => "datetime", "extra_check" => "no" ),
	array( "column" => "locationtype", "title" => "Location", "required" => "no", "input_type" => "select", "extra_check" => "no", "filterbox" => "checkbox" ),
	array( "column" => "judgename", "title" => "Judge Name", "required" => "no", "input_type" => "text", "extra_check" => "no", "filterbox" => "text" ),
	array( "column" => "attorneyid", "title" => "Attorney Name", "required" => "no", "input_type" => "tableselect", "extra_check" => "no", "filterbox" => "checkbox" ),
	array( "column" => "decisiontype", "title" => "Decision", "required" => "no", "input_type" => "select", "extra_check" => "no", "filterbox" => "checkbox"  ),
	array( "column" => "decision", "title" => "Decision Date", "required" => "no", "input_type" => "date", "extra_check" => "no" ),
	array( "column" => "appealtype", "title" => "Appeal", "required" => "no", "input_type" => "select", "extra_check" => "no", "filterbox" => "checkbox"  ),
	);

$rowformat = array(
	array( "value" => "master", "column" => "hearingtype", "background-color" => "#b8c8ed", "text-color" => "", "font-weight" => "normal" ),
	array( "value" => "individual", "column" => "hearingtype", "background-color" => "#fc6d50", "text-color" => "", "font-weight" => "normal" ),
	);

?>
