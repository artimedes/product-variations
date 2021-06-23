<?php
if(has_post_thumbnail($post->ID)): 
	$img = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'single-post-thumbnail'); 
endif;
$image = $img[0];

list($image_width, $image_height) = getimagesize($image);
$image_aspect = ($image_width/$image_height);

$plugin_dir = str_replace($server_root,"",plugin_dir_path(__FILE__));
$server_link = "https://".$_SERVER["SERVER_NAME"]."/".$plugin_dir;

?>
<input type="hidden" class="previous-formaat-x-selected">
<?php

wc_enqueue_js("
	var first_formaat = $('.first-formaat').val();
	var bank_breedte_cm = 180;
	
	var list_type = $('input[name=list_type]').val();
	
	var default_formaat_parts = first_formaat.split('x');
	var image_width = '$image_width';
	var image_height = '$image_height';
	
	var border_formats = [25,30,35,40,45,50,55,60,65,70,75,80,85,90,95,100,105,110,115,120,125,130,135];
	var border_sizes = [];
	
	var min_border_px = 1;
	var max_border_px = 4;
	
	var min_size = 20;
	var max_size = 140;
	
	var size_ratio = min_size/max_size;
	
	border_sizes[min_size] = min_border_px;
	
	var num = 0;
	$.each(border_formats, function (index, value) {
		num++;
		var border_size = Number(min_border_px+(size_ratio*num));
		
		if(border_size > 4) { border_sizes[value] = 4; }
		else { border_sizes[value] = border_size; }
	});
	
	border_sizes[max_size] = max_border_px;
	
	$('.formaat_bank option[value='+first_formaat+']').attr('selected','selected');
	
	$('.option_select').change(function() {
		var current_product;
		if(list_type == 'icons') {
			current_product = $('.option-product:checked').val();
		} else {
			current_product = $('.option-switch-materiaal option:selected').val();
		}
		
		if(current_product != 'canvas') {
			$('.formaat_bank option:first').attr('selected','selected');
			$('.formaat_bank_wrap').hide();
			$('.woocommerce-product-gallery__image:first').find('a').removeAttr('href');
			
			$('.art-preview-work img').attr('class','img-fluid');
		} else {
			if($(this).attr('name') != 'option-formaat') {
				$('.formaat_bank_wrap').hide();
				$('.woocommerce-product-gallery__image:first').find('a').removeAttr('href');
			} else {
				$('.formaat_bank_wrap').show();
			}
		}
	});
	
	if(list_type == 'icons') {
		$('.option-lijst').change(function() {
			$('.woocommerce-product-gallery__image').mouseover(function() {
				$('.zoomImg').show();
			});
			
			if($('.option-product:checked').val() == 'canvas') {
				var lijst = $(this).val().replace(' ','-');
				$('.art-preview-work img').attr('class','img-fluid');
			}
		});
		
		$('.option-formaat').change(function() {
			if($('.option-product:checked').val() == 'canvas') {	
				var formaat = $(this).val();
				$('.formaat_bank option[value='+formaat+']').attr('selected','selected');
				formaat_bank_setup(formaat);
				
				$('.woocommerce-product-gallery__image').mouseover(function() {
					$('.zoomImg').hide();
				});
			}
		});	
	}
	
	$('.formaat_bank').click(function() {
		var formaat = $('.formaat_bank option:selected').val();
		formaat_bank_setup(formaat);
	});
	
	$('.formaat_bank').change(function() {
		var formaat = $(this).val();
			
		formaat_bank_setup(formaat);
		
		var product = 'canvas';
		var unique_category = $('input[name=unique_category]').val();
		var product_categorie = $('input[name=product_category]').val();
		var product_tag = $('input[name=product_tag]').val();
		
		var lijst = 'geen-lijst';
		if(list_type == 'icons') {
			$('.option-canvas').removeClass('option_li_checked');
			$('.option-canvas').addClass('option_li');
			$('.canvas-'+formaat).toggleClass('option_li option_li_checked');
			
			if($('.option-lijst:checked').val() != 'geen lijst') {
				lijst = $('.option-lijst:checked').val();
			}
		} else {
			$('.canvas-'+formaat).attr('selected', true);
			
			if($('.option-lijst:selected').val() != 'geen lijst') {
				lijst = $('.option-lijst:selected').val().replace('-',' ');
			}
		}
		
		var formaat_str = formaat.replace('x','-');   
		var lijst_str = lijst.replace(' ','-');   
		
		var custom_img = '';
		
		var sku_orig = $('input[name=category_scode]').val();
		
		var ajax_data_string = 'product='+product;
			ajax_data_string += '&sku='+sku_orig;
			ajax_data_string += '&unique_category='+unique_category;
			ajax_data_string += '&product_categorie='+product_categorie;
			ajax_data_string += '&product_tag='+product_tag;
			ajax_data_string += '&formaat='+formaat;   
			ajax_data_string += '&lijst='+lijst;   
			ajax_data_string += '&custom_img='+custom_img;   
			
		var url = '/wp-content/plugins/artimedes-pod/product_variations.ajax.php';   

		$.ajax({   
			type: 'post',   
			url: url,   
			data: ajax_data_string,   
			dataType: 'json',   
			success: function(data){
				var prijs_string = '<span class=\'woocommerce-Price-amount amount\'>';
				prijs_string += '<span class=\'woocommerce-Price-currencySymbol\'>€</span>';   
				prijs_string += ' '+data.prijs;
				prijs_string += '</span>';
				
				if(formaat == '') {   
					$('.price').html('');
					$('.single_add_to_cart_button').attr('disabled','disabled');   
				} else {   
					$('.price').html(prijs_string);
					$('.single_add_to_cart_button').removeAttr('disabled');   
				}   
				
				$('.custom-price').val(data.prijs);   
				
				$('.sku').text(sku_orig+'-'+formaat);
				$('.custom-sku').val(sku_orig+'-'+formaat);
				
				$('body').trigger('update_checkout');
				$('.product-page-price').show();
				$('.preloader').hide();
				
				if(data.prijs == '0.00') {
					$('.product-page-price').hide();
					$('.quantity').hide();
					$('.single_add_to_cart_button').hide();
					$('.product_meta').hide();
					
					$('.offerte_field').show();
				} else {
					$('.product-page-price').show();
					$('.quantity').show();
					$('.single_add_to_cart_button').show();
					$('.product_meta').show();
					
					$('.offerte_field').hide();
				}
			}   
		});
	});
	
	function formaat_bank_setup(formaat) {
		$('.formaat_bank_wrap').show();
		
		$('.woocommerce-product-gallery__image').mouseover(function() {
			if ( $('.easyzoom-flyout').length ) {
				$('.easyzoom-flyout').hide();
			}
		});
		
		var formaat_parts = formaat.split('x');
		var formaat_x;
		var formaat_y;
	
		if(Number(image_width) > Number(image_height)) {
			formaat_x = formaat_parts[1];
			formaat_y = formaat_parts[0];
		} else {
			formaat_x = formaat_parts[0];
			formaat_y = formaat_parts[1];
		}
	
		var prev_formaat_x_selected = $('.previous-formaat-x-selected').val();
		$('.previous-formaat-x-selected').val(formaat_x);

		var width_perc;
		if(Number(image_width) > Number(image_height)) {
			width_perc = (formaat_x/bank_breedte_cm)*55;
		} else {
			var liggend_factor;
			if(formaat_x < 80) {
				liggend_factor = 1;
			} else if(formaat_x >= 80 && formaat_x < 90) {
				liggend_factor = 0.9;
			} else if(formaat_x >= 90 && formaat_x < 105) {
				liggend_factor = 0.8;
			} else if(formaat_x >= 105 && formaat_x < 135) {
				liggend_factor = 0.75;
			} else if(formaat_x >= 135) {
				liggend_factor = 0.65;
			}
			liggend_factor = liggend_factor/2;
	
			width_perc = (formaat_x/bank_breedte_cm)*(liggend_factor*100);
		}
		$('.art-preview-work img').stop().animate({
			width: width_perc+'%'
		}, 'fast');
		$('.art-preview-work img').css('width',width_perc+'%');
		$('.art-preview-work img').css('bottom','20px');
		
		var border_lijst;
		if(list_type == 'icons') {
			border_lijst = $('.option-lijst:checked').val();
		} else {
			border_lijst = $('.option-lijst:selected').val();
		}
		border_lijst = 'geen lijst';
		
		if(border_lijst != 'geen lijst') {
			$('.art-preview-work img').css('border-width','');
			var border_lijst_px = border_sizes[formaat_x];
			if(border_lijst.indexOf('goud') != -1) {
				var goud_lijst_cm = Number(6);
				var goud_lijst_aspect = goud_lijst_cm/formaat_x;
				
				var goud_lijst_border_perc = width_perc*goud_lijst_aspect;
				$('.art-preview-work img').css('border-width',goud_lijst_border_perc+'%');
			} else {
				var lijst_cm = Number(1);
				var lijst_aspect = lijst_cm/formaat_x;
				
				var lijst_border_perc = width_perc*lijst_aspect;
				$('.art-preview-work img').css('border-width',lijst_border_perc+'%');
				
				var lijst_tussen_cm = Number(0.5);
				var lijst_tussen_aspect = lijst_tussen_cm/formaat_x;
				
				var lijst_tussen_padding_perc = width_perc*lijst_tussen_aspect;
				$('.art-preview-work img').css('padding',lijst_tussen_padding_perc+'%');
			}
		} else {
			$('.art-preview-work img').css('border-width','');
		}
		
		$('.woocommerce-product-gallery__image:first').find('a').html($('.bank-display').html());
		
		var current_img_height_px = $('.art-preview-work img').css('height').replace('px','');
		current_img_height_px = Number(current_img_height_px)+Number(20);
		
		if(current_img_height_px < 150) {
			$('.art-preview-work').stop().animate({
				'min-height': '150px'
			}, 'fast');
			$('.art-preview-work').css('min-height','150px');
		} else {
			$('.art-preview-work').stop().animate({
				'min-height': current_img_height_px+'px'
			}, 'fast');
			$('.art-preview-work').css('min-height',current_img_height_px+'px');	
		}

		var couch_width_perc;
		if(Number(image_width) > Number(image_height)) {
			if(formaat_x < prev_formaat_x_selected) { 
				if(formaat_x >= 130) { couch_width_perc = 90; }
				else { couch_width_perc = 100; }
			} else {
				if(formaat_x < 130) { couch_width_perc = 100; }
				else { couch_width_perc = 90; }
			}
		} else {
			if(formaat_x < prev_formaat_x_selected) {
				var couch_width_perc;
				if(formaat_x < 80) { couch_width_perc = 100; }
				else if(formaat_x >= 80 && formaat_x < 90) { couch_width_perc = 90; }
				else if(formaat_x >= 90 && formaat_x < 105) { couch_width_perc = 80; }
				else if(formaat_x >= 105 && formaat_x < 135) { couch_width_perc = 75; }
				else if(formaat_x >= 135) { couch_width_perc = 65; }
			} else {
				if(formaat_x < 80) { couch_width_perc = 100; }
				else if(formaat_x >= 80 && formaat_x < 90) { couch_width_perc = 90; }
				else if(formaat_x >= 90 && formaat_x < 105) { couch_width_perc = 80; }
				else if(formaat_x >= 105 && formaat_x < 135) { couch_width_perc = 75; }
				else if(formaat_x >= 135) { couch_width_perc = 65; }
			}
		}
		$('.art-preview-couch img').stop().animate({
			width: couch_width_perc+'%'
		}, 'fast');
		$('.art-preview-couch img').css('width',couch_width_perc+'%');
		
		$('.woocommerce-product-gallery__image:first').find('a').html($('.bank-display').html());
		
		var wrap_height = $('.art-preview-wrap').css('height').replace('px','');
		wrap_height = Number(wrap_height)+Number(5);
		$('.flickity-viewport:first').css('height',wrap_height+'px');
	}
");
?>