<?php
/**
 * Add engraving text to cart item.
 *
 * @param array $cart_item_data
 * @param int   $product_id
 * @param int   $variation_id
 *
 * @return array
 */
function pod_add_option_to_cart_item($cart_item_data, $product_id, $variation_id) {
	$product_type = get_the_terms( $product_id,'product_type')[0]->slug;
	if($product_type != "custom") {
		return;
	}
	
	$option_product = filter_input(INPUT_POST, 'option-product');
	$option_formaat = filter_input(INPUT_POST, 'option-formaat');
	$option_lijst = filter_input(INPUT_POST, 'option-lijst');
	
	$lang = filter_input(INPUT_POST, 'lang');
	
	if(empty($option_product)) {
		return $cart_item_data;
	}
	if(empty( $option_formaat)) {
		return $cart_item_data;
	}
	
	$cart_item_data['option-product'] = $option_product;
	$cart_item_data['option-formaat'] = $option_formaat;
	$cart_item_data['option-lijst'] = $option_lijst;
	$cart_item_data['lang'] = $lang;
	
	return $cart_item_data;
}
add_filter( 'woocommerce_add_cart_item_data', 'pod_add_option_to_cart_item', 10, 3 );

/**
 * Display engraving text in the cart.
 *
 * @param array $item_data
 * @param array $cart_item
 *
 * @return array
 */
function pod_display_option_cart($item_data, $cart_item) {
	if (empty($cart_item['option-product'])) {
		return $item_data;
	}
	if (empty( $cart_item['option-formaat'])) {
		return $item_data;
	}
	
	$current_lang = apply_filters( 'wpml_current_language', NULL );
	if($current_lang == "") {
		$current_lang = "nl";
	}
	
	$lang = array();
	$lang["materiaal"]["nl"]				= "Materiaal";
	$lang["papier"]["nl"]					= "papier";
	$lang["aquarelpapier"]["nl"]			= "Aquarelpapier";
	$lang["formaat"]["nl"]					= "Formaat";
	$lang["afbeelding"]["nl"]				= "Afbeelding";
	$lang["lijst"]["nl"]					= "Omlijsting";
	$lang["geen-lijst"]["nl"]				= "Geen lijst";
	$lang["baklijst-blank"]["nl"]			= "Houten baklijst blank";
	$lang["baklijst-wit"]["nl"]				= "Houten baklijst wit";
	$lang["baklijst-zwart"]["nl"]			= "Houten baklijst zwart";
	$lang["bloklijst-goud"]["nl"]			= "Houten bloklijst goudkleur";
	$lang["wissellijst-blank"]["nl"]		= "Houten wissellijst, blank";
	$lang["wissellijst-koloniaal"]["nl"]	= "Houten wissellijst, koloniaal";
	$lang["wissellijst-wit"]["nl"]			= "Houten wissellijst, wit";
	$lang["wissellijst-zwart"]["nl"]		= "Houten wissellijst, zwart";
	$lang["dibond-baklijst-wit"]["nl"]		= "Houten baklijst wit";
	$lang["dibond-baklijst-zwart"]["nl"]	= "Houten baklijst zwart";
	$lang["cart-label-materiaal"]["nl"]		= "Gicléeprint";

	$lang["materiaal"]["en"]				= "Material";
	$lang["papier"]["en"]					= "paper";
	$lang["aquarelpapier"]["en"]			= "Watercolor Paper";
	$lang["formaat"]["en"]					= "Size";
	$lang["afbeelding"]["en"]				= "Image";
	$lang["lijst"]["en"]					= "Frame";
	$lang["geen-lijst"]["en"]				= "None";
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
	$lang["cart-label-materiaal"]["en"]		= "Gicléeprint";
	
	if($cart_item['option-product'] == "papier") {
		$option_product = $lang["aquarelpapier"][$current_lang];
	} else {
		$option_product = $cart_item['option-product'];
	}
	
	if(strpos($cart_item['option-lijst'],"geen") !== false) {
		$option_lijst = $lang["geen-lijst"][$current_lang];
	} else {
		$option_lijst_key = str_replace(" ","-",$cart_item['option-lijst']);
		$option_lijst = $lang[$option_lijst_key][$current_lang];
	}
	
	$item_data[] = array(
		'key'     => __($lang["cart-label-materiaal"][$current_lang], 'iconic'),
		'value'   => wc_clean($option_product),
		'display' => '',
	);
	$item_data[] = array(
		'key'     => __($lang["formaat"][$current_lang], 'iconic2'),
		'value'   => wc_clean($cart_item['option-formaat']." cm"),
		'display' => '',
	);
	if(strpos($cart_item['option-lijst'],"geen") !== false) {
	} else {
		$item_data[] = array(
			'key'     => __($lang["lijst"][$current_lang], 'iconic3'),
			'value'   => wc_clean($option_lijst),
			'display' => '',
		);
	}
	return $item_data;
}
add_filter( 'woocommerce_get_item_data', 'pod_display_option_cart', 10, 2 );

