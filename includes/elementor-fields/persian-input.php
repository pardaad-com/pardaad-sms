<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/*
 * Elementor Form Field - Persian Input
 * Add a new "Persian Input" field to Elementor form widget.
 */
class Elementor_Persian_Input_Field extends \ElementorPro\Modules\Forms\Fields\Field_Base {

	public function get_type() {
		return 'persian-input';
	}
    
	public function get_name() {
		return __( 'SunWay - Only Persian character', 'sunway' );
	}

	public function render( $item, $item_index, $form ) {
		$form->add_render_attribute(
			'input' . $item_index,
			[
				'size' => '1',
				'class' => 'elementor-field-textual',
				'placeholder' => $item['persian-input-placeholder'],
			]
		);

		echo '<input ' . $form->get_render_attribute_string( 'input' . $item_index ) . '>';
	}

	public function update_controls( $widget ) {
		$elementor = \ElementorPro\Plugin::elementor();

		$control_data = $elementor->controls_manager->get_control_from_stack( $widget->get_unique_name(), 'form_fields' );

		if ( is_wp_error( $control_data ) ) {
			return;
		}

		$field_controls = [
			'persian-input-placeholder' => [
				'name' => 'persian-input-placeholder',
				'label' => __('Placeholder'),
				'type' => \Elementor\Controls_Manager::TEXT,
				'dynamic' => [
					'active' => true,
				],
				'condition' => [
					'field_type' => $this->get_type(),
				],
				'tab'          => 'content',
				'inner_tab'    => 'form_fields_content_tab',
				'tabs_wrapper' => 'form_fields_tabs',
			],
		];

		$control_data['fields'] = $this->inject_field_controls( $control_data['fields'], $field_controls );

		$widget->update_control( 'form_fields', $control_data );
	}

	public function validation( $field, $record, $ajax_handler ) {
        $fieldlabel = $field['title'];

		if ( preg_match( '/^[\s\x{0600}-\x{06FF}]*$/u', $field['value'] ) !== 1 ) {
			$ajax_handler->add_error(
				$field['id'],
				__( 'Must be in persian', 'sunway' )
			);
		}
	}

	public function __construct() {
		parent::__construct();
		add_action( 'elementor/preview/init', [ $this, 'editor_preview_footer' ] );
	}

	public function editor_preview_footer() {
		add_action( 'wp_footer', [ $this, 'content_template_script' ] );
	}

	public function content_template_script() {
		?>
		<script>
		jQuery( document ).ready( () => {

			elementor.hooks.addFilter(
				'elementor_pro/forms/content_template/field/<?php echo $this->get_type(); ?>',
				function ( inputField, item, i ) {
					const fieldId    = 'form_field_${i}';
					const fieldClass = 'elementor-field-textual elementor-field ${item.css_classes}';
					const size       = '1';

					return '<input id="${fieldId}" class="${fieldClass}" size="${size}" pattern="${pattern}" title="${title}">';
				}, 10, 3
			);

		});
		</script>
		<?php
	}

}