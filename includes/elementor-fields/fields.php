<?php if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

// Add national id number field to forms
function add_national_id_form_field( $form_fields_registrar ) {
	require_once( __DIR__ . '/national-id.php' );
	$form_fields_registrar->register( new \Elementor_National_ID_Field() );
}
add_action( 'elementor_pro/forms/fields/register', 'add_national_id_form_field' );

// Add mobile number field to forms
function add_mobile_number_form_field( $form_fields_registrar ) {
	require_once( __DIR__ . '/mobile-number.php' );
	$form_fields_registrar->register( new \Elementor_Mobile_Number_Field() );
}
add_action( 'elementor_pro/forms/fields/register', 'add_mobile_number_form_field' );

// Add persian input field to forms
function add_persian_input_form_field( $form_fields_registrar ) {
	require_once( __DIR__ . '/persian-input.php' );
	$form_fields_registrar->register( new \Elementor_Persian_Input_Field() );
}
add_action( 'elementor_pro/forms/fields/register', 'add_persian_input_form_field' );