<?php
/**
 * St. Augustine Civil Rights Library Theme Options
 *
 * @package St. Augustine Civil Rights Library
 * @since St. Augustine Civil Rights Library 1.0
 */

class SACR_Options {
	/**
	 * The option value in the database will be based on get_stylesheet()
	 * so child themes don't share the parent theme's option value.
	 *
	 * @access public
	 * @var string
	 */
	public $option_key = 'sacr_theme_options';

	/**
	 * Holds our options.
	 *
	 * @access public
	 * @var array
	 */
	public $options = array();

	/**
	 * Constructor.
	 *
	 * @access public
	 */
	public function __construct() {
		add_action( 'admin_init', array( $this, 'options_init' ) );
		add_action( 'admin_menu', array( $this, 'add_page' ) );
	}

	/**
	 * Registers the form setting for our options array.
	 *
	 * This function is attached to the admin_init action hook.
	 *
	 * This call to register_setting() registers a validation callback, validate(),
	 * which is used when the option is saved, to ensure that our option values are properly
	 * formatted, and safe.
	 *
	 * @access public
	 *
	 * @return void
	 */
	public function options_init() {
		$this->options = $this->get_theme_options();

		// Register our option group.
		register_setting(
			'sacr_options',
			$this->option_key,
			array( $this, 'validate' )
		);

		// Register our settings field group.
		add_settings_section(
			'general',
			__( 'Pages', 'sacr' ),
			'__return_false',
			'theme_options'
		);

		add_settings_field(
			'map',  
			__( 'Map Page', 'sacr' ),
			array( $this, 'field_select' ),
			'theme_options',
			'general',
			array(
				'name'        => $this->option_key . '[map]',
				'value'       => $this->options[ 'map' ],
				'options'     => sacr_get_pages()
			)
		);

		add_settings_field(
			'timeline',  
			__( 'Timeline Page', 'sacr' ),
			array( $this, 'field_select' ),
			'theme_options',
			'general',
			array(
				'name'        => $this->option_key . '[timeline]',
				'value'       => $this->options[ 'timeline' ],
				'options'     => sacr_get_pages()
			)
		);

		add_settings_section(
			'contentdm',
			__( 'ContentDM', 'sacr' ),
			'__return_false',
			'theme_options'
		);

		add_settings_field(
			'contentdm',  
			__( 'ContentDM Collections', 'sacr' ),
			array( $this, 'field_text' ),
			'theme_options',
			'contentdm',
			array(
				'name'        => $this->option_key . '[contentdm]',
				'value'       => $this->options[ 'contentdm' ]
			)
		);

		add_settings_field(
			'contentdm-oral',  
			__( 'ContentDM Oral Histories', 'sacr' ),
			array( $this, 'field_text' ),
			'theme_options',
			'contentdm',
			array(
				'name'        => $this->option_key . '[contentdm-oral]',
				'value'       => $this->options[ 'contentdm-oral' ]
			)
		);

		add_settings_field(
			'contentdm-film-sound',  
			__( 'ContentDM Film and Sound Recordings', 'sacr' ),
			array( $this, 'field_text' ),
			'theme_options',
			'contentdm',
			array(
				'name'        => $this->option_key . '[contentdm-film-sound]',
				'value'       => $this->options[ 'contentdm-film-sound' ]
			)
		);

		add_settings_field(
			'contentdm-documents',  
			__( 'ContentDM Documents & Historical Artifacts', 'sacr' ),
			array( $this, 'field_text' ),
			'theme_options',
			'contentdm',
			array(
				'name'        => $this->option_key . '[contentdm-documents]',
				'value'       => $this->options[ 'contentdm-documents' ]
			)
		);

		add_settings_field(
			'contentdm-fbi',  
			__( 'ContentDM FBI Files', 'sacr' ),
			array( $this, 'field_text' ),
			'theme_options',
			'contentdm',
			array(
				'name'        => $this->option_key . '[contentdm-fbi]',
				'value'       => $this->options[ 'contentdm-fbi' ]
			)
		);

		add_settings_field(
			'contentdm-images',  
			__( 'ContentDM Photographs & Images', 'sacr' ),
			array( $this, 'field_text' ),
			'theme_options',
			'contentdm',
			array(
				'name'        => $this->option_key . '[contentdm-images]',
				'value'       => $this->options[ 'contentdm-images' ]
			)
		);
	}

