<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
<style>
<?php include_once $pajmroot."css/pages_css.php"; ?>
</style>
<script type="text/javascript" src="js/jquery-latest.min.js" /></script>
<script type="text/javascript" src="js/jquery.mask.min.js" /></script>
<script type="text/javascript" src="js/mask-config.js" /></script>

</head>
<body>

<button class="collapsemenu">Page Menu</button>
<div class="sidenav">
<?php echo $menuhtml; ?>
</div>

<?php
if ( !empty($_GET["page"]) ) {
	// DB connection info
	require_once $funcroot."dbconnection.php";

	// call page info and arrays
	include "pages/".$_GET["page"].".php";

	// pass on the correct page
	$andget = "?";
	if ( isset($_GET['page']) ) { $page = $andget."page=".$_GET['page']; $andget = "&amp;"; }
	if ( isset($_GET['return']) ) { $return = $andget."return=".$_GET['return']; $andget = "&amp;"; }
	$addgetvars = $page.$return;

	if ( !isset($_GET["return"]) ) {
		//filter menu
		include $funcroot.'filtermenu.php';

		// main page view table
		echo "<div class=\"main\">\n";
		echo "<input type='hidden' id='sort' value='$coloderby'>\n";
		echo "<table width=100% id=\"mainviewtable\">
	<tr>\n";

		if ( $showidcolumn != "no" ) {
			echo"<th><span style=\"cursor:pointer;\" id=\"id::asc\" class=\"colsort\">ID</span></th>\n";
		}
		if ( $showrownum == "yes" ) {
			echo"<th><span>No.</span></th>\n";
		}
		// table row header
		foreach ( $colslist as $i => $col ) {
			if ( $col["hidecol"] != "yes" ) {
			$sortstring = "";
			if ( $col["input_type"] != "pivotjoin" )
				$sortstring = "id=\"".$col["column"]."::asc\" class=\"colsort\"";
			echo "<th><span style=\"cursor:pointer;\" $sortstring>".$col["title"]."</span></th>\n";
			}	
		}
		if ( $showdeletecolumn != "no" ) {
			echo "<th></th>";
		}
		echo "</tr>\n";
		// here goes table
		echo "</table>\n";
		echo "</div>\n";
	}

	if ( $showaddedit != "no" ) {
		$formtitle = "Add Information";
		if ( $_GET["action"] == "edit" ) { $formtitle = "Edit Information"; }
		echo "<button class=\"collapseform\">".$formtitle."</button>
		<div class=\"rightform\">\n";
		// right menu form
		include $funcroot.'addeditform.php';
		echo "</div>\n";
	}
}

//phpinfo(32);
// close DB connection
mysqli_close($conn);
//mysqli:close($conn);

echo "<script>\n";
$collapsearray = array( "collapsemenu", "collapseform", "collapsefilter", "collapsesearch");
foreach ( $collapsearray as $coll ) {
	echo "var coll = document.getElementsByClassName(\"".$coll."\");";
?>
var i;

for (i = 0; i < coll.length; i++) {
  coll[i].addEventListener("click", function() {
    this.classList.toggle("active");
    var content = this.nextElementSibling;
    if (content.style.display === "block") {
      content.style.display = "none";
    } else {
      content.style.display = "block";
    }
  });
}
<?php
}
?>

</script>
</body>
</html> 
