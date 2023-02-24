<?php

namespace CHT\frontend;

use CHT\admin\CHT_PRO_Admin_Base;
use CHT\admin\CHT_PRO_Social_Icons;
use CHT\admin\CHT_Social_Icons;

if (!defined('ABSPATH')) {
    exit;
}

$admin_base = CHT_PRO_ADMIN_INC.'/class-admin-base.php';
require_once $admin_base;

$social_icons = CHT_PRO_ADMIN_INC.'/class-social-icons.php';
require_once $social_icons;

class CHT_PRO_Frontend extends CHT_PRO_Admin_Base
{

    public $widget_number = "";

    public $inline_css = "";

    public $widget_settings = [];

    public $chaty_settings = [];

    public $hasFont = false;


    /**
     * constructor.
     */
    public function __construct()
    {
        $this->socials = CHT_PRO_Social_Icons::get_instance()->get_icons_list();
        // collecting default social media icons
        if (wp_doing_ajax()) {
            // initialize function it is AJAX request
            add_action('wp_ajax_choose_social', [$this, 'choose_social_handler']);
            // return setting for a social media in html
            add_action('wp_ajax_get_chaty_settings', [$this, 'get_chaty_settings']);
            // return setting for a social media in html
            add_action('wp_ajax_remove_chaty_widget', [$this, 'remove_chaty_widget']);
            // remove social media widget
            add_action('wp_ajax_rename_chaty_widget', [$this, 'rename_chaty_widget']);
            // rename social media widget
            add_action('wp_ajax_change_chaty_widget_status', [$this, 'change_chaty_widget_status']);
            // remove social media widget
        }

        // save contact form submit data
        add_action('wp_ajax_chaty_front_form_save_data', [$this, 'chaty_front_form_save_data']);
        add_action('wp_ajax_nopriv_chaty_front_form_save_data', [$this, 'chaty_front_form_save_data']);

        // update channel widget views
        add_action('wp_ajax_update_chaty_widget_views', [$this, 'update_chaty_widget_views']);
        add_action('wp_ajax_nopriv_update_chaty_widget_views', [$this, 'update_chaty_widget_views']);

        // update channel widget views
        add_action('wp_ajax_update_chaty_channel_views', [$this, 'update_chaty_channel_views']);
        add_action('wp_ajax_nopriv_update_chaty_channel_views', [$this, 'update_chaty_channel_views']);

        // update channel widget views
        add_action('wp_ajax_update_chaty_widget_click', [$this, 'update_chaty_widget_click']);
        add_action('wp_ajax_nopriv_update_chaty_widget_click', [$this, 'update_chaty_widget_click']);

        // update channel widget views
        add_action('wp_ajax_update_chaty_channel_click', [$this, 'update_chaty_channel_click']);
        add_action('wp_ajax_nopriv_update_chaty_channel_click', [$this, 'update_chaty_channel_click']);

        $in_editors = $this->check_for_editors();
        if (!($in_editors)) {
            add_action('wp_enqueue_scripts', [$this, 'cht_front_end_css_and_js']);
        }

    }//end __construct()


    function chaty_front_form_save_data()
    {
        $response = [
            'status'  => 0,
            'error'   => 0,
            'errors'  => [],
            'message' => '',
        ];
        $postData = filter_input_array(INPUT_POST);
        if (isset($postData['nonce']) && isset($postData['widget']) && (wp_verify_nonce($postData['nonce'], "chaty-front-form".$postData['widget']) || $postData['nonce'] == wp_create_nonce("chaty_widget_nonce".$postData['widget']))) {
            $name    = isset($postData['name']) ? $postData['name'] : "";
            $email   = isset($postData['email']) ? $postData['email'] : "";
            $message = isset($postData['message']) ? $postData['message'] : "";
            $phone   = isset($postData['phone']) ? $postData['phone'] : "";
            $ref_url = isset($postData['ref_url']) ? $postData['ref_url'] : "";
            $widget  = $postData['widget'];
            $channel = $postData['channel'];

            $value = get_option('cht_social'.$widget.'_'.$channel);
            // get saved settings for button
            $errors = [];
            if (!empty($value)) {
                $field_setting = isset($value['name']) ? $value['name'] : [];
                if (isset($field_setting['is_active']) && $field_setting['is_active'] == "yes" && isset($field_setting['is_required']) && $field_setting['is_required'] == "yes" && empty($name)) {
                    $error    = [
                        'field'   => 'chaty-field-name',
                        'message' => esc_attr("this field is required", 'chaty'),
                    ];
                    $errors[] = $error;
                }

                $field_setting = isset($value['phone']) ? $value['phone'] : [];
                if (isset($field_setting['is_active']) && $field_setting['is_active'] == "yes" && isset($field_setting['is_required']) && $field_setting['is_required'] == "yes" && empty($phone)) {
                    $error    = [
                        'field'   => 'chaty-field-phone',
                        'message' => esc_attr("this field is required", 'chaty'),
                    ];
                    $errors[] = $error;
                }

                $field_setting = isset($value['email']) ? $value['email'] : [];
                if (isset($field_setting['is_active']) && $field_setting['is_active'] == "yes" && isset($field_setting['is_required']) && $field_setting['is_required'] == "yes") {
                    if (empty($email)) {
                        $error    = [
                            'field'   => 'chaty-field-name',
                            'message' => esc_attr("this field is required", 'chaty'),
                        ];
                        $errors[] = $error;
                    } else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                        $error    = [
                            'field'   => 'chaty-field-email',
                            'message' => esc_attr("email address is not valid", 'chaty'),
                        ];
                        $errors[] = $error;
                    }
                }

                $field_setting = isset($value['message']) ? $value['message'] : [];
                if (isset($field_setting['is_active']) && $field_setting['is_active'] == "yes" && isset($field_setting['is_required']) && $field_setting['is_required'] == "yes" && empty($message)) {
                    $error    = [
                        'field'   => 'chaty-field-message',
                        'message' => esc_attr("this field is required", 'chaty'),
                    ];
                    $errors[] = $error;
                }

                if (empty($errors)) {
                    $widget = trim($widget, "_");
                    $response['message']          = esc_html($value['thanks_message']);
                    $response['redirect_action']  = esc_sql($value['redirect_action']);
                    $response['redirect_link']    = esc_url($value['redirect_link']);
                    $response['link_in_new_tab']  = esc_attr($value['link_in_new_tab']);
                    $response['close_form_after'] = esc_attr($value['close_form_after']);
                    $response['close_form_after_seconds'] = esc_attr($value['close_form_after_seconds']);
                    $send_leads_in_email = $value['send_leads_in_email'];
                    $save_leads_locally  = $value['save_leads_locally'];

                    date_default_timezone_set(get_option('timezone_string'));
                    $new_date = date("Y-m-d H:i:s");

                    if ($save_leads_locally == "yes") {
                        global $wpdb;
                        $chaty_table   = $wpdb->prefix.'chaty_contact_form_leads';
                        $insert        = [];
                        $field_setting = isset($value['name']) ? $value['name'] : [];
                        if (isset($field_setting['is_active']) && $field_setting['is_active'] == "yes") {
                            $insert['name'] = esc_sql(sanitize_text_field($name));
                        }

                        $field_setting = isset($value['email']) ? $value['email'] : [];
                        if (isset($field_setting['is_active']) && $field_setting['is_active'] == "yes") {
                            $insert['email'] = esc_sql(sanitize_text_field($email));
                        }

                        $field_setting = isset($value['phone']) ? $value['phone'] : [];
                        if (isset($field_setting['is_active']) && $field_setting['is_active'] == "yes") {
                            $insert['phone_number'] = esc_sql(sanitize_text_field($phone));
                        }

                        $field_setting = isset($value['message']) ? $value['message'] : [];
                        if (isset($field_setting['is_active']) && $field_setting['is_active'] == "yes") {
                            $insert['message'] = esc_sql(sanitize_text_field($message));
                        }

                        $insert['ref_page']   = esc_url(esc_sql($ref_url));
                        $insert['ip_address'] = $this->get_user_ipaddress();
                        $insert['widget_id']  = esc_sql(sanitize_text_field($widget));
                        $insert['created_on'] = esc_sql($new_date);
                        $wpdb->insert($chaty_table, $insert);
                    }//end if

                    if ($send_leads_in_email == "yes") {
                        $mail_content  = "";
                        $mail_content .= "<table cellspacing='0' cellpadding='0' border='0' >";
                        $field_setting = isset($value['name']) ? $value['name'] : [];
                        if (isset($field_setting['is_active']) && $field_setting['is_active'] == "yes") {
                            $mail_content .= "<tr>";
                            $mail_content .= "<th align='left'>Name: </th>";
                            $mail_content .= "<td>".esc_attr($name)."</td>";
                            $mail_content .= "</tr>";
                        }

                        $field_setting = isset($value['email']) ? $value['email'] : [];
                        if (isset($field_setting['is_active']) && $field_setting['is_active'] == "yes") {
                            $mail_content .= "<tr>";
                            $mail_content .= "<th align='left'>Email: </th>";
                            $mail_content .= "<td>".esc_attr($email)."</td>";
                            $mail_content .= "</tr>";
                        } else if (empty($email)) {
                            $email = "no-reply@".$_SERVER['HTTP_HOST'];
                        }

                        $field_setting = isset($value['phone']) ? $value['phone'] : [];
                        if (isset($field_setting['is_active']) && $field_setting['is_active'] == "yes") {
                            $mail_content .= "<tr>";
                            $mail_content .= "<th align='left'>Phone number: </th>";
                            $mail_content .= "<td>".esc_attr($phone)."</td>";
                            $mail_content .= "</tr>";
                        }

                        $field_setting = isset($value['message']) ? $value['message'] : [];
                        if (isset($field_setting['is_active']) && $field_setting['is_active'] == "yes") {
                            $mail_content .= "<tr>";
                            $mail_content .= "<th align='left'>Message: </th>";
                            $mail_content .= "<td>".nl2br($message)."</td>";
                            $mail_content .= "</tr>";
                        }

                        $mail_content .= "</table>";

                        $blog_email = (isset($value['email_address']) && !empty($value['email_address'])) ? $value['email_address'] : get_bloginfo('admin_email');
                        $blog_name  = (isset($value['sender_name']) && !empty($value['sender_name'])) ? $value['sender_name'] : get_bloginfo('name');
                        $subject    = (isset($value['email_subject']) && !empty($value['email_subject'])) ? $value['email_subject'] : "New contact form lead";

                        $date_format = get_option("date_format");
                        $time_format = get_option("time_format");

                        if (empty($date_format)) {
                            $date_format = "Y-m-d";
                        }

                        if (empty($time_format)) {
                            $time_format = "H:i:s";
                        }

                        $current_date = $new_date;
                        $date         = get_date_from_gmt($current_date, $date_format);
                        $time         = get_date_from_gmt($current_date, $time_format);

                        $subject = str_replace(["{name}", "{phone}", "{email}", "{date}", "{hour}"], [esc_attr($name), esc_attr($phone), esc_attr($email), esc_attr($date), esc_attr($time)], $subject);

                        $headers  = "MIME-Version: 1.0\r\n";
                        $headers .= "Content-Type: text/html; charset=UTF-8\r\n";
                        $headers .= 'From: '.$name.' <'.$email.'>'."\r\n";
                        $headers .= 'X-Mailer: PHP/'.phpversion()."\r\n";
                        if (isset($email) && !empty($email) && isset($name) && !empty($name) && $email != "no-reply@".$_SERVER['HTTP_HOST']) {
                            $headers .= "Reply-To: ".sanitize_text_field($name)." <".sanitize_email($email).">\r\n";
                        }

                        wp_mail($blog_email, $subject, $mail_content, $headers);
                    }//end if

                    $response['status'] = 1;
                } else {
                    $response['errors'] = $errors;
                    $response['error']  = 1;
                }//end if
            } else {
                $response['message'] = "Invalid request, Please try again";
            }//end if
        } else {
            $response['message'] = "Invalid request, Please try again";
        }//end if

