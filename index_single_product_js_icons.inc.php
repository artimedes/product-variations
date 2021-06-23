<?php
wc_enqueue_js("
	var artimedes_check = $('input[name=artimedes-check]').val();
	//if(artimedes_check == 'true') {
		
		var plugin_map = $('input[name=server_name]').val();
		var isMobile = window.matchMedia('only screen and (max-width: 760px)').matches;
		
		$('.usps').hide();
		
		$('.price-wrapper').hide();
		
		$('.option-papier').hide();
		$('.option-dibond').hide(); 
		$('.option-canvas').show();   
		$('.option-canvas:first').find('.option-formaat').prop('checked', true);   

		$('.lijst-span').hide();   
		$('.lijst-geen').show();   
		$('.lijst-canvas').show();
		
		$(document).mousemove(function() {
			if ( $('.easyzoom-flyout').length ) {
				$('.easyzoom-flyout').hide();
			}
		});
		
		$('.preloader').hide();
		$('.preloader').css('background-image','url('+plugin_map+'/images/preloader.gif)');
		
		var unique_category = $('input[name=unique_category]').val();
		
		var current_lang = $('input[name=current-lang]').val();
		
		var product_categorie = $('input[name=product_category]').val();
		var product_tag = $('input[name=product_tag]').val();
		var product_name = $('input[name=product_name]').val();
		
		var list_type = $('input[name=list_type]').val();
		
		var server_name = $('input[name=server_name]').val();
		var image_map = $('input[name=image_map]').val();
		var img_width = '';
		var img_height = '';
		var img_width_side = 1000;
		var img_height_side = 709;
		
		var image_url = $('input[name=image_url]').val();
		var orig_img_width = $('input[name=image_width]').val();
		var orig_img_height = $('input[name=image_height]').val();
		
		var orig_viewport_height = $('.woocommerce-product-gallery__image:first').css('height').replace('px','');//$('.woocommerce-product-gallery__image:first').first($('.wp-post-image')).find('img').attr('height');
		orig_viewport_height = Number(orig_viewport_height)+Number(10);
		var viewport_max_height = 793;
		if((Number(orig_img_width)/Number(orig_img_height)) < 0.6) { viewport_max_height = 823; }
		
		$('.woocommerce-product-gallery__wrapper').find('button').hide();
		
		var default_prijs = $('.custom-price').val();   
		if(default_prijs == '0.00') {
			$('.product-page-price').hide();
			$('.quantity').hide();
			$('.single_add_to_cart_button').hide();
		}
		
		$('.price:first').hide();
		$('.product-border').hide();
		
		var default_prijs_string = '<span class=\'woocommerce-Price-amount amount\'>';
		default_prijs_string += '<span class=\'woocommerce-Price-currencySymbol\'>€</span>';   
		default_prijs_string += ' '+default_prijs;
		default_prijs_string += '</span>';
		
		var scode = $('input[name=category_scode]').val();   
		var geen_lijst_src_noimg = $('.option-img-geen').attr('src').replace('lijst-geen-canvas.jpg','');   
	
		var img_front_orig = $('.woocommerce-product-gallery__image:first').find('a').html();   
		var img_side_orig = $('.woocommerce-product-gallery__image:nth-child(2)').find('a').html();   
		
		//$('.woocommerce-main-image img').attr('src',image_url);
		
		var img_front_orig_src = image_url;//$('.woocommerce-product-gallery__image:first').find('a').attr('href');
		var img_side_orig_src = $('.woocommerce-product-gallery__image:nth-child(2)').find('a').attr('href');    
		
		$('.woocommerce-product-gallery__image:first').find('img').attr('src',img_front_orig_src);
		img_front_orig = $('.woocommerce-product-gallery__image:first').find('a').html();
		
		var img_600px = $('.woocommerce-main-image').attr('href');//$('.flickity-viewport:first').find('img').attr('src');
		//var img_srcset_new = $('.flickity-viewport:first').find('img').attr('srcset');
		//if(img_600px.indexOf('600') != -1) { img_srcset_new = img_srcset_new.replace(img_front_orig_src,img_600px); }
			
		//$('.flickity-viewport:first').find('a').attr('href',img_600px);
		//$('.flickity-viewport:first').find('img').attr('srcset',img_srcset_new);
		
		var cart_url_orig = $('.cart').attr('action');
		
		$.urlParam = function(name){
			var results = new RegExp('[\?&]' + name + '=([^&#]*)').exec(window.location.href);
			if (results==null) {
			   return null;
			}
			return decodeURI(results[1]) || 0;
		}
		
		$('.woocommerce-product-gallery__image:first').find('a').removeAttr('href');
		
		var sku_orig = $('.sku').text();
		
		var sku_init = sku_orig;
		if($('.custom-price').val() != '0.00') { sku_init += '-'+$('.option-formaat:checked').val(); }
		
		$('.sku').text(sku_init);
		$('.custom-sku').val(sku_init);
		
		if(current_lang == 'nl') { $('.product-page-price').append(' <span style=\'font-size: 8pt;\'>Gratis verzending<span>'); }
		
		$('.product-page-price').html('');
		$('p.price').html(default_prijs_string);
		
		$('.woocommerce-product-details__short-description').hide();
		var short_description = $('.woocommerce-product-details__short-description').text();
		var long_description = $('.post-content:nth-child(1)').html();
		/*
		var long_description_parts = long_description.split('</h3>');
		var long_description_head = long_description_parts[0]+'</h3>';
		var long_description_text = long_description_parts[1];
		
		var product_description = '<p><br />'+$.trim(long_description_head);
		product_description += '<div class=\'product-desc-wrap\'>';
		product_description += '<i>'+$.trim(long_description_text)+$.trim(short_description)+'</i></p>';
		product_description += '<span class=\'meta_product_desc\'><h3 class=\'fusion-woocommerce-tab-title fusion-responsive-typography-calculated\'>Giclée</h3>Wordt gedrukt met 12-kleuren UV-licht bestendige pigmentinkten, dankzij deze gepigmenteerde inkten kan een kleurechtheid worden verkregen van meer dan 100 jaar en wordt de hoogste kwaliteit kunstreproductie bereikt.</span>';
		product_description += '</div>';
		
		$('.avada-product-gallery').append(product_description);
		*/
		$('.wc-tabs-wrapper').hide();
		
		var add_to_cart_orig_background = $('.single_add_to_cart_button').css('background-color');
		
		$('.option_select').change(function() {   
			var option_id = this.id;   
			var option_value = this.value;   

			$('.single_add_to_cart_button').attr('disabled','disabled');   
			$('.single_add_to_cart_button').css('background','#CCC');
			
			var product = $('.option-product:checked').val();   
			var formaat = $('.option-formaat:checked').val();   
			
			$('.meta_product_desc').hide();

			if(product == 'canvas') {   
				$('.option-canvas').show();   
				$('.option-papier').hide();
				$('.option-dibond').hide();
				
				$('.meta_product_desc').html('<h3 class=\'fusion-woocommerce-tab-title fusion-responsive-typography-calculated\'>Giclée op canvas</h3>Helderwitte zuurvrij canvas van de hoogste kwaliteit met een fijne natuurlijke structuur zonder pitten of weeffouten waar het gekozen kunstwerk op wordt geprint. De pigmentinkten komen perfect tot hun recht dankzij de kwaliteit van het canvas en het meerdere malen behandelen van het canvas met vernis. Deze extra laag beschermt het doek tegen krasjes of vuil.');
			} else if(product == 'papier') {   
				$('.option-canvas').hide();   
				$('.option-papier').show();
				$('.option-dibond').hide();   
				
				$('.meta_product_desc').html('<h3 class=\'fusion-woocommerce-tab-title fusion-responsive-typography-calculated\'>Giclée op aquarelpapier</h3>Uw Giclée wordt met 12-kleuren UV-licht bestendige pigmentinkten op zuurvrij 320 grams aquarelpapier geprint. Gemaakt van 100% katoen geeft dit FineArt papier een natuurlijke en artistieke uitstraling. De Giclée op aquarelpapier is los te bestellen of ingelijst in bijpassende lijst.');
			} else if(product == 'dibond') {   
				$('.option-canvas').hide();   
				$('.option-papier').hide();   
				$('.option-dibond').show();   
				
				$('.meta_product_desc').html('<h3 class=\'fusion-woocommerce-tab-title fusion-responsive-typography-calculated\'>Giclée op Dibond</h3>Uw Giclée wordt met 12-kleuren UV-licht bestendige pigmentinkten op zuurvrij 260 grams satijn papier geprint om vervolgens te worden gefixeerd op een Dibond plaat. Voor extra bescherming tegen UV-licht, spatjes en vuil wordt de giclée print voorzien van een flinterdunne transparante folielaag. Hierna wordt de print op een sterke 2mm Dibond plaat veredeld en aan de achterkant uitgerust met een U-profiel ophangsysteem. Alu-Dibond bestaat uit een sandwichplaat op basis van twee lagen aluminium en een kernlaag van zwart polyethyleen.');
			}
			
			$('.meta_product_desc').show();
			
			var product_label = '';
			product_label = product;
			$('.option-field-lijst').show();
			
			$('.product-page-price').hide();
			$('.preloader').show();
	
			if(option_id.indexOf('option-product') != -1) {   
				$('.option-'+product_label+':first').find('.option-formaat').prop('checked', true);   
				formaat = $('.option-'+product_label+':first').find('.option-formaat').val();   

				$('.lijst-span').hide();   
				$('.option-lijst:first').show()   

				$('.lijst-geen').show();   
				if(product == 'canvas') {
					$('.lijst-canvas').show();
				}   
				if(product == 'papier') {
					$('.lijst-papier').show();
				}   
				if(product == 'dibond') {
					$('.lijst-dibond').show();
				}   

				var geen_lijst_src = geen_lijst_src_noimg;   
				if(product == 'canvas') {
					geen_lijst_src += 'lijst-geen-canvas.jpg';
				}   
				if(product == 'papier') {
					geen_lijst_src += 'lijst-geen-papier.jpg';
				}   
				if(product == 'dibond') {
					geen_lijst_src += 'lijst-geen-dibond.jpg';
				}   
				$('.option-img-geen').attr('src',geen_lijst_src);   

				$('.option-lijst:first').prop('checked', true);   
			}   
	
			var lijst = 'geen-lijst';   
			if($('.option-lijst:checked').val() != 'geen lijst') {
				lijst = $('.option-lijst:checked').val();
			}   

			var formaat_str = formaat.replace('x','-');   
			var lijst_str = lijst.replace(' ','-');   
			if(lijst_str.indexOf('koloniaal') != -1) {
				lijst_str = 'wissellijst-hout-koloniaal';
			}   

			var img_front = '';   
			var img_side = '';   
		
			var img_src_front = '';
			var img_src_size = '';
			
			var current_viewport_height = $('.woocommerce-product-gallery__image:first').css('height').replace('px','');
			current_viewport_height = Number(current_viewport_height);
			
			if(product == 'papier') {
				if(option_id.indexOf('option-product') != -1) {
					if(Number(orig_img_width) < Number(orig_img_height)) {
						$('.flickity-viewport:first').css('height','679.328px');
					} else {
						$('.flickity-viewport:first').css('height',orig_viewport_height+'px');
					}
				} else {
					if(lijst_str != 'geen-lijst') { 
						if(formaat == '40x60') { $('.flickity-viewport:first').css('height','679.328px'); }
						else { $('.flickity-viewport:first').css('height',current_viewport_height+'px'); }
					} else {
						if(Number(orig_img_width) < Number(orig_img_height)) {
							if(formaat == '40x60') { $('.flickity-viewport:first').css('height',viewport_max_height+'px'); }
							else { $('.flickity-viewport:first').css('height','679.328px'); }
						} else {
							$('.flickity-viewport:first').css('height',orig_viewport_height+'px');
						}
					}
				}
			} else {
				$('.flickity-viewport:first').css('height',orig_viewport_height+'px');
			}
			/*
			if(lijst_str == 'geen-lijst') {   
				if(product == 'papier') {
					if($('input[name=image_width]').val() > $('input[name=image_height]').val()) {
						img_width = 1000;
						if(formaat == '40x60') {
							img_height = 667;
						} else {
							img_height = 750;
						}
					} else {
						if(formaat == '40x60') {
							img_width = 667;
						} else {
							img_width = 750;
						}
						img_height = 1000;
					}
					img_src_front = server_name+'/'+image_map+'/'+scode+'-print-'+formaat_str+'.jpg';
					img_src_side = server_name+'/'+image_map+'/'+scode+'-print-schuin.jpg';
				
					img_front = '<img src=\"'+img_src_front+'\" class=\"attachment-shop_single size-shop_single wp-post-image\" data-caption=\"'+product_name+'\" data-src=\"'+img_src_front+'\" data-large_image=\"'+img_src_front+'\" data-large_image_width=\"'+img_width+'\" data-large_image_height=\"'+img_height+'\" sizes=\"(max-width: 600px) 100vw, 600px\">';
					img_side = '<img src=\"'+img_src_side+'\" class=\"attachment-shop_single size-shop_single wp-post-image\" data-caption=\"'+product_name+'\" data-src=\"'+img_src_side+'\" data-large_image=\"'+img_src_side+'\" data-large_image_width=\"'+img_width_side+'\" data-large_image_height=\"'+img_height_side+'\" sizes=\"(max-width: 600px) 100vw, 600px\">';
				} else if(product == 'dibond') {
					img_src_front = img_front_orig_src;
					img_src_side = server_name+'/'+image_map+'/'+scode+'-dibond-schuin.jpg';
				
					img_front = img_front_orig;   
					img_side = '<img src=\"'+img_src_side+'\" class=\"attachment-shop_single size-shop_single wp-post-image\" data-caption=\"'+product_name+'\" data-src=\"'+img_src_side+'\" data-large_image=\"'+img_src_side+'\" data-large_image_width=\"'+img_width_side+'\" data-large_image_height=\"'+img_height_side+'\" sizes=\"(max-width: 600px) 100vw, 600px\">';  
				} else {
					img_src_front = img_front_orig_src;
					img_src_side = img_side_orig_src;
					
					img_front = img_front_orig;   
					img_side = img_side_orig;   
				}   
			} else {   
				if(product == 'canvas') {
					img_src_front = server_name+'/'+image_map+'/'+scode+'-canvas-'+lijst_str+'.jpg';
					img_src_side = img_side_orig_src;
					
					img_side = img_side_orig;
					
					img_width = $('input[name=image_width]').val();
					img_height = $('input[name=image_height]').val();
				} else if(product == 'papier') {
					if($('input[name=image_width]').val() > $('input[name=image_height]').val()) {
						img_width = 1000;
						img_height = 781;
					} else {
						img_width = 781;
						img_height = 1000;
					}
					
					img_src_front = server_name+'/'+image_map+'/'+scode+'-print-30-40-'+lijst_str+'.jpg';
					img_src_side = server_name+'/'+image_map+'/'+scode+'-print-schuin.jpg';
					
					img_side = '<img src=\"'+img_src_side+'\" class=\"attachment-shop_single size-shop_single wp-post-image\" data-caption=\"'+product_name+'\" data-src=\"'+img_src_side+'\" data-large_image=\"'+img_src_side+'\" data-large_image_width=\"'+img_width_side+'\" data-large_image_height=\"'+img_height_side+'\" sizes=\"(max-width: 600px) 100vw, 600px\">';
				} else if(product == 'dibond') {
					img_src_front = server_name+'/'+image_map+'/'+scode+'-dibond-'+lijst_str+'.jpg';
					img_src_side = server_name+'/'+image_map+'/'+scode+'-dibond-schuin.jpg';
					
					img_side = '<img src=\"'+img_src_side+'\" class=\"attachment-shop_single size-shop_single wp-post-image\" data-caption=\"'+product_name+'\" data-src=\"'+img_src_side+'\" data-large_image=\"'+img_src_side+'\" data-large_image_width=\"'+img_width_side+'\" data-large_image_height=\"'+img_height_side+'\" sizes=\"(max-width: 600px) 100vw, 600px\">';
					
					img_width = $('input[name=image_width]').val();
					img_height = $('input[name=image_height]').val();
				}
				img_front = '<img src=\"'+img_src_front+'\" class=\"attachment-shop_single size-shop_single wp-post-image\" data-caption=\"'+product_name+'\" data-src=\"'+img_src_front+'\" data-large_image=\"'+img_src_front+'\" data-large_image_width=\"'+img_width+'\" data-large_image_height=\"'+img_height+'\" sizes=\"(max-width: 600px) 100vw, 600px\">'; 
			}
			*/
			
			//REWRITE VOOR IMAGES?
			if(product == 'papier') {
				if($('input[name=image_width]').val() > $('input[name=image_height]').val()) {
					img_width = 1000;
					if(formaat == '40x60') {
						img_height = 667;
					} else {
						img_height = 750;
					}
				} else {
					if(formaat == '40x60') {
						img_width = 667;
					} else {
						img_width = 750;
					}
					img_height = 1000;
				}
				img_src_front = server_name+'/'+image_map+'/'+scode+'-print-'+formaat_str+'.jpg';
				img_src_side = server_name+'/'+image_map+'/'+scode+'-print-schuin.jpg';
			
				img_front = '<img src=\"'+img_src_front+'\" class=\"attachment-shop_single size-shop_single wp-post-image\" data-caption=\"'+product_name+'\" data-src=\"'+img_src_front+'\" data-large_image=\"'+img_src_front+'\" data-large_image_width=\"'+img_width+'\" data-large_image_height=\"'+img_height+'\" sizes=\"(max-width: 600px) 100vw, 600px\">';
				img_side = '<img src=\"'+img_src_side+'\" class=\"attachment-shop_single size-shop_single wp-post-image\" data-caption=\"'+product_name+'\" data-src=\"'+img_src_side+'\" data-large_image=\"'+img_src_side+'\" data-large_image_width=\"'+img_width_side+'\" data-large_image_height=\"'+img_height_side+'\" sizes=\"(max-width: 600px) 100vw, 600px\">';
			} else if(product == 'dibond') {
				img_src_front = img_front_orig_src;
				img_src_side = server_name+'/'+image_map+'/'+scode+'-dibond-schuin.jpg';
			
				img_front = img_front_orig;   
				img_side = '<img src=\"'+img_src_side+'\" class=\"attachment-shop_single size-shop_single wp-post-image\" data-caption=\"'+product_name+'\" data-src=\"'+img_src_side+'\" data-large_image=\"'+img_src_side+'\" data-large_image_width=\"'+img_width_side+'\" data-large_image_height=\"'+img_height_side+'\" sizes=\"(max-width: 600px) 100vw, 600px\">';  
			} else {
				img_src_front = img_front_orig_src;
				img_src_side = img_side_orig_src;
				
				img_front = img_front_orig;   
				img_side = img_side_orig;   
			} 
			//REWRITE
			
			
			$('.woocommerce-product-gallery__image:first').find('a').removeAttr('href');
			$('.woocommerce-product-gallery__image:first').find('a').html(img_front);
			//$('.woocommerce-product-gallery__image:nth-child(2)').find('a').attr('href',img_src_side);
			//$('.woocommerce-product-gallery__image:nth-child(2)').find('a').html(img_side);
			
			if((product == 'canvas' || product == 'dibond') && lijst_str == 'geen-lijst') {
				//$('.flickity-viewport:first').find('a').attr('href',img_600px);
				//$('.flickity-viewport:first').find('img').attr('srcset',img_srcset_new);
				$('.woocommerce-main-image').attr('href',img_600px);
			}
			
			$('.woocommerce-product-gallery__image:first').hover(function() {
				$('.woocommerce-product-gallery__image:first').find($('.easyzoom-flyout')).find('img').attr('src',img_src_front);
			});
			$('.woocommerce-product-gallery__image:nth-child(2)').hover(function() {
				$('.woocommerce-product-gallery__image:nth-child(2)').find($('.easyzoom-flyout')).find('img').attr('src',img_src_side);
			});
			
			if(option_id == 'option-lijst') {
				if (isMobile) { window.scrollTo(0, 0); }
			}
			
			var custom_img = '';
			if(product == 'papier') {
				var custom_img = img_src_front;
			}   
			$('.custom-image').val(custom_img);
			
			var ajax_data_string = 'product='+product;
			ajax_data_string += '&sku='+sku_orig;
			ajax_data_string += '&unique_category='+unique_category;
			ajax_data_string += '&product_categorie='+product_categorie;
			ajax_data_string += '&product_tag='+product_tag;
			ajax_data_string += '&formaat='+formaat;   
			ajax_data_string += '&lijst='+lijst;   
			ajax_data_string += '&custom_img='+custom_img;
			ajax_data_string += '&image_url='+image_url;
			
			//var url = '/wp-content/plugins/product-variations/product_variations.ajax.php';
			var url = server_name+'/product_variations.ajax.php';   
			
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
					
					$('.pakket-length').val(data.pakket_length);
					$('.pakket-width').val(data.pakket_width);
					$('.pakket-height').val(data.pakket_height);
					$('.pakket-weight').val(data.pakket_weight);
					
					if(formaat == '') {   
						$('.price').html('');
						$('.single_add_to_cart_button').attr('disabled','disabled');
						$('.single_add_to_cart_button').css('background-color','#CCC'); 
					} else {   
						$('p.price').html(prijs_string);
						$('.single_add_to_cart_button').removeAttr('disabled');
						$('.single_add_to_cart_button').css('background-color',add_to_cart_orig_background);
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
	
		$('.inch').click(function() {   
			if($('.display_inch').is(':visible')) {   
				$('.display_inch').css('display','none');   
			} else {   
				$('.display_inch').css('display','inline');   
			}   
		});   
		
		$('.option-canvas:first').removeClass('option_li'); 
		$('.option-canvas:first').addClass('option_li_checked'); 
		
		$('.option-product').click(function() {   
			var product = $('.option-product:checked').val();   
			
			var product_label = '';
			product_label = product;
			
			$('.option-product').parent().parent().removeClass('option_li_product_checked');
			$('.option-product').parent().parent().removeClass('option_li_product');
			$('.option-product:not(:checked)').parent().parent().addClass('option_li_product');
			$('.option-product:checked').parent().parent().addClass('option_li_product_checked');

			$('.option-formaat').parent().parent().removeClass('option_li_checked');
			$('.option-formaat').parent().parent().addClass('option_li');

			$('.option-'+product_label).removeClass('option_li_checked');
			$('.option-'+product_label).removeClass('option_li');
			$('.option-'+product_label+':not(:first)').addClass('option_li');
			$('.option-'+product_label+':first').addClass('option_li_checked');

			$('.option-lijst').parent().parent().removeClass('option_li_checked');
			$('.option-lijst').parent().parent().removeClass('option_li');
			$('.option-lijst:not(:first)').parent().parent().addClass('option_li'); 
			$('.option-lijst:first').parent().parent().addClass('option_li_checked');    
		});   
	
		$('.option_select').click(function() {   
			var option_name = $(this).attr('name');   
	
			$('.'+option_name).parent().parent().removeClass('option_li_checked');
			$('.'+option_name).parent().parent().removeClass('option_li');
			$('.'+option_name+':not(:checked)').parent().parent().addClass('option_li');
			$('.'+option_name+':checked').parent().parent().addClass('option_li_checked');
		});
		
		$( window ).load(function() {
			$('.option-product').prop('checked', false);
			$('.option-product:first').prop('checked', true);
			$('.option-lijst').prop('checked', false);
			$('.option-lijst:first').prop('checked', true);
			$('.option-formaat').prop('checked', false);
			$('.option-formaat:first').prop('checked', true);
		});
		
		$('.col').click(function() {
			if($(this).is('.first')) {
				if(Number(orig_img_width) < Number(orig_img_height)) {
					if($('.option-product:checked').val() == 'papier') {
						$('.flickity-viewport:first').css('height','679.328px');
					} else {
						$('.flickity-viewport:first').css('height',viewport_max_height+'px');
					}
				} else {
					if($('.option-product:checked').val() == 'papier') {
						$('.flickity-viewport:first').css('height','392px');
					} else {
						$('.flickity-viewport:first').css('height',orig_viewport_height+'px');
					}
				}
			}
		});
	//}
");
?>