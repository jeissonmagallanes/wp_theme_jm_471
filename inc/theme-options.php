<?php

//register settings
function theme_settings_init(){
    register_setting( 'theme_settings', 'theme_settings' );
}

//add settings page to menu
function add_settings_page() {
    add_menu_page( __( 'Theme Options' ), __( 'Theme Options' ), 'manage_options', 'settings', 'theme_settings_page');
}

//add actions
add_action( 'admin_init', 'theme_settings_init' );
add_action( 'admin_menu', 'add_settings_page' );

//start settings page
function theme_settings_page() {

    if ( ! isset( $_REQUEST['updated'] ) )
    $_REQUEST['updated'] = false; ?>

    <div>
        <div id="icon-options-general"></div>
        <h2><?php _e( 'Theme Options' ) //your admin panel title ?></h2>

        <?php
        //show saved options message
        if ( false !== $_REQUEST['updated'] ) : ?>
        <div><p><strong><?php _e( 'Options saved' ); ?></strong></p></div>
        <?php endif; ?>

        <form method="post" action="options.php">
            <?php settings_fields( 'theme_settings' ); ?>
            <?php $options = get_option( 'theme_settings' ); ?>

            <table style="text-align:left">

                <!-- Social -->
                <tr><td colspan="2"><strong>SOCIAL:</strong></td></tr>
                <tr valign="top">
                    <th scope="row"><?php _e( 'Facebook' ); ?></th>
                    <td><input style="width:100%" id="theme_settings[ci_facebook]" type="text" size="36" name="theme_settings[ci_facebook]" value="<?php esc_attr_e( $options['ci_facebook'] ); ?>" /></td>
                </tr>
                <tr valign="top">
                    <th scope="row"><?php _e( 'Twitter' ); ?></th>
                    <td><input style="width:100%" id="theme_settings[ci_twitter]" type="text" size="36" name="theme_settings[ci_twitter]" value="<?php esc_attr_e( $options['ci_twitter'] ); ?>" /></td>
                </tr>
                <tr valign="top">
                    <th scope="row"><?php _e( 'Youtube' ); ?></th>
                    <td><input style="width:100%" id="theme_settings[ci_youtube]" type="text" size="36" name="theme_settings[ci_youtube]" value="<?php esc_attr_e( $options['ci_youtube'] ); ?>" /></td>
                </tr>
                <tr valign="top">
                    <th scope="row"><?php _e( 'Instagram' ); ?></th>
                    <td><input style="width:100%" id="theme_settings[ci_instagram]" type="text" size="36" name="theme_settings[ci_instagram]" value="<?php esc_attr_e( $options['ci_instagram'] ); ?>" /></td>
                </tr>
                <tr><td colspan="2"><br></td></tr>
            </table>

            <p><input name="submit" id="submit" value="Save Changes" type="submit"></p>
        </form>

    </div><!-- END wrap -->

<?php
}
//sanitize and validate
function options_validate( $input ) {
    global $select_options, $radio_options;
    if ( ! isset( $input['option1'] ) )
        $input['option1'] = null;
    $input['option1'] = ( $input['option1'] == 1 ? 1 : 0 );
    $input['sometext'] = wp_filter_nohtml_kses( $input['sometext'] );
    if ( ! isset( $input['radioinput'] ) )
        $input['radioinput'] = null;
    if ( ! array_key_exists( $input['radioinput'], $radio_options ) )
        $input['radioinput'] = null;
    $input['sometextarea'] = wp_filter_post_kses( $input['sometextarea'] );
    return $input;
}
?>
