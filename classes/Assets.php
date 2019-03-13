<?php
namespace TUTOR;

if ( ! defined( 'ABSPATH' ) )
	exit;

class Assets{

	public function __construct() {
		add_action('admin_enqueue_scripts', array($this, 'admin_scripts'));
		add_action('wp_enqueue_scripts', array($this, 'frontend_scripts'));
		add_action( 'admin_head', array($this, 'tutor_add_mce_button'));
		add_filter( 'get_the_generator_html', array($this, 'tutor_generator_tag'), 10, 2 );
		add_filter( 'get_the_generator_xhtml', array($this, 'tutor_generator_tag'), 10, 2 );
	}

	public function admin_scripts(){
		wp_enqueue_style('tutor-select2', tutor()->url.'assets/packages/select2/select2.min.css', array(), tutor()->version);
		wp_enqueue_style('tutor-admin', tutor()->url.'assets/css/tutor-admin.css', array(), tutor()->version);

		/**
		 * Scripts
		 */
		wp_enqueue_media();
		wp_enqueue_script('jquery-ui-slider');
		wp_enqueue_script('tutor-select2', tutor()->url.'assets/packages/select2/select2.min.js', array('jquery'), tutor()->version, true );
		wp_enqueue_script('tutor-admin', tutor()->url.'assets/js/tutor-admin.js', array('jquery'), tutor()->version, true );

		$tutor_localize_data = array();
		if ( ! empty($_GET['taxonomy']) && ( $_GET['taxonomy'] === 'course-category' || $_GET['taxonomy'] === 'course-tag') ){
			$tutor_localize_data['open_tutor_admin_menu'] = true;
		}

		wp_localize_script('tutor-admin', 'tutor_data', $tutor_localize_data);
	}

	/**
	 * Load frontend scripts
	 */
	public function frontend_scripts(){
		global $post;

		wp_enqueue_editor();

		$options = tutor_utils()->get_option();
		$localize_data = array(
			'ajaxurl'       => admin_url('admin-ajax.php'),
			'nonce_key'     => tutor()->nonce,
			tutor()->nonce  => wp_create_nonce( tutor()->nonce_action ),
			'options'       => $options,
		);

		if ( ! empty($post->post_type) && $post->post_type === 'tutor_quiz'){
			$quiz_options = tutor_utils()->get_quiz_option($post->ID);
			$localize_data['quiz_options'] = $quiz_options;
		}

		/**
		 * Enabling Sorting, draggable, droppable...
		 */
		wp_enqueue_script('jquery-ui-sortable');

		//Plyr
		wp_enqueue_style( 'tutor-plyr', tutor()->url . 'assets/packages/plyr/plyr.css', array(), tutor()->version );
		wp_enqueue_script( 'tutor-plyr', tutor()->url . 'assets/packages/plyr/plyr.polyfilled.min.js', array( 'jquery' ), tutor()->version, true );

        //Social Share
        wp_enqueue_script( 'tutor-social-share', tutor()->url . 'assets/packages/SocialShare/SocialShare.min.js', array( 'jquery' ), tutor()->version, true );

		//Including player assets if video exists
		if (tutor_utils()->has_video_in_single()) {

			$localize_data['post_id'] = get_the_ID();
			$localize_data['best_watch_time'] = 0;

			$best_watch_time = tutor_utils()->get_lesson_reading_info(get_the_ID(), 0, 'video_best_watched_time');
			if ($best_watch_time > 0){
				$localize_data['best_watch_time'] = $best_watch_time;
			}
		}

		$localize_data = apply_filters('tutor_localize_data', $localize_data);

		if (tutor_utils()->get_option('load_tutor_css')){
			wp_enqueue_style('tutor-frontend', tutor()->url.'assets/css/tutor-front.css', array(), tutor()->version);
		}
		if (tutor_utils()->get_option('load_tutor_js')) {
			wp_enqueue_script( 'tutor-frontend', tutor()->url . 'assets/js/tutor-front.js', array( 'jquery' ), tutor()->version, true );
			wp_localize_script('tutor-frontend', '_tutorobject', $localize_data);
		}
	}

	/**
	 * Add Tinymce button for placing shortcode
	 */
	function tutor_add_mce_button() {
		// check user permissions
		if ( !current_user_can( 'edit_posts' ) && !current_user_can( 'edit_pages' ) ) {
			return;
		}
		// check if WYSIWYG is enabled
		if ( 'true' == get_user_option( 'rich_editing' ) ) {
			add_filter( 'mce_external_plugins', array($this, 'tutor_add_tinymce_js') );
			add_filter( 'mce_buttons', array($this, 'tutor_register_mce_button') );
		}
	}
	// Declare script for new button
	function tutor_add_tinymce_js( $plugin_array ) {
		$plugin_array['tutor_button'] = tutor()->url .'assets/js/mce-button.js';
		return $plugin_array;
	}
	// Register new button in the editor
	function tutor_register_mce_button( $buttons ) {
		array_push( $buttons, 'tutor_button' );
		return $buttons;
	}

	/**
	 * Output generator tag to aid debugging.
	 *
	 * @param string $gen Generator.
	 * @param string $type Type.
	 * @return string
	 */
	function tutor_generator_tag( $gen, $type ) {
		switch ( $type ) {
			case 'html':
				$gen .= "\n" . '<meta name="generator" content="TutorLMS ' . esc_attr( TUTOR_VERSION ) . '">';
				break;
			case 'xhtml':
				$gen .= "\n" . '<meta name="generator" content="TutorLMS ' . esc_attr( TUTOR_VERSION ) . '" />';
				break;
		}
		return $gen;
	}
	
}