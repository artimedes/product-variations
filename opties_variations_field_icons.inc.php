<div class="option-field">
	<label for="option-product"><?php _e( $lang["materiaal"][$current_lang], 'iconic' ); ?></label>
	<ul class="option-switch option-switch-materiaal">
		<li class="option_li_checked">
			<label class="option-label">
				<input type="radio" class="option_select option-product" id="option-product-canvas" name="option-product" value="canvas" checked>
				<img src="<?=$img_src_canvas_zijkant?>" class="full option-img">
				<span>Canvas</span><br /><span style="font-size: 7pt; color: #777;"><?=$lang["canvas_desc"][$current_lang]?></span>
			</label>
		</li>
		<li class="option_li">
			<label class="option-label">
				<input type="radio" class="option_select option-product" id="option-product-papier" name="option-product" value="papier">
				<img src="<?=$img_src_papier_zijkant?>" class="full option-img">
				<span><?=$lang["aquarelpapier"][$current_lang]?></span><br /><span style="font-size: 7pt; color: #777;"><?=$lang["aquarelpapier_desc"][$current_lang]?></span>
			</label>
		</li>
		<li class="option_li">
			<label class="option-label">
				<input type="radio" class="option_select option-product" id="option-product-dibond" name="option-product" value="dibond">
				<img src="<?=$img_src_dibond_zijkant?>" class="full option-img">
				<span>Dibond</span><br /><span style="font-size: 7pt; color: #777;"><?=$lang["dibond_desc"][$current_lang]?></span>
			</label>
		</li>
	</ul>
	<div style="clear:both"></div>
</div>

<div class="option-field option-field-lijst">
	<label for="option-product"><?php _e( $lang["lijst"][$current_lang], 'iconic' ); ?></label>
	
	<?php
	$img_lijst_geen = $server_name."/".$server_map."/images/lijst-zijkant/lijst-geen-canvas.jpg";
	?>
	
	<ul class="option-switch">
		<li class="option_li_checked lijst-span lijst-geen">
			<label class="option-label">
				<input type="radio" class="option_select option-lijst" id="option-lijst-geen" name="option-lijst" value="geen lijst" checked>
				<img src="<?=$img_lijst_geen?>" class="full option-img option-img-geen">
				<span><?=$lang["geen-lijst"][$current_lang]?></span>
			</label>
		</li>
		
		<?php
		foreach($curl_data_array["select_options"]->select_lijsten as $lijst_product_key=>$lijsten_product) {
			foreach($lijsten_product as $lijst_values) {
				$lijst_key = $lijst_values[0];
				$lijst_value = $lijst_values[1];
				
				$lijst_class = "lijst-".$lijst_product_key;
				$lijst_tag = $lijst_product_key."-".$lijst_key;
				
				$img_lijst = $server_name."/".$server_map."/images/lijst-zijkant/".$lijst_key.".jpg";
				?>
				<li class="option_li lijst-span <?=$lijst_class?>">
					<label class="option-label">
						<input type="radio" class="option_select option-lijst" id="option-lijst-<?=$lijst_tag?>" name="option-lijst" value="<?=$lijst_value?>" >
						<img src="<?=$img_lijst?>" class="full option-img">
						<span><?=$lang[$lijst_key][$current_lang]?></span>
					</label>
				</li>
				<?php		
			}
		}
		?>
	</ul>
	<div style="clear:both"></div>
</div>

<?php
$formaat_array = array();
$formaat_array = $curl_data_array["select_options"]->select_formaten;
?>

<div class="option-field">
	<label for="option-formaat"><?php _e( $lang["formaat"][$current_lang], 'iconic2' ); ?></label>
	<br />
	<?php
	if($current_lang == "en") {
		?>
		<input type="checkbox" name="formaat_inch" class="inch"> Inches
		<?php
	} 
	?>
	
	<ul class="option-switch-formaat">
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
				if(strpos($formaat_key,"papier") !== false and $printformaat != "") {
					$formaat_string_print = "<br /><tag>".$lang["afbeelding"][$current_lang]."<br />".$printformaat." cm</tag>";
				}
				$formaat_string_inch = "<br /><tag class='display_inch'>(".$formaat_inch_x."x".$formaat_inch_y." inch)</tag>";
				?>
				<li class="option_li <?=$option_formaat_size?> <?=$formaat_key?>">
					<label class="option-label">
					<input type="radio" class="option_select option-formaat" id="<?=$formaat_key?>" name="option-formaat" value="<?=$formaat_val?>">
					<span><h3><?=$size_txt?></h3><?=$formaat_string?><?=$formaat_string_inch?><?=$formaat_string_print?></span>
					</label>
				</li>
				<?php
			}
		}
		?>
	</ul>
	<div style="clear:both"></div>
</div>