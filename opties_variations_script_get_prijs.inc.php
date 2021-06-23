<?php
$post_unique_category = $_POST["unique_category"];

$post_product = $_POST["option-product"];
$post_product_categorie = $_POST["product_category"];
$post_product_tag = $_POST["product_tag"];
$post_formaat = $_POST["option-formaat"];
$post_lijst = str_replace(" ","-",$_POST["option-lijst"]);
$post_image_url = $_POST["image_url"];

include("connect.inc.php");

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
$price = $prijs_field[$post_formaat];
?>