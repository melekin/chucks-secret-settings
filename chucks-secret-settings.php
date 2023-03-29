<?php
/**
 * Plugin Name: Chuck's Secret Settings
 * Plugin URI: https://github.com/melekin/chucks-secret-settings
 * Description: Adds a new configuration page to the settings menu
 * Version: 1.1.0
 * Author: Charles Peck
 * Author URI: https://g.dev/chuck
 * License: GPL2
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain: chucks-secret-settings
 */

// Add a new configuration page in the settings menu
function chuck_add_settings_page() {
	add_options_page(
		"Chuck's Secret Settings",
		"Secret Settings",
		"manage_options",
		"chuck_secret_settings",
		"chuck_settings_page"
	);
}
add_action( 'admin_menu', 'chuck_add_settings_page' );

// Display the settings page
function chuck_settings_page() {
?>
	<div class="wrap">
		<h1>Chuck's Secret Settings</h1>
		<form method="post" action="options.php">
			<?php settings_fields( 'chuck_secret_settings_group' ); ?>
			<?php do_settings_sections( 'chuck_secret_settings' ); ?>
			<?php submit_button(); ?>
		</form>
	</div>
<?php
}

// Add the settings fields
function chuck_settings_init() {
	register_setting(
		'chuck_secret_settings_group',
		'chuck_secret_settings_options',
		'chuck_settings_validate'
	);

	add_settings_section(
		'chuck_secret_settings_section',
		'Secret Settings',
		'chuck_settings_section_callback',
		'chuck_secret_settings'
	);

	add_settings_field(
		'chuck_password_reset_subject',
		'Password Reset Email Subject',
		'chuck_password_reset_subject_callback',
		'chuck_secret_settings',
		'chuck_secret_settings_section'
	);

	add_settings_field(
		'chuck_password_reset_message',
		'Password Reset Email Message',
		'chuck_password_reset_message_callback',
		'chuck_secret_settings',
		'chuck_secret_settings_section'
	);
}
add_action( 'admin_init', 'chuck_settings_init' );

// Display the settings section description
function chuck_settings_section_callback() {
	echo '<p>These are the options I expect to customize frequently</p>';
}

// Display the password reset message field
function chuck_password_reset_message_callback() {
	$options = get_option( 'chuck_secret_settings_options' );
	$message = isset( $options['password_reset_message'] ) ? $options['password_reset_message'] : '';

	echo '<textarea name="chuck_secret_settings_options[password_reset_message]" rows="5" cols="50">' . esc_textarea( $message ) . '</textarea>';
}

// Display the password reset subject field
function chuck_password_reset_subject_callback() {
	$options = get_option( 'chuck_secret_settings_options' );
	$subject = isset( $options['password_reset_subject'] ) ? $options['password_reset_subject'] : '';

	echo '<input type="text" name="chuck_secret_settings_options[password_reset_subject]" value="' . esc_attr( $subject ) . '">';
}

// Validate the input data
function chuck_settings_validate( $input ) {
	$input['password_reset_message'] = sanitize_textarea_field( $input['password_reset_message'] );
	$input['password_reset_subject'] = sanitize_text_field( $input['password_reset_subject'] );
	return $input;
}

// Modify the password reset email message
function chuck_modify_password_reset_message( $message, $key, $user_login, $user_data ) {
	$options = get_option( 'chuck_secret_settings_options' );
	$message = isset( $options['password_reset_message'] ) ? $options['password_reset_message'] : '';

	$message = str_replace( '[reset_password_url]', network_site_url( "wp-login.php?action=rp&key=$key&login=" . rawurlencode( $user_login ), 'login' ), $message );
	$message = str_replace( '[site_name]', get_bloginfo( 'name' ), $message );

	return $message;
}
add_filter( 'retrieve_password_message', 'chuck_modify_password_reset_message', 10, 4 );

// Modify the password reset email subject
function chuck_modify_password_reset_subject( $title ) {
	$options = get_option( 'chuck_secret_settings_options' );
	$subject = isset( $options['password_reset_subject'] ) ? $options['password_reset_subject'] : '';

	return $subject;
}
add_filter( 'retrieve_password_title', 'chuck_modify_password_reset_subject' );

// Allow the plugin to be easily extended
do_action( 'chucks-secret-settings' );