<?php
// table row header
foreach ( $colslist as $i => $col ) {
	if ( $col["input_type"] == "dropedit" ) { break;
	} elseif ( $col["input_type"] == "tableselect" && array_search($col["column"], array_column($selslist, "selcol")) !== null ) {
		foreach ( $selslist as $k => $sel ) {
			if ( $col["column"] == $sel["selcol"] ) {
				$searchcol = $sel["selname"];
				$ljointables .= "LEFT JOIN ".$sel["seltable"]." AS t$i ON ";
				if ( $col["multiple"] == "yes" ) {
					// replace %T% with table alias
					$fields .= str_replace("%T%", "t$i", "GROUP_CONCAT(".$sel["selname"]." ORDER BY 1 SEPARATOR ', ') AS ".$col["column"]).",";
					$ljointables .= $table.".".$col["column"]." LIKE CONCAT('%', t$i.".$sel["selid"].", '%') ";
					$groupby = "GROUP BY $table.".$col["column"];
				} elseif ( $col["concatfield"] == "yes" ) {
					$fields .= str_replace("%T%", "t$i", $sel["selname"]." AS ".$col["column"]).",";
					$ljointables .= $table.".".$col["column"]." = t$i.".$sel["selid"]." ";
				} else {
					$fields .= "t$i.".$sel["selname"]." AS ".$col["column"].",";
					$ljointables .= $table.".".$col["column"]." = t$i.".$sel["selid"]." ";
				}
			}
		} 
	} elseif ( $col["input_type"] == "pivotjoin" )  {
		$fields .= "`".$col["column"]."`, ";
		$ljointables .= "LEFT JOIN\n\t(SELECT $pivkey, GROUP_CONCAT(DISTINCT(CASE WHEN $joinkey = '".$col["key"]."' THEN $joinkeyname END) ORDER BY 1 SEPARATOR ', ') AS '".$col["column"]."' FROM $jointable WHERE $joinwherekey = $joinwhereval AND $joinkey = '".$col["key"]."' GROUP BY $pivkey) AS t".$i." ON $table.id=t$i.$pivkey\n";

	} elseif ( !empty($col["concatval"]) ) {
		$fields .= $col["concatval"]." AS ".str_replace("%T%", "t$i", $col["column"]).",";
	} else {
		$fields .= "$table.".$col["column"].", ";
       	}
	// add in ajax filters wheres here
	if ( !empty($_POST[$col["column"]]) ) {
		${$col["column"]} = implode("','", $_POST[$col["column"]]);
		if ( $col["filterbox"] == "checkbox" ) { 
			if ( $col["multiple"] == "yes" && $col["input_type"] == "tableselect")
				$addwheres .= " AND t$i.id REGEXP '".str_replace(",", "||", ${$col["column"]})."' ";
			elseif ( $col["multiple"] == "yes" ) // just type select
				$addwheres .= " AND ".$col["column"]." REGEXP '".str_replace(",", "||", ${$col["column"]})."' ";
			else
				$addwheres .= " AND ".$col["column"]." IN('".${$col["column"]}."') ";
		}
		elseif ( $col["filterbox"] == "text" ) {
			if ( $col["input_type"] == "tableselect" ) {
				$addwheres .= " AND $searchcol LIKE '%".${$col["column"]}."%' ";
			} elseif ( !empty($col["concatval"]) ) {
				$addwheres .= " AND ".$col["concatval"]." LIKE '%".${$col["column"]}."%' ";
			} else {
				$addwheres .= " AND ".$col["column"]." LIKE '%".${$col["column"]}."%' ";
			}
		}
	}
}

// clean up of sql variables
$fields = rtrim($fields,", ");

