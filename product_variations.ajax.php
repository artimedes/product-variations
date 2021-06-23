<?php
$post_sku = $_POST["sku"];
$post_product = $_POST["product"];
$post_formaat = $_POST["formaat"];
$post_lijst = $_POST["lijst"];
$post_image_url = $_POST["image_url"];

$aantal = 1;

$db_prijs_field = "";
if($post_product == "canvas") {
	if($post_lijst != "geen-lijst") {
		if($post_lijst == "bloklijst-goud") {
			$db_prijs_field = "canvas_gouden_bloklijst";
		}
		else { $db_prijs_field = "canvas_baklijst"; }
	} else { $db_prijs_field = "canvas_20mm"; }
}
if($post_product == "papier") {
	if($post_lijst != "geen-lijst") {
		$db_prijs_field = "inlijsting_aquarelpapier_poly_acryl";
	} else {
		$db_prijs_field = "aquarelpapier_320g";
	}
}
if($post_product == "dibond") {
	if($post_lijst != "geen-lijst") {
		$db_prijs_field = "dibond_baklijst";
	} else {
		$db_prijs_field = "dibond";
	}
}

$curl_link = "https://artimedes.com/api-pod-plugin/curl.php?sku=".$post_sku."&image_url=".$post_image_url;
	
$curl_data = file_get_contents($curl_link);
$curl_data_array = (array)json_decode($curl_data);
$prijs_array = (array)$curl_data_array["product_prices"];
$prijs_field = (array)$prijs_array[$db_prijs_field];
$prijs = $prijs_field[$post_formaat];

$pakket_formaat = explode("x",$post_formaat);
if($post_product == "papier") {
	$pakket_length = 75;
	$pakket_width = 15;
	$pakket_height = 15;
	$pakket_weight = 2;
} else {
	$pakket_length = $pakket_formaat[0];
	$pakket_width = $pakket_formaat[1];
	$pakket_height = $aantal*5;
	$pakket_weight = 3;
}

$pcarray = array();
$pcarray['prijs_field'] = $db_prijs_field;
$pcarray['prijs'] = $prijs;
$pcarray['pakket_length'] = $pakket_length;
$pcarray['pakket_width'] = $pakket_width;
$pcarray['pakket_height'] = $pakket_height;
$pcarray['pakket_weight'] = $pakket_weight;

echo json_encode($pcarray);
?>