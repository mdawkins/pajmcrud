<?php
// create array for creating select dropdown list
foreach ( $specslist as $sublist ) {
	echo $sublist["spec703id"]." - ".$sublist["specsource"];
	$kval=0;	
	foreach ( $sublist["testspecs"] as $key => $value ) {
		$key = trim($key);
		$titlekey = str_replace("grad", "Sieve Size ", $key);
		$titlekey = str_replace("extradesc", "Extra Description", $titlekey);
		$titlekey = str_replace("wo_orgmat", "Without Organic Material,...", $titlekey);
		$titlekey = str_replace("wo_asbestos", "Without Asbestos...", $titlekey);
		$titlekey = str_replace("asr_c1270_c1567", "ASR ASTM C1270 / C1567", $titlekey);
		$titlekey = str_replace("asg_t85", "Apparent Specific Gravity, AASHTO T85", $titlekey);
		$titlekey = str_replace("abs_t85", "Absorption, AASHTO T85", $titlekey);
		$titlekey = str_replace("laa_t96", "LA Abrasion, AASHTO T 96", $titlekey);
		$titlekey = str_replace("laa_t96", "LA Abrasion, AASHTO T 96", $titlekey);
		$titlekey = str_replace("sss_t104", "Sodium Sulfate Soundness, AASHTO T 104", $titlekey);
		$titlekey = str_replace("di_t210", "Durability Index, AASHTO T 210", $titlekey);
		$titlekey = str_replace("ff_d5821", "Fractured Faces, ASTM D5821", $titlekey);
		$titlekey = str_replace("ll_t89ma", "Liquid Limit, Method A, AASHTO T 89", $titlekey);
		$titlekey = str_replace("pi_t90", "Plastic Index, AASHTO T 90", $titlekey);
		$titlekey = str_replace("faa_t304", "Fine Aggregate Angularity, AASHTO T 304", $titlekey);
		$titlekey = str_replace("fep_d4791", "Flat and Elongate Particles, ASTM D4791", $titlekey);
		$titlekey = str_replace("clfp_t112", "Clay Lumps and Friable Particles, AASHTO T 112", $titlekey);
		$titlekey = str_replace("se_t176", "Sand Equivalent, AASHTO T 112", $titlekey);
		$titlekey = str_replace("coarse", ", Coarse", $titlekey);
		$titlekey = str_replace("fine", ", Fine", $titlekey);

		foreach ( $value as $vals ) {
			$splitvals  = explode(",", $vals);	
			foreach ( $splitvals as $val ) {
				$val = trim($val);
				$titleval = str_replace("grad", ", Grading", $val);
				$titleval = str_replace("permin", ", % Min", $titleval);
				$titleval = str_replace("permax", ", % Max", $titleval);
				$titleval = str_replace("min", ", Min", $titleval);
				$titleval = str_replace("max", ", Max", $titleval);
				$titleval = str_replace("range", " Range", $titleval);
				$titleval = str_replace("ratio", " Ratio", $titleval);
				$titleval = str_replace("minsize", " Min Size", $titleval);
				$titleval = str_replace("maxsize", " Max Size", $titleval);
				$titleval = str_replace("_", ".", $titleval);
				$titleval = str_replace("mm", " mm ", $titleval);
				$titleval = str_replace("um", " um ", $titleval);
				$titleval = str_replace("textarea", "", $titleval);
				$titleval = str_replace("checkbox", "", $titleval);
				$titleval = str_replace("blank", "", $titleval);

				$input_type ="text";
				if ( $key == "grad" ) {
					$collist = $key."_".$val."_permin; ".$key."_".$val."_permax; ".$key."_".$val."_dev";
					$input_type ="3text";
				} else {
					if ( $val == "textarea" || $val == "checkbox" ) {
						$input_type = $val;
						unset($val);
					} else {
						$val = "_$val";
					}
					$collist = $key.$val;
				}
				$colslist[$kval] = array( "column" => $collist, "title" => $titlekey.$titleval, "required" => "yes", "input_type" => $input_type );
				//print_r($colslist[$kval]);
				//echo "<br>";
				$kval++;
			}
		}
	}
}
?>