if ( !empty($wheres) && empty($addwheres) ) {
	$wheres = "WHERE ".rtrim(trim($wheres),"AND");
} elseif ( !empty($addwheres) && empty($wheres) ) {
	$wheres = "WHERE ".ltrim($addwheres, " AND ");
} elseif ( !empty($wheres) && !empty($addwheres) )
	$wheres = "WHERE ".rtrim(trim($wheres),"AND").$addwheres;

// Column ORDER BY via _POST, variable, or default first Column
if ( isset($_POST["column"]) ) {
	$colorderby = str_replace("::", " ", $_POST["column"]);
} elseif ( isset($colorderby) ) {
	$colorderby = str_replace("::", " ", $colorderby);
} else	$colorderby = $colslist[0]["column"];
if ( isset($_POST["sort"]) ) { $colorderby .= " ".$_POST["sort"]; }

$sqlsel_rows = "SELECT $table.id, $fields FROM $table $ljointables $wheres $groupby ORDER BY $colorderby";

$result = $conn->query($sqlsel_rows);
if ($result->num_rows > 0) {
	$rownum = 0;
        // output data of each row
	while($row = $result->fetch_assoc()) {
		$colnum = 0;
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
		if ( $tabletype != "pivottable" ) {
			$ahrefedit = "<a ".$tdstyle." href='?page=".$_GET['page']."&amp;action=edit&amp;id=".$row['id']."'>";
			$ahrefend = "</a>";
		}
		if ( $showidcolumn != "no" ) {
			$html .= "<td>$ahrefedit".$row['id']."$ahrefend</td>\n";
			$colnum++;
		}
		if ( $showrownum == "yes" ) {
			$rownum++;
			$html .= "<td>$ahrefedit".$rownum."$ahrefend</td>\n";
			$colnum++;
		}
		foreach ($colslist as $col) {
			if ( $col["input_type"] == "dropedit" ) {
				$html .= "<td><a ".$tdstyle." href='?page=".$col["column"]."&amp;action=edit&amp;id=".$row['id']."&amp;return=".$_GET['page']."'>".$col["title"]."</a></td>\n";
			} elseif ( $col["input_type"] == "date" ) {
				if ( $row[$col["column"]] == "0000-00-00" ) { $row[$col["column"]] = "--"; 
				} else { $row[$col["column"]] = date("m/d/Y",strtotime($row[$col["column"]])); }
				$html .= "<td>$ahrefedit".$row[$col["column"]]."$ahrefend</td>\n";
			} elseif ( $col["input_type"] == "datetime" ) {
				if ( $row[$col["column"]] == "0000-00-00 00:00:00" ) { $row[$col["column"]] = "--"; 
				} else { $row[$col["column"]] = date("m/d/Y @ h:i a",strtotime($row[$col["column"]])); }
				$html .= "<td>$ahrefedit".$row[$col["column"]]."$ahrefend</td>\n";
			} elseif ( $col["input_type"] == "select" ) {
				$row[$col["column"]] = str_replace(";", "/", $row[$col["column"]]);
				foreach ( $lists[$col["column"]] as $lst ) {
					$row[$col["column"]] = str_replace($lst["key"], $lst["title"], $row[$col["column"]]);
					//if ( $lst["key"] == $row[$col["column"]] ) { $row[$col["column"]] = $lst["title"]; }
				}
				$html .= "<td>$ahrefedit".$row[$col["column"]]."$ahrefend</td>\n";
			} else $html .= "<td>$ahrefedit".$row[$col["column"]]."$ahrefend</td>\n";
			$colnum++;
		}
		if ( $showdeletecolumn != "no" ) {
			$html .= "<td><a href='?page=".$_GET['page']."&amp;action=delete&amp;id=".$row['id']."'>Delete</a></td>";
			$colnum++;
		}
		$html .= "</tr>\n";
	}
}
else {
	$html = "<tr><td colspan=4>Empty, Add information</td></tr>\n";
}
	//$html .= "<tr><td colspan=$colnum>SQL: $sqlsel_rows</td></tr>\n";
echo $html;
?>
