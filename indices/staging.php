<?php
// Common functions
include basename($_SERVER['DOCUMENT_ROOT'])."_conf.inc";
require_once "../pajmcrud/functions/dbconnection.php";

if ( !empty($_GET["page"]) ) {

	// call page info and arrays
	include "pages/".$_GET["page"].".php";

	// pass on the correct page
	$andget = "?";
	if ( isset($_GET['page']) ) { $page = $andget."page=".$_GET['page']; $andget = "&amp;"; }
	if ( isset($_GET['return']) ) { $return = $andget."return=".$_GET['return']; $andget = "&amp;"; }
	$addgetvars = $page.$return;

	//if ( !isset($_GET["return"]) && $_GET["action"] != "edit" ) {
	if ( !isset($_GET["return"]) ) {
		// main page view table
		include $funcroot."viewtable.php";
	//phpinfo(32);
	} elseif ( $_GET["action"] == "edit" ) {
		// main page addedit form
		include $funcroot."addeditform.php";
	}
	/*
<script>

$(document).ready(function() {

	$('.vtrow').click(function() {
		columnId = $(this).attr('id');
		//alert(columnId);
		//edit_data(columnId);
	});

	function edit_data(editId) {
		var action = 'fetch_data';
		var editId = editId;
		$.ajax({
			url:"staging.php<?php echo $addgetvars ?>&action=edit",
			method:"POST",
			data:{ action:action, editId:editId },
			success: function(data){
				$('#addeditform').html(data);
				//document.getElementById("addeditform").style.display = "block";
			}
		});
	}

});

</script>
*/
?>
<?php
}


if( !empty($_POST["parselid"]) ) {
	// array fields needed from selslist
	$selcol=urldecode($_POST["selcol"]);			//selcol={{SELCOL}}
	$selname=urldecode($_POST["selname"]);			//selname={{SELNAME}}
	$selid=urldecode($_POST["selid"]);			//selid={{SELID}}
	$seltable=urldecode($_POST["seltable"]);		//seltable={{SELTABLE}}
	$wherekey=urldecode($_POST["wherekey"]);		//wherekey={{WHEREKEY}}
	$whereval=urldecode($_POST["whereval"]);		//wherval={{WHEREVAL}}
	$selunion=urldecode($_POST["selunion"]);		//wherval={{WHEREVAL}}
	$parselcol=urldecode($_POST["parselcol"]);		//parselcol={{PARSELCOL}}
	$partitle=urldecode($_POST["partitle"]);		//partitle={{PARTITLE}}
	$parselid=urldecode($_POST["parselid"]);		////grabbed by ajax event keyid???

	if ( !empty($selunion) ) { $unionstring = " UNION ( SELECT ".$selid.", ".$selname." as ".$selcol." FROM ".$selunion."=".$parselid." )"; }
	if ( !empty($whereval) ) { $wherestring = ' WHERE '.$wherekey." LIKE ".$whereval; } // !!! CANNOT USE SINGLE OR DOUBLE QUOTES HERE, PLACE IN VAR
	elseif ( !empty($wherekey) ) { $wherestring = ' WHERE '.$wherekey; }
	//Fetch all state data
	$sqlsel_rows = "SELECT t1.".$selid.", ".$selname." as ".$selcol." FROM ".$seltable.$wherestring." and t2.id = ".$parselid.$unionstring." ORDER BY ".$selid." ASC";
	$query = $conn->query($sqlsel_rows);

	//Count total number of rows
	$rowCount = $query->num_rows;
    
	//Project option list
	if ( $rowCount > 1 ) { //only print if there are multiple rows
		echo '<option value="">Select a '.$partitle.'</option>';
	} 
	if ( $rowCount > 0 ) { 
		while($row = $query->fetch_assoc()) {
			echo '<option value="'.$row[$selid].'">'.$row[$selcol].'</option>';
		}
	} else {
		echo '<option value="">'.$sqlsel_rows.' not available</option>';
	}
}

//phpinfo(32);
// close DB connection
mysqli_close($conn);
?>