	/**
	 * Adds our theme options page to the admin menu.
	 *
	 * This function is attached to the admin_menu action hook.
	 *
	 * @access public
	 *
	 * @return void
	 */
	public function add_page() {
		$theme_page = add_options_page(
			__( 'Theme Settings', 'sacr' ), 
			get_bloginfo( 'name' ),
			'edit_theme_options',
			'theme_options',
			array( $this, 'render_page' )
		);
	}

	/**
	 * Returns the default options.
	 *
	 * @access public
	 *
	 * @return array
	 */
	public function get_default_theme_options() {
		$default_theme_options = array(
			'map'       => '',
			'timeline'  => '',
			'contentdm' => '',
			'contentdm-oral' => '',
			'contentdm-film-sound' => '',
			'contentdm-documents' => '',
			'contentdm-fbi' => '',
			'contentdm-images' => ''
		);

		return apply_filters( 'sacr_default_theme_options', $default_theme_options );
	}

	/**
	 * Returns the options array.
	 *
	 * @access public
	 *
	 * @return array
	 */
	public function get_theme_options() {
		return get_option( $this->option_key, $this->get_default_theme_options() );
	}

	/**
	 * Displays the theme options page.
	 *
	 * @access public
	 *
	 * @return void
	 */
	public function render_page() {
		?>
		<div class="wrap">
			<?php screen_icon(); ?>
			<?php $theme_name = wp_get_theme(); ?>
			<h2><?php printf( __( '%s Theme Options', 'function' ), $theme_name ); ?></h2>
			
			<form method="post" action="options.php">
				<?php
					settings_fields( 'sacr_options' );
					do_settings_sections( 'theme_options' );
					submit_button();
				?>
			</form>
		</div>
		<?php
	}

	/**
	 * Sanitizes and validates form input.
	 *
	 * @see options_init()
	 * @access public
	 * @param array $input
	 *
	 * @return array The validated data.
	 */
	public function validate( $input ) {
		$output = $defaults = $this->get_default_theme_options();

		// Map
		$output[ 'map' ] = absint( $input[ 'map' ] );
		$output[ 'timeline' ] = absint( $input[ 'timeline' ] );

		$urls = array( 'contentdm', 'contentdm-oral', 'contentdm-film-sound', 'contentdm-documents', 'contentdm-fbi', 'contentdm-images' );

		foreach ( $urls as $url ) {
			$output[$url] = esc_url( $input[$url] );
		}

		return apply_filters( 'sacr_options_validate', $output, $input, $defaults );
	}

	/* Standard Fields ***************************************************************/
 
	/**
	 * Number Field
	 */
	function field_text( $args = array() ) {
		$defaults = array(
			'name'        => '',
			'value'       => '',
			'description' => ''
		);
		
		$args = wp_parse_args( $args, $defaults );
		extract( $args );
		
		$id   = esc_attr( $name );
	?>
		<input type="text" name="<?php echo $name; ?>" id="<?php echo $id ?>" value="<?php echo esc_attr( $value ); ?>" class="regular-text" />
		<p class="description"><?php echo $description; ?></p>
	<?php
	} 

