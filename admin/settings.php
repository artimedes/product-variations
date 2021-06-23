<?php
add_action('admin_menu', 'artimedes_pod_admin_option');
function artimedes_pod_admin_option() {
    add_menu_page( 'Artimedes POD instellingen', 'Artimedes POD', 'manage_options', 'artimedes_pod', 'show_menu_artimedes_pod', 'dashicons-welcome-write-blog' );
}

function show_menu_artimedes_pod () {
    ?>
    <h2>Artimedes POD Settings</h2>
  <!--<form action="options.php" method="post">-->
  <form action="" method="post">
  	<h4>Gevonden producten</h4>
  	<?php
  	$args = array(
        'post_type'		=>	'product',
        'product_type'	=>	'custom'
    );

    $loop = new WP_Query( $args );

    while ( $loop->have_posts() ) : $loop->the_post();
        global $product;
        $product_id = $product->get_id();
        
        $drukfile = get_post_meta($product_id,'artimedes_pod_product_drukfile')[0];
        ?>
        <div style="width: 100%; float: left; margin-bottom: 10px;">
			<div style="width: 35%; float: left;">
				<a href="<?=get_permalink()?>">
					<?=woocommerce_get_product_thumbnail('medium')?><br />
					<?=get_the_title()?>
				</a>
			</div>
			<div style="width: 65%; float: left;">
				<label>Drukfile</label>
				<input type="text" name="artimedes_pod_product_drukfile" value="<?=$drukfile?>">
			</div>
        </div>
        <?php
    endwhile;

    wp_reset_query();
  	?>
    <?php 
    //settings_fields( 'nelio_example_plugin_settings' );
    //do_settings_sections( 'nelio_example_plugin' );
    ?>
    <input
      type="submit"
      name="submit-pod"
      class="button button-primary"
      value="<?php esc_attr_e( 'Save' ); ?>"
    />
  </form>
    <?php
    if(isset($_POST["submit-pod"])) {
    	global $wpdb;
    	
    	$post_artimedes_pod_product_drukfile = $_POST["artimedes_pod_product_drukfile"];
    	$p_query = "
    		UPDATE	wp_postmeta
    		SET		meta_value = '$post_artimedes_pod_product_drukfile'
    		WHERE	meta_key = 'artimedes_pod_product_drukfile'
    		AND		post_id = '$product_id'
    	";
    	$wpdb->get_results($p_query);
    }
}

/*
function nelio_register_settings() {
  register_setting(
    'nelio_example_plugin_settings',
    'nelio_example_plugin_settings',
    'nelio_validate_example_plugin_settings'
  );

  add_settings_section(
    'section_one',
    'Section One',
    'nelio_section_one_text',
    'nelio_example_plugin'
  );

  add_settings_field(
    'some_text_field',
    'Some Text Field',
    'nelio_render_some_text_field',
    'nelio_example_plugin',
    'section_one'
  );

  add_settings_field(
    'another_number_field',
    'Another Number Field',
    'nelio_render_another_number_field',
    'nelio_example_plugin',
    'section_one'
  );
}
add_action( 'admin_init', 'nelio_register_settings' );

function nelio_validate_example_plugin_settings( $input ) {
    $output['some_text_field']      = sanitize_text_field( $input['some_text_field'] );
    $output['another_number_field'] = absint( $input['another_number_field'] );
    // ...
    return $output;
}

function nelio_section_one_text() {
  echo '<p>Tekstveld met info</p>';
}

function nelio_render_some_text_field() {
  $options = get_option( 'nelio_example_plugin_settings' );
  printf(
    '<input type="text" name="%s" value="%s" />',
    esc_attr( 'nelio_example_plugin_settings[some_text_field]' ),
    esc_attr( $options['some_text_field'] )
  );
}

function nelio_render_another_number_field() {
  $options = get_option( 'nelio_example_plugin_settings' );
  printf(
    '<input type="number" name="%s" value="%s" />',
    esc_attr( 'nelio_example_plugin_settings[another_number_field]' ),
    esc_attr( $options['another_number_field'] )
  );
}
*/

/*
VOOR DE MEDIA LIBRARY? ALS ER EEN OPTIE GEMAAKT KAN WORDEN: 'MAAK PRODUCT AAN'
$post_id = wp_insert_post( array(
                'post_title' => $title,
                'post_type' => 'product',
                'post_status' => 'publish',
                'post_content' => $body,
            ));
            $product = wc_get_product( $post_id );
            $product->set_sku( $sku );
            // etc...
            $product->save();
*/

?>