        echo json_encode($response);
        exit;

    }//end chaty_front_form_save_data()


    function check_for_editors()
    {
        $is_elementor    = isset($_GET['elementor-preview']) ? 1 : 0;
        $is_ct_builder   = isset($_GET['ct_builder']) ? 1 : 0;
        $is_divi_theme   = isset($_GET['et_fb']) ? 1 : 0;
        $is_zion_builder = isset($_GET['zionbuilder-preview']) ? 1 : 0;
        $is_site_origin  = isset($_GET['siteorigin_panels_live_editor']) ? 1 : 0;
        $fl_builder      = isset($_GET['fl_builder']) ? 1 : 0;
        return ($is_ct_builder || $is_elementor || $is_divi_theme || $is_zion_builder || $is_site_origin || $fl_builder) ? 1 : 0;

    }//end check_for_editors()


    function cht_front_end_css_and_js()
    {
        if ($this->canInsertWidget()) :
            $settings = $this->widget_settings;
            if (!empty($settings)) {
                $chaty_updated_on = get_option("chaty_updated_on");
                if (empty($chaty_updated_on)) {
                    $chaty_updated_on = time();
                }

                $data = [];
                $data['chaty_widgets'] = $settings;
                $data['ajax_url']      = admin_url("admin-ajax.php");
                $status = get_option("cht_data_analytics_status");
                $status = ($status === false) ? "on" : $status;
                $data['data_analytics_settings'] = $status;

                wp_enqueue_style('chaty-css', CHT_PLUGIN_URL."css/chaty-front.min.css", [], $chaty_updated_on.CHT_CURRENT_VERSION);
                wp_add_inline_style('chaty-css', $this->inline_css);

                if ($this->hasFont) {
                    wp_enqueue_style('font-awesome-css', "https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.12.0/css/all.min.css");
                }

                wp_register_script("chaty", CHT_PLUGIN_URL."js/cht-front-script.min.js", ['jquery'], $chaty_updated_on.CHT_CURRENT_VERSION);
                wp_enqueue_script("chaty");

                wp_localize_script('chaty', 'chaty_settings', $data);

                $this->chaty_settings['chaty_settings'] = $data;
            }//end if
        endif;

    }//end cht_front_end_css_and_js()


    public function update_chaty_widget_click()
    {
        $postData = filter_input_array(INPUT_POST);
        $response = [];
        if (!empty($postData)) {
            $widget_id = trim(isset($postData['widgetId']) ? $postData['widgetId'] : "");
            $type      = isset($postData['type']) ? $postData['type'] : "";
            $date      = strtotime(date("Y-m-d 00:00:00"));
            global $wpdb;
            $chaty_table = $wpdb->prefix.'chaty_widget_analysis';
            $widget_id   = trim($widget_id, "_");
            $channels    = isset($postData['channels']) ? $postData['channels'] : [];
            $widget_id   = esc_sql($widget_id);

            // checking for existing widgets data for current data
            $query = "SELECT id, widget_id, channel_slug, no_of_views, no_of_clicks, is_widget, analysis_date
                FROM {$chaty_table}
                WHERE widget_id = '%d' AND is_widget = '1' AND analysis_date ='%d'";
            $query = $wpdb->prepare($query, [$widget_id, $date]);

            if (!empty($query)) {
                $result = $wpdb->get_row($query, ARRAY_A);
                if (!empty($result)) {
                    $id    = $result['id'];
                    $query = "UPDATE {$chaty_table} SET no_of_clicks = no_of_clicks + 1 WHERE id = '%d'";
                    $query = $wpdb->prepare($query, [$id]);
                    $wpdb->query($query);
                } else {
                    $data = [];
                    $data['is_widget']     = 0;
                    $data['no_of_views']   = 0;
                    $data['no_of_clicks']  = 1;
                    $data['widget_id']     = $widget_id;
                    $data['channel_slug']  = '';
                    $data['analysis_date'] = $date;
                    $wpdb->insert($chaty_table, $data);
                }

                if (!empty($channels)) {
                    $isSingle = isset($postData['isSingle']) ? $postData['isSingle'] : 0;
                    $isOpen   = isset($postData['isOpen']) ? $postData['isOpen'] : 0;

                    if ($isSingle || $isOpen) {
                        foreach ($channels as $channel) {
                            $channel = esc_sql(strtolower($channel));
                            $query   = "SELECT id, widget_id, channel_slug, no_of_views, no_of_clicks, is_widget, analysis_date
                                    FROM {$chaty_table}
                                    WHERE widget_id = '%d' AND is_widget = '0' AND analysis_date ='%d' AND channel_slug = '%s'";
                            $query   = $wpdb->prepare($query, [$widget_id, $date, $channel]);
                            if (!empty($query)) {
                                $result = $wpdb->get_row($query, ARRAY_A);
                                if (!empty($result)) {
                                    $id    = $result['id'];
                                    $query = "UPDATE {$chaty_table} SET no_of_clicks = no_of_clicks + 1 WHERE id = '%d'";
                                    $query = $wpdb->prepare($query, [$id]);
                                    $wpdb->query($query);
                                } else {
                                    $data = [];
                                    $data['is_widget']     = 0;
                                    $data['no_of_views']   = 0;
                                    $data['no_of_clicks']  = 1;
                                    $data['widget_id']     = $widget_id;
                                    $data['channel_slug']  = $channel;
                                    $data['analysis_date'] = $date;

                                    $wpdb->insert($chaty_table, $data);
                                }
                            }
                        }//end foreach
                    } else {
                        foreach ($channels as $channel) {
                            $channel = esc_sql(strtolower($channel));
                            $query   = "SELECT id, widget_id, channel_slug, no_of_views, no_of_clicks, is_widget, analysis_date
                                    FROM {$chaty_table}
                                    WHERE widget_id = '%d' AND is_widget = '0' AND analysis_date ='%d' AND channel_slug = '%s'";
                            $query   = $wpdb->prepare($query, [$widget_id, $date, $channel]);
                            if (!empty($query)) {
                                $result = $wpdb->get_row($query, ARRAY_A);
                                if (!empty($result)) {
                                    $id    = $result['id'];
                                    $query = "UPDATE {$chaty_table} SET no_of_views = no_of_views + 1 WHERE id = '%d'";
                                    $query = $wpdb->prepare($query, [$id]);
                                    $wpdb->query($query);
                                } else {
                                    $data = [];
                                    $data['is_widget']     = 0;
                                    $data['no_of_views']   = 1;
                                    $data['no_of_clicks']  = 0;
                                    $data['widget_id']     = $widget_id;
                                    $data['channel_slug']  = $channel;
                                    $data['analysis_date'] = $date;

                                    $wpdb->insert($chaty_table, $data);
                                }
                            }
                        }//end foreach
                    }//end if
                }//end if
            }//end if
        }//end if

        echo "1";
        exit;

    }//end update_chaty_widget_click()


    public function update_chaty_channel_click()
    {
        $postData = filter_input_array(INPUT_POST);
        $response = [];
        if (!empty($postData)) {
            $widget_id = trim(isset($postData['widgetId']) ? $postData['widgetId'] : "");
            $date      = strtotime(date("Y-m-d 00:00:00"));
            global $wpdb;
            $chaty_table = $wpdb->prefix.'chaty_widget_analysis';
            $widget_id   = esc_sql(trim($widget_id, "_"));
            $channel     = isset($postData['channel']) ? $postData['channel'] : "";
            $channel     = esc_sql(strtolower($channel));

            $query = "SELECT id, widget_id, channel_slug, no_of_views, no_of_clicks, is_widget, analysis_date
                                    FROM {$chaty_table}
                                    WHERE widget_id = '%d' AND is_widget = '0' AND analysis_date ='%d' AND channel_slug = '%s'";

            $query = $wpdb->prepare($query, [$widget_id, $date, $channel]);
            if (!empty($query)) {
                $result = $wpdb->get_row($query, ARRAY_A);
                if (!empty($result)) {
                    $id    = $result['id'];
                    $query = "UPDATE {$chaty_table} SET no_of_clicks = no_of_clicks + 1 WHERE id = '%d'";
                    $query = $wpdb->prepare($query, [$id]);
                    $wpdb->query($query);
                } else {
                    $data = [];
                    $data['is_widget']     = 0;
                    $data['no_of_views']   = 0;
                    $data['no_of_clicks']  = 1;
                    $data['widget_id']     = $widget_id;
                    $data['channel_slug']  = $channel;
                    $data['analysis_date'] = $date;

                    $wpdb->insert($chaty_table, $data);
                }
            }
        }//end if

        echo "1";
        exit;

    }//end update_chaty_channel_click()


    public function update_chaty_widget_views()
    {
        $postData = filter_input_array(INPUT_POST);
        $response = [];
        if (!empty($postData)) {
            $widget_id = trim(isset($postData['widgetId']) ? $postData['widgetId'] : "");
            $date      = strtotime(date("Y-m-d 00:00:00"));
            global $wpdb;
            $chaty_table = $wpdb->prefix.'chaty_widget_analysis';
            $widget_id   = esc_sql(trim($widget_id, "_"));
            $channels    = isset($postData['channels']) ? $postData['channels'] : [];

            // checking for existing widgets data for current data
            $query = "SELECT id, widget_id, channel_slug, no_of_views, no_of_clicks, is_widget, analysis_date
                FROM {$chaty_table}
                WHERE widget_id = '%d' AND is_widget = '1' AND analysis_date ='%d'";
            $query = $wpdb->prepare($query, [$widget_id, $date]);

            if (!empty($query)) {
                $result = $wpdb->get_row($query, ARRAY_A);
                if (!empty($result)) {
                    $id    = $result['id'];
                    $query = "UPDATE {$chaty_table} SET no_of_views = no_of_views + 1 WHERE id = '%d'";
                    $query = $wpdb->prepare($query, [$id]);
                    $wpdb->query($query);
                } else {
                    $data = [];
                    $data['is_widget']     = 1;
                    $data['no_of_views']   = 0;
                    $data['no_of_clicks']  = 0;
                    $data['widget_id']     = $widget_id;
                    $data['channel_slug']  = '';
                    $data['analysis_date'] = $date;
                    $data['no_of_views']   = 1;
                    $wpdb->insert($chaty_table, $data);
                }

                if (!empty($channels)) {
                    $isSingle = esc_sql(isset($postData['isSingle']) ? $postData['isSingle'] : 0);
                    $isOpen   = esc_sql(isset($postData['isOpen']) ? $postData['isOpen'] : 0);

                    if ($isSingle || $isOpen) {
                        foreach ($channels as $channel) {
                            $channel = esc_sql(strtolower($channel));
                            $query   = "SELECT id, widget_id, channel_slug, no_of_views, no_of_clicks, is_widget, analysis_date
                                    FROM {$chaty_table}
                                    WHERE widget_id = '%d' AND is_widget = '0' AND analysis_date ='%d' AND channel_slug = '%s'";
                            $query   = $wpdb->prepare($query, [$widget_id, $date, $channel]);
                            if (!empty($query)) {
                                $result = $wpdb->get_row($query, ARRAY_A);
                                if (!empty($result)) {
                                    $id    = $result['id'];
                                    $query = "UPDATE {$chaty_table} SET no_of_views = no_of_views + 1 WHERE id = '%d'";
                                    $query = $wpdb->prepare($query, [$id]);
                                    $wpdb->query($query);
                                } else {
                                    $data = [];
                                    $data['is_widget']     = 0;
                                    $data['no_of_views']   = 1;
                                    $data['no_of_clicks']  = 0;
                                    $data['widget_id']     = $widget_id;
                                    $data['channel_slug']  = $channel;
                                    $data['analysis_date'] = $date;

                                    $wpdb->insert($chaty_table, $data);
                                }
                            }
                        }//end foreach
                    }//end if
                }//end if
            }//end if
        }//end if

        echo "1";
        exit;

    }//end update_chaty_widget_views()


    public function update_chaty_channel_views()
    {
        $postData = filter_input_array(INPUT_POST);
        $response = [];
        if (!empty($postData)) {
            $widget_id = trim(isset($postData['widgetId']) ? $postData['widgetId'] : "");
            $date      = strtotime(date("Y-m-d 00:00:00"));
            global $wpdb;
            $chaty_table = $wpdb->prefix.'chaty_widget_analysis';
            $widget_id   = esc_sql(trim($widget_id, "_"));
            $channels    = isset($postData['channels']) ? $postData['channels'] : [];

            // checking for existing widgets data for current data
            $query = "SELECT id, widget_id, channel_slug, no_of_views, no_of_clicks, is_widget, analysis_date
                FROM {$chaty_table}
                WHERE widget_id = '%d' AND is_widget = '1' AND analysis_date ='%d'";
            $query = $wpdb->prepare($query, [$widget_id, $date]);

            if (!empty($query)) {
                $result = $wpdb->get_row($query, ARRAY_A);
                /*
                    if(!empty($result)) {
                    $id = $result['id'];
                    $query = "UPDATE {$chaty_table} SET no_of_views = no_of_views + 1 WHERE id = '%d'";
                    $query = $wpdb->prepare($query, array($id));
                    $wpdb->query($query);
                    } else {
                    $data = array();
                    $data['is_widget'] = 1;
                    $data['no_of_views'] = 0;
                    $data['no_of_clicks'] = 0;
                    $data['widget_id'] = $widget_id;
                    $data['channel_slug'] = '';
                    $data['analysis_date'] = $date;
                    $data['no_of_views'] = 1;
                    $wpdb->insert($chaty_table, $data);
                }*/

                if (!empty($channels)) {
                    foreach ($channels as $channel) {
                        $channel = esc_sql(strtolower($channel));
                        $query   = "SELECT id, widget_id, channel_slug, no_of_views, no_of_clicks, is_widget, analysis_date
                                FROM {$chaty_table}
                                WHERE widget_id = '%d' AND is_widget = '0' AND analysis_date ='%d' AND channel_slug = '%s'";
                        $query   = $wpdb->prepare($query, [$widget_id, $date, $channel]);
                        if (!empty($query)) {
                            $result = $wpdb->get_row($query, ARRAY_A);
                            if (!empty($result)) {
                                $id    = $result['id'];
                                $query = "UPDATE {$chaty_table} SET no_of_views = no_of_views + 1 WHERE id = '%d'";
                                $query = $wpdb->prepare($query, [$id]);
                                $wpdb->query($query);
                            } else {
                                $data = [];
                                $data['is_widget']     = 0;
                                $data['no_of_views']   = 1;
                                $data['no_of_clicks']  = 0;
                                $data['widget_id']     = $widget_id;
                                $data['channel_slug']  = $channel;
                                $data['analysis_date'] = $date;

                                $wpdb->insert($chaty_table, $data);
                            }
                        }
                    }//end foreach
                }//end if
            }//end if
        }//end if

        echo "1";
        exit;

    }//end update_chaty_channel_views()


    function get_user_ipaddress()
    {
        if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
            $ip = sanitize_text_field(wp_unslash($_SERVER['HTTP_CLIENT_IP']));
        } else if (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            // ip pass from proxy
            $ip = sanitize_text_field(wp_unslash($_SERVER['HTTP_X_FORWARDED_FOR']));
        } else {
            $ip = sanitize_text_field(wp_unslash($_SERVER['REMOTE_ADDR']));
        }

        return $ip;

    }//end get_user_ipaddress()


    public function get_chaty_settings()
    {
        if (current_user_can('manage_options')) {
            $slug    = sanitize_text_field($_POST['social']);
            $channel = sanitize_text_field($_POST['channel']);
            $status  = 0;
            $data    = [];
            if (!empty($slug)) {
                foreach ($this->socials as $social) {
                    if ($social['slug'] == $slug) {
                        break;
                    }
                }

                if (!empty($social)) {
                    $status = 1;
                    $data   = $social;
                    // echo "<pre>"; print_r($social); echo "</pre>";
                    $data['help']      = "";
                    $data['help_text'] = "";
                    $data['help_link'] = "";
                    if ((isset($social['help']) && !empty($social['help'])) || isset($social['help_link'])) {
                        $data['help_title'] = isset($social['help_title']) ? $social['help_title'] : "Doesn't work?";
                        $data['help_text']  = isset($social['help']) ? $social['help'] : "";
                        if (isset($data['help_link']) && !empty($data['help_link'])) {
                            $data['help_link'] = $data['help_link'];
                        } else {
                            $data['help_title'] = $data['help_title'];
                        }
                    }
                }
            }//end if

            $response            = [];
            $response['data']    = $data;
            $response['status']  = $status;
            $response['channel'] = $channel;
            echo json_encode($response);
            die;
        }//end if

    }//end get_chaty_settings()


    // function choose_social_handler start
    public function choose_social_handler()
    {
        if (current_user_can('manage_options')) {
            check_ajax_referer('cht_nonce_ajax', 'nonce_code');
            $slug = sanitize_text_field($_POST['social']);

            if (!is_null($slug) && !empty($slug)) {
                foreach ($this->socials as $social) {
                    if ($social['slug'] == $slug) {
                        break;
                    }
                }

                if (!$social) {
                    return;
                    // return if social media setting not found
                }

                $this->widget_index = sanitize_text_field($_POST['widget_index']);
                ;

                $value = get_option('cht_social'.$this->widget_index.'_'.$social['slug']);
                // get setting for media if already saved
                ob_start();
                include CHT_PRO_DIR.DIRECTORY_SEPARATOR."views".DIRECTORY_SEPARATOR."admin".DIRECTORY_SEPARATOR."channel-setting.php";
                $html = ob_get_clean();
                echo json_encode($html);
            }//end if

            wp_die();
        }//end if

    }//end choose_social_handler()


    // function choose_social_handler end
    public function rename_chaty_widget()
    {
        if (current_user_can('manage_options')) {
            $widget_index = sanitize_text_field($_POST['widget_index']);
            $widget_nonce = sanitize_text_field($_POST['widget_nonce']);
            $widget_title = sanitize_text_field($_POST['widget_title']);
            if (isset($widget_index) && !empty($widget_index) && !empty($widget_nonce) && wp_verify_nonce($widget_nonce, "chaty_remove_".$widget_index)) {
                $index = $widget_index;
                $index = trim($index, "_");

                if (empty($index)) {
                    update_option("cht_widget_title", $widget_title);
                } else {
                    update_option("cht_widget_title_".$index, $widget_title);
                }

                echo esc_url(admin_url("admin.php?page=chaty-app"));
                exit;
            }
        }

    }//end rename_chaty_widget()


    public function remove_chaty_widget()
    {
        if (current_user_can('manage_options')) {
            $widget_index = sanitize_text_field($_POST['widget_index']);
            $widget_nonce = sanitize_text_field($_POST['widget_nonce']);
            if (isset($widget_index) && !empty($widget_index) && !empty($widget_nonce) && wp_verify_nonce($widget_nonce, "chaty_remove_".$widget_index)) {
                $index = $widget_index;
                $index = trim($index, "_");

                $deleted_list = get_option("chaty_deleted_settings");
                if (empty($deleted_list) || !is_array($deleted_list)) {
                    $deleted_list = [];
                }

                if (!in_array($index, $deleted_list)) {
                    $deleted_list[] = $index;
                    update_option("chaty_deleted_settings", $deleted_list);
                }

                if ($index == 0) {
                    update_option("cht_is_default_deleted", 1);
                }

                echo esc_url(admin_url("admin.php?page=chaty-app"));
                exit;
            }//end if
        }//end if

    }//end remove_chaty_widget()


    public function change_chaty_widget_status()
    {
        if (current_user_can('manage_options')) {
            $widget_index = sanitize_text_field($_POST['widget_index']);
            $widget_nonce = sanitize_text_field($_POST['widget_nonce']);
            if (isset($widget_index) && !empty($widget_index) && !empty($widget_nonce) && wp_verify_nonce($widget_nonce, "chaty_remove_".$widget_index)) {
                $widget_index = trim($widget_index, "_");
                if (empty($widget_index) || $widget_index == 0) {
                    $widget_index = "";
                } else {
                    $widget_index = "_".$widget_index;
                }

                $status = get_option("cht_active".$widget_index);
                if ($status) {
                    update_option("cht_active".$widget_index, 0);
                } else {
                    update_option("cht_active".$widget_index, 1);
                }
            }
        }

        echo "1";
        exit;

    }//end change_chaty_widget_status()


    // get social media list for front end widget
    public function get_social_icon_list($index="")
    {
        if (empty($index)) {
            $index = $this->widget_number;
        }

        $social = get_option('cht_numb_slug'.$index);
        // get saved social media list
        $social = explode(",", $social);

        $arr = [];
        foreach ($social as $number => $key_soc) :
            foreach ($this->socials as $key => $social) :
                // compare with Default Social media list
                if ($social['slug'] != $key_soc) {
                    continue;
                    // return if slug is not equal
                }

                $value = get_option('cht_social'.$index.'_'.$social['slug']);
                // get saved settings for button
                if ($value) {
                    $slug = strtolower($social['slug']);

                    if (!empty($value['value']) || $slug == "contact_us" || (isset($value['is_agent']) && $value['is_agent'])) {
                        $url            = "";
                        $mobile_url     = "";
                        $desktop_target = "";
                        $mobile_target  = "";
                        $qr_code_image  = "";

                        $channel_type = $slug;

                        if (!isset($value['value'])) {
                            $value['value'] = "";
                        }

                        $svg_icon = $social['svg'];
                        if ($slug == "link" || $slug == "custom_link" || $slug == "custom_link_3" || $slug == "custom_link_4" || $slug == "custom_link_5") {
                            if (isset($value['channel_type']) && !empty($value['channel_type'])) {
                                $channel_type = $value['channel_type'];

                                foreach ($this->socials as $icon) {
                                    if ($icon['slug'] == $channel_type) {
                                        $svg_icon = $icon['svg'];
                                    }
                                }
                            }
                        }

                        $channel_type    = strtolower($channel_type);
                        $channel_id      = "cht-channel-".$number.$index;
                        $channel_id      = trim($channel_id, "_");
                        $pre_set_message = "";

                        if ($channel_type == "viber") {
                            // Viber change to exclude + from number for desktop
                            $val = $value['value'];
                            if (is_numeric($val)) {
                                $fc = substr($val, 0, 1);
                                if ($fc == "+") {
                                    $length = (-1 * (strlen($val) - 1));
                                    $val    = substr($val, $length);
                                }

                                if (!wp_is_mobile()) {
                                    // Viber change to include + from number for mobile
                                    $val = "+".$val;
                                }
                            }
                        } else if ($channel_type == "whatsapp") {
                            // Whatspp change to exclude + from phone number
                            $val = $value['value'];
                            $val = str_replace("+", "", $val);
                        } else if ($channel_type == "facebook_messenger") {
                            // Facebook change to change URL from facebook.com to m.me version 2.1.0 change
                            $val = $value['value'];
                            $val = str_replace("facebook.com", "m.me", $val);
                            // Facebook change to remove www. from URL. version 2.1.0 change
                            $val = str_replace("www.", "", $val);

                            $val        = trim($val, "/");
                            $val_array  = explode("/", $val);
                            $total      = (count($val_array) - 1);
                            $last_value = $val_array[$total];
                            $last_value = explode("-", $last_value);
                            $total_text = (count($last_value) - 1);
                            $total_text = $last_value[$total_text];

                            if (is_numeric($total_text)) {
                                $val_array[$total] = $total_text;
                                $val = implode("/", $val_array);
                            }
                        } else {
                            $val = $value['value'];
                        }//end if

                        if (!isset($value['title'])) {
                            $value['title'] = $social['title'];
                            // Initialize title with default title if not exists. version 2.1.0 change
                        }

                        $image_url = "";

                        // get custom image URL if uploaded. version 2.1.0 change
                        if (isset($value['image_id']) && !empty($value['image_id'])) {
                            $image_id = $value['image_id'];
                            if (!empty($image_id)) {
                                $image_data = wp_get_attachment_image_src($image_id, "full");
                                if (!empty($image_data) && is_array($image_data)) {
                                    $image_url = $image_data[0];
                                }
                            }
                        }

                        $on_click_fn = "";
                        // get custom icon background color if exists. version 2.1.0 change
                        if (!isset($value['bg_color']) || empty($value['bg_color'])) {
                            $value['bg_color'] = '';
                        }

                        if ($channel_type == "whatsapp") {
                            // setting for Whatsapp URL
                            $val = str_replace("+", "", $val);
                            $val = str_replace(" ", "", $val);
                            $val = str_replace("-", "", $val);
                            if (isset($value['use_whatsapp_web']) && $value['use_whatsapp_web'] == "no") {
                                $url = "https://wa.me/".$val;
                            } else {
                                $url = "https://web.whatsapp.com/send?phone=".$val;
                            }

                            $url            = esc_url($url);
                            $mobile_url     = "https://wa.me/".$val;
                            $desktop_target = "_blank";
                            $mobile_url     = esc_url($mobile_url);
                        } else if ($channel_type == "phone") {
                            // setting for Phone
                            $url = "tel:".esc_attr($val);
                        } else if ($channel_type == "sms") {
                            // setting for SMS
                            $url = "sms:".esc_attr($val);
                        } else if ($channel_type == "telegram") {
                            // setting for Telegram
                            $val            = ltrim($val, "@");
                            $url            = "https://telegram.me/".$val;
                            $desktop_target = "_blank";
                            $mobile_target  = "_blank";
                            $url            = esc_url($url);
                        } else if ($channel_type == "line" || $channel_type == "google_maps" || $channel_type == "poptin" || $channel_type == "waze") {
                            // setting for Line, Google Map, Link, Poptin, Waze, Custom Link
                            $url            = esc_url($val);
                            $desktop_target = "_blank";
                            $mobile_target  = "_blank";
                        } else if ($channel_type == "link" || $channel_type == "custom_link" || $channel_type == "custom_link_3" || $channel_type == "custom_link_4" || $channel_type == "custom_link_5") {
                            $url      = $val;
                            $is_exist = strpos($val, "javascript");
                            $is_viber = strpos($val, "viber");
                            if ($is_viber !== false) {
                                $url = esc_url($url);
                            } else if ($is_exist === false) {
                                $url = esc_url($val);
                                if ($channel_type == "custom_link" || $channel_type == "link" || $channel_type == "custom_link_3" || $channel_type == "custom_link_4" || $channel_type == "custom_link_5") {
                                    $desktop_target = (isset($value['new_window']) && $value['new_window'] == 0) ? "" : "_blank";
                                    $mobile_target  = (isset($value['new_window']) && $value['new_window'] == 0) ? "" : "_blank";
                                }
                            } else {
                                $url            = "javascript:;";
                                $on_click_fn    = str_replace('"', "'", esc_attr($val));
                                $on_click_fn    = str_replace('`', "'", $on_click_fn);
                                $on_click_fn    = urldecode($on_click_fn);
                                $desktop_target = "";
                                $mobile_target  = "";
                            }
                        } else if ($channel_type == "wechat") {
                            // setting for WeChat
                            $url = "javascript:;";
                            if (!empty($value['title'])) {
                                $value['title'] .= ": ".esc_attr($val);
                            } else {
                                $value['title'] = esc_attr($val);
                            }

                            $qr_code = isset($value['qr_code']) ? $value['qr_code'] : "";
                            if (!empty($qr_code)) {
                                $image_data = wp_get_attachment_image_src($qr_code, "full");
                                if (!empty($image_data) && is_array($image_data)) {
                                    $qr_code_image = esc_url($image_data[0]);
                                }
                            }
                        } else if ($channel_type == "viber") {
                            // setting for Viber
                            $url = esc_attr($val);
                        } else if ($channel_type == "snapchat") {
                            // setting for SnapChat
                            $url            = "https://www.snapchat.com/add/".$val;
                            $desktop_target = "_blank";
                            $mobile_target  = "_blank";
                            $url            = esc_url($url);
                        } else if ($channel_type == "waze") {
                            // setting for Waze
                            $url = "javascript:;";
                            $value['title'] .= ": ".esc_attr($val);
                        } else if ($channel_type == "vkontakte") {
                            // setting for vkontakte
                            $url            = "https://vk.me/".$val;
                            $desktop_target = "_blank";
                            $mobile_target  = "_blank";
                            $url            = esc_url($url);
                        } else if ($channel_type == "skype") {
                            // setting for Skype
                            $url = "skype:".esc_attr($val)."?chat";
                        } else if ($channel_type == "email") {
                            // setting for Email
                            $url = "mailto:".esc_attr($val);
                        } else if ($channel_type == "facebook_messenger") {
                            // setting for facebook URL
                            $url = esc_url($val);
                            $url = str_replace("http:", "https:", $url);
                            if (wp_is_mobile()) {
                                $mobile_target = "";
                            } else {
                                $desktop_target = "_blank";
                            }

                            $url = esc_url($url);
                        } else if ($channel_type == "twitter") {
                            // setting for Twitter
                            $url            = "https://twitter.com/".$val;
                            $desktop_target = "_blank";
                            $mobile_target  = "_blank";
                            $url            = esc_url($url);
                        } else if ($channel_type == "instagram") {
                            // setting for Instagram
                            $url            = "https://www.instagram.com/".$val;
                            $desktop_target = "_blank";
                            $mobile_target  = "_blank";
                            $url            = esc_url($url);
                        } else if ($channel_type == "linkedin") {
                            // setting for Linkedin
                            $link_type = !isset($value['link_type']) || $value['link_type'] == "company" ? "company" : "personal";
                            if ($link_type == "personal") {
                                $url = "https://www.linkedin.com/in/".$val;
                            } else {
                                $url = "https://www.linkedin.com/company/".$val;
                            }

                            $desktop_target = "_blank";
                            $mobile_target  = "_blank";
                            $url            = esc_url($url);
                        } else if ($channel_type == "slack") {
                            // setting for Twitter
                            $url            = esc_url($val);
                            $desktop_target = "_blank";
                            $mobile_target  = "_blank";
                            $url            = esc_url($url);
                        } else if ($channel_type == "discord") {
                            // setting for Discord
                            $url            = esc_url($val);
                            $desktop_target = "_blank";
                            $mobile_target  = "_blank";
                            $url            = esc_url($url);
                        } else if ($channel_type == "microsoft_teams") {
                            // setting for Microsoft_Teams
                            $url            = esc_url($val);
                            $desktop_target = "_blank";
                            $mobile_target  = "_blank";
                            $url            = esc_url($url);
                        } else if ($channel_type == "tiktok") {
                            $val            = $value['value'];
                            $firstCharacter = substr($val, 0, 1);
                            if ($firstCharacter != "@") {
                                $val = "@".$val;
                            }

                            $url            = esc_url("https://www.tiktok.com/".$val);
                            $desktop_target = $mobile_target = "_blank";
                            $url            = esc_url($url);
                        }//end if

                        // Instagram checking for custom color
                        if ($channel_type == "instagram" && $value['bg_color'] == "#ffffff") {
                            $value['bg_color'] = "";
                        }

                        $svg = trim(preg_replace('/\s\s+/', '', $svg_icon));

                        $is_mobile  = isset($value['is_mobile']) ? 1 : 0;
                        $is_desktop = isset($value['is_desktop']) ? 1 : 0;

                        if (empty($mobile_url)) {
                            $mobile_url = $url;
                        }

                        $bg_color  = $value['bg_color'];
                        $rgb_color = $this->getRGBColor($value['bg_color']);
                        $url       = htmlspecialchars($url);

                        $is_agent        = (isset($value['is_agent']) && $value['is_agent']) ? 1 : 0;
                        $agentData       = [];
                        $valid           = 1;
                        $header_text     = "";
                        $header_sub_text = "";
                        $header_bg_color = "";
                        $header_text_color = "";
                        $is_agent_desktop  = 0;
                        $is_agent_mobile   = 0;
                        if ($is_agent) {
                            $valid      = 0;
                            $agent_data = isset($value['agent_data'])&&is_array($value['agent_data'])&&!empty($value['agent_data']) ? $value['agent_data'] : [];
                            if (!empty($agent_data)) {
                                $is_agent_desktop = isset($value['is_agent_desktop']) && $value['is_agent_desktop'] == "checked" ? 1 : 0;
                                $is_agent_mobile  = isset($value['is_agent_mobile']) && $value['is_agent_mobile'] == "checked" ? 1 : 0;
                                foreach ($agent_data as $agent) {
                                    if (isset($agent['value']) && !empty($agent['value'])) {
                                        $valid           = 1;
                                        $image_id        = isset($agent['image_id']) ? $agent['image_id'] : 0;
                                        $agent_fa_icon   = isset($agent['agent_fa_icon']) ? $agent['agent_fa_icon'] : "";
                                        $svg_icon        = $svg;
                                        $agent_image_url = "";
                                        if (!empty($agent_fa_icon)) {
                                            $svg_icon      = "<span class='chaty-custom-icon'><i class='".esc_attr($agent_fa_icon)."'></i></span>";
                                            $this->hasFont = true;
                                        } else if (!empty($image_id)) {
                                            $image_data = wp_get_attachment_image_src($image_id, "full");
                                            if (!empty($image_data) && is_array($image_data)) {
                                                $agent_image_url = esc_sql($image_data[0]);
                                            }
                                        }


                                        $agentValue = $agent['value'];
                                        if($channel_type == "poptin") {
                                            $agentValue = esc_url($agentValue);
                                        } else if($channel_type == "line") {
                                            $agentValue = esc_url($agentValue);
                                        } else if($channel_type == "google_maps") {
                                            $agentValue = esc_url($agentValue);
                                        } else if($channel_type == "waze") {
                                            $agentValue = esc_url($agentValue);
                                        } else if($channel_type == "slack") {
                                            $agentValue = esc_url($agentValue);
                                        } else if($channel_type == "discord") {
                                            $agentValue = esc_url($agentValue);
                                        } else if($channel_type == "microsoft_teams") {
                                            $agentValue = esc_url($agentValue);
                                        } else {
                                            $agentValue = esc_html($agent['value']);
                                        }
                                        $agentData[] = [
                                            'value'          => $agentValue,
                                            'agent_bg_color' => esc_attr(isset($agent['agent_bg_color']) ? $agent['agent_bg_color'] : $social['color']),
                                            'link_type'      => esc_attr(isset($agent['link_type']) ? $agent['link_type'] : 'personal'),
                                            'agent_title'    => esc_attr(isset($agent['agent_title']) ? $agent['agent_title'] : $social['title']),
                                            'svg_icon'       => $svg_icon,
                                            'agent_image'    => esc_url($agent_image_url),
                                        ];
                                    }//end if
                                }//end foreach

                                if ($valid) {
                                    $qr_code_image  = "";
                                    $mobile_target  = "";
                                    $desktop_target = "";
                                    $url            = "javascript:;";
                                    $val            = "";

                                    $image_id      = isset($value['agent_image_id']) ? $value['agent_image_id'] : 0;
                                    $agent_fa_icon = isset($value['agent_fa_icon']) ? $value['agent_fa_icon'] : "";
                                    if (!empty($agent_fa_icon)) {
                                        $svg           = "<span class='chaty-custom-icon'><i class='".esc_attr($agent_fa_icon)."'></i></span>";
                                        $this->hasFont = true;
                                    } else if (!empty($image_id)) {
                                        $image_data = wp_get_attachment_image_src($image_id, "full");
                                        if (!empty($image_data) && is_array($image_data)) {
                                            $image_url = $image_data[0];
                                        }
                                    }

                                    $value['title']    = esc_attr(isset($value['agent_title']) ? $value['agent_title'] : $value['title']);
                                    $header_text       = esc_attr(isset($value['agent_header_text']) ? $value['agent_header_text'] : $social['title']);
                                    $header_sub_text   = esc_attr(isset($value['agent_sub_header_text']) ? $value['agent_sub_header_text'] : "How can we help?");
                                    $header_text_color = esc_attr(isset($value['agent_head_text_color']) ? $value['agent_head_text_color'] : "#ffffff");
                                    $header_bg_color   = esc_attr(isset($value['agent_head_bg_color']) ? $value['agent_head_bg_color'] : $social['color']);
                                    $bg_color          = esc_attr(isset($value['agent_bg_color']) ? $value['agent_bg_color'] : $bg_color);
                                    $rgb_color         = esc_attr($this->getRGBColor($bg_color));
                                }//end if
                            }//end if
                        }//end if

                        // echo "<pre>"; print_r($value); echo "</pre>";
                        $contact_fields        = [];
                        $contact_form_settings = [];

                        if ($channel_type == "contact_us") {
                            $url            = "javascript:;";
                            $desktop_target = "";
                            $mobile_target  = "";
                            if (isset($value['name']) || isset($value['email']) || isset($value['message'])) {
                                $field_setting = $value['name'];
                                if (isset($field_setting['is_active']) && $field_setting['is_active'] == "yes") {
                                    $contact_fields[] = [
                                        "field"       => "name",
                                        "is_required" => (isset($field_setting['is_required']) && $field_setting['is_required'] == "yes") ? 1 : 0,
                                        "placeholder" => esc_html(isset($field_setting['placeholder']) ? $field_setting['placeholder'] : "Enter your name"),
                                        "type"        => "text",
                                    ];
                                }

                                $field_setting = $value['email'];
                                if (isset($field_setting['is_active']) && $field_setting['is_active'] == "yes") {
                                    $contact_fields[] = [
                                        "field"       => "email",
                                        "is_required" => (isset($field_setting['is_required']) && $field_setting['is_required'] == "yes") ? 1 : 0,
                                        "placeholder" => esc_html(isset($field_setting['placeholder']) ? $field_setting['placeholder'] : "Enter your name"),
                                        "type"        => "email",
                                    ];
                                }

                                $field_setting = $value['phone'];
                                if (isset($field_setting['is_active']) && $field_setting['is_active'] == "yes") {
                                    $contact_fields[] = [
                                        "field"       => "phone",
                                        "is_required" => (isset($field_setting['is_required']) && $field_setting['is_required'] == "yes") ? 1 : 0,
                                        "placeholder" => esc_html(isset($field_setting['placeholder']) ? $field_setting['placeholder'] : "Enter your name"),
                                        "type"        => "text",
                                    ];
                                }

                                $field_setting = $value['message'];
                                if (isset($field_setting['is_active']) && $field_setting['is_active'] == "yes") {
                                    $contact_fields[] = [
                                        "field"       => "message",
                                        "is_required" => (isset($field_setting['is_required']) && $field_setting['is_required'] == "yes") ? 1 : 0,
                                        "placeholder" => esc_html(isset($field_setting['placeholder']) ? $field_setting['placeholder'] : "Enter your name"),
                                        "type"        => "textarea",
                                    ];
                                }
                            }//end if

                            if (!empty($contact_fields)) {
                                $contact_form_settings = [
                                    "button_text_color"  => esc_attr(isset($value['button_text_color']) ? $value['button_text_color'] : "#ffffff"),
                                    "button_bg_color"    => esc_attr(isset($value['button_bg_color']) ? $value['button_bg_color'] : "#A886CD"),
                                    "button_text"        => esc_attr(isset($value['button_text']) ? $value['button_text'] : "Chat"),
                                    "contact_form_title" => esc_attr(isset($value['contact_form_title']) ? $value['contact_form_title'] : "Contact Us"),
                                ];
                            } else {
                                $valid = false;
                            }
                        }//end if

                        if ($valid) {
                            $pre_set_message      = esc_attr(isset($value['pre_set_message']) ? $value['pre_set_message'] : "");
                            $is_default_open      = esc_attr((isset($value['is_default_open'])&&$value['is_default_open'] == "yes") ? 1 : 0);
                            $has_welcome_message  = esc_attr((isset($value['embedded_window'])&&$value['embedded_window'] == "yes") ? 1 : 0);
                            $embedded_message     = isset($value['embedded_message']) ? $value['embedded_message'] : "";
                            $channel_account_type = esc_attr(isset($value['link_type']) ? $value['link_type'] : "personal");
                            $mail_subject         = esc_attr(isset($value['mail_subject']) ? $value['mail_subject'] : "");
                            $is_use_web_version   = esc_attr((isset($value['use_whatsapp_web']) && $value['use_whatsapp_web'] == "no") ? 0 : 1);
                            $is_open_new_tab      = esc_attr((isset($value['is_open_new_tab']) && $value['is_open_new_tab'] == 0) ? 0 : 1);
                            $channel_type         = esc_attr(isset($value['channel_type']) && !empty($value['channel_type']) ? $value['channel_type'] : $social['slug']);

                            $widget_token = wp_create_nonce("chaty_widget_nonce".$index);

                            $agent_fa_icon = isset($value['fa_icon']) ? $value['fa_icon'] : "";
                            if (!empty($agent_fa_icon)) {
                                $svg           = "<span class='chaty-custom-channel-icon'><i class='".esc_attr($agent_fa_icon)."'></i></span>";
                                $this->hasFont = true;
                            }

                            $allowedHTML = [
                                'a'      => [
                                    'href'  => [],
                                    'title' => [],
                                ],
                                'b'      => [],
                                'a'      => [
                                    "href"   => [],
                                    "target" => [],
                                ],
                                'strong' => [],
                                'em'     => [],
                                'span'   => [
                                    "style" => [],
                                ],
                                'i'      => [],
                                'p'      => [],
                            ];

                            $embedded_message = wp_kses($embedded_message, $allowedHTML);

                            $data  = [
                                "channel"               => $social['slug'],
                                "value"                 => esc_attr__(wp_unslash($val)),
                                "hover_text"            => esc_attr__(wp_unslash($value['title'])),
                                "svg_icon"              => $svg,
                                "is_desktop"            => $is_desktop,
                                "is_mobile"             => $is_mobile,
                                "icon_color"            => $bg_color,
                                "icon_rgb_color"        => $rgb_color,
                                "channel_type"          => esc_attr($channel_type),
                                "custom_image_url"      => esc_url($image_url),
                                "order"                 => "",
                                "pre_set_message"       => esc_attr($pre_set_message),
                                "is_use_web_version"    => esc_attr($is_use_web_version),
                                "is_open_new_tab"       => esc_attr($is_open_new_tab),
                                "is_default_open"       => esc_attr($is_default_open),
                                "has_welcome_message"   => esc_attr($has_welcome_message),
                                "chat_welcome_message"  => $embedded_message,
                                "qr_code_image_url"     => esc_url($qr_code_image),
                                "mail_subject"          => esc_attr($mail_subject),
                                "channel_account_type"  => esc_attr($channel_account_type),
                                "contact_form_settings" => $contact_form_settings,
                                "contact_fields"        => $contact_fields,
                                "url"                   => $url,
                                "mobile_target"         => esc_attr($mobile_target),
                                "desktop_target"        => esc_attr($desktop_target),
                                "target"                => esc_attr($desktop_target),
                                "is_agent"              => esc_attr($is_agent),
                                "agent_data"            => $agentData,
                                "header_text"           => esc_attr($header_text),
                                "header_sub_text"       => esc_attr($header_sub_text),
                                "header_bg_color"       => esc_attr($header_bg_color),
                                "header_text_color"     => esc_attr($header_text_color),
                                "widget_token"          => $widget_token,
                                "widget_index"          => esc_attr($index),
                                "click_event"           => $on_click_fn,
                                "is_agent_desktop"      => esc_attr($is_agent_desktop),
                                "is_agent_mobile"       => esc_attr($is_agent_mobile),
                            ];
                            $arr[] = $data;
                        }//end if
                    }//end if
                }//end if
            endforeach;
        endforeach;
        return $arr;

    }//end get_social_icon_list()


    // add widget to fron end
    public function insert_widget()
    {

    }//end insert_widget()


    public function getRGBColor($color)
    {
        if (!empty($color)) {
            if (strpos($color, '#') !== false) {
                $color = $this->hex2rgba($color);
            }

            if (strpos($color, 'rgba(') !== false || strpos($color, 'rgb(') !== false) {
                $color   = explode(",", $color);
                $color   = str_replace(["rgba(", "rgb(", ")"], ["", "", ""], $color);
                $string  = "";
                $string .= ((isset($color[0])) ? trim($color[0]) : "0").",";
                $string .= ((isset($color[1])) ? trim($color[1]) : "0").",";
                $string .= ((isset($color[2])) ? trim($color[2]) : "0");
                return $string;
            }
        }

        return "0,0,0";

    }//end getRGBColor()


    public function hex2rgba($color, $opacity=false)
    {

        $default = 'rgb(0,0,0)';

        // Return default if no color provided
        if (empty($color)) {
            return $default;
        }

        // Sanitize $color if "#" is provided
        if ($color[0] == '#') {
            $color = substr($color, 1);
        }

        // Check if color has 6 or 3 characters and get values
        if (strlen($color) == 6) {
            $hex = [
                $color[0].$color[1],
                $color[2].$color[3],
                $color[4].$color[5],
            ];
        } else if (strlen($color) == 3) {
            $hex = [
                $color[0].$color[0],
                $color[1].$color[1],
                $color[2].$color[2],
            ];
        } else {
            return $default;
        }

        // Convert hexadec to rgb
        $rgb = array_map('hexdec', $hex);

        // Check if opacity is set(rgba or rgb)
        if ($opacity) {
            if (abs($opacity) > 1) {
                $opacity = 1.0;
            }

            $output = 'rgba('.implode(",", $rgb).','.$opacity.')';
        } else {
            $output = 'rgb('.implode(",", $rgb).')';
        }

        // Return rgb(a) color string
        return $output;

    }//end hex2rgba()


    public function check_for_url($index="")
    {
        if (empty($index)) {
            $index = $this->widget_number;
        }

        $page_options = get_option("cht_page_settings".$index);
        $or_flag      = 1;
        // for page Rule contain
        // checking for page visibility settings
        if (!empty($page_options) && is_array($page_options)) {
            $server = $_SERVER;

            $link         = (isset($server['HTTPS']) && $server['HTTPS'] === 'on' ? "https" : "http")."://".$server['HTTP_HOST'].$server['REQUEST_URI'];
            $site_url     = site_url("/");
            $request_url  = substr($link, strlen($site_url));
            $url          = trim($request_url, "/");
            $url          = urldecode(strtolower($url));
            $or_flag      = 0;
            $total_option = count($page_options);
            $options      = 0;
            // checking for each page options
            foreach ($page_options as $option) {
                $key   = $option['option'];
                $value = trim(strtolower($option['value']));

                if (strpos($value, site_url()) !== false) {
                    if (strpos($value, site_url()) === 0) {
                        $length = strlen(site_url("/"));
                        $value  = substr($value, $length);
                        $value  = trim($value, "/");
                    }
                }

                if ($key != '') {
                    if ($option['shown_on'] == "show_on") {
                        $value = trim($value, "/");
                        if ($key == "home") {
                            if (is_home()) {
                                $or_flag = 1;
                            }
                        } else {
                            if (!empty($value)) {
                                switch ($key) {
                                case 'page_contains':
                                    $index = strpos($url, $value);
                                    if ($index !== false) {
                                        $or_flag = 1;
                                    }
                                    break;
                                case 'page_has_url':
                                    if ($url === $value) {
                                        $or_flag = 1;
                                    }
                                    break;
                                case 'page_start_with':
                                    $length = strlen($value);
                                    $result = substr($url, 0, $length);
                                    if ($result == $value) {
                                        $or_flag = 1;
                                    }
                                    break;
                                case 'page_end_with':
                                    $length = strlen($value);
                                    $result = substr($url, ((-1) * $length));
                                    if ($result == $value) {
                                        $or_flag = 1;
                                    }
                                    break;
                                }//end switch
                            } else {
                                if ($key == 'page_has_url') {
                                    if ($request_url == "") {
                                        $or_flag = 1;
                                    }
                                }
                            }//end if
                        }//end if
                    } else {
                        $options++;
                    }//end if
                }//end if
            }//end foreach

            if ($total_option == $options) {
                $or_flag = 1;
            }

            foreach ($page_options as $option) {
                $key   = $option['option'];
                $value = trim(strtolower($option['value']));

                if (strpos($value, site_url()) !== false) {
                    if (strpos($value, site_url()) === 0) {
                        $length = strlen(site_url("/"));
                        $value  = substr($value, $length);
                        $value  = trim($value, "/");
                    }
                }

                if ($key != '' && $option['shown_on'] == "not_show_on") {
                    $value = trim($value, "/");
                    if ($key == "home") {
                        if (is_home()) {
                            $or_flag = 0;
                        }
                    } else {
                        if (!empty($value)) {
                            switch ($key) {
                            case 'page_contains':
                                $index = strpos($url, $value);
                                if ($index !== false) {
                                    $or_flag = 0;
                                }
                                break;
                            case 'page_has_url':
                                if ($url === $value) {
                                    $or_flag = 0;
                                }
                                break;
                            case 'page_start_with':
                                $length = strlen($value);
                                $result = substr($url, 0, $length);
                                if ($result == $value) {
                                    $or_flag = 0;
                                }
                                break;
                            case 'page_end_with':
                                $length = strlen($value);
                                $result = substr($url, ((-1) * $length));
                                if ($result == $value) {
                                    $or_flag = 0;
                                }
                                break;
                            }//end switch
                        } else {
                            if ($key == 'page_has_url') {
                                if ($request_url == "") {
                                    $or_flag = 0;
                                }
                            }
                        }//end if
                    }//end if
                }//end if
            }//end foreach
        }//end if

        return $or_flag;

    }//end check_for_url()


    public function get_widget_settings($index="")
    {
        $is_traffic_source = $this->getVisitorTrafficSource($index);
        if (get_option('cht_active'.$index) && $is_traffic_source) {
            $page_status = $this->check_for_url($index);
            if ($page_status) {
                $social     = $this->get_social_icon_list($index);
                $cht_active = get_option("cht_active".$index);

                $len = count($social);

                if ($len >= 1 && !empty($social)) {
                    $def_color    = get_option('cht_color'.$index);
                    $custom_color = get_option('cht_custom_color'.$index);
                    // checking for custom color
                    if (!empty($custom_color)) {
                        $color = $custom_color;
                    } else {
                        $color = $def_color;
                    }

                    $bg_color = strtoupper($color);

                    // get total active channels
                    $cta = nl2br(get_option('cht_cta'.$index));
                    $cta = str_replace("&amp;#39;", "'", $cta);
                    $cta = str_replace("&#39;", "'", $cta);
                    $cta = esc_attr__(wp_unslash($cta));
                    $cta = html_entity_decode($cta);

                    $isPro = get_option('cht_token');
                    // is PRO version
                    $isPro = (empty($isPro) || $isPro == null) ? 0 : 1;

                    $positionSide = get_option('positionSide'.$index);
                    // get widget position
                    $cht_bottom_spacing = get_option('cht_bottom_spacing'.$index);
                    // get widget position from bottom
                    $cht_side_spacing = get_option('cht_side_spacing'.$index);
                    // get widget position from left/Right
                    $cht_widget_size = get_option('cht_widget_size'.$index);
                    // get widget size
                    $positionSide = empty($positionSide) ? 'right' : $positionSide;
                    // Initialize widget position if not exists
                    $cht_side_spacing = ($cht_side_spacing) ? $cht_side_spacing : '25';
                    // Initialize widget from left/Right if not exists
                    $cht_widget_size = ($cht_widget_size) ? $cht_widget_size : '54';
                    // Initialize widget size if not exists
                    $position = get_option('cht_position'.$index);
                    $position = ($position) ? $position : 'right';
                    // Initialize widget position if not exists
                    $total = ($cht_side_spacing + $cht_widget_size + $cht_side_spacing);
                    $cht_bottom_spacing = ($cht_bottom_spacing) ? $cht_bottom_spacing : '25';
                    // Initialize widget bottom position if not exists
                    $cht_side_spacing = ($cht_side_spacing) ? $cht_side_spacing : '25';
                    // Initialize widget left/Right position if not exists
                    $image_id = "";
                    $imageUrl = plugin_dir_url("")."chaty-pro/admin/assets/images/chaty-default.png";
                    // Initialize default image
                    $analytics = get_option("cht_google_analytics".$index);
                    // check for google analytics enable or not
                    $analytics = empty($analytics) ? 0 : $analytics;
                    // Initialize google analytics flag to 0 if not data not exists
                    $text = get_option("cht_close_button_text".$index);
                    // close button settings
                    $close_text = ($text === false) ? "Hide" : $text;

                    $imageUrl = "";
                    if ($image_id != "") {
                        $image_data = wp_get_attachment_image_src($image_id, "full");
                        if (!empty($image_data) && is_array($image_data)) {
                            $imageUrl = $image_data[0];
                            // change close button image if exists
                        }
                    }

                    $font_family = get_option('cht_widget_font'.$index);
                    // add inline css for custom position
                    if ($position != "custom") {
                        $positionSide       = $position;
                        $cht_bottom_spacing = 25;
                        $cht_side_spacing   = 25;
                    } else {
                        $position = $positionSide;
                    }

                    $animation_class = get_option("chaty_attention_effect".$index);
                    $animation_class = empty($animation_class) ? "" : $animation_class;

                    $time_trigger = get_option("chaty_trigger_on_time".$index);
                    $time_trigger = empty($time_trigger) ? "no" : $time_trigger;

                    $trigger_time = get_option("chaty_trigger_time".$index);
                    $trigger_time = (empty($trigger_time) || !is_numeric($trigger_time) || $trigger_time < 0) ? 0 : $trigger_time;
                    if (empty($trigger_time)) {
                        $time_trigger = "no";
                    }

                    /*
                        $hide_widget = get_option("chaty_trigger_hide" . $index);
                        $hide_widget = empty($hide_widget) ? "no" : $hide_widget;

                        $hide_time = get_option("chaty_trigger_hide_time" . $index);
                        $hide_time = (empty($hide_time) || !is_numeric($hide_time) || $hide_time < 0) ? 0 : $hide_time;
                        if(empty($hide_time)) {
                        $hide_widget = "no";
                    }*/

                    $hide_widget = "no";
                    $hide_time   = 0;

                    $exit_intent = get_option("chaty_trigger_on_exit".$index);
                    $exit_intent = empty($exit_intent) ? "no" : $exit_intent;

                    $on_page_scroll = get_option("chaty_trigger_on_scroll".$index);
                    $on_page_scroll = empty($on_page_scroll) ? "no" : $on_page_scroll;

                    $page_scroll = get_option("chaty_trigger_on_page_scroll".$index);
                    $page_scroll = (empty($page_scroll) || !is_numeric($page_scroll) || $page_scroll < 0) ? 0 : $page_scroll;
                    if (empty($page_scroll)) {
                        $on_page_scroll = "no";
                    }

                    $state = get_option("chaty_default_state".$index);
                    $state = empty($state) ? "click" : $state;

                    $mode = get_option("chaty_icons_view".$index);
                    $mode = empty($mode) ? "vertical" : $mode;

                    $has_close_button = get_option("cht_close_button".$index);
                    $has_close_button = empty($has_close_button) ? "yes" : $has_close_button;

                    $countries = get_option("chaty_countries_list".$index);
                    $countries = ($countries === false || empty($countries) || !is_array($countries)) ? [] : $countries;
                    if (count($countries) == 240) {
                        $countries = [];
                    }

                    $display_days  = get_option("cht_date_and_time_settings".$index);
                    $display_rules = [];

                    $gmt = "";
                    if (!empty($display_days)) {
                        $count = 0;
                        foreach ($display_days as $key => $value) {
                            if ($count == 0) {
                                if (isset($value['gmt']) && !empty($value['gmt'])) {
                                    if (is_numeric($value['gmt'])) {
                                        if ($value['gmt'] == 0) {
                                            $difference = "UTC";
                                        } else if ($value['gmt'] > 0) {
                                            $difference = "+".trim($value['gmt'], "+");
                                        } else {
                                            $difference = $value['gmt'];
                                        }
                                    } else {
                                        $difference = $value['gmt'];
                                    }

                                    $gmt = $difference;
                                } else {
                                    $gmt = "UTC";
                                }

                                $count++;
                            }//end if

                            if ($value['end_time'] == "00:00") {
                                $value['end_time'] = "23:59:59";
                            }

                            $start_time = $value['start_time'];
                            $end_time   = $value['end_time'];
                            $start_time = date("H:i", strtotime(date("Y-m-d ".$start_time)));
                            $end_time   = date("H:i", strtotime(date("Y-m-d ".$end_time)));
                            if ($end_time >= $start_time) {
                                $record         = [];
                                $record['days'] = ($value['days'] - 1);
                                $record['start_time']  = $value['start_time'];
                                $record['start_hours'] = intval(date("G", strtotime(date("Y-m-d ".$value['start_time']))));
                                $record['start_min']   = intval(date("i", strtotime(date("Y-m-d ".$value['start_time']))));
                                $record['end_time']    = $value['end_time'];
                                $record['end_hours']   = intval(date("G", strtotime(date("Y-m-d ".$value['end_time']))));
                                $record['end_min']     = intval(date("i", strtotime(date("Y-m-d ".$value['end_time']))));
                                $display_rules[]       = $record;
                            } else {
                                $record         = [];
                                $record['days'] = ($value['days'] - 1);
                                $record['start_time']  = $value['start_time'];
                                $record['start_hours'] = intval(date("G", strtotime(date("Y-m-d ".$value['start_time']))));
                                $record['start_min']   = intval(date("i", strtotime(date("Y-m-d ".$value['start_time']))));
                                $record['end_time']    = "23:59";
                                $record['end_hours']   = 23;
                                $record['end_min']     = 59;
                                $display_rules[]       = $record;
                                $record = [];
                                if ($value['days'] >= 1 && $value['days'] <= 6) {
                                    $value['days'] = ($value['days'] + 1);
                                } else if ($value['days'] == 7) {
                                    $value['days'] = 1;
                                }

                                $record['days']        = ($value['days'] - 1);
                                $record['start_time']  = "00:00";
                                $record['start_hours'] = intval(date("G", strtotime(date("Y-m-d 00:00"))));
                                $record['start_min']   = intval(date("i", strtotime(date("Y-m-d 00:00"))));
                                $record['end_time']    = $value['end_time'];
                                $record['end_hours']   = intval(date("G", strtotime(date("Y-m-d ".$value['end_time']))));
                                $record['end_min']     = intval(date("i", strtotime(date("Y-m-d ".$value['end_time']))));
                                $display_rules[]       = $record;
                            }//end if
                        }//end foreach
                    }//end if

                    $display_conditions = 0;
                    if (!empty($display_rules)) {
                        $display_conditions = 1;
                    }

                    // checking for date and time
                    $cht_date_rules = get_option("cht_date_rules".$index);
                    $date_status    = 0;
                    $start_date     = "";
                    $end_date       = "";
                    $time_diff      = 0;
                    if (isset($cht_date_rules['status']) && $cht_date_rules['status'] == "yes") {
                        $start_date = isset($cht_date_rules['start_date']) ? $cht_date_rules['start_date'] : "";
                        $end_date   = isset($cht_date_rules['end_date']) ? $cht_date_rules['end_date'] : "";
                        $start_time = isset($cht_date_rules['start_time']) ? $cht_date_rules['start_time'] : "";
                        $end_time   = isset($cht_date_rules['end_time']) ? $cht_date_rules['end_time'] : "";
                        if (!empty($start_date)) {
                            $start_date = $this->getYMDDate($start_date);
                            if (!empty($start_time)) {
                                $start_date = $start_date." ".$start_time.":00";
                            } else {
                                $start_date = $start_date." 00:00:00";
                            }
                        }

                        if (!empty($end_date)) {
                            $end_date = $this->getYMDDate($end_date);
                            if (!empty($end_time)) {
                                $end_date = $end_date." ".$end_time.":00";
                            } else {
                                $end_date = $end_date." 23:59:59";
                            }
                        }

                        if (!empty($start_date) || !empty($end_date)) {
                            $date_status = 1;
                            if (isset($cht_date_rules['timezone']) && !empty($cht_date_rules['timezone'])) {
                                $time_zone = $cht_date_rules['timezone'];
                                if (strpos($time_zone, "UTC") == 0) {
                                    $difference = str_replace('UTC', '', $cht_date_rules['timezone']);
                                } else {
                                    $difference = $time_zone;
                                }

                                $time_diff = $difference;
                            } else {
                                $time_diff = "UTC";
                            }

                            // if(!empty($start_date)) {
                            // $start_date = strtotime($start_date);
                            // }
                            // if(!empty($end_date)) {
                            // $end_date = strtotime($end_date);
                            // }
                        }//end if
                    }//end if

                    $custom_css = get_option('chaty_custom_css'.$index);
                    $custom_css = trim(preg_replace('/\s\s+/', '', $custom_css));

                    $pending_messages = get_option("cht_pending_messages".$index);
                    $pending_messages = ($pending_messages === false) ? "off" : $pending_messages;

                    $click_setting = get_option("cht_cta_action".$index);
                    $click_setting = ($click_setting === false) ? "click" : $click_setting;

                    $cht_number_of_messages = get_option("cht_number_of_messages".$index);
                    $cht_number_of_messages = ($cht_number_of_messages === false) ? 0 : $cht_number_of_messages;

                    $number_color = get_option("cht_number_color".$index);
                    $number_color = ($number_color === false) ? "#ffffff" : $number_color;

                    $number_bg_color = get_option("cht_number_bg_color".$index);
                    $number_bg_color = ($number_bg_color === false) ? "#dd0000" : $number_bg_color;

                    $cht_cta_text_color = get_option("cht_cta_text_color".$index);
                    $cht_cta_text_color = ($cht_cta_text_color === false) ? "#333333" : $cht_cta_text_color;

                    $cht_cta_bg_color = get_option("cht_cta_bg_color".$index);
                    $cht_cta_bg_color = ($cht_cta_bg_color === false) ? "#ffffff" : $cht_cta_bg_color;

                    if (empty($cht_number_of_messages)) {
                        $pending_messages = "off";
                    }

                    if (empty($bg_color)) {
                        $bg_color = '#A886CD';
                    }

                    $bg_color = strtolower($bg_color);
                    if (strpos($bg_color, "#") === false && strpos($bg_color, "rgb") === false) {
                        $bg_color = "#".$bg_color;
                    }

                    $state = ($state == "open") ? "open" : $state;
                    if ($state == "open") {
                        $pending_messages = 0;
                        $cta = "";
                        $animation_class = "";
                    }

                    // widget setting array
                    $setting = [];
                    $setting['show_close_button'] = $has_close_button;
                    $setting['position']          = $position;
                    $setting['custom_position']   = 1;
                    $setting['bottom_spacing']    = $cht_bottom_spacing;
                    $setting['side_spacing']      = $cht_side_spacing;
                    $setting['icon_view']         = $mode;
                    $setting['default_state']     = $state;
                    $setting['cta_text']          = html_entity_decode($cta);
                    $setting['cta_text_color']    = $cht_cta_text_color;
                    $setting['cta_bg_color']      = $cht_cta_bg_color;
                    $setting['show_cta']          = ($click_setting == "click") ? "first_click" : "all_time";
                    $setting['is_pending_mesg_enabled']    = $pending_messages;
                    $setting['pending_mesg_count']         = $cht_number_of_messages;
                    $setting['pending_mesg_count_color']   = $number_color;
                    $setting['pending_mesg_count_bgcolor'] = $number_bg_color;
                    $setting['widget_icon']        = get_option('widget_icon'.$index);
                    $setting['widget_icon_url']    = $this->getCustomWidgetImg($index);
                    $setting['font_family']        = $font_family;
                    $setting['widget_size']        = $cht_widget_size;
                    $setting['custom_widget_size'] = $cht_widget_size;
                    $setting['is_google_analytics_enabled'] = $analytics;
                    $setting['close_text']       = $close_text;
                    $setting['widget_color']     = $bg_color;
                    $setting['widget_rgb_color'] = $this->getRGBColor($bg_color);
                    $setting['has_custom_css']   = empty($custom_css) ? 0 : 1;
                    $setting['custom_css']       = $custom_css;
                    $setting['widget_token']     = wp_create_nonce("chaty_widget_nonce".$index);
                    $setting['widget_index']     = $index;
                    $setting['attention_effect'] = $animation_class;

                    $widgetSetting       = [];
                    $widgetSetting['id'] = empty($index) ? 0 : $index;
                    $widgetSetting['identifier'] = $widgetSetting['id'];
                    $widgetSetting['settings']   = $setting;

                    $trigger = [];
                    $trigger['has_time_delay'] = ($time_trigger == "yes") ? 1 : 0;
                    $trigger['time_delay']     = $trigger_time;
                    $trigger['exit_intent']    = ($exit_intent == "yes") ? 1 : 0;
                    $trigger['has_display_after_page_scroll'] = ($on_page_scroll == "yes") ? 1 : 0;
                    $trigger['display_after_page_scroll']     = $page_scroll;
                    $trigger['auto_hide_widget'] = ($hide_widget == "yes") ? 1 : 0;
                    $trigger['hide_after']       = $hide_time;

                    $trigger['show_on_pages_rules'] = [];

                    $trigger['time_diff'] = $time_diff;
                    $trigger['has_date_scheduling_rules'] = $date_status;
                    $trigger['date_scheduling_rules']     = [
                        'start_date_time' => $start_date,
                        'end_date_time'   => $end_date,

                    ];
                    $trigger['date_scheduling_rules_timezone'] = $time_diff;

                    $trigger['day_hours_scheduling_rules_timezone'] = 0;
                    $trigger['has_day_hours_scheduling_rules']      = $display_conditions;
                    $trigger['day_hours_scheduling_rules']          = $display_rules;
                    $trigger['day_time_diff']        = $gmt;
                    $trigger['show_on_direct_visit'] = 0;
                    $trigger['show_on_referrer_social_network'] = 0;
                    $trigger['show_on_referrer_search_engines'] = 0;
                    $trigger['show_on_referrer_google_ads']     = 0;
                    $trigger['show_on_referrer_urls']           = [];
                    $trigger['has_show_on_specific_referrer_urls'] = 0;
                    $trigger['has_traffic_source'] = 0;
                    $trigger['has_countries']      = count($countries) ? 1 : 0;
                    $trigger['countries']          = $countries;
                    $trigger['has_target_rules']   = 0;

                    $widgetSetting['triggers'] = $trigger;

                    $widgetSetting['channels'] = $social;

                    $this->widget_settings[] = $widgetSetting;
                }//end if
            }//end if
        }//end if

    }//end get_widget_settings()


    public function getYMDDate($date)
    {
        $date       = explode("/", $date);
        $month      = isset($date[0]) ? $date[0] : "00";
        $month_date = isset($date[1]) ? $date[1] : "00";
        $year       = isset($date[2]) ? $date[2] : "0000";
        return $year."-".$month."-".$month_date;

    }//end getYMDDate()


    public function getVisitorTrafficSource($index="")
    {

        $traffic_source = get_option("chaty_traffic_source".$index);
        if ($traffic_source === false || $traffic_source != "yes") {
            return true;
        }

        $origin_landing_page = '';
        $HTTP_REFERER        = ( isset($_SERVER['HTTP_REFERER'])) ? $_SERVER['HTTP_REFERER'] : '';
        if (isset($_COOKIE['CHATY_HTTP_REFERER']) && $_COOKIE['CHATY_HTTP_REFERER'] != '') {
            $HTTP_REFERER = $_COOKIE['CHATY_HTTP_REFERER'];
        }

        if ($HTTP_REFERER != '') {
            @setcookie('CHATY_HTTP_REFERER', $HTTP_REFERER, (time() + (86400 * 30)), "/");
            // 86400 = 1 day
        }

        $chaty_traffic_source = get_option("chaty_traffic_source".$index);
        if ($chaty_traffic_source == "yes") {
            $direct_visit     = get_option("chaty_traffic_source_direct_visit".$index);
            $social_network   = get_option("chaty_traffic_source_social_network".$index);
            $search_engines   = get_option("chaty_traffic_source_search_engine".$index);
            $google_ads       = get_option("chaty_traffic_source_google_ads".$index);
            $other_source_url = get_option("chaty_custom_traffic_rules".$index);
            $other_source_url = !is_array($other_source_url) ? [] : $other_source_url;
            $url_setting      = [];
            foreach ($other_source_url as $setting) {
                if (!empty($setting['url_value'])) {
                    $url_setting[] = $setting;
                }
            }

            if ($direct_visit != "yes" && $social_network != "yes" && $search_engines != "yes" && $google_ads != "yes" && empty($url_setting)) {
                return "no-rule";
            }

            if (isset($_COOKIE['chaty_traffic_source-'.$index]) &&  $_COOKIE['chaty_traffic_source-'.$index] != '') {
                return $_COOKIE['chaty_traffic_source-'.$index];
            }

            $coupon_traffic_source = $this->trafficSource();

            $response        = false;
            $visitor_referel = ( (isset($HTTP_REFERER) && $HTTP_REFERER != '' ) ? parse_url($HTTP_REFERER)['host'] : '' );

            if (( ( empty($visitor_referel) || $_SERVER['HTTP_HOST'] == $visitor_referel || (isset($_SERVER['HTTP_ORIGIN']) && (parse_url($_SERVER['HTTP_ORIGIN'])['host'] == $visitor_referel )) ) ) &&  $direct_visit == "yes") {
                $response = "direct_link";
            }

            if (!$response && $search_engines == "yes") {
                foreach ($coupon_traffic_source['search_engine'] as $source) {
                    if ((strpos($visitor_referel, $source) !== false)) {
                        if ($source == "google." && strpos($visitor_referel, "plus.google") !== false) {
                            break;
                        } else {
                            $response = "search_engine";
                            break;
                        }
                    }
                }
            }

            // if social_media
            if (!$response && $social_network == "yes") {
                foreach ($coupon_traffic_source['social_media'] as $source) {
                    if (strpos($visitor_referel, $source) !== false) {
                        $response = "social_media";
                        break;
                    }
                }
            }

            // if google_ads
            if ($google_ads == "yes" && !$response &&  isset($origin_landing_page) && !empty($origin_landing_page)) {
                if ((strpos($origin_landing_page, 'gclid=') !== false)) {
                    $response = "google_ads";
                }
            }

            if (!empty($url_setting) && !$response) {
                $flag = $this->checkSpecifixUrlInRolesTrafficSource($index);
                if ($flag) {
                    $response = "specific_url";
                } else {
                    $response = false;
                }
            }
        } else {
            $response = "no-rule";
        }//end if

        return $response;

    }//end getVisitorTrafficSource()


    function checkSpecifixUrlInRolesTrafficSource($index)
    {
        $flag       = true;
        $flag_array = [];
        $contain_flag_array     = [];
        $not_contain_flag_array = [];

        $HTTP_REFERER = ( isset($_SERVER['HTTP_REFERER'])) ? $_SERVER['HTTP_REFERER'] : '';
        if (isset($_COOKIE['CHATY_HTTP_REFERER']) && $_COOKIE['CHATY_HTTP_REFERER'] != '') {
            $HTTP_REFERER = $_COOKIE['CHATY_HTTP_REFERER'];
        }

        $referer = (isset($HTTP_REFERER) ? parse_url($HTTP_REFERER) : 'empty' );

        if ($referer == 'empty' || !isset($referer['host'])) {
            return true;
        }

        $referer_host  = $this->removeWWW($referer['host']);
        $query         = (isset($referer['query']) && !empty($referer['query']) ? '?'.$referer['query'] : '');
        $referer_path  = $referer['path'].$query;
        $referer_path  = strtolower(str_replace("/", "%2f", $referer_path));
        $contain_array = [];
        $not_contain_array = [];
        $url_settings      = get_option("chaty_custom_traffic_rules".$index);
        foreach ($url_settings as $setting) {
            if (!empty($setting['url_value'])) {
                if ($setting['url_option'] == "contain") {
                    $contain_array[] = [
                        $setting['url_option'],
                        $setting['url_value'],
                    ];
                } else {
                    $not_contain_array[] = [
                        $setting['url_option'],
                        $setting['url_value'],
                    ];
                }
            }
        }

        if (empty($contain_array) && empty($not_contain_array)) {
            return true;
        }

        // echo "<pre>"; print_r($contain_array); die;
        if (!empty($contain_array)) {
            foreach ($contain_array as $key => $value) {
                $role_link = parse_url($value[1]);
                $role_host = $this->removeWWW($role_link['host']);
                $role_path = '';
                if (isset($role_link['path'])) {
                    $role_path = $role_link['path'];
                } else {
                    $role_path = '';
                }

                if (isset($role_link['query'])) {
                    $role_path .= '?'.$role_link['query'];
                }

                $role_path = (preg_match("/\p{Hebrew}/u", $role_path) ? $role_path : str_replace("/", "%2f", $role_path));
                $role_path = strtolower(str_replace("&amp;", "&", $role_path));
                $role_path = trim($role_path);
                if ($role_path == '') {
                    $role_path = '/';
                }

                if ($referer_path == '') {
                    $referer_path = '/';
                }

                if ($role_host != $referer_host) {
                    $flag = false;
                } else if (empty($role_path) && empty($referer_path)) {
                    $flag = true;
                } else if (strtolower(urlencode($role_path)) == strtolower($referer_path) && strtolower($referer_path) == '%2f') {
                    $flag = true;
                } else {
                    switch ($value[0]) {
                    case 'contain':
                        if (empty($role_path) && !empty($referer_path)) {
                            $flag = true;
                        } else if ($role_path == "/" || $role_path == "%2f") {
                            $flag = true;
                        } else if (strpos($referer_path, ( preg_match("/\p{Hebrew}/u", $role_path) ? strtolower(urlencode($role_path)) : strtolower($role_path) )) !== false) {
                            $flag = true;
                        } else if (strpos($referer_path.'/', ( preg_match("/\p{Hebrew}/u", $role_path) ? strtolower(urlencode($role_path)) : strtolower($role_path) )) !== false) {
                            $flag = true;
                        } else if (strpos($referer_path.'%2f', ( preg_match("/\p{Hebrew}/u", $role_path) ? strtolower(urlencode($role_path)) : strtolower($role_path) )) !== false) {
                            $flag = true;
                        } else {
                            $flag = false;
                        }
                        break;
                    }

                    $and = $flag;
                }//end if

                $flag_array[]         = $flag;
                $contain_flag_array[] = $flag;
            }//end foreach
        }//end if

        if (!empty($not_contain_array)) {
            foreach ($not_contain_array as $key => $value) {
                $role_link = parse_url($value[1]);

                $role_host = $this->removeWWW($role_link['host']);

                $role_path = '';
                if (isset($role_link['path'])) {
                    $role_path = $role_link['path'];
                } else {
                    $role_path = '';
                }

                if (isset($role_link['query'])) {
                    $role_path .= '?'.$role_link['query'];
                }

                $role_path = (preg_match("/\p{Hebrew}/u", $role_path) ? $role_path : str_replace("/", "%2f", $role_path));
                $role_path = str_replace("&amp;", "&", $role_path);
                $role_path = trim($role_path);
                if ($role_path == '') {
                    $role_path = '/';
                }

                if ($referer_path == '') {
                    $referer_path = '/';
                }

                if ($role_host == $referer_host && (empty($role_path) || $role_path == "%2f") && (empty($referer_path) || $referer_path == "%2f")) {
                    $flag = false;
                } else {
                    switch ($value[0]) {
                    case 'not_contain':
                        if (isset($referer_path) && strpos(strtolower($referer_path), ((preg_match("/\p{Hebrew}/u", $role_path)) ? strtolower(urlencode($role_path)) : strtolower($role_path))) !== false) {
                            $flag = false;
                        } else if ($role_path == "/" || $role_path == "%2f") {
                            $flag = false;
                        } else {
                            $flag = true;
                        }
                        break;
                    }
                }

                $flag_array[] = $flag;
                $not_contain_flag_array[] = $flag;
            }//end foreach
        }//end if

        if (!empty($not_contain_array) && empty($contain_array)) {
            return (in_array(false, $not_contain_flag_array) ? false : true );
        } else if (!empty($not_contain_array) && !empty($contain_array)) {
            if (in_array(false, $not_contain_flag_array)) {
                return false;
            } else {
                return (in_array(true, $contain_flag_array) ? true : false );
            }
        } else if (empty($not_contain_array) && !empty($contain_array)) {
            return (in_array(true, $contain_flag_array) ? true : false );
        } else {
            return $flag;
        }

    }//end checkSpecifixUrlInRolesTrafficSource()


    function removeWWW($url)
    {
        return str_replace('www.', '', $url);

    }//end removeWWW()


    // returns traffic source list
    public function trafficSource()
    {
        $traffic_source = [
            "search_engine" => [
                'accoona',
                'ansearch',
                'biglobe',
                'daum',
                'egerin	',
                'leit.is',
                'maktoob',
                'miner.hu',
                'najdi.si',
                'najdi.org',
                'naver',
                'rambler',
                'rediff',
                'sapo',
                'search.ch',
                'sesam',
                'seznam',
                'walla',
                'zipLoca',
                'slurp',
                'search.msn.com',
                'nutch',
                'simpy',
                'bot.',
                'aspSeek',
                'crawler.',
                'msnbot',
                'libwww-perl',
                'fast',
                'baidu.',
                'bing.',
                'google.',
                'duckduckgo',
                'ecosia',
                'exalead',
                'giablast',
                'munax',
                'qwant',
                'sogou',
                'soso',
                'yahoo.',
                'yandex.',
                'youdao',
                'aol.',
                'hotbot.',
                'webcrawler.',
                'eniro',
                'naver',
                'lycos',
                'ask',
                'altavista',
                'netscape',
                'about',
                'mamma',
                'alltheweb',
                'voila',
                'live',
                'alice',
                'mama',
                'wp.pl',
                'onecenter',
                'szukacz',
                'yam',
                'kvasir',
                'ozu',
                'terra',
                'pchome',
                'mynet',
                'ekolay',
                'rembler',
            ],
            "social_media"  => [
                "facebook.",
                "instagram.",
                "linkedin.",
                "myspace.",
                "twitter.",
                "t.co",
                "plus.google",
                "disqus.",
                "snapchat.",
                "tumbler.",
                "pinterest.",
                "twoo",
                "mymfb",
                "youtube.",
                "vine",
                "whatsapp",
                "vk.com",
                "secret",
                "medium",
                "bebo",
                "friendster",
                "hi5",
                "habbo",
                "ning",
                "classmates",
                "tagged",
                "myyearbook",
                "meetup",
                "mylife",
                "reunion",
                "flixster",
                "myheritage",
                "multiply",
                "orkut",
                "badoo",
                "gaiaonline",
                "blackplanet",
                "skyrock",
                "perfspot",
                "zorpia",
                "netlog",
                "tuenti",
                "nasza-klasa.pl",
                "irc-gallery",
                "studivz",
                "xing",
                "renren",
                "kaixin001",
                "hyves.nl",
                "MillatFacebook",
                "ibibo",
                "sonico",
                "wer-kennt-wen",
                "cyworld",
                "iwiw",
                "dribbble.",
                "stumbleupon.",
                "flickr.",
                "plaxo.",
                "digg.",
                "del.icio.us",
            ],
        ];
        return $traffic_source;

    }//end trafficSource()


    // returns for widget is active or not
    private function canInsertWidget()
    {

        $flag       = false;
        $status     = get_option('cht_active') && $this->checkChannels() && $this->check_for_url();
        $is_deleted = get_option("cht_is_default_deleted");
        if ($status && $is_deleted === false) {
            $this->get_widget_settings();
            $flag = true;
        }

        $deleted_list = get_option("chaty_deleted_settings");
        if (empty($deleted_list) || !is_array($deleted_list)) {
            $deleted_list = [];
        }

        $chaty_widgets = get_option("chaty_total_settings");
        if (!empty($chaty_widgets) && $chaty_widgets != null && is_numeric($chaty_widgets) && $chaty_widgets > 0) {
            for ($i = 1; $i <= $chaty_widgets; $i++) {
                if (!in_array($i, $deleted_list)) {
                    $this->widget_number = "_".$i;
                    $status = get_option('cht_active_'.$i) && $this->checkChannels() && $this->check_for_url();
                    if ($status) {
                        $this->get_widget_settings("_".$i);
                        $flag = true;
                    }
                }
            }
        }

        return $flag;

    }//end canInsertWidget()


    // checking for social channels
    private function checkChannels()
    {
        $social = explode(",", get_option('cht_numb_slug'.$this->widget_number));
        $res    = false;
        foreach ($social as $name) {
            $value = get_option('cht_social'.$this->widget_number.'_'.strtolower($name));
            $res   = $res || !empty($value['value']) || ($name == "Contact_Us") || (isset($value['is_agent']) && $value['is_agent']);
        }

        return $res;

    }//end checkChannels()


}//end class


return new CHT_PRO_Frontend();
