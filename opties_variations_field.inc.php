<?php
function output_pod_option_field() {
	global $product;
	global $post;
	
	$product_id = $product->get_id();
	$product_type = $product->get_type();
	
	if($product_type != "custom") {
		return;
	}
	
	$server_name = "http://".$_SERVER["SERVER_NAME"];
	$server_root = $_SERVER["DOCUMENT_ROOT"];
	$server_dir = __DIR__;
	$server_map = str_replace($server_root."/","",$server_dir);
	?>
	<link href="<?=$server_name?>/<?=$server_map?>/custom.css" rel="stylesheet" type="text/css">
	<?php
	
	if(isset($_GET["list_type"])) {
		$get_list_type = $_GET["list_type"];
	} else {
		$get_list_type = "icons";
	}
	
	$get_product_sku = $product->get_sku();
	
	$wp_image_src = wp_get_attachment_image_src( get_post_thumbnail_id( $product_id ), 'single-post-thumbnail' );
	$get_product_image_url = $wp_image_src[0];
	
	$curl_link = "https://artimedes.com/api-pod-plugin/curl.php?sku=".$get_product_sku."&image_url=".$get_product_image_url;
	$curl_data = file_get_contents($curl_link);
	$curl_data_array = (array)json_decode($curl_data);
	
	$unique_category = $curl_data_array["unique_category"];
	$product_cat = $curl_data_array["product_cat"];
	$product_tag = $curl_data_array["product_tag"];
	$brand_name = $product_cat;
	
	$url_list = get_permalink($product_id);
	$url_list_link_icons = $url_list."&list_type=icons";
	$url_list_link_select = $url_list."&list_type=select";
	if($get_list_type == "select") {
		$url_list_class_icons = "";
		$url_list_class_select = "selected";
	}
	if($get_list_type == "" or $get_list_type == "icons") {
		$url_list_class_icons = "selected";
		$url_list_class_select = "";
	}
	
	include_once("label_translations.inc.php");
	
	//$server_name = $curl_data_array["server_name"];
	$img_map = $curl_data_array["image_details"]->product_images_map;
	
	$db_product_title = $curl_data_array["product_title"];
	$scode = $curl_data_array["scode"];
	$category_scode = $curl_data_array["scode"];
	
	$img_name_canvas_zijkant = $curl_data_array["image_details"]->side_images->image_canvas_zijkant;
	$img_name_papier_zijkant = $curl_data_array["image_details"]->side_images->image_papier_zijkant;
	$img_name_dibond_zijkant = $curl_data_array["image_details"]->side_images->image_dibond_zijkant;
	
	$img_src_canvas_zijkant = $server_name."/".$img_map."/".$img_name_canvas_zijkant;
	$img_src_papier_zijkant = $server_name."/".$img_map."/".$img_name_papier_zijkant;
	$img_src_dibond_zijkant = $server_name."/".$img_map."/".$img_name_dibond_zijkant;
	
	$img_width = $curl_data_array["image_details"]->main_image->image_width;
	$img_height = $curl_data_array["image_details"]->main_image->image_height;
	
	$first_formaat = $curl_data_array["standard_details"]->standard_format;
	$std_prijs = sprintf("%01.2f",$curl_data_array["standard_details"]->standard_price);	
	
	if($get_list_type == "select") { include("opties_variations_field_select.inc.php"); }
	else { include("opties_variations_field_icons.inc.php"); }
	?>
	
	<input type="hidden" name="artimedes-check" class="artimedes-check" value="<?=$artimedes_check?>" />
	<input type="hidden" name="current-lang" class="current-lang" value="<?=$current_lang?>" />
	<input type="hidden" name="unique_category" value="<?=$unique_category?>" />
	<input type="hidden" name="product_category" value="<?=$product_cat?>" />
	<input type="hidden" name="product_tag" value="<?=$product_tag?>" />
	<input type="hidden" name="category_scode" value="<?=$category_scode?>" />
	<input type="hidden" name="server_name" value="<?=$server_name?>/<?=$server_map?>" />
	<input type="hidden" name="image_map" value="<?=$img_map?>" />
	<input type="hidden" name="image_url" value="<?=$get_product_image_url?>" />
	<input type="hidden" name="product_name" value="<?=$product_name?>" />
	<input type="hidden" name="image_width" value="<?=$img_width?>" />
	<input type="hidden" name="image_height" value="<?=$img_height?>" />
	<input type="hidden" name="list_type" value="<?=$get_list_type?>" />
	<input type="hidden" name="custom-price" class="custom-price" value="<?=$std_prijs?>" />
	<input type="hidden" name="custom-image" class="custom-image" />
	<input type="hidden" name="custom-sku" class="custom-sku" />
	<input type="hidden" name="first-formaat" class="first-formaat" value="<?=$first_formaat?>" />
	
	<?php
	$pakket_formaat = explode("x",$first_formaat);
		
	$aantal = 1;
	
	$pakket_length = $pakket_formaat[0];
	$pakket_width = $pakket_formaat[1];
	$pakket_height = $aantal*5;
	$pakket_weight = 3;
	?>
	<input type="hidden" name="pakket-length" class="pakket-length" value="<?=$pakket_length?>" />
	<input type="hidden" name="pakket-width" class="pakket-width" value="<?=$pakket_width?>" />
	<input type="hidden" name="pakket-height" class="pakket-height" value="<?=$pakket_height?>" />
	<input type="hidden" name="pakket-weight" class="pakket-weight" value="<?=$pakket_weight?>" />
	
	<div itemscope itemtype="http://schema.org/Product" style="width: 100%;">
		<div class="preloader"></div>
		<p itemprop="price" class="price product-page-price "><?php echo $product->get_price_html(); ?></p>
		<span style="display: none;" itemprop="name"><?=$product_name?></span>
		<span style="display: none;" itemprop="brand"><?=$brand_name?></span>
		<span style="display: none;" itemprop="productID"><?=$category_scode?></span>
		<div style="display: none;" itemprop="offers" itemscope itemtype="http://schema.org/Offer">
			<span itemprop="priceCurrency" content="EUR">€</span>
			<span itemprop="price" content="<?=$std_prijs?>"><?=$std_prijs?></span>
		</div>
	</div>
	<?php
	
}
add_action( 'woocommerce_before_add_to_cart_button', 'output_pod_option_field', 20 );

function( $price, $cart_item, $cart_item_key){
    $price = wc_price($std_prijs, 4); 
    return $price;
}
?>