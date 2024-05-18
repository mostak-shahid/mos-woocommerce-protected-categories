<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://www.mdmostakshahid.com
 * @since             1.0.0
 * @package           Mos_Woocommerce_Protected_Categories
 *
 * @wordpress-plugin
 * Plugin Name:       Mos Woocommerce Rotected Categories
 * Plugin URI:        https://www.mdmostakshahid.com/mos-woocommerce-protected-categories
 * Description:       Lock entire WooCommerce categories - restrict access to certain users, user roles, or create a secret password. All products are completely hidden.
 * Version:           1.0.0
 * Author:            Md. Mostak Shahid
 * Author URI:        https://www.mdmostakshahid.com/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       mos-woocommerce-protected-categories
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define( 'MOS_WOOCOMMERCE_PROTECTED_CATEGORIES_VERSION', '1.0.0' );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-mos-woocommerce-protected-categories-activator.php
 */
function mos_woocommerce_protected_categories_activate() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-mos-woocommerce-protected-categories-activator.php';
	Mos_Woocommerce_Protected_Categories_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-mos-woocommerce-protected-categories-deactivator.php
 */
function mos_woocommerce_protected_categories_deactivate() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-mos-woocommerce-protected-categories-deactivator.php';
	Mos_Woocommerce_Protected_Categories_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'mos_woocommerce_protected_categories_activate' );
