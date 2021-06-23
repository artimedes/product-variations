<?php
include("connect.inc.php");

$server_name = "http://".$_SERVER["SERVER_NAME"];
$product_images_map = "product-images";

if(isset($_GET["sku"])) {
	$scode = $_GET["sku"];
} else {
	//DEFAULT SCODE
	$scode = "";
}

$unique_category = "";	
$product_cat = "";
$product_tag = "";
/*
$query_details = "SELECT * FROM podsinger_werken WHERE scode = '$scode' LIMIT 1";
$result_details = $mysqli->query($query_details) or die(mysqli_error());
while($row_details = $result_details->fetch_assoc()) {
	$details_kunstenaar = $row_details["kunstenaar"];
	$details_titel = $row_details["titel"];
	$details_image_name = $row_details["image"];
	$details_image_url = $row_details["image_url"];
}

list($details_image_width,$details_image_height) = getimagesize($details_image_url);

include("curl-formaten.inc.php");
include("curl-prijzen.inc.php");

$standard_format = $formaat_array["canvas"][0];
$standard_product_field = "canvas_20mm";

$query_standard_values = "SELECT `$standard_product_field` FROM podsinger_prijzen WHERE formaat = '$standard_format' LIMIT 1";
$result_standard_values = $mysqli->query($query_standard_values) or die(mysqli_error());
while($row_standard_values = $result_standard_values->fetch_assoc()) {
	$standard_price = $row_standard_values[$standard_product_field];
}
*/

$lijst_array = array();
$lijst_array["canvas"] = array(
	"baklijst-blank" => "baklijst blank",
	"baklijst-wit" => "baklijst wit",
	"baklijst-zwart" => "baklijst zwart",
	"bloklijst-goud" => "bloklijst goud"
);
$lijst_array["papier"] = array(
	"wissellijst-blank" => "wissellijst blank",
	"wissellijst-koloniaal" => "wissellijst koloniaal",
	"wissellijst-wit" => "wissellijst wit",
	"wissellijst-zwart" => "wissellijst zwart"
);
$lijst_array["dibond"] = array(
	"baklijst-wit" => "baklijst wit",
	"baklijst-zwart" => "baklijst zwart"
);

$img_name_canvas_zijkant = $scode."-canvas-schuin.jpg";
$img_name_papier_zijkant = $scode."-print-schuin.jpg";
$img_name_dibond_zijkant = $scode."-dibond-schuin.jpg";

$product_details->server_name = $server_name;
$product_details->scode = $scode;
$product_details->unique_category = $unique_category;
$product_details->product_cat = $product_cat;
$product_details->product_tag = $product_tag;
$product_details->artist = $details_kunstenaar;
$product_details->product_title = $details_titel;
$product_details->custom_sku = $scode."-".$standard_format;
$product_details->image_details->product_images_map = $product_images_map;
$product_details->image_details->main_image->image_url = $details_image_url;
$product_details->image_details->main_image->image_name = $details_image_name;
$product_details->image_details->main_image->image_width = $details_image_width;
$product_details->image_details->main_image->image_height = $details_image_height;
$product_details->image_details->side_images->image_canvas_zijkant = $img_name_canvas_zijkant;
$product_details->image_details->side_images->image_papier_zijkant = $img_name_papier_zijkant;
$product_details->image_details->side_images->image_dibond_zijkant = $img_name_dibond_zijkant;
$product_details->standard_details->standard_format = $standard_format;
$product_details->standard_details->standard_price = $standard_price;
foreach($formaat_array as $formaat_product_key=>$formaten_product) {
	foreach($formaten_product as $formaat_product) {
		$product_details->select_options->select_formaten[$formaat_product_key][] = $formaat_product;
	}
}
foreach($lijst_array as $lijst_product_key=>$lijsten_product) {
	foreach($lijsten_product as $lijst_key=>$lijst_value) {
		$product_details->select_options->select_lijsten[$lijst_product_key][] = [$lijst_key,$lijst_value];
	}
}
foreach($prijs_array as $prijs_field_key=>$prijs_field_details) {
	foreach($prijs_field_details as $field_formaat=>$field_prijs) {
		$product_details->product_prices[$prijs_field_key][$field_formaat] = $field_prijs;
	}
}

$product_details_json = json_encode($product_details, JSON_UNESCAPED_UNICODE);
echo $product_details_json;
?>