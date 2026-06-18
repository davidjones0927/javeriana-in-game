<?php
/**
 * Extension functions and defination
 *
 */
defined( 'ABSPATH' ) || exit;

/**
 * Check if Image Masking is enabled
 *
 * @return bool
 */
function hapro_is_image_masking_enabled() {
	return apply_filters( 'happyaddons/extensions/image_masking', true );
}

/**
 * Check if Display Condition is enabled
 *
 * @return bool
 */
function hapro_is_display_condition_enabled() {
	return apply_filters( 'happyaddons/extensions/display_condition', true );
}

/**
 * Check if Happy Particle Effects is enabled
 *
 * @return bool
 */
function hapro_is_happy_particle_effects_enabled() {
	return apply_filters( 'happyaddons/extensions/happy_particle_effects', true );
}

/**
 * Check if Happy Global Badge is enabled
 *
 * @return bool
 */
function hapro_is_happy_global_badge_enabled() {
	return apply_filters( 'happyaddons/extensions/happy_global_badge', true );
}

/**
 * Check if Preset is enabled
 *
 * @return bool
 */
function hapro_is_preset_enabled() {
	return apply_filters( 'happyaddons/extensions/preset', true );
}

/**
 * Check if Happy Multi Layer Parallax is enabled
 *
 * @return bool
 */
function hapro_is_happy_multi_layer_parallax_enabled() {
	return apply_filters( 'happyaddons/extensions/happy_multi_layer_parallax', true );
}
