<?php

// filterbox
$checkboxset = 0;
$textset = 0;
foreach ( $colslist as $i => $col ) {
	$cbkeys = array_count_values(array_column($colslist, "filterbox"))["checkbox"];	
	$txtkeys = array_count_values(array_column($colslist, "filterbox"))["text"];	
	if ( $col["filterbox"] == "checkbox" ) {
		if ( $checkboxset == 0 ) { $cbhtml = "<button class=\"collapsefilter\">Checkbox Filter</button>\n<div class=\"filternav\">\n"; }
		$checkboxset++;
		$sqlsel_filterbox = "select DISTINCT(".$col["column"].") from $table WHERE ".$col["column"]." != \"\" ORDER BY ".$col["column"];
		if ( $col["multiple"] == "yes" ) {
			$sqlsel_filterbox = "select DISTINCT(SUBSTRING_INDEX(SUBSTRING_INDEX(".$table.".".$col["column"].", ';', numbers.n), ';', -1)) ".$col["column"]." FROM (SELECT 1 n UNION ALL SELECT 2 UNION ALL SELECT 3 UNION ALL SELECT 4 UNION ALL SELECT 5) numbers INNER JOIN ".$table." on CHAR_LENGTH(".$table.".".$col["column"].")-CHAR_LENGTH(REPLACE(".$table.".".$col["column"].", ';', '')) >= numbers.n-1 WHERE ".$table.".".$col["column"]." != '' ORDER BY ".$table.".".$col["column"];
		}
		//echo $sqlsel_filterbox."\n";
		if ( $col["input_type"] == "tableselect" ) {
			include_once $funcroot.'selecttbllist.php';
		}
		$result = $conn->query($sqlsel_filterbox);
		if ($result->num_rows > 0) {
			$filterboxtitle = $col["title"];
			$cbhtml .= "<p>\n<label>$filterboxtitle</label>\n";
			// output data of each row
			while($row = $result->fetch_assoc()) {
				foreach ( $lists[$col["column"]] as $list ) {
					if ( $list["key"] == $row[$col["column"]] ) {
						if ( $list["checked"] == "yes" ) { $checked = "checked"; } 
						$cbhtml .= "<label><input type=\"checkbox\" class=\"common_selector ".$col["column"]."\" value=\"".$row[$col["column"]]."\" $checked > ".$list["title"]."</label>\n";
						unset($checked);
					}
				}
			}
			$cbhtml .= "</p>\n";
		}
		if ( $cbkeys == $checkboxset ) { $cbhtml .= "</div>\n"; }
	}
	if ( $col["filterbox"] == "text" ) {
		if ( $textset == 0 ) { $txthtml .= "<button class=\"collapsesearch\">Search Filter</button>\n<div class=\"searchform\">\n<table width=100%>"; }
		$textset++;
		$txthtml .= "<tr>
			<td>".$col["title"].":</td>
			<td><input type=\"text\" name=\"".$col["column"]."\" class=\"common_search ".$col["column"]."\" >
			</td>
		</tr>\n";
		if ( $txtkeys == $textset ) { $txthtml .= "</table>\n</div>\n"; }
	}
}

echo $cbhtml;
echo $txthtml;

?>

<script>

$(document).ready(function() {

	columnName = "";
	if ( columnName == "" ) {
<?php if ( !isset($colorderby) ) { $colorderby = "id::asc"; }
echo "\t\tcolumnName = \"".$colorderby."\";\n"; ?>
	}

	$('.common_selector').click(function() {
		filter_data();
	});

	$('.common_search').unbind().keyup(function() {
		filter_data();
	});

	$('.colsort').click(function() {
		columnName = $(this).attr('id');
		if ( document.getElementById('sort').value == columnName ) {
			var sepcol = columnName.split('::');
			if ( sepcol[1] == "desc" ) {
				var coldir = "asc";
			} else {
				var coldir = "desc";
			}
			columnName = sepcol[0].concat("::", coldir);
		}
		$("#sort").val(columnName);
		// alert(document.getElementById('sort').value);
		filter_data();
	});

//	$('.vtrow').click(function() {
//		document.getElementById("addeditform").style.display = "block";
//	});

	function get_filter(class_name) {
		var filter = [];
		$('.'+class_name+':checked').each(function(){
			filter.push($(this).val());
		});
		return filter;
	}

	function get_search(class_name) {
		var searchval = [];
		$('.'+class_name).each(function(){
			searchval.push($(this).val());
		});
		return searchval;
	}

	function filter_data() {
		//$('#mainviewtable').html('<table class="loading" style="" ></table>');
		var action = 'fetch_data';
		var column = columnName;
<?php
foreach ( $colslist as $i => $col ) {
	if ( $col["filterbox"] == "checkbox" ) {
		echo "\t\tvar ".$col["column"]." = get_filter('".$col["column"]."');\n";
		$datastring .= $col["column"].":".$col["column"].", ";
	} 
	if ( $col["filterbox"] == "text" ) {
		echo "\t\tvar ".$col["column"]." = get_search('".$col["column"]."');\n";
		$datastring .= $col["column"].":".$col["column"].", ";
	}
}
$datastring  = rtrim($datastring, ", ");
?>
		$.ajax({
			url:"staging.php<?php echo $addgetvars ?>",
			method:"POST",
			data:{ action:action, column:column, <?php echo $datastring; ?> },
			success: function(response){
				$('#mainviewtable tr:not(:first)').remove();
				$('#mainviewtable').append(response);

			}
		});
	}

	filter_data();


});
</script>
