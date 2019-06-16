<?php

// Error message set to empty
$msgErr = [];

if ( isset($_POST["editId"]) ) { 
	$_GET["id"] = $_POST["editId"]; 
//	echo "<div>\n";
//	$closediv = "</div>\n";
}
// Set each variable to empty
foreach ($colslist as $col) {
	${$col["column"]} = "";
}

if ( $_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["submit"]) ) {

	// for updating a row
	$sqlupdate_row = "update $table set ";
	// for inserting a row
	$sqlinsert_row = "insert into $table (";
	
	// check for empty inputs from _POST	
	foreach ( $colslist as $col ) {
		if ( $col["input_type"] != "noform" ) {
	
		// Error Checking for fields
		if ( empty($_POST[$col["column"]]) && $col["required"] == "yes" && $col["input_type"] != "dropedit" ) {
			$msgErr[$col["column"]] = $col["title"]." is required";
		} elseif ( $col["extra_check"] == "yes" && $col["column"] == "email" && (!filter_var($_POST[$col["column"]], FILTER_VALIDATE_EMAIL)) ) {
			// check if e-mail address is well-formed
			$msgErr[$col["column"]] = "Invalid email format";
		}

		// add modifications to the input value here ONLY!!!
		if ( $col["input_type"] == "dropedit" ) {
			break;
		// recombined _POST coltext 
		} elseif ( $col["input_type"] == "3text" ) {
			$coltext = explode(";", $col["column"]);
			$_POST[$col["column"]] = $_POST[$coltext[0]]."; ".$_POST[$coltext[1]]."; ".$_POST[$coltext[2]];
			$sqlupdate_row .= $coltext[0].'="'.addslashes(test_input($_POST[$coltext[0]])).'", '; 
			$sqlupdate_row .= $coltext[1].'="'.addslashes(test_input($_POST[$coltext[1]])).'", '; 
			$sqlupdate_row .= $coltext[2].'="'.addslashes(test_input($_POST[$coltext[2]])).'", '; 
		} elseif ( $col["input_type"] == "select" || $col["input_type"] == "tableselect" ) {
			${$col["column"]} = implode(";", $_POST[$col["column"]]); 
		} elseif ( $col["input_type"] == "datetime" ) {
			${$col["column"]} = date("Y-m-d H:i:s",strtotime($_POST[$col["column"]]));
		} else {
			${$col["column"]} = $_POST[$col["column"]];
		}
		// test input and addslashes to field variable
		${$col["column"]} = addslashes(test_input(${$col["column"]}));

		// Recombine queries
		$sqlinsert_row .= $col["column"].",";	
		if ( empty(${$col["column"]}) ) {
			$sqlupdate_row .= $col["column"].'=NULL, ';
			$sqlinsert_row_values .= "NULL,";	
		} else {
			$sqlupdate_row .= $col["column"].'="'.${$col["column"]}.'", ';
			$sqlinsert_row_values .= "'".${$col["column"]}."',";	
		}
		}
	}
	// Build sql queries
	$sqlupdate_row = rtrim($sqlupdate_row,", ").' where id="'.$_GET['id'].'"';
	//echo "Update: ".$sqlupdate_row."\n";
	$sqlinsert_row = rtrim($sqlinsert_row,",").") values(".rtrim($sqlinsert_row_values,",").")";
	//echo "Insert: ".$sqlinsert_row."\n";

	// Decide which query to pass on
	if ( $_POST["submit"] == "Update" ) {
		$sql_row = $sqlupdate_row;
		$sqltext = "updated";
	} elseif ( $_POST["submit"] == "Submit" ) {
		$sql_row = $sqlinsert_row;
		$sqltext = "created";
	}

	// If no error is found in the fields either formatting or empty
	if ( !$msgErr ) {
		if ( $conn->query($sql_row) === TRUE ) {
			echo "Record $sqltext successfully";
			//clear variables
			foreach ( $colslist as $col ) { ${$col["column"]} = ""; }
			if ( isset($_GET["return"]) ) {
				header( "Location: ".$_SERVER['PHP_SELF']."?page=".$_GET["return"] ); /* Redirect browser */
				exit();
			} //else {
			//	header( "Location: ".$_SERVER['PHP_SELF']."?page=".$_GET["page"] ); /* Redirect browser */
			//	exit();
			//}
		}
		else echo "Error: $conn->error";
	// needed to keep updating instead of Update
	} elseif ( $_POST["submit"] == "Update" && $msgErr ) {
		$action = "edit";
	}
}

// find row in DB
$buttonvalue = "Submit";
if ( $_GET["action"] == "edit" ) {
	$buttonvalue = "Update";
	// get info from db
	$sqlsel_row = "select * from $table where id=".$_GET['id'];
	//echo $sqlsel_row;
	$result = $conn->query($sqlsel_row);
	if ( !empty($result) ) {
		$row = $result->fetch_assoc();
		foreach ( $colslist as $col ) {
			if ( $col["input_type"] == "3text" ) {
				$coltext = explode(";", $col["column"]);
				${$col["column"]} = $row[$coltext[0]]."; ".$row[$coltext[1]]."; ".$row[$coltext[2]];
			} elseif ( $col["input_type"] == "datetime" ) {
				${$col["column"]} = date("Y-m-d\TH:i", strtotime( $row[$col["column"]] ));
	 		} else ${$col["column"]} = $row[$col["column"]];
			//echo "K: ".$col["column"]."; V: ".${$col["column"]}."<br>";
		}
	}
	$addgetvars .= "&amp;id=".$_GET['id'];
}

