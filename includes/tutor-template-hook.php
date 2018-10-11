<?php

/**
 * TUTOR hook
 */

add_action('tutor_course/archive/before_loop', 'tutor_course_archive_filter_bar');

add_action('tutor_course/archive/before_loop_course', 'tutor_course_loop_before_content');
add_action('tutor_course/archive/after_loop_course', 'tutor_course_loop_after_content');

add_action('tutor_course/loop/thumbnail', 'tutor_course_loop_thumbnail');
add_action('tutor_course/loop/title', 'tutor_course_loop_title');

add_action('tutor_course/loop/before_rating', 'tutor_course_loop_author');
add_action('tutor_course/loop/price', 'tutor_course_loop_price');
add_action('tutor_course/loop/after_price', 'tutor_course_loop_add_to_cart');
add_action('tutor_course/loop/rating', 'tutor_course_loop_rating');
