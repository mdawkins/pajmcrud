<?php
//parselid=$(this).val()

//print_r( $selslist );
//echo "<br>".$col["column"]."<br>";
foreach ( $selslist as $ajaxsel ) {
	if ( $ajaxsel["selcol"] == $col["column"] ) {
		$transvars = [ "{{PARENT}}" => urlencode($ajaxsel["parselcol"]), 
			"{{SELCOL}}" => urlencode($ajaxsel["selcol"]),
			"{{SELNAME}}" => urlencode($ajaxsel["selname"]),
			"{{SELID}}" => urlencode($ajaxsel["selid"]),
			"{{SELTABLE}}" => urlencode($ajaxsel["seltable"]),
			"{{WHEREKEY}}" => urlencode($ajaxsel["wherekey"]),
			"{{WHEREVAL}}" => urlencode($ajaxsel["whereval"]),
			"{{SELUNION}}" => urlencode($ajaxsel["selunion"]),
			"{{PARSELCOL}}" => urlencode($ajaxsel["parselcol"]),
			"{{PARTITLE}}" => urlencode($ajaxsel["partitle"])
		];
	}
}

$jstemplate = "<script type=\"text/javascript\">
$(document).ready(function() {
	$('#{{PARENT}}').on('change',function() {
		var parentVAL = $(this).val();
		if(parentVAL) {
			$.ajax({
				type: 'POST',
				url: 'data.php',
				data: \"parselid=\"+parentVAL+\"&selcol={{SELCOL}}&selname={{SELNAME}}&selid={{SELID}}&seltable={{SELTABLE}}&wherekey={{WHEREKEY}}&whereval={{WHEREVAL}}&selunion={{SELUNION}}&parselcol={{PARSELCOL}}&partitle={{PARTITLE}}\",
				success: function(html){
					$('#{{SELCOL}}').html(html);
				}
			}); 
		} else {
			$('#{{SELCOL}}').html('<option value=\"\">Select {{PARTITLE}} first</option>');
		}
	});
});
</script>";

$jstemplate = strtr( $jstemplate, $transvars);
?>
