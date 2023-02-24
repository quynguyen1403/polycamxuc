<?php

// Add extra profile information
add_action('show_user_profile', 'rt_extra_user_profile_fields');
add_action('edit_user_profile', 'rt_extra_user_profile_fields');

function rt_user_social_medias_arr()
{
    return [
        'twitter' => esc_html__('Twitter', 'gostudy-core'),
        'facebook-f' => esc_html__('Facebook', 'gostudy-core'),
        'instagram' => esc_html__('Instagram', 'gostudy-core'),
        'linkedin-in' => esc_html__('Linkedin', 'gostudy-core'),
        'telegram-plane' => esc_html__('Telegram', 'gostudy-core')
    ];
}

function rt_extra_user_profile_fields($user)
{

    if ( user_can( $user->ID, 'edit_lp_courses' ) ) : ?>
		<h3><?php esc_html_e( 'Instructor Info', 'gostudy-core' ); ?></h3>
		<table class="form-table">
		  <tr>
			<th><label for="occupation"><?php esc_html_e( 'Occupation', 'gostudy-core' ); ?></label></th>
			<td>
				<input type="text" name="occupation" id="occupation" value="<?php echo esc_attr( get_the_author_meta( 'occupation', $user->ID ) ); ?>" class="regular-text" /><br />
				<span class="description"><?php esc_html_e( 'Your area of specialty. Note: can be set for LearnPress Instructors only.', 'gostudy-core' ); ?></span>
			</td>
		  </tr>
		</table>
		<?php
    endif;

    echo '<h3>', esc_html__('Social media accounts', 'gostudy-core'), '</h3>';

    echo '<table class="form-table">';
        foreach (rt_user_social_medias_arr() as $social => $value) {
            ?>
            <tr>
                <th><label for="<?php echo esc_attr($social); ?>" style="text-transform: capitalize;"><?php esc_html_e( $value, 'gostudy-core' ); ?></label></th>
                <td>
                    <input type="text" name="<?php echo esc_attr($social); ?>" id="<?php echo esc_attr($social); ?>" value="<?php echo esc_attr( get_the_author_meta( $social, $user->ID ) ); ?>" class="regular-text" /><br />
                    <span class="description"><?php esc_html_e('Your '.$value.' url.', 'gostudy-core'); ?></span>
                </td>
            </tr>
            <?php
        }
    echo '</table>';
}

add_action('personal_options_update', 'rt_save_extra_user_profile_fields');
add_action('edit_user_profile_update', 'rt_save_extra_user_profile_fields');

function rt_save_extra_user_profile_fields($user_id)
{
    if (!current_user_can('edit_user', $user_id) ) return false;

    if ( current_user_can('edit_lp_courses') ) update_user_meta( $user_id, 'occupation', $_POST['occupation'] );

    foreach (rt_user_social_medias_arr() as $social => $value) {
        update_user_meta( $user_id, $social, $_POST[ $social ] );
    }
}

add_action('wp_head', 'rt_wp_head_custom_code', 1000);
function rt_wp_head_custom_code()
{
    // this code not only js or css / can insert any type of code

    if (class_exists('Gostudy_Theme_Helper')) {
        $header_custom_code = Gostudy_Theme_Helper::get_option('header_custom_js');
    }
    echo isset($header_custom_code) ? "<script>".$header_custom_code."</script>" : '';
}

add_action('wp_footer', 'rt_custom_footer_js', 1000);

function rt_custom_footer_js()
{
    if (class_exists('Gostudy_Theme_Helper')) {
        $custom_js = Gostudy_Theme_Helper::get_option('custom_js');
    }
    echo !empty($custom_js) ? '<script id="rt_custom_footer_js">'.$custom_js.'</script>' : '';
}

// If Redux is running as a plugin, this will remove the demo notice and links
add_action('redux/loaded', 'remove_demo');


/**
 * Removes the demo link and the notice of integrated demo from the redux-framework plugin
 */
if (! function_exists('remove_demo')) {
    function remove_demo()
    {
        // Used to hide the demo mode link from the plugin page. Only used when Redux is a plugin.
        if (class_exists('ReduxFrameworkPlugin')) {
            remove_filter('plugin_row_meta', [
                ReduxFrameworkPlugin::instance(),
                'plugin_metalinks'
            ], null, 2 );

            // Used to hide the activation notice informing users of the demo panel. Only used when Redux is a plugin.
            remove_action( 'admin_notices', [ReduxFrameworkPlugin::instance(), 'admin_notices'] );
        }
    }
}

// Get User IP
if (! function_exists('rt_get_ip')) {
    function rt_get_ip()
    {
        if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
            $ip = $_SERVER['HTTP_CLIENT_IP'];
        } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
        } else {
            $ip = $_SERVER['REMOTE_ADDR'] ?? '0.0.0.0';
        }

        $ip = filter_var( $ip, FILTER_VALIDATE_IP );
        $ip = false === $ip ? '0.0.0.0' : $ip;

        return $ip;
    }
}

