<?php
/**
 * Plugin Name: Artimedes B.V. Plugin POD variaties
 * Plugin URI: http://www.artimedes.com 
 * Description: POD variaties
 * Version: 1.0
 * Author: Artimedes B.V.
 * Author URI: http://www.artimedes.com 
 * Requires at least: 3.5
 * Tested up to: 4.3.1
 * Text Domain: artimedes-pod
 * Domain Path: /lang
 *
 * @author Artimedes B.V.
 *
 *
 */

function pod_single_product_js() {
	global $product;

	$product_title = $product->get_name();
	$product_id = $product->get_id();
	
	if(!$product->is_type( 'custom' )) {
		return;
	}
	
	if(!isset($_GET["list_type"]) or $_GET["list_type"] == "") {
		$get_list_type = "";
	} else {
		$get_list_type = $_GET["list_type"];
	}
	
	$iphone = strpos($_SERVER['HTTP_USER_AGENT'],"iPhone");
	$android = strpos($_SERVER['HTTP_USER_AGENT'],"Android");
	$palmpre = strpos($_SERVER['HTTP_USER_AGENT'],"webOS");
	$berry = strpos($_SERVER['HTTP_USER_AGENT'],"BlackBerry");
	$ipod = strpos($_SERVER['HTTP_USER_AGENT'],"iPod");
	$ipad = strpos($_SERVER['HTTP_USER_AGENT'],"iPad");

	if($iphone || $android || $palmpre || $ipod || $berry  == true) {
		$mobile_device = true;
	} else {
		$mobile_device = false;
	}

	if($get_list_type == "") {
		if($mobile_device == true) {
			$get_list_type = "icons";
		} else {
			$get_list_type = "icons";
		}
	}
	
	include("index_single_product_js_icons.inc.php");
}
add_action( 'woocommerce_single_product_summary', 'pod_single_product_js', 10 );

include("opties_variations_field.inc.php");
include("opties_variations_script.inc.php");

include("bank-display/index.php");

// --------------------------
// #1 Add New Product Type to Select Dropdown
 
add_filter( 'product_type_selector', 'artimedes_add_custom_product_type' );
 
function artimedes_add_custom_product_type( $types ){
    $types[ 'custom' ] = 'Artimedes product';
    return $types;
}
 
// --------------------------
// #2 Add New Product Type Class
 
add_action( 'init', 'artimedes_create_custom_product_type' );
 
function artimedes_create_custom_product_type(){
    class WC_Product_Custom extends WC_Product {
      public function get_type() {
         return 'custom';
      }
    }
}
 
// --------------------------
// #3 Load New Product Type Class
 
add_filter( 'woocommerce_product_class', 'artimedes_woocommerce_product_class', 10, 2 );
 
function artimedes_woocommerce_product_class( $classname, $product_type ) {
    if ( $product_type == 'custom' ) {
        $classname = 'WC_Product_Custom';
    }
    return $classname;
}

function custom_product_cart_button($product_type) {
	global $product;

	if($product->is_type( 'custom' )) {
    	wc_get_template( 'single-product/add-to-cart/simple.php' );
	}
}
add_action( 'woocommerce_custom_add_to_cart', 'custom_product_cart_button' );






add_filter( 'woocommerce_product_data_tabs', 'artimedes_pod_product_tab', 10, 2 );
 
function artimedes_pod_product_tab($tabs) {
	$product_id = $_GET["post"];
	$product_type =  WC_Product_Factory::get_product_type($product_id);
	if($product_type == "custom") {
		$tabs['artimedes_pod'] = array(
			'label'	 => __( 'Artimedes POD productinstellingen', 'pod_product' ),
			'target' => 'artimedes_pod_product_options',
			'class'  => 'show_if_artimedes_pod_product',
		);
	}
	return $tabs;
}

add_action( 'woocommerce_product_data_panels', 'artimedes_pod_product_tab_product_tab_content' );

function artimedes_pod_product_tab_product_tab_content($product_id) {
	$product_type =  WC_Product_Factory::get_product_type($product_id);
	if($product_type == "custom") {
		?>
		<div id='artimedes_pod_product_options' class='panel woocommerce_options_panel'>
			<div class='options_group'>
				<?php
				woocommerce_wp_text_input(
					array(
						'id' => 'artimedes_pod_product_drukfile',
						'label' => __( 'Drukfile', 'pod_product' ),
						'placeholder' => '',
						'desc_tip' => 'true',
						'description' => __( 'Link naar de drukfile van dit werk', 'pod_product' ),
						'type' => 'text'
					)
				);
				?>
			</div>
		</div>
		<?php
	}
}

add_action( 'woocommerce_process_product_meta', 'save_artimedes_pod_product_settings' );
	
function save_artimedes_pod_product_settings( $post_id ){
	$artimedes_pod_product_drukfile = $_POST['artimedes_pod_product_drukfile'];
	if( !empty( $artimedes_pod_product_drukfile ) ) {
		update_post_meta( $post_id, 'artimedes_pod_product_drukfile', esc_attr( $artimedes_pod_product_drukfile ) );
	}
}

/*
add_action( 'woocommerce_single_product_summary', 'artimedes_pod_product_front' );
	
function artimedes_pod_product_front () {
    global $product;

    if ( 'artimedes_pod' == $product->get_type() ) {  	
       echo( get_post_meta( $product->get_id(), 'artimedes_pod_product_drukfile' )[0] );

  }
}
*/

include("admin/settings.php")
?>