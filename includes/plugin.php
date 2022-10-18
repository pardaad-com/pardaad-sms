<?php
include_once( SUNWAY_PATH .  'includes/elementor-fields/fields.php' );
// SunWay actions after submit elementor forms
function sunway_form_action( $form_actions_registrar ) {
	include_once( SUNWAY_PATH .  'includes/elementor-action.php' );
	$form_actions_registrar->register( new SunWay_Action_After_Submit() );
}
add_action( 'elementor_pro/forms/actions/register', 'sunway_form_action' );