/**
 * Add engraving text to order.
 *
 * @param WC_Order_Item_Product $item
 * @param string                $cart_item_key
 * @param array                 $values
 * @param WC_Order              $order
 */
function pod_add_option_to_order_items($item, $cart_item_key, $values, $order) {
	if (empty($values['option-product'])) {
		return;
	}

	$item->add_meta_data(__('Gicléeprint op', 'iconic'), $values['option-product']);
	$item->add_meta_data(__('Formaat', 'iconic2'), $values['option-formaat']);
	if($values['option-lijst'] != "") {
		$item->add_meta_data(__('Lijst', 'iconic3'), $values['option-lijst']);
	}
}
add_action('woocommerce_checkout_create_order_line_item', 'pod_add_option_to_order_items', 10, 4);

// Save custom field value in cart item
function pod_save_custom_field_in_cart_object( $cart_item_data, $product_id, $variation_id ) {
    // Get the correct Id to be used (compatible with product variations)
    $the_id = $variation_id > 0 ? $variation_id : $product_id;
	$product = wc_get_product($the_id); // Get the WC_Product object
	
	//$price = $_POST["custom-price"];
	include("opties_variations_script_get_prijs.inc.php");
	$cart_item_data['custom_price'] = $price;
	
	$sku = $_POST["custom-sku"];
	$cart_item_data['custom_option_sku_active'] = "yes";
	$cart_item_data['custom_option_sku'] = $sku;
	
	$custom_width = $_POST["pakket-width"];
	$custom_height = $_POST["pakket-height"];
	$custom_weight = $_POST["pakket-weight"];
	$custom_length = $_POST["pakket-length"];
	$cart_item_data['custom_width'] = $custom_width;
	$cart_item_data['custom_height'] = $custom_height;
	$cart_item_data['custom_weight'] = $custom_weight;
	$cart_item_data['custom_length'] = $custom_length;
	
	$material = $_POST["option-product"];
	$cart_item_data['custom_option_material'] = $material;
	
    return $cart_item_data;
}
add_filter('woocommerce_add_cart_item_data', 'pod_save_custom_field_in_cart_object', 30, 3);

// Change price of items in the cart
function pod_add_custom_item_price( $cart_object) {
    if(is_admin() && !defined('DOING_AJAX'))
        return;

    foreach(WC()->cart->get_cart() as $cart_item) {
    	if(isset($cart_item['custom_price'])) { 
    		$new_price = (float)$cart_item['custom_price'];
        	$cart_item['data']->set_price($new_price);
    	}
    	if(isset($cart_item['custom_option_sku'])) { 
    		$new_sku = $cart_item['custom_option_sku'];
    		$cart_item['data']->set_sku($new_sku);
    	}
    	if (isset($cart_item['custom_width'])) {
            $cart_item['data']->set_width($cart_item['custom_width']);
        }
        if (isset($cart_item['custom_height'])) {
            $cart_item['data']->set_height($cart_item['custom_height']);
        }
        if (isset($cart_item['custom_weight'])) {
            $cart_item['data']->set_weight($cart_item['custom_weight']);
        }
        if (isset($cart_item['custom_length'])) {
            $cart_item['data']->set_length($cart_item['custom_length']);
        }
    }
}
add_action('woocommerce_before_calculate_totals', 'pod_add_custom_item_price', 1);

function pod_woocommerce_cart_item_price_filter($price, $cart_item, $cart_item_key) {
    $new_price = $cart_item['custom_price'];
	return $new_price;
}
add_filter('woocommerce_cart_item_price', 'pod_woocommerce_cart_item_price_filter', 10, 3);
?>