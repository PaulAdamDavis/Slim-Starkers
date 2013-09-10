<?php

    add_action('admin_menu', 'extra_settings_menu');

    function extra_settings_menu() {
        add_menu_page('Extra Settings', 'Extra Settings', 'administrator', 'extra-settings', 'extra_settings_html');
        add_action('admin_init', 'register_mysettings');
    }

    function register_mysettings() {
        register_setting('extra_settings_group', 'ga_tracking_code');
    }

    function extra_settings_html() { ?>
        <div class="wrap">

            <h2>Extra Settings</h2>

            <form method="post" action="options.php">

                <?php settings_fields('extra_settings_group'); ?>

                <table class="form-table">
                    <tr valign="top">
                        <th>Google Tracking UA Code</th>
                        <td><input type="text" name="ga_tracking_code" value="<?php echo get_option('ga_tracking_code'); ?>" placeholder="UA-1234567-89" /></td>
                    </tr>
                </table>

                <p class="submit">
                    <input type="submit" class="button-primary" value="Save Changes" />
                </p>

            </form>

        </div>
    <?php }
