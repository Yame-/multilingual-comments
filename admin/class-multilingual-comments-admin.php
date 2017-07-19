<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       Yame.be
 * @since      1.0.0
 *
 * @package    Multilingual_Comments
 * @subpackage Multilingual_Comments/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Multilingual_Comments
 * @subpackage Multilingual_Comments/admin
 * @author     Yame <yannick@yame.be>
 */
class Multilingual_Comments_Admin {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	public function get_plugin_name(){
		return $this->plugin_name;
	}
	
	public function wpmlc_add_menu_item(){
		add_menu_page(
	        __( 'Multilingual Comments', $this->get_plugin_name() ),
	        'Multilingual Comments',
	        'edit_users',
	        'wpmlc',
	        array($this, 'wpmlc_settings_tab'),
	        'dashicons-nametag', // Dashicons?
	        100
	    );
	}
	
	function wpmlc_settings_tab() {
	    ?>
	    <div class="wrap">
	        <h2>Multilingual Comments</h2>
	        <form action="options.php" method="POST">
		        
		        <?php settings_fields( 'wpmlc-settings-group' ); ?>
	            <?php do_settings_sections( $this->get_plugin_name() ); ?>
	            <?php submit_button(); ?>
		        
	        </form>
	    </div>
	    <?php
	}
	
	function wpmlc_settings_page_init() {
		
	    register_setting( 'wpmlc-settings-group', 'wc_settings_multilingual' );
	    add_settings_section( 'section-one', __( 'Activate Multilingual Comments', $this->get_plugin_name() ), array($this,'section_one_callback'), $this->get_plugin_name() );
	    add_settings_field( 'wc_settings_multilingual', 'Make your choice:', array($this,'wc_settings_multilingual'), $this->get_plugin_name(), 'section-one' );
	    
	}
	
	function section_one_callback() {
	}
	
	function wc_settings_multilingual() {
	    $setting = esc_attr( get_option( 'wc_settings_multilingual' ) );
	    $options = array(
        	0 => __('None', $this->get_plugin_name()),
        	1 => __('Only reviews', $this->get_plugin_name()),
        	2 => __('Only Comments', $this->get_plugin_name()),
        	3 => __('Both', $this->get_plugin_name()),
        );
        
	    echo '<select name="wc_settings_multilingual">';
	    foreach( $options as $value => $option ){
		    $selected = ( $value == $setting ) ? 'selected' : '';
		    echo '<option value="'.$value.'" '.$selected.'>'.$option.'</option>';
	    }
	    echo '</select>';
	}
	
	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Multilingual_Comments_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Multilingual_Comments_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/multilingual-comments-admin.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Multilingual_Comments_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Multilingual_Comments_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/multilingual-comments-admin.js', array( 'jquery' ), $this->version, false );

	}

}
