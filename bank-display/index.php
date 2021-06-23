<?php
/**
 * Plugin Name: Artimedes ARTIMEDES_product_bank_display
 * Plugin URI: http://www.artimedes.com 
 * Description: Weergave met bank
 * Version: 1.0
 * Author: Hugo
 * Author URI: http://www.artimedes.com 
 * Requires at least: 3.5
 * Tested up to: 4.3.1
 * Text Domain: ARTIMEDES_product_bank_display
 * Domain Path: /lang
 *
 * @author Hugo
 *
 *
 */

function pod_product_bank_display() {
	global $product;
	global $post;
	
	$product_title = $product->get_name();
	$product_id = $product->get_id();
	$product_sku = $product->get_sku();
	$product_type = $product->get_type();
	
	if($product_type != "custom") {
		return;
	}
	
	$server_name = "http://".$_SERVER["SERVER_NAME"];
	$server_root = $_SERVER["DOCUMENT_ROOT"];
	$server_dir = __DIR__;
	$server_map = str_replace($server_root."/","",$server_dir);
	
	include($server_dir."/settings.inc.php");
	include($server_dir."/custom-css.php");
	
	$img_map = $server_name."/".$server_map."/images";
	$img_bank = "bank.jpg";
	$img_bank_kussens = "bank-kussens.png";
	
	?>
	<div class="bank-display" style="display: none;">
		<div class="art-preview-wrap text-center">
			<div class="art-preview-work">
				<img class="img-fluid" src="<?=$image?>" />
			</div>
			<div class="art-preview-couch" style="text-align: center;">
				<img class="img-fluid" src="<?=$img_map?>/<?=$img_bank?>" />
			</div>
		</div>		
	</div>
	<?php
}
add_action( 'woocommerce_after_single_product_summary', 'pod_product_bank_display', 20 );

function pod_product_bank_format_select() {
	global $product;

	$product_type = $product->get_type();
	
	if($product_type != "artimedes-product") {
		return;
	}
	?>
	<div class="formaat_bank_wrap" style="display: none;"></div>
	<?php
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
	
	$get_list_type = "icons";
	if($get_list_type == "") {
		if($mobile_device == true) {
			$get_list_type = "select";
		} else {
			$get_list_type = "icons";
		}
	}
	
	wc_enqueue_js("
		if($('input[name=list_type]').val() == 'icons') {
			var formaten = [];
			var size_list = ['S','M','L','XL','XX','X'];
		
			$('.option-switch-formaat li').each(function() {
				var li_class = $(this).attr('class');
				if(li_class.indexOf('canvas') != -1) {
					var formaat_text_parts = $(this).text().split(' cm');
					var formaat_text = $.trim(formaat_text_parts[0]);
				
					for ( var i = 0; i < size_list.length; i++ ) {
						formaat_text = formaat_text.replace(size_list[i],'');
					}
					formaten.push(formaat_text);
				}				
			});
		} else {
			var formaten = [];
			var size_list = ['S','M','L','XL','XX','X'];
	
			$('.option-switch-formaat option').each(function() {
				if($(this).attr('class').indexOf('canvas') != -1) {
					var formaat_text = $(this).attr('value');
					formaten.push(formaat_text);
				}
			});
		}
	");
	
	$current_lang = apply_filters('wpml_current_language', NULL);
	if($current_lang == "") {
		$current_lang = "nl";
	}
	
	if($mobile_device == true) {
		?>
		<style>
		.bank-wrap {
			font-size: 8pt;
		}
		</style>
		<?php
	}
	
	if($current_lang == "en") {
		wc_enqueue_js("
			var formaten_html = '';
			formaten_html += '<div class=\'form-flat bank-wrap\'>';
			formaten_html += '<select name=\'formaat_bank\' style=\'width: 110px; margin-bottom: 10px; display: inline-block;\' class=\'formaat_bank\'>';
			for(var f = 0; f < formaten.length; f++) {
				formaten_html += '<option value=\''+formaten[f]+'\'>'+formaten[f]+' cm</option>';
			}
			formaten_html += '</select>';
			formaten_html += '</div>';
			$('.formaat_bank_wrap').html(formaten_html);
		");
	} else {
		wc_enqueue_js("
			var formaten_html = '';
			formaten_html += '<div class=\'form-flat bank-wrap\'>';
			formaten_html += '<select name=\'formaat_bank\' style=\'width: 110px; margin-bottom: 10px; display: inline-block;\' class=\'formaat_bank\'>';
			for(var f = 0;f < formaten.length;f++) {
				formaten_html += '<option value=\''+formaten[f]+'\'>'+formaten[f]+' cm</option>';
			}
			formaten_html += '</select>';
			formaten_html += '</div>';
			$('.formaat_bank_wrap').html(formaten_html);
		");
	}
}
add_action('woocommerce_before_single_product_summary', 'pod_product_bank_format_select', 10);
?>