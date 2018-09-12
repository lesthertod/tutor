<?php
namespace LMS;

if ( ! defined( 'ABSPATH' ) )
	exit;


class Utils {

	/**
	 * @param null $key
	 * @param bool $default
	 *
	 * @return array|bool|mixed
	 *
	 * Get option data
	 *
	 * @since v.1.0.0
	 */
	public function get_option($key = null, $default = false){
		$option = (array) maybe_unserialize(get_option('lms_option'));

		if (empty($option) || ! is_array($option)){
			return $default;
		}
		if ( ! $key){
			return $option;
		}
		if (array_key_exists($key, $option)){
			return $option[$key];
		}

		//Access array value via dot notation, such as option->get('value.subvalue')
		if (strpos($key, '.')){
			$option_key_array = explode('.', $key);

			$new_option = $option;
			foreach ($option_key_array as $dotKey){
				if (isset($new_option[$dotKey])){
					$new_option = $new_option[$dotKey];
				}else{
					return $default;
				}
			}

			return $new_option;
		}

		return $default;
	}

	/**
	 * @param null $key
	 * @param array $array
	 *
	 * @return array|bool|mixed
	 *
	 * get array value by dot notation
	 *
	 * @since v.1.0.0
	 *
	 */

	public function avalue_dot($key = null, $array = array()){
		if ( ! $key || ! is_array($array) || ! count($array) ){
			return false;
		}
		$option_key_array = explode('.', $key);

		$value = $array;
		foreach ($option_key_array as $dotKey){
			if (isset($value[$dotKey])){
				$value = $value[$dotKey];
			}else{
				return false;
			}
		}
		return $value;
	}

	/**
	 * @return array
	 *
	 * Get all pages
	 */
	public function get_pages(){
		$pages = array();
		$wp_pages = get_pages();
		if (is_array($wp_pages) && count($wp_pages)){
			foreach ($wp_pages as $page){
				$pages[$page->ID] = $page->post_title;
			}
		}
		return $pages;
	}

	/**
	 * @return string
	 *
	 * Get course archive URL
	 */
	public function course_archive_page_url(){
		$course_page_url = trailingslashit(site_url()).'course';


		$course_archive_page = lms_utils()->get_option('course_archive_page');
		if ($course_archive_page && $course_archive_page !== '-1'){
			$course_page_url = get_permalink($course_archive_page);
		}
		return trailingslashit($course_page_url);
	}

	/**
	 * @param int $student_id
	 *
	 * @return string
	 *
	 * Get student URL
	 */

	public function student_url($student_id = 0){
		$site_url = trailingslashit(site_url()).'student/';
		$user_name = '';

		if ( ! $student_id){
			$student_id = get_current_user_id();
		}

		if ($student_id){

			$user = get_userdata($student_id);
			$user_name = $user->user_login;

		}else{
			$user_name = 'user_name';
		}

		return $site_url.$user_name;

	}

	/**
	 * @return bool
	 *
	 * Check if WooCommerce Activated
	 */

	public function has_wc(){
		return class_exists( 'woocommerce' );
	}

