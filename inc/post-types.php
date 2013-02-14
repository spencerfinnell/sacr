<?php
/**
 *
 */

/**
 * Post Type Class
 *
 * Handle a lot of the code that stays the same to try 
 * and stay as DRY as possible. Will be expanded upon further
 * as more features are needed.
 *
 * @since St. Augustine Civil Rights Library 1.0
 */
class SACR_Post_Type {
	public $post_type_name;
	public $post_type_slug;
	public $post_type_labels;
	public $post_type_args;
	public $post_type_meta;
	
	/**
	 * Set the default variables, and by default call
	 * the register_post_type() function (as that is the main purpose
	 * of this class). Any other funcitonality has to be called manually.
	 *
	 * @since St. Augustine Civil Rights Library 1.0
	 */
	public function __construct( $name, $args = array(), $labels = array(), $slug = '' ) {
		$this->post_type_name   = $name;
		$this->post_type_args   = $args;
		$this->post_type_labels = $labels;

		if ( '' != $slug )
			$this->post_type_slug = $slug;
		else
			$this->post_type_slug = str_replace( '-', '_', sanitize_title( $this->post_type_name ) );

		$this->register_post_type();

		add_action( 'save_post', array( $this, 'meta_box_save' ), 10, 2 );
	}

	/**
	 * Register the Post Type
	 *
	 * @since St. Augustine Civil Rights Library 1.0
	 */
	private function register_post_type() {
		$singular = $this->post_type_name;

		if ( ! isset( $this->post_type_args[ 'plural' ] ) )
			$plural = $singular . 's';
		else
			$plural = $this->post_type_args[ 'plural' ];

		$labels = wp_parse_args(
			$this->post_type_labels,
			array(
				'name'               => $plural,
				'singular_name'      => $singular,
				'add_new'            => 'Add New',
				'add_new_item'       => sprintf( __( 'Add New %s', 'sacr' ), $singular ),
				'edit_item'          => sprintf( __( 'Edit %s', 'sacr' ), $singular ),
				'new_item'           => sprintf( __( 'New %s', 'sacr' ), $singular ),
				'all_items'          => sprintf( __( 'All %s', 'sacr' ), $plural ),
				'view_item'          => sprintf( __( 'View %s', 'sacr' ), $singular ),
				'search_items'       => sprintf( __( 'Search %s', 'sacr' ), $plural ),
				'not_found'          => sprintf( __( 'No %s found', 'sacr' ), $plural ),
				'not_found_in_trash' => sprintf( __( 'No %s found in the trash', 'sacr' ), $plural ),
				'parent_item_colon'  => '',
				'menu_name'          => $plural
			)
		);

		$args = wp_parse_args(
			$this->post_type_args,
			array(
				'labels'             => $labels,
				'public'             => true,
				'publicly_queryable' => true,
				'show_ui'            => true, 
				'show_in_menu'       => true, 
				'query_var'          => true,
				'rewrite'            => array( 'slug' => $this->post_type_slug ),
				'capability_type'    => 'post',
				'has_archive'        => true, 
				'hierarchical'       => false,
				'menu_position'      => 6,
				'supports'           => array( 'title', 'editor', 'thumbnail' )
			)
		); 

		register_post_type( $this->post_type_slug, $args );

		do_action( 'sacr_register_post_type_' . $this->post_type_slug, $this->post_type_slug, $this->post_type_args );
	}

	/**
	 * Create a Taxonomy
	 *
	 * @since St. Augustine Civil Rights Library 1.0
	 */
	public function register_taxonomy($name, $args = array(), $labels = array()) {
		$name   = $name;
		$slug   = str_replace( '-', '_', sanitize_title( $name ) );
		$plural = $name . 's';  

		$labels = wp_parse_args(
			$labels,
			array(  
				'name'                  => _x( $plural, 'taxonomy general name' ),  
				'singular_name'         => _x( $name, 'taxonomy singular name' ),  
				'search_items'          => __( 'Search ' . $plural ),  
				'all_items'             => __( 'All ' . $plural ),  
				'parent_item'           => __( 'Parent ' . $name ),  
				'parent_item_colon'     => __( 'Parent ' . $name . ':' ),  
				'edit_item'             => __( 'Edit ' . $name ),  
				'update_item'           => __( 'Update ' . $name ),  
				'add_new_item'          => __( 'Add New ' . $name ),  
				'new_item_name'         => __( 'New ' . $name . ' Name' ),  
				'menu_name'             => __( $plural ),  
			)
		);  

		$args = wp_parse_args(  
			$args,
			array(  
				'label'                 => $plural,  
				'labels'                => $labels,  
				'public'                => true,  
				'show_ui'               => true,  
				'show_in_nav_menus'     => true,  
				'_builtin'              => false,  
			)
		);

		register_taxonomy( $this->post_type_slug . '-' . $slug, $this->post_type_slug, $args );
	}

	public function meta_box_save($post_id, $post) {
		if ( empty( $this->post_type_meta ) )
			return $post_id;

		if ( empty( $_POST ) )
			return $post_id;

		/** Don't save when autosaving */
		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) 
			return $post_id;
		
		$meta_keys = apply_filters( 'sacr_post_type_metabox_save', $this->post_type_meta );

		foreach ( $meta_keys as $id => $key ) {
			if ( ! isset( $_POST[$key] ) )
				continue;

			$value = apply_filters( 'sacr_item_meta_' . $key, $_POST[ $key ] );
			
			if ( '' == $key )
				delete_post_meta( $post_id, $key, $value );
			else
				update_post_meta( $post_id, $key, $value );
		}
	}
}