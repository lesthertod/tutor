<?php
/*
Plugin Name: Tutor
Plugin URI: http://https://themeum.com/tutor
Description: Tutor is a complete solution for creating a Learning Management System in WordPress way. It can help you to create
 courses, lessons and quizzes.
Author: Themeum
Version: 1.0.0
Author URI: http://themeum.com
Requires at least: 4.5
Tested up to: 4.9
Text Domain: tutor
Domain Path: /languages/
*/
if ( ! defined( 'ABSPATH' ) )
	exit;

/**
 * Defined the tutor main file
 */
define('TUTOR_VERSION', '1.0.0');
define('TUTOR_FILE', __FILE__);

if ( ! function_exists('tutor')) {
	function tutor() {
		$info = array(
			'path'              => plugin_dir_path( TUTOR_FILE ),
			'url'               => plugin_dir_url( TUTOR_FILE ),
			'basename'          => plugin_basename( TUTOR_FILE ),
			'version'           => TUTOR_VERSION,
			'nonce_action'      => 'tutor_nonce_action',
			'nonce'             => '_wpnonce',
			'course_post_type'  => apply_filters( 'tutor_course_post_type', 'course' ),
			'lesson_post_type'  => apply_filters( 'tutor_lesson_post_type', 'lesson' ),
			'instructor_role'      => apply_filters( 'tutor_instructor_role', 'tutor_instructor' ),
			'instructor_role_name' => apply_filters( 'tutor_instructor_role_name', __( 'Tutor Instructor', 'tutor' ) ),
			'template_path'     => apply_filters( 'tutor_template_path', 'tutor/' ),
		);

		return (object) $info;
	}
}
include 'classes/init.php';

function tutor_utils(){
	return new \TUTOR\Utils();
}

$tutor = new \TUTOR\init();
$tutor->run(); //Boom