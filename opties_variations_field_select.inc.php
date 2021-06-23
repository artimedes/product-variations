<div class="option-field">
	<label for="option-product"><?php _e($lang["materiaal"][$current_lang], 'iconic'); ?></label>
	
	<select name="option-product" class="option_select option-switch option-switch-materiaal">
		<option class="option_select option-product" id="option-product-canvas" value="canvas">Canvas</option>
		<option class="option_select option-product" id="option-product-papier" value="papier"><?=$lang["aquarelpapier"][$current_lang]?></option>
		<option class="option_select option-product" id="option-product-dibond" value="dibond">Dibond</option>
	</select>
	<div style="clear:both"></div>
</div>

<div class="option-field option-field-lijst">
	<label for="option-product"><?php _e($lang["lijst"][$current_lang], 'iconic'); ?></label>
	
	<select name="option-lijst" class="option_select option-switch">
		<option class="option_select option-lijst" id="option-lijst-geen" value="geen lijst"><?=$lang["geen-lijst"][$current_lang]?></option>
		<?php
		foreach($curl_data_array["select_options"]->select_lijsten as $lijst_product_key=>$lijsten_product) {
			foreach($lijsten_product as $lijst_values) {
				$lijst_key = $lijst_values[0];
				$lijst_value = $lijst_values[1];
				
				$lijst_class = "lijst-".$lijst_product_key;
				$lijst_tag = $lijst_product_key."-".$lijst_key;
				?>
				<option class="option_select option-lijst <?=$lijst_class?>" id="option-lijst-<?=$lijst_tag?>" value="<?=$lijst_key?>"><?=$lang[$lijst_key][$current_lang]?></option>
				<?php
			}
		}
		?>
	</select>
	<div style="clear:both"></div>
</div>

<?php
$formaat_array = array();
$formaat_array = $curl_data_array["select_options"]->select_formaten;
?>

<style>
.product-footer { margin-top: 10px; }
</style>

<div class="option-field">
	<label for="option-formaat"><?php _e($lang["formaat"][$current_lang], 'iconic2'); ?></label>
	<?php
	if($current_lang == "en") {
		?>
		<input type="checkbox" name="formaat_inch" class="inch"> Inches
		<?php
	}
	?>
	<select name="option-formaat" class="option_select option-switch-formaat">
		<?php
		$formaat_s_array = array();
		$formaat_m_array = array();
		
		foreach($formaat_array as $formaat_key_txt=>$formaat_values) {
			foreach($formaat_values as $formaat_val) {
				$formaat_key = "option-".$formaat_key_txt." ".$formaat_key_txt."-".$formaat_val;
			
				if(strpos($formaat_key,"papier") !== false) {
					$print_query = "";
					$printformaat = "";
				}
			
				$inch_factor = "0.393700787";
				$formaat_parts = explode("x",$formaat_val);
				$formaat_inch_x = round(($formaat_parts[0]*$inch_factor),2);
				$formaat_inch_y = round(($formaat_parts[1]*$inch_factor),2);
	
				$size_m2 = $formaat_parts[0]*$formaat_parts[1]/10000;
				if($size_m2 <= 0.16) {
					$size_txt = "S";
				} else if($size_m2 > 0.16 and $size_m2 <= 0.36) {
					$size_txt = "M";
				} else if($size_m2 > 0.36 and $size_m2 <= 0.64) {
					$size_txt = "L";
				} else if($size_m2 > 0.64 and $size_m2 <= 1.2) {
					$size_txt = "XL";
				} else {
					$size_txt = "XXL";
				}
	
				if(strpos($formaat_key,"canvas") !== false) {
					$option_formaat_size = "option_canvas_formaat_".strtolower($size_txt);
				} else {
					$option_formaat_size = "option_papier_formaat_".strtolower($size_txt);
				}
	
				if(strpos($formaat_key,"canvas") !== false) {
					if($size_txt == "S") {
						$standard_formaat_s = $formaat_parts[0]."x".$formaat_parts[1];
						$formaat_s_array[] = $standard_formaat_s;
					}
					if($size_txt == "M") {
						$standard_formaat_m = $formaat_parts[0]."x".$formaat_parts[1];
						$formaat_m_array[] = $standard_formaat_m;
					}
				}
			
				$formaat_string = $formaat_parts[0]."x".$formaat_parts[1]." cm ";
				$formaat_string_print = "";
			
				$formaat_key_parts = explode(" ",$formaat_key);
				$formaat_id = $formaat_key_parts[1];
				?>
				<option class="option_select option-formaat <?=$option_formaat_size?> <?=$formaat_key?>" id="<?=$formaat_id?>" value="<?=$formaat_val?>"><?=$formaat_string?></option>
				<?php 
			}
		}
		?>		
	</select>
	<div style="clear:both"></div>
</div>