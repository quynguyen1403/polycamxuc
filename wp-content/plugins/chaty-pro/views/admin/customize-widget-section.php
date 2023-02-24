<?php
if (!defined('ABSPATH')) {
    exit;
}

// wp_enqueue_media();
wp_enqueue_style('wp-color-picker');

// hide/show on page variable
$url_options = [
    'home'            => "Homepage",
    'page_contains'   => 'pages that contain',
    'page_has_url'    => 'a specific page',
    'page_start_with' => 'pages starting with',
    'page_end_with'   => 'pages ending with',
];
?>
<?php $class = count($this->socials) > 1 ? "active" : ""; ?>
<section class="section">


    <div class="form-horizontal grid gap-7">
        <?php
        $color = get_option('cht_color'.$this->widget_index);
        $color = empty($color) ? '#A886CD' : $color;
        ?>
        <div class="form-horizontal__item o-channel social-widget-color <?php echo esc_attr($class) ?>">
            <label class="align-top form-horizontal__item-label font-primary text-cht-gray-150 text-base block mb-3"><?php esc_html_e('Color', 'chaty'); ?>:</label>
            <div>
                <input type="text" name="cht_color" class="chaty-color-field" value="<?php echo esc_attr($color) ?>">
            </div>
        </div>

        <?php
        // Position ?>
        <div class="form-horizontal__item">
            <label class="align-top form-horizontal__item-label font-primary text-cht-gray-150 text-base block mb-3">Position:</label>
            <div>
                <?php $position = get_option('cht_position'.$this->widget_index); ?>
                <div class="tab-tab-select bg-cht-gray-50 rounded-md p-1 inline-flex flex-wrap items-center">
                    <label class="custom-control custom-radio" for="left-position">
                        <input type="radio" id="left-position" name="cht_position" class="custom-control-input" <?php checked($position, "left") ?> value="left" />
                        <span class="custom-control-label"><?php esc_html_e('Left', 'chaty'); ?></span>
                    </label>

                    <label class="custom-control custom-radio" for="right-position">
                        <input type="radio" id="right-position" name="cht_position" class="custom-control-input" <?php checked($position, "right") ?> value="right" />
                        <span class="custom-control-label"><?php esc_html_e('Right', 'chaty'); ?></span>
                    </label>

                    <?php if ($this->is_pro()) : ?>
                        <label class="custom-control custom-radio" for="positionCustom">
                            <input type="radio" id="positionCustom" name="cht_position" class="custom-control-input position-pro-radio" <?php checked($position, "custom") ?>  value="custom" />
                            <span class="custom-control-label">
                                <?php esc_html_e('Custom Position', 'chaty'); ?>
                            </span>
                        </label>
                    <?php else : ?>
                        <div class="custom-control ml-1 group relative">
                            <span class="custom-control pointer-events-none custom-radio free-custom-radio">
                                <input type="radio" class="custom-control-input" disabled>
                                <span class="custom-control-label"><?php esc_html_e('Custom Position', 'chaty'); ?> </span>
                            </span>
                            <a 
                                target="_blank" 
                                class="absolute opacity-0 group-hover:opacity-100 left-0 top-0 bg-cht-primary w-full h-full rounded-[3px] inline-flex justify-center items-center text-base text-white hover:text-white" 
                                href="<?php echo esc_url($this->getUpgradeMenuItemUrl()); ?>">
                                    <?php esc_html_e('Activate your key', 'chaty'); ?>
                            </a>
                        </div>
                        
                    <?php endif; ?>
                </div>

                <div id="positionPro" style="display: <?php echo esc_attr(($position === 'custom') ? 'block' : 'none'); ?>" >
                    <div class="position-pro max-w-[410px]">
                        <div>
                            <label class="text-cht-gray-150/70">Side selection:</label>
                            <?php $positionSide = get_option('positionSide'.$this->widget_index) ?>
                            <?php $pos_custom = empty($positionSide) ? 'right' : $positionSide; ?>
                            <?php $pos_custom = ($pos_custom != 'left' && $pos_custom != 'right') ? 'right' : $pos_custom; ?>
                            <div class="tab-tab-select bg-cht-gray-50 inline-block rounded-md p-1">
                                <label class="custom-control custom-radio custom-radio-btn">
                                    <input type="radio" value="left" name="positionSide" class="custom-control-input" <?php checked($pos_custom, "left") ?> />
                                    <span class="custom-control-label">
                                    <?php esc_html_e('Left', 'chaty'); ?>
                                    </span>
                                </label>
                                <label class="custom-control custom-radio custom-radio-btn">
                                    <input type="radio" value="right" name="positionSide" class="custom-control-input" <?php checked($pos_custom, "right") ?> />
                                    <span class="custom-control-label">
                                        <?php esc_html_e('Right', 'chaty'); ?>
                                    </span>
                                </label>
                            </div>
                        </div>

                        <div class="text-cht-gray-150/70">
                            <label><?php esc_html_e('Bottom spacing', 'chaty'); ?>:</label>
                            <?php
                            $cht_bottom_spacing = get_option('cht_bottom_spacing'.$this->widget_index);
                            $cht_bottom_spacing = !empty($cht_bottom_spacing) ? $cht_bottom_spacing : 25;
                            ?>
                            <input type="number" name="cht_bottom_spacing" id="positionBottom" min="0" max="2000" value="<?php echo esc_attr($cht_bottom_spacing)  ?>" placeholder="25">px
                        </div>

                        <div class="text-cht-gray-150/70">
                            <label><?php esc_html_e('Side spacing', 'chaty'); ?>:</label>
                            <?php
                            $cht_side_spacing = get_option('cht_side_spacing'.$this->widget_index);
                            $cht_side_spacing = !empty($cht_side_spacing) ? $cht_side_spacing : 25;
                            ?>
                            <input type="number" name="cht_side_spacing" id="positionSide" min="0" max="2000" value="<?php echo esc_attr($cht_side_spacing) ?>" placeholder="25">px
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="form-horizontal__item chaty-icon-view active">
            <label class="form-horizontal__item-label font-primary text-cht-gray-150 text-base block mb-3" for="chaty_icons_view"><?php esc_html_e('Icons view', 'chaty');?>:</label>
            <div>
                <?php
                $mode  = get_option('chaty_icons_view'.$this->widget_index);
                $mode  = empty($mode) ? "vertical" : $mode;
                ?>
                <div class="tab-tab-select bg-cht-gray-50 inline-block rounded-md p-1">
                    <label class="custom-control custom-radio" for="vertical-position">
                        <input type="radio" id="vertical-position" name="chaty_icons_view" class="custom-control-input" <?php checked($mode, "vertical") ?> value="vertical" />
                        <span class="custom-control-label"><?php esc_html_e('Vertical', 'chaty'); ?></span>
                    </label>

                    <label class="custom-control custom-radio" for="horizontal-position">
                        <input type="radio" id="horizontal-position" name="chaty_icons_view" class="custom-control-input" <?php checked($mode, "horizontal") ?> value="horizontal" />
                        <span class="custom-control-label"><?php esc_html_e('Horizontal', 'chaty'); ?></span>
                    </label>
                </div>
            </div>
        </div>
        <div class="form-horizontal__item chaty-default-state active">
            <label class="form-horizontal__item-label font-primary text-cht-gray-150 text-base block mb-3"><?php esc_html_e('Default state', 'chaty');?>:</label>
            <div>
                <?php
                $states = [
                    "click" => "Click to open",
                    "hover" => "Hover to open",
                    "open"  => "Opened by default",
                ];
                $state  = get_option('chaty_default_state'.$this->widget_index);
                $state  = empty($state) ? "click" : $state;
                ?>
                <select name="chaty_default_state" id="chaty_default_state" class="chaty-select">
                    <?php foreach ($states as $key => $value) : ?>
                        <option value="<?php echo esc_attr($key); ?>" <?php selected($state, $key); ?>><?php echo esc_attr($value); ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
        </div>
        <div class="form-horizontal__item flex-center hide-show-button <?php echo esc_attr($state == "open" ? "active" : "") ?>" >
            <label class="form-horizontal__item-label font-primary text-cht-gray-150 text-base block mb-3"><?php esc_html_e('Show close button', 'chaty');?>:</label>
            <div>
                <label class="switch">
                    <?php $close_button = get_option('cht_close_button'.$this->widget_index); ?>
                    <?php $close_button = empty($close_button) ? "yes" : $close_button; ?>
                    <input type="hidden" name="cht_close_button" value="no" >
                    <input data-gramm_editor="false" type="checkbox" id="cht_close_button" name="cht_close_button" value="yes" <?php checked($close_button, "yes") ?> >
                    <span class="chaty-slider round"></span>
                </label>
            </div>
        </div>
        <?php
        // Call to Action ?>
        <div class="form-horizontal__item">
            <label class="align-top form-horizontal__item-label font-primary text-cht-gray-150 text-base block mb-3"><?php esc_html_e('Call to action', 'chaty'); ?>:</label>
            <div class="disable-message" data-title='When the default state is set to "Opened by default", the "Call to action" feature doesn&apos;t apply because the Chaty widget is already open.'>
                <?php
                $cta = get_option('cht_cta'.$this->widget_index);
                ?>
                <textarea data-value="<?php echo esc_attr($cta) ?>" class="test_textarea titleColor rounded-lg text-cht-gray-150 text-base font-primary" cols="40" rows="2" name="cht_cta" placeholder="<?php esc_html_e('Message us!', 'chaty'); ?>" ><?php echo esc_attr((wp_unslash($cta))) ?></textarea>
            </div>
        </div>
        <div class="color-setting">
            <div class="color-box flex flex-wrap gap-5">
                <div class="clr-setting">
                    <?php
                    $val = get_option("cht_cta_text_color".$this->widget_index);
                    $val = ($val === false) ? "#333333" : $val;
                    ?>
                    <div class="form-horizontal__item flex items-center gap-3 flex-center">
                        <label class="form-horizontal__item-label font-primary text-cht-gray-150 text-base inline-block"><?php esc_html_e('Call to action text color', 'chaty');?>:</label>
                        <div>
                            <div class="disable-message" data-title='When the default state is set to "Opened by default", the "Attention effect" feature doesn&apos;t apply because the Chaty widget is already open.'>
                                <input value="<?php echo esc_attr($val) ?>" type="text" class="chaty-color-field" name="cht_cta_text_color" id="cht_cta_text_color">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="clr-setting">
                    <?php
                    $val = get_option("cht_cta_bg_color".$this->widget_index);
                    $val = ($val === false) ? "#ffffff" : $val;
                    ?>
                    <div class="form-horizontal__item flex gap-3 items-center flex-center">
                        <label class="form-horizontal__item-label font-primary text-cht-gray-150 text-base inline-block"><?php esc_html_e('Call to action background', 'chaty');?>:</label>
                        <div>
                            <div class="disable-message" data-title='When the default state is set to "Opened by default", the "Attention effect" feature doesn&apos;t apply because the Chaty widget is already open.'>
                                <input value="<?php echo esc_attr($val) ?>" type="text" class="chaty-color-field" name="cht_cta_bg_color" id="cht_cta_bg_color">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="form-horizontal__item flex-center">
            <label class="align-top form-horizontal__item-label font-primary text-cht-gray-150 text-base block mb-3">
                <?php esc_html_e('Call to action behavior', 'chaty'); ?>
                <span
                    class="icon label-tooltip"
                    data-title='Choose how the CTA button would appear. "Hide after first click" hides the CTA button after the first visit. If you select the second option, the CTA stays visible all the time'>
                    <span>
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="none">
                            <path d="M8.00004 14.6654C11.6819 14.6654 14.6667 11.6806 14.6667 7.9987C14.6667 4.3168 11.6819 1.33203 8.00004 1.33203C4.31814 1.33203 1.33337 4.3168 1.33337 7.9987C1.33337 11.6806 4.31814 14.6654 8.00004 14.6654Z" stroke="#72777c" stroke-width="1.33" stroke-linecap="round" stroke-linejoin="round"></path>
                            <path d="M8 10.6667V8" stroke="#72777c" stroke-width="1.33" stroke-linecap="round" stroke-linejoin="round"></path>
                            <path d="M8 5.33203H8.00667" stroke="#72777c" stroke-width="1.33" stroke-linecap="round" stroke-linejoin="round"></path>
                        </svg>
                    </span>
                </span>

            </label>
            <div class="cta-action-radio tab-tab-select bg-cht-gray-50 inline-block rounded-md p-1">
                <?php
                $cta_action = get_option('cht_cta_action'.$this->widget_index);
                $cta_action = empty($cta_action) ? "click" : $cta_action;
                ?>
                <div class=" disable-message" data-title='When the default state is set to "Opened by default", the "Show call to action" feature doesn&apos;t apply because the Chaty widget is already open.' for="all_time-cht_cta_action">
                    <label class="custom-control custom-radio">
                        <input type="radio" id="click-cht_cta_action" name="cht_cta_action" class="custom-control-input" <?php checked($cta_action, "click") ?> value="click" />
                        <span class="custom-control-label"><?php esc_html_e('Hide after first click', 'chaty'); ?></span>
                    </label>
                </div>
                <div class=" disable-message" data-title='When the default state is set to "Opened by default", the "Show call to action" feature doesn&apos;t apply because the Chaty widget is already open.' for="all_time-cht_cta_action">
                    <label class="custom-control custom-radio">
                        <input type="radio" id="all_time-cht_cta_action" name="cht_cta_action" class="custom-control-input" <?php checked($cta_action, "all_time") ?> value="all_time" />
                        <span class="custom-control-label"><?php esc_html_e('Show all the time', 'chaty'); ?></span>
                    </label>
                </div>
            </div>
        </div>

        <div class="form-horizontal__item flex-center">
            <label class="form-horizontal__item-label flex items-center space-x-2 font-primary text-cht-gray-150 text-base mb-3">
                <?php esc_html_e('Attention effect', 'chaty');?>
                <span
                    class="icon label-tooltip"
                    data-title="The attention effect will appear on your site until your website visitors engage with the widget for the first time. After the first engagement, the attention effect will not appear again.">
                    <span class="ml-2">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16" fill="none">
                            <path d="M8.00004 14.6654C11.6819 14.6654 14.6667 11.6806 14.6667 7.9987C14.6667 4.3168 11.6819 1.33203 8.00004 1.33203C4.31814 1.33203 1.33337 4.3168 1.33337 7.9987C1.33337 11.6806 4.31814 14.6654 8.00004 14.6654Z" stroke="#72777c" stroke-width="1.33" stroke-linecap="round" stroke-linejoin="round"></path>
                            <path d="M8 10.6667V8" stroke="#72777c" stroke-width="1.33" stroke-linecap="round" stroke-linejoin="round"></path>
                            <path d="M8 5.33203H8.00667" stroke="#72777c" stroke-width="1.33" stroke-linecap="round" stroke-linejoin="round"></path>
                        </svg>
                    </span>
                </span>
            </label>
            <div class="disable-message" data-title='When the default state is set to "Opened by default", the "Attention effect" feature doesn&apos;t apply because the Chaty widget is already open.'>
                <span class="header-tooltip-text text-center"></span>
                <?php
                $group   = '';
                $effects = [
                    ""           => "None",
                    "jump"       => "Bounce",
                    "waggle"     => "Waggle",
                    "sheen"      => "Sheen",
                    "spin"       => "Spin",
                    "fade"       => "Fade",
                    "shockwave"  => "Shockwave",
                    "blink"      => "Blink",
                    "pulse-icon" => "Pulse",
                ];
                $effect  = get_option('chaty_attention_effect'.$this->widget_index);
                $effect  = empty($effect) ? "" : $effect;
                ?>
                <select name="chaty_attention_effect" class="chaty-select" id="chaty_attention_effect" data-effect="<?php echo esc_attr($effect) ?>">
                    <?php foreach ($effects as $key => $value) : ?>
                        <option value="<?php echo esc_attr($key); ?>" <?php selected($effect, $key); ?>><?php echo esc_attr($value); ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
        </div>

        <div class="form-horizontal__item flex-center">
            <label class="form-horizontal__item-label flex items-center space-x-2 font-primary text-cht-gray-150 text-base mb-2">
                <?php esc_html_e('Pending messages', 'chaty');?>
                <span class="icon label-tooltip" data-title="Increase your click-rate by displaying a pending messages icon near your Chaty widget to let your visitors know that you're waiting for them to contact you.">
                    <span class="ml-2">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16" fill="none">
                            <path d="M8.00004 14.6654C11.6819 14.6654 14.6667 11.6806 14.6667 7.9987C14.6667 4.3168 11.6819 1.33203 8.00004 1.33203C4.31814 1.33203 1.33337 4.3168 1.33337 7.9987C1.33337 11.6806 4.31814 14.6654 8.00004 14.6654Z" stroke="#72777c" stroke-width="1.33" stroke-linecap="round" stroke-linejoin="round"></path>
                            <path d="M8 10.6667V8" stroke="#72777c" stroke-width="1.33" stroke-linecap="round" stroke-linejoin="round"></path>
                            <path d="M8 5.33203H8.00667" stroke="#72777c" stroke-width="1.33" stroke-linecap="round" stroke-linejoin="round"></path>
                        </svg>
                    </span>
                </span>
            </label>
            <div class="disable-message" data-title='When the default state is set to "Opened by default", the "Pending messages" feature doesn&apos;t apply because the Chaty widget is already open.'>
                <label class="switch">
                    <?php
                    $checked      = get_option('cht_pending_messages'.$this->widget_index);
                    $checked      = empty($checked) ? "off" : $checked;
                    $active_class = ($checked == "on") ? "active" : "";
                    ?>
                    <input type="hidden" name="cht_pending_messages" value="off">
                    <input type="checkbox" id="cht_pending_messages" name="cht_pending_messages" value="on" <?php checked($checked, "on") ?> >
                    <span class="chaty-slider round"></span>
                </label>
            </div>
            <div class="pending-message-items <?php echo esc_attr($active_class) ?>">
                <div class="p-5 group-control-wrap items-baseline max-w-[410px]">
                    <?php
                        $val = get_option("cht_number_of_messages".$this->widget_index);
                        $val = ($val === false) ? "1" : $val;
                    ?>
                    <div class="flex mb-3 items-center gap-3">
                        <label class="font-primary text-cht-gray-150 text-base"><?php esc_html_e('Number of messages', 'chaty');?>:</label>
                        <div>
                            <input style="border-color: #eaeff2" min="0" value="<?php echo esc_attr($val) ?>" type="number" class="w-16 border hover:border-cht-primary border-solid text-cht-gray-150 p-[0_!important] rounded-[7px_!important] leading-[36px_!important] text-center" name="cht_number_of_messages" id="cht_number_of_messages">
                        </div>
                    </div>
                    <?php
                        $val = get_option("cht_number_color".$this->widget_index);
                        $val = ($val === false) ? "#ffffff" : $val;
                    ?>
                    <div class="float-left flex mb-3 mr-5 items-center gap-3">
                        <label class="font-primary text-cht-gray-150 text-base"><?php esc_html_e('Number color', 'chaty');?>:</label>
                        <div>
                            <input value="<?php echo esc_attr($val) ?>" type="text" class="chaty-color-field" name="cht_number_color" id="cht_number_color">
                        </div>
                    </div>
                    <?php
                        $val = get_option("cht_number_bg_color".$this->widget_index);
                        $val = ($val === false) ? "#dd0000" : $val;
                    ?>
                    <div class="float-left flex items-center gap-3">
                        <label class="font-primary text-cht-gray-150 text-base"><?php esc_html_e('Background color', 'chaty');?>:</label>
                        <div>
                            <input value="<?php echo esc_attr($val) ?>" type="text" class="chaty-color-field" name="cht_number_bg_color" id="cht_number_bg_color">
                        </div>
                    </div>
                    <div class="clear-both"></div>
                </div>
            </div>
        </div>

        

        <?php $widget_icon = get_option('widget_icon'.$this->widget_index); ?>
        <div class="form-horizontal__item chaty-widget-icon widget-icon__block o-channel <?php echo esc_attr($class) ?>">
            <label class="form-horizontal__item-label font-primary text-cht-gray-150 text-base mb-2 block">Widget icon:</label>
            <?php $pro_class = $this->is_pro() ? "has-pro" : "has-free"; ?>
            <div class="widget-icon__wrap gap-3 sm:gap-6 pb-5 items-center inline-flex <?php echo esc_attr($pro_class)  ?>">
                <label class="custom-control custom-radio relative">
                    <input type="radio" name="widget_icon" class="custom-control-input js-widget-i " value="chat-base" data-type="chat-base" data-gramm_editor="false" <?php checked($widget_icon, "chat-base") ?> />
                    <i class="icon-chat" data-type="chat-base">
                        <svg version="1.1" id="ch" xmlns="http://www.w3.org/2000/svg"
                             xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="-496 507.7 54 54"
                             style="enable-background:new -496 507.7 54 54;" xml:space="preserve">
                            <style type="text/css">.st1 { fill: #FFFFFF; }
                                .st0 { fill: #808080; }
                            </style>
                            <g>
                                <circle cx="-469" cy="534.7" r="27" fill="#a886cd"/>
                            </g>
                            <path class="st1" d="M-459.9,523.7h-20.3c-1.9,0-3.4,1.5-3.4,3.4v15.3c0,1.9,1.5,3.4,3.4,3.4h11.4l5.9,4.9c0.2,0.2,0.3,0.2,0.5,0.2 h0.3c0.3-0.2,0.5-0.5,0.5-0.8v-4.2h1.7c1.9,0,3.4-1.5,3.4-3.4v-15.3C-456.5,525.2-458,523.7-459.9,523.7z"/>
                            <path class="st0" d="M-477.7,530.5h11.9c0.5,0,0.8,0.4,0.8,0.8l0,0c0,0.5-0.4,0.8-0.8,0.8h-11.9c-0.5,0-0.8-0.4-0.8-0.8l0,0C-478.6,530.8-478.2,530.5-477.7,530.5z"/>
                            <path class="st0" d="M-477.7,533.5h7.9c0.5,0,0.8,0.4,0.8,0.8l0,0c0,0.5-0.4,0.8-0.8,0.8h-7.9c-0.5,0-0.8-0.4-0.8-0.8l0,0C-478.6,533.9-478.2,533.5-477.7,533.5z"/>
                        </svg>
                    </i>
                    <span class="custom-control-radio"></span>
                </label>
                <?php $disabled = (!$this->is_pro()) ? "disabled" : ""; ?>

                <label class="custom-control custom-radio relative">
                    <input type="radio" name="widget_icon" class="custom-control-input js-widget-i" value="chat-smile" data-type="chat-smile" data-gramm_editor="false" <?php checked($widget_icon, "chat-smile") ?>  >
                    <i class="icon-chat" data-type="chat-smile">
                        <svg version="1.1" id="smile" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="-496.8 507.1 54 54" style="enable-background:new -496.8 507.1 54 54;" xml:space="preserve">
                            <style type="text/css">.st1 { fill: #FFFFFF; }
                                .st2 { fill: none; stroke: #808080; stroke-width: 1.5; stroke-linecap: round; stroke-linejoin: round; }
                            </style>
                            <g>
                                <circle cx="-469.8" cy="534.1" r="27" fill="#a886cd"/>
                            </g>
                            <path class="st1" d="M-459.5,523.5H-482c-2.1,0-3.7,1.7-3.7,3.7v13.1c0,2.1,1.7,3.7,3.7,3.7h19.3l5.4,5.4c0.2,0.2,0.4,0.2,0.7,0.2c0.2,0,0.2,0,0.4,0c0.4-0.2,0.6-0.6,0.6-0.9v-21.5C-455.8,525.2-457.5,523.5-459.5,523.5z"/>
                            <path class="st2" d="M-476.5,537.3c2.5,1.1,8.5,2.1,13-2.7"/>
                            <path class="st2" d="M-460.8,534.5c-0.1-1.2-0.8-3.4-3.3-2.8"/>
                        </svg>
                    </i>
                    <span class="custom-control-radio"></span>
                </label>


                <label class="custom-control custom-radio relative">
                    <input type="radio" name="widget_icon" class="custom-control-input js-widget-i" value="chat-bubble" data-type="chat-bubble" data-gramm_editor="false" <?php checked($widget_icon, "chat-bubble") ?> />
                    <i class="icon-chat" data-type="chat-bubble">
                        <svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="-496.9 507.1 54 54" style="enable-background:new -496.9 507.1 54 54;" xml:space="preserve">
                            <style type="text/css">.st1 { fill: #FFFFFF; }</style>
                            <g>
                                <circle cx="-469.9" cy="534.1" r="27" fill="#a886cd"/>
                            </g>
                            <path class="st1" d="M-472.6,522.1h5.3c3,0,6,1.2,8.1,3.4c2.1,2.1,3.4,5.1,3.4,8.1c0,6-4.6,11-10.6,11.5v4.4c0,0.4-0.2,0.7-0.5,0.9 c-0.2,0-0.2,0-0.4,0c-0.2,0-0.5-0.2-0.7-0.4l-4.6-5c-3,0-6-1.2-8.1-3.4s-3.4-5.1-3.4-8.1C-484.1,527.2-478.9,522.1-472.6,522.1z M-462.9,535.3c1.1,0,1.8-0.7,1.8-1.8c0-1.1-0.7-1.8-1.8-1.8c-1.1,0-1.8,0.7-1.8,1.8C-464.6,534.6-463.9,535.3-462.9,535.3z M-469.9,535.3c1.1,0,1.8-0.7,1.8-1.8c0-1.1-0.7-1.8-1.8-1.8c-1.1,0-1.8,0.7-1.8,1.8C-471.7,534.6-471,535.3-469.9,535.3z M-477,535.3c1.1,0,1.8-0.7,1.8-1.8c0-1.1-0.7-1.8-1.8-1.8c-1.1,0-1.8,0.7-1.8,1.8C-478.8,534.6-478.1,535.3-477,535.3z"/>
                        </svg>
                    </i>
                    <span class="custom-control-radio"></span>
                </label>


                <label class="custom-control custom-radio relative <?php echo esc_attr(!$this->is_pro() ? "add-border" : "") ?>">
                    <input type="radio" name="widget_icon" class="custom-control-input js-widget-i" value="chat-db" data-type="chat-db" data-gramm_editor="false" <?php checked($widget_icon, "chat-db") ?> />
                    <i class="icon-chat" data-type="chat-db">
                        <svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="-496 507.1 54 54" style="enable-background:new -496 507.1 54 54;" xml:space="preserve">
                            <style type="text/css">.st1 {fill: #FFFFFF;}</style>
                            <g>
                                <circle cx="-469" cy="534.1" r="27" fill="#a886cd"/>
                            </g>
                            <path class="st1" d="M-464.6,527.7h-15.6c-1.9,0-3.5,1.6-3.5,3.5v10.4c0,1.9,1.6,3.5,3.5,3.5h12.6l5,5c0.2,0.2,0.3,0.2,0.7,0.2 c0.2,0,0.2,0,0.3,0c0.3-0.2,0.5-0.5,0.5-0.9v-18.2C-461.1,529.3-462.7,527.7-464.6,527.7z"/>
                            <path class="st1" d="M-459.4,522.5H-475c-1.9,0-3.5,1.6-3.5,3.5h13.9c2.9,0,5.2,2.3,5.2,5.2v11.6l1.9,1.9c0.2,0.2,0.3,0.2,0.7,0.2 c0.2,0,0.2,0,0.3,0c0.3-0.2,0.5-0.5,0.5-0.9v-18C-455.9,524.1-457.5,522.5-459.4,522.5z"/>
                        </svg>
                    </i>
                    <span class="custom-control-radio"></span>
                </label>

                <?php if (!$this->is_pro()) : ?>
                    <div class="custom-control group custom-radio upgrade-upload-btn relative flex">
                <?php else : ?>
                    <label class="custom-control custom-radio relative" id="image-upload-content">
                <?php endif; ?>
                <?php $imgURL = $this->getCustomWidgetImg(); ?>
                <div class="form-group widget-image <?php echo (!empty($imgURL) ? "has-custom-image" : "") ?>" id="image-upload">
                    <div id="elPreviewImage">
                        <img id="outputImage" src="<?php echo esc_url($imgURL) ?>"/>
                        <i class='icon-upload'></i>
                    </div>
                    <div class="file-loading">
                        <input class="sr-only" type="file" id="testUpload" name="cht_widget_img" 
                        <?php if (!$this->is_pro()) { echo 'disabled';} ?> accept="image/*" onchange="loadPreviewFile(event)" >
                    </div>
                </div>
                <span class="custom-control-radio"></span>
                <?php if ($this->is_pro()) : ?>
                    <input type="radio" name="widget_icon" class="custom-control-input js-widget-i js-upload" value="chat-image" data-gramm_editor="false" <?php checked($widget_icon, "chat-image") ?> <?php echo esc_attr($disabled) ?>  data-type="chat-image" id="uploadInput" >
                    
                <?php endif; ?>
                <?php if (!$this->is_pro()) : ?>
                    
                        <a class="bg-cht-primary opacity-0 focus:text-white text-base hidden group-hover:inline-block group-hover:opacity-100 py-1.5 px-2 rounded-[4px] text-white hover:text-white text-center w-[208px] absolute right-0 -bottom-8" target="_blank" href="<?php echo esc_url($this->getUpgradeMenuItemUrl()); ?>"><?php esc_html_e('Activate your license key', 'chaty'); ?></a>
                    </div>
                <?php else : ?>
                    </label>
                <?php endif; ?>


                <script type="text/javascript">
                    (function ($) {
                        $(document).ready(function () {
                            /*$('#testUpload').fileinput({
                                showCaption: false,
                                showCancel: false,
                                showClose: false,
                                showRemove: false,
                                showUpload: false,
                                browseIcon: "<i class='icon-upload'></i>",
                                browseLabel: 'Upload',
                                browseClass: 'file-browse',
                                overwriteInitial: false,
                                initialPreviewCount: false,
                                allowedFileTypes: ['image'],
                                maxFileCount: 1,
                                initialPreviewAsData: true,
                                elPreviewImage: '#elPreviewImage',
                                initialPreview: [
                                    "<?php //echo esc_url($this->getCustomWidgetImg());?>",
                                ],
                                layoutTemplates: {
                                    progress: '',
                                    actionDelete: '',
                                    actionZoom: '',
                                    preview: ''
                                }
                            });*/
                        });
                    }(jQuery));
                </script>
            </div>
        </div>


        <div class="form-horizontal__item font-section">
            <label class="form-horizontal__item-label font-primary text-cht-gray-150 text-base mb-2 inline-block">Font Family:</label>
            <div>
                <?php
                $font = get_option('cht_widget_font'.$this->widget_index);
                $font = empty($font) ? "" : $font;
                ?>
                <select name="cht_widget_font" class="form-fonts">
                    <option value="">Select font family</option>
                    <?php $group = '';
                    foreach ($fonts as $key => $value) :
                        if ($value != $group) {
                            echo '<optgroup label="'.$value.'">';
                            $group = $value;
                        }

                        $key_value = $key;
                        if ($key == "-apple-system,BlinkMacSystemFont,'Segoe UI',Roboto,Oxygen-Sans,Ubuntu,Cantarell,'Helvetica Neue',sans-serif") {
                            $key_value = 'system_font';
                        }
                        ?>
                        <option data-group="<?php echo esc_attr($value); ?>" value="<?php echo esc_attr($key_value); ?>" data-type="<?php echo esc_attr($value); ?>" <?php selected($font, $key_value); ?>><?php echo esc_attr($key); ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
        </div>

        <div class="form-horizontal__item">
            <label class="form-horizontal__item-label font-primary text-cht-gray-150 text-base mb-2 inline-block">Widget size:</label>
            <div class="flex items-center space-x-2">
                <?php
                    $size = get_option('cht_widget_size'.$this->widget_index);
                    $size = empty($size) ? 54 : $size;
                    $fixedSizes = ["44", "54", "70", "84", "94"];
                ?>
                <!-- custom widget size start -->
                <div class="tab-tab-select bg-cht-gray-50 rounded-md p-1 inline-flex flex-wrap items-center">
                    <label class="custom-control custom-radio" for="size-s">
                        <input 
                            type="radio" 
                            id="size-s"
                            class="custom-control-input widget-size-control" 
                            <?php checked($size, "44") ?> 
                            value="44" 
                        />
                        <span class="custom-control-label">S</span>
                    </label>

                    <label class="custom-control custom-radio" for="size-m">
                        <input 
                            type="radio" 
                            id="size-m"
                            class="custom-control-input widget-size-control" 
                            <?php checked($size, "54") ?> 
                            value="54" 
                        />
                        <span class="custom-control-label">M</span>
                    </label>
                    <label class="custom-control custom-radio" for="size-l">
                        <input 
                            type="radio" 
                            id="size-l"
                            class="custom-control-input widget-size-control" 
                            <?php checked($size, "70") ?> 
                            value="70" 
                        />
                        <span class="custom-control-label">L</span>
                    </label>
                    <label class="custom-control custom-radio" for="size-xl">
                        <input 
                            type="radio" 
                            id="size-xl"
                            class="custom-control-input widget-size-control" 
                            <?php checked($size, "84") ?> 
                            value="84" 
                        />
                        <span class="custom-control-label">XL</span>
                    </label>
                    <label class="custom-control custom-radio" for="size-xxl">
                        <input 
                            type="radio" 
                            id="size-xxl" 
                            class="custom-control-input widget-size-control" 
                            <?php checked($size, "94") ?> 
                            value="94" 
                        />
                        <span class="custom-control-label">XXL</span>
                    </label>
                    <label class="custom-control custom-radio" for="size-custom">
                        <input 
                            type="radio" 
                            id="size-custom"
                            class="custom-control-input widget-size-control" 
                            value="<?php echo esc_attr($size) ?>"
                            <?php echo in_array($size, $fixedSizes) ? '': 'checked' ?>
                        />
                        <span class="custom-control-label">Custom</span>
                    </label>
                </div>
                <!-- custom widget size ends -->
            </div>
            <div id="custom-widget-size" style="display: <?php echo in_array($size, $fixedSizes) ? 'none' : 'block' ?>" >
                <div class="position-pro max-w-[410px]">
                    <div class="text-cht-gray-150/70">
                        <label>Custom widget size:</label>
                        <input 
                            type="number" 
                            max="2000"
                            min="0"
                            class="widget-size-control"
                            value="<?php echo esc_attr($size) ?>" placeholder="<?php echo esc_attr($size) ?>">px
                    </div>
                </div>
            </div>
            <input id="custom-widget-size-input" name="cht_widget_size" type="hidden" value="<?php echo esc_attr($size) ?>"/>
        </div>

        <div class="form-horizontal__item flex-center">
            <input type="hidden" name="cht_google_analytics" value="0" >
            <label class="form-horizontal__item-label  font-primary text-cht-gray-150 text-base mb-2 inline-block"><?php esc_html_e('Google Analytics', 'chaty');?>:</label>
            <div>
                <label class="switch group inline-flex">
                    <?php
                    $checked = get_option('cht_google_analytics'.$this->widget_index);
                    $checked = ($checked === false) ? "off" : $checked;
                    ?>
                    <input type="hidden" name="cht_google_analytics" value="off">
                    <input data-gramm_editor="false" type="checkbox" name="cht_google_analytics" value="1" <?php checked($checked, 1) ?> <?php echo esc_attr($disabled) ?> >
                    <span class="chaty-slider round"></span>
                    <?php if (!$this->is_pro()) : ?>
                        <a target="_blank" class="opacity-0 group-hover:opacity-100 ml-4 bg-cht-primary px-5 py-1.5 rounded-[4px] text-white hover:text-white text-base" href="<?php echo esc_url($this->getUpgradeMenuItemUrl()); ?>">
                            <?php esc_html_e('Activate your license key', 'chaty'); ?>
                        </a>
                    <?php endif ?>
                </label>
            </div>
        </div>

        <input type="hidden" id="chaty_site_url" value="<?php echo site_url("/") ?>" >
        <?php $request_data = filter_input_array(INPUT_GET); ?>
        <?php if ((isset($request_data['page']) && $request_data['page'] == "chaty-widget-settings") || $has_no_widgets) { ?>
            <input type="hidden" name="widget" value="new-widget" >
            <input type="hidden" name="widget_nonce" value="<?php echo wp_create_nonce("chaty-widget-new-widget") ?>" >
        <?php } else if (isset($request_data['widget']) && !empty($request_data['widget']) && is_numeric($request_data['widget']) && $request_data['widget'] > 0) { ?>
            <input type="hidden" name="widget" value="<?php echo esc_attr($request_data['widget']) ?>" >
            <input type="hidden" name="widget_nonce" value="<?php echo wp_create_nonce("chaty-widget-".$request_data['widget']) ?>" >
        <?php } ?>
    </div>
</section>
