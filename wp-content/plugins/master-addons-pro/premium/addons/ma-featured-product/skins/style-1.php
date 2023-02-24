<!-- Start Featured Product Style 1 -->
<?php

use Elementor\Icons_Manager; ?>
<div class="jltma-featured-product jltma-fp-style-1">
    <div class="jltma-fp-container">
        <div class="elementor--star-style-star_unicode jltma-fp-rating">
            <div class="elementor-star-rating">
                <?php echo $this->render_stars($icon); ?>
            </div>
        </div>
        <div class="jltma-fp-title">
            <?php esc_html_e($settings['jltma_fp_title']); ?>
        </div>
        <?php if (!empty($settings['jltma_fp_price'])) { ?>
            <div class="jltma-fp-price-container">
                <span class="jltma-fp-price">
                    <?php esc_html_e($settings['jltma_fp_price']); ?>
                </span>
                <?php if (!empty($settings['jltma_fp_original_price'])) { ?>
                    <span class="jltma-fp-original-price">
                        <?php esc_html_e($settings['jltma_fp_original_price']); ?>
                    </span>
                <?php } ?>
            </div>
        <?php } ?>

        <img class="jltma-fp-image" src="<?php echo esc_url($settings['jltma_fp_image']['url']); ?>" />

        <?php if ($settings['jltma_fp_content_type'] === 'desc') { ?>
            <div class="jltma-fp-content">
                <?php esc_html_e($settings['jltma_fp_description']); ?>
            </div>
        <?php } else { ?>
            <ul class="jltma-fp-lists">
                <?php foreach ($settings['jltma_fp_product_lists'] as $lists => $list) { ?>
                    <li class="jltma-fp-list">
                        <span class="jltma-fp-list-icon">
                            <?php Icons_Manager::render_icon($settings['jltma_fp_list_icon'], ['aria-hidden' => 'true']); ?>
                        </span>
                        <span class="jltma-fp-content">
                            <?php esc_html_e($list['jltma_fp_product_list']); ?>
                        </span>
                    </li>
                <?php } ?>
            </ul><?php
                } ?>
    </div>
    <div class="jltma-fp-button-container">
        <a class="jltma-fp-button" href="<?php echo esc_url($button_link); ?>" <?php esc_attr_e($target);
                                                                                esc_attr_e($rel); ?>>
            <?php esc_html_e($settings['jltma_fp_button']); ?>
        </a>
    </div>
    <?php echo $this->render_ribbons(); ?>
</div>
<!-- End Featured Product Style 1 -->
