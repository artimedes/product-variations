<?php
$prijs_db_table = "api_prijzen";

$prijs_array = array();
$prijs_db_field_array = array(
	"canvas"=>array(
		"canvas_20mm","canvas_baklijst","canvas_gouden_bloklijst"
	),
	"papier"=>array(
		"aquarelpapier_320g","inlijsting_aquarelpapier_poly_acryl"
	),
	"dibond"=>array(
		"dibond","dibond_baklijst"
	)
);

foreach($formaat_array as $formaat_product_key => $formaten_product) {
	$prijs_db_fields_query = implode(",",$prijs_db_field_array[$formaat_product_key]);
	$query_prijzen = "SELECT formaat,$prijs_db_fields_query FROM `$prijs_db_table` WHERE (";
	foreach($formaten_product as $formaat_product_key => $formaat_product) {
		if($formaat_product_key != end(array_keys($formaten_product))) {
			$query_prijzen .= "formaat = '$formaat_product' OR ";
		} else {
			$query_prijzen .= "formaat = '$formaat_product'";
		}
	}
	$query_prijzen .= ")";
	
	$result_prijzen = $mysqli->query($query_prijzen);
	while($row_prijzen = $result_prijzen->fetch_assoc()) {
		$row_formaat = $row_prijzen["formaat"];
		
		$prijs_db_fields = explode(",",$prijs_db_fields_query);
		foreach($prijs_db_fields as $prijs_field) {
			$prijs_array[$prijs_field][$row_formaat] = $row_prijzen[$prijs_field];
		}
	}
}
?>