	/**
	 * @return mixed
	 *
	 *
	 */
	public function languages(){
		$language_codes = array(
			'en' => 'English' ,
			'aa' => 'Afar' ,
			'ab' => 'Abkhazian' ,
			'af' => 'Afrikaans' ,
			'am' => 'Amharic' ,
			'ar' => 'Arabic' ,
			'as' => 'Assamese' ,
			'ay' => 'Aymara' ,
			'az' => 'Azerbaijani' ,
			'ba' => 'Bashkir' ,
			'be' => 'Byelorussian' ,
			'bg' => 'Bulgarian' ,
			'bh' => 'Bihari' ,
			'bi' => 'Bislama' ,
			'bn' => 'Bengali/Bangla' ,
			'bo' => 'Tibetan' ,
			'br' => 'Breton' ,
			'ca' => 'Catalan' ,
			'co' => 'Corsican' ,
			'cs' => 'Czech' ,
			'cy' => 'Welsh' ,
			'da' => 'Danish' ,
			'de' => 'German' ,
			'dz' => 'Bhutani' ,
			'el' => 'Greek' ,
			'eo' => 'Esperanto' ,
			'es' => 'Spanish' ,
			'et' => 'Estonian' ,
			'eu' => 'Basque' ,
			'fa' => 'Persian' ,
			'fi' => 'Finnish' ,
			'fj' => 'Fiji' ,
			'fo' => 'Faeroese' ,
			'fr' => 'French' ,
			'fy' => 'Frisian' ,
			'ga' => 'Irish' ,
			'gd' => 'Scots/Gaelic' ,
			'gl' => 'Galician' ,
			'gn' => 'Guarani' ,
			'gu' => 'Gujarati' ,
			'ha' => 'Hausa' ,
			'hi' => 'Hindi' ,
			'hr' => 'Croatian' ,
			'hu' => 'Hungarian' ,
			'hy' => 'Armenian' ,
			'ia' => 'Interlingua' ,
			'ie' => 'Interlingue' ,
			'ik' => 'Inupiak' ,
			'in' => 'Indonesian' ,
			'is' => 'Icelandic' ,
			'it' => 'Italian' ,
			'iw' => 'Hebrew' ,
			'ja' => 'Japanese' ,
			'ji' => 'Yiddish' ,
			'jw' => 'Javanese' ,
			'ka' => 'Georgian' ,
			'kk' => 'Kazakh' ,
			'kl' => 'Greenlandic' ,
			'km' => 'Cambodian' ,
			'kn' => 'Kannada' ,
			'ko' => 'Korean' ,
			'ks' => 'Kashmiri' ,
			'ku' => 'Kurdish' ,
			'ky' => 'Kirghiz' ,
			'la' => 'Latin' ,
			'ln' => 'Lingala' ,
			'lo' => 'Laothian' ,
			'lt' => 'Lithuanian' ,
			'lv' => 'Latvian/Lettish' ,
			'mg' => 'Malagasy' ,
			'mi' => 'Maori' ,
			'mk' => 'Macedonian' ,
			'ml' => 'Malayalam' ,
			'mn' => 'Mongolian' ,
			'mo' => 'Moldavian' ,
			'mr' => 'Marathi' ,
			'ms' => 'Malay' ,
			'mt' => 'Maltese' ,
			'my' => 'Burmese' ,
			'na' => 'Nauru' ,
			'ne' => 'Nepali' ,
			'nl' => 'Dutch' ,
			'no' => 'Norwegian' ,
			'oc' => 'Occitan' ,
			'om' => '(Afan)/Oromoor/Oriya' ,
			'pa' => 'Punjabi' ,
			'pl' => 'Polish' ,
			'ps' => 'Pashto/Pushto' ,
			'pt' => 'Portuguese' ,
			'qu' => 'Quechua' ,
			'rm' => 'Rhaeto-Romance' ,
			'rn' => 'Kirundi' ,
			'ro' => 'Romanian' ,
			'ru' => 'Russian' ,
			'rw' => 'Kinyarwanda' ,
			'sa' => 'Sanskrit' ,
			'sd' => 'Sindhi' ,
			'sg' => 'Sangro' ,
			'sh' => 'Serbo-Croatian' ,
			'si' => 'Singhalese' ,
			'sk' => 'Slovak' ,
			'sl' => 'Slovenian' ,
			'sm' => 'Samoan' ,
			'sn' => 'Shona' ,
			'so' => 'Somali' ,
			'sq' => 'Albanian' ,
			'sr' => 'Serbian' ,
			'ss' => 'Siswati' ,
			'st' => 'Sesotho' ,
			'su' => 'Sundanese' ,
			'sv' => 'Swedish' ,
			'sw' => 'Swahili' ,
			'ta' => 'Tamil' ,
			'te' => 'Tegulu' ,
			'tg' => 'Tajik' ,
			'th' => 'Thai' ,
			'ti' => 'Tigrinya' ,
			'tk' => 'Turkmen' ,
			'tl' => 'Tagalog' ,
			'tn' => 'Setswana' ,
			'to' => 'Tonga' ,
			'tr' => 'Turkish' ,
			'ts' => 'Tsonga' ,
			'tt' => 'Tatar' ,
			'tw' => 'Twi' ,
			'uk' => 'Ukrainian' ,
			'ur' => 'Urdu' ,
			'uz' => 'Uzbek' ,
			'vi' => 'Vietnamese' ,
			'vo' => 'Volapuk' ,
			'wo' => 'Wolof' ,
			'xh' => 'Xhosa' ,
			'yo' => 'Yoruba' ,
			'zh' => 'Chinese' ,
			'zu' => 'Zulu' ,
		);

		return apply_filters('lms/utils/languages', $language_codes);
	}

	public function print_view($value = ''){
		echo '<pre>';
		print_r($value);
		echo '</pre>';
	}

	public function get_courses(){
		global $wpdb;

		$query = $wpdb->get_results("SELECT ID, post_author, post_title, post_name,post_status, menu_order from {$wpdb->posts} WHERE post_status = 'publish' AND post_type = 'course' ");
		return $query;
	}

	public function get_course_count(){
		global $wpdb;

		$count = $wpdb->get_var("SELECT COUNT(ID) from {$wpdb->posts} WHERE post_status = 'publish' AND post_type = 'course'; ");
		return $count;
	}

	public function get_lesson_count(){
		global $wpdb;

		$count = $wpdb->get_var("SELECT COUNT(ID) from {$wpdb->posts} WHERE post_status = 'publish' AND post_type = 'lesson'; ");
		return $count;
	}

	public function get_lesson($course_id = 0){
		if (!$course_id){
			$course_id = get_the_ID();
		}

		$args = array(
			'post_type'  => 'lesson',
			'meta_query' => array(
				array(
					'key'     => '_lms_course_id_for_lesson',
					'value'   => $course_id,
					'compare' => '=',
				),
			),
		);

		$query = new \WP_Query($args);

		return $query;

	}

	public function get_topics($course_id = 0){
		if (!$course_id){
			$course_id = get_the_ID();
		}

		$args = array(
			'post_type'  => 'topics',
			'post_parent'  => $course_id,
			'orderby' => 'menu_order',
			'order'   => 'ASC',
		);

		$query = new \WP_Query($args);

		return $query;
	}

	public function get_lessons_by_topic($topics_id = 0){
		if (!$topics_id){
			$topics_id = get_the_ID();
		}

		$args = array(
			'post_type'  => 'lesson',
			'post_parent'  => $topics_id,
			'orderby' => 'menu_order',
			'order'   => 'ASC',
		);

		$query = new \WP_Query($args);

		return $query;
	}



}