// delete row in DB
if ( $_GET["action"] == "delete" ) {
	$sqldel_row = "delete from $table where id=".$_GET['id'];
	//echo $sqldel_row;
	if ( $conn->query($sqldel_row) === TRUE ) {
		echo "Record deleled successfully";
	}
	else echo "Error: $conn->error";
}
?> 
	<form method="POST" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']).$addgetvars;?>">
	<table width=100% id="addeditform">
	<tr><th colspan=2><span><?php echo ucfirst(preg_replace("/_/", " ", $_GET["page"]))." Information"; ?></span></th></tr>
<?php
foreach ( $colslist as $col ) {
	if ( $col["input_type"] != "noform" ) {
?>
	<tr>
		<td><?php echo $col["title"] ?>:</td>
		<td><?php
	switch ( $col["input_type"] ) {
		case "text":
		case "currency":
		echo "<input type=\"text\" name=\"".$col["column"]."\" id=\"".$col["column"]."\" value=\"".${$col["column"]}."\" >\n";
		break;

		case "date":
		echo "<input type=\"date\" name=\"".$col["column"]."\" id=\"".$col["column"]."\" value=\"".${$col["column"]}."\" >\n";
		break;

		case "datetime":
		echo "<input type=\"datetime-local\" name=\"".$col["column"]."\" id=\"".$col["column"]."\" value=\"".${$col["column"]}."\" step=\"900\" >\n";
		break;

		case "3text":
		$coltext = explode("; ", $col["column"]);
		if ( !empty($_POST[$col["column"]]) && ( $_GET["action"] == "edit" || $action == "edit" ) ) { 
			${$coltext[0]} = $_POST[$coltext[0]];
			${$coltext[1]} = $_POST[$coltext[1]];
			${$coltext[2]} = $_POST[$coltext[2]]; 
		} elseif ( !empty(${$col["column"]}) ) { 
		$colval = explode("; ", ${$col["column"]});
			foreach ( $colval as $colkey => $colvalue ) {
				${$coltext[$colkey]} = $colvalue;
			}
		}
		echo "<input class=\"coltext\" type=\"text\" name=\"".$coltext[0]."\" id=\"".$coltext[0]."\" value=\"".${$coltext[0]}."\" >
			<input class=\"coltext\" type=\"text\" name=\"".$coltext[1]."\" id=\"".$coltext[1]."\" value=\"".${$coltext[1]}."\" >
			<input class=\"coltext\" type=\"text\" name=\"".$coltext[2]."\" id=\"".$coltext[2]."\" value=\"".${$coltext[2]}."\" >\n";
		break;

		case "textarea":
		echo "<textarea name=\"".$col["column"]."\" id=\"".$col["column"]."\" >".${$col["column"]}."</textarea>\n";
		break;

		case "checkbox":
		if ( ${$col["column"]} ) { $checked = "checked"; }
		echo "<input type=\"checkbox\" name=\"".$col["column"]."\"  id=\"".$col["column"]."\" value=\"yes\" $checked >\n";
		break;

		case "tableselect":
		include_once $funcroot.'selecttbllist.php';
		case "select":
			if ( $col["multiple"] == "yes" ) { $multiple = "multiple"; $size = "size=\"3\""; 
			} else { unset($multiple); $size = "size=\"1\""; }
		echo "<select name=\"".$col["column"]."[]\"  id=\"".$col["column"]."\" ".$size." ".$multiple.">
				<option value=\"\">Select a ".$col["title"]."</option>\n";
			$multisels = explode(";", ${$col["column"]});
			foreach ( $lists[$col["column"]] as $list ) {
				if ( array_search($list["key"], $multisels) !== false ) { $selected="selected"; }
				if ( $list["key"] != "selectparent" ) {
					echo "\t\t\t\t<option value='".$list["key"]."' $selected >".$list["title"]."</option>\n";
				} else { $selectnested = "true"; }
				unset($selected);
			}
		echo "\t\t\t</select>\n";
		break;
	} ?>
<?php
	if ( $col["required"] == "yes" ) {
		echo "\t\t\t<span class=\"error\">* ".$msgErr[$col["column"]]."</span>\n";
	} ?>
		</td>
	</tr>
<?php
	if ( $selectnested == "true" ) {
		include $funcroot."ajaxselect.php"; // $jstemplate var
		echo $jstemplate;
		unset($selectnested);
	}
	}
}
?>

	<tr>
		<td>
			<input type="submit" name="submit" value="<?php echo $buttonvalue?>">
		</td>
		<td><p><span class=\"error\">* Required Field.</span></p></td>
	</tr>
	</table>
	</form>
