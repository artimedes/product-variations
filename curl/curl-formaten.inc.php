<?php
$formaat_db_field = "formaat";
$formaat_db_table = "api_prijzen";

$formaat_array = array();
$formaat_producten_array = array("canvas","dibond");
$formaat_exceptions_array = array(145,155,165,175,185,190,195,205,210,215,225,230,230,245);

$min_aspect_difference = 0.02;
$img_aspect = ($details_image_width/$details_image_height)*1000;

$query_api = "
	SELECT	`$formaat_db_field`
	FROM	`$formaat_db_table`
	WHERE	ABS((aspect_integer-".$img_aspect.")/aspect_integer) < ".$min_aspect_difference;
$result_api = $mysqli->query($query_api);
$api_count = $result_api->num_rows;
if($api_count == 0) {
	$min_aspect_difference = 0.03;
	
	$query_api_aspect = "
		SELECT	`$formaat_db_field`
		FROM	`$formaat_db_table`
		WHERE	ABS((aspect_integer-".$img_aspect.")/aspect_integer) < ".$min_aspect_difference;
	$result_api_aspect = $mysqli->query($query_api_aspect);
	$api_count_aspect = $result_api_aspect->num_rows;

	if($api_count_aspect > 0) {
		while($row_api = $result_api_aspect->fetch_assoc()) {
			$formaat = $row_api[$formaat_db_field];
			$db_formaat_parts = explode("x",$formaat);
			
			foreach($formaat_producten_array as $formaat_product) {
				if($formaat_product == "dibond") {
					if(($db_formaat_parts[0] <= 100 and $db_formaat_parts[1] <= 100) and ($db_formaat_parts[0] >= 20 and $db_formaat_parts[1] >= 20)) {
						$formaat_array[$formaat_product][] = $formaat;
					}
				} else {
					if(in_array($db_formaat_parts[0], $formaat_exceptions_array) or in_array($db_formaat_parts[1], $formaat_exceptions_array)) {
					} else {
						if($db_formaat_parts[0] > 140 and $db_formaat_parts[1] > 140) { }
						else {
							$formaat_array[$formaat_product][] = $formaat;
						}
					}
				}
			}
		}
	}
} else {
	while($row_api = $result_api->fetch_assoc()) {
		$formaat = $row_api[$formaat_db_field];
		$db_formaat_parts = explode("x",$formaat);
		
		foreach($formaat_producten_array as $formaat_product) {
			if($formaat_product == "dibond") {
				if(($db_formaat_parts[0] <= 100 and $db_formaat_parts[1] <= 100) and ($db_formaat_parts[0] >= 20 and $db_formaat_parts[1] >= 20)) {
					$formaat_array[$formaat_product][] = $formaat;
				}
			} else {
				if(in_array($db_formaat_parts[0], $formaat_exceptions_array) or in_array($db_formaat_parts[1], $formaat_exceptions_array)) {
				} else {
					if($db_formaat_parts[0] > 140 and $db_formaat_parts[1] > 140) { }
					else {
						$formaat_array[$formaat_product][] = $formaat;
					}
				}
			}
		}
	}
}
$formaat_array["papier"][] = "30x40";
$formaat_array["papier"][] = "40x60";
$formaat_array["papier"][] = "60x80";
?>