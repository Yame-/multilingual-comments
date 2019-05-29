<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       Yame.be
 * @since      1.0.0
 *
 * @package    Multilingual_Comments
 * @subpackage Multilingual_Comments/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Multilingual_Comments
 * @subpackage Multilingual_Comments/public
 * @author     Yame <yannick@yame.be>
 */
class Multilingual_Comments_Public {

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
	 * @param      string    $plugin_name       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
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

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/multilingual-comments-public.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
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

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/multilingual-comments-public.js', array( 'jquery' ), $this->version, false );

	}
	
	public function wpmlc_should_i_run(){
		$multicomment = get_option('wc_settings_multilingual');

		if( $multicomment == 0 ){
			return false;
		}
		
		// When user is viewing admin dashboard
		if( is_admin() ){
			return false;
		}

		// Only reviews
		if( 1 == $multicomment && !is_product() ){
			return false;
		}

		// Only comments
		if( 2 == $multicomment && is_product() ){
			return false;
		}
		
		return true;
	}

	/**
	 * Merge all language comments together
	 *
	 * @since 	 1.0.0
	 */
	public function wpmlc_merge_wpml_comments( $arr ){
		global $wpdb;
		
		if( false === $this->wpmlc_should_i_run() ){
			return $arr;
		}

		// Get all active languages
		$languages = $wpdb->get_results("SELECT code FROM {$wpdb->prefix}icl_languages WHERE active=1", ARRAY_A);

		$lang_ids = [];
		// Foreach active language get the post_id
		foreach( $languages as $lang ){
			$lang_ids[] = "comment_post_ID = '".icl_object_id(get_the_ID(),'product',false,$lang['code'])."'";
		}

		// Edit the query to include all 'post_id's'
		$arr['where'] = str_replace("AND icltr2.language_code = '".ICL_LANGUAGE_CODE."'", '', $arr['where']);
		$arr['where'] = str_replace("AND comment_post_ID = ".get_the_ID()."", '', $arr['where']);

		$arr['where'] .= ' AND ('.implode(" OR ", $lang_ids).')';
		
		return $arr;
	}
	
	function wpmlc_change_rating_counts($count){
		
		if( false === $this->wpmlc_should_i_run() ){
			return $count;
		}
		
		$count = array();
		$comments = get_comments();
		foreach( $comments as $comment ){
			
			$rating = get_comment_meta( $comment->comment_ID, 'rating', true );
			if( isset($count[$rating]) ){
				$count[$rating] += 1;
			} else {
				$count[$rating] = 1;
			}
			
		}
		return $count;
	}
	
	function wpmlc_change_review_count($count){
		
		if( false ===  $this->wpmlc_should_i_run() ){
			return $count;
		}
		
		$count = count(get_comments());
		return $count;
	}
	
	function wpmlc_change_average_rating($average_rating){
		
		if( false ===  $this->wpmlc_should_i_run() ){
			return $average_rating;
		}	
		
		$rating = 0;
		$comments = get_comments();

        if( count( $comments ) == 0 ){
            return $rating;
        }

		foreach( $comments as $comment ){
			
			$rating += get_comment_meta( $comment->comment_ID, 'rating', true );
			
		}
		
		$average_rating = $rating / count($comments);
		return $average_rating;
		
	}
	
	function wpmlc_change_comment_number($count){
		
		if( false ===  $this->wpmlc_should_i_run() ){
			return $count;
		}
		
		return count( get_comments() );
	}

}
