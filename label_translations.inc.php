<?php
$current_lang = apply_filters( 'wpml_current_language', NULL );
if($current_lang == "") { $current_lang = "nl"; }

$lang = array();
$lang["materiaal"]["nl"]					= "Materiaal";
$lang["papier"]["nl"]						= "papier";
$lang["canvas_desc"]["nl"]					= "20mm spieraam";
$lang["aquarelpapier"]["nl"]				= "Aquarelpapier";
$lang["aquarelpapier_desc"]["nl"]			= "320 grams";
$lang["dibond_desc"]["nl"]					= "2mm alu-dibond, mat";
$lang["formaat"]["nl"]						= "Formaat";
$lang["afbeelding"]["nl"]					= "Afbeelding";
$lang["lijst"]["nl"]						= "Lijst";
$lang["geen-lijst"]["nl"]					= "Geen lijst";
if($get_list_type == "select") {
	$lang["baklijst-blank"]["nl"]			= "Baklijst blank";
	$lang["baklijst-wit"]["nl"]				= "Baklijst wit";
	$lang["baklijst-zwart"]["nl"]			= "Baklijst zwart";
	$lang["bloklijst-goud"]["nl"]			= "Bloklijst goud";
	$lang["wissellijst-blank"]["nl"]		= "Wissellijst blank";
	$lang["wissellijst-koloniaal"]["nl"]	= "Wissellijst koloniaal";
	$lang["wissellijst-wit"]["nl"]			= "Wissellijst wit";
	$lang["wissellijst-zwart"]["nl"]		= "Wissellijst zwart";
	$lang["dibond-baklijst-wit"]["nl"]		= "Dibond baklijst wit";
	$lang["dibond-baklijst-zwart"]["nl"]	= "Dibond baklijst zwart";
} else {
	$lang["baklijst-blank"]["nl"]			= "Blank";
	$lang["baklijst-wit"]["nl"]				= "Wit";
	$lang["baklijst-zwart"]["nl"]			= "Zwart";
	$lang["bloklijst-goud"]["nl"]			= "Goud";
	$lang["wissellijst-blank"]["nl"]		= "Blank";
	$lang["wissellijst-koloniaal"]["nl"]	= "Koloniaal";
	$lang["wissellijst-wit"]["nl"]			= "Wit";
	$lang["wissellijst-zwart"]["nl"]		= "Zwart";
	$lang["dibond-baklijst-wit"]["nl"]		= "Wit";
	$lang["dibond-baklijst-zwart"]["nl"]	= "Zwart";
}
$lang["cart-label-materiaal"]["nl"]			= "Gicléeprint";

$lang["materiaal"]["en"]					= "Material";
$lang["papier"]["en"]						= "paper";
$lang["canvas_desc"]["en"]					= "20mm stretched";
$lang["aquarelpapier"]["en"]				= "Watercolor Paper";
$lang["aquarelpapier_desc"]["en"]			= "320 grams";
$lang["dibond_desc"]["en"]					= "2mm alu-dibond, matte";
$lang["formaat"]["en"]						= "Size";
$lang["afbeelding"]["en"]					= "Image";
$lang["lijst"]["en"]						= "Framed";
$lang["geen-lijst"]["en"]					= "None";
if($get_list_type == "select") {
	$lang["baklijst-blank"]["en"]			= "Canvas frame blanc";
	$lang["baklijst-wit"]["en"]				= "Canvas frame white";
	$lang["baklijst-zwart"]["en"]			= "Canvas frame black";
	$lang["bloklijst-goud"]["en"]			= "Canvas frame gold";
	$lang["wissellijst-blank"]["en"]		= "Paper frame blanc";
	$lang["wissellijst-koloniaal"]["en"]	= "Paper frame kolonial";
	$lang["wissellijst-wit"]["en"]			= "Paper frame white";
	$lang["wissellijst-zwart"]["en"]		= "Paper frame black";
	$lang["dibond-baklijst-wit"]["en"]		= "Dibond frame white";
	$lang["dibond-baklijst-zwart"]["en"]	= "Dibond frame black";
} else {
	$lang["baklijst-blank"]["en"]			= "Blanc";
	$lang["baklijst-wit"]["en"]				= "White";
	$lang["baklijst-zwart"]["en"]			= "Black";
	$lang["bloklijst-goud"]["en"]			= "Gold";
	$lang["wissellijst-blank"]["en"]		= "Blanc";
	$lang["wissellijst-koloniaal"]["en"]	= "Kolonial";
	$lang["wissellijst-wit"]["en"]			= "White";
	$lang["wissellijst-zwart"]["en"]		= "Black";
	$lang["dibond-baklijst-wit"]["en"]		= "White";
	$lang["dibond-baklijst-zwart"]["en"]	= "Black";
}
$lang["cart-label-materiaal"]["en"]			= "Gicléeprint";
?>