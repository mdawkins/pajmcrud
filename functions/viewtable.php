<?php
$addtab = $colstring = $wherestring = [];
// table row header
foreach ( $colslist as $i => $col ) {
	if ( $col["input_type"] == "tableselect" && array_search($col["column"], array_column($selslist, "selcol")) !== null ) {
		foreach ( $selslist as $k => $sel ) {
			if ( $col["column"] == $sel["selcol"] ) {
				$addtab[$i] = $sel["seltable"]." AS t$i";
				$colstring[$i] = "t$i.".$sel["selname"]." AS ".$col["column"];
				$wherestring[$i] = $table.".".$col["column"]."=t$i.".$sel["selid"];
			}
		} 
	} elseif ( $col["input_type"] == "dropedit" ) { break;
	} else { $colstring[$i] = "$table.".$col["column"]; }
}

// table row information
foreach ( $colstring as $key => $field ) {
	$fields .= $field.",";
}
$fields = rtrim($fields,",");

if ( !empty($wherestring) ) {
	$wheres = "WHERE ";
	foreach ( $wherestring as $key => $where ) {
		$wheres .= $where." AND ";
	}
	$wheres = rtrim(trim($wheres),"AND");
}

// add in ajax filters wheres here
foreach ( $colslist as $i => $col ) {
	if ( !empty($_POST[$col["column"]]) ) {
		${$col["column"]} = implode("','", $_POST[$col["column"]]);
		if ( $col["filterbox"] == "checkbox" ) { 
			$addwheres .= " AND ".$col["column"]." REGEXP '".str_replace(",", "|", ${$col["column"]})."' ";
		}
		elseif ( $col["filterbox"] == "text" ) {
			$addwheres .= " AND ".$col["column"]." LIKE '%".${$col["column"]}."%' ";
		}
		if ( empty($wheres) ) { $wheres = "WHERE ".ltrim($addwheres, " AND "); }
		else { $wheres .= $addwheres; }
	}
}

foreach ( $addtab as $key => $tab ) {
	//echo $tab.":";
	$addtables .= ", ".$tab;
}

// list All Sources in DB
if ( !isset($colorderby) ) { $colorderby = $colslist[0]["column"]; } else { $colorderby = str_replace("::", " ", $colorderby); }
if ( isset($_POST["column"]) ) { $colorderby = str_replace("::", " ", $_POST["column"]); }
if ( isset($_POST["sort"]) ) { $colorderby .= " ".$_POST["sort"]; }

$sqlsel_rows = "SELECT $table.id, $fields FROM $table $addtables $wheres ORDER BY ".$colorderby;
//echo $sqlsel_rows;

$result = $conn->query($sqlsel_rows);
if ($result->num_rows > 0) {
	$rownum = 0;
        // output data of each row
	while($row = $result->fetch_assoc()) {
		if ( isset($rowformat) ) { 
			foreach ( $rowformat as $rfm ) {
				if ( $rfm["value"] == $row[$rfm["column"]] ) {
					if ( !empty($rfm['background-color']) && isset($rfm['background-color']) ) {
						$rowbgcolor = "background-color:".$rfm['background-color']; }
					if ( !empty($rfm['text-color']) && isset($rfm['text-color']) ) {
						$rowtextcolor = "color:".$rfm['text-color'].";"; }
					if ( !empty($rfm['font-weight']) && isset($rfm['font-weight']) ) {
						$rowfontweight = "font-weight:".$rfm['font-weight'].";"; }
					if ( !empty($rfm['font-style']) && isset($rfm['font-style']) ) {
						$rowfontstyle = "font-style:".$rfm['font-style'].";"; }
					$rowstyle = "style=\"".$rowbgcolor."; cursor:pointer;\"";
					$tdstyle = "style=\"".$rowtextcolor.$rowfontweight.$rowfontstyle."\"";
					// clear values
					$rowbgcolor = $rowtextcolor = $rowfontweight = $rowfontstyle = "";
				}
			}
		}
		$html .= "<tr ".$rowstyle." id=\"".$row['id']."\" class=\"vtrow\" >\n";
		$ahrefedit = "<a ".$tdstyle." href='?page=".$_GET['page']."&amp;action=edit&amp;id=".$row['id']."'>";
		if ( $showidcolumn != "no" ) { $html .= "<td>".$ahrefedit.$row['id']."</a></td>\n"; }
		if ( $showrownum == "yes" ) { $rownum++; $html .= "<td>".$ahrefedit.$rownum."</a></td>\n"; }
		foreach ($colslist as $col) {
			if ( $col["input_type"] == "dropedit" ) {
				$html .= "<td><a ".$tdstyle." href='?page=".$col["column"]."&amp;action=edit&amp;id=".$row['id']."&amp;return=".$_GET['page']."'>".$col["title"]."</a></td>\n";
			} elseif ( $col["input_type"] == "date" ) {
				if ( $row[$col["column"]] == "0000-00-00" ) { $row[$col["column"]] = "--"; 
				} else { $row[$col["column"]] = date("m/d/Y",strtotime($row[$col["column"]])); }
				$html .= "<td>".$ahrefedit.$row[$col["column"]]."</a></td>\n";
			} elseif ( $col["input_type"] == "datetime" ) {
				if ( $row[$col["column"]] == "0000-00-00 00:00:00" ) { $row[$col["column"]] = "--"; 
				} else { $row[$col["column"]] = date("m/d/Y @ h:i a",strtotime($row[$col["column"]])); }
				$html .= "<td>".$ahrefedit.$row[$col["column"]]."</a></td>\n";
			} elseif ( $col["input_type"] == "select" ) {
				$row[$col["column"]] = str_replace(";", "/", $row[$col["column"]]);
				foreach ( $lists[$col["column"]] as $lst ) {
					$row[$col["column"]] = str_replace($lst["key"], $lst["title"], $row[$col["column"]]);
					//if ( $lst["key"] == $row[$col["column"]] ) {
						//$row[$col["column"]] = $lst["title"];
					//}
				}
				$html .= "<td>".$ahrefedit.$row[$col["column"]]."</a></td>\n";
			} else $html .= "<td>".$ahrefedit.$row[$col["column"]]."</a></td>\n";
		}
		$html .= "<td><a href='?page=".$_GET['page']."&amp;action=delete&amp;id=".$row['id']."'>Delete</a></td>
		</tr>\n";
	}
}
else {
	$html = "<tr><td colspan=4>Empty, Add information</td></tr>\n";
}
echo $html;
?>