	/**
	 * Number Field
	 */
	function field_number( $args = array() ) {
		$defaults = array(
			'min'         => 1,
			'max'         => 100,
			'step'        => 1,
			'name'        => '',
			'value'       => '',
			'description' => ''
		);
		
		$args = wp_parse_args( $args, $defaults );
		extract( $args );
		
		$id   = esc_attr( $name );
	?>
		<label for="<?php echo esc_attr( $id ); ?>">
			<input type="number" min="<?php echo absint( $min ); ?>" max="<?php echo absint( $max ); ?>" step="<?php echo absint( $step ); ?>" name="<?php echo $name; ?>" id="<?php echo $id ?>" value="<?php echo esc_attr( $value ); ?>" />
			<?php echo $description; ?>
		</label>
	<?php
	} 

	/**
	 * Textarea Field
	 */
	function field_textarea( $args = array() ) {
		$defaults = array(
			'name'        => '',
			'value'       => '',
			'description' => ''
		);
		
		$args = wp_parse_args( $args, $defaults );
		extract( $args );
		
		$id   = esc_attr( $name );
	?>
		<label for="<?php echo $id; ?>">
			<textarea name="<?php echo $name; ?>" id="<?php echo $id; ?>" class="code large-text" rows="6" cols="50"><?php echo esc_textarea( $value ); ?></textarea>
			<?php echo $description; ?>
		</label>
	<?php
	} 

	/**
	 * Single Checkbox Field
	 *
	 * @since WooMenu 1.0
	 */
	function field_checkbox_single( $args = array() ) {
		$defaults = array(
			'name'        => '',
			'value'       => '',
			'compare'     => 'on',
			'description' => ''
		);
		
		$args = wp_parse_args( $args, $defaults );
		extract( $args );
		
		$id   = esc_attr( $name );
	?>
		<label for="<?php echo esc_attr( $id ); ?>">
			<input type="checkbox" id="<?php echo $id; ?>" name="<?php echo $name; ?>" value="<?php echo esc_attr( $value ); ?>" <?php checked( $compare, $value ); ?>>
			<?php echo $description; ?>
		</label>
	<?php
	} 

	/**
	 * Radio Field
	 *
	 * @since WooMenu 1.0
	 */
	function field_radio( $args = array() ) {
		$defaults = array(
			'name'        => '',
			'value'       => '',
			'options'     => array(),
			'description' => ''
		);
		
		$args = wp_parse_args( $args, $defaults );
		extract( $args );
		
		$id   = esc_attr( $name );
	?>
		<?php foreach ( $options as $option_id => $option_label ) : ?>
		<label title="<?php echo esc_attr( $option_label ); ?>">
			<input type="radio" name="<?php echo $name; ?>" value="<?php echo $option_id; ?>" <?php checked( $option_id, $value ); ?>>
			<?php echo esc_attr( $option_label ); ?>
		</label>
			<br />
		<?php endforeach; ?>
	<?php
	}

	/**
	 * Select Field
	 *
	 * @since WooMenu 1.0
	 */
	function field_select( $args = array() ) {
		$defaults = array(
			'name'        => '',
			'value'       => '',
			'options'     => array(),
			'description' => ''
		);
		
		$args = wp_parse_args( $args, $defaults );
		extract( $args );
		
		$id   = esc_attr( $name );
	?>
		<label for="<?php echo $id; ?>">
			<select name="<?php echo $name; ?>">
				<?php foreach ( $options as $option_id => $option_label ) : ?>
				<option value="<?php echo esc_attr( $option_id ); ?>" <?php selected( $option_id, $value ); ?>>
					<?php echo esc_attr( $option_label ); ?>
				</option>
				<?php endforeach; ?>
			</select>
			<?php echo $description; ?>
		</label>
	<?php
	}
}

function sacr_get_pages() {
	$output = array();

	foreach ( get_pages() as $page ) {
		$output[ $page->ID ] = $page->post_title;
	}

	return $output;
}

function sacr_get_theme_option( $key = null ) {
	global $sacr_options;

	$options = $sacr_options->get_theme_options();

	if ( ! $key )
		return $options;

	return $options[ $key ];
}