register_deactivation_hook( __FILE__, 'mos_woocommerce_protected_categories_deactivate' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-mos-woocommerce-protected-categories.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function mos_woocommerce_protected_categories_run() {

	$plugin = new Mos_Woocommerce_Protected_Categories();
	$plugin->run();

}
mos_woocommerce_protected_categories_run();


function mos_woocommerce_protected_categories_add_term_fields( $taxonomy ) {
	?>
  <div class="form-field">
    <label for="mos_woocommerce_protected_categories_custom_meta_data">Custom Meta Data Field</label>
    <input type="text" name="mos_woocommerce_protected_categories_custom_meta_data" id="mos_woocommerce_protected_categories_custom_meta_data" />
    <p>Description for meta field goes here.</p>
  </div>
  <?php
}
 
add_action( 'product_cat_add_form_fields', 'mos_woocommerce_protected_categories_add_term_fields' );

function mos_woocommerce_protected_categories_edit_term_fields( $term, $taxonomy ) {
	$mos_product_cat_visibility = get_term_meta( $term->term_id, 'mos_product_cat_visibility', true )?get_term_meta( $term->term_id, 'mos_product_cat_visibility', true ):"public";
	$mos_product_cat_password = get_term_meta( $term->term_id, 'mos_product_cat_password', true )?get_term_meta( $term->term_id, 'mos_product_cat_password', true ):"";
	$mos_product_cat_users = get_term_meta( $term->term_id, 'mos_product_cat_users', true )?get_term_meta( $term->term_id, 'mos_product_cat_users', true ):[];
	$mos_product_cat_user_roles = get_term_meta( $term->term_id, 'mos_product_cat_user_roles', true )?get_term_meta( $term->term_id, 'mos_product_cat_user_roles', true ):[];

	// var_dump($mos_product_cat_visibility);
	// var_dump($mos_product_cat_password);
	// var_dump($mos_product_cat_users);
	// var_dump($mos_product_cat_user_roles);

	wp_nonce_field('mos_woocommerce_protected_categories_action', 'mos_woocommerce_protected_categories_field');
	$allusers = get_users( array( 'fields' => array( 'ID', 'display_name' ) ) );
	echo '<pre>';
	$role_names = wp_roles()->role_names;
	echo '</pre>';
  ?>
	<tr class="form-field">
		<th>
			<label for="mos_woocommerce_protected_categories_custom_meta_data">Visibility</label>
		</th>
		<td>
			<fieldset id="mos_product_cat_visibility" class="mos-cat-visibility">
				<legend class="screen-reader-text">Visibility</legend>
				<label class="mos-cat-visibility-option"><input type="radio" name="mos_product_cat_visibility" id="mos_public_visibility" value="public" <?php checked($mos_product_cat_visibility, 'public', true) ?>> Public</label>
				
				<label class="mos-cat-visibility-option"><input type="radio" name="mos_product_cat_visibility" id="mos_private_visibility" value="private" <?php checked($mos_product_cat_visibility, 'private', true) ?>> Private</label>					
				
				<label class="mos-cat-visibility-option"><input type="radio" name="mos_product_cat_visibility" id="mos_protected_visibility_pass" value="pass_protected" <?php checked($mos_product_cat_visibility, 'pass_protected', true) ?>> Protected by Password </label>	
				
				<label class="mos-cat-visibility-option"><input type="radio" name="mos_product_cat_visibility" id="mos_protected_visibility_user_roles" value="user_role_protected" <?php checked($mos_product_cat_visibility, 'user_role_protected', true) ?>> Password Protected by User roles</label>	

				<label class="mos-cat-visibility-option"><input type="radio" name="mos_product_cat_visibility" id="mos_protected_visibility_users" value="user_protected" <?php checked($mos_product_cat_visibility, 'user_protected', true) ?>> Password Protected by User</label>
				<div class="mos-cat-protection-type mos-cat-protection-type-password">
					<input class="mos-cat-password-field mos_product_cat_password" name="mos_product_cat_password" id="mos_product_cat_password" type="text" placeholder="Enter password…" value="<?php echo esc_html($mos_product_cat_password) ?>">
				</div>				

				<div class="mos-cat-protection-type mos-cat-protection-type-user-roles">
					<select name="mos_product_cat_user_roles[]" id="mos_product_cat_user_roles" class="select2 mos-cat-protection-select mos_product_cat_user_roles" multiple>
						<?php foreach($role_names as $key=>$value) : ?>
							<option value="<?php echo esc_html($key) ?>" <?php echo (in_array($key, $mos_product_cat_user_roles))?'selected':'' ?>><?php echo esc_html($value) ?></option>
						<?php endforeach?>
					</select>
				</div>
				<div class="mos-cat-protection-type mos-cat-protection-type-user">
					<select name="mos_product_cat_users[]" id="mos_product_cat_users" class="select2 mos-cat-protection-select mos_product_cat_users" multiple>
						<?php foreach ( $allusers as $user ) : ?>
							<option value="<?php echo esc_html($user->ID) ?>" <?php echo (in_array($user->ID, $mos_product_cat_users))?'selected':'' ?>><?php echo esc_html($user->display_name) ?></option>
						<?php endforeach?>					
					</select>
				</div>
			</fieldset>
		</td>
	</tr>
  <?php
}

add_action( 'product_cat_edit_form_fields', 'mos_woocommerce_protected_categories_edit_term_fields', 10, 2 );

function mos_woocommerce_protected_categories_save_term_fields( $term_id ) {

	if (!isset($_POST['mos_woocommerce_protected_categories_field']) || !wp_verify_nonce(sanitize_text_field(wp_unslash($_POST['mos_woocommerce_protected_categories_field'])), 'mos_woocommerce_protected_categories_action')) {
		return;
	} 
	update_term_meta($term_id,'mos_product_cat_visibility',sanitize_text_field($_POST['mos_product_cat_visibility']));
	update_term_meta($term_id,'mos_product_cat_password',sanitize_text_field($_POST['mos_product_cat_password']));
	update_term_meta($term_id,'mos_product_cat_users',$_POST['mos_product_cat_users']);
	update_term_meta($term_id,'mos_product_cat_user_roles',$_POST['mos_product_cat_user_roles']);
}

add_action( 'created_product_cat', 'mos_woocommerce_protected_categories_save_term_fields' );
add_action( 'edited_product_cat', 'mos_woocommerce_protected_categories_save_term_fields' );