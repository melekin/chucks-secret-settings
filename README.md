# Chuck's Secret Settings WordPress Plugin

This WordPress plugin adds a new configuration page to the settings menu. It allows users to customize the WordPress password reset email subject and message, as well as the email address and "From" name used by WordPress to send notifications.

## Installation

1. Download the plugin zip file or clone the GitHub repository to your WordPress plugins directory.
2. Activate the plugin through the WordPress Plugins screen.

## Usage

1. Navigate to the WordPress settings menu and click on the "Secret Settings" option.
2. Customize the password reset email subject and message, as well as the email address and "From" name used by WordPress to send notifications.
3. Click "Save Changes" to apply your customizations.

## Filters

This plugin provides the following filters:

- `chucks-secret-settings` - Allows the plugin to be easily extended.
- `retrieve_password_message` - Modifies the password reset email message.
- `retrieve_password_title` - Modifies the password reset email subject.
- `wp_mail_from` - Modifies the email address used by WordPress to send notifications.
- `wp_mail_from_name` - Modifies the "From" name used by WordPress to send notifications.

## Contributions

Contributions to this plugin are welcome. Please submit an issue or pull request on the [GitHub repository](https://github.com/melekin/chucks-secret-settings).

## License

This plugin is licensed under the GPL2 License. See the [LICENSE](https://www.gnu.org/licenses/gpl-2.0.html) file for more details.