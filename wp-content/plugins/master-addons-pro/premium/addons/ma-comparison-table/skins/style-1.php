<div class="jltma-comparison-table jltma-cmpt-style-1">
    <ul><?php
        for ($i = 1; $i <= $settings['jltma_cmpt_product_count']; $i++) { ?>
            <li class="jltma-cmpt-product-heading jltma-cmpt-product-<?php esc_attr_e($i); ?>"><?php esc_html_e($settings['jltma_cmpt_product_title_' . $i]); ?></li>
        <?php } ?>
    </ul>
    <table>
        <tbody>
            <tr class="jltma-cmpt-header">
                <td class="jltma-cmpt-features-heading" rowspan="2"><?php esc_html_e($settings['jltma_cmpt_feature_heading']); ?></td>
                <?php for ($i = 1; $i <= $settings['jltma_cmpt_product_count']; $i++) { ?>
                    <td class="jltma-cmpt-product-heading jltma-cmpt-product-<?php esc_attr_e($i); ?>">
                        <?php if (!empty($settings['jltma_cmpt_product_title_' . $i])) { ?>
                            <div class="jltma-cmpt-product-title"><?php esc_html_e($settings['jltma_cmpt_product_title_' . $i]); ?></div>
                        <?php } ?>
                        <?php if (!empty($settings['jltma_cmpt_product_image_' . $i]['url'])) { ?>
                            <img class="jltma-cmpt-product-img" src="<?php echo esc_url($settings['jltma_cmpt_product_image_' . $i]['url']); ?>" />
                        <?php } ?>
                    </td>
                <?php } ?>
            </tr>
            <tr>
                <td class="jltma-cmpt-hide"></td>
                <?php for ($i = 1; $i <= $settings['jltma_cmpt_product_count']; $i++) { ?>
                    <td class="jltma-cmpt-feature jltma-cmpt-product-price jltma-cmpt-product-<?php esc_attr_e($i); ?>"><?php esc_html_e($settings['jltma_cmpt_product_price_' . $i]); ?></td>
                <?php } ?>
            </tr>
            <?php
            $count = count($settings['jltma_cmpt_feature_list']);
            for ($x = 1; $x <= $count; $x++) { ?>
                <tr>
                    <td class="jltma-cmpt-feature-heading"><?php esc_html_e($settings['jltma_cmpt_feature_list'][$x - 1]['jltma_cmpt_feature']); ?></td>
                    <?php for ($j = 1; $j <= $settings['jltma_cmpt_product_count']; $j++) { ?>
                        <td class="jltma-cmpt-feature jltma-cmpt-product-<?php esc_attr_e($j); ?>">
                            <?php
                            if (count($settings['jltma_cmpt_feature_list_' . $j]) >= $x) {
                                if ($settings['jltma_cmpt_feature_list_' . $j][$x - 1]['jltma_cmpt_content_type'] !== 'text' && $settings['jltma_cmpt_feature_list_' . $j][$x - 1]['jltma_cmpt_content_type'] !== 'icon') {
                                    if ($settings['jltma_cmpt_feature_list_' . $j][$x - 1]['jltma_cmpt_content_type'] === 'fa fa-close') { ?>
                                        <i class="jltma-cmpt-mark-no <?php esc_attr_e($settings['jltma_cmpt_feature_list_' . $j][$x - 1]['jltma_cmpt_content_type']); ?>"></i>
                                    <?php
                                    } else { ?>
                                        <i class="jltma-cmpt-mark-yes <?php esc_attr_e($settings['jltma_cmpt_feature_list_' . $j][$x - 1]['jltma_cmpt_content_type']); ?>"></i>
                                    <?php
                                    }
                                } elseif ($settings['jltma_cmpt_feature_list_' . $j][$x - 1]['jltma_cmpt_content_type'] === 'icon') {
                                    ?>
                                    <i class="<?php esc_attr_e($settings['jltma_cmpt_feature_list_' . $j][$x - 1]['jltma_cmpt_feature_icon']['value']); ?>"></i>
                            <?php
                                } else {
                                    esc_html_e($settings['jltma_cmpt_feature_list_' . $j][$x - 1]['jltma_cmpt_feature_text']);
                                }
                            } else {
                                echo '';
                            } ?>
                        </td>
                    <?php } ?>
                </tr>
            <?php } ?>
            <tr>
                <td class="jltma-cmpt-feature-heading jltma-cmpt-feature-heading-button"><?php esc_html_e($settings['jltma_cmpt_feature_heading_button']); ?></td>
                <?php
                for ($j = 1; $j <= $settings['jltma_cmpt_product_count']; $j++) {
                    if (!empty($settings['jltma_cmpt_product_link_' . $j]['url'])) {
                        $this->add_link_attributes('button_' . $j . '-link-attributes', $settings['jltma_cmpt_product_link_' . $j]);
                    }
                    $this->add_render_attribute('button_' . $j . '-link-attributes', 'class', 'jltma-cmpt-product-btn'); ?>
                    <td class="jltma-cmpt-feature-button jltma-cmpt-product-<?php esc_attr_e($j); ?>">
                        <?php if ($settings['jltma_cmpt_button_text_' . $j] !== '') { ?>
                            <a <?php echo $this->get_render_attribute_string('button_' . $j . '-link-attributes'); ?>>
                                <?php esc_html_e($settings['jltma_cmpt_button_text_' . $j]); ?>
                            </a>
                        <?php } ?>
                    </td>
                <?php } ?>
            </tr>
        </tbody>
    </table>
</div>
