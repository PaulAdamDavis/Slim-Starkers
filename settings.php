<?php
// create custom plugin settings menu
add_action('admin_menu', 'slim_create_menu');

function slim_create_menu() {

    //create new top-level menu
    add_menu_page('Slim Settings', 'Slim Settings', 'administrator', __FILE__, 'slim_settings_page');

    //call register settings function
    add_action( 'admin_init', 'register_mysettings' );
}


function register_mysettings() {
    //register our settings
    register_setting( 'slim-settings-group', 'slim_ga_tracking_code' );
}

function slim_settings_page() {
?>
<div class="wrap">
<h2>Slim Settings</h2>

<form method="post" action="options.php">

    <?php settings_fields('slim-settings-group'); ?>
    <table class="form-table">

        <tr valign="top">
        <th scope="row">Google Tracking Code</th>
        <td><input name="slim_ga_tracking_code" value="<?php echo get_option('slim_ga_tracking_code'); ?>" /></td>
        </tr>

    </table>

    <p class="submit">
    <input type="submit" class="button-primary" value="<?php _e('Save Changes') ?>" />
    </p>

</form>
</div>
<?